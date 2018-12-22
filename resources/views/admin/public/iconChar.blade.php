@extends('admin.base')
@section('content')
<link rel="stylesheet" href="{{ asset('css/iconChar.css') }}">

<body class="body">
    <div class="ly-div-ul">
        <ul class="site-doc-icon">
            @forelse($list as $item)
                <li>
                    @if($item['name'] == 'loading')
                        <i class="layui-icon {{ $item['font_class'] }} layui-icon layui-anim layui-anim-rotate layui-anim-loop"></i>
                    @else
                        <i class="layui-icon {{ $item['font_class'] }}"></i>
                    @endif
                    <div class="doc-icon-name">{{ $item['name'] }}</div>
                    <div class="doc-icon-code">{{ str_replace('&','&amp;',$item['code']) }}</div>
                    <div class="doc-icon-fontclass">{{ $item['font_class'] }}</div>
                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                </li>
            @empty
                <li>暂无数据</li>
            @endforelse
        </ul>
    </div>
</body>
@endsection
@section('script')
<script type="text/javascript">
    layui.use(['element', 'layer'], function () {
        var element = layui.element;
        var layer = layui.layer;

        add_btn();
    });

    /*
     * 添加确认按钮，初始化其它内容
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     */
    function add_btn() {
        // 添加确认按钮
        $('.body').prepend('<div class="ly-div-btn"><button class="layui-btn layui-btn-fluid" onclick="submit();">确认</button></div>');
        $('.ly-div-ul').addClass('ly-div-ul-top');

        // （初始化操作）在所有 li 元素下添加单选框
        $('.ly-div-ul ul li').each(function () {
            $(this).prepend('<i class="layui-icon ly-radio layui-icon-circle"></i>');
        });

        // 点击选中事件（单选）
        $('.ly-div-ul ul li').on('click', function () {
            $(this).siblings().find('.ly-radio').removeClass('layui-icon-radio').addClass('layui-icon-circle');
            $(this).find('.ly-radio').addClass('layui-icon-radio');
            $(this).find('.ly-radio').addClass('layui-icon-radio');
        });
    }

    /*
     * 确认按钮点击
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     */
    function submit() {
        var code = ''; // 字体图标编码
        var id = ''; // 字体图标id

        $('.ly-div-ul ul li').each(function () {
            var selected = $(this).find('.ly-radio.layui-icon-radio');

            if (selected.length == 1) { // 获取到选中内容，结束遍历
                code = selected.siblings('div .doc-icon-code').html(); // 获取字符图标编码
                code = code.replace('amp;',''); // 字符替换
                id = selected.siblings('input[name="id"]').val(); // 字体图标id
                return false;
            }
        });

        if (code == '' && id == '') {
            layer.msg('请选择图标样式！');
            return false;
        }

        // 向父页面传值
        send_value_to_parent(code, id);
    }

    /*
     * 向父页面传值
     * 父页面：admin/leftNavEdit
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     */
    function send_value_to_parent(v, id) {
        parent.set_icon_value(v, id); // 调用父页面的函数

        // 关闭当前页面
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
</script>
@endsection
