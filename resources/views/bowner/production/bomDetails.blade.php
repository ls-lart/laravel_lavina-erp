 @extends('layouts.bowner')

@section('content')

	@include('includes.message')

	<h4 style="text-align: center;">BOM Detials</h4>
	<p style="text-align: center;">Define BOM to create 2000 piece of a product</p>
	
	<!-- End .nav nav-tabs -->

		<!-- Show Orders -->
		<div  class="row" id="view">
			<div class="col-sm-8 col-sm-offset-2 card">
			<br>
			<h4 style="text-align: left;">{{$bom->name}}</h4>
			<p>{{$bom->product->name}}</p>
			<div class="table-responsive">
			<table class="table table-responsive table-bordered table-striped">
			    <thead>
			      <tr>
			        <th>#</th>
			        <th>Material</th>
			        <th>quantiyt</th>
			      </tr>
			    </thead>
			    <tbody>
		    	@php
		    		$i = 1;
		    	@endphp
				@foreach ($materials as $detail)
				  	<tr>
						<td>{{ $i++ }}</td>
						
						<td>{{ $detail->material->name }}</td>
						<td>{{ $detail->quantity }} </td>

					</tr>
				@endforeach

			    </tbody>
			    
		  	</table>
		  	</div>
		  	<!-- End .table-responsive -->
		  	
		</div>
		<!-- End View Order .tab-pane -->
		
		
	
	<!-- End .tab-content -->

@stop


