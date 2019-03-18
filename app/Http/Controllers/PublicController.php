<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/12/17
 * Time: 23:26
 */

namespace App\Http\Controllers;

use App\Model\File;
use Illuminate\Http\Request;
use zgldh\QiniuStorage\QiniuStorage;

class PublicController extends Controller
{
    /**
     * uploadFile ajax上传文件
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/1/8
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        $getData = $request->all();

        // 文件后缀类型（''-不做限制）
        $defaultExts = ['jpg','jpeg','gif','png','doc','docx','xls','xlsx','ppt','pptx','pdf'];
        $exts = isset($getData['exts']) ? $getData['exts'] : $defaultExts;
        if (!empty($exts)) {
            if (is_string($exts)) {
                $exts = explode(',', $exts);
            }

            $exts = array_map('strtolower', $exts);
        }

        // 上传的文件大小限制，单位M（0-不做限制）
        $maxSize = isset($getData['maxSize']) ? $getData['maxSize'] : 5;
        $maxSize = (int)$maxSize * 1048576;

        $file = $request->file('file');

        // 检测上传的文件是否合法
        if (!($file->isValid())) {
            $msg = $file->getErrorMessage();
            return response()->json(return_code(1001, $msg));
        }

        // 检测上传文件后缀
        $ext = $file->getClientOriginalExtension();
        if ( !(empty($exts) || in_array(strtolower($ext), $exts)) ) {
            return response()->json(return_code(1002, 'Upload file suffix not allowed'));
        }

        // 检测上传文件大小
        $size = $file->getClientSize();
        if ( !(0 == $maxSize || $size <= $maxSize) ) {
            return response()->json(return_code(1003, 'Upload file size does not match'));
        }

        $originalName = $file->getClientOriginalName(); // 原文件名
        $saveName = date('Ymd') . '_' . time() . '_' . uniqid() . '.' . $ext; // 保存文件名
        $realPath = $file->getRealPath(); // 临时绝对路径

        // 保存到七牛
        $disk = QiniuStorage::disk('qiniu');
        $res = $disk->put($saveName, file_get_contents($realPath));
        if (!$res) {
            $msg = $file->getErrorMessage();
            return response()->json(return_code(1004, $msg));
        }

        // 获取下载路径
        $savePath = $disk->downloadUrl($saveName);

        // 部分数据存储到数据表
        $model = new File();
        $saveData = $model->addData([
            'fileName' => $originalName,
            'ext' => $ext,
            'size' => $size,
            'savePath' => $savePath,
        ]);
        if ($saveData['code'] != 0) {
            return response()->json($saveData);
        }

        $retData = [
            'fileName' => $originalName,
            'url' => $savePath,
            'fid' => $saveData['data']['id']
        ];
        return response()->json(return_code(0, 'Successful upload', $retData));
    }

}