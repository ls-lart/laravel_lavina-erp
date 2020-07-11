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
<script src="//www.amcharts.com/lib/3/amcharts.js"></script>
<script src="//www.amcharts.com/lib/3/serial.js"></script>
<script src="//www.amcharts.com/lib/3/pie.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
<script>

// --- Income by All Products ---
var chartData = {!! $manfacturingDaily !!};

console.log(chartData);

/*
function getYearlyData( monthly ) {
  var yearly = [];
  for ( var i = 0; i < monthly.length; i++ ) {
    var dp = monthly[ i ],
      next = monthly[ i + 1 ];
    if ( next === undefined || dp.month.split('-')[0] != next.month.split('-')[0] )
      yearly.push( dp );
  }
  return yearly;
}
*/

/**
 * Sets proper data set
 */
function setData( type ) {
 //if (type == "daily") {
  	chart.dataProvider = chartData;
  	$('h1.serial').text('Daily Revenue');
  //}

 

  chart.validateData();
}

var chart = AmCharts.makeChart("chartdiv", {
	"type": "serial",
	"dataDateFormat": "YYYY-MM-DD",
  	"dataProvider": chartData,
  	/*
  	// For ajax function
  	"dataLoader": {
	  	"url": "data/dailyByProduct.php",
	    //"format": "json",
	    "showErrors": true,
	    "noStyles": true,
	    "async": true,
	    "load": function( options, chart ) {
        // Here the data is already loaded and set to the chart.
        // We can iterate through it and add proper graphs
        for ( var key in chart.dataProvider[0] ) {
        	if ( chart.dataProvider[0].hasOwnProperty( key ) && key != chart.categoryField ) {
        		var graph = new AmCharts.AmGraph();
        		graph.valueField = key;
        		graph.type = "column";
        		graph.fillAlphas = 0.8;
        		graph.title = key,
            	//graph.lineThickness = 2;
            	chart.addGraph(graph);
	        }
	    }
		}
	},
	*/
	"rotate": false,
	"marginTop": 10,
	"marginRight": 20,
    "marginLeft": 20,
    "marginBottom": 10,
	"categoryField": "date",
	"categoryAxis": {
		//"parseDates": true,
		"gridAlpha": 0.07,
		"axisColor": "#DADADA",
		"axisAlpha": 0.5,
		"labelRotation": 45,
		"startOnAxis": false,
		"title": "Date",
		//"inside": true,
		"gridPosition": "start",
		//"autoGridCount": true,
		//"tickLength": 0,
		/*
		"guides": [{
			"category": "2016-06-05",
			"lineColor": "#CC0000",
			"lineAlpha": 1,
			"dashLength": 2,
			"inside": true,
			"labelRotation": 90,
			"label": "holiday"
		}, {
			"category": "2016-07-05",
			"lineColor": "#CC0000",
			"lineAlpha": 1,
			"dashLength": 2,
			"inside": true,
			"labelRotation": 90,
			"label": "holiday"
		}]
		*/
	},
	"valueAxes": [{
		"stackType": "regular",
		//"stackType": "100%",
		//"axisColor": "#DADADA",
		"axisAlpha": 0.5,
		"gridAlpha": 0.07,
		//"axisAlpha": 0,
		"title": "($)",
        //"labelsEnabled": false,
        //"position": "left"
	}],
	"startDuration": 0.5,
	"graphs": [{
		"valueField": "Ear Loop Machine 1",
		"type": "column",
		"fillAlphas": 0.8,
		//"lineAlpha": 0.2,
		//"fontSize": 11,
		//"bulletSize": 14,
		//"customBullet": "https://www.amcharts.com/lib/3/images/star.png?x",
        //"customBulletField": "customBullet",
		"title": "Ear Loop Machine 1",
		"balloonText": "[[title]]: $<span style='font-size:12px'><b>[[value]]</b></span>",
	},{
		"valueField": "Tie on Machine 1",
		"type": "column",
		"fillAlphas": 0.8,
		"title": "Tie on Machine 1",
		"balloonText": "[[title]]: $<span style='font-size:12px'><b>[[value]]</b></span>",
	}, {
		"valueField": "Face Mask Machine 1",
		"type": "column",
		"fillAlphas": 0.8,
		"title": "Face Mask Machine 1",
		"balloonText": "[[title]]: $<span style='font-size:12px'><b>[[value]]</b></span>",
	}, {
		"valueField": "salary",
		"type": "column",
		"newStack": true,
		"fillAlphas": 0.8,
		"title": "salary",
		"balloonText": "[[title]]: $<span style='font-size:12px'><b>[[value]]</b></span>",
	}, {
		"valueField": "purchase",
		"type": "column",
		"newStack": true,
		"fillAlphas": 0.8,
		"title": "purchase",
		"balloonText": "[[title]]: $<span style='font-size:12px'><b>[[value]]</b></span>",
	},{
		"valueField": "profit",
		"type": "column",
		"newStack": true,
		"fillAlphas": 0.8,
		"title": "profit",
		"balloonText": "[[title]]: $<span style='font-size:12px'><b>[[value]]</b></span>",
	}],
	"legend": {
		"position": "bottom",
		"valueText": "$[[value]]",
		"valueWidth": 150,
		"valueAlign": "left",
		"equalWidths": true,
		"periodValueText": ", total: $[[value.sum]]",
		//"autoMargins": false,
        "borderAlpha": 0.2,
        "horizontalGap": 10,
        //"markerSize": 10,
        //"useGraphSettings": true,
	},
	"chartCursor": {
		"cursorAlpha": 0,
		//"graphBulletSize": 1.5,
     	//"zoomable":false,
      	//"valueZoomable":true,
        //"valueLineEnabled":true,
        //"valueLineBalloonEnabled":true,
        //"valueLineAlpha":0.2
	},
	"chartScrollbar": {
		"color": "FFFFFF"
	},
	/*
	"valueScrollbar":{
      "offset":30
    },
    */
	"export": {
    	"enabled": false,
     }
});


</script>
@stop

