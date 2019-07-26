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
            <a class="layui-btn layui-btn-danger radius btn-delect" data-event="batchDeletion" title="删除"><i class="layui-icon">&#xe640;</i></a>
            <a class="layui-btn btn-add btn-default layui-btn-normal" data-event="addData" title="添加"><i class="layui-icon">&#xe654;</i></a>
            <a class="layui-btn btn-add btn-default" data-event="refreshData" title="刷新"><i class="layui-icon">&#xe666;</i></a>
        </span>
        <span class="fr">
            <div class="layui-input-inline">
                <input type="text" autocomplete="off" placeholder="请输入名称" class="layui-input" id="title">
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

<!-- 行表格操作按钮集 -->
<script type="text/html" id="barOption">
    <a class="layui-btn layui-btn-sm layui-btn-normal ly-layui-btn" lay-event="edit" title="编辑"><i class="layui-icon">&#xe642;</i>编辑</a>
    <a class="layui-btn layui-btn-sm ly-layui-btn" lay-event="permission" title="权限"><i class="layui-icon">&#xe653;</i>权限</a>
</script>

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
            ,url: '{{ route('admin.user.groupPageData') }}'
            ,cols: [[ //标题栏
                {checkbox: true, fixed: 'left', width: 50}
                , {title: 'ID',field: 'id', width: 70, sort: true}
                , {title: '排序（点击修改）', field: 'sort', width: 150, align: 'center', edit: 'text', sort: true, style:'cursor: pointer;'}
                , {title: '组名', field: 'name',templet: '@verbatim<div><span title="{{ d.name }}">{{ d.name }}</span></div>@endverbatim', style:'cursor: text;'}
                , {title: '更新时间', field: 'updated_at', width: 170, align: 'center'}
                , {title: '创建时间', field: 'created_at', width: 170, align: 'center'}
                , {title: '操作', fixed: 'right', width: 180, align: 'center', toolbar: '#barOption'} //这里的toolbar值是模板元素的选择器
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

        // 监听单元格编辑
        table.on('edit(dateTable)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段

            if (!LyitePackage.checkStr(value, 'number')) {
                layer.msg('数据不合法');
                return false;
            }

            $.ajax({
                url: '{{ route('admin.user.updateGroupSort') }}',
                type: 'post',
                dataType: 'json',
                data: {
                    'id': data.id,
                    'sort': value
                },
                success: function (d) {
                    layer.msg(d.msg);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('操作失败');
                }
            });
        });

        // 监听行工具事件
        table.on('tool(dateTable)', function(obj){
            var data = obj.data;
            if(obj.event === 'edit'){ // 编辑
                edit_data(data.id);
            } else if (obj.event === 'permission') { // 权限
                layer.open({
                    type: 2, // 类型
                    shade: 0.5, // 遮罩
                    maxmin: true, // 最大最小化
                    title: '权限编辑', // 标题
                    area: ['900px', '600px'], // 宽高
                    content: '{{ route('admin.nav.permission') }}?id=' + data.id, // 内容
                    end: function () {
                        tableIns.reload(); // 刷新
                    }
                });
            }
        });

        // you code ...

        // 自定义监听数据
        var active = {
            batchDeletion: function () { // 批量删除
                var checkStatus = table.checkStatus('dataCheck'), data = checkStatus.data;

                var ids = '';
                for (var i = 0; i < data.length; i++) { // 循环筛选出id
                    ids += ids == '' ? data[i].id : ',' + data[i].id;
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
                            url: '{{ route('admin.user.delUserGroupData') }}',
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
            },
            addData: function () { // 添加数据
                edit_data(0);
            },
            refreshData: function () { // 刷新
                tableIns.reload();
            },
            searchData: function () { // 搜索
                var title = $("#title").val(); // 获取搜索内容
                tableIns.reload({
                    where:{
                        name:title,
                    },
                    page:{curr:1}
                });
            },
        };

        // 头部按钮操作，调用 active 中的函数
        $('.my-btn-box .layui-btn').on('click', function () {
            var type = $(this).data('event');
            active[type] ? active[type].call(this) : '';
        });

        /*
         * 编辑、添加数据调用函数
         * @author Lycan <LycanCoder@gmail.com>
         * @date 2018/10/19
         */
        function edit_data(id) {
            layer.open({
                type: 2, // 类型
                shade: 0.5, // 遮罩
                maxmin: true, // 最大最小化
                title: '数据编辑', // 标题
                area: ['800px', '600px'], // 宽高
                content: '{{ route('admin.user.groupEdit') }}?id=' + id, // 内容
                end: function () {
                    tableIns.reload(); // 刷新
                }
            });
        }
    });
</script>
@endsection
