@extends('admin.base')
@section('content')
    <style>
        .layui-upload-img{width: 150px; height: 150px; margin: 0 0 10px 65px;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;}
        #uploadText{text-align: center;color: #666666;font-size: 12px;}
    </style>

    <body class="body">
    <form class="layui-form layui-form-pane" method="" action="">
        {{ csrf_field() }}

        <div class="layui-upload">
            <div class="layui-upload-list">
                <img class="layui-upload-img" id="demo1" style="background-color: #c2c2c2;">
                <p id="uploadText"></p>
            </div>
            <button type="button" class="layui-btn" id="uploadBtn" style="margin-left: 95px;">上传头像</button>
            <button class="layui-btn" id="saveBtn" lay-submit="" lay-filter="submit" style="margin-left: 95px;display: none;">保&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;存</button>
            <input type="hidden" name="fid" lay-verify="uploadFile" value="">
            <input type="hidden" name="furl" value="">
        </div>
    </form>
    </body>
@endsection
@section('script')
    <script type="text/javascript">
        layui.use(['form', 'layedit', 'laydate', "upload"], function(){
            var form = layui.form;
            var layer = layui.layer;
            var layedit = layui.layedit;
            var laydate = layui.laydate;
            var upload = layui.upload;

            // 数据验证
            form.verify({
                uploadFile: function(value){
                    if(value.length < 1){
                        return '请上传头像';
                    }
                }
            });

            // 监听提交
            form.on('submit(submit)', function(data){
                var submitThis = $(this);
                submitThis.attr('disabled', true);
                // 提交数据
                $.ajax({
                    url: '{{ route('admin.user.userChangeHeaderSubmit') }}',
                    type: 'post',
                    dataType: 'json',
                    data: {'data' : JSON.stringify(data.field)},
                    success: function (d) {
                        if (d.status == 1) {
                            layer.msg(d.msg, {time: 2000}, function () {
                                $(parent.document).find("img.login-user-header").attr('src', $("input[name='furl']").val());
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

            //普通图片上传
            var token = $("[name='_token']").val();
            var uploadInst = upload.render({
                elem: '#uploadBtn',
                url: '{{ route('uploadFile') }}',
                data:{
                    '_token':token
                },
                before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                },
                done: function(res){
                    if (res.status == 1) {
                        layer.msg('上传成功');
                        $("#uploadBtn").hide();
                        $("#saveBtn").show();
                        $("input[name='fid']").val(res.data.fid);
                        $("input[name='furl']").val(res.data.url);
                    } else {
                        layer.msg('上传失败');
                        $("#uploadText").html("上传失败");
                    }
                },
                error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#uploadText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
    </script>
@endsection