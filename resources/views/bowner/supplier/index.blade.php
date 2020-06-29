@extends('layouts.bowner')

@section('content')

	@include('includes.message')

	<h4>Suppliers</h4>
	<br>
	<div class="row">
		<!-- Start .nav nav-tabs -->
		<a href="/bowner/supplier/create" class="btn btn btn-success btn-xs" style="padding: 5px 10px; float: right;margin-bottom: 1rem;border:0px;margin-right: 10px;"><i class="fa fa-truck"></i> Create Supplier</a>
	</div>

	<!-- End .nav nav-tabs -->
	<div class="table-responsive">
		<table class="table table-hover table-bordered table-striped">
	    <thead>
	      <tr>
	        <th>Id</th>
	        <th>Name</th>
	        <th>Address</th>
	        <th>Phone</th>
	        <th>Description</th>
	      </tr>
	    </thead>
	    <tbody>
		
		@if($suppliers)
			@foreach($suppliers as $supplier)
			  <tr>
				<td>{{$supplier->id}}</td>
				<td><a href="{{route('bowner.supplier.edit', $supplier->id)}}">{{$supplier->name}}</td>
				<td>{{$supplier->address1 .','. $supplier->address2}}</td>
				<td>{{$supplier->phone}}</td>
				<td>{{$supplier->description}}</td>
			  </tr>
			@endforeach
		@endif  
		
	    </tbody>
	  	</table>
  </div>
	
@stop

@section('scripts')
<script>
</script>
@stop

