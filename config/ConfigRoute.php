<?php

/**
 * Class ConfigRoute
 * 设置配置路径
 */
class ConfigRoute
{
    /**
     * 返回项目配置目录的路径
     * 默认是default，表示使用ROOT/config/default下的配置
     * @return mixed|string
     */
    public static function getConfigPath()
    {
        $configPath = "";
        if(empty($configPath)) {
            if (!empty($_SERVER['HTTP_HOST'])) {
                $configPath = \str_replace(':', '_', $_SERVER['HTTP_HOST']);
            } elseif (!empty($_SERVER['argv'][1])) {
                $configPath = $_SERVER['argv'][1];
            }
        }
        if (substr($configPath, -3) == "_80") {
            $configPath = substr($configPath, 0, -3);
        }

        return $configPath;
    }

}