@extends('admin.base')
@section('content')
<body class="login-body body" onkeypress="return f_keyword_click(event, '#sub')">
    <div class="login-box">
        <form class="layui-form layui-form-pane" method="post" action="{{ route('admin.index.checkLogin') }}">
            {{ csrf_field() }}
            <div class="layui-form-item">
                <h3>数据管理平台</h3>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">账号：</label>
                <div class="layui-input-inline">
                    <input type="text" name="account" value="{{ old('account') }}" class="layui-input"
                           lay-verify="account" placeholder="邮箱或手机号码" autocomplete="on" maxlength="20"/>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码：</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" class="layui-input" lay-verify="password"
                           placeholder="密码" maxlength="20"/>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">验证码：</label>
                <div class="layui-input-inline">
                    <input style="float: left;width: 5.9rem;" type="text" name="code" class="layui-input"
                           onkeyup="this.value=this.value.replace(/\D/g,'')" lay-verify="code"
                           placeholder="验证码" maxlength="4"/>
                    <img style="float: left;" title="点击切换验证码"
                         onclick="javascript:this.src='{{ route('admin.public.captcha') }}'"
                         src="{{ route('admin.public.captcha') }}">
                </div>
            </div>
            <div class="layui-form-item">
                <button type="reset" class="layui-btn layui-btn-danger btn-reset">重置</button>
                <button type="button" class="layui-btn btn-submit" lay-submit="" lay-filter="sub" id="sub">立即登录</button>
            </div>
        </form>
    </div>
</body>
@endsection
@section('script')
<script type="text/javascript">
    layui.use(['form','layer'], function () {
        var form = layui.form;
        var $ = layui.jquery;

        // 验证
        form.verify({
            account: function (value) {
                if (value == "") {
                    return "请输入账号";
                }
            },
            password: function (value) {
                if (value == "") {
                    return "请输入密码";
                }
            },
            code: function (value) {
                if (value == "") {
                    return "请输入验证码";
                }
            }
        });

        // 提交监听
        form.on('submit(sub)', function (data) {
            /*layer.alert(JSON.stringify(data.field), {
                title: '最终的提交信息'
            });
            return false;*/
            $('form').submit();
        });

        // you code ...
    });
</script>
@endsection