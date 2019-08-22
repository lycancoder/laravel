<?php

namespace App\Logic\LogInOut;

use App\Model\File;
use App\Model\User;
use App\Model\UserGroup;
use App\Model\UserLoginLog;
use App\Logic\Nav\AdminNav;

/**
 * 用户登录操作处理
 * Class Login
 * @package App\Logic\LogInOut
 */
Class Login
{
    /**
     * adminLogin 超级管理员登录
     * @author Lycan LycanCoder@gmail.com
     * @date 2019/7/26
     *
     * @param array $params
     * $params['account']  必需  登录账户
     * $params['password'] 必需  账户密码
     *
     * @return array
     */
    public function adminLogin($params = array())
    {
        // 验证密码
        if (md5(md5($params['account'].$params['password'])) != env('ADMIN_PASSWORD'))
            return return_code(101, '账号或密码错误');

        // 获取所有菜单及权限
        $nav = new AdminNav();
        $retNav = $nav->navList();
        $navArr = $retNav['data'];

        # 获取所有权限的ID 形成权限ID字符串
        $nav_ids = implode(',', array_column($navArr, 'id'));

        # 处理权限数据
        $navPermissionArr = $this->navTurn($navArr);

        # 模拟普通用户数据格式 参考普通用户登录
        $userData = [
            'id' => 0,
            'name' => $params['account'],
            'email' => '',
            'phone' => '',
            'g_id' => 0,
            'header' => 'img/default-head.png',
            'groupName' => '超级管理员组',
            'nav_ids' => $nav_ids,
        ];

        # 保存session
        session([
            'loginUser' => $userData,
            'LoginUserPermission' => $navPermissionArr
        ]);

        return return_code(0, '登录成功');
    }

    /**
     * login 普通用户登录验证
     * @author Lycan LycanCoder@gmail.com
     * @date 2019/7/25
     *
     * @param array $params
     * $params['account']  必需  登录账户
     * $params['password'] 必需  账户密码
     * $params['ip']       必需  客户端IP
     *
     * @return array
     */
    public function login($params = array())
    {
        if (!verify_email($params['account']) && !verify_phone($params['account']))
            return return_code(101, '账号信息输入错误');

        $model = new User();
        $userData = $model->checkLogin($params['account'], verify_email($params['account']) ? 'email' : 'phone');
        if (!$userData || !password_verify($params['password'], $userData['password']))
            return return_code(101, '账号或密码错误');

        if ($userData['status'] != 1)
            return return_code(101, '该账号已被禁用');

        # 设置头像
        $userData['header'] = "img/default-head.png";
        if ($userData["header_id"]) {
            $file = new File();
            $filePath = $file->getPath($userData["header_id"]);
            $userData['header'] = $filePath["save_path"];
        }

        unset($userData["password"],$userData["status"],$userData["header_id"]);

        # 获取所在组信息
        $userGroup = new UserGroup();
        $groupInfo = $userGroup->getInfoId($userData['g_id']);
        $userData['groupName'] = $groupInfo['name'];
        $userData['nav_ids'] = $groupInfo['nav_ids'];

        # 获取所拥有的权限
        $leftNav = new AdminNav();
        $navArr = $leftNav->navList(['ids' => $groupInfo['nav_ids']]);
        $navArr = $navArr['data'];

        # 处理权限数据
        $navPermissionArr = $this->navTurn($navArr);

        # 保存session
        session([
            'loginUser' => $userData,
            'LoginUserPermission' => $navPermissionArr
        ]);

        # 记录登录日志
        $userLoginLog = new UserLoginLog();
        $userLoginLog->addData($userData['id'], $params['ip']);

        return return_code(0, '登录成功');
    }

    /**
     * navTurn
     * @author Lycan LycanCoder@gmail.com
     * @date 2019/7/26
     *
     * @param array $nav 原始二维权限数组
     * @return array 一维数组
     */
    private function navTurn($nav = array())
    {
        # 过滤掉url值为空的数据
        # demo:
        # [['id'=>1,'url'=>'test'],['id'=>2,'url'=>''],['id'=>3,'url'=>'test1']]
        # => [['id'=>1,'url'=>'test'],['id'=>2,'url'=>'test1']]
        $navArr = array_filter($nav, function($v) {
            return $v['url'];
        });

        # 指定键值组成新数据
        # demo:
        # [['id'=>1,'url'=>'test'],['id'=>2,'url'=>'test1']] => ['test'=>1,'test1'=>2]
        return $navArr ? array_pluck($navArr, 'id', 'url') : [];
    }
}
