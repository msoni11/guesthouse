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
                </form>
                <hr>
                @if($foods)
                <?php $total_price = 0; ?>
                 <table class="table table-hover table-striped table-bordered table-responsive">
                    <tr>
                        <th>Food Item Name</th>
                        <th>Food Quantity</th>
                        <th>Food Price(per Unit)</th>
                        <th colspan="2">Actions</th>
                    </tr>
                    
                @foreach($foods as $food)
                <tr>
                    <td>{{$food->name}}</td>
                    <td>{{$food->quantity}}</td>
                    <td>{{$food->price}}</td>
                    @if($guestroom->checked_in == 1)
                        <td>
                            <a href="{{route('foodserved.edit', array('id' => $food->id, 'guestroomallotmentid' => $guestroom->id))}}" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route'=>['foodserved.destroy', $food->id]]) !!}
                            {!! Form::hidden('guestroomallotmentid', $guestroom->id) !!}
                            <button class="btn btn-danger">
                                <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    @else
                        <td colspan="2"></td>
                    @endif
                <div style="display:none"> {!! $total_price += ($food->quantity*$food->price) !!}</div>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><strong>Total</strong>(in Rs)</td>
                    <td>{{$total_price}}</td>
                    <td colspan="2"></td>
                </tr>
                </table>
                @endif

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{ url('/guest_info/pending')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>

                @if($guestroom->checked_in == 1)
                    <div class="col-md-6">
                        <div id="my_camera"></div>
                        <form>
                            <input type=button value="Take Guest Photo Snapshot" onClick="take_snapshot()">
                        </form>
                    </div>

                {!! Form::open(['method' => 'PATCH', 'route'=>['guestroomallotment.update', $guestroom->id]]) !!}
                    <div class="col-md-6">
                        <div id="results">
                            @if(!$guest_info->guest_photo_checkout)
                                <img src="{{ $guest_info->guest_photo_checkout }}" width='240px' height='180px'><br>
                            @endif</div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                                {!! Form::hidden('set_date',1) !!}
                                {!! Form::hidden('check_out_date',date('Y-m-d H:i:i:s')) !!}
                                <input type="submit" class="btn btn-primary" value="Approve" />
                        </div>
                    </div>
                {!! Form::close() !!}
                @endif
                <hr>
            </div>
            @if($guestroom->checked_in == 1)
            <script language="JavaScript">
                Webcam.set({
                    width: 240,
                    height: 180,
                    image_format: 'jpeg',
                    jpeg_quality: 100,
                    upload_name: 'test',
                });
                Webcam.attach( '#my_camera' );
                function take_snapshot() {
                    // take snapshot and get image data
                    Webcam.snap( function(data_uri) {
                        // display results in page
                        document.getElementById('results').innerHTML =
                                '<img src="'+data_uri+'" name="guest_img"/><input type="hidden" value="'+data_uri+'" name="guest_photo_checkout"/>';

                    } );
                }
            </script>
            @endif
        </div>
    </div>
</div>
@stop