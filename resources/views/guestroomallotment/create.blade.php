@extends('layouts.app')
@section('content')
<div class="container" ng-app='allotment'>
    <div class="row" ng-controller="allotmentCtrl">
       
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Guest Room Allotment</div>
            <div class="panel-body">
                 @include('flash::message')
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                 {!! Form::open(['url' => 'guestroomallotment']) !!}   
                <div class="form-group  form-inline">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('Guest Name', 'Guest Name:') !!}
                        {!! Form::hidden('guest_info_id', isset($booking_request->guest_info_id)?$booking_request->guest_info_id:'',['class'=>'form-control']) !!}
                        {!! Form::text('guest_name', isset($booking_request->name)?$booking_request->name:'',['class'=>'form-control','disabled'=>true]) !!}
                        </div>
                        <div class="col-md-1">
                        {!! Form::label('Room No', 'Room No:') !!}
                        {!! Form::select('room_id',array_merge([''=>'Select'],$rooms), null,['class'=>'form-control', 'ng-model'=>'room_no', 'ng-change'=>"changeRoom($cntJson)"]) !!}
                        </div>
                        <div class="col-md-3">                
                        {!! Form::label('Check In Date', 'Check In Date:') !!}
                        {!! Form::text('check_in_date',isset($booking_request->check_in_date)?$booking_request->check_in_date:'',['class'=>'form-control', 'id'=>'check_in_date']) !!}
                       </div> 
                       <div class="col-md-3">
                        {!! Form::label('Check Out Date', 'Check Out Date:') !!}
                        {!! Form::text('check_out_date',isset($booking_request->check_out_date)?$booking_request->check_out_date:'',['class'=>'form-control', 'id'=>'check_out_date']) !!}
                       </div>  
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <p class="avail-rooms" ng-bind="msgText"></p>
                        </div>
                    </div>
                   </div> 
                    <div class="form-group">
                        <div class="row">
                        <div class="col-md-2">      
                        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                        </div>    
                    </div>
                
                {!! Form::close() !!}
            </div>
        </div>
        <script language="JavaScript">
		jQuery(document).ready(function($){
                    $('#check_in_date').datetimepicker({
                         sideBySide: true,
                         format: "YYYY/MM/DD hh:mm:ss",
                    });
                    $('#check_out_date').datetimepicker({
                         sideBySide: true,
                         format: "YYYY/MM/DD hh:mm:ss",
                    });
                });
	</script>
    </div>
</div>    
@stop