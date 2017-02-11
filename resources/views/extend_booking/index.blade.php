@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h4>Book Guest House</h4></div>
                    <div class="panel-body">
                        <br>
                        <br>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @include('flash::message')
                                <div class="form-group form-inline">
                                    {!! Form::open(['method' => 'POST','files'=>true,'route'=>['extend_booking.store']]) !!}
                                    {!! Form::hidden('booking_requests_id',$id->id) !!}
                                    {!! Form::Label('extend days', 'Extend Days:') !!}
                                    {!! Form::hidden('status',$id->status) !!}
                                    {!! Form::select('extend_days',[''=>'Select',1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10],null,['class'=>'form-control'])!!}
                                    {!! Form::submit('Submit', ['class'=>'form-control bt btn-primary'])!!}

                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
