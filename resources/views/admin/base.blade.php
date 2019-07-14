<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>数据管理平台</title>

    <link rel="stylesheet" href="{{ asset('plugs/layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layui-admin.css') }}">
    <link rel="icon" href="{{ asset('img/code.png') }}">

    @yield('css')
</head>

{{-- body内容 --}}
@yield('content')

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/lyite-sign.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/lyite-package.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/public.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugs/layui/layui.js') }}"></script>
<script>
    layui.use(['element','form','layer','table','upload','laydate','layedit'], function(){
        var element = layui.element;
        var form = layui.form;
        var layer = layui.layer;
        var table = layui.table;
        var upload = layui.upload;
        var laydate = layui.laydate;
        var layedit = layui.layedit;

        // 成功提示
        @if(session('msg'))
            layer.msg("{{ session('msg') }}");
        @endif

        // 错误提示
        @if($errors->any())
            @foreach($errors->all() as $error)
                layer.msg("{{ $error }}");
                @break
            @endforeach
        @endif
    });

    // ajax请求头
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@yield('script')

</html>