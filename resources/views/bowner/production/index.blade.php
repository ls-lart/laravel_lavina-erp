@extends('layouts.bowner')

@section('content')

@include('includes.message')


<!--<div class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print"></span> Print This Page</div><br><br>-->

<!-- Start .nav nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
	<!--<li role="presenstation" class="active"><a href="#workorders" aria-controls="workorders" role="tab" data-toggle="tab"><strong>Workorders</strong></a></li>
	<li role="presenstation"><a href="#BOMS" aria-controls="BOMS" role="tab" data-toggle="tab"><strong>BOMs</strong></a></li>
	<li role="presenstation"><a href="#TPMS" aria-controls="TPMS" role="tab" data-toggle="tab"><strong>TPMS & Breakdowns</strong></a></li>-->
	<li role="presenstation" class="active"><a href="#Effeciency" aria-controls="Effeciency" role="tab" data-toggle="tab"><strong> Effeciency & Performance</strong></a></li>
	<li role="presenstation" ><a href="#MShiftReport" aria-controls="MShiftReport" role="tab" data-toggle="tab"><strong>Manfacturing Log</strong></a></li>
	<li role="presenstation"><a href="#PShiftReport" aria-controls="PShiftReport" role="tab" data-toggle="tab"><strong>Packaging Log</strong></a></li>
	


	<li  style="float: right;" >

		<a href="{{route('production.shift.show')}}" class="btn btn btn-default btn-xs" style="padding: 5px 10px;"><i class="fa fa-hourglass"></i> Shifts & Reports</a>
	</li>
	<li  style="float: right;" >

		<!--<a href="/bowner/production/bom/new" class="btn btn btn-default btn-xs" style="padding: 5px 10px; margin-right: 10px;"><i class="glyphicon glyphicon-cutlery" style="margin-right: 10px;"></i>Create BOM</a>-->
	</li>
		<!--<li  style="float: right;margin-right: 10px;" >
			<a href="/bowner/inventories/product/create" class="btn btn btn-default btn-xs" style="padding: 5px 10px;"><i class="fa fa-shopping-bag"></i> Create Product</a>
		</li>-->

	</ul>
	<!-- End .nav nav-tabs -->
	<br>

	<div class="tab-content">
		
		<div  role="tabpanel6" class="tab-pane fade in active" id="Effeciency">
			<!-- Start .table-responsive -->
					
					<!-- dashboard for the effeciency of each machine 
						each machine vs the shifts production 
					 -->
					<!-- dashboard for the effeciency of shift leaders -->
					<!-- dashboard for the effeciency of product packaging  -->
					<!-- dashboard for the effeciency of machine health -->
					<!-- dashboard for the effeciency of cost effeciency  -->

			<!-- / .table-responsive -->
			@php
			$productionUnits_all_masks = 0;
			$effeciency_all_masks = 0;
			$breakdowns_all_masks = 0;

			$productionUnits_earloop = 0;
			$effeciency_earloop = 0;
			$breakdowns_earloop = 0;
			$scraps_earloop = 0;
			$unpackaged_earloop = 0;
			$i_earloop = 0;

			$productionUnits_tieon = 0;
			$effeciency_tieon = 0;
			$breakdowns_tieon = 0;
			$scraps_tieon = 0;
			$unpackaged_tieon = 0;
			$i_tieon = 0;

			$productionUnits_overshoes = 0;
			$effeciency_overshoes = 0;
			$breakdowns_overshoes = 0;
			$scraps_overshoes = 0;
			$unpackaged_overshoes = 0;
			$i_overshoes = 0;


			$productionUnits_overhead = 0;
			$effeciency_overhead = 0;
			$breakdowns_overhead = 0;
			$scraps_overhead = 0;
			$unpackaged_overhead = 0;
			$i_overhead = 0;

			$productionUnits_bracelet = 0;
			$effeciency_bracelet = 0;
			$breakdowns_bracelet = 0;
			$scraps_bracelet = 0;
			$unpackaged_bracelet = 0;
			$i_bracelet = 0;

			$i = 0;
			$j = 0;

			foreach ($manfacturing_shifts as $shift){

				if($shift->machine_id == 1){
					$effeciency_all_masks = $effeciency_all_masks + floatval($shift->production_effeciency);
					$j++;
					$breakdowns_all_masks = $breakdowns_all_masks + $shift->total_breakdown_duration ;
				}

				if($shift->machine_id == 5){
					$effeciency_earloop = $effeciency_earloop + floatval($shift->production_effeciency);
					$breakdowns_earloop = $breakdowns_earloop + floatval($shift->total_breakdown_duration);
					$i_earloop++;
				}

				if($shift->machine_id == 6){
					$effeciency_tieon = $effeciency_tieon + floatval($shift->production_effeciency);
					$breakdowns_tieon = $breakdowns_tieon + floatval($shift->total_breakdown_duration);
					$i_tieon++;
				}

				if($shift->machine_id == 2){
					$effeciency_overshoes = $effeciency_overshoes + floatval($shift->production_effeciency);
					$breakdowns_overshoes = $breakdowns_overshoes + floatval($shift->total_breakdown_duration);
					$i_overshoes++;

					$wip = App\WipProduction::where('shift_id',$shift->id)->first(); 
					if($wip){
						$productionUnits_overshoes = $productionUnits_overshoes + intval($wip->quantity);
						$scraps_overshoes = $scraps_overshoes + intval($wip->scraps);
						$unpackaged_overshoes = $unpackaged_overshoes + intval($wip->packaged);
					}
				}

				if($shift->machine_id == 3){
					$effeciency_overhead = $effeciency_overhead + floatval($shift->production_effeciency);
					$breakdowns_overhead = $breakdowns_overhead + floatval($shift->total_breakdown_duration);
					$i_overhead++;

					$wip = App\WipProduction::where('shift_id',$shift->id)->first(); 
					if($wip){
						$productionUnits_overhead = $productionUnits_overhead + intval($wip->quantity);
						$scraps_overhead = $scraps_overhead + intval($wip->scraps);
						$unpackaged_overhead = $unpackaged_overhead + intval($wip->packaged);
					}
				}

				if($shift->machine_id == 4){
					$effeciency_bracelet = $effeciency_bracelet + floatval($shift->production_effeciency);
					$breakdowns_bracelet = $breakdowns_bracelet + floatval($shift->total_breakdown_duration);
					$i_bracelet++;

					$wip = App\WipProduction::where('shift_id',$shift->id)->first(); 
					if($wip){
						$productionUnits_bracelet = $productionUnits_bracelet + intval($wip->quantity);
						$scraps_bracelet = $scraps_bracelet + intval($wip->scraps);
						$unpackaged_bracelet = $unpackaged_bracelet + intval($wip->packaged);
					}
				}


						
				if($shift->machine_id == 5 || $shift->machine_id == 6 ){
				
					$wip = App\WipProduction::where('shift_id',$shift->id)->first(); 
					if($wip){

						if($shift->machine_id == 5){
							$productionUnits_earloop = $productionUnits_earloop + intval($wip->quantity);
							$scraps_earloop = $scraps_earloop + intval($wip->scraps);
							$unpackaged_earloop = $unpackaged_earloop + intval($wip->packaged);
						}

						if($shift->machine_id == 6){
							$productionUnits_tieon = $productionUnits_tieon + intval($wip->quantity);
							$scraps_tieon = $scraps_tieon + intval($wip->scraps);
							$unpackaged_tieon = $unpackaged_tieon + intval($wip->packaged);
						}

						$productionUnits_all_masks = $productionUnits_all_masks + intval($wip->quantity);	
					}
					$i++;
				}
						
			}

			$effeciency_all_masks = $effeciency_all_masks / $j;

			$effeciency_earloop = $effeciency_earloop / $i_earloop;
			$unpackaged_earloop = $productionUnits_earloop - $unpackaged_earloop - $scraps_earloop;

			$effeciency_tieon = $effeciency_tieon / $i_tieon;
			$unpackaged_tieon = $productionUnits_tieon - $unpackaged_tieon - $scraps_tieon;

			$effeciency_overshoes = $effeciency_overshoes / $i_overshoes;
			$unpackaged_overshoes = $productionUnits_overshoes - $unpackaged_overshoes - $scraps_overshoes;

			$effeciency_overhead = $effeciency_overhead / $i_overhead;
			$temp = $productionUnits_overhead - ($unpackaged_overhead + $scraps_overhead);
			$unpackaged_overhead = $temp;
			
			$effeciency_bracelet = $effeciency_bracelet / $i_bracelet;
			$unpackaged_bracelet = $productionUnits_bracelet - $unpackaged_bracelet - $scraps_bracelet;
			

			@endphp

			

			<div class="row">
			
				<div class="col-md-10 col-md-offset-1 card">
					<div class="row">
						
						<div class="col-md-8">
							<h4 class="text-left"><img src="https://images-na.ssl-images-amazon.com/images/I/21nmHIKhnGL._AC_.jpg" style="width: 50px;margin-right: 10px;">Face Mask Machine 1 - Overall</h4>
							<div id="chartdiv" style="width:auto; height:400px; margin:10px auto;"></div>
						</div>
						<div class="col-md-4" style="padding-top: 5rem;">
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Production Units</h5>
								<h4>{{ number_format($productionUnits_all_masks, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Total Effeciency</h5>
								<h4>{{  number_format($effeciency_all_masks, 2, '.', ',') }}%</h4>
							</div>
							<!--<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Unpackaged Units</h5>
								<h4>30,000</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Scraps</h5>
								<h4>13,000</h4>
							</div>-->
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Total Breakdown</h5>
								<h4>{{$breakdowns_all_masks/60}} hours</h4>
							</div>
						</div>


						<div class="col-md-8">
							<h4 class="text-left"><img src="https://images-na.ssl-images-amazon.com/images/I/31YjLpUEmDL.jpg" style="width: 50px;margin-right: 10px;"> Ear Loop Mask Machine 1 - Overall</h4>
							<div id="chartdiv_earloop" style="width:auto; height:400px; margin:10px auto;"></div>
						</div>
						<div class="col-md-4" style="padding-top: 5rem;">
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Production Units</h5>
								<h4>{{ number_format($productionUnits_earloop, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Total Effeciency</h5>
								<h4>{{  number_format($effeciency_earloop, 2, '.', ',') }}%</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Unpackaged Units</h5>
								<h4>{{number_format($unpackaged_earloop, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Scraps</h5>
								<h4>{{ number_format($scraps_earloop, 0, '.', ',') }} - {{number_format($scraps_earloop / $productionUnits_earloop * 100 , 0, '.', ',')}} %</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Total Breakdown</h5>
								<h4>{{$breakdowns_earloop/60}} hours</h4>
							</div>
						</div>


						<div class="col-md-8">
							<h4 class="text-left"><img src="https://cdn.ecommercedns.uk/files/9/230279/6/8038996/tie-on-face-mask_medium.png" style="width: 50px;margin-right: 10px;"> Tie On Mask Machine 1 - Overall</h4>
							<div id="chartdiv_tieon" style="width:auto; height:400px; margin:10px auto;"></div>
						</div>
						<div class="col-md-4" style="padding-top: 5rem;">
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Production Units</h5>
								<h4>{{ number_format($productionUnits_tieon, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Total Effeciency</h5>
								<h4>{{  number_format($effeciency_tieon, 2, '.', ',') }}%</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Unpackaged Units</h5>
								<h4>{{number_format($unpackaged_tieon, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Scraps</h5>
								<h4>{{ number_format($scraps_tieon, 0, '.', ',') }} - {{number_format($scraps_tieon / $productionUnits_tieon * 100 , 0, '.', ',')}} %</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Total Breakdown</h5>
								<h4>{{$breakdowns_tieon/60}} hours</h4>
							</div>
						</div>


					</div>
				</div>

				<div class="col-md-10 col-md-offset-1 card" style="margin-top: 2rem;padding-bottom: 10px;">
					<div class="row">
						
						<div class="col-md-8">
							
						
							<h4 class="text-left" style=""><img src="https://ae01.alicdn.com/kf/H87367f107b7d493aa21cc870dc83ef64n.jpg" style="width: 50px;margin-right: 10px;"> OverShoes Machine - Overall</h4>

							<div id="chartdiv_overshoes" style="width:auto; height:400px; margin:10px auto;"></div>
						</div>
						<div class="col-md-4" style="padding-top: 5rem;">
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Production Units</h5>
								<h4>{{ number_format($productionUnits_overshoes, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Total Effeciency</h5>
								<h4>{{  number_format($effeciency_overshoes, 2, '.', ',') }}%</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Unpackaged Units</h5>
								<h4>{{number_format($unpackaged_overshoes, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Scraps</h5>
								<h4>{{ number_format($scraps_overshoes, 0, '.', ',') }} - {{number_format($scraps_overshoes / $productionUnits_overshoes * 100 , 0, '.', ',')}} %</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Total Breakdown</h5>
								<h4>{{$breakdowns_overshoes/60}} hours</h4>
							</div>
						</div>

					</div>
				</div>

					<div class="col-md-10 col-md-offset-1 card" style="margin-top: 2rem;padding-bottom: 10px;">
					<div class="row">
						
						<div class="col-md-8">
							
						
							<h4 class="text-left" style=""><img src="https://cpimg.tistatic.com/04121042/s/4/Disposable-Bouffant-Cap.jpg" style="width: 50px;margin-right: 10px;"> OverHead Machine - Overall</h4>

							<div id="chartdiv_overhead" style="width:auto; height:400px; margin:10px auto;"></div>
						</div>
						<div class="col-md-4" style="padding-top: 5rem;">
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Production Units</h5>
								<h4>{{ number_format($productionUnits_overhead, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Total Effeciency</h5>
								<h4>{{  number_format($effeciency_overhead, 2, '.', ',') }}%</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Unpackaged Units</h5>
								<h4>{{number_format($unpackaged_overhead, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Scraps</h5>
								<h4>{{ number_format($scraps_overhead, 0, '.', ',') }} - {{number_format($scraps_overhead / $productionUnits_overhead * 100 , 0, '.', ',')}} %</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Total Breakdown</h5>
								<h4>{{$breakdowns_overhead/60}} hours</h4>
							</div>
						</div>

					</div>
				</div>


				<div class="col-md-10 col-md-offset-1 card" style="margin-top: 2rem;padding-bottom: 10px;margin-bottom: 2rem;">
					<div class="row">
						
						<div class="col-md-8">
							
						
							<h4 class="text-left" style=""><img src="https://5.imimg.com/data5/OM/BW/MY-14078910/patient-identification-band-2c-child-28pack-of-100-pcs-29-500x500.jpg" style="width: 50px;margin-right: 10px;">ID Bracelet Machine - Overall</h4>

							<div id="chartdiv_bracelet" style="width:auto; height:400px; margin:10px auto;"></div>
						</div>
						<div class="col-md-4" style="padding-top: 5rem;">
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Production Units</h5>
								<h4>{{ number_format($productionUnits_bracelet, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 1rem;">
								<h5>Total Effeciency</h5>
								<h4>{{  number_format($effeciency_bracelet, 2, '.', ',') }}%</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Unpackaged Units</h5>
								<h4>{{number_format($unpackaged_bracelet, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Scraps</h5>
								<h4>{{ number_format($scraps_bracelet, 0, '.', ',') }}</h4>
							</div>
							<div class="col-md-6 text-center" style="margin-top: 2rem;">
								<h5>Total Breakdown</h5>
								<h4>{{$breakdowns_bracelet/60}} hours</h4>
							</div>
						</div>

					</div>
				</div>





			</div>

		</div>

		<div  role="tabpanel4" class="tab-pane fade " id="MShiftReport">
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
							<th>Total Breakdown Duration (Min)</th>
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
						<tr>
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
							
							
							@php
								$wip = App\WipProduction::where('shift_id',$shift->id)->first()
							@endphp

							@if($wip)
							<td style="background-color: white;text-align: center;padding: 0px;"><img style="height: 50px;"  src=" {{ $wip->product->image }}"/></td>

							<td>{{ $wip->product->name }}</td>

							
							<td>{{ $wip->quantity }}</td>
							@else
							<td></td>
							<td></td>
							<td></td>
							@endif
							<td>{{ $shift->operation_duration }}</td>
							<td>{{ $shift->workers }}</td>

							<td>{{ number_format((float)$shift->production_effeciency, 2, '.', '') }} %</td>
							<td>{{ $shift->total_breakdown_duration }}</td>
							@if($wip)
							<td>{{ $wip->packaged }}</td>
							@else
							<td></td>
							@endif

							@php
								$scraps = App\Scraps::where('shift_id',$shift->id)->get();
								$scr = 0;
								foreach ($scraps as $scrap){
									$scr = $scr + $scrap->amount ;
								}
								
							@endphp

									
							<td>{{$scr}}</td>
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

		<div  role="tabpanel5" class="tab-pane fade " id="PShiftReport">
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
							<th>Packaged</th>
							<th>Operation Duration</th>
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
							@endphp 	
							<td>{{ $wip->product->name }}</td>

							
							<td>{{ $wip->quantity }}</td>
							<td>{{ $shift->operation_duration }}</td>
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
				
			
			</div>
			<!-- / .table-responsive -->
		</div>

		


	</div>
	

	@stop

	@section('scripts')
<!--<script src="//www.amcharts.com/lib/4/amcharts.js"></script>
<script src="//www.amcharts.com/lib/4/serial.js"></script>
<script src="//www.amcharts.com/lib/4/pie.js"></script>
<script src="//www.amcharts.com/lib/4/plugins/animate/animate.min.js"></script>
<script src="//www.amcharts.com/lib/4/plugins/export/export.min.js"></script>
<script src="//www.amcharts.com/lib/4/themes/light.js"></script>
<script src="//www.amcharts.com/lib/4/plugins/dataloader/dataloader.min.js"></script>-->

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/plugins/regression.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/lang/de_DE.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/germanyLow.js"></script>
<script src="https://www.amcharts.com/lib/4/fonts/notosans-sc.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>

<script>

//console.log({!! $manfacturingDaily !!});

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
am4core.useTheme(am4themes_dataviz);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Enable chart cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

// Enable scrollbar
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = {!! $manfacturingDaily !!};

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.dateFormatter.inputDateFormat = "yyyy-MM-dd a";
dateAxis.renderer.minGridDistance = 40;
dateAxis.tooltipDateFormat = "MMM dd, yyyy a";
dateAxis.dateFormats.setKey("day", "dd");

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.tooltipText = "{date}\n[bold font-size: 17px] effeciency: {valueY} %[/]";
series.dataFields.valueY = "Face Mask Machine 1";
series.dataFields.dateX = "date";
//series.strokeDasharray = 3;
series.strokeWidth = 2
series.strokeOpacity = 0.3;
//series.strokeDasharray = "3,3";
series.name = "Face Mask Machine 1";

var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.strokeWidth = 2;
bullet.stroke = am4core.color("#fff");
bullet.setStateOnChildren = true;
bullet.propertyFields.fillOpacity = "opacity";
bullet.propertyFields.strokeOpacity = "opacity";

var hoverState = bullet.states.create("hover");
hoverState.properties.scale = 1.7;

var regseries = chart.series.push(new am4charts.LineSeries());
regseries.dataFields.valueY = "Face Mask Machine 1";
regseries.dataFields.dateX = "date";
regseries.strokeWidth = 2;
regseries.name = "Linear Regression";

regseries.plugins.push(new am4plugins_regression.Regression());
regseries.method = "linear";
//regseries.simplify = true;

chart.legend = new am4charts.Legend();
//chart.cursor = new am4charts.XYCursor();

/*
var lastTrend = createTrendLine([
  { "date": "2012-01-17", "value": 16 },
  { "date": "2012-01-22", "value": 10 }
]);

// Initial zoom once chart is ready
lastTrend.events.once("datavalidated", function(){
  series.xAxis.zoomToDates(new Date(2012, 0, 2), new Date(2012, 0, 13));
});
*/



// Create chart instance
var chart = am4core.create("chartdiv_earloop", am4charts.XYChart);

// Enable chart cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

// Enable scrollbar
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = {!! $manfacturingDaily !!};

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.dateFormatter.inputDateFormat = "yyyy-MM-dd a";
dateAxis.renderer.minGridDistance = 40;
dateAxis.tooltipDateFormat = "MMM dd, yyyy a";
dateAxis.dateFormats.setKey("day", "dd");

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.tooltipText = "{date}\n[bold font-size: 17px] effeciency: {valueY} %[/]";
series.dataFields.valueY = "Ear Loop Machine 1";
series.dataFields.dateX = "date";
//series.strokeDasharray = 3;
series.strokeWidth = 2
series.strokeOpacity = 0.3;
//series.strokeDasharray = "3,3";
series.name = "Ear Loop Machine 1";

var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.strokeWidth = 2;
bullet.stroke = am4core.color("#fff");
bullet.setStateOnChildren = true;
bullet.propertyFields.fillOpacity = "opacity";
bullet.propertyFields.strokeOpacity = "opacity";

var hoverState = bullet.states.create("hover");
hoverState.properties.scale = 1.7;

var regseries = chart.series.push(new am4charts.LineSeries());
regseries.dataFields.valueY = "Ear Loop Machine 1";
regseries.dataFields.dateX = "date";
regseries.strokeWidth = 2;
regseries.name = "Linear Regression";

regseries.plugins.push(new am4plugins_regression.Regression());
regseries.method = "linear";
//regseries.simplify = true;

chart.legend = new am4charts.Legend();




// Create chart instance
var chart = am4core.create("chartdiv_tieon", am4charts.XYChart);

// Enable chart cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

// Enable scrollbar
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = {!! $manfacturingDaily !!};

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.dateFormatter.inputDateFormat = "yyyy-MM-dd a";
dateAxis.renderer.minGridDistance = 40;
dateAxis.tooltipDateFormat = "MMM dd, yyyy a";
dateAxis.dateFormats.setKey("day", "dd");

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.tooltipText = "{date}\n[bold font-size: 17px] effeciency: {valueY} %[/]";
series.dataFields.valueY = "Tie on Machine 1";
series.dataFields.dateX = "date";
//series.strokeDasharray = 3;
series.strokeWidth = 2
series.strokeOpacity = 0.3;
//series.strokeDasharray = "3,3";
series.name = "Tie on Machine 1";

var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.strokeWidth = 2;
bullet.stroke = am4core.color("#fff");
bullet.setStateOnChildren = true;
bullet.propertyFields.fillOpacity = "opacity";
bullet.propertyFields.strokeOpacity = "opacity";

var hoverState = bullet.states.create("hover");
hoverState.properties.scale = 1.7;

var regseries = chart.series.push(new am4charts.LineSeries());
regseries.dataFields.valueY = "Tie on Machine 1";
regseries.dataFields.dateX = "date";
regseries.strokeWidth = 2;
regseries.name = "Linear Regression";

regseries.plugins.push(new am4plugins_regression.Regression());
regseries.method = "linear";
//regseries.simplify = true;

chart.legend = new am4charts.Legend();



// Create chart instance
var chart = am4core.create("chartdiv_overshoes", am4charts.XYChart);

// Enable chart cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

// Enable scrollbar
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = {!! $manfacturingDaily !!};

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.dateFormatter.inputDateFormat = "yyyy-MM-dd a";
dateAxis.renderer.minGridDistance = 40;
dateAxis.tooltipDateFormat = "MMM dd, yyyy a";
dateAxis.dateFormats.setKey("day", "dd");

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.tooltipText = "{date}\n[bold font-size: 17px] effeciency: {valueY} %[/]";
series.dataFields.valueY = "Overshoes";
series.dataFields.dateX = "date";
//series.strokeDasharray = 3;
series.strokeWidth = 2
series.strokeOpacity = 0.3;
//series.strokeDasharray = "3,3";
series.name = "Overshoes";

var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.strokeWidth = 2;
bullet.stroke = am4core.color("#fff");
bullet.setStateOnChildren = true;
bullet.propertyFields.fillOpacity = "opacity";
bullet.propertyFields.strokeOpacity = "opacity";

var hoverState = bullet.states.create("hover");
hoverState.properties.scale = 1.7;

var regseries = chart.series.push(new am4charts.LineSeries());
regseries.dataFields.valueY = "Overshoes";
regseries.dataFields.dateX = "date";
regseries.strokeWidth = 2;
regseries.name = "Linear Regression";

regseries.plugins.push(new am4plugins_regression.Regression());
regseries.method = "linear";






// Create chart instance
var chart = am4core.create("chartdiv_overhead", am4charts.XYChart);

// Enable chart cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

// Enable scrollbar
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = {!! $manfacturingDaily !!};

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.dateFormatter.inputDateFormat = "yyyy-MM-dd a";
dateAxis.renderer.minGridDistance = 40;
dateAxis.tooltipDateFormat = "MMM dd, yyyy a";
dateAxis.dateFormats.setKey("day", "dd");

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.tooltipText = "{date}\n[bold font-size: 17px] effeciency: {valueY} %[/]";
series.dataFields.valueY = "Overhead";
series.dataFields.dateX = "date";
//series.strokeDasharray = 3;
series.strokeWidth = 2
series.strokeOpacity = 0.3;
//series.strokeDasharray = "3,3";
series.name = "Overhead";

var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.strokeWidth = 2;
bullet.stroke = am4core.color("#fff");
bullet.setStateOnChildren = true;
bullet.propertyFields.fillOpacity = "opacity";
bullet.propertyFields.strokeOpacity = "opacity";

var hoverState = bullet.states.create("hover");
hoverState.properties.scale = 1.7;

var regseries = chart.series.push(new am4charts.LineSeries());
regseries.dataFields.valueY = "Overhead";
regseries.dataFields.dateX = "date";
regseries.strokeWidth = 2;
regseries.name = "Linear Regression";

regseries.plugins.push(new am4plugins_regression.Regression());
regseries.method = "linear";



// Create chart instance
var chart = am4core.create("chartdiv_bracelet", am4charts.XYChart);

// Enable chart cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

// Enable scrollbar
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = {!! $manfacturingDaily !!};

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.dateFormatter.inputDateFormat = "yyyy-MM-dd a";
dateAxis.renderer.minGridDistance = 40;
dateAxis.tooltipDateFormat = "MMM dd, yyyy a";
dateAxis.dateFormats.setKey("day", "dd");

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.tooltipText = "{date}\n[bold font-size: 17px] effeciency: {valueY} %[/]";
series.dataFields.valueY = "ID Bracelet";
series.dataFields.dateX = "date";
//series.strokeDasharray = 3;
series.strokeWidth = 2
series.strokeOpacity = 0.3;
//series.strokeDasharray = "3,3";
series.name = "ID Bracelet";

var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.strokeWidth = 2;
bullet.stroke = am4core.color("#fff");
bullet.setStateOnChildren = true;
bullet.propertyFields.fillOpacity = "opacity";
bullet.propertyFields.strokeOpacity = "opacity";

var hoverState = bullet.states.create("hover");
hoverState.properties.scale = 1.7;

var regseries = chart.series.push(new am4charts.LineSeries());
regseries.dataFields.valueY = "ID Bracelet";
regseries.dataFields.dateX = "date";
regseries.strokeWidth = 2;
regseries.name = "Linear Regression";

regseries.plugins.push(new am4plugins_regression.Regression());
regseries.method = "linear";
//regseries.simplify = true;


}); // end am4core.ready()




</script>
@stop

