<?php
namespace app\common;

use think\facade\Db;

class BaseModel
{
    /**
     * 初始化过的模型.
     * @var array
     */
    protected static $instance = [];
    
    /**
     * 静态方法获取表名
     * @return string
     */
    public static function tableName(): string
    {
        return static::getInstance()->table;
    }
    
    /**
     * 单例模式获取当前对象
     * @return mixed
     */
    public static function getInstance(): object
    {
        if (!isset(static::$instance[static::class])) {
            static::$instance[static::class] = new static();
        }
        return static::$instance[static::class];
    }
}
?>