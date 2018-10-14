<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/10/14
 * Time: 18:03
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return 'Admin';
    }
}