@extends('admin.base')
@section('content')
<style>
    .ly-label {position: relative;}
    .ly-label i {position: absolute;top: 0;right: 0;color: #a0a0a0;cursor: pointer;}
</style>

<body class="body">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>菜单编辑</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" method="" action="">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $data['id'] ?? '' }}">
        <input type="hidden" name="parent_id" value="{{ $data['parent_id'] ?? $parent_id }}">

        <div class="layui-form-item">
            <label class="layui-form-label">菜单名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" autocomplete="off" placeholder="示例：菜单编辑页面" class="layui-input" value="{{ $data['title'] }}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label ly-label">菜单路由 <i class="layui-icon" title="一级菜单可为空，如果是外部链接，请添加 http:// 或 https://">&#xe702;</i></label>
            <div class="layui-input-block">
                <input type="text" name="url" lay-verify="" placeholder="示例：leftNavEdit" autocomplete="off" class="layui-input" value="{{ $data['url'] }}">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">菜单图标</label>
                <div class="layui-input-inline layui-input" style="width: 60px;">
                    <i class="layui-icon ly-icon" style="font-size: 26px;">{{ $data['code'] ? $data['code'] : '&#xe655;' }}</i>
                    <input type="hidden" name="icon" value="{{ $data['icon_id'] ? $data['icon_id'] : 110 }}">
                </div>
                <input type="button" class="layui-btn layui-btn-normal" onclick="show_icon();" value="选择">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">同级排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" lay-verify="required" placeholder="值越小越靠前（输入正整数）" autocomplete="off" class="layui-input" value="{{ $data['sort'] ?? 1 }}">
            </div>
        </div>

        <div class="layui-form-item" pane="">
            <label class="layui-form-label">新窗口打开</label>
            <div class="layui-input-block">
                <input type="checkbox" name="target" lay-skin="switch" lay-filter="switchTarget" lay-text="是|否" {{ $data['target'] == 1 ? 'checked' : '' }} value="{{ $data['target'] ?? 2 }}">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">启用/停用</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-filter="switchStatus" lay-text="启用|停用" {{ $data['status'] == 2 ? '' : 'checked' }} value="{{ $data['status'] ?? 1 }}">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</body>
@endsection
@section('script')
<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form;
        var layer = layui.layer;
        var layedit = layui.layedit;
        var laydate = layui.laydate;

        // 监听 新窗口 开关
        form.on('switch(switchTarget)', function(data){
            $('[name="target"]').val(this.checked ? '1' : '2')
        });

        // 监听 启用/停用 开关
        form.on('switch(switchStatus)', function(data){
            $('[name="status"]').val(this.checked ? '1' : '2')
        });

        // 监听提交
        form.on('submit(submit)', function(data){
            var submitThis = $(this);
            submitThis.attr('disabled', true);
            // 提交数据
            $.ajax({
                url: '{{ route('admin.nav.leftNavEditSubmit') }}',
                type: 'post',
                dataType: 'json',
                data: {'data' : JSON.stringify(data.field)},
                success: function (d) {
                    if (d.code == 0) {
                        layer.msg(d.msg, {time: 2000}, function () {
                            // 关闭当前页面
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        });
                    } else {
                        submitThis.attr('disabled', false);
                        layer.msg(d.msg);
                    }
                }
            });

            return false; // 作用：禁止数据回调后快速刷新页面
        });
    });

    /*
     * 显示图标样式，点击 选择 调用
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     */
    function show_icon() {
        layer.open({
            type: 2, // 类型
            shade: 0.5, // 遮罩
            maxmin: true, // 最大最小化
            title: '字体图标', // 标题
            area: ['710px', '450px'], // 宽高
            content: '{{ route('admin.public.iconChar') }}' // 内容
        });
    }

    /*
     * 接收子页面返回的值，并做相关处理
     * 子页面：admin/iconChar
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     */
    function set_icon_value(v, id) {
        $('[name="icon"]').val(id);
        $('.ly-icon').html(v);
    }
</script>
@endsection