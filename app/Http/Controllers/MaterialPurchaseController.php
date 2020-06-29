<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Material;
use App\Purchase;
use App\Supplier;
use App\Product;
use App\StockLog;

class MaterialPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $purchases = Purchase::paginate(10);

        return view('bowner.inventories.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $materials = Material::all();

        $suppliers = Supplier::pluck('name', 'id')->all();
        return view('bowner.inventories.purchase.create', compact('materials', 'suppliers'));
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
        $purchase = new Purchase();
        $purchase->material_id = $request->material_id;
        $purchase->quantity = $request->quantity;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->save();

        Session::flash('created_message', 'The material has been submitted for purchasing');

        return redirect('/bowner/inventories/material/purchase');
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
        $purchase = Purchase::findOrFail($id);
        $materials = Material::all();
        $suppliers = Supplier::pluck('name', 'id')->all();

        return view('bowner.inventories.purchase.edit', compact('purchase', 'materials', 'suppliers'));
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
        $purchase = Purchase::findOrFail($id);
        $purchase->material_id = $request->material_id;
        $purchase->quantity = $request->quantity;
        $purchase->supplier_id = $request->supplier_id;
        
        $purchase->save();

        Session::flash('updated_message', 'The purchase has been updated!');

        return redirect('/bowner/inventories/material/purchase');
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
        $purchase = Purchase::findOrFail($id);

        $purchase->delete();

        $stock_log = StockLog::where('purchase_id' , '=', $id)->first();
        
        $product = Product::findOrFail($stock_log->product_id);

        // if product or material 

        $product->quantity = $product->quantity - $stock_log->quantity;
        
        $stock_log->deleted = true;
        $product->save();
        $stock_log->save();

        Session::flash('deleted_message', 'The purchase has been deleted');

        return redirect('/bowner/inventories/');
    }


    
   
}
