<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="We started in 2016 our journey with our first product ConsulTrust, a mobile application running smoothly in iOS, Android with an amazing backend web application. Our consultants are increasing every day and full trust from our customers. With our development methodology and experience we will be able to support your business, offer you innovative solutions."
          name="description"/>
    <meta content="HUD Systems" name="author"/>
    <style>
        body {
            font-family: DejaVu Sans;
        }
    </style>
</head>
<body>
<table>
    @foreach($answers as $answer)
        <tr>
            <td>{{ $answer->title_en }}</td>
            <td>{{ $answer->answer }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>