
@extends('layouts.bowner')
@section('content')
@include('includes.message')

<div class="row">
	<a href="/production/shift_report/show/" style="float: right;" id="closer" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i></a>
	<div class="col-sm-10 col-sm-offset-1">
<!-- Start .table-responsive -->
			<div class="table-responsive">
				<table class="table table-responsive table-bordered table-striped">
					<thead>
						
						<tr>
							<th>وردية</th>
							<th>تاريخ الوردية</th>
							<th>مشرف</th>
							
							<th></th>
							<th>المنتج</th>
							<!--<th>كمية الانتاج</th>-->
							<th>كمية التغليف</th>
							<!--<th>مدة التشغيل</th>-->
							<th>عدد العاملين</th>
						
							
							
							<th>هالك</th>
							<!--<th>الكمية المتبقية</th>-->
							<th>ملاحظات</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>
						@php 
						$i = 0 ;
						@endphp
						@foreach ($packaging_shifts as $shift)

						@php
								$wip = App\WipProduction::where('shift_id',$shift->id)->first();
								$shift_man =  App\ShiftLog::where('id',$shift->log_id)->first();
								$wip_man = App\WipProduction::where('shift_id',$shift->log_id)->first();
						@endphp


						@if($wip)

						@if($i == 0)
						@elseif(($packaging_shifts[$i]->shift_type != $packaging_shifts[$i-1]->shift_type) ||($packaging_shifts[$i]->shift_date != $packaging_shifts[$i-1]->shift_date) ||  ($packaging_shifts[$i]->human_id != $packaging_shifts[$i-1]->human_id))
						<tr>
							<td></td>
						</tr>
						@else
						@endif
						<tr>
							@if($i == 0)
								<td>{{ $shift->shift_type }}</td>
								<td style="width: 100px;">{{ date("Y-m-d", strtotime($shift->shift_date)) }}</td>
								<td >{{ $shift->human->name }}</td>

							@elseif(($packaging_shifts[$i]->shift_type != $packaging_shifts[$i-1]->shift_type) ||($packaging_shifts[$i]->shift_date != $packaging_shifts[$i-1]->shift_date) ||  ($packaging_shifts[$i]->human_id != $packaging_shifts[$i-1]->human_id))
								<td>{{ $shift->shift_type }}</td>
								<td style="width: 100px;">{{ date("Y-m-d", strtotime($shift->shift_date)) }}</td>
								<td >{{ $shift->human->name }}</td>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif

							@if($wip)
							<td style="background-color: white;text-align: center;padding: 0px;"><img style="height: 50px;"  src=" {{ $wip->product->image }}"/></td>

							<td>{{ $wip->product->name }}
									@if($shift_man)
									 	<p style="padding: 10px; background-color: white;font-weight: bold;">
									 	@if($wip_man) {{$wip_man->quantity}} @endif : 
									 	{{$shift_man->shift_type}} - وردية  يوم {{ date("Y-m-d", strtotime($shift_man->shift_date)) }}  -   {{$shift_man->human->name}}
									
										</p>
									@endif

							</td>
							
							<td><strong>{{ $wip->quantity }}</strong></td>
							@else
							<td></td>
							<td></td>
							<td></td>
							@endif
							<!--<td>{{ $shift->operation_duration }}</td>-->
							<td>{{ $shift->workers }}</td>

							<td>{{$shift->scrap}}</td>

							<th><span style="font-weight: 500;"></span></th>
							

							<td>{{ $shift->notes }}</td>

							@if($i == 0)
							<td> 
								<!--<div style="display: inline-flex;">

								
								<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Shift Details" href="{{route('production.PShift.delete',$shift->id)}}"><span class="glyphicon glyphicon-trash"></span></a>


								

							</div> -->
						</td>
							
								
							@endif


							
							
						</tr>
						@endif
						
						@php 
						$i ++;
						 @endphp

						 

						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		</div>
			<!-- / .table-responsive -->
@stop			