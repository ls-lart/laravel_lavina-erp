@extends('layouts.bowner')

@section('content')

	<h4 style="text-align: center;">Add Supplier</h4>
	<br>

	{!! Form::open(['method'=>'POST', 'action'=>'SupplierController@store']) !!}
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 card">
			
			<div class="row">
		<div class="form-group col-sm-12">
			{!! Form::label('name', 'Name ') !!}
			{!! Form::text('name', null, ['class'=>'form-control', 'required']) !!}
		</div>
		
		<div class="form-group col-sm-12">
			{!! Form::label('phone', 'Phone ') !!}
			{!! Form::text('phone', null, ['class'=>'form-control', 'required']) !!}
		</div>
	
		<div class="form-group col-sm-12">
			{!! Form::label('address1', 'Address 1 ') !!}
			{!! Form::text('address1', null, ['class'=>'form-control', 'required']) !!}
		</div>
	
	

		<div class="form-group col-sm-12">
			{!! Form::label('description', 'Description:') !!}
			{!! Form::textarea('description', null, ['size'=>'30x5', 'class'=>'form-control']) !!}
		</div>
		

			<div class="form-group col-sm-12" style="margin-top: 1rem;">
				{!! Form::submit('Add Supplier', ['class'=>'btn btn-primary']) !!}
				<a class="btn btn-danger" href="{{URL('/bowner/supplier/')}}">Cancel</a>
			</div>
		</div>
	</div>

	{!! Form::close() !!}

	<hr>
	@include('includes.form_error')
</div>
@stop

@section('scripts')
	<script type="text/javascript">
	</script>
@stop
