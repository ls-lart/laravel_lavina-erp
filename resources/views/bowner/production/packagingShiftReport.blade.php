@extends('layouts.bowner')
@section('content')
@include('includes.message')


<a href="/production/shift_report/show/" style="float: right;" id="closer" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i></a>


<div class="card col-sm-10 col-sm-offset-1" id="Packaging">
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
   @foreach($array as $wip)

 
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
         <div class="form-group col-sm-5" >
            <label>{{$wip->product->name}}</label>
            <br>
            <br>
            <p style="width: 100%;padding-right: 15px;">
               <span style="">منتج جاهز للتعبئة</span> <strong style="float: right;color: #a94442;">{{$wip->quantity - $wip->packaged - $wip->scraps}}</strong>
            </p>
            </p style="width: 100%;"><span style="">إطبع هذا الكود في الكراتين المعبأه لهذه الوردية</span><strong style="float: right;color: #31708f;font-size: 1.2rem;padding-right: 15px;">
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
            {{ Form::hidden('production_qunatity[]', $wip->quantity - $wip->packaged - $wip->scraps ) }}
            </p>
         </div>
         @php
         $shift[$i] = $wip->shift->id;
         @endphp 
         {{ Form::hidden('shift[]', $shift[$i] ) }}
        
         <div class="form-group col-sm-2" >
            {!! Form::label('quantity', 'Production Quantity / الكمية المعبأة') !!}
            {!! Form::number('quantity[]', null, ['class'=>'form-control','max'=>$wip->quantity, 'step'=>'any']) !!}
         </div>
         <!--<div class="form-group col-sm-2">
            {!! Form::label('operation duration', 'Operation Duration / مدة التشغيل بالساعة') !!}
            {!! Form::number('duration[]', null, ['class'=>'form-control', 'step'=>'any']) !!}
         </div>-->
         <div class="form-group col-sm-2">
            {!! Form::label('operators number', 'Operators Number / عدد العاملين') !!}
            {!! Form::number('operators[]', null, ['class'=>'form-control', 'step'=>'any']) !!}
         </div>
         <!--<div class="form-group col-sm-1">
            {!! Form::label('scrap', 'Scrap / الهالك بالقطعه') !!}
            {!! Form::number('scrap[]', null, ['class'=>'form-control', 'step'=>'any']) !!}
         </div>-->
      
         <div class="form-group col-sm-2">
         {!! Form::label('done', 'Done / إكتمل تغليف هذه الوردية' , ['style'=>'font-size:12px;margin-right:10px;']) !!}
         {!! Form::hidden('done[]', 0) !!}
         {!! Form::checkbox('done[]', true) !!}
         <br>
         <p>عند الانتهاء من تغليف هذه الودية، إضغط هنا لحساب كمية الهالك</p>
         </div>
      </div>
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