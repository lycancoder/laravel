<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>罗盘时钟</title>

    <link rel="stylesheet" href="{{ asset('css/time_compass.css') }}">

</head>
<body>

<div id="clock"></div>

<div id="foot" style="z-index: 999;position: fixed;bottom: 0;left: 0;width: 100%;display: none;">
    <div style="width:300px;margin:0 auto; padding:20px 0;">
        <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=50010602501715" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;">
            <img src="{{ asset('img/police.png') }}" style="float:left;"/>
            <p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">渝公网安备 50010602501715号</p>
        </a>
    </div>
</div>

<script src="{{ asset('js/time_compass.js') }}"></script>

</body>
</html>
