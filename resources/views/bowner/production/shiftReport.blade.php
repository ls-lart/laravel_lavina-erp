@extends('layouts.bowner')
@section('content')
@include('includes.message')
<h4 style="text-align: center;">Reports / تقارير</h4>
<p style="text-align: center;"></p>
<br><br>
<div class="row">
<div class="col-sm-2"></div>
<div class="card col-sm-3" style="text-align: center;" id="btn-manfacturing-div">
   <a href="#" id="btn-manfacturing">
   <label>Manfacturing / تصنيع</label>
   <br>
   <br>
   <i class="fa fa-industry" style="font-size: 5rem;"></i>
   </a>
</div>
<div class="col-sm-1"></div>
<div class="card col-sm-3" style="text-align: center;" id="btn-packaging-div">
   <a href="#" id="btn-packaging">
   <label>Packaging / تغليف</label>
   <br>
   <br>
   <i class="fa fa-archive" style="font-size: 5rem;"></i>
   </a>
</div>
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


<div class="card col-sm-10 col-sm-offset-1 hidden" id="Manfacturing">
   <!--Manfacturing
      TPMS & Breakdown 
      	- Machine 
      	- TPM or Breakdown 
      	- Mantaince / Breakdown part Type (Machine Part )
      	- Notes
      
      quantities of products will reflect the workorder by FIFO and inventory by in progress 
      
      all this will drop in WIP 
      
      
      
      -->
   {!! Form::open(['method'=>'POST', 'action'=>'ProductionController@storeShiftReport', 'class'=>'form-group']) !!}
   <div class="row">
      <div class="form-group col-sm-4 has-feedback">
         {!! Form::label('Date / وردية يوم', 'Date / وردية يوم') !!}
         {!! Form::text('shift_date', null, ['class'=>'form-control','id'=>'shift_date','required']) !!}
         <span class="glyphicon glyphicon-calendar form-control-feedback" style="right: 10px; top: 22px;"></span>
      </div>
      <div class="form-group col-sm-4">
         {!! Form::label('shift', 'Shift / وردية') !!}
         <select name="shift_type" id="shift_type" class="form-control" required>
            <option value="morning" >Morning / صباحية</option>
            <option value="night" >Night / مسائية</option>
         </select>
      </div>
      <div class="form-group col-sm-4">
         {!! Form::label('shift Leader', 'Shift Leader / مشرف الوردية') !!}
         <select name="shift_leader" id="shift_leader" class="form-control" required>
            <option value="">إختار مشرف الوردية</option>
            @foreach($leaders as $leader)
            <option value="{{$leader->id}}">{{$leader->name}}</option>
            @endforeach
         </select>
      </div>
      <br>			
      <hr>
   </div>
   <div class="row" style="    background-color: #f7f7f7;
      margin-top: 2rem;
      border: 1px dashed #d3d3d373;
      margin-right: 0px;
      margin-left: 0px;">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         <h4 style="text-align: center; width: 100%;">ماكينة ماسك رئيسية ١</h4>
      </div>
      <div class="form-group col-sm-12" style="margin-top: 1.5rem;margin-bottom: 2rem;">
         <h5 style="text-align: center; width: 100%;">Breakdowns & Minor Stoppage / اعطال و توقفات قصيره</h5>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 3rem; margin-bottom: 1rem;">
         <!-- present all the machine parts in thier names  -->
         <!-- duration , machine part , note -->
         <div class="clone-parent">
            <div class="row row-clone">
               <div class="form-group col-sm-2">
                  {!! Form::label('duration', 'Duration / المده بالدقايق') !!}
                  {!! Form::number('duration_machine_1[]', null, ['class'=>'form-control', 'min'=>1]) !!}
               </div>
               <div class="form-group col-sm-8">
                  {!! Form::label('notes', 'Notes / أذكر العطل بالتوضيح') !!}
                  {!! Form::textarea('notes_machine_1[]', null, ['class'=>'form-control' , 'rows'=>'2']) !!}
               </div>
            </div>
         </div>
         <div class="row add-button">
            <a href="#" class="btn btn-success add-product" style="float: right;">Add / اضف عطل اخر</a>
         </div>
         <div class="form-group row" style="margin-top: 1rem;">
            {!! Form::label('Other Notes', 'Other Notes / ملاحظات اخري لها علاقه بالاعطال') !!}
            {!! Form::textarea('other_notesـbreakdowns_machine_1', null, ['class'=>'form-control', 'rows'=>'5'] ) !!}
         </div>
      </div>
   </div>
   <div class="row" style="    background-color: #f7f7f7;
      margin-top: 2rem;
      border: 1px dashed #d3d3d373;
      margin-right: 0px;
      margin-left: 0px;">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         <h4 style="text-align: center; width: 100%;">ماكينة ماسك استك ١</h4>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 10px; margin-bottom: 1rem;">
         <div class="form-group col-sm-2" style="text-align: center;">
            <img style=" width: 100px;
               height: auto;
               margin: 0 auto;"src="https://pngimg.com/uploads/medical_mask/medical_mask_PNG41.png">
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('quantity', 'Production Quantity / الكمية') !!}
            {!! Form::number('quantity_machine_1_ear_loop', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('color', 'Product Color / لون المنتج') !!}
            <select name="product_color_machine_1_ear_loop" id="product_color_machine_1_ear_loop" class="form-control" required>
               <option value="blue" >Blue / أزرق</option>
               <option value="green" >Green / أخضر</option>
               <option value="pink" >Pink / زهري</option>
               <option value="white" >White / أبيض</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('type', 'Product Type / نوع المنتج') !!}
            <select name="product_type_machine_1_ear_loop" id="product_type_machine_1_ear_loop" class="form-control" required>
               <option value="Ultra" >Ultra / الترا</option>
               <option value="Extra" >Extra / اكسترا</option>
               <option value="Protect" >Protect / بروتكت</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operation Duration / مدة التشغيل بالساعة') !!}
            {!! Form::number('operation_duration_machine_1_ear_loop', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operators Number / عدد العاملين') !!}
            {!! Form::number('operators_machine_1_ear_loop', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
      </div>
      <div class="form-group col-sm-12" style="margin-top: 1.5rem;margin-bottom: 2rem;">
         <h5 style="text-align: center; width: 100%;">Breakdowns & Minor Stoppage / اعطال و توقفات قصيره</h5>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 3rem; margin-bottom: 1rem;">
         <!-- present all the machine parts in thier names  -->
         <!-- duration , machine part , note -->
         <div class="clone-parent">
            <div class="row row-clone-ear-loop">
               <div class="form-group col-sm-2">
                  {!! Form::label('duration', 'Duration / المده بالدقايق') !!}
                  {!! Form::number('duration_machine_ear_loop_1[]', null, ['class'=>'form-control', 'min'=>1]) !!}
               </div>
               <div class="form-group col-sm-8">
                  {!! Form::label('notes', 'Notes / أذكر العطل بالتوضيح') !!}
                  {!! Form::textarea('notes_machine_ear_loop_1[]', null, ['class'=>'form-control' , 'rows'=>'2']) !!}
               </div>
            </div>
         </div>
         <div class="row add-button">
            <a href="#" class="btn btn-success add-product-ear-loop" style="float: right;">Add / اضف عطل اخر</a>
         </div>
         <div class="form-group row" style="margin-top: 1rem;">
            {!! Form::label('Other Notes', 'Other Notes / ملاحظات اخري لها علاقه بالاعطال') !!}
            {!! Form::textarea('other_notesـbreakdowns_machine_ear_loop_1', null, ['class'=>'form-control', 'rows'=>'5'] ) !!}
         </div>
      </div>
   </div>
   <div class="row" style="    background-color: #f7f7f7;
      margin-top: 2rem;
      border: 1px dashed #d3d3d373;
      margin-right: 0px;
      margin-left: 0px;">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         <h4 style="text-align: center; width: 100%;">ماكينة ماسك رباط ١</h4>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 10px; margin-bottom: 1rem;">
         <div class="form-group col-sm-2" style="text-align: center;">
            <img style=" width: 100px;
               height: auto;
               margin: 0 auto;"src="https://images-na.ssl-images-amazon.com/images/I/51Djy%2BFnGzL._SL1280_.jpg">
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('quantity', 'Production Quantity / الكمية') !!}
            {!! Form::number('quantity_machine_1_tie_on', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('color', 'Product Color / لون المنتج') !!}
            <select name="product_color_machine_1_tie_on" id='product_color_machine_1_tie_on' class="form-control" required>
               <option value="blue" >Blue / أزرق</option>
               <option value="green" >Green / أخضر</option>
               <option value="pink" >Pink / زهري</option>
               <option value="white" >White / أبيض</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('type', 'Product Type / نوع المنتج') !!}
            <select name="product_type_machine_1_tie_on" id='product_type_machine_1_tie_on' class="form-control" required>
               <option value="Ultra" >Ultra / الترا</option>
               <option value="Extra" >Extra / اكسترا</option>
               <option value="Protect" >Protect / بروتكت</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operation Duration / مدة التشغيل بالساعة') !!}
            {!! Form::number('operation_duration_machine_1_tie_on', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('Operators Number', 'Operators Number / عدد العاملين') !!}
            {!! Form::number('operators_machine_1_tie_on', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
      </div>
      <div class="form-group col-sm-12" style="margin-top: 1.5rem;margin-bottom: 2rem;">
         <h5 style="text-align: center; width: 100%;">Breakdowns & Minor Stoppage / اعطال و توقفات قصيره</h5>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 3rem; margin-bottom: 1rem;">
         <!-- present all the machine parts in thier names  -->
         <!-- duration , machine part , note -->
         <div class="clone-parent">
            <div class="row row-clone-tie-on">
               <div class="form-group col-sm-2">
                  {!! Form::label('duration', 'Duration / المده بالدقايق') !!}
                  {!! Form::number('duration_machine_tie_on_1[]', null, ['class'=>'form-control', 'min'=>1]) !!}
               </div>
               <div class="form-group col-sm-8">
                  {!! Form::label('notes', 'Notes / أذكر العطل بالتوضيح') !!}
                  {!! Form::textarea('notes_machine_tie_on_1[]', null, ['class'=>'form-control' , 'rows'=>'2']) !!}
               </div>
            </div>
         </div>
         <div class="row add-button">
            <a href="#" class="btn btn-success add-product-tie-on" style="float: right;">Add / اضف عطل اخر</a>
         </div>
         <div class="form-group row" style="margin-top: 1rem;">
            {!! Form::label('Other Notes', 'Other Notes / ملاحظات اخري لها علاقه بالاعطال') !!}
            {!! Form::textarea('other_notesـbreakdowns_machine_tie_on_1', null, ['class'=>'form-control', 'rows'=>'5'] ) !!}
         </div>
      </div>
   </div>
   <div class="row" style="    background-color: #f7f7f7;
      margin-top: 3rem;
      border: 1px dashed #d3d3d373;
      margin-right: 0px;
      margin-left: 0px;">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         <h4 style="text-align: center; width: 100%;">ماكينة اوفر شوز</h4>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 10px; margin-bottom: 1rem;">
         <div class="form-group col-sm-2" style="text-align: center;">
            <img style=" width: 100px;
               height: auto;
               margin: 0 auto;"src="https://ae01.alicdn.com/kf/H87367f107b7d493aa21cc870dc83ef64n.jpg">
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('quantity', 'Production Quantity / الكمية') !!}
            {!! Form::number('quantity_machine_over_shoes', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('color', 'Product Color / لون المنتج') !!}
            <select name="product_color_machine_over_shoes" id='product_color_machine_over_shoes' class="form-control" required>
               <option value="blue" >Blue / أزرق</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('type', 'Product Type / نوع المنتج') !!}
            <select name="product_type_machine_over_shoes" id='product_type_machine_over_shoes' class="form-control" required>
               <option value="Ultra" >Ultra / الترا</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operation Duration / مدة التشغيل بالساعة') !!}
            {!! Form::number('operation_duration_machine_over_shoes', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('Operators Number', 'Operators Number / عدد العاملين') !!}
            {!! Form::number('operators_machine_over_shoes', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
      </div>
      <div class="form-group col-sm-12" style="margin-top: 1.5rem;margin-bottom: 2rem;">
         <h5 style="text-align: center; width: 100%;">Breakdowns & Minor Stoppage / اعطال و توقفات قصيره</h5>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 3rem; margin-bottom: 1rem;">
         <!-- present all the machine parts in thier names  -->
         <!-- duration , machine part , note -->
         <div class="clone-parent">
            <div class="row row-clone-overshoes">
               <div class="form-group col-sm-2">
                  {!! Form::label('duration', 'Duration / المده بالدقايق') !!}
                  {!! Form::number('breakdown_duration_machine_over_shoes[]', null, ['class'=>'form-control', 'min'=>1]) !!}
               </div>
               <div class="form-group col-sm-8">
                  {!! Form::label('notes', 'Notes / أذكر العطل بالتوضيح') !!}
                  {!! Form::textarea('breakdown_notes_machine_over_shoes[]', null, ['class'=>'form-control' , 'rows'=>'2']) !!}
               </div>
            </div>
         </div>
         <div class="row add-button">
            <a href="#" class="btn btn-success add-product-overshoes" style="float: right;">Add / اضف عطل اخر</a>
         </div>
         <div class="form-group row" style="margin-top: 1rem;">
            {!! Form::label('Other Notes', 'Other Notes / ملاحظات اخري لها علاقه بالاعطال') !!}
            {!! Form::textarea('other_notesـbreakdowns_machine_over_shoes', null, ['class'=>'form-control', 'rows'=>'5'] ) !!}
         </div>
      </div>
   </div>
   <div class="row" style="    background-color: #f7f7f7;
      margin-top: 3rem;
      border: 1px dashed #d3d3d373;
      margin-right: 0px;
      margin-left: 0px;">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         <h4 style="text-align: center; width: 100%;">ماكينة اوفر هيد</h4>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 10px; margin-bottom: 1rem;">
         <div class="form-group col-sm-2" style="text-align: center;">
            <img style=" width: 100px;
               height: auto;
               margin: 0 auto;"src="https://5.imimg.com/data5/GI/ND/MY-1424298/disposable-bouffant-cap-500x500.jpg">
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('quantity', 'Production Quantity / الكمية') !!}
            {!! Form::number('quantity_machine_over_head', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('color', 'Product Color / لون المنتج') !!}
            <select name="product_color_machine_over_head" id='product_color_machine_over_head' class="form-control" required>
               <option value="blue" >Blue / أزرق</option>
               <option value="pink" >Pink / زهري</option>
               <option value="white" >White / أبيض</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('type', 'Product Type / نوع المنتج') !!}
            <select name="product_type_machine_over_head" id='product_type_machine_over_head' class="form-control" required>
               <option value="Ultra" >Ultra / الترا</option>
               <option value="Protect" >Protect / بروتكت</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operation Duration / مدة التشغيل بالساعة') !!}
            {!! Form::number('operation_duration_machine_over_head', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('Operators Number', 'Operators Number / عدد العاملين') !!}
            {!! Form::number('operators_machine_over_head', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
      </div>
      <div class="form-group col-sm-12" style="margin-top: 1.5rem;margin-bottom: 2rem;">
         <h5 style="text-align: center; width: 100%;">Breakdowns & Minor Stoppage / اعطال و توقفات قصيره</h5>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 3rem; margin-bottom: 1rem;">
         <!-- present all the machine parts in thier names  -->
         <!-- duration , machine part , note -->
         <div class="clone-parent">
            <div class="row row-clone-overhead">
               <div class="form-group col-sm-2">
                  {!! Form::label('duration', 'Duration / المده بالدقايق') !!}
                  {!! Form::number('breakdown_duration_machine_over_head[]', null, ['class'=>'form-control', 'min'=>1]) !!}
               </div>
               <div class="form-group col-sm-8">
                  {!! Form::label('notes', 'Notes / أذكر العطل بالتوضيح') !!}
                  {!! Form::textarea('breakdown_notes_machine_over_head[]', null, ['class'=>'form-control' , 'rows'=>'2']) !!}
               </div>
            </div>
         </div>
         <div class="row add-button">
            <a href="#" class="btn btn-success add-product-overhead" style="float: right;">Add / اضف عطل اخر</a>
         </div>
         <div class="form-group row" style="margin-top: 1rem;">
            {!! Form::label('Other Notes', 'Other Notes / ملاحظات اخري لها علاقه بالاعطال') !!}
            {!! Form::textarea('other_notesـbreakdowns_machine_over_head', null, ['class'=>'form-control', 'rows'=>'5'] ) !!}
         </div>
      </div>
   </div>
   <div class="row" style="    background-color: #f7f7f7;
      margin-top: 3rem;
      border: 1px dashed #d3d3d373;
      margin-right: 0px;
      margin-left: 0px;">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         <h4 style="text-align: center; width: 100%;">ماكينة اوفر هيد</h4>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 10px; margin-bottom: 1rem;">
         <div class="form-group col-sm-2" style="text-align: center;">
            <img style=" width: 100px;
               height: auto;
               margin: 0 auto;"src="https://5.imimg.com/data5/OM/BW/MY-14078910/patient-identification-band-2c-child-28pack-of-100-pcs-29-500x500.jpg">
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('quantity', 'Production Quantity / الكمية') !!}
            {!! Form::number('quantity_machine_bracelet', null, ['class'=>'form-control', 'min'=>1, 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('color', 'Product Color / لون المنتج') !!}
            <select name="product_color_machine_bracelet" id='product_color_machine_bracelet' class="form-control" required>
               <option value="blue" >Blue / أزرق</option>
               <option value="pink" >Pink / زهري</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('type', 'Product Type / نوع المنتج') !!}
            <select name="product_type_machine_bracelet" id='product_type_machine_bracelet' class="form-control" required>
               <option value="Adult" >Adult / كبار</option>
               <option value="Kids" >Kids / أطفال</option>
            </select>
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operation Duration / مدة التشغيل بالساعة') !!}
            {!! Form::number('operation_duration_machine_bracelet', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('Operators Number', 'Operators Number / عدد العاملين') !!}
            {!! Form::number('operators_machine_bracelet', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
      </div>
      <div class="form-group col-sm-12" style="margin-top: 1.5rem;margin-bottom: 2rem;">
         <h5 style="text-align: center; width: 100%;">Breakdowns & Minor Stoppage / اعطال و توقفات قصيره</h5>
      </div>
      <div class="col-sm-10 col-sm-offset-1" style="background-color: white;padding: 3rem; margin-bottom: 1rem;">
         <!-- present all the machine parts in thier names  -->
         <!-- duration , machine part , note -->
         <div class="clone-parent">
            <div class="row row-clone-bracelet">
               <div class="form-group col-sm-2">
                  {!! Form::label('duration', 'Duration / المده بالدقايق') !!}
                  {!! Form::number('breakdown_duration_machine_bracelet[]', null, ['class'=>'form-control', 'min'=>1]) !!}
               </div>
               <div class="form-group col-sm-8">
                  {!! Form::label('notes', 'Notes / أذكر العطل بالتوضيح') !!}
                  {!! Form::textarea('breakdown_notes_machine_bracelet[]', null, ['class'=>'form-control' , 'rows'=>'2']) !!}
               </div>
            </div>
         </div>
         <div class="row add-button">
            <a href="#" class="btn btn-success add-product-bracelet" style="float: right;">Add / اضف عطل اخر</a>
         </div>
         <div class="form-group row" style="margin-top: 1rem;">
            {!! Form::label('Other Notes', 'Other Notes / ملاحظات اخري لها علاقه بالاعطال') !!}
            {!! Form::textarea('other_notesـbreakdowns_machine_bracelet', null, ['class'=>'form-control', 'rows'=>'5'] ) !!}
         </div>
      </div>
   </div>
   {!! Form::open(['method'=>'POST', 'action'=>'ProductionController@storeShiftReportPackaging', 'class'=>'form-group']) !!}
   <div class="row">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         {!! Form::submit('Submit / حفظ', ['class'=>'btn btn-primary']) !!}
         <a class="btn btn-danger" href="{{URL('/production/shift_report/show')}}">Cancel / إلغاء</a>
      </div>
   </div>
   {!! Form::close() !!}
</div>
<div class="card col-sm-10 col-sm-offset-1 hidden" id="Packaging">
   <!-- 
      - show the products that needs to be packaged 
      - number of operators 
      - codes to be used for packaging 
      - shift leader 
      - shift date 
      - scrap amount in kg 	
      --> 	
   {!! Form::open(['method'=>'POST', 'action'=>'ProductionController@storeShiftReportPackaging', 'class'=>'form-group']) !!}
   <div class="row">
      <div class="form-group col-sm-4 has-feedback">
         {!! Form::label('Date / وردية يوم', 'Date / وردية يوم') !!}
         {!! Form::text('shift_date', null, ['class'=>'form-control','id'=>'shift_date','required']) !!}
         <span class="glyphicon glyphicon-calendar form-control-feedback" style="right: 10px; top: 22px;"></span>
      </div>
      <div class="form-group col-sm-4">
         {!! Form::label('shift', 'Shift / وردية') !!}
         <select name="shift_type" id="shift_type" class="form-control" required>
            <option value="morning" >Morning / صباحية</option>
            <!--<option value="night" >Night / مسائية</option>-->
         </select>
      </div>
      <div class="form-group col-sm-4">
         {!! Form::label('shift Leader', 'Shift Leader / مشرف الوردية') !!}
         <select name="shift_leader" id="shift_leader" class="form-control" required>
            <option value="">إختار مشرف الوردية</option>
            @foreach($leaders as $leader)
            <option value="{{$leader->id}}">{{$leader->name}}</option>
            @endforeach
         </select>
      </div>
      <br>			
      <hr>
   </div>
   @php $i = 0; @endphp
   @foreach($wips as $wip)
   <div class="row" style="    background-color: #f7f7f7;
      margin-top: 2rem;
      border: 1px dashed #d3d3d373;
      margin-right: 0px;
      margin-left: 0px;padding: 10px;">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         <h4 style="text-align: center; width: 100%;">  {{$wip->shift->shift_type}} - يوم {{ date("Y-m-d", strtotime($wip->shift->shift_date)) }}  - وردية {{$wip->shift->human->name}} </h4>
      </div>
      <div class="col-sm-12 col-sm-offset-0" style="background-color: white;padding: 10px; margin-bottom: 1rem;">
         <div class="form-group col-sm-1" style="text-align: center;">
            <img style=" width: 70px;
               height: auto;
               margin: 0 auto;"src="{{$wip->product->image}}">
         </div>
         <div class="form-group col-sm-4" >
            <label>{{$wip->product->name}}</label>
            <br>
            <br>
            <p style="width: 100%;">
               <span style="">منتج جاهز للتعبئة</span> <strong style="float: right;color: #a94442;">{{$wip->quantity}}</strong>
            </p>
            </p style="width: 100%;"><span style="">إطبع هذا الكود في الكراتين المعبأه لهذه الوردية</span><strong style="float: right;color: #31708f;font-size: 1.2rem;">
            @php 
            $orderdate = explode('-',date("y-m-d", strtotime($wip->shift->shift_date)));
            $arr_day = str_split($orderdate[2]);
            $arr_month = str_split($orderdate[1]);
            $arr_year = str_split($orderdate[0]);
            $c_1 = App\Http\Controllers\ProductionController::returnCode($arr_day[0]);
            $c_2 = App\Http\Controllers\ProductionController::returnCode($arr_day[1]);
            $c_3 = App\Http\Controllers\ProductionController::returnCode($arr_month[0]);
            $c_4 = App\Http\Controllers\ProductionController::returnCode($arr_month[1]);
            $c_5 = App\Http\Controllers\ProductionController::returnCode($arr_year[0]);
            $c_6 = App\Http\Controllers\ProductionController::returnCode($arr_year[1]);
            $code = $c_1.$c_2.$c_3.$c_4.$c_5.$c_6;
            echo $code;
            @endphp
            @if($wip->shift->shift_type == 'morning')
            -1- {{$wip->product->code}}
            @php 
            $code = $code . ' -1- '.$wip->product->code; 
            @endphp
            @else
            -2- {{$wip->product->code}}
            @php $code = $code . ' -2- '.$wip->product->code; @endphp
            @endif
            </strong>
            {{ Form::hidden('batch[]', $code ) }}
            {{ Form::hidden('product[]', $wip->product->id ) }}
            </p>
         </div>
         @php
         $shift[$i] = $wip->shift->id;
         @endphp 
         {{ Form::hidden('shift[]', $shift[$i] ) }}
         <div class="form-group col-sm-2" >
            {!! Form::label('quantity', 'Production Quantity / الكمية المعبأة') !!}
            {!! Form::number('quantity[]', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operation Duration / مدة التشغيل بالساعة') !!}
            {!! Form::number('duration[]', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-2">
            {!! Form::label('operators number', 'Operators Number / عدد العاملين') !!}
            {!! Form::number('operators[]', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
         <div class="form-group col-sm-1">
            {!! Form::label('scrap', 'Scrap / الهالك بالقطعه') !!}
            {!! Form::number('scrap[]', null, ['class'=>'form-control', 'step'=>'any', 'required']) !!}
         </div>
      </div>
      <!--<div class="form-group col-sm-3">
         {!! Form::label('done', 'Done / إكتمل تغليف هذه الوردية' , ['style'=>'font-size:12px']) !!}
         {!! Form::checkbox('done[]', true, false) !!}
         </div>-->
      <div class="form-group col-sm-10 col-sm-offset-1">
         {!! Form::label('notes', 'Notes / ملحوظات لها علاقة بتغليف هذه الكمية') !!}
         {!! Form::textarea('notes[]', null, ['class'=>'form-control' , 'rows'=>'2']) !!}
      </div>
   </div>
   @php 
   $i++;
   @endphp
   @endforeach
   <div class="row">
      <div class="form-group col-sm-12" style="margin-top: 1rem;">
         {!! Form::submit('Submit / حفظ', ['class'=>'btn btn-primary']) !!}
         <a class="btn btn-danger" href="{{URL('/production/shift_report/show')}}">Cancel / إلغاء</a>
      </div>
   </div>
   {!! Form::close() !!}
</div>
<style type="text/css">
   .hidden{
   display: none;
   }
</style>
@stop
@section('scripts')
<script>
   $(function() {
   
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
   	});
   
   	$('#btn-packaging').click(function(){
   
   		$("#Manfacturing").addClass('hidden');
   		$("#Packaging").removeClass('hidden');
   		$("#btn-manfacturing-div").addClass('hidden');
   		$("#btn-packaging-div").addClass('hidden');
   	});
   
   
   	$("#cancel").click(function(){
   
   		$("#btn-manfacturing-div").removeClass('hidden');
   		$("#btn-packaging-div").removeClass('hidden');
   		$("#Manfacturing").addClass('hidden');
   		$("#Packaging").addClass('hidden');
   
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
   		/*
   		$("div.row-clone:first").clone()
   			.insertAfter("div.row-clone:last")
   			.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
   			*/
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
   		/*
   		$("div.row-clone:first").clone()
   			.insertAfter("div.row-clone:last")
   			.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
   			*/
   			$cloneInput.clone()
   			.insertAfter("div.row-clone-tie-on:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");
   
   		// Disable add-product button if input fields > products quantity
   		
   
   	});
   
   	 	 	$("div.add-button").on('click', 'a.add-product-ear-loop', function(event) {
   		event.preventDefault();
   		/*
   		$("div.row-clone:first").clone()
   			.insertAfter("div.row-clone:last")
   			.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
   			*/
   			$cloneInput.clone()
   			.insertAfter("div.row-clone-ear-loop:last")
   			.append("<a class='btn btn-danger remove' style='margin-top:23px;'><i class='fa fa-close'></i></a>");
   			$("div.row-clone>.form-group>input:last").val("");
   			$("div.row-clone>.form-group>select:last").val("");
   
   		
   
   	});
   
   	$("div.add-button").on('click', 'a.add-product-overshoes', function(event) {
   		event.preventDefault();
   		/*
   		$("div.row-clone:first").clone()
   			.insertAfter("div.row-clone:last")
   			.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
   			*/
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
   		/*
   		$("div.row-clone:first").clone()
   			.insertAfter("div.row-clone:last")
   			.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
   			*/
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
   		/*
   		$("div.row-clone:first").clone()
   			.insertAfter("div.row-clone:last")
   			.append("<a class='btn btn-warning remove' style='margin-top:23px;'>Remove</a>");
   			*/
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
   
   });
</script>
@stop