<html>
<body>    
    <p>Dear Sir/Madam</p>
    @if($request->status == 1)
        <p>Please check new guest house booking request details and click on accept/reject link for further approval.</p>
        <p>Please check  details and click on accept link for further approval.</p>

        <p>Click Here: <a href="{{$links['accept']}}">Accept</a>/<a href="{{$links['reject']}}">Reject</a></p>
        <table border="1" style='border-collapse: collapse'>
            <tr>
                <td width="50%">No. Extend days</td><td width="50%">{{$request->extend_days}}</td>
            </tr>
        </table>


    @elseif($request->status == 2)
        <table border="1" style='border-collapse: collapse'>
            <tr>
                <td width="50%">No. Extend days</td><td width="50%">{{$request->extend_days}}</td>
            </tr>
        </table>

    @elseif($request->status == 3)
        <p>We are Sorry no rooms are available</p>
    @endif


        <p></p>
    <p><strong>Guest Infomation:</strong></p>
    <p>Thank You</p>
    <p>HZL Team</p>
</body>
</html>
