@extends('admin.base')

@section('css')
<style>
    .ly-layui-btn {height: unset;line-height: unset;border-radius: 5px;}
</style>
@endsection

@section('content')
<body class="body">
    <!-- 自定义工具集 -->
    <div class="my-btn-box">
        <span class="fl">
            <a class="layui-btn btn-add btn-default" data-event="refreshData" title="刷新"><i class="layui-icon">&#xe666;</i></a>
        </span>
        <span class="fr">
            <div class="layui-input-inline">
                <input type="text" autocomplete="off" placeholder="用户名" class="layui-input" id="name">
            </div>
            <button class="layui-btn mgl-20" data-event="searchData" title="查询"><i class="layui-icon">&#xe615;</i></button>
        </span>
    </div>

    <!-- 表格 -->
    <div id="dateTable" lay-filter="dateTable"></div>
</body>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/layui_admin.js') }}"></script>

<script type="text/javascript">
    // layui方法
    layui.use(['table', 'form', 'layer', 'vip_table'], function () {
        // 操作对象
        var form = layui.form;
        var table = layui.table;
        var layer = layui.layer;
        var vipTable = layui.vip_table;
        var $ = layui.jquery;

        // 表格渲染
        var tableIns = table.render({
            elem: '#dateTable' //指定原始表格元素选择器（推荐id选择器）
            // ,height: vipTable.getFullHeight() //容器高度
            ,id: 'dataCheck'
            ,method: 'get'
            ,url: '{{ route('admin.user.userLoginLogPageData') }}'
            ,cols: [[ //标题栏
                {checkbox: true, fixed: 'left', width: 50}
                , {title: 'ID',field: 'id', width: 70, sort: true}
                , {title: '用户名', field: 'name'}
                , {title: '登录IP地址', field: 'ip', width: 250}
                , {title: '创建时间', field: 'created_at', width: 170, align: 'center'}
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
        });

        // you code ...

        // 自定义监听数据
        var active = {
            refreshData: function () { // 刷新
                tableIns.reload();
            },
            searchData: function () { // 搜索
                tableIns.reload({
                    where:{
                        name:$("#name").val(),
                    },
                    page:{curr:1}
                });
            }
        };

        // 头部按钮操作，调用 active 中的函数
        $('.my-btn-box .layui-btn').on('click', function () {
            var type = $(this).data('event');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
@endsection
