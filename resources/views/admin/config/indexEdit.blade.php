@extends('admin.base')
@section('content')
    <style>
        .ly-label {position: relative;}
        .ly-label i {position: absolute;top: 0;right: 0;color: #a0a0a0;cursor: pointer;}
    </style>

    <body class="body">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>用户组编辑</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" method="" action="">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $data['id'] ?? '' }}">

        <div class="layui-form-item">
            <label class="layui-form-label ly-label">键名 <i class="layui-icon" title="键名填写后不可更改，只能是字母和下划线组成，并且只能以字母开头和结尾，大于2个字符">&#xe702;</i></label>
            <div class="layui-input-block">
                <input type="text" name="key" lay-verify="key" autocomplete="off" placeholder="示例：VERSION" class="layui-input" value="{{ $data['key'] }}" @if($data['key']) readonly @endif>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">配置值</label>
            <div class="layui-input-block">
                <input type="text" name="value" lay-verify="value" autocomplete="off" placeholder="示例：1.0.0" class="layui-input" value="{{ $data['value'] }}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
                <input type="text" name="remark" autocomplete="off" placeholder="示例：版本号" class="layui-input" value="{{ $data['remark'] }}">
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
                key: function(value) {
                    if (value.length <= 2 || !f_verify_key(value)) {
                        return '配置键名输入有误';
                    }
                },
                value: function(value) {
                    if (value.length < 1) {
                        return '配置值不能为空';
                    }
                }
            });

            // 监听提交
            form.on('submit(submit)', function(data){
                var submitThis = $(this);
                submitThis.attr('disabled', true);
                // 提交数据
                $.ajax({
                    url: '{{ route('admin.config.configEditSubmit') }}',
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

        function f_verify_key(v) {
            let regex = /^(?!_)(?!.*?_$)[a-zA-Z_\u4e00-\u9fa5]+$/i;
            return regex.test(v); // 验证：true-正确；false-错误
        }
    </script>
@endsection