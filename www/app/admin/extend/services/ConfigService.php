<?php

namespace app\admin\extend\services;


use app\common\model\Config;
use think\facade\Db;

class ConfigService
{
    /**
     * 对配置的数组和枚举进行处理
     * @param array $info
     * @param bool $array 是否处理数组
     * @return array
     */
    public function formatFilter(array $info,bool $array = true):array
    {
        if (empty($info)) return [];
        $value = $info['value'];
        if ($info['style'] == 'array' && $array) {
            if ($value) {
                $value = \app\common\helpers\Functions::strLineToArray($value, ':');
            }
            $value = $value ?: [];
        }
        $info['value'] = $value;

        $extra = $info['extra'];
        if ($info['style'] == 'select') {
            if ($extra) {
                $extra = \app\common\helpers\Functions::strLineToArray($extra, ':');
            }
            $extra = $extra ?: [];
        }
        $info['extra'] = $extra;
        return $info;
    }
}