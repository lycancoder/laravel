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

        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="name" autocomplete="off" placeholder="" class="layui-input" value="{{ $data['name'] }}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">用户组</label>
            <div class="layui-input-block">
                <select name="g_id" lay-filter="" lay-verify="required">
                    <option value=""></option>
                    @foreach($group as $k)
                        <option value="{{ $k['id'] }}" @if($k['id'] == $data['g_id']) selected @endif>{{ $k['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label ly-label">邮箱 <i class="layui-icon" title="邮箱填写后不可更改">&#xe702;</i></label>
            <div class="layui-input-block">
                <input type="text" name="email" lay-verify="email" placeholder="邮箱填写后不可更改" autocomplete="off" class="layui-input" value="{{ $data['email'] }}" @if($data['email']) readonly @endif>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label ly-label">手机号码 <i class="layui-icon" title="手机号码填写后不可更改">&#xe702;</i></label>
            <div class="layui-input-block">
                <input type="text" name="phone" lay-verify="phone" placeholder="手机号码填写后不可更改" autocomplete="off" class="layui-input" value="{{ $data['phone'] }}" @if($data['phone']) readonly @endif>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" lay-verify="required" placeholder="值越小越靠前（输入正整数）" autocomplete="off" class="layui-input" value="{{ $data['sort'] ?? 1 }}">
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

            // 监听 启用/停用 开关
            form.on('switch(switchStatus)', function(data){
                $('[name="status"]').val(this.checked ? '1' : '2')
            });

            // 数据验证
            form.verify({
                name: function(value){
                    if(value.length < 2){
                        return '用户名至少得2个字符';
                    }
                },
                email: function(value){
                    if (value.length > 0 && !f_verify_email(value)) {
                        return '邮箱地址不合法';
                    }
                },
                phone: function (value) {
                    if (value.length == 0 || !f_verify_phone(value)) {
                        return '手机号码不合法';
                    }
                }
            });

            // 监听提交
            form.on('submit(submit)', function(data){
                var submitThis = $(this);
                submitThis.attr('disabled', true);
                // 提交数据
                $.ajax({
                    url: '{{ route('admin.user.userEditSubmit') }}',
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