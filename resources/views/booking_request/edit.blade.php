@extends('layouts.app')
@section('content')
<div class="container" ng-app='guest_house'>
    <div class="row" ng-controller="guestCtr" >
        <div class="panel panel-default">
            <div class="panel-heading panel-default">Update Booking Request</div>
            <div class="panel-body">
               
                <?php $food_order_list = array('break-fast', 'lunch', 'dinner'); ?>
 
               
                {!! Form::model($booking_request,['method' => 'PATCH', 'files'=>true, 'route'=>['booking_request.update',$booking_request->id]]) !!}
                
                <div class="form-group" ng-init="init({!! $booking_request->no_of_visitors !!})">
                    {!! Form::label('No. of visitors', 'No. of visitors:') !!}
                    {!! Form::select('no_of_visitors', [''=>'Select', 1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10],null,['class'=>'form-control', 'ng-model'=>'no_of_visitors', 'ng-change'=>'changeVisitors()']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('No. of rooms required', 'No. of rooms required:') !!}
                    {!! Form::text('required_room',null,['class'=>'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('Type of Guest', 'Type of Guest:') !!}
                    {!! Form::text('type_of_guest',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Check In Date', 'Check In Date:') !!}
                    {!! Form::text('check_in_date',null,['class'=>'form-control', 'id'=>'check_in_date', 'style'=>'position: relative', 'data-format'=>'yyyy/MM/dd hh:mm:ssZ']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Check Out Date', 'Check Out Date:') !!}
                    {!! Form::text('check_out_date',null,['class'=>'form-control', 'id'=>'check_out_date', 'style'=>'position: relative', 'data-format'=>'yyyy/MM/dd hh:mm:ssZ']) !!}
                </div>
                 
                <div class="form-group">
                    {!! Form::label('Food Order', 'Food Order:') !!}
                    @foreach($food_order_list as $food)
                    {!! Form::checkbox('food_order[]', $food, in_array($food, $food_order_list),['class'=>'']) !!}{!! Form::label('', $food) !!}
                    @endforeach
                </div>
                
                <div class="form-group">
                    {!! Form::label('Purpose', 'Purpose:') !!}
                    {!! Form::textarea('purpose',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Remark', 'Remark:') !!}
                    {!! Form::textarea('remark',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::hidden('request_by', Auth::user()->id, null, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::hidden('status',2,null,['class'=>'form-control']) !!}
                </div>
                
                <div style="display:none">{!! $index =0 !!}</div>
                @foreach($guest_info as $guest)
                <div class="form-group form-inline">
                        {!! $index = $index + 1 !!})
                        {!! Form::hidden('guest_id[]',$guest->id, null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Name', 'Guest Name:') !!}
                        {!! Form::text('name[]',$guest->name, null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Contact No', 'Guest Contact No:') !!}
                        {!! Form::text('contact_no[]',$guest->contact_no,null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Email', 'Guest Email:') !!}
                        {!! Form::text('email[]',$guest->email, null,['class'=>'form-control']) !!}
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
                @endforeach
                <div ng-repeat="n in [] | range:no_of_visitors - {!! $booking_request->no_of_visitors !!}">
                    <div class="form-group form-inline">
                        <% $index + {!! $booking_request->no_of_visitors !!} + 1 %>)
                        {!! Form::label('Guest Name', 'Guest Name:') !!}
                        {!! Form::text('name[]', null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Contact No', 'Guest Contact No:') !!}
                        {!! Form::text('contact_no[]',null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Email', 'Guest Email:') !!}
                        {!! Form::text('email[]', null,['class'=>'form-control']) !!}
                         {!! Form::label('Guest Address', 'Guest Address:') !!}
                        {!! Form::text('address[<% $index + 1 %>]',null,['class'=>'form-control']) !!}
                    </div>
                     <div class="form-group form-inline">
                        {!! Form::label('Attach Document', 'Attach Document:') !!}
                        {!! Form::select('document_type[<% $index + 1 %>]', ['Company Employee ID Card','Voter Photo ID','Driving License','Passport'], null,['class'=>'form-control']) !!}
                        <label class="file" class="form-control">
                                <input type="file" name="doc[<% $index + 1 %>]" id="file">
                                <span class="file-custom"></span>
                        </label>
                    </div>
                    
                </div>
                <div class="form-group">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
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
@stop