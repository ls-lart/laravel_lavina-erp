@extends('layouts.bowner')

@section('content')

@include('includes.message')


<!--<div class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print"></span> Print This Page</div><br><br>-->

<!-- Start .nav nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
	<!--<li role="presenstation" class="active"><a href="#workorders" aria-controls="workorders" role="tab" data-toggle="tab"><strong>Workorders</strong></a></li>
	<li role="presenstation"><a href="#BOMS" aria-controls="BOMS" role="tab" data-toggle="tab"><strong>BOMs</strong></a></li>
	<li role="presenstation"><a href="#TPMS" aria-controls="TPMS" role="tab" data-toggle="tab"><strong>TPMS & Breakdowns</strong></a></li>-->
	<li role="presenstation" class="active"><a href="#MShiftReport" aria-controls="MShiftReport" role="tab" data-toggle="tab"><strong>Manfacturing Log</strong></a></li>
	<li role="presenstation"><a href="#PShiftReport" aria-controls="PShiftReport" role="tab" data-toggle="tab"><strong>Packaging Log</strong></a></li>
	<li role="presenstation"><a href="#Effeciency" aria-controls="Effeciency" role="tab" data-toggle="tab"><strong> Effeciency & Performance</strong></a></li>


	<li  style="float: right;" >

		<a href="{{route('bowner.production.shift.show')}}" class="btn btn btn-default btn-xs" style="padding: 5px 10px;"><i class="fa fa-hourglass"></i> Shifts & Reports</a>
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
		<div  role="tabpanel1" class="tab-pane fade " id="workorders">
			<br>
			<!-- Start .table-responsive -->
			<div class="table-responsive">
				<table class="table table-responsive table-bordered table-striped">
					<thead>
						<tr>
							<th>Order Id</th>
							<th>Customer</th>
							<th>Product</th>

							<th>Order Qty</th>
							<th>Inventory Qty</th>
							<th>Material Qty</th>
							<th>Status</th>
							<th>Date</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
						@php 
						$i = 0; // count items in an order 
						$orderFilled[$order->id] = 1;
						@endphp
						@foreach ($order->orderdetail()->get() as $detail)
						@if($detail->product->quantity < $detail->quantity)
						<tr>
							<td >{{ $order->id }}</td>
							<td >{{ $order->customer->name }}</td>

							<td>{{ $detail->product->name }}</td>

							<td>{{ $detail->quantity  * $detail->product->unit->equi }}</td>
							<td>{{ $products[$detail->product_id] }} (x <i>{{ $detail->product->unit->equi }}</i>)</td>


							@php

							$bom = App\Bom::where('product_id',$detail->product_id)->latest('updated_at')->first();
							$bom_materials = App\BomMaterial::where('bom_id',$bom->id)->get();

							@endphp 	

							<td>
								@foreach($bom_materials as $bom_material)

								<p style="    background: white;
								padding: 10px;
								border-radius: 5px;">
								{{$bom_material->material->name}}  



								<span style="float: right;">{{$bom_material->material->unit->name}}</span>
								<span style="float: right;margin-right: 5px;">
									{{$bom_material->quantity/2000 * $detail->quantity  * $detail->product->unit->equi   }}
								</span>

							</p>

							@endforeach
						</td>
						<td><i>{{ $detail->product->extra }}<i></td>

							<td>{{ date("d-m-Y", strtotime($order->delivery_at)) }}</td>
							<td></td>
							@php 
							$i++;
							@endphp

						</tr>
						@php 
						$products[$detail->product_id] -= $detail->quantity 
						@endphp
						@endif
						@endforeach
						@endforeach
					</tbody>
				</table>
			</div>
			<!-- / .table-responsive -->
		</div>



		<div  role="tabpanel2" class="tab-pane fade" id="BOMS">
			<!-- Start .table-responsive -->
			<div class="table-responsive">
				<table class="table table-responsive table-bordered table-striped">
					<thead>
						<tr>
							<th>Bom Id</th>
							<th>Name</th>
							<th>Product</th>
							<th>Created At</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>
						@foreach ($boms as $bom)

						<tr>

							<td>{{ $bom->id }}</td>
							<td>{{ $bom->name }}</td>
							<td>{{ $bom->product->name }}</td>
							<td>{{ date("d-m-Y", strtotime($bom->created_at)) }}</td>
							<td><div style="display: inline-flex;">

								<!-- Complete button -->
								<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="complete purchase" href="{{route('bowner.production.bom.details',$bom->id)}}"><span class="glyphicon glyphicon-list"></span></a>

							</div></td>

						</tr>

						@endforeach
					</tbody>
				</table>
			</div>
			<!-- / .table-responsive -->
		</div>

		<div  role="tabpanel3" class="tab-pane fade" id="TPMS">
			<!-- Start .table-responsive -->
			<div class="table-responsive">
				<table class="table table-responsive table-bordered table-striped">
					<thead>
						<tr>
							<th>Machine Name</th>
							<th>Machine Segment</th>
							<th>TPM / Breakdown</th>
							<th>Notes</th>
							<th>Date</th>

						</tr>
					</thead>
					<tbody>
						@foreach ($boms as $bom)

						<tr>

							<td>{{ $bom->id }}</td>
							<td>{{ $bom->name }}</td>
							<td>{{ $bom->product->name }}</td>
							<td>{{ date("d-m-Y", strtotime($bom->created_at)) }}</td>
							<td><div style="display: inline-flex;">

								<!-- Complete button -->
								<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="complete purchase" href="{{route('bowner.production.bom.details',$bom->id)}}"><span class="glyphicon glyphicon-list"></span></a>

							</div></td>

						</tr>

						@endforeach
					</tbody>
				</table>
			</div>
			<!-- / .table-responsive -->
		</div>

		<div  role="tabpanel4" class="tab-pane fade in active" id="MShiftReport">
			<!-- Start .table-responsive -->
			<div class="table-responsive">
				<table class="table table-responsive table-bordered table-striped">
					<thead>
						
						<tr>
							<th>Shift Type</th>
							<th>Shift Date</th>
							<th>Shift Leader</th>
							<th>Machine</th>
							
							<th>Operation Duration</th>
							<th>Product Image</th>
							<th>Product</th>
							<th>Production</th>
							<th>Operators</th>
							<th>Production Effeciency</th>
							<th>Total Breakdown Duration (Min)</th>
							<th>Packaged</th>
							<th>Scrap</th>
							<th>Notes</th>
							

						</tr>
					</thead>
					<tbody>
						@php 
						$i = 0 ;
						@endphp
						@foreach ($manfacturing_shifts as $shift)

						<tr>
							@if($i == 0)
								<td>{{ $shift->shift_type }}</td>
								<td >{{ $shift->shift_date }}</td>
								<td >{{ $shift->human->name }}</td>
							@elseif( $manfacturing_shifts[$i]->shift_type != $manfacturing_shifts[$i-1]->shift_type )
								<td>{{ $shift->shift_type }}</td>
								<td >{{ $shift->shift_date }}</td>
								<td >{{ $shift->human->name }}</td>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif

							
							<td>{{ App\Machines::findorfail($shift->machine_id)->name }}</td>
							
							<td>{{ $shift->operation_duration }}</td>
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
							<td>{{ $shift->workers }}</td>
							<td>{{ number_format((float)$shift->production_effeciency, 2, '.', '') }} %</td>
							<td>{{ $shift->total_breakdown_duration }}</td>
							@if($wip)
							<td>{{ $wip->packaged }}</td>
							@php
								$scrap = App\Scraps::where('shift_id',$shift->id)->first();
							@endphp
								@if($scrap)
									<td> {{$scrap->amount}}</td>
								@else
									<td></td>
								@endif		
							@else
							<td></td>
							<td></td>
							@endif
							<td>{{ $shift->notes }}</td>
							
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
							<th>Packaging</th>
							<th>Operation Duration</th>
							<th>Operators</th>
							<th>Effeciency</th>
							<th>Scrap</th>
							
							<th>Notes</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>
						@php 
						$i = 0 ;
						@endphp
						@foreach ($packaging_shifts as $shift)

						<tr>
							@if($i == 0)
								<td>{{ $shift->shift_type }}</td>
								<td >{{ $shift->shift_date }}</td>
								<td >{{ $shift->human->name }}</td>
							@elseif( $packaging_shifts[$i]->shift_type != $packaging_shifts[$i-1]->shift_type )
								<td>{{ $shift->shift_type }}</td>
								<td >{{ $shift->shift_date }}</td>
								<td >{{ $shift->human->name }}</td>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif

							
							
							
							
							
							<td style="background-color: white;text-align: center;padding: 0px;"><img style="height: 50px;"  src=" {{ App\Product::findorfail($shift->machine_id)->image }}"/></td>
							
							<td>{{ App\WipProduction::where('shift_id',$shift->id)->first()->product->name }}</td>

							
							<td>{{ App\WipProduction::where('shift_id',$shift->id)->first()->quantity }}</td>
							<td>{{ $shift->operation_duration }}</td>
							<td>{{ $shift->workers }}</td>
							<td>{{ number_format((float)$shift->production_effeciency, 2, '.', '') }} %</td>
							<td>
								@php 
									$scrap = App\Scraps::where('packaging_id',$shift->id)->first();
								@endphp
								{{ $scrap->amount }}
								<p style="padding: 10px; background-color: white;">From Shift  :
									{{$scrap->shift->shift_type}}  وردية - يوم {{ date("Y-m-d", strtotime($scrap->shift->shift_date)) }}  -   {{$scrap->shift->human->name}}
								</p>
							</td>
							<td>{{ $shift->notes }}</td>
							<td> <div style="display: inline-flex;">

								<!-- Complete button -->
								<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="Shift Details" href="{{route('bowner.production.bom.details',$bom->id)}}"><span class="glyphicon glyphicon-list"></span></a>


								

							</div> </td>
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

		<div  role="tabpanel6" class="tab-pane fade" id="Effeciency">
			<!-- Start .table-responsive -->
					
					<!-- dashboard for the effeciency of each machine 
						each machine vs the shifts production 
					 -->
					<!-- dashboard for the effeciency of shift leaders -->
					<!-- dashboard for the effeciency of product packaging  -->
					<!-- dashboard for the effeciency of machine health -->
					<!-- dashboard for the effeciency of cost effeciency  -->

			<!-- / .table-responsive -->
		</div>


	</div>
	<!-- Pagination -->
	<div class="row">
		<div class="text-center">
			{{ $orders->render() }}
		</div>
	</div>

	@stop

	@section('scripts')
	<script>
	</script>
	@stop

