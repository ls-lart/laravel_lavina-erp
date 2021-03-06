@extends('layouts.bowner')

@section('content')

	<h4 style="text-align: center;">Material</h4>
	<br>

	{!! Form::open(['method'=>'POST', 'action'=>'InventoryController@storeMaterial', 'class'=>'form-group']) !!}
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 card">
			
			<div class="form-group col-sm-12">
				{!! Form::label('Name', 'Material Name') !!}
				{!! Form::text('name', null, ['class'=>'form-control',  'required']) !!}
			</div>
			<div class="form-group col-sm-12">
				{!! Form::label('code', 'Material Code') !!}
				{!! Form::text('code', null, ['class'=>'form-control',  'required']) !!}
			</div>	
			<div class="form-group col-sm-12">
				{!! Form::label('warehouse_id', 'Default Warehouse') !!}
				<select name="warehouse_id" id="warehouse_id" class="form-control" required>
					<option value="" selected>Choose Warehouse</option>
					@foreach($warehouses as $warehouse)
						<option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-sm-12">
				{!! Form::label('unit_id', 'Unit Of Measurement') !!}
				<select name="unit_id" id="unit_id" class="form-control" required>
					<option value="" selected>Choose UOM</option>
					@foreach($units as $unit)
						<option value="{{ $unit->id }}">{{ $unit->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-sm-12">
				{!! Form::label('make', 'Make Or Purchase') !!}
				<select name="make" id="make" class="form-control" required>
					<option value="0" selected>Purchase</option>
					<option value="1" selected>Make</option>
				</select>
			</div>
				
			<!--<div class="form-group col-sm-12">
				{!! Form::label('supplier_id', 'Supplier (*):') !!}
				{!! Form::select('supplier_id', [''=>'Choose Supplier'] + $suppliers, null, ['class'=>'form-control', 	'required']) !!}
			</div>
		
			<div class="form-group col-sm-12">
				{!! Form::label('quantity', 'Purchase Quantity (*):') !!}
				{!! Form::number('quantity', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
			</div>
			-->

			<div class="form-group col-sm-12" style="margin-top: 1rem;">
				{!! Form::submit('Submit Material', ['class'=>'btn btn-primary']) !!}
				<a class="btn btn-danger" href="{{URL('/bowner/inventories/')}}">Cancel</a>
			</div>
		</div>
	</div>

	{!! Form::close() !!}

@stop