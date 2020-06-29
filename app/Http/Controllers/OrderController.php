<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


use Carbon\Carbon;
use Validator;

use App\OrderDetail;
use App\Customer;
use App\Product;
use App\Order;
use App\Accounting;
use App\StockLog;
use App\Warehouses;

use Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function __construct()
    {
        $this->middleware('bowner_employee');
    }
    */

    public function index()
    {
        $products = Product::pluck('name', 'id')->all();
        $customers = Customer::all();

        $orders = Order::orderBy('created_at', 'asc')->paginate(10);

        return view('orders.index', compact('orders', 'products', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();

        $order->customer_id = $request['customer'];
        $order->user_id = Auth::user()->id;
        $order->vat = $request['vat'];
        $order->note = $request['note'];
        $order->billing_type = $request->billing_type;
        //$order->delivery_at = date("Y-m-d", strtotime($request['delivery_at'] . "+1 day"));
        $order->delivery_at = date("Y-m-d", strtotime($request['delivery_at'] ));
        
        $order->save();

        // Filter empty array elements
        $products = array_filter($request->products);
        $i = 0;
        $total_cost_order = 0;
        foreach ($products as $product) {
            $orderDetail = new OrderDetail;
            $orderDetail->product_id = $product;
            $quantity = $orderDetail->quantity = $orderDetail->remainder_quantity = $request->quantity[$i];
            $cost = $orderDetail->total_cost = $request->price[$i];
            $i++;
            
            //Product::where('id', $product)->value('cost');
            $vat_rate = Product::where('id', $product)->value('vat_rate');
            if ($order->vat) {
                $total_cost = ($cost * $quantity) + ( $cost * $quantity * $vat_rate / 100 );
            } else {
                $total_cost = $cost * $quantity;
              }
            $total_cost_order += $total_cost;
            $orderDetail->total_cost = $total_cost;
            $orderDetail->order_id = $order->id;
            $orderDetail->save();
        }

        $order->total_cost = $total_cost_order;

        $order->save();

        Session::flash('created_message', 'The order has been created!');



        return redirect('/orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Order::findOrFail($id);

        return view('orders.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $products = Product::pluck('name', 'id')->all();
        $customers = Customer::all();
        $details = OrderDetail::where('order_id', $id)->get();
        $delivery_at = date("d-m-Y", strtotime($order->delivery_at));

        return view('orders.edit', compact('order', 'details', 'products', 'customers', 'delivery_at'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->customer_id = $request['customer'];
        $order->user_id = Auth::user()->id;
        $order->vat = $request['vat'];
        $order->note = $request['note'];
        $order->delivery_at = date("Y-m-d", strtotime($request['delivery_at'] ));

        // Filter empty array elements
        $products = array_filter($request->products);
        $i = 0;
        $total_cost_order = 0;
        $order->orderdetail()->delete();
        foreach ($products as $product) {
            $orderDetail = new OrderDetail;
            $orderDetail->product_id = $product;
            $quantity = $orderDetail->quantity = $orderDetail->remainder_quantity = $request->quantity[$i];
            $cost = $orderDetail->total_cost = $request->price[$i];

            $i++;
           //$cost = Product::where('id', $product)->value('cost');
            $vat_rate = Product::where('id', $product)->value('vat_rate');
            if ($order->vat) {
                $total_cost = ($cost * $quantity) + ( $cost * $quantity * $vat_rate / 100 );
            } else {
                $total_cost = $cost * $quantity;
              }
            $total_cost_order += $total_cost;
            $orderDetail->total_cost = $total_cost;
            $orderDetail->order_id = $order->id;
            $orderDetail->save();
        }

        $order->total_cost = $total_cost_order;
        
        $order->save();


        $accouting = Accounting::where('transaction_id','=',$order->id)->first();
        //$accouting->transaction_id = $id;
        //$accouting->accounting_book = 'Receivable';
        //$accouting->created_at = strtotime("now");
        $accouting->updated_at = strtotime("now");

        //$accouting->product_id = $product->id;
        //$accouting->quantity =  $input->actual_quanity;
        //$accouting->item_cost = $purchase->price;
        //$accouting->customer_id = $order->customer_id;
        $accouting->amount = $order->total_cost;
        $accouting->save();


        //$accouting->invoice_id = 'INV-'.$accouting->id;
        //$accouting->save();

        Session::flash('updated_message', 'The order has been updated!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $order = Order::findOrFail($id);
        $order->delete();

        // delete the accounting record for this order 

        $accouting = Accounting::where('transaction_id','=',$order->id);
        $accouting->delete();

        Session::flash('deleted_message', 'The order has been deleted');

        return redirect('/orders');
    }

    public function complete($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 1;

        // For Undo feature
        /*
        $order->status = !$order->status;
        if ($order->status == 1) {
            $product_qty = $order->product->quantity - $order->quantity;
        } else {
            $product_qty = $order->product->quantity + $order->quantity;
        }
        */

        $order->save();

        Session::flash('updated_message', 'The order has been completed');

        return redirect('/orders');
    }

    public function submit($id)
    {
        $order = Order::findOrFail($id);
        $order->submit = 1;
        $order->save();

        // submitting an order makes it accouting recivable 

        $accouting = new Accounting();
        $accouting->transaction_id = $id;
        $accouting->accounting_book = 'Receivable';
        $accouting->created_at = strtotime("now");
        $accouting->updated_at = strtotime("now");

        //$accouting->product_id = $product->id;
        //$accouting->quantity =  $input->actual_quanity;
        //$accouting->item_cost = $purchase->price;
        $accouting->customer_id = $order->customer_id;
        $accouting->amount = $order->total_cost;
        $accouting->save();


        $accouting->invoice_id = 'INV-'.$accouting->id;
        $accouting->save();


        return redirect('/orders');
    } 

    public function ReadyToDeliver($id)
    {
         $order = Order::findOrFail($id);
         $order->deliver = 1;
         $order->save();

         return redirect('/orders');
    }
    public function deliver($id)
    {
        $detail = orderDetail::findOrFail($id);
        $detail->delivered = 1;
        $detail->delivered_at = strtotime("now");

        $detail->save();

        $order = Order::findOrFail($detail->order_id);
        //$order->deliver = 1;


        $details = $order->orderdetail()->get();
        $done = false;
        foreach ($details as $detail) {
            if($detail->delivered)
                $done = true;
            else
                $done = false;
        }
        if($done){
            $order->delivered = 1;
            $order->delivered_at = strtotime("now");

            if($order->billded)
                $order->status = 1;

            $order->save();
        }

        $product = Product::findOrFail($detail->product_id);
            // Update product inventory quantity
        $product->quantity = $product->quantity - $detail->quantity;  
        $product->save(); 


        // 

        // stock log entry 

        $log = new StockLog();
        $log->product_id = $product->id;
        $log->quantity = $detail->quantity;
        
        $log->type = "Dispatch";
        $log->purchase_id = $detail->order_id;
        
        //if($input->updated_at)

        $log->created_at = strtotime("now");
        $log->customer_id = $order->customer_id; 
        $log->save();



        //}

        Session::flash('updated_message', 'The order delivery has been submitted');

        return redirect('/bowner/inventories');
    } 

    public function partialDeliver($id){

        $order = Order::findOrFail($id);
        // go to the page to confirm delivery
        $details = $order->orderdetail()->get();
        $warehouses = Warehouses::pluck('name', 'id')->all();

        return view('orders.delivery.create', compact('order', 'details','warehouses'));

    }

    public function partialDelivery(Request $request, $id){

        $order = Order::findOrFail($id);
        $done = false;
        $i = 0;
        foreach ($order->orderdetail()->get() as $detail) {

            if(!$detail->delivered){
            if($request->quantity[$i] ){

                $log = new StockLog();
                $log->product_id = $detail->product->id;
                $log->quantity = $request->quantity[$i];
        
                $log->type = "Dispatch";
                $log->purchase_id = $detail->order_id;
                $log->warehouse_id = $request->warehouses[$i];
                $log->created_at = strtotime("now");
                $log->customer_id = $order->customer_id; 
                $log->notes = $request['note'];
                $log->save();

                 $product = Product::findOrFail($detail->product_id);
                 // Update product inventory quantity
                 $product->quantity = $product->quantity -$request->quantity[$i];  
                 $product->save(); 

                 $detail->remainder_quantity = $detail->remainder_quantity - $request->quantity[$i];
                 $detail->save();
            }


            $logs = StockLog::where('purchase_id','=',$detail->order_id)
                ->where('product_id','=',$detail->product->id)
                ->get();
            $quantity = 0;
            foreach ($logs as $l) {
                 $quantity  = $quantity + $l->quantity ; 
                }        

            if($detail->quantity <= $quantity){
                $detail->delivered = 1;
                $detail->delivered_at = strtotime("now");
                $detail->save();
                $done = true ;
            }else{
                $done = false;
            }

            $i++;

        }
 
        }

         if($done){
            $order->delivered = 1;
            $order->delivered_at = strtotime("now");

            if($order->billded)
                $order->status = 1;

            $order->save();
        }


       Session::flash('updated_message', 'The partial delivery has been submitted');

        return redirect('/bowner/inventories');
        
    }
}
