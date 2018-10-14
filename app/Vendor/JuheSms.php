<?php
/**
 * 通过聚合数据平台发送短信
 * 添加了新的短信模板，需要在setMessage()方法中添加对应的模板内容
 * User: Lycan
 * Date: 2018/10/9
 * Time: 22:52
 */

namespace App\Vendor;

class JuheSms
{
    private $key = '';
    private $tpl_id = '';
    private $url = '';
    private $tpl_value = '';

    /**
     * JuheSms constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->key = isset($params['key']) ? $params['key'] : ''; // APPKEY
        $this->tpl_id = isset($params['tpl_id']) ? $params['tpl_id'] : ''; // 短信模板ID
        $this->url = 'http://v.juhe.cn/sms/send'; // 短信接口的URL
    }

    /**
     * 您设置的模板变量，根据实际情况修改
     * @param array $params
     * @return string
     */
    private function setMessage($params = array())
    {
        switch ($this->tpl_id) {
            case 106343:
                // 【亚古文化】您的注册验证码为#code#，请勿泄露给他人，若非本人操作，请忽略此信息。
                return $this->tpl_value = '#code#=' . $params['code'];
                break;
            case 106341:
                // 【亚古文化】您的验证码是#code#
                return $this->tpl_value = '#code#=' . $params['code'];
                break;
            case 106673:
                // 【重庆大学生视频大赛】您的注册验证码为#code#，请勿泄露给他人，若非本人操作，请忽略此信息。
                return $this->tpl_value = '#code#=' . $params['code'];
                break;
            default :
                // 【亚古文化】您的注册验证码为#code#，请勿泄露给他人，若非本人操作，请忽略此信息。
                return $this->tpl_value = '#code#=' . $params['code'];
                break;
        }
    }

    /**
     * 请求发送短信
     * @param $url
     * @param bool $params
     * @param int $isPost
     * @return bool|mixed
     */
    private function juheCurl($url, $params = false, $isPost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params)
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            else
                curl_setopt($ch, CURLOPT_URL, $url);
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);

        return $response;
    }

    /**
     * 发送短信调用方法
     * @param string $phone 手机号码
     * @param array $message 短信内容
     * @return array
     */
    public function smsSend($phone = '', $message = array())
    {
        header('content-type:text/html;charset=utf-8');
        $smsConf = array(
            'key'       => $this->key,
            'mobile'    => $phone, // 接受短信的用户手机号码
            'tpl_id'    => $this->tpl_id,
            'tpl_value' => self::setMessage($message)
        );
        $content = self::juheCurl($this->url, $smsConf, 1); // 请求发送短信

        if ($content) {
            $result = json_decode($content, true);
            $error_code = $result['error_code'];

            if ($error_code == 0) {
                // 状态为0，说明短信发送成功
                // echo "短信发送成功,短信ID：".$result['result']['sid'];
                return array('code' => 0, 'msg' => '短信发送成功，短信ID：' . $result['result']['sid'], 'data' => $result);
            }else{
                // 状态非0，说明失败
                // echo "短信发送失败(".$error_code.")：".$result['reason'];
                return array('code' => $error_code, 'msg' => '短信发送失败：' . $result['reason'], 'data' => $result);
            }
        }else{
            // 返回内容异常，以下可根据业务逻辑自行修改
            // echo "请求发送短信失败";
            return array('code' => 1, 'msg' => '请求发送短信失败', 'data' => '');
        }
    }
}
