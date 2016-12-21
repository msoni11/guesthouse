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
                            {!! Form::select('no_of_visitors',[''=>'Select', 1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13,14=>14,15=>15,16=>16,17=>17,18=>18,19=>19,20=>20,21=>21,22=>22,23=>23,24=>24,25=>25,26=>26,27=>27,28=>28,29=>29,30=>30,31=>31,32=>32,33=>33,34=>34,35=>35,36=>36,37=>37,38=>38,39=>39,40=>40,41=>41,42=>42,43=>43,44=>44,45=>45,46=>46,47=>47,48=>48,49=>49,50=>50,51=>51,52=>52,53=>53,54=>54,55=>55,56=>56,57=>57,58=>58,59=>59,60=>60,61=>61,62=>62,63=>63,64=>64,65=>65,66=>66,67=>67,68=>68,69=>69,70=>70,71=>71,72=>72,73=>73,74=>74,75=>75,76=>76,77=>77,78=>78,79=>79,80=>80,81=>81,82=>82,83=>83,84=>84,85=>85,86=>86,87=>87,88=>88,89=>89,90=>90,91=>91,92=>92,93=>93,94=>94,95=>95,96=>96,97=>97,98=>98,99=>99,100=>100],null,['class'=>'form-control', 'ng-model'=>'no_of_visitors', 'ng-change'=>'changeVisitors()']) !!}
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
                        {!! Form::checkbox('food_type[]','lunch',null,['class'=>'form-control']) !!}
                        {!! Form::label('', 'Lunch') !!}
                        {!! Form::checkbox('food_type[]','dinner',null,['class'=>'form-control']) !!}
                        {!! Form::label('', 'Dinner') !!}
                        {!! Form::checkbox('food_type[]','breakfast',null,['class'=>'form-control']) !!}
                        {!! Form::label('','Breakfast') !!}
                    </div>

                        <div class="col-md-4">
                            {!! Form::label('Contact no','Contact no:') !!}
                            {!! Form::text('contact_no',null,['class'=>'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            {!! Form::label('Purpose', 'Purpose:') !!}
                            {!! Form::textarea('purpose',null,['class'=>'form-control', 'rows'=>2]) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group form-inline">
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::label('HOD', 'Approver:') !!}
                            {!! Form::select('hod_id', $hods, null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::hidden('request_by',  Auth::user()->id, null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::hidden('status',3,null,['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::submit('Submit Order', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                    </div>
                </div>
                
                {!! Form::close() !!}
            </div>
            <script>
            $(document).ready(function() {             
             $('#check_in_date').datetimepicker({
                    sideBySide: true,
                    minDate:new Date(),
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
</div>
</div>
@stop