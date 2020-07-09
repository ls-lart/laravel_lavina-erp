<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Material;
use App\OrderDetail;
use App\Product;
use App\Supplier;
use App\Purchase;
use App\Warehouses;
use App\Unit;
use App\StockLog;
use App\Order;
use Log;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products   = Product::all();
        $materials  = Material::all();
        $purchases  = Purchase::where('status','=',0)->get();

        // select orders first 

        $orders     = Order::where('submit','=',1)->where('deliver','=',1)->where('status','=',0)->get();
        $logs = StockLog::orderBy('created_at','DESC')->get();
        
        // 'purchases'
        return view('bowner.inventories.index', compact('products', 'materials','purchases','logs','orders'));
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
        //
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
    public function createProduct()
    {
        //
        $warehouses = Warehouses::all();
         $units = Unit::all();
        $suppliers = Supplier::pluck('name', 'id')->all();
        return view('bowner.inventories.product.create', compact('warehouses', 'suppliers','units'));
    }

    public function createMaterial()
    {
        //
        $warehouses = Warehouses::all();
        $units = Unit::all();
        $suppliers = Supplier::pluck('name', 'id')->all();
        return view('bowner.inventories.material.create', compact('warehouses', 'suppliers','units'));
    }
    
    public function storeProduct(Request $request)
    {
        //
        $product = new Product();
        $product->name = $request->name;
        $product->code = $request->code;
        $product->warehouse_id = $request->warehouse_id;
        $product->unit_id = $request->unit_id;
        $product->image = $request->image;
        $product->make = $request->make;
        $product->type = $request->type;
        $product->color = $request->color;
        $product->save();

        Session::flash('created_message', 'The product has been submitted');

        return redirect('bowner/inventories');
    }

    public function storeMaterial(Request $request){
         //
        $product = new Material();
        $product->name = $request->name;
        $product->code = $request->code;
        $product->warehouse_id = $request->warehouse_id;
        $product->unit_id = $request->unit_id;
        $product->make = $request->make;
        $product->save();

        Session::flash('created_message', 'The Material has been submitted');

        return redirect('bowner/inventories');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id)
    {
        //
        $product = Product::findOrFail($id);
        return view('bowner.inventories.product.edit', compact('product'));
    }

    public function editMaterial($id)
    {
        //
        $material = Material::findOrFail($id);
        return view('bowner.inventories.material.edit', compact('material'));
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

    }

    public function updateProduct(Request $request, $id)
    {
        //
        $product = Product::findOrFail($id);
        $p_qty = $product->quantity = $request->quantity;

        // If 'hod' so no 'extra'
        if ($request->extra != null) {
            $extra = $product->extra = $request->extra;

            if ($extra >= $product->unit->equi) {
                $product->quantity = $p_qty + floor($extra / $product->unit->equi);
                $product->extra = $extra % $product->unit->equi;
            }
        }

        $product->save();

        Session::flash('updated_message', 'The product available quantity has been updated');

        return redirect('/bowner/inventories');
    }

    public function updateMaterial(Request $request, $id)
    {
        //
        $material = Material::findOrFail($id);
        $material->quantity = $request->quantity;
        $material->save();

        Session::flash('updated_message', 'The material available quantity has been updated');

        return redirect('/bowner/inventories');
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
    }
}
