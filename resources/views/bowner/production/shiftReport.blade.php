@extends('layouts.bowner')
@section('content')
@include('includes.message')
<h4 style="text-align: center;">Reports / تقارير</h4>
<p style="text-align: center;"></p>
<br><br>
<div class="row">

	@if(Auth::user()->access == 'manfacturing' || Auth::user()->access == 'production' || Auth::user()->access == 'super_manager')

	



	<div class="col-sm-8 col-sm-offset-1 card" style="text-align: left;padding: 15px;cursor: pointer;" id="btn-manfacturing-div">

		
			<a href="/production/shift_report/show/manafacturing" id="btn-manfacturing" style="cursor: pointer;">
				<label><i class="fa fa-industry" style="margin-right: 10px;font-size: 15px;"></i> Manfacturing Report / تقرير تصنيع وإنتاج</label>
			
				
			</a>
		
		</div>
		
			<div class="col-sm-2" style="border-radius: 5px;text-align: left;margin-bottom: 2.5rem;margin-top: 2px;">
				<a href="{{route('production.list.last.manafacturing')}}"  style="padding:15px" class="btn btn-xs btn-default btn-block" data-toggle="tooltip" data-placement="right"  >مدخلات الورديات السابقة <span style="margin-left: 10px;" class="glyphicon glyphicon-list"></span></a>
			</div>

	@endif 

	@if(Auth::user()->access == 'packaging' || Auth::user()->access == 'production' || Auth::user()->access == 'super_manager' )

	
	<div class="col-sm-8 col-sm-offset-1 card" style="text-align: left;padding: 15px;cursor: pointer;" id="btn-packaging-div">

		
			<a href="/production/shift_report/show/packaging" id="btn-packaging" style="cursor: pointer;">
				<label><i class="fa fa-archive" style="margin-right: 10px;font-size: 15px;"></i> Packaging Report / تقرير تغليف و تعبئة</label>
			
				
			</a>
		
		</div>
		
			<div class="col-sm-2" style="border-radius: 5px;text-align: left;margin-bottom: 2.5rem;margin-top: 2px;">
				<a href="{{route('production.list.last.packaging')}}"  style="padding:15px" class="btn btn-xs btn-default btn-block" data-toggle="tooltip" data-placement="right"  >مدخلات الورديات السابقة <span style="margin-left: 10px;" class="glyphicon glyphicon-list"></span></a>
			</div>
		
	

	@endif 
</div>
<!--<div class="row" style="margin-top: 6rem;">
<div class="col-sm-2"></div>
<div class="card col-sm-3" style="text-align: center;" id="btn-manfacturing-div">
   <a href="#" id="btn-manfacturing">
   <label>Attendance / حضور و إنصرف</label>
   <br>
   <br>
   <i class="fa fa-industry" style="font-size: 5rem;"></i>
   </a>
</div>
</div>-->

@stop
@section('scripts')
<script>
	/*$(function() {

		$('input[id="shift_date"]').daterangepicker({
			format: 'DD-MM-YYYY',
			singleDatePicker: true,
			showDropdowns: true,
     	//minDate: moment(),
     },
     function(start, end, label) {
     	var years = moment().diff(start, 'years');
     });

		$('#btn-manfacturing').click(function(){

			$("#Manfacturing").removeClass('hidden');
			$("#Packaging").addClass('hidden');
			$("#btn-manfacturing-div").addClass('hidden');
			$("#btn-packaging-div").addClass('hidden');
			$("#closer").removeClass('hidden');

		});

		$('#btn-packaging').click(function(){

			$("#Manfacturing").addClass('hidden');
			$("#Packaging").removeClass('hidden');
			$("#btn-manfacturing-div").addClass('hidden');
			$("#btn-packaging-div").addClass('hidden');
			$("#closer").removeClass('hidden');
		});


		$("#cancel").click(function(){

			$("#btn-manfacturing-div").removeClass('hidden');
			$("#btn-packaging-div").removeClass('hidden');
			$("#Manfacturing").addClass('hidden');
			$("#Packaging").addClass('hidden');
			$("#closer").addClass('hidden');
		});

		$("#closer").click(function(){

			$("#Manfacturing").addClass('hidden');
			$("#Packaging").addClass('hidden');
			$("#btn-manfacturing-div").removeClass('hidden');
			$("#btn-packaging-div").removeClass('hidden');
			$("#closer").addClass('hidden');
		});




   	//Add product when clicking button	
   	$cloneParent = $("div.clone-parent");
   	$cloneInput = $("div.row-clone");

   	// Hide alert for duplicated products
   	$(".myalert").hide();

   	// get total number of products could be selected

   	// Click button to add products 
   	$("div.add-button").on('click', 'a.add-product', function(event) {
   		event.preventDefault();
   		
   			$cloneInput.clone()
   			.insertAfter("div.row-clone:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");

   		// Disable add-product button if input fields > products quantity
   		if ($("div.row-clone").length >= productQty) {
   			$("a.add-product").prop("disabled", true);
   		}

   	});

   	$("div.add-button").on('click', 'a.add-product-tie-on', function(event) {
   		event.preventDefault();
   		
   			$cloneInput.clone()
   			.insertAfter("div.row-clone-tie-on:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");

   		// Disable add-product button if input fields > products quantity
   		

   	});

   	$("div.add-button").on('click', 'a.add-product-ear-loop', function(event) {
   		event.preventDefault();
   		
   			$cloneInput.clone()
   			.insertAfter("div.row-clone-ear-loop:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");



   		});

   	$("div.add-button").on('click', 'a.add-product-overshoes', function(event) {
   		event.preventDefault();
   		
   			$cloneInput.clone()
   			.insertAfter("div.row-clone-overshoes:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");

   		// Disable add-product button if input fields > products quantity
   		if ($("div.row-clone-overshoes").length >= productQty) {
   			$("a.add-product-overshoes").prop("disabled", true);
   		}

   	});

   	$("div.add-button").on('click', 'a.add-product-overhead', function(event) {
   		event.preventDefault();
   		
   			$cloneInput.clone()
   			.insertAfter("div.row-clone-overhead:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");

   		// Disable add-product button if input fields > products quantity
   		if ($("div.row-clone-overhead").length >= productQty) {
   			$("a.add-product-overhead").prop("disabled", true);
   		}

   	});

   	$("div.add-button").on('click', 'a.add-product-bracelet', function(event) {
   		event.preventDefault();
   		
   			$cloneInput.clone()
   			.insertAfter("div.row-clone-bracelet:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");

   		// Disable add-product button if input fields > products quantity
   		if ($("div.row-clone-bracelet").length >= productQty) {
   			$("a.add-product-bracelet").prop("disabled", true);
   		}

   	});	

   	$submitBut = $("input:submit");
   	// Check if duplicated products
   	function checkSelected() {
   		$selected = $("select.product");
   		console.log("select length: " + $selected.length);
   		for (i = 0; i < $selected.length; i++) {
   			flag = 0;
   			thisSelect = $selected[i].value;
   			console.log("current select: " + thisSelect);
   			if (thisSelect === "") { continue; }
   			$selected.not($selected[i]).each(function() {
   				console.log("value check: " + this.value);
   				if (this.value == thisSelect) {
   					$(".myalert").show();
   					$submitBut.prop("disabled", true);
   					flag = 1;
   				}
   			}); // /.each
   			if (flag == 1) { break; }
   		} // /for
   		if (flag === 0) {
   			$(".myalert").hide();
   			$submitBut.prop("disabled", false);
   		}	
   	}

   	// Click remove button 
   	$cloneParent.on('click', 'a.btn.remove', function(e) {
   		e.preventDefault();
   		$this = $(this).parent().remove();
   		
   		// re-allow add button 
   		console.log("pQty:" + productQty);
   		console.log("clone length:" + $("div.row-clone").length);
   		
   		
   		checkSelected();

   	}); // /remove button click

   	
   	
   	// Check if duplicated products when selected
   	$cloneParent.on('change', 'select', function () {
   		checkSelected();
   	});

   });*/
</script>
@stop