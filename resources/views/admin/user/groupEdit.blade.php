@extends('admin.base')
@section('content')
    <body class="body">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>用户组编辑</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" method="" action="">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $data['id'] ?? '' }}">

        <div class="layui-form-item">
            <label class="layui-form-label">组名</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="示例：数据管理员" class="layui-input" value="{{ $data['name'] }}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">同级排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" lay-verify="required" placeholder="值越小越靠前（输入正整数）" autocomplete="off" class="layui-input" value="{{ $data['sort'] ?? 1 }}">
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

            // 监听提交
            form.on('submit(submit)', function(data){
                var submitThis = $(this);
                submitThis.attr('disabled', true);
                // 提交数据
                $.ajax({
                    url: '{{ route('admin.user.groupEditSubmit') }}',
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
    </script>
@endsection