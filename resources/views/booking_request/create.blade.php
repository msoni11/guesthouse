@extends('layouts.app')
@section('content')
<div class="container" ng-app='guest_house'>
    <div class="row" ng-controller="guestCtr">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Book Guest House</div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger" >
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! Form::open(['url' => 'booking_request', 'files'=>true]) !!}
                <div class="form-group form-inline">
                    <div class="row">
                        <div class="col-md-4">   
                        {!! Form::label('No. of visitors', 'No. of visitors:') !!}
                        {!! Form::select('no_of_visitors',[''=>'Select', 1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10],null,['class'=>'form-control', 'ng-model'=>'no_of_visitors', 'ng-change'=>'changeVisitors()']) !!}                   
                      </div>
                      <div class="col-md-4">       
                        {!! Form::label('No. of rooms required', 'No. of rooms required:') !!}
                        {!! Form::text('required_room',null,['class'=>'form-control']) !!}
                      </div>
                      <div class="col-md-4"> 
                        {!! Form::label('Type of Guest', 'Type of Guest:') !!}
                        {!! Form::select('type_of_guest',['visitor'=>'Visitor', 'employee'=>'Employee', 'contractor'=>'Contractor'],null,['class'=>'form-control', 'ng-model'=>'type_of_guest', 'ng-init'=>"type_of_guest == 'visitor'" ]) !!}
                        {!! Form::text('po_no',null,['class'=>'form-control ng-hide', 'ng-show' => "type_of_guest == 'contractor'"]) !!}
                      </div>
                    </div>
                </div>    
                <div class="form-group form-inline">
                    <div class="row">
                    <div class="col-md-4"> 
                        {!! Form::label('Check In Date', 'Check In Date:') !!}
                        {!! Form::text('check_in_date',null,['class'=>'form-control', 'id'=>'check_in_date']) !!}
                    </div>
                    <div class="col-md-4"> 
                        {!! Form::label('Check Out Date', 'Check Out Date:') !!}
                        {!! Form::text('check_out_date',null,['class'=>'form-control', 'id'=>'check_out_date']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('Food Order', 'Food Order:') !!}
                        {!! Form::checkbox('food_order[]','break-fast',['class'=>'form-control']) !!}
                        {!! Form::label('', 'Break Fast') !!}
                        {!! Form::checkbox('food_order[]','lunch',['class'=>'form-control']) !!}
                        {!! Form::label('', 'Lunch') !!}
                        {!! Form::checkbox('food_order[]','dinner',['class'=>'form-control']) !!}
                        {!! Form::label('', 'Dinner') !!}
                    </div>
                </div>
                </div>
                <div class="form-group form-inline">
                    <div class="row">
                    <div class="col-md-4">
                    {!! Form::label('Organization Name &  Address', 'Organization Name & Address:') !!}
                    {!! Form::textarea('org_name_address',null,['class'=>'form-control', 'rows'=>2]) !!}
                    </div>
                        
                    <div class="col-md-4"> 
                    {!! Form::label('Purpose', 'Purpose:') !!}
                    {!! Form::textarea('purpose',null,['class'=>'form-control', 'rows'=>2]) !!}
                    </div>
                    
                    <div class="col-md-4">
                    {!! Form::label('Remark', 'Remark:') !!}
                    {!! Form::textarea('remark',null,['class'=>'form-control', 'rows'=>2, 'cols'=>47]) !!}
                    </div>
                </div>
                </div>
                <div class="form-group">
                    {!! Form::hidden('request_by',  Auth::user()->id, null, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::hidden('status',3,null,['class'=>'form-control']) !!}
                </div>
                <div ng-repeat="n in [] | range:no_of_visitors">
                     <hr>  
                    <div class="form-group form-inline">
                        <% $index + 1 %>)
                        {!! Form::label('Guest Name', 'Guest Name:') !!}
                        {!! Form::text('name[<% $index + 1 %>]',null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Contact No', 'Guest Contact No:') !!}
                        {!! Form::text('contact_no[<% $index + 1 %>]',null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Email', 'Guest Email:') !!}
                        {!! Form::text('email[<% $index + 1 %>]',null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Address', 'Guest Address:') !!}
                        {!! Form::text('address[<% $index + 1 %>]',null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group form-inline">
                        {!! Form::label('Attach Document', 'Attach Document:') !!}
                        {!! Form::select('document_type[<% $index + 1 %>]', ['Company Employee ID Card'=>'Company Employee ID Card','Voter Photo ID'=>'Voter Photo ID','Driving License'=>'Driving License','Passport'=>'Passport'], null,['class'=>'form-control']) !!}
                        <label class="file" class="form-control">
                                <input type="file" name="doc[<% $index + 1 %>]" id="file">
                                <span class="file-custom"></span>
                        </label>
                    </div>
                     
                </div>    
                <div class="form-group form-inline">
                    <div class="row">
                      <div class="col-md-4"> 
                        {!! Form::label('HOD', 'Approval:') !!}
                        {!! Form::select('hod_id', $hods, null, ['class'=>'form-control']) !!}
                      </div>
                    </div>
                </div>
                
                 <div class="form-group">
                 <div class="row">
                    <div class="col-md-2">
                    {!! Form::submit('Submit Booking', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                </div>
                
                {!! Form::close() !!}
            </div>
            <script>
            $(document).ready(function() {             
             $('#check_in_date').datetimepicker({
                    format: "YYYY/MM/DD hh:mm:ss",
              });
             $('#check_out_date').datetimepicker({
                    format: "YYYY/MM/DD hh:mm:ss",
              });
            });
         </script>
        </div>
    </div>
</div>
</div>
@stop