@extends('layouts.bowner')

@section('content')
	<div class="row" style="margin-top: 3rem;">
	<div class="col-sm-10 col-sm-offset-1 card"> 
	
	{!! Form::open(['method'=>'POST', 'action'=>'BownerHumansController@storeAttendance', 'files'=>true]) !!}
	<div class="row">
		<div class="form-group col-sm-4 has-feedback">
         {!! Form::label('Date / وردية يوم', 'Date /  يوم') !!}
         {!! Form::text('date', null, ['class'=>'form-control','id'=>'date','required']) !!}
         <span class="glyphicon glyphicon-calendar form-control-feedback" style="right: 10px; top: 22px;"></span>
      </div>
      @php
      	$i = 0;
      @endphp
      @foreach($employees as $employee)
      	@if($i == 0)
      		<div class="form-group col-sm-12" style="font-weight: 600;font-size: 16px;">{{$employee->department}}</div>
      	@elseif($employees[$i]['department'] != $employees[$i-1]['department'])	
      		<div class="form-group col-sm-12" style="font-weight: 600;font-size: 16px;">{{$employee->department}}</div>
      	@endif	

      	<div class="form-group col-sm-4" style="    background-color: #f5f5f5;padding: 0.5rem 0.85rem;border-radius: 5px;margin-left: 10px;">
      		{!! Form::label($employee->name, $employee->name , ['style'=>'font-size:16px; margin-right:10px;']) !!}
			{!! Form::label('Full day / يوم كامل', 'Full day / يوم كامل' , ['style'=>'font-size:10px;margin-right:5px;']) !!}
			{!! Form::checkbox('fullday[]', $employee->id, false) !!}

			{!! Form::label('Half day / نصف يوم', 'Half day / نصف يوم' , ['style'=>'font-size:10px;margin-right:10px;;margin-left:15px;']) !!}
			{!! Form::checkbox('halfday[]', $employee->id, false) !!}
		</div>


	

      @php
      	$i++;
      @endphp	
      @endforeach

		
	</div>


	
	<hr>
	<div class="row">
		<div class="form-group col-sm-3">
			{!! Form::submit('Submit / حفظ', ['class'=>'btn btn-primary']) !!}
			<a class="btn btn-danger" href="{{redirect()->getUrlGenerator()->previous()}}">Cancel / إلغاء</a>
		</div>
	</div>

	{!! Form::close() !!}	
	
	
	@include('includes.form_error')
	</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
	$(function() {
		$('input[id="date"], input[id="birth"]').daterangepicker({
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