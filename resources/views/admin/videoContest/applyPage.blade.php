@extends('admin.base')

@section('content')
<body class="body">
    <!-- 表格 -->
    <div id="dateTable" lay-filter="dateTable"></div>
</body>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/layui_admin.js') }}"></script>

<script type="text/html" id="barDemo">
    <button class="layui-btn layui-btn-xs layui-btn-normal" lay-event="detail">团队成员</button>
    <button class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</button>
</script>

<script type="text/html" id="toolbarDemo">
    <button class="layui-btn layui-btn-sm" lay-event="refreshData"><i class="layui-icon">&#xe666;</i> 刷新</button>
    <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="deletes"><i class="layui-icon">&#xe640;</i> 删除</button>
    <input class="layui-input" type="text" name="id" placeholder="参赛编号" style="height: 30px;display: inline-block;width: auto;">
    <input class="layui-input" type="text" name="phone" placeholder="报名电话" style="height: 30px;display: inline-block;width: auto;">
    <button class="layui-btn layui-btn-sm" lay-event="search"><i class="layui-icon">&#xe615;</i> 搜索</button>
</script>

<script type="text/javascript">
    // layui方法
    layui.use(['table', 'form', 'layer', 'vip_table'], function () {
        // 操作对象
        var table = layui.table;

        // 表格渲染
        var tableIns = table.render({
            elem: '#dateTable' //指定原始表格元素选择器（推荐id选择器）
            // ,height: vipTable.getFullHeight() //容器高度
            ,toolbar: '#toolbarDemo' //头部工具栏
            ,id: 'dataCheck'
            ,method: 'get'
            ,url: '{{ route('admin.videoContest.applyPageData') }}'
            ,cols: [[ //标题栏
                {checkbox: true, fixed: 'left', width: 50}
                , {title: '参赛编号',field: 'id', width: 100, sort: true, fixed: 'left'}
                , {field: 'team', title: '团队名称', width:200}
                , {field: 'number', title: '团队人数', width:100, sort: true}
                , {field: 'team_leader', title: '队长'}
                , {field: 'tel', title: '联系方式', width:150}
                , {field: 'phone', title: '报名电话', width:150}
                , {field: 'school', title: '学 校', width:300}
                , {field: 'major', title: '专 业', width:200}
                , {field: 'created_at', title: '报名时间', width:170}
                , {title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#barDemo'}
            ]]
            ,page: true //分页
            ,even: true //隔行背景
            ,loading: true //请求数据时，是否显示loading
            ,limits: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100]
            ,limit: 10 //默认采用10
            ,done: function (res, curr, count) {
                //如果是异步请求数据方式，res即为你接口返回的信息。
                //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                //curr即为当前页码、count即为数据总量
            }
        });

        // 监听行工具事件
        table.on('tool(dateTable)', function(obj){
            var data = obj.data;

            if(obj.event === 'detail'){ // 查看
                layer.open({
                    type: 2,
                    title: '参赛成员信息',
                    shadeClose: true,
                    shade: 0.2,
                    area: ['500px', '50%'],
                    content: '{{ route('admin.videoContest.memberPage') }}?id=' + data.id
                });
            } else if (obj.event === 'del') { // 删除
                layer.msg('您确定要删除所选数据？', {
                    time: false,
                    btn: ['确定', '取消'],
                    btnAlign: 'c',
                    btn1: function (index, layero) {
                        $.ajax({
                            url: '{{ route('admin.videoContest.delVideoContestData') }}',
                            type: 'post',
                            dataType: 'json',
                            data: {'ids' : data.id},
                            success: function (d) {
                                layer.msg(d.msg);
                                if (0 == d.code) {
                                    obj.del();
                                }
                            }
                        });
                    },
                    btn2: function (index, layero) {
                        // you code ...
                    },
                });
            }
        });

        table.on('toolbar(dateTable)', function (obj) {
            var data = obj.data;

            if (obj.event === 'refreshData') {
                tableIns.reload();
            } else if (obj.event === 'deletes') {
                var checkStatus = table.checkStatus('dataCheck'), cd = checkStatus.data;

                var ids = '';
                for (var i = 0; i < cd.length; i++) { // 循环筛选出id
                    ids += ids == '' ? cd[i].id : ',' + cd[i].id;
                }

                if (ids == '') {
                    layer.msg('请选择要删除的数据');
                    return false;
                }

                layer.msg('您确定要删除所选数据？', {
                    time: false,
                    btn: ['确定', '取消'],
                    btnAlign: 'c',
                    btn1: function (index, layero) {
                        $.ajax({
                            url: '{{ route('admin.videoContest.delVideoContestData') }}',
                            type: 'post',
                            dataType: 'json',
                            data: {'ids' : ids},
                            success: function (d) {
                                layer.msg(d.msg);
                                tableIns.reload(); // 刷新
                            }
                        });
                    },
                    btn2: function (index, layero) {
                        // you code ...
                    },
                });
            } else if (obj.event === 'search') {
                var phone = $('input[name="phone"]').val();
                var id = $('input[name="id"]').val();
                tableIns.reload({
                    where:{
                        phone:phone,
                        id:id,
                    },
                    page:{curr:1},
                    done: function (res) {
                        $('input[name="phone"]').val(phone);
                        $('input[name="id"]').val(id);
                    }
                });
            }
        });
    });
</script>
@endsection
