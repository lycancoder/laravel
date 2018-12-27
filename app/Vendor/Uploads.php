<?php
/**
 * 上传文件封装类
 * User: Lycan
 * Date: 2018/12/25
 * Time: 20:52
 */

namespace App\Vendor;

class Uploads
{
    private $error = ''; // 错误信息
    private $mimes = array('image/jpeg','application/pdf','application/msword'); // 允许上传的文件MimeType类型
    private $exts = array('jpg','jpeg','gif','png','doc','docx','xls','xlsx','ppt','pptx','pdf'); // 文件后缀类型
    private $maxSize = 1048576; // 上传的文件大小限制（0-不做限制）
    private $savePath = './Uploads'; // 保存路径

    /**
     * Uploads constructor. 构造上传实例
     * @param array $config 配置
     */
    public function __construct($config = array())
    {
        $this->mimes = isset($config['mimes']) ? $config['mimes'] : $this->mimes;
        $this->maxSize = isset($config['maxSize']) ? $config['maxSize'] : $this->maxSize;
        $this->exts = isset($config['exts']) ? $config['exts'] : $this->exts;
        $this->savePath = isset($config['savePath']) ? $config['savePath'] : $this->savePath;

        if (!empty($this->exts)) {
            if (is_string($this->exts)) {
                $this->exts = explode(',', $this->exts);
            }
            $this->exts = array_map('strtolower', $this->exts);
        }

        if (!empty($this->mimes)) {
            if (is_string($this->mimes)) {
                $this->mimes = explode(',', $this->mimes);
            }
            $this->mimes = array_map('strtolower', $this->mimes);
        }
    }

    /**
     * getError 获取最后一次上传错误信息
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/25
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * uploadOne 上传单个文件
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/27
     *
     * @example (new Uploads())->uploadOne($_FILES['file']);
     * @param array $file
     * @return array|bool|mixed
     */
    public function uploadOne($file = array())
    {
        if (empty($file)) {
            // 没有上传的文件
            $this->error = 'No uploaded files';
            return false;
        }

        if (count($file) != count($file, 1)) {
            // 上传数据格式错误（不是一维数组）
            $this->error = 'Upload data format error (not a one-dimensional array)';
            return false;
        }

        $info = $this->uploads(array($file));
        return $info ? $info[0] : $info;
    }
    /**
     * uploads 上传文件
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/27
     *
     * @example (new Uploads())->uploads($_FILES);
     * @param array $files
     * @return array|bool
     */
    public function uploads($files = array())
    {
        if ($files === array()) {
            $files = $_FILES;
        }

        if (empty($files)) {
            // 没有上传的文件
            $this->error = 'No uploaded files';
            return false;
        }

        if (!self::mkDirectory($this->savePath)) {
            return false;
        }

        $info = array();
        $files = self::dealFiles($files);
        foreach ($files as $key => $file) {
            $file['name'] = strip_tags($file['name']);
            if (!isset($file['key'])) {
                $file['key'] = $key;
            }

            $file['ext'] = self::getExt($file['name']);

            if (!self::check($file)) {
                continue;
            }

            $saveName = self::setFileName($file['ext']);
            $moveFile = move_uploaded_file($file['tmp_name'],$this->savePath.'/'.$saveName);
            if ($moveFile) {
                $info[] = array(
                    'filename' => $file['name'],
                    'savePath' => $this->savePath.'/'.$saveName,
                    'saveName' => $saveName,
                    'ext'      => $file['ext'],
                    'size'     => $file['size'],
                );
            } else {
                // 移动文件失败
                $this->error = 'Failed to move files';
                continue;
            }
        }

        return $info ? $info : false;
    }

    /**
     * check 检测文件
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/27
     *
     * @param array $file
     * @return bool
     */
    protected function check($file = array())
    {
        if ($file['error']) {
            // 上传失败，错误代码
            self::error($file['error']);
            return false;
        }

        if (empty($file['name'])) {
            // 未知上传错误
            $this->error = 'Unknown upload error';
            return false;
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            // 非法上传文件
            $this->error = 'Illegal upload of files';
            return false;
        }

        if (!self::checkSize($file['size'])) {
            // 上传文件大小不符
            $this->error = 'Upload file size does not match';
            return false;
        }

        if (!self::checkMime($file['type'])) {
            // 上传文件MIME类型不允许
            $this->error = 'Upload file MimeType is not allowed';
            return false;
        }

        if (!$this->checkExt($file['ext'])) {
            // 上传文件后缀不允许
            $this->error = 'Upload file suffix not allowed';
            return false;
        }

        return true;
    }

    /**
     * error 获取错误代码信息
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/26
     *
     * @param int $errorNo 错误号
     */
    private function error($errorNo = 0)
    {
        switch ($errorNo) {
            case 1: // 上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值
                $this->error = 'The uploaded file exceeds the value of the upload_max_filesize option in php.ini';
                break;
            case 2: // 上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值
                $this->error = 'The size of the uploaded file exceeds the value specified by the MAX_FILE_SIZE option in the HTML form.';
                break;
            case 3: // 文件只有部分被上传
                $this->error = 'Only part of the file is uploaded';
                break;
            case 4: // 没有文件被上传
                $this->error = 'No files have been uploaded';
                break;
            case 6: // 找不到临时文件夹
                $this->error = 'Temporary folder not found';
                break;
            case 7: // 文件写入失败
                $this->error = 'File write failed';
                break;
            default: // 未知上传错误
                $this->error = 'Unknown upload error';
                break;
        }
    }

    /**
     * checkSize 检测文件大小
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/27
     *
     * @param int $size
     * @return bool
     */
    protected function checkSize($size = 0)
    {
        return !($size > $this->maxSize) || (0 == $this->maxSize);
    }

    /**
     * checkMime 检测文件mime类型
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/27
     *
     * @param string $mime
     * @return bool
     */
    protected function checkMime($mime = '')
    {
        return empty($this->mimes) ? true : in_array(strtolower($mime), $this->mimes);
    }

    /**
     * checkExt 检测文件后缀
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/27
     *
     * @param string $ext
     * @return bool
     */
    protected function checkExt($ext = '')
    {
        return empty($this->exts) ? true : in_array(strtolower($ext), $this->exts);
    }

    /**
     * dealFiles 处理上传文件，转换数组变量为正确的方式
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/26
     *
     * @param array $files
     * @return array
     */
    protected function dealFiles($files = array())
    {
        $fileArray = array();
        $n = 0;

        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                $keys = array_keys($file);
                $count = count($file['name']);

                for ($i = 0; $i < $count; $i++) {
                    $fileArray[$n]['key'] = $key;

                    foreach ($keys as $keyName) {
                        $fileArray[$n][$keyName] = $file[$keyName][$i];
                    }
                    $n++;
                }
            } else {
                $fileArray = $files;
                break;
            }
        }

        return $fileArray;
    }

    /**
     * mkDirectory 创建目录
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/26
     *
     * @param string $path
     * @return bool
     */
    protected function mkDirectory($path = '')
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (!is_writable($path) || !is_dir($path)) {
            // 目录不可写或创建失败
            $this->error = 'Directory not writable or failed to create';
            return false;
        }

        return true;
    }

    /**
     * getExt 获取文件名后缀
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/26
     *
     * @param string $filename
     * @param bool $strtolower
     * @return mixed|string
     */
    protected function getExt($filename = '', $strtolower = false)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return $strtolower == false ? $ext : strtolower($ext);
    }

    /**
     * setFileName 设置文件名
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/26
     *
     * @param string $ext
     * @return string
     */
    protected function setFileName($ext = '')
    {
        $name = uniqid() . '.' . $ext;
        return $name;
    }
}