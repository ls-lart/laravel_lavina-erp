@extends('layouts.bowner')
@section('content')
@include('includes.message')
<h4>Inventory</h4>
<br>
<!-- Start .nav nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
   <li role="presenstation" class="active"><a href="#product" aria-controls="product" role="tab" data-toggle="tab"><strong>Finished Products</strong></a></li>
   <li role="presenstation"><a href="#material" aria-controls="material" role="tab" data-toggle="tab"><strong>Raw Material</strong></a></li>
   <li role="presenstation"><a href="#purchasing" aria-controls="material" role="tab" data-toggle="tab"><strong>Purchasing</strong> 
   	@if(count($purchases) > 0)
   	<span class="btn btn-danger btn-xs" style="margin-left: 1rem;" >{{count($purchases)}}</span>
   	@endif
   	 </a></li>
   <li role="presenstation"><a href="#pending" aria-controls="material" role="tab" data-toggle="tab"><strong>Pending Orders Delivery</strong>

   	@if(count($orders) > 0)
   	<span class="btn btn-danger btn-xs" style="margin-left: 1rem;" >{{count($orders)}}</span>
   	@endif

    </a>
	</li>
   <!--<li role="presenstation"><a href="#receiving" aria-controls="material" role="tab" data-toggle="tab"><strong>Pending Receiving </strong></a></li>-->
   <li role="presenstation"><a href="#logs" aria-controls="material" role="tab" data-toggle="tab"><strong>Stock Log </strong></a></li>
   <li  style="float: right;" onClick="window.print()">
      <a href="" class="btn btn btn-success btn-xs" style="padding: 5px 10px;"><i class="fa fa-cart-plus"></i> Stock Entry</a>
   </li>
    <li  style="float: right;margin-right: 10px;" >
      <a href="/bowner/inventories/material/create" class="btn btn btn-default btn-xs" style="padding: 5px 10px;"><i class="glyphicon glyphicon-barcode"></i> Create Material</a>
   </li>
   <li  style="float: right;margin-right: 10px;" >
      <a href="/bowner/inventories/product/create" class="btn btn btn-default btn-xs" style="padding: 5px 10px;"><i class="fa fa-shopping-bag"></i> Create Product</a>
   </li>
</ul>
<!-- End .nav nav-tabs -->
<div class="tab-content">
   <!-- View Products -->
   <div role="tabpanel1" class="tab-pane fade in active" id="product">
      <br>
      <div class="table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <!--<th>Id</th>-->
                  <th>Code</th>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Cost</th>
                  <th>UOM</th>
                  <th>Available Qty</th>
                  <th>Warehouse</th>
                  <!--<th>VAT (%)</th>-->
                  <th>Last Update</th>
                  <th style="width: 250px;">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($products as $product)
               <tr>
                  <!--<td>{{$product->id}}</td>-->
                  <td>{{$product->code}}</td>
                  <td style="background-color: white;text-align: center;padding: 0px;"><img style="height: 50px;"  src="{{$product->image}}"></td>
                  <td><b>{{$product->name}}</b></td>
                  <td>{{$product->cost}}</td>
                  <td>{{$product->unit->name}}</td>
                  <td>{{$product->quantity}}</td>
                  <td>{{$product->warehouse->name}}</td>
                  <!--<td>{{$product->vat_rate}}</td>-->
                  <td>{{date("d-m-Y", strtotime($product->updated_at))}}</td>
                  <td>
                     <a class="btn btn-xs btn-primary" href="{{route('bowner.inventories.product.edit', $product->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
                     <a class="btn btn-xs btn-default" href="{{route('bowner.inventories.product.edit', $product->id)}}"><span class="glyphicon glyphicon-eye-open"></span> Log</a>
                     @if ($product->make == 0)
                     <a class="btn btn-xs btn-success" href="{{route('bowner.product.purchase.request', $product->id)}}">Request Purchase Item</a>
                     @else
                     <a class="btn btn-xs btn-warning" href="{{route('bowner.inventories.product.edit', $product->id)}}">Request Make Item</a>
                     @endif	
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <!-- /.table-responsive -->
   </div>
   <!-- /.tab-pane -->
   <!-- / View Product -->
   <!-- View Material -->
   <div role="tabpanel2" class="tab-pane fade" id="material">
      <br>
      <div class="table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th>Id</th>
                  <th>Actions</th>
                  <th>Product</th>
                  <th>Cost</th>
                  <th>UOM</th>
                  <th>Available Qty</th>
                  <th>VAT (%)</th>
                  <th>Date</th>
               </tr>
            </thead>
            <tbody>
               @foreach($materials as $material)
               <tr>
                  <td>{{$material->id}}</td>
                  <td><a class="btn btn-xs btn-primary" href="{{route('bowner.inventories.material.edit', $material->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                  <td>{{$material->name}}</td>
                  <td>{{$material->cost}}</td>
                  <td>{{$material->unit->name}}</td>
                  <td>{{$material->quantity}}</td>
                  <td>{{$material->vat_rate}}</td>
                  <td>{{date("d-m-Y", strtotime($material->updated_at))}}</td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <!-- /.table-responsive -->
      <!-- Purchase button -->
      <div class="container">
         <a class="btn btn-info" href="{{route('bowner.purchase.create')}}">Purchase Material</a>
      </div>
   </div>
   <!-- /.tab-pane -->
   <!-- / View Material -->
   <div  role="tabpanel3" class="tab-pane fade" id="purchasing">
      <br>
      <div class="table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th>Id</th>
                 
                  <th>Product</th>
                  <th>Cost</th>
                  <th>UOM</th>
                  <th>Quantity</th>
                  <th>Supplier</th>
                  <th>Total Cost</th>
                  <th>Status</th>
                  <th>Date</th>
                   <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($purchases as $purchase)
               <tr>
                  <td>{{$purchase->id}}</td>
                  
                  @if ($purchase->product)
                  <td>{{$purchase->product->name}}</td>
                  <td>{{$purchase->price}}</td>
                  <td>{{$purchase->product->unit->name}}</td>
                  <td>{{$purchase->quantity}}</td>
                  <td>{{$purchase->supplier->name}}</td>
                  <td>{{number_format($purchase->quantity * $purchase->price,2,'.','')}}</td>
                  @else
                  <td>{{$purchase->material->name}}</td>
                  <td>{{$purchase->material->cost}}</td>
                  <td>{{$purchase->material->unit->name}}</td>
                  <td>{{$purchase->quantity}}</td>
                  <td>{{$purchase->supplier->name}}</td>
                  <td>{{number_format($purchase->quantity * $purchase->material->cost,2,'.','')}}</td>
                  @endif
                  @if ($purchase->status == 1 )
                  <td class="success">Completed <span class="glyphicon glyphicon-ok text-success"></span></td>
                  @elseif ($purchase->status == 2 )
                  <td class="warning">Pending Receiving 
                     <span class="glyphicon glyphicon-info-sign text-warning"></span>
                     <span style="float: right;">{{$purchase->actual_quantity}}</span>
                  </td>
                  @else 
                  <td class="info">Pending</td>
                  @endif	
                  <td>{{date("d-m-Y", strtotime($purchase->updated_at))}}</td>
                  <td>
                     <div style="display: inline-flex;">
                        <!-- Edit button -->
                        @if ($purchase->status == 0)
                        <a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="left" title="edit purchase" href="{{route('bowner.purchase.edit', $purchase->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
                        @else 
                        <a href="#" class="btn btn-xs btn-primary disabled"><span class="glyphicon glyphicon-ok"></span></a>
                        @endif
                        <!-- Delete button -->
                        <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="delete purchase" href="{{route('bowner.purchase.destroy', $purchase->id)}}"><span class="glyphicon glyphicon-remove"></span></a>
                        @if ($purchase->status == 0)
                        <!-- Complete button -->
                        <a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="complete purchase" href="{{route('bowner.purchase.complete', $purchase->id)}}"><span class="glyphicon glyphicon-ok"></span></a>
                        @else
                        <!-- Undo button -->
                        <!--
                           <a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="undo completing purchase" href="{{route('bowner.purchase.complete', $purchase->id)}}"><span class="glyphicon glyphicon-repeat"></span></a>
                           -->
                        <!-- Complete button -->
                        <a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="Confirm / batch receiving" href="{{route('bowner.purchase.receiving.confirm', $purchase->id)}}"><span class="glyphicon glyphicon-ok"></span></a>
                        @endif
                     </div>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <!-- /.table-responsive -->
      <!-- / View Purchasing Material -->
   </div>

   <div  role="tabpanel4" class="tab-pane fade" id="pending">
      <br>
      <div class="table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <!--<th>Id</th>-->
                 
                  <th>Image</th>
                  <th>Product</th>
                  <th>UOM</th>
                  <th>Quantity</th>
                  <th>Remainder Quantity</th>
                  <th>Customer</th>
                  <th>Order ID</th>
                  <th>Delivery Status</th>
                  <th>Date</th>
                   <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($orders as $order)
              
               @php ($i = 0)

               @foreach($order->orderdetail as $detail)
               
               

                  <td style="background-color: white;text-align: center;padding: 0px;"><img style="height: 50px;"  src="{{$detail->product->image}}"></td>
                  <td><b>{{$detail->product->name}}</b></td>
                  <td>{{$detail->product->unit->name}}</td>
                  <td>{{$detail->quantity}}</td>
                  <td>{{$detail->remainder_quantity}}</td>
             
                  
                 

                  @if($i == 0 )
                  <td>{{$detail->order->customer->name}}</td>
                  <td>{{$detail->order->id}}</td>
                  @else
                  <td></td>
                  <td></td>
				  @endif

                  @if($detail->delivered == true)
                  	<td class="success">Completed</td>
                  @else
                  	@if($detail->product->quantity > $detail->quantity)
                  		<td class="warning">Pending</td>
                  	@else
                  		<td class="danger">Not Enough Stock</td>	
                  	@endif 
                  		
                  @endif




                  	
                  <td>{{date("d-m-Y", strtotime($detail->updated_at))}}</td>
                   <td width="280px;">
                    @if($detail->order->delivered)
                    	@if($i == 0 )
                    		<a class=" btn btn-primary btn-xs" href="{{ route('orders.show', $order->id) }}" target="_blank"><span class="glyphicon glyphicon-print" data-toggle="tooltip" data-placement="right" title="print"></span> Print Delivery Slip</a>
                    	@endif	
                    @else
                    	 @if($i == 0 )
                    	<!--<a class="btn btn-xs btn-default" style="float: left;" href="{{ route('orders.delivery', $detail->id) }}"><span class="glyphicon glyphicon-send" data-toggle="tooltip" data-placement="right" title="Deliver Order"></span> Full Delivery</a>-->

                    	<a class="btn btn-xs btn-warning " style="float: left;" href="{{ route('orders.partial.delivery', $detail->order_id) }}"><span class="glyphicon glyphicon-send" data-toggle="tooltip" data-placement="right" title="Deliver Order"></span> Delivery</a>   
                    	@endif                 
                    @endif	
                  </td>

               </tr>

               @if( count($order->orderdetail)  == $i + 1 )
               <tr><td></td></tr>
               @endif

             	@php ($i++)
               @endforeach

               @endforeach
            </tbody>
         </table>
      </div>
      <!-- /.table-responsive -->
   </div>

   <div  role="tabpanel5" class="tab-pane fade" id="logs">
      <br>
      <div class="table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th>Id</th>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>UOM</th>
                  <th>Supplier / Customer</th>
                  <th>Type</th>
                  <th>Purchase/Dispatch ID</th>
                  <th>Date</th>
                  <th>Note</th>
               </tr>
            </thead>
            <tbody>
               @foreach($logs as $log)
               @php
               if (!$log->deleted) {
               $color = "transperant";
               }else{
               $color = "#ff000024";
               }
               @endphp
               <tr style="background-color:{{$color}}">
                  <td>{{$log->id}}</td>
                  <td style="background-color: white;text-align: center;padding: 0px;"><img style="height: 50px;"  src="{{$log->product->image}}"></td>
                  <td>{{$log->product->name}}</td>
                  <td>{{$log->quantity}}</td>
                  <td>{{$log->product->unit->name}}</td>
                  @if($log->supplier)
                  <td>{{$log->supplier->name}}</td>
                  @elseif($log->customer)
                  <td>{{$log->customer->name}}</td>
                  @else
                  <td></td>
                  @endif
                  @if($log->type == 'Receive')
                  <td class="success">{{$log->type}}</td>
                  @elseif($log->type == 'Dispatch')
                  <td class="warning">{{$log->type}}</td>
                  @elseif($log->type == 'Receive - Manfacturing')
                  <td class="info">{{$log->type}}</td>
                  @elseif($log->type == 'Return')
                  <td class="danger">{{$log->type}}</td>
                  @endif	
                  <td>{{$log->purchase_id}}</td>
                
                  <td>{{$log->created_at}}</td>
                    <td>{{$log->notes}}</td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
    
      <!-- /.table-responsive -->
      <!-- / View Purchasing Material -->
   </div>

</div>
<!-- /.tab-content -->
@stop
@section('scripts')
<script></script>
@stop