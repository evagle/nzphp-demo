<?php
/**
 * Created by PhpStorm.
 * User: abing
 * Date: 21/12/2016
 * Time: 21:36
 */

namespace models\accounts;


use ZPHP\DB\ActiveRecord;

class User extends ActiveRecord
{
    protected $table = "user";
    protected $connectionName = "accounts";
}