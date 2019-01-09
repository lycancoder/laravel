<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2019/1/9
 * Time: 21:52
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $getData = $request->all();
        return $getData;
    }
}