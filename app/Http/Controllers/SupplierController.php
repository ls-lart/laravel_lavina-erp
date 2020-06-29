<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Supplier;
use App\Product;
use App\Material;
use App\Purchase;
use App\StockLog;
use App\Accounting;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $suppliers = Supplier::all();

        return view('bowner.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('bowner.supplier.create');
    }


    public function requestProductPurchase($id){

        $suppliers = Supplier::pluck('name', 'id')->all();
        $product = Product::find($id);
        $materials = Material::all();

        return view('bowner.inventories.purchase.create', compact('suppliers','product','materials'));
    }


    public function storeProductPurchase(Request $request){

        $product = new Purchase();
        $product->product_id = $request->product_id;
        $product->supplier_id = $request->supplier_id;
        $product->quantity = $request->quantity;
        $product->is_product = 1;
        $product->approved = false;
        $product->created_at = strtotime($request->created_at);
        $product->price = $request->price;

        $product->save();

        Session::flash('created_message', 'Purchase has been submitted');

        return redirect('bowner/inventories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $supplier = new Supplier();

        $this->validate($request, [
            'phone' => 'required|digits_between:9,11|unique:suppliers',
        ]);

        $supplier->name = $request->name;
        $supplier->address1 = $request->address1;
        $supplier->address2 = $request->address2;
        $supplier->phone = $request->phone;
        $supplier->description = $request->description;

        $supplier->save();

        Session::flash('created_message', 'The new supplier has been added');

        return redirect('/bowner/supplier');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $supplier = Supplier::findOrFail($id);

        return view('bowner.supplier.edit', compact('supplier'));
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
        $supplier = Supplier::findOrFail($id);

        $this->validate($request, [
            'phone' => 'required|digits_between:9,11|unique:suppliers,phone,'.$supplier->id,
        ]);

        $supplier->name = $request->name;
        $supplier->address1 = $request->address1;
        $supplier->address2 = $request->address2;
        $supplier->phone = $request->phone;
        $supplier->description = $request->description;

        $supplier->save();

        Session::flash('update_message', 'The new supplier has been updated');

        return redirect('/bowner/supplier');
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
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        Session::flash('deleted_message', 'The supplier has been deleted');

        return redirect('/bowner/supplier');
    }

     public function complete($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->status = !$purchase->status;

        if($purchase->product == true ){
            if ($purchase->status == 1) {
                $material_qty = $purchase->product->quantity + $purchase->quantity;
             } else {
                $material_qty = $purchase->product->quantity - $purchase->quantity;
            } 

            //$material = Product::findOrFail($purchase->product_id);
            //$material->quantity = $material->qunatity;

            $purchase->status = 2;
            $purchase->save();
            //$product->save();

            // save the accounting information for the supplier and the general ledger 
            // make it pending recieving 

        }else{
            if ($purchase->status == 1) {
                $material_qty = $purchase->material->quantity + $purchase->quantity;
             } else {
                $material_qty = $purchase->material->quantity - $purchase->quantity;
            }
            $material = Material::findOrFail($purchase->material_id);
            $material->quantity = $material->qty;

            $purchase->save();
            $material->save();

            
        }    
        Session::flash('updated_message', 'The purchase and inventory have been updated');

        return redirect('/bowner/inventories');
    }

    public function recievingConfirmation($id){

        $purchase = Purchase::findOrFail($id);
     
        return view('bowner.inventories.purchase.confirm', compact('purchase'));

    }
    public function recievingComplete(Request $request , $id){
        //
        $purchase = Purchase::findOrFail($id);
        $input = $request;

        $product = Product::findOrFail($purchase->product_id);
        $product->quantity = $product->quantity + $input->actual_quanity;

        $product->save();

        $purchase->updated_at = strtotime($input->updated_at);
        //$purchase->status = 1;
        $purchase->actual_quantity = $purchase->actual_quantity + $input->actual_quanity;
        $purchase->save();
       
        if($purchase->quantity >= $purchase->actual_quantity){
            $purchase->status = 1;
            $purchase->save();
        }

        $log = new StockLog();
        $log->product_id = $product->id;
        $log->quantity = $input->actual_quanity;
        $log->notes = $input->notes;
        $log->type = "Receive";
        $log->purchase_id = $id;
        
        if($input->updated_at)
            $log->created_at = strtotime($input->updated_at);

        $log->supplier_id = $purchase->supplier_id; 
        $log->save();




        // save the accouting info 

        // the supplier 
        // the cost 
        // quanitiy 
        // product / matierial 
        // amount = cost * qunainty 
        // created_at date 
        // accouting book (main) -- accounting payable 
        // billed (yes or no) 
        // transaction_id (purchase request id )         

        $accouting = new Accounting();
        $accouting->transaction_id = $id;
        $accouting->accounting_book = 'Payable';
        $accouting->created_at = strtotime("now");
        $accouting->updated_at = strtotime("now");
        $accouting->product_id = $product->id;
        $accouting->quantity =  $input->actual_quanity;
        $accouting->item_cost = $purchase->price;
        $accouting->supplier_id = $purchase->supplier_id;
        $accouting->save();


        $accouting->invoice_id = 'PAY-'.$accouting->id;
        $accouting->save();

        return redirect('/bowner/inventories/');

    }
}
