@extends('layouts.bowner')
@section('content')
@include('includes.message')
<h4>Delivery</h4>
<br>

			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 card">

					<div class="row">
					<div class="form-group col-sm-6">
					{!! Form::label('Order', 'Order ') !!}
					<p style="padding: 8px 15px; background-color: #eee;font-weight: bold;">{{ $order->id }}</p>
				</div>
					<div class="form-group col-sm-6">
					{!! Form::label('customer', 'Customer ') !!}
					<p style="padding: 8px 15px; background-color: #eee;font-weight: bold;">{{ $order->customer->name }}</p>
				</div>
			</div>

			{!! Form::open(['method'=>'POST', 'action'=>['OrderController@partialDelivery', $order->id], 'class'=>'form-group']) !!}
				
			 @foreach($order->orderdetail as $detail)
				<div class="row row-clone">
					@if(!$detail->delivered)
					<div class="form-group col-sm-5">

						<p style="padding: 8px 15px; background-color: #eee;font-weight: bold;">
							<img style="height: 50px; margin-right: 10px;"  src="{{$detail->product->image}}">{{ $detail->product->name }}</p>
					</div>	

					<div class="form-group col-sm-2">
						{!! Form::label('Reminder Quantity', 'Reminder Quantity') !!}
						<p style="padding: 8px 15px; background-color: #eee;font-weight: bold;">{{ $detail->remainder_quantity }}</p>
					</div>

					<div class="form-group col-sm-2">
						{!! Form::label('quantity', 'Quantity ') !!}
						{!! Form::number('quantity[]', null, ['class'=>'form-control', 'min'=>0]) !!}
					</div>
					
					
					<div class="form-group col-sm-3">
						{!! Form::label('warehouse', 'Warehouse') !!}
						{!! Form::select('warehouses[]', [''=>'Choose Warehouse'] + $warehouses, null,  ['class'=>'form-control product'  ,'required']) !!}
					</div>
					@endif
				</div>
			@endforeach


			<br>
		

			<div class="row">
			
				
				
		
				<div class="form-group col-sm-12">
					{!! Form::label('note', 'Note:') !!}
					{!! Form::textarea('note', null, ['size'=>'30x5', 'class'=>'form-control']) !!}
				</div>
			</div>
		
			<hr>

			<div class="form-group col-sm-12" style="text-align: right;">
				{!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
				
			</div>

			{!! Form::close() !!}
		

		</div>
	</div>
@stop