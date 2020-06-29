@extends('layouts.bowner')

@section('content')

	@if(Session::has('exceed_leaves'))
		<div class="alert alert-danger fade" style="margin-top:10px;font-size:14px">			
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{session('exceed_leaves')}}
		</div>
	@endif

	<h4 style="text-align: center;">BOM</h4>
	<p style="text-align: center;">Define BOM to create 2000 piece of a product</p>

				<div class="row">
				<div class="col-sm-8 col-sm-offset-2 card">



			{!! Form::open(['method'=>'POST', 'action'=>'ProductionController@SaveBOM', 'class'=>'form-group']) !!}
			

			<div class="form-group col-sm-12">
					{!! Form::label('BOM Name', 'BOM Name:') !!}
					{!! Form::text('name', null, [ 'class'=>'form-control']) !!}
				</div>

			

				<div class="form-group col-sm-12">
					{!! Form::label('Product', 'Product ') !!}
					<select name="product" id="product" class="form-control" required>
						<option>Choose Product</option>
						@foreach($products as $product)
							<option value="{{ $product->id }}" >{{ $product->name  }}</option>
						@endforeach
					</select>
				</div>





				<div class="clone-parent">
				<div class="row row-clone" style="margin-right: 2px; margin-left: 2px;">

					<div class="form-group col-sm-6">
						{!! Form::label('materials', 'Material ') !!}
						{!! Form::select('materials[]', [''=>'Choose Material'] + $materials, null, ['class'=>'form-control product', 'required']) !!}
					</div>	

					<div class="form-group col-sm-3">
						{!! Form::label('quantity', 'Quantity In KG OR Unit') !!}
						{!! Form::number('quantity[]', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
					</div>
				
					
				</div>
			</div>


			<br>

			<div class="row add-button">
				<a href="#" class="btn btn-success add-product" style="margin: 0 0 10px 10px; float: right;margin-right: 10px;">Add Material</a>
			</div>

			<hr>
			
			<div class="row">

				<div class="form-group col-sm-12">
					{!! Form::label('note', 'Note:') !!}
					{!! Form::textarea('note', null, ['size'=>'30x5', 'class'=>'form-control']) !!}
				</div>
			</div>

			<hr>
	
			<div class="form-group col-sm-6" style="text-align: right;">
				{!! Form::submit('Save', ['class'=>'btn btn-primary col-sm-3']) !!}
				<a class="btn btn-warning col-sm-3" href="{{ route('orders.index') }}">Cancel</a>
			</div>

			{!! Form::close() !!}
			<hr>
			<div class="alert alert-warning myalert">
				<ul>
					<li>Products chosen are duplicated.</li>
				</ul>
			</div>

		</div>
	</div>
@stop	

@section('scripts')
<script>
	$(function() {
		$('input[id="delivery_at"]').daterangepicker({
			format: 'DD-MM-YYYY',
			singleDatePicker: true,
			showDropdowns: true,
			//minDate: moment(),
		},
		function(start, end, label) {
			var years = moment().diff(start, 'years');
		});
	});
</script>
<script type="text/javascript">
	$(function() {
		//Add product when clicking button	
		$cloneParent = $("div.clone-parent");
		$cloneInput = $("div.row-clone");

		// Hide alert for duplicated products
		$(".myalert").hide();

		// get total number of products could be selected
		productQty = {{ count($products) }};

		// Click button to add products 
		$("div.add-button").on('click', 'a.add-product', function(event) {
			event.preventDefault();
			/*
			$("div.row-clone:first").clone()
				.insertAfter("div.row-clone:last")
				.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
			*/
			$cloneInput.clone()
				.insertAfter("div.row-clone:last")
				.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
			$("div.row-clone>.form-group>input:last").val("");
			$("div.row-clone>.form-group>select:last").val("");

			// Disable add-product button if input fields > products quantity
			if ($("div.row-clone").length >= productQty) {
				$("a.add-product").prop("disabled", true);
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
			if ($("div.row-clone").length < productQty) {
				console.log("enable");
				$("a.add-product").prop("disabled", false);
			}
			
			checkSelected();

		}); // /remove button click
		
		// Check if duplicated products when selected
	    $cloneParent.on('change', 'select', function () {
	    	checkSelected();
		});
	});
</script>
@stop