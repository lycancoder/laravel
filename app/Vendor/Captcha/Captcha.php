<?php
/**
 * 登录/注册 验证码
 * 如果自定义字体，请将字体放入同级目录ttfs文件夹下，初始化时只需传入字体名（带后缀）
 * 在 diyProcess() 中对验证码进行相关处理
 * 在 verifyCode() 中对验证码进行验证
 * User: Lycan LycanCoder@gmail.com
 * Date: 2018/10/18
 * Time: 20:17
 */

namespace App\Vendor\Captcha;

class Captcha
{
    private $codeSet  = '';      // 验证码字符集合
    private $fontSize = 12;      // 验证码字体大小(px)
    private $useCurve = false;   // 是否画混淆曲线
    private $useNoise = false;   // 是否添加杂点
    private $width    = 0;        // 验证码图片宽度
    private $height   = 0;        // 验证码图片高度
    private $length   = 0;        // 验证码位数
    private $font     = '';       // 验证码字体，不设置将随机获取
    private $bgc      = array(); // 背景颜色
    private $image    = null;    // 验证码图片实例
    private $color    = null;    // 验证码字体颜色

    /**
     * 架构方法 设置参数
     * Captcha constructor.
     * @param array $config 配置参数
     */
    public function __construct($config = array())
    {
        $this->codeSet  = isset($config['codeSet']) ? $config['codeSet'] : self::_setCode();
        $this->fontSize = isset($config['fontSize']) ? $config['fontSize'] : 18;
        $this->useCurve = isset($config['useCurve']) ? true : false;
        $this->useNoise = isset($config['useNoise']) ? true : false;
        $this->width    = isset($config['width']) ? $config['width'] : 130;
        $this->height   = isset($config['height']) ? $config['height'] : 50;
        $this->length   = isset($config['length']) ? $config['length'] : 4;
        $this->font     = isset($config['font']) ? $config['font'] : '';
        $this->bgc      = isset($config['bgc']) ? $config['bgc'] : array(240, 88, 12);
    }

    /**
     * 验证码字符集合
     * @return string
     */
    private function _setCode()
    {
        return '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
    }

    /**
     * 画一条由两条连在一起构成的随机正弦函数曲线作干扰线(你可以改成更帅的曲线函数)
     *
     * 高中的数学公式咋都忘了涅，写出来
     * 正弦型函数解析式：y=Asin(ωx+φ)+b
     * 各常数值对函数图像的影响：
     * A：决定峰值（即纵向拉伸压缩的倍数）
     * b：表示波形在Y轴的位置关系或纵向移动距离（上加下减）
     * φ：决定波形与X轴位置关系或横向移动距离（左加右减）
     * ω：决定周期（最小正周期T=2π/∣ω∣）
     */
    private function _writeCurve()
    {
        $px = $py = 0;

        // 曲线前部分
        $A = mt_rand(1, $this->height / 2);                  // 振幅
        $b = mt_rand(-$this->height / 4, $this->height / 4);   // Y轴方向偏移量
        $f = mt_rand(-$this->height / 4, $this->height / 4);   // X轴方向偏移量
        $T = mt_rand($this->height, $this->width * 2);  // 周期
        $w = (2* M_PI)/$T;

        $px1 = 0;  // 曲线横坐标起始位置
        $px2 = mt_rand($this->width / 2, $this->width * 0.8);  // 曲线横坐标结束位置

        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if ($w!=0) {
                $py = $A * sin($w * $px + $f) + $b + $this->height / 2;  // y = Asin(ωx+φ) + b
                $i = (int) ($this->fontSize / 5);
                while ($i > 0) {
                    // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多
                    imagesetpixel($this->image, $px + $i, $py + $i, $this->color);
                    $i--;
                }
            }
        }

        // 曲线后部分
        $A = mt_rand(1, $this->height / 2);                  // 振幅
        $f = mt_rand(-$this->height / 4, $this->height / 4);   // X轴方向偏移量
        $T = mt_rand($this->height, $this->width * 2);  // 周期
        $w = (2 * M_PI) / $T;
        $b = $py - $A * sin($w * $px + $f) - $this->height / 2;
        $px1 = $px2;
        $px2 = $this->height;

        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if ($w != 0) {
                $py = $A * sin($w * $px + $f) + $b + $this->height / 2;  // y = Asin(ωx+φ) + b
                $i = (int) ($this->fontSize / 5);
                while ($i > 0) {
                    imagesetpixel($this->image, $px + $i, $py + $i, $this->color);
                    $i--;
                }
            }
        }
    }

    /**
     * 画杂点
     * 往图片上写不同颜色的字母或数字
     */
    private function _writeNoise()
    {
        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
        for($i = 0; $i < 10; $i++){
            // 杂点颜色
            $noiseColor = imagecolorallocate($this->image, mt_rand(150,225), mt_rand(150,225), mt_rand(150,225));
            for($j = 0; $j < 5; $j++) {
                // 绘杂点
                imagestring($this->image, 5, mt_rand(-10, $this->width),  mt_rand(-10, $this->height), $codeSet[mt_rand(0, 29)], $noiseColor);
            }
        }
    }

    /**
     * 使用字体
     * 如果没有指定字体样式，将使用随机字体
     */
    private function _writeFont()
    {
        // 获取字体目录
        $ttfPath = dirname(__FILE__) . '/ttfs/';

        // 如果没有指定字体样式，将使用随机字体
        if (empty($this->font)) {
            $dir = dir($ttfPath);
            $ttf = array();

            while (false !== ($file = $dir->read())) {
                if($file[0] != '.' && substr($file, -4) == '.ttf') {
                    $ttf[] = $file;
                }
            }

            $dir->close();
            $this->font = $ttf[array_rand($ttf)];
        }

        $this->font = $ttfPath . $this->font;
    }

    /**
     * 绘制验证码
     */
    private function _drawCode()
    {
        $code = array(); // 验证码
        $codeNX = 0; // 验证码第N个字符的左边距
        for ($i = 0; $i < $this->length; $i++) {
            $code[$i] = $this->codeSet[mt_rand(0, strlen($this->codeSet) - 1)];
            $codeNX  += mt_rand($this->fontSize * 1.2, $this->fontSize * 1.6);
            imagettftext($this->image, $this->fontSize, mt_rand(-40, 40), $codeNX, $this->fontSize * 1.6, $this->color, $this->font, $code[$i]);
        }

        self::diyProcess($code);
    }

    /**
     * 输出验证码
     */
    public function getCodeImg()
    {
        // 建立一幅 $this->width x $this->height 的画布
        $this->image = imagecreate($this->width, $this->height);

        // 填充背景色
        imagecolorallocate($this->image, $this->bgc[0], $this->bgc[1], $this->bgc[2]);

        // 验证码字体随机颜色
        $this->color = imagecolorallocate($this->image, mt_rand(1,150), mt_rand(1,150), mt_rand(1,150));

        // 使用字体
        self::_writeFont();

        // 绘杂点
        if ($this->useNoise) self::_writeNoise();

        // 绘干扰线
        if ($this->useCurve) self::_writeCurve();

        // 绘验证码
        self::_drawCode();

        header('Cache-Control: private, max-age=0, no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header("content-type: image/png");

        // 输出图像
        imagepng($this->image);
        imagedestroy($this->image);
    }

    /**
     * 对验证码进行自定义处理（想怎么处理怎么处理，你高兴就好）
     * @param array $code 验证码
     */
    private function diyProcess(array $code)
    {
        // array 转 string
        $code = join('', $code);

        session(['captcha' => [
            'value' => md5('Lycan'.strtolower($code)),
            'time' => time()
        ]]);
    }

    /**
     * 验证验证码
     * @param string $code
     * @return array
     */
    public function verifyCode(string $code)
    {
        // 获取验证码
        $seCode = session('captcha');

        if (empty($code)) {
            // 验证码为空
            return array('status' => 0, 'msg' => '验证码为空');
        } elseif ((time() - $seCode['time']) > 300) {
            // 设置5分钟内做有效验证码
            return array('status' => 0, 'msg' => '验证码过时');
        } elseif (md5('Lycan'.strtolower($code)) != $seCode['value']) {
            // 验证码错误
            return array('status' => 0, 'msg' => '验证码错误');
        } else {
            // 验证码正确
            return array('status' => 1, 'msg' => '验证码正确');
        }
    }
}