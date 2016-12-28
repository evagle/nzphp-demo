<?php
/**
 * Created by PhpStorm.
 * User: abing
 * Date: 15/12/2016
 * Time: 22:05
 */

namespace controllers\main;

use controllers\BaseController;
use models\accounts\User;
use ZPHP\Core\ZConfig;

class main extends BaseController
{
    public function main()
    {
        $projectName = ZConfig::get('project_name');

        return $this->getView([
                "welcome to $projectName!"
            ], false);
    }

    public function test()
    {
        $projectName = ZConfig::get('project_name');

        $t1 = microtime(true);
        $user = User::find(14);
        $x = $user->username;

        $t2 = microtime(true);

        return $this->getView([
            "welcome to $projectName!", $t2-$t1,  $user, $user->username
        ], false);
    }


}