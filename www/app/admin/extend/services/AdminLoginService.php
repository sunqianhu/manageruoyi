<?php
namespace app\admin\extend\services;

use app\common\helpers\Result;
use app\common\model\Admin;

use think\response\Json;
use think\facade\Validate;
use think\facade\Request;
use think\facade\Db;
use think\captcha\facade\Captcha;

class AdminLoginService
{
    //错误信息
    public $message = '';
    
    //是否登录保存cookie
    public $cookie = false;
    
    //用户信息
    public $_user;
    
    /**
     * 登录操作
     * @return Json
     */
    public function login(): Json
    {
        $data = Request::post();
        if (!$this->validate($data)) {
            return Result::error($this->message);
        }
        
        $user = $this->getUser('username', $data['username']);
        if (!$user) {
            return Result::error('用户名或密码错误');
        }
        if(!$this->validatePassword($data['password'])){
            return Result::error($this->message);
        }
        
        return Result::success('登录成功');
    }
    
    /**
     * 获取用户信息
     * @return mixed
     */
    public function getUser($field = '', $value = '')
    {
        if ($this->_user === null) {
            if ($field && $value) {
                $this->_user = Db::table(Admin::tableName())->where($field, $value)->find();
            }
        }
        return $this->_user;
    }
    
    /**
     * 验证密码
     * @param $password
     * @return bool
     */
    public function validatePassword($password):bool{
        if(!$this->_user){
            $this->message = '用户信息获取失败';
            return false;
        }
        if($this->_user['password']!=md5($password)){
            $this->message = '密码错误';
            return false;
        }
        return true;
    }
    
    /**
     * 验证登录信息
     * @param $data
     * @return bool
     */
    public function validate($data): bool
    {
        $rules = [
            'username|用户名' => 'require|min:2|max:20',
            'password|密码' => 'require|min:6|max:20',
            'captcha|验证码' => 'require|length:5',
        ];

        //验证数据格式
        $validate = Validate::rule($rules);
        if (!$validate->check($data)) {
            $this->message = $validate->getError() ?: '表单数据错误';
            return false;
        }
        //验证验证码
        if (!Captcha::check($data['captcha'])) {
            $this->message = '验证码错误';
            return false;
        }
        if (isset($data['remember']) && $data['remember']) {
            $this->cookie = true;
        }
        return true;
    }
}

