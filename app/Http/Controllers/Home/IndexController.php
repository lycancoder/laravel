<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/10/14
 * Time: 18:15
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Vendor\JuheSms;

class IndexController extends Controller
{
    public function index()
    {
        $juheSms = new JuheSms(array('key' => 'b6b99847f1ef7def5f2e1dacf531a957', 'tpl_id' => '106341'));
        $result = $juheSms->smsSend(13350334517, array('code' => 123456));
        return p($result);
        //return 'Home';
    }

}