@extends('layouts.bowner')

@section('content')

@include('includes.message')

{!! Form::open(['method'=>'POST', 'action'=>'ProductionController@storeShiftReport', 'class'=>'form-group']) !!}
		
		<!--
			get the WIP 
			- shift date 
			- shift type 
			- shift leader 
			- product 
				- type 
				- color 
			- production 
			- duration 
			- operators 
		-->




{!! Form::close() !!}
@stop