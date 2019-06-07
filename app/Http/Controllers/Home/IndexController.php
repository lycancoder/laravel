<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/10/14
 * Time: 18:15
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('home.index.timeCompass');
    }
}
