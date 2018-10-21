<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="We started in 2016 our journey with our first product ConsulTrust, a mobile application running smoothly in iOS, Android with an amazing backend web application. Our consultants are increasing every day and full trust from our customers. With our development methodology and experience we will be able to support your business, offer you innovative solutions."
          name="description"/>
    <meta content="HUD Systems" name="author"/>
    <style>
        /*important for arabic*/
        body {
            font-family: DejaVu Sans;
        }
    </style>
    <style>
        /*table style*/
        .tr-margin{
            margin: 5px;
        }
    </style>
    <style>
        /*general style*/
        .heavy-font{
            font-weight: bold;
        }
        .full-width{
            width: 100%;
        }
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
<header class="full-width text-center">
    <h4 class="heavy-font">Medical Report</h4>
</header>
<table>
    @foreach($answers as $answer)
        <tr class="tr-margin">
            <td colspan="2">{{ $answer->title_en }} :</td>
            <td colspan="2">{{ $answer->answer }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>