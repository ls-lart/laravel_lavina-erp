@extends('layouts.bowner')

@section('content')

	@include('includes.message')

	<ul class="nav nav-tabs" role="tablist">
	<!--<li role="presenstation" class="active"><a href="#workorders" aria-controls="workorders" role="tab" data-toggle="tab"><strong>Workorders</strong></a></li>
	<li role="presenstation"><a href="#BOMS" aria-controls="BOMS" role="tab" data-toggle="tab"><strong>BOMs</strong></a></li>
	<li role="presenstation"><a href="#TPMS" aria-controls="TPMS" role="tab" data-toggle="tab"><strong>TPMS & Breakdowns</strong></a></li>-->
	<li role="presenstation" class="active"><a href="#employees" aria-controls="employees" role="tab" data-toggle="tab"><strong>Employees</strong></a></li>
	<li role="presenstation"><a href="#attendance" aria-controls="attendance" role="tab" data-toggle="tab"><strong>Attendance</strong></a></li>
	<li role="presenstation"><a href="#Effeciency" aria-controls="Effeciency" role="tab" data-toggle="tab"><strong> Salaries & Compensations</strong></a></li>


	<li  style="float: right;" >

		<a class="btn btn btn-default btn-xs" style="padding: 5px 10px;" href="{{ url('/bowner/humans/create') }}">Add Employee</a>

	</li>
	<li  style="float: right;" >

		<a class="btn btn btn-default btn-xs" style="padding: 5px 10px;" href="{{ url('/bowner/humans/attendance/tool') }}">Attendance Tool</a>

	</li>
	
	<li  style="float: right;" >

		<!--<a href="/bowner/production/bom/new" class="btn btn btn-default btn-xs" style="padding: 5px 10px; margin-right: 10px;"><i class="glyphicon glyphicon-cutlery" style="margin-right: 10px;"></i>Create BOM</a>-->
	</li>
		<!--<li  style="float: right;margin-right: 10px;" >
			<a href="/bowner/inventories/product/create" class="btn btn btn-default btn-xs" style="padding: 5px 10px;"><i class="fa fa-shopping-bag"></i> Create Product</a>
		</li>-->

	</ul>

	<div class="tab-content">
		<div  role="tabpanel1" class="tab-pane fade in active" id="employees">
			<br>

	<div class="table-responsive">
		<table class="table table-hover table-bordered table-striped">
	    <thead>
	      <tr>
	        <th>Id</th>
	        <th>Name</th>
	        <th>Job Title</th>
	        <th>Job Department</th>
	        <th>Start Day</th>
	        <th>Date of Birth</th>
	        <th>Gender</th>
	        <th>Address</th>
	        <th>Phone</th>
	        <th>ID#</th>
	      </tr>
	    </thead>
	    <tbody>
		
		@if($humans)
			@foreach($humans as $human)
			  <tr>
				<td>{{$human->id}}</td>
				<td><a href="{{route('bowner.humans.edit', $human->id)}}">{{$human->name}}</td>
				<td>{{$human->job}}</td>
				<td>{{$human->department}}</td>
				<td>{{date("d-m-Y", strtotime($human->start_day))}}</td>
				<td>{{date("d-m-Y", strtotime($human->birth))}}</td>
				<td>{{$human->gender}}</td>
				<td>{{$human->address1 .','. $human->address2}}</td>
				<td>{{$human->phone}}</td>
				<td>{{$human->idnum}}</td>
			  </tr>
			@endforeach
		@endif  
		
	    </tbody>
	  	</table>
	</div>
</div>

<div  role="tabpanel2" class="tab-pane fade" id="attendance">
			<br>

	<div class="table-responsive">
		<table class="table table-hover table-bordered table-striped">
	    <thead>
	      <tr>
	        <th>Id</th>
	        <th>Name</th>
	        <th>Title</th>
	        <th>Department</th>
	        <th>Date</th>
	        <th>Attendance</th>
	      
	      </tr>
	    </thead>
	    <tbody>
		
		
			@foreach($attendance as $att)
			  <tr>
				<td>{{$att->id}}</td>
				<td><a href="{{route('bowner.humans.edit', $att->human->id)}}">{{$att->human->name}}</td>
				<td>{{$att->human->job}}</td>
				<td>{{$att->human->department}}</td>
				<td>{{ date("Y-m-d", strtotime($att->date)) }}</td>
				@if($att->halfday)
					<td class="warning">Half Day</td>
				@elseif($att->fullday)
					<td class="success">Full Day</td>
				@else
					<td class="danger">Absent </td>
				@endif	
				
			  </tr>
			@endforeach
	 
		
	    </tbody>
	  	</table>
	</div>
</div>


</div>
	
	
@stop

@section('scripts')
<script>
</script>
@stop

