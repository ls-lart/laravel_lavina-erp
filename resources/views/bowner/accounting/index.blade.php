@extends('layouts.bowner')
@section('content')
@include('includes.message')
<h4>Accounting</h4>
<br>
<!-- Start .nav nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
   <li role="presenstation" class="active"><a href="#ledger" aria-controls="product" role="tab" data-toggle="tab"><strong>Accounting Ledger</strong></a></li>

   <li role="presenstation"> <a href="#ledger" aria-controls="product" role="tab" data-toggle="tab"><strong>Cash In Hand</strong></a></li>
   
   <li  style="float: right;" >
      <a href="/accounting/payment/create" class="btn btn btn-success btn-xs" style="padding: 5px 10px;"><i class="fa fa-euro"></i> Payment Entry</a>
      
   </li>

   
</ul>

@stop
@section('scripts')
<script></script>
@stop