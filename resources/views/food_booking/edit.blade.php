@extends('layouts.app')
@section('content')
<div class="container" ng-app='guest_house'>
    <div class="row" ng-controller="guestCtr" >
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Update Food Booking</div>
            <div class="panel-body">
               
                <?php $food_order_list = array('lunch', 'dinner'); ?>
 
               
                {!! Form::model($food_booking,['method' => 'PATCH', 'files'=>true, 'route'=>['food_booking.update',$food_booking->id]]) !!}
                
                <div class="form-group" ng-init="init({!! $food_booking->no_of_visitors !!})">
                    {!! Form::label('No. of visitors', 'No. of visitors:') !!}
                    {!! Form::select('no_of_visitors', [''=>'Select', 1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10],null,['class'=>'form-control', 'ng-model'=>'no_of_visitors', 'ng-change'=>'changeVisitors()']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('No. of Food Items Required', 'No. of Food Items Required:') !!}
                    {!! Form::text('quantity',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Date', 'Check In Date:') !!}
                    {!! Form::text('date',null,['class'=>'form-control', 'id'=>'check_in_date', 'style'=>'position: relative', 'data-format'=>'yyyy/MM/dd hh:mm:ssZ']) !!}
                </div>
                 
                <div class="form-group">
                    {!! Form::label('Food Order', 'Food Order:') !!}
                    @foreach($food_order_list as $food)
                    {!! Form::radio('food_type[]', $food, in_array($food, $food_order_list),['class'=>'']) !!}{!! Form::label('', $food) !!}
                    @endforeach
                </div>
                
                <div class="form-group">
                    {!! Form::label('Purpose', 'Purpose:') !!}
                    {!! Form::textarea('purpose',null,['class'=>'form-control']) !!}
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
                        {!! Form::text('address[]',null,['class'=>'form-control']) !!}
               </div>
                @endforeach
                <div ng-repeat="n in [] | range:no_of_visitors - {!! $food_booking->no_of_visitors !!}">
                    <div class="form-group form-inline">
                        <% $index + {!! $food_booking->no_of_visitors !!} + 1 %>)
                        {!! Form::label('Guest Name', 'Guest Name:') !!}
                        {!! Form::text('name[]', null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Contact No', 'Guest Contact No:') !!}
                        {!! Form::text('contact_no[]',null,['class'=>'form-control']) !!}
                        {!! Form::label('Guest Email', 'Guest Email:') !!}
                        {!! Form::text('email[]', null,['class'=>'form-control']) !!}
                         {!! Form::label('Guest Address', 'Guest Address:') !!}
                        {!! Form::text('address[]',null,['class'=>'form-control']) !!}
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

            });
         </script>
        </div>
    </div>
</div>    
@stop