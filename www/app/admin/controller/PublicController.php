<?php
/**
 * 公共控制器
 */
namespace app\admin\controller;

use app\BaseController;

class PublicController extends BaseController
{
    /**
     * 登录页面
     */
    public function loginAction()
    {
        return $this->render();
    }
}
