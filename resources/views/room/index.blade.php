@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Room</h4></div>   
                <div class="panel-body">
                    <a href="{{url('/room/create')}}" class="btn btn-success">Add Room</a>
                    <br>
                    <br>
                     
                    <table class="table table-striped table-bordered table-responsive">
                    <thead>
                    <tr >
                     <th>Id</th>
                     <th>Room No</th>
                     <th>Room Type</th>
                     <th>Description</th>
                     <th>Capacity</th>
                     <th>Guest House</th>
                     <th>Status</th>
                     <th colspan="3">Actions</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($rooms as $room)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $room->room_no }}</td>
                         <td>{{ $room->room_type }}</td>
                         <td>{{ $room->description }}</td>
                         <td>{{ $room->capacity }}</td>
                         <td>{{ $room->guest_house_name }}</td>
                         <td>{{ $room->status?'Active':'In Active' }}</td>
                         <td><a href="{{url('room',$room->id)}}" class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span></a></td>
                         <td><a href="{{route('room.edit',$room->id)}}" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a></td>
                         <td>
                         {!! Form::open(['method' => 'DELETE', 'route'=>['room.destroy', $room->id]]) !!}
                         <button class="btn btn-danger">
                             <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                         </button>
                         {!! Form::close() !!}
                         </td>
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {!! $rooms->links() !!}
                </div>
            </div>
        </div>     
    </div> 
</div>

@endsection
