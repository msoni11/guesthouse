@extends('layouts.app')
@section('content')
<div class="container" ng-app='guest_house'>
    <div class="row" ng-controller="guestCtr">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Book Food Orders</div>
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
                {!! Form::open(['url' => 'food_booking', 'files'=>true]) !!}
                <div class="form-group form-inline">
                    <div class="row">
                    <div class="col-md-4">   
                    {!! Form::label('No. of visitors', 'No. of visitors:') !!}
                    {!! Form::select('no_of_visitors',[''=>'Select', 1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10],null,['class'=>'form-control', 'ng-model'=>'no_of_visitors', 'ng-change'=>'changeVisitors()']) !!}                   
                  </div>
                 <div class="col-md-4">       
                    {!! Form::label('No. of Food Items Required', 'No. of  Food Items Required:') !!}
                    {!! Form::text('quantity',null,['class'=>'form-control']) !!}
                </div>
                <div class="col-md-4"> 
                        {!! Form::label('Date', 'Date:') !!}
                        {!! Form::text('date',null,['class'=>'form-control', 'id'=>'check_in_date']) !!}
                    </div>
                </div>
                </div>    
                <div class="form-group form-inline">
                    <div class="row">
                  
                    <div class="col-md-4">
                        {!! Form::label('Food Order', 'Food Order:') !!}
                        {!! Form::radio('food_type[]','lunch',['class'=>'form-control']) !!}
                        {!! Form::label('', 'Lunch') !!}
                        {!! Form::radio('food_type[]','dinner',['class'=>'form-control']) !!}
                        {!! Form::label('', 'Dinner') !!}
                    </div>
                        
                   <div class="col-md-4"> 
                    {!! Form::label('Purpose', 'Purpose:') !!}
                    {!! Form::textarea('purpose',null,['class'=>'form-control', 'rows'=>2]) !!}
                    </div>
                </div>
                </div>
                <div class="form-group">
                    {!! Form::hidden('request_by',  Auth::user()->id, null, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::hidden('status',2,null,['class'=>'form-control']) !!}
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
                </div>    
                
                 <div class="form-group">
                 <div class="row">
                    <div class="col-md-2">
                    {!! Form::submit('Submit Order', ['class' => 'btn btn-primary form-control']) !!}
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