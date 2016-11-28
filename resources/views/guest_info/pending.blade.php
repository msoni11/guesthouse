@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Guest Room Allotment</h4></div>   
                <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('flash::message') 
                       {!! Form::model($search_form_data_arr, ['url' => '/guest_info/pending', 'method'=>'GET']) !!}
                       <div class="form-group form-inline">
                           {!! Form::Label('From Date', 'From Date:') !!}
                           {!! Form::text('from_date', null, ['class'=>'form-control', 'id'=>'from_date'])!!}
                      
                           {!! Form::Label('To Date', 'To Date:') !!}
                           {!! Form::text('to_date', null, ['class'=>'form-control', 'id'=>'to_date'])!!}       
                           
                           
                           {!! Form::Label('Status', 'Status:') !!}
                           {!! Form::select('status', [''=>'-Select-', 0=>'Pending Check In', 1=>' Checked In', 2=>'Checked out'],  null, ['class'=>'form-control', 'id'=>'to_date'])!!}  
                           
                           {!! Form::submit('Search', ['class'=>'form-control bt btn-primary'])!!}
                           
                           {!! Form::submit('Reset', ['class'=>'form-control bt btn-primary', 'name'=>'reset'])!!}
                           
                           <a href="{{url('/guest_info/pending')}}" class="btn btn-success">All Records</a>
                       </div>
                       {!! Form::close() !!}
                    </div>
                   </div>       
                
                <table class="table table-hover table-striped table-bordered table-responsive">
                        <thead>
                 <tr >
                     <th>Id</th>
                     <th>Name</th>
                     <th>Contact No</th>
                     <th>Email</th>
                     <th>Address</th>                     
                     <th>Document Attached</th>
                     <th>Photo</th>
                     <th>Finger Print ID </th>
                     <th>Room no</th>
                     <th>Check In Date</th>
                     <th>Check Out Date</th>
                     <th colspan="4">Actions</th>
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
                         <td>{{ $guest->document_type }}
                             @if($guest->doc)
                              - <a href="{{ url('/uploads/'.$guest->doc) }}">View</a>
                              @endif
                         </td>
                         
                         <td>
                             
                             @if($guest->guest_photo ) 
                             <a href="{{ $guest->guest_photo }}"> Guest photo </a>
                             @endif
                         </td>
                         
                        <td>
                            @if($guest->finger_print)
                             {{ $guest->finger_print }}
                             @endif
                        </td> 
                         
                         <td>
                             @if($guest->room_no ) 
                             <a href="{{ url('/room/'. $guest->room_id )}}"> {{ $guest->room_no }}</a>
                             @endif
                         </td>
                         
                         <td>{{ $guest->check_in_date }}</td>
                         <td>{{ $guest->check_out_date }}</td>
                         <td><a href="{{url('guest_info',$guest->id)}}" class="btn btn-primary">Details</a></td>
                         <td><a href="{{route('guest_info.edit',$guest->id)}}" class="btn btn-warning">Edit</a></td>

                         @if($guest->guest_room_allotment_id)
                         <td>
                           @if($guest->checked_in == 2)
                            <a href="{{route('guestroomallotment.show',$guest->guest_room_allotment_id)}}" class="btn btn-success "><span aria-hidden="true" class="glyphicon glyphicon-print"></span></a>                                  
                          @elseif($guest->checked_in == 1)                                      
                             {!! Form::open(['method' => 'PATCH', 'route'=>['guestroomallotment.update', $guest->guest_room_allotment_id]]) !!}   
                             {!! Form::hidden('set_date',1) !!}
                             {!! Form::hidden('check_out_date',date('Y-m-d H:i:i:s')) !!}
                             <button class="btn btn-primary">
                                 Check Out Now
                             </button>
                             {!! Form::close() !!}               
                          @else             
                             @if($guest->doc && $guest->finger_print && $guest->guest_photo)                                       
                             <form action="{{ url('/guest_info/updatecheckin') }}" method="GET">           
                             <?php echo method_field('PUT'); ?>
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                             <input type="hidden" name="guest_room_allotment_id" value="{{ $guest->guest_room_allotment_id }}">  
                                                {!! Form::submit('Check In Now', ['class' => 'btn btn-primary form-control']) !!}
                                       </form>
                                        @else 
                                        Attach Required documents.<a href="{{route('guest_info.edit',$guest->id)}}" class="btn btn-warning"> Click Here </a>
                                       @endif
                            @endif           
                         </td>
                         @else
                         <td>     
                         <a href="{{url('/guestroomallotment/create?guest_info_id='.$guest->id)}}" class="btn btn-success">Allocate Room</a>
                         </td>
                         @endif
                         @if($guest->checked_in == 1)
                         <td>   
                            <a href="{{url('/foodserved/create/?user_id=' . $guest->id)}}" class="btn btn-success">Add Food</a>     
                         </td>
                         @endif 
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {!! $guest_info->links() !!}
                </div>
            </div>
                 <script>
                    $(document).ready(function() {             
                     $('#from_date').datetimepicker({
                            format: "YYYY/MM/DD",
                      });
                     $('#to_date').datetimepicker({
                            format: "YYYY/MM/DD",
                      });
                    });
                 </script>
        </div>     
    </div> 
</div>

@endsection
