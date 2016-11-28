@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Guest Check In & Out Detail</div>
            <div class="panel-body">
                <form class="form-horizontal">
                @foreach ($guestroomallotment as $guestroom)    
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Guest Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" placeholder="{{$guestroom->name}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="room_no" class="col-sm-2 control-label">Room No</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="room_no" placeholder="{{$guestroom->room_no}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="room_type" class="col-sm-2 control-label">Room Type</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="room_type" placeholder="{{$guestroom->room_type}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="check_in_date" class="col-sm-2 control-label">Check In Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="check_in_date" placeholder="{{$guestroom->check_in_date}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="check_out_date" class="col-sm-2 control-label">Check Out Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="check_out_date" placeholder="{{$guestroom->check_out_date}}" readonly>
                    </div>
                </div>
                @endforeach
                <hr>
                @if($foods)
                <?php $total_price = 0; ?>
                 <table class="table table-hover table-striped table-bordered table-responsive">
                    <tr>
                        <th>Food Item Name</th>
                        <th>Food Quantity</th>
                        <th>Food Price(per Unit)</th>
                    </tr>
                    
                @foreach($foods as $food)
                <tr>
                    <td>{{$food->name}}</td>
                    <td>{{$food->quantity}}</td>
                    <td>{{$food->price}}</td>
                <div style="display:none"> {!! $total_price += ($food->quantity*$food->price) !!}</div>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><strong>Total</strong>(in Rs)</td>
                    <td>{{$total_price}}</td>
                </tr>
                </table>
                @endif
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{ url('/guest_info/pending')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <hr>
            </form>                
            </div>
        </div>
    </div>
</div>
@stop