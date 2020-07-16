@extends('layouts.bowner')

@section('content')

	<h4 style="text-align: center;">Purchase Product</h4>
	<br>

	{!! Form::open(['method'=>'POST', 'action'=>'SupplierController@storeProductPurchase', 'class'=>'form-group']) !!}
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 card">
			

			<div class="form-group col-sm-12 has-feedback">
			{!! Form::label('created_at', 'Date ') !!}
			{!! Form::text('created_at', null, ['class'=>'form-control']) !!}
			<span class="glyphicon glyphicon-calendar form-control-feedback" style="right: 10px; top: 22px;"></span>
			</div>


			<div class="form-group col-sm-12">
			{!! Form::label('product_id', 'Product ') !!}
			<select name="product_id" id="product_id" class="form-control" required>
			
				@foreach($materials as $material)
					<option value="{{ $material->id }}">{{ $material->name }}</option>
				@endforeach	
			
			</select>
			</div>

			<div class="form-group col-sm-12">
			{!! Form::label('supplier_id', 'Supplier ') !!}
			{!! Form::select('supplier_id', [''=>'Choose Supplier'] + $suppliers, null, ['class'=>'form-control', 'required']) !!}
			</div>
			
			<div class="form-group col-sm-12">
			{!! Form::label('quantity', 'Purchase Quantity ') !!}
			{!! Form::number('quantity', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
			</div>

			<div class="form-group col-sm-12">
			{!! Form::label('price', 'Purchase Price ') !!}
			{!! Form::number('price', null, ['class'=>'form-control', 'min'=>0, 'required' , 'step' => '0.1']) !!}
			</div>

			<div class="form-group col-sm-12" style="margin-top: 1rem;">
				{!! Form::submit('Submit Purchase Request', ['class'=>'btn btn-primary']) !!}
				<a class="btn btn-danger" href="{{URL('/bowner/inventories/')}}">Cancel</a>
			</div>



			
		</div>
	</div>

	{!! Form::close() !!}

@stop

@section('scripts')
	<script type="text/javascript">
	$(function() {
		$('input[id="start_day"], input[id="created_at"]').daterangepicker({
			format: 'DD-MM-YYYY',
			singleDatePicker: true,
			showDropdowns: true
		}, 
		function(start, end, label) {
			var years = moment().diff(start, 'years');
			//alert("You joined " + years + " ago");
		});
	});
	</script>
@stop