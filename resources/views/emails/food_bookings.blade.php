<html>
<body>    
    <p>Dear Sir/Madam</p>
    <p>Please check new food booking request details and click on accept/reject link for further approval.</p>
    <p>Click Here: <a href="{{$links['accept']}}">Accept</a>/<a href="{{$links['reject']}}">Reject</a></p>
    <table border="1" style='border-collapse: collapse'>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">No. of visitors</td><td width="50%">{{$food_bookings->no_of_visitors}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">No. of Food Items Required</td><td width="50%">{{$food_bookings->quantity}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Date</td><td width="50%">{{$food_bookings->date}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Food Order</td><td width="50%">@if($food_bookings->food_type)
                            @foreach($food_bookings->food_type as $food) 
                            {{ ucfirst($food) }}
                            @endforeach
                        @endif </td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Purpose</td><td width="50%">{{$food_bookings->purpose}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Request By</td><td width="50%">{{$users->name}}</td>
        </tr>
        <tr border="1">
            <td width="50%">Status</td><td width="50%">{{ $food_bookings->status==3?'Pending from HOD':'' }}{{ $food_bookings->status==2?'Pending from owner':'' }} {{ $food_bookings->status==1?'Accept':'' }} {{ $food_bookings->status==0?'Reject':'' }}</td>
        </tr>
    </table>
    <p></p>
    {{--<p><strong>Guest Infomation:</strong></p>--}}
    {{--<table border="1" style='border-collapse: collapse'>--}}
        {{--<tr border="1" style='border-collapse: collapse'>--}}
            {{--<th>Guest Name</th><th>Contact No</th><th>Email</th><th>Address</th>--}}
        {{--</tr>--}}
        {{--@foreach($guest_info as $guest)--}}
            {{--<tr border="1" style='border-collapse: collapse'>--}}
                {{--<td>{{$guest->name}}</td><td>{{$guest->contact_no}}</td><td>{{$guest->email}}</td><td>{{$guest->address}}</td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
    {{--</table>--}}
    <p>Thank You</p>
    <p>HZL Team</p>
</body>
</html>
