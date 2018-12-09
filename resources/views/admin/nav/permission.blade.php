@extends('admin.base')
@section('content')
<style>
    .cate-box{margin-bottom: 15px;padding-bottom:10px;border-bottom: 1px solid #f0f0f0;}
    .cate-box dt{margin-bottom: 10px;}
    .cate-box dt .cate-first{padding:10px 20px;}
    .cate-box dd{padding:0 50px;}
    .cate-box dd .cate-second{margin-bottom: 10px;}
    .cate-box dd .cate-third{padding:0 40px;margin-bottom: 10px;}
</style>

<body class="body">
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-header layuiadmin-card-header-auto">
                <h2>组 【 <span style="color: #ff0000">{{ $userGroupInfo['name'] }}</span> 】 权限分配</h2>
            </div>
            <div class="layui-card-body">
                <form class="layui-form" method="" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="g_id" value="{{ $userGroupInfo['id'] }}">

                    @forelse($permissions as $first)
                        <dl class="cate-box">
                            <dt>
                                <div class="cate-first">
                                    <input type="checkbox" lay-skin="primary" name="permissions[]" id="menu{{ $first['id'] }}" title="{{ $first['title'] }}" value="{{ $first['id'] }}" @if(in_array($first['id'], $groupPermission)) checked @endif>
                                </div>
                            </dt>
                            @if(isset($first['_child']))
                                @foreach($first['_child'] as $second)
                                    <dd>
                                        <div class="cate-second">
                                            <input type="checkbox" lay-skin="primary" name="permissions[]" id="menu{{ $first['id'] }}-{{ $second['id'] }}" title="{{ $second['title'] }}" value="{{ $second['id'] }}" @if(in_array($second['id'], $groupPermission)) checked @endif>
                                        </div>
                                        @if(isset($second['_child']))
                                            <div class="cate-third">
                                                @foreach($second['_child'] as $three)
                                                    <input type="checkbox" lay-skin="primary" name="permissions[]" id="menu{{ $first['id'] }}-{{ $second['id'] }}-{{ $three['id'] }}" title="{{ $three['title'] }}" value="{{ $three['id'] }}" @if(in_array($three['id'], $groupPermission)) checked @endif>
                                                @endforeach
                                            </div>
                                        @endif
                                    </dd>
                                @endforeach
                            @endif
                        </dl>
                    @empty
                        <div style="text-align: center;padding:20px 0;">无数据</div>
                    @endforelse

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="submit">确 认</button>
                            <a href=""  class="layui-btn" >返 回</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection

@section('script')
<script type="text/javascript">
    layui.use(['element','form','layer','table','upload','laydate','layedit'], function(){
        var element = layui.element;
        var form = layui.form;
        var layer = layui.layer;
        var table = layui.table;
        var upload = layui.upload;
        var laydate = layui.laydate;
        var layedit = layui.layedit;


        form.on('checkbox', function (data) {
            var check = data.elem.checked;//是否选中
            var checkId = data.elem.id;//当前操作的选项框
            if (check) {
                //选中
                var ids = checkId.split("-");
                if (ids.length == 3) {
                    //第三级菜单
                    //第三级菜单选中,则他的上级选中
                    $("#" + (ids[0] + '-' + ids[1])).prop("checked", true);
                    $("#" + (ids[0])).prop("checked", true);
                } else if (ids.length == 2) {
                    //第二级菜单
                    $("#" + (ids[0])).prop("checked", true);
                    $("input[id*=" + ids[0] + '-' + ids[1] + "]").each(function (i, ele) {
                        $(ele).prop("checked", true);
                    });
                } else {
                    //第一级菜单不需要做处理
                    $("input[id*=" + ids[0] + "-]").each(function (i, ele) {
                        $(ele).prop("checked", true);
                    });
                }
            } else {
                //取消选中
                var ids = checkId.split("-");
                if (ids.length == 2) {
                    //第二级菜单
                    $("input[id*=" + ids[0] + '-' + ids[1] + "]").each(function (i, ele) {
                        $(ele).prop("checked", false);
                    });
                } else if (ids.length == 1) {
                    $("input[id*=" + ids[0] + "-]").each(function (i, ele) {
                        $(ele).prop("checked", false);
                    });
                }
            }
            form.render();
        });

        // 监听提交
        form.on('submit(submit)', function(data){
            /*layer.alert(JSON.stringify(data.field), {
                title: '最终的提交信息'
            });
            return false;*/

            // 提交数据
            //$('form').submit();

            // 提交数据
            $.ajax({
                url: '{{ route('admin.nav.saveUserGroupPermission') }}',
                type: 'post',
                dataType: 'json',
                data: {'data' : JSON.stringify(data.field)},
                success: function (d) {
                    if (d.status == 1) {
                        layer.msg(d.msg, {time: 2000}, function () {
                            // 关闭当前页面
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        });
                    } else {
                        layer.msg(d.msg);
                    }
                }
            });

            return false; // 作用：禁止数据回调后快速刷新页面
        });
    });
</script>
@endsection