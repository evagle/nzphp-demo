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
use models\accounts\UserB;
use ZPHP\Common\ZLog;
use ZPHP\Core\ZConfig;
//use ZPHP\DB\Pdo;

class main extends BaseController
{
    public function main()
    {
        $projectName = ZConfig::get('project_name');

        $t1 = microtime(true);
        $names = User::getColumnNames();
        $user = User::find(14);
        $user->username .= "2";
        $user->update();

        if ($user instanceof User) {
            ZLog::info('info', [$user->username]);
        } else {
            ZLog::info('info', ['22222']);
        }
        $t2 = microtime(true);

        return $this->getView([
                "welcome to $projectName!", $t2-$t1, ($user)
            ], false);
    }
}