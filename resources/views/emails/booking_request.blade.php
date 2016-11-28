<html>
<body>    
    <p>Dear Sir/Madam</p>
    <p>Please check new guest house booking request details and click on accept/reject link for further approval.</p>
    <p>Click Here: <a href="{{$links['accept']}}">Accept</a>/<a href="{{$links['reject']}}">Reject</a></p>
    <table border="1" style='border-collapse: collapse'>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">No. of visitors</td><td width="50%">{{$booking_request->no_of_visitors}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">No. of rooms required</td><td width="50%">{{$booking_request->required_room}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Type of Guest</td><td width="50%">{{$booking_request->type_of_guest}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Check In Date</td><td width="50%">{{$booking_request->check_in_date}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Check Out Date</td><td width="50%">{{$booking_request->check_out_date}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Food Order</td><td width="50%">@if($booking_request->food_order)
                            @foreach($booking_request->food_order as $food) 
                            {{ ucfirst($food) }}
                            @endforeach
                        @endif </td>
        </tr>
         <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Org Name & Address</td><td width="50%">{{$booking_request->org_name_address	}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Purpose</td><td width="50%">{{$booking_request->purpose}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Remark</td><td width="50%">{{$booking_request->remark}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Request By</td><td width="50%">{{$users->name}}</td>
        </tr>
        <tr border="1">
            <td width="50%">Status</td><td width="50%">{{ $booking_request->status==2?'Pending':'' }} {{ $booking_request->status==1?'Accept':'' }} {{ $booking_request->status==0?'Reject':'' }}</td>
        </tr>
    </table>
    <p></p>
    <p><strong>Guest Infomation:</strong></p>
    <table border="1" style='border-collapse: collapse'>
        <tr border="1" style='border-collapse: collapse'>
            <th>Guest Name</th><th>Contact No</th><th>Email</th><th>Address</th><th>Attached Document Type</th>
        </tr>
        @foreach($guest_info as $guest)
            <tr border="1" style='border-collapse: collapse'>
                <td>{{$guest->name}}</td><td>{{$guest->contact_no}}</td><td>{{$guest->email}}</td><td>{{$guest->address}}</td><td>{{$guest->document_type}}</td>
            </tr>
        @endforeach
    </table>
    <p>Thank You</p>
    <p>HZL Team</p>
</body>
</html>
