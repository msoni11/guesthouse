@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Pending Guest's Actual Check In</h4></div>   
                <div class="panel-body">
                   <table class="table table-hover table-striped table-bordered table-responsive">
                   <thead>
                    <tr >
                        <th>Id</th>
                        <th>Name</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Address</th>                     
                        <th>Document Attached</th>
                        <th>Document picture</th>
                        <th>finger Print</th>
                        <th>Photo</th>
                        <th>Check In Date</th>
                        <th>Check Out Date</th>
                        <th colspan="3">Actions</th>
                    </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($guest_info as $guest)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $guest->name }}</td>
                         <td>{{ $guest->contact_no }}</td>
                         <td>{{ $guest->email }}</td>
                         <td>{{ $guest->address }}</td>
                         <td>{{ $guest->document_type }}</td>
                         <td>@if($guest->doc)
                              <a href="{{ url('/uploads/'.$guest->doc) }}">View</a>
                              @endif
                         </td>
                         <td>
                             @if($guest->finger_print)
                             <a href="{{ url('/uploads/'.$guest->finger_print) }}">View</a>
                             @endif
                         </td>
                         <td>@if($guest->guest_photo ) 
                             <a href="{{ $guest->guest_photo }}"> View </a>
                             @endif
                         </td>
                         <td>{{ $guest->check_in_date }}</td>
                         <td>{{ $guest->check_out_date }}</td>
                         <td><a href="{{url('guest_info',$guest->id)}}" class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span></a></td>
                         <td><a href="{{route('guest_info.edit',$guest->id)}}" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a></td>
                         <td>
                          @if($guest->doc && $guest->finger_print && $guest->guest_photo)
                         <form action="{{ url('/guest_info/updatecheckin') }}" method="GET">
                          <?php echo method_field('PUT'); ?>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                          <input type="hidden" name="guest_room_allotment_id" value="{{ $guest->guest_room_allotment_id }}">  
                                  {!! Form::submit('Check In Now', ['class' => 'btn btn-primary form-control']) !!}
                         </form>
                          @else 
                          Please attach documents before check in.
                         @endif
                         </td>
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {!! $guest_info->links() !!}
                </div>
            </div>
        </div>     
    </div> 
</div>

@endsection
