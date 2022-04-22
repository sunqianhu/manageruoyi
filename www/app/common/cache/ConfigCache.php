<?php
namespace app\common\cache;

use app\admin\extend\services\ConfigService;
use app\common\model\Config;
use think\facade\Cache;
use think\facade\Db;

class ConfigCache
{
    /**
     * 获取配置值
     * @param string|null $type
     * @param $default
     * @return false|mixed
     * @throws \Throwable
     */
    public static function get(string $type=null,$default = null){
        if(!$type) return false;
        $list = self::lists();

        return isset($list[$type])?$list[$type]['value']:$default;
    }
    
    /**
     * 获取配置列表
     * @return array
     * @throws \Throwable
     */
    public static function lists():array{
        return Cache::remember('config_list',function (){
            $result = [];
            $lists = Db::table(Config::tableName())->field(['type','value','extra','style'])->select()->toArray();
            if($lists){
                $service = new ConfigService();
                foreach ($lists as $key=>$value){
                    $result[$value['type']]=$service->formatFilter($value);
                }
            }
            return $result;
        });
    }
}
