@extends('layouts.bowner')

@section('content')

	@include('includes.message')

	<h4>Orders</h4>
	<!-- Start .nav nav-tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presenstation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab"><strong>All Orders</strong></a></li>
		<!--<li role="presenstation"><a href="#create" aria-controls="create" role="tab" data-toggle="tab"><strong>Create Orders</strong></a></li>-->
		<li  style="float: right;" role="presenstation">
		<a href="#create" class="btn btn btn-success btn-xs" style="padding: 5px 10px;" aria-controls="create" role="tab" data-toggle="tab"><i class="fa fa-cart-plus"></i> Create Order</a>
	</li>
	</ul>
	<!-- End .nav nav-tabs -->

	<div class="tab-content">
		<!-- Show Orders -->
		<div role="tabpanel1" class="tab-pane fade in active" id="view">
			<br>
			<div class="table-responsive">
			<table class="table table-responsive table-bordered table-striped">
			    <thead>
			      <tr>
			        <th>Id</th>
			        <th>Actions</th>
			        <th>Customer</th>
			        <!--<th>VAT (14%)</th>-->
			        <th>Total Price ($)</th>
			        <th>Created By</th>
			        <th>Order Date</th>
			        <th>Updated Date</th>
			        <th>Delivery Date</th>
			        <th>Note</th>
			        <th>Delivery Status</th>
			        <th>Billing Status</th>
			      </tr>
			    </thead>
			    <tbody>
				@foreach ($orders as $order)
					@php
						$stock = 1;
					@endphp
					@foreach ($order->orderdetail()->get() as $detail)
						@if ($detail->quantity > $detail->product->quantity)
							@php
								$stock = 0;
							@endphp
						@endif
					@endforeach
					  <tr>
						<td>{{ $order->id }}</td>
						<td>
							<div style="display: inline-flex;">
						@if ($order->status == 0 && $order->deliver == 0 && (Auth::user()->isBowner() || (Auth::user()->isEmployee() && $order->user_id == Auth::user()->id)))
							<!-- Edit button -->
							<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="view/edit order detail" href="{{ route('orders.edit', $order->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
						@else
							<!-- Disable Edit button -->
							<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="view order detail" href="{{ route('orders.edit', $order->id) }}"><span class="glyphicon glyphicon-list-alt"></span></a>
						@endif
						@if (Auth::user()->isBowner())
							<!-- Delete button -->
							<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="{{ $order->status == 1 ? 'delete order' : 'cancel order' }}" href="{{ route('bowner.orders.destroy', $order->id) }}"><span class="glyphicon glyphicon-remove"></span></a>
						@endif
						@if (($order->submit == 1) && ($order->deliver == 1) && ($order->status == 1) && (Auth::user()->isBowner()))
							<!-- Complete button -->
							<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="complete order" href="{{ route('bowner.orders.complete', $order->id) }}"><span class="glyphicon glyphicon-ok"></span></a>
						@endif

						<a class="btn btn-xs btn-default" href="{{ route('orders.show', $order->id) }}" target="_blank"><span class="glyphicon glyphicon-print" data-toggle="tooltip" data-placement="right" title="print"></span></a> 
							</div>
						</td>
						<td>{{ $order->customer->name }}</td>
						<!--<td>{{ $order->vat ? 'Yes' : 'No' }}</td>-->
						<td>{{ $order->total_cost }}</td>


				


						<td>{{ $order->user->name }}</td>
						<td>{{ $order->created_at->diffForHumans() }}</td>
						<td>{{ $order->updated_at->diffForHumans() }}</td>
						<td>{{ date("d-m-Y", strtotime($order->delivery_at)) }}</td>
						<td>{{ $order->note }}</td>

					@if (($order->submit == 0) && (Auth::user()->isBowner()))
						<td><a href="{{ route('bowner.orders.submit', $order->id) }}" class="btn btn-xs btn-primary btn-block">Submit Order</a></td>
					@elseif (($order->submit == 0) && (Auth::user()->isEmployee()))
						<td>Waiting for submission</td>
					@elseif ($order->status == 1)
						<td class="success">Completed <span class="text-success glyphicon glyphicon-ok"></span></td>
					@elseif ($order->deliver == 0 && $stock == 0)
						<td style="background-color: #ffffe6;"><b>Not enough stock</b></td>
					@elseif (($order->deliver == 0) && (Auth::user()->isBowner())) 
						
							@if( $order->billed == 1 || $order->billing_type != 0 )
								<td><a href="{{ route('orders.deliver', $order->id) }}" class="btn btn-xs btn-block btn-pink">
								Submit for delivery</a></td>
							@else
								<td class="warning">Waiting for billing &nbsp;</td>
							@endif
						

					@elseif (($order->deliver == 0) && (Auth::user()->isEmployee())) 
						<td style="background-color: #ffe6e6;">Waiting for submitting delivery</td>
					@elseif($order->delivered == 1)
							<td class="success">Completed <span class="text-success glyphicon glyphicon-ok"></span></td>
					@else
						<td class="info">Waiting for delivery &nbsp;</td>
					@endif



					@if (($order->submit == 0) && (Auth::user()->isBowner()))
						<td><a href="{{ route('bowner.orders.submit', $order->id) }}" class="btn btn-xs btn-primary btn-block">Submit Order</a></td>
					@elseif (($order->submit == 0) && (Auth::user()->isEmployee()))
						<td>Waiting for submission</td>
					@elseif ($order->status == 1)
						<td class="success">Completed <span class="text-success glyphicon glyphicon-ok"></span></td>
					@elseif (($order->billed == 0) && (Auth::user()->isEmployee())) 
						<td  class="warning">>Waiting for billing</td>
					@else
						<td class="warning">Waiting for billing &nbsp;</td>
					@endif



					</tr>
				@endforeach
			    </tbody>
		  	</table>
		  	</div>
		  	<!-- End .table-responsive -->

			<!-- Pagination -->
		  	<div class="row">
		  		<div class="text-center">
		  			{{ $orders->render() }}
		  		</div>
		  	</div>
		</div>
		<!-- End .tab-pane -->
		<!-- End Show Order -->

		<!-- Create Order -->
		<div role="tabpanel2" class="tab-pane fade" id="create" style="padding: 20px;">


			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 card">




			
			{!! Form::open(['method'=>'POST', 'action'=>'OrderController@store', 'class'=>'form-group']) !!}
			<div class="clone-parent">
				<div class="row row-clone">
					<div class="form-group col-sm-5">
						{!! Form::label('products', 'Product ') !!}
						{!! Form::select('products[]', [''=>'Choose Product'] + $products, null, ['class'=>'form-control product', 'required']) !!}
					</div>	

					<div class="form-group col-sm-2">
						{!! Form::label('quantity', 'Quantity ') !!}
						{!! Form::number('quantity[]', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
					</div>
					<div class="form-group col-sm-3">
						{!! Form::label('price', 'Price ') !!}
						{!! Form::number('price[]', null, ['class'=>'form-control', 'min'=>0, 'required'  , 'step' => '0.1']) !!}
					</div>
				</div>
			</div>
			<br>
			<div class="row add-button">
				<a href="#" class="btn btn-success add-product" style="margin: 0 0 10px 10px; float: right;margin-right: 10px;">Add Product</a>
			</div>
			
			<hr>
			<div class="row">
				

				<div class="form-group col-sm-10">
					{!! Form::label('customer', 'Customer ') !!}
					<select name="customer" id="customer" class="form-control" required>
						<option value="" selected>Choose Customer</option>
						@foreach($customers as $customer)
							<option value="{{ $customer->id }}">{{ $customer->name .' ( '.$customer->address1 .' )' }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-2">
					<a class="btn btn-info" href="{{ url('/customer/create') }}" style="margin-top: 2.3rem;">Add Customer</a>
				</div>

				<div class="form-group col-sm-12">
					{!! Form::label('vat', 'TAX Code:') !!}
					{!! Form::select('vat', [0=>'No', 1=>'Yes'], 0, ['class'=>'form-control']) !!}
				</div>

				<div class="form-group col-sm-12">
					{!! Form::label('billing_type', 'Order Billing Type') !!}
					{!! Form::select('billing_type', [0=>'Cash In-Front', 1=>'Ok To Deliver, Cash Later'], 0, ['class'=>'form-control']) !!}
				</div>


			
				<div class="form-group col-sm-12 has-feedback">
					{!! Form::label('delivery_at', 'Delivery By ') !!}
					{!! Form::text('delivery_at', null, ['class'=>'form-control']) !!}
					<span class="glyphicon glyphicon-calendar form-control-feedback" style="right: 10px; top: 22px;"></span>
				</div>

				<div class="form-group col-sm-12">
					{!! Form::label('note', 'Note:') !!}
					{!! Form::textarea('note', null, ['size'=>'30x5', 'class'=>'form-control']) !!}
				</div>
			</div>
		
			<hr>

			<div class="form-group col-sm-12" style="text-align: right;">
				{!! Form::submit('Create Order', ['class'=>'btn btn-primary']) !!}
				
			</div>

			{!! Form::close() !!}
			<hr>
			<div class="alert alert-warning myalert">
				<ul>
					<li>Products chosen are duplicated.</li>
				</ul>
			</div>

		</div>
	</div>
		</div>
		<!-- End .tab-pane -->
		<!-- End Create Order -->
	</div>
	<!-- End .tab-content -->

@stop

@section('scripts')
<script>
	$(function() {
		$('input[id="delivery_at"]').daterangepicker({
			format: 'DD-MM-YYYY',
			singleDatePicker: true,
			showDropdowns: true,
			//minDate: moment(),
		},
		function(start, end, label) {
			var years = moment().diff(start, 'years');
		});
	});
</script>
<script type="text/javascript">
	$(function() {
		//Add product when clicking button	
		$cloneParent = $("div.clone-parent");
		$cloneInput = $("div.row-clone");

		// Hide alert for duplicated products
		$(".myalert").hide();

		// get total number of products could be selected
		productQty = {{ count($products) }};

		// Click button to add products 
		$("div.add-button").on('click', 'a.add-product', function(event) {
			event.preventDefault();
			/*
			$("div.row-clone:first").clone()
				.insertAfter("div.row-clone:last")
				.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
			*/
			$cloneInput.clone()
				.insertAfter("div.row-clone:last")
				.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
			$("div.row-clone>.form-group>input:last").val("");
			$("div.row-clone>.form-group>select:last").val("");

			// Disable add-product button if input fields > products quantity
			if ($("div.row-clone").length >= productQty) {
				$("a.add-product").prop("disabled", true);
			}

		});

		$submitBut = $("input:submit");
		// Check if duplicated products
		function checkSelected() {
			$selected = $("select.product");
			console.log("select length: " + $selected.length);
			for (i = 0; i < $selected.length; i++) {
				flag = 0;
				thisSelect = $selected[i].value;
				console.log("current select: " + thisSelect);
				if (thisSelect === "") { continue; }
				$selected.not($selected[i]).each(function() {
					console.log("value check: " + this.value);
					if (this.value == thisSelect) {
						$(".myalert").show();
						$submitBut.prop("disabled", true);
						flag = 1;
					}
				}); // /.each
				if (flag == 1) { break; }
			} // /for
			if (flag === 0) {
				$(".myalert").hide();
				$submitBut.prop("disabled", false);
			}	
		}

		// Click remove button 
		$cloneParent.on('click', 'a.btn.remove', function(e) {
			e.preventDefault();
			$this = $(this).parent().remove();
			
			// re-allow add button 
			console.log("pQty:" + productQty);
			console.log("clone length:" + $("div.row-clone").length);
			if ($("div.row-clone").length < productQty) {
				console.log("enable");
				$("a.add-product").prop("disabled", false);
			}
			
			checkSelected();

		}); // /remove button click
		
		// Check if duplicated products when selected
	    $cloneParent.on('change', 'select', function () {
	    	checkSelected();
		});
	});
</script>
@stop

