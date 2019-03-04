<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2019/1/8
 * Time: 22:58
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $table = 'file';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * addData 新增文件数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/1/8
     *
     * @param array $data
     * @return array
     */
    public function addData(array $data)
    {
        $this->file_name = $data['fileName'];
        $this->ext = $data['ext'];
        $this->size = $data['size'];
        $this->save_path = $data['savePath'];
        $bool = $this->save();

        if ($bool) {
            $retData['id'] = $this->id;
            return returnCode(1, '保存文件成功', $retData);
        } else {
            return returnCode(0, '保存文件失败');
        }
    }

    /**
     * getPath 获取文件地址
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/5
     *
     * @param int $id
     * @return mixed
     */
    public function getPath(int $id)
    {
        $info = $this->where('id', $id)->first(['save_path']);
        return $info;
    }
}