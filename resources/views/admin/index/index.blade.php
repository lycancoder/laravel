@extends('admin.base')
@section('content')
<body>
    <!-- layout admin -->
    <div class="layui-layout layui-layout-admin"> <!-- 添加skin-1类可手动修改主题为纯白，添加skin-2类可手动修改主题为蓝白 -->
        <!-- header -->
        <div class="layui-header my-header">
            <a href="">
                {{--<img class="my-header-logo" src="{{ asset('img/code.png') }}" alt="logo">--}}
                <div class="my-header-logo">数据管理平台</div>
            </a>
            <div class="my-header-btn">
                <button class="layui-btn layui-btn-small btn-nav"><i class="layui-icon">&#xe65f;</i></button>
            </div>

            <!-- 顶部左侧添加选项卡监听 -->
            <ul class="layui-nav" lay-filter="side-top-left">
                {{--
                <li class="layui-nav-item"><a href="javascript:;" href-url="demo/btn.html"><i class="layui-icon">&#xe621;</i>按钮</a></li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon">&#xe621;</i>基础</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" href-url="demo/btn.html"><i class="layui-icon">&#xe621;</i>按钮</a></dd>
                        <dd><a href="javascript:;" href-url="demo/form.html"><i class="layui-icon">&#xe621;</i>表单</a></dd>
                    </dl>
                </li>
                --}}
            </ul>

            <!-- 顶部右侧添加选项卡监听 -->
            <ul class="layui-nav my-header-user-nav" lay-filter="side-top-right">
                {{--<li class="layui-nav-item"><a href="javascript:;" class="pay" href-url="">支持作者</a></li>--}}
                <li class="layui-nav-item">
                    <a class="name" href="javascript:;"><i class="layui-icon">&#xe629;</i>主题</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-skin="0">默认</a></dd>
                        <dd><a href="javascript:;" data-skin="1">纯白</a></dd>
                        <dd><a href="javascript:;" data-skin="2">蓝白</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a class="name" href="javascript:;"><img src="{{ asset('img/code.png') }}" alt="logo"> {{ session('loginUser')['name'] }} </a>
                    <dl class="layui-nav-child">
                        {{--<dd><a href="javascript:;" href-url="{{ route('admin.user.userChangePassword') }}"><i class="layui-icon">&#xe673;</i>修改密码</a></dd>--}}
                        <dd><a href="javascript:;" href-url="" onclick="change_password()"><i class="layui-icon">&#xe673;</i>修改密码</a></dd>
                        <dd><a href="{{ route('admin.index.logout') }}"><i class="layui-icon">&#x1006;</i>退出</a></dd>
                    </dl>
                </li>
            </ul>

        </div>
        <!-- side -->
        <div class="layui-side my-side">
            <div class="layui-side-scroll">
                <!-- 左侧主菜单添加选项卡监听 -->
                <ul class="layui-nav layui-nav-tree" lay-filter="side-main">
                    {{--
                    <li class="layui-nav-item  layui-nav-itemed">
                        <a href="javascript:;"><i class="layui-icon">&#xe620;</i>基础</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" href-url="demo/form.html"><i class="layui-icon">&#xe621;</i>按钮</a></dd>
                            <dd><a href="javascript:;" href-url="demo/form.html"><i class="layui-icon">&#xe621;</i>表单</a></dd>
                            <dd><a href="javascript:;" href-url="demo/table.html"><i class="layui-icon">&#xe621;</i>表格</a></dd>
                            <dd><a href="javascript:;" href-url="demo/tab-card.html"><i class="layui-icon">&#xe621;</i>选项卡</a></dd>
                            <dd><a href="javascript:;" href-url="demo/progress-bar.html"><i class="layui-icon">&#xe621;</i>进度条</a></dd>
                            <dd><a href="javascript:;" href-url="demo/folding-panel.html"><i class="layui-icon">&#xe621;</i>折叠面板</a></dd>
                            <dd><a href="javascript:;" href-url="demo/auxiliar.html"><i class="layui-icon">&#xe621;</i>辅助元素</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon">&#xe628;</i>扩展</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" href-url="demo/login.html"><i class="layui-icon">&#xe621;</i>登录页</a></dd>
                            <dd><a href="javascript:;" href-url="demo/register.html"><i class="layui-icon">&#xe621;</i>注册页</a></dd>
                            <dd><a href="javascript:;" href-url="demo/login2.html"><i class="layui-icon">&#xe621;</i>登录页2</a></dd>
                            <dd><a href="javascript:;" href-url="demo/map.html"><i class="layui-icon">&#xe621;</i>图表</a></dd>
                            <dd><a href="javascript:;" href-url="demo/add-edit.html"><i class="layui-icon">&#xe621;</i>添加-修改</a></dd>
                            <dd><a href="javascript:;" href-url="demo/data-table.html"><i class="layui-icon">&#xe621;</i>data-table 表格页</a></dd>
                            <dd><a href="javascript:;" href-url="demo/tree-table.html"><i class="layui-icon">&#xe621;</i>Tree table树表格页</a></dd>
                            <dd><a href="javascript:;" href-url="demo/404.html"><i class="layui-icon">&#xe621;</i>404页</a></dd>
                            <dd><a href="javascript:;" href-url="demo/tips.html"><i class="layui-icon">&#xe621;</i>提示页</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a target="_blank" href="#"><i class="layui-icon">&#xe61e;</i>加入群下载源码</a>
                    </li>
                    --}}
                </ul>

            </div>
        </div>
        <!-- body -->
        <div class="layui-body my-body">
            <div class="layui-tab layui-tab-card my-tab" lay-filter="card" lay-allowClose="true">
                <ul class="layui-tab-title">
                    <li class="layui-this" lay-id="1"><span><i class="layui-icon">&#xe638;</i>欢迎页</span></li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe id="iframe" src="{{ route('admin.index.welcome') }}" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <div class="layui-footer my-footer">
            <div style="margin:0 auto;width:fit-content;">
                <div>
                    <span>Copyright &copy; {{ date('Y') }} Lycan 版权所有</span>&nbsp;&nbsp;
                    <a href="http://www.miitbeian.gov.cn/" target="_blank">渝ICP备17008552号</a>&nbsp;&nbsp;
                    <span>技术支持：Lycan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- pay -->
    <div class="my-pay-box none">
        <div><img src="{{ asset('img/code.png') }}" alt="支付宝"><p>支付宝</p></div>
        <div><img src="{{ asset('img/code.png') }}" alt="微信"><p>微信</p></div>
    </div>

    <!-- 右键菜单 -->
    <div class="my-dblclick-box">
        <table class="layui-tab dblclick-tab">
            <tr class="card-refresh">
                <td><i class="layui-icon">&#x1002;</i>刷新当前标签</td>
            </tr>
            <tr class="card-close">
                <td><i class="layui-icon">&#x1006;</i>关闭当前标签</td>
            </tr>
            <tr class="card-close-all">
                <td><i class="layui-icon">&#x1006;</i>关闭所有标签</td>
            </tr>
        </table>
    </div>
</body>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/layui_admin.js') }}"></script>
<script type="text/javascript">
    layui.use(['layer','vip_nav'], function () {
        // 操作对象
        var layer = layui.layer;
        var vipNav = layui.vip_nav;
        var $ = layui.jquery;

        // 顶部左侧菜单生成 [请求地址,过滤ID,是否展开,携带参数]
        //vipNav.top_left('{{ asset('js/nav_top_left.json') }}','side-top-left',false);
        // 主体菜单生成 [请求地址,过滤ID,是否展开,携带参数]
        vipNav.main('{{ route('admin.nav.leftNav') }}','side-main',true);

        // you code ...
    });

    // 修改密码
    function change_password() {
        layer.open({
            type: 2, // 类型
            shade: 0.5, // 遮罩
            shift: 1,
            maxmin: true, // 最大最小化
            title: '修改密码', // 标题
            area: ['710px', '450px'], // 宽高
            content: '{{ route('admin.user.userChangePassword') }}' // 内容
        });
    }
</script>
@endsection