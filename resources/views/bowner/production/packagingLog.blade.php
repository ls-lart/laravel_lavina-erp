@extends('layouts.bowner')

@section('content')

@include('includes.message')


	<div class="tab-content card">
			<h4>Packaging Log</h4>
			<br>
		

		<div  role="tabpanel5" class="tab-pane fade in active" id="PShiftReport">
			<!-- Start .table-responsive -->
			<div class="table-responsive">
				<table class="table table-responsive table-bordered table-striped">
					<thead>
						
						<tr>
							<th>Shift Type</th>
							<th>Shift Date</th>
							<th>Shift Leader</th>
							<th>Product Image</th>
							<th>Product</th>
							<th>Production</th>
							<th>Packaged</th>
							<!--<th>Operation Duration</th>-->
							<th>Operators</th>
							<th>Effeciency</th>
							<th>Scrap</th>
							
							<th>Notes</th>
							<!--<th>Actions</th>-->

						</tr>
					</thead>
					<tbody>
						@php 
						$i = 0 ;
						@endphp
						@foreach ($packaging_shifts as $shift)
						@if($i == 0)
						@elseif( $packaging_shifts[$i]->shift_date!= $packaging_shifts[$i-1]->shift_date )
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
							@elseif( $packaging_shifts[$i]->shift_date!= $packaging_shifts[$i-1]->shift_date )
								<td>{{ $shift->shift_type }}</td>
								<td style="width: 100px;">{{ date("Y-m-d", strtotime($shift->shift_date)) }}</td>
								<td >{{ $shift->human->name }}</td>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif
							
							
							
							
							
							<td style="background-color: white;text-align: center;padding: 0px;"><img style="height: 50px;"  src=" {{ App\Product::findorfail($shift->machine_id)->image }}"/></td>
							
							@php 
								$wip = App\WipProduction::where('shift_id',$shift->id)->first();

								$shift_man =  App\ShiftLog::where('id',$shift->log_id)->first();
								
								$wip_man = App\WipProduction::where('shift_id',$shift->log_id)->first();

							@endphp 	
							<td>@if($wip){{ $wip->product->name }}

									@if($shift_man)
									 <p style="padding: 10px; background-color: white;">
									{{$shift_man->shift_type}}  وردية - يوم {{ date("Y-m-d", strtotime($shift_man->shift_date)) }}  -   {{$shift_man->human->name}}
									
									</p>
									@endif
								@endif		
							</td>		
							<th><strong>@if($wip_man) {{$wip_man->quantity}} @endif</strong></th>
							<td>@if($wip) {{ $wip->quantity }} @endif</td>
							<!--<td>{{ $shift->operation_duration }}</td>-->
							<td>{{ $shift->workers }}</td>
							<td>{{ number_format((float)$shift->production_effeciency, 2, '.', '') }} %</td>
							<td>

								@php 
									$scraps = App\Scraps::where('packaging_id',$shift->id)->get();
									$scr = 0;
								@endphp
								@if($scraps)
									@foreach($scraps as $scrap)

									 {{ $scrap->amount }}

									@endforeach
								@endif	


							</td>
							<td>{{ $shift->notes }}</td>
							<!--<td> <div style="display: inline-flex;">

							
								

							</div> </td> -->
						</tr>
						@php 
						$i ++;
						 @endphp
						@endforeach
					</tbody>
				</table>
					<!-- Pagination -->
  	<div class="row">
  		<div class="text-center">
  			{{ $packaging_shifts->render() }}
  		</div>
  	</div>
			
			</div>
			<!-- / .table-responsive -->
		</div>

		


	</div>
	

	@stop

	@section('scripts')

	@stop

