@extends('layouts.bowner')

@section('content')

	<h4 style="text-align: center;">Confirm Product Receving</h4>
	<br>

	{!! Form::open(['method'=>'POST', 'action'=>['SupplierController@recievingComplete', $purchase->id], 'class'=>'form-group']) !!}
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 card">
			

			<div class="form-group col-sm-12 has-feedback">
			{!! Form::label('updated_at', 'Date ') !!}
			{!! Form::text('updated_at', null, ['class'=>'form-control']) !!}
			<span class="glyphicon glyphicon-calendar form-control-feedback" style="right: 10px; top: 22px;"></span>
			</div>


			
			<div class="form-group col-sm-12">
			<label>Requested Quantity</label>
			<div class="">
				<button type="button" class="btn btn-default btn-block disabled" style="text-align: left;">{{$purchase->quantity}}</button>
			</div>
			</div>

					


			<div class="form-group col-sm-12">
			{!! Form::label('actual_quanity', 'Batch Quantity ') !!}
			{!! Form::number('actual_quanity', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
			</div>

			<div class="form-group col-sm-12">
			{!! Form::label('notes', 'Notes ') !!}
			{!! Form::textArea('notes', null, ['class'=>'form-control' ]) !!}
			</div>

			

			<div class="form-group col-sm-12" style="margin-top: 1rem;">
				{!! Form::submit('Confirm Receiving', ['class'=>'btn btn-primary']) !!}
				<a class="btn btn-danger" href="{{URL('/bowner/inventories/')}}">Cancel</a>
			</div>



			
		</div>
	</div>

	{!! Form::close() !!}

@stop

@section('scripts')
	<script type="text/javascript">
	$(function() {
		$('input[id="start_day"], input[id="updated_at"]').daterangepicker({
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