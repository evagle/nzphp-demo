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

    protected $fetchHooks = ['jsonColumn' => __CLASS__."::parseJson"];
    protected $saveHooks = ['jsonColumn' => __CLASS__."::toJson"];

    public static function parseJson($string)
    {
        if (is_string($string)) {
            return json_decode($string, true);
        }
        return $string;
    }

    public static function toJson($value)
    {
        return json_encode($value);
    }
}