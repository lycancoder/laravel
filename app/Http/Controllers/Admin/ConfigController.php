<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2019/5/8
 * Time: 21:07
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logic\Datetime\Timer;
use App\Model\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * indexPage 配置页
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/8
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexPage()
    {
        return view('admin.config.indexPage');
    }

    /**
     * indexPageData 配置页列表数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/8
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPageData(Request $request)
    {
        $model = new Config();
        $getData = $request->all();

        $data = $model
            ->when(isset($getData['name']), function ($query) use ($getData) {
                return $query->where('key', 'like', '%' . $getData['name'] . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate($request->get('limit', 10))
            ->toArray();

        $data['data'] = Timer::timestampToYmdHis($data['data']);

        return response()->json(['code' => 0, 'msg' => '加载成功', 'count' => $data['total'], 'data' => $data['data']]);
    }

    /**
     * indexEdit 配置编辑页
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/8
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexEdit(Request $request)
    {
        $model = new Config();
        $getData = $request->all();

        $data = $model->getInfoId($getData['id']);

        return view('admin.config.indexEdit', compact('data'));
    }

    /**
     * configEditSubmit 保存数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/9
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function configEditSubmit(Request $request)
    {
        $model = new Config();
        $getData = $request->all();
        $getData = json_decode($getData['data'], true);
        $ret = $model->updateInfo($getData);

        return response()->json($ret);
    }
}
