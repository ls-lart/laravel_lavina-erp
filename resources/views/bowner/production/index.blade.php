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

			<div class="row">
				<div class="col-md-12">
					<h1 class="text-center serial">Daily Revenue</h1>
					<div id="chartdiv" style="width:auto; height:400px; margin:10px auto;"></div>
				</div>
			</div>

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
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/lang/de_DE.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/germanyLow.js"></script>
<script src="https://www.amcharts.com/lib/4/fonts/notosans-sc.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<script>

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end




var chart = am4core.create('chartdiv', am4charts.XYChart)
chart.colors.step = 2;

chart.legend = new am4charts.Legend()
chart.legend.position = 'top'
chart.legend.paddingBottom = 20
chart.legend.labels.template.maxWidth = 95

var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
xAxis.dataFields.category = 'date'
xAxis.renderer.cellStartLocation = 0.1
xAxis.renderer.cellEndLocation = 0.9
xAxis.renderer.grid.template.location = 0;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;

function createSeries(value, name) {
    var series = chart.series.push(new am4charts.ColumnSeries())
    series.dataFields.valueY = value
    series.dataFields.categoryX = 'date'
    series.name = name

    series.events.on("hidden", arrangeColumns);
    series.events.on("shown", arrangeColumns);

    var bullet = series.bullets.push(new am4charts.LabelBullet())
    bullet.interactionsEnabled = false
    bullet.dy = 30;
    bullet.label.text = '{valueY}'
    bullet.label.fill = am4core.color('#ffffff')

    return series;
}

chart.data = {!! $manfacturingDaily !!};
/* [
    {
        category: 'Place #1',
        first: 40,
        second: 55,
        third: 60
    },
    {
        category: 'Place #2',
        first: 30,
        second: 78,
        third: 69
    },
    {
        category: 'Place #3',
        first: 27,
        second: 40,
        third: 45
    },
    {
        category: 'Place #4',
        first: 50,
        second: 33,
        third: 22
    }
]
*/

console.log({!! $manfacturingDaily !!});

createSeries('Ear Loop Machine 1', 'The Thirst');
createSeries('Tie on Machine 1', 'The Second');
createSeries('Face Mask Machine 1', 'The Third');

function arrangeColumns() {

    var series = chart.series.getIndex(0);

    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
        var delta = ((x1 - x0) / chart.series.length) * w;
        if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart.series.indexOf(series);
                }
            })
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function(series) {
                var trueIndex = chart.series.indexOf(series);
                var newIndex = series.dummyData;

                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
            })
        }
    }
}

}); // end am4core.ready()




	

</script>
@stop

