<?php
/**
 * Created by PhpStorm.
 * User: abing
 * Date: 15/12/2016
 * Time: 22:05
 */

namespace controllers\main;

use controllers\BaseController;
use ZPHP\Common\ZLog;
use ZPHP\Core\ZConfig;

class main extends BaseController
{
    public function main()
    {
        ZLog::info("aaa", ["info", ZConfig::get('views_path')]);
        $projectName = ZConfig::get('project_name');
        return $this->getView([
                "welcome to $projectName!"
            ], false);
    }
}