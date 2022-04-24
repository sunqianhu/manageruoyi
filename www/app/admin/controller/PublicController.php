<?php
/**
 * 公共控制器
 */
namespace app\admin\controller;

use think\captcha\facade\Captcha;
use app\admin\BaseController;
use app\admin\extend\services\AdminLoginService;
use app\common\helpers\Result;
use think\facade\Request;

class PublicController extends BaseController
{
    /**
     * 登录页面
     */
    public function loginAction()
    {
        if(Request::isPost()){
            $result = (new AdminLoginService())->login();
            $data = $result->getData();
            //LoginLog::logAdd($this->request->post('username',''),$data['success']?1:0,$data['msg']);
            return $result;
        }else{
            return $this->render();
        }
    }
    
    /**
     * 获取验证码
     * @return \think\Response
     */
    public function captchaAction(){
        return Captcha::create();
    }
    
    
}
