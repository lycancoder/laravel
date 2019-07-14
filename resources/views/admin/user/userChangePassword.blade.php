@extends('admin.base')

@section('content')
<body class="body">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>修改密码</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" method="" action="">
        {{ csrf_field() }}

        <div class="layui-form-item">
            <label class="layui-form-label">原密码</label>
            <div class="layui-input-block">
                <input type="password" name="oldPassword" lay-verify="required" autocomplete="off" class="layui-input" value="">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">新密码</label>
            <div class="layui-input-block">
                <input type="password" name="newPassword" lay-verify="newPassword" autocomplete="off" class="layui-input" value="">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">确认新密码</label>
            <div class="layui-input-block">
                <input type="password" name="surePassword" lay-verify="surePassword" autocomplete="off" class="layui-input" value="">
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

        // 数据验证
        form.verify({
            newPassword: function(value){
                var oldPassword = $('input[name="oldPassword"]').val();
                if(value.length < 6){
                    return '密码至少得6个字符';
                }
                if (value == oldPassword) {
                    return '不能与原密码一致';
                }
            },
            surePassword: function(value){
                var newPassword = $('input[name="newPassword"]').val();
                if (value != newPassword) {
                    return '两次密码不一致';
                }
            }
        });

        // 监听提交
        form.on('submit(submit)', function(data){
            var submitThis = $(this);
            submitThis.attr('disabled', true);
            // 提交数据
            $.ajax({
                url: '{{ route('admin.user.userChangePasswordSubmit') }}',
                type: 'post',
                dataType: 'json',
                data: {'data' : JSON.stringify(data.field)},
                success: function (d) {
                    if (d.code == 0) {
                        layer.msg(d.msg + ' 请重新登录', {time: 2000}, function () {
                            parent.location.href = "{{ route('admin.index.logout') }}";
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
</script>
@endsection
