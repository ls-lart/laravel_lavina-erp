@extends('layouts.bowner')

@section('content')

	<h4>Payment Entry</h4>
	<br>

	<!--
	
		payment date - o.k
		 
		payment amount - o.k
		
		payment against customer - o.k
		
		payment type  - cash , transfer , check - o.k

		in case of check ( check number and collection date )

		in case of bank transfer (bank name and account number )
	
		note 

		payment currency - o.k 

	-->
	
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 card">
			
			{!! Form::open(['method'=>'POST', 'action'=>'AccountingController@storePayment', 'class'=>'form-group']) !!}
		
			
			<div class="row">


				<div class="form-group col-sm-12">
					Entry Type
					<select name="entryType" id="entryType" class="form-control" required>
					
							<option value="cash-in" selected>Cash In</option>
							<option value="cash-out" >Cash Out</option>
					
					</select>
				</div>

				
				<div class="form-group col-sm-12 has-feedback">
					{!! Form::label('created_at', 'Payment Date ') !!}
					{!! Form::text('created_at', null, ['class'=>'form-control']) !!}
					<span class="glyphicon glyphicon-calendar form-control-feedback" style="right: 10px; top: 22px;"></span>
				</div>

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
					{!! Form::label('amount', 'amount ') !!}
						{!! Form::number('amount','', ['class'=>'form-control', 'min'=>0,'step'=>0, 'required']) !!}
				</div>	

				<div class="form-group col-sm-12">
					{!! Form::label('currency', 'Currency') !!}
					{!! Form::select('currency', [0=>'EGP', 1=>'USD'], 0, ['class'=>'form-control']) !!}
				</div>

				<div class="form-group col-sm-12">
					{!! Form::label('type', 'Type') !!}
					{!! Form::select('type', [0=>'Cash', 1=>'Check',2=>'Bank Transfer'], 0, ['class'=>'form-control']) !!}
				</div>
				

				


			
				

				<div class="form-group col-sm-12">
					{!! Form::label('note', 'Note:') !!}
					{!! Form::textarea('note', null, ['size'=>'30x5', 'class'=>'form-control']) !!}
				</div>
			</div>
		
			<hr>

			<div class="form-group col-sm-12" style="text-align: right;">
				{!! Form::submit('Submit Payment', ['class'=>'btn btn-primary']) !!}
				
			</div>

			{!! Form::close() !!}
			

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

@stop
