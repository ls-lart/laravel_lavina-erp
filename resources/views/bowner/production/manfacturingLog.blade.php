@extends('layouts.bowner')

@section('content')

@include('includes.message')



	<div class="tab-content">
		

		<div  role="tabpanel4" class="tab-pane fade in active card" id="MShiftReport">
			<h4>Manfacturing Log</h4>
			<br>
			<!-- Start .table-responsive -->
			<div class="table-responsive">
				<table class="table table-responsive table-bordered table-striped">
					<thead>
						
						<tr>
							<th>Shift Type</th>
							<th>Shift Date</th>
							<th>Shift Leader</th>
							<th>Machine</th>
							<th>Product Image</th>
							<th>Product</th>
							<th>Production</th>
							<th>Operation Duration</th>
							<th>Operators</th>
							<th>Production Effeciency</th>
							<th>Breakdown Duration (Min)</th>
							<th>Packaged</th>
							<th>Scrap</th>
							<th>Notes</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>
						@php 
						$i = 0 ;
						@endphp
						@foreach ($manfacturing_shifts as $shift)

						@if($i == 0)
						@elseif(($manfacturing_shifts[$i]->shift_type != $manfacturing_shifts[$i-1]->shift_type) ||($manfacturing_shifts[$i]->shift_date != $manfacturing_shifts[$i-1]->shift_date) ||  ($manfacturing_shifts[$i]->human_id != $manfacturing_shifts[$i-1]->human_id))
						<tr>
							<td></td>
						</tr>
						@else
						@endif
						
						@php
								$class = '';
								$wip = App\WipProduction::where('shift_id',$shift->id)->first();
					
								$scraps = App\Scraps::where('shift_id',$shift->id)->get();
								$scr = 0;
								foreach ($scraps as $scrap){
									$scr = $scr + (int)$scrap->amount ;
								}

								/*if($wip){
									if( ($wip->qunatity == ($wip->packaged + $scr) ) ){
										$class = 'success';
									}
									else{
										$class = 'danger'; 	
									}
								}*/
								
						@endphp

						<tr class="{{$class}}" >
							@if($i == 0)
								<td>{{ $shift->shift_type }}</td>
								<td style="width: 100px;">{{ date("Y-m-d", strtotime($shift->shift_date)) }}</td>
								<td >{{ $shift->human->name }}</td>

							@elseif(($manfacturing_shifts[$i]->shift_type != $manfacturing_shifts[$i-1]->shift_type) ||($manfacturing_shifts[$i]->shift_date != $manfacturing_shifts[$i-1]->shift_date) ||  ($manfacturing_shifts[$i]->human_id != $manfacturing_shifts[$i-1]->human_id))
								<td>{{ $shift->shift_type }}</td>
								<td style="width: 100px;">{{ date("Y-m-d", strtotime($shift->shift_date)) }}</td>
								<td >{{ $shift->human->name }}</td>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif


							

							
							<td>{{ App\Machines::findorfail($shift->machine_id)->name }}</td>
							
							
							

							@if($wip)
							<td style="background-color: ;text-align: center;padding: 0px;"><img style="height: 50px;"  src=" {{ $wip->product->image }}"/></td>

							<td>{{ $wip->product->name }}</td>

							
							<td>{{ $wip->quantity }}</td>
							@else
							<td></td>
							<td></td>
							<td></td>
							@endif

							@if($shift->machine_id == 1)
							<td></td>
							<td></td>
							<td></td>
							@else
							<td>{{ $shift->operation_duration }}</td>
							<td>{{ $shift->workers }}</td>
							<td>{{ number_format((float)$shift->production_effeciency, 2, '.', '') }} %</td>
							@endif

							
							

							
							<td>{{ $shift->total_breakdown_duration }}</td>
							@if($wip)
							<td>{{ $wip->packaged }}</td>
							@else
							<td></td>
							@endif

							

							@if($shift->machine_id == 1)
							<td></td>
							<style type="text/css">.bold{
								font-weight: bold;
							}</style>
							@else
								@php
									$class="";
									if($wip && ( $scr/$wip->quantity *100 > 5 ))
										$class="danger bold";
								@endphp
							<td class="{{$class}}">{{$scr}} 
							
							</td>
							@endif

							
							<td>{{ $shift->notes }}</td>

							@if($i == 0)
							<td> <div style="display: inline-flex;">

								
								<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Shift Details" href="{{route('production.MShift.delete',$shift->id)}}"><span class="glyphicon glyphicon-trash"></span></a>


								

							</div> </td>
							@elseif(($manfacturing_shifts[$i]->shift_type != $manfacturing_shifts[$i-1]->shift_type) ||($manfacturing_shifts[$i]->shift_date != $manfacturing_shifts[$i-1]->shift_date) ||  ($manfacturing_shifts[$i]->human_id != $manfacturing_shifts[$i-1]->human_id))
								<td> <div style="display: inline-flex;">

								
								<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Shift Details" href="{{route('production.MShift.delete',$shift->id)}}"><span class="glyphicon glyphicon-trash"></span></a>


								

							</div> </td>
							@else
								<td></td>
								
							@endif


							
							
						</tr>
						@php 
						$i ++;
						 @endphp
						@endforeach
					</tbody>
				</table>

				
			<!-- / .table-responsive -->
			</div>
		</div>

		
		


	</div>
	

	@stop


