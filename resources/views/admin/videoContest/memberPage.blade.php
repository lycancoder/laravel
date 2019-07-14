@extends('admin.base')

@section('content')
<body class="body">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="150">
            <col width="100">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>姓名</th>
            <th>性别</th>
            <th>出生年月</th>
        </tr>
        </thead>
        <tbody>
        @forelse($data as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['gender'] }}</td>
                <td>{{ $item['birth'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">暂 无 数 据</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</body>
@endsection
