<?php

## 配置路由，这里决定使用哪些配置

class ConfigRoute
{
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