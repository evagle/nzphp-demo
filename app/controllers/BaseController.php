<?php

namespace controllers;

use ZPHP\Controller\IController,
    ZPHP\Core\ZConfig as ZConfig,
    ZPHP\Common\Route as ZRoute,
    common;
use ZPHP\Protocol\Request;


abstract class BaseController implements IController
{
    protected $params = array();
    protected $loginInfo;

    public function _before()
    {
        $this->params = Request::getParams();
        return true;
    }

    public function _after()
    {

    }

    protected function getView($params = [], $viewMode = null)
    {
        $viewMode = $viewMode ? $viewMode : ZConfig::getField('project', 'view_mode');

        $data = array(
            'data' => $params,
            '_view_mode' => $viewMode,
            'ts' => time(),
            'status' => 0,
            'code' => 0,
            'msg' => '',
        );
        return $data;
    }

    public function getParams()
    {
        return $this->params;
    }

    protected function getInteger(array $params, $key, $default = null, $abs = false, $notEmpty = false)
    {

        if (!isset($params[$key])) {
            if (is_null($default)) {
                throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
            }
            return $default;
        }

        $integer = isset($params[$key]) ? (int)$params[$key] : 0;

        if ($abs) {
            $integer = \abs($integer);
        }

        if ($notEmpty && empty($integer)) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return $integer;
    }

    protected function _getInteger($key, $default = null, array $params = null, $abs = false, $notEmpty = false)
    {
        if (empty($params)) {
            $params = $this->params;
        }

        if (!isset($params[$key])) {
            if (is_null($default)) {
                throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
            }
            return $default;
        }

        $integer = isset($params[$key]) ? (int)$params[$key] : 0;

        if ($abs) {
            $integer = \abs($integer);
        }

        if ($notEmpty && empty($integer)) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return $integer;
    }

    protected function getIntegers($params, $key, $abs = false, $notEmpty = false)
    {
        $params = (array)$params;
        $integers = (\array_key_exists($key, $params) && !empty($params[$key])) ? \array_map('intval', (array)$params[$key]) : array();

        if ($abs) {
            $integers = \array_map('abs', $integers);
        }

        if (!empty($notEmpty) && empty($integers)) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return $integers;
    }

    protected function getFloat($params, $key, $default = null, $abs = false, $notEmpty = false)
    {
        $params = (array)$params;

        if (!isset($params[$key])) {
            if (is_null($default)) {
                throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
            }
            return $default;
        }

        $float = isset($params[$key]) ? \floatval($params[$key]) : 0;

        if ($abs) {
            $float = \abs($float);
        }

        if (!empty($notEmpty) && empty($float)) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return $float;
    }

    protected function _getFloat($key, $default = null, array $params = null, $abs = false, $notEmpty = false)
    {
        if (empty($params)) {
            $params = $this->params;
        }

        if (!isset($params[$key])) {
            if (is_null($default)) {
                throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
            }
            return $default;
        }

        $float = isset($params[$key]) ? \floatval($params[$key]) : 0;

        if ($abs) {
            $float = \abs($float);
        }

        if (!empty($notEmpty) && empty($float)) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return $float;
    }

    protected function getString($params, $key, $default = null, $notEmpty = false)
    {
        $params = (array)$params;

        if (!isset($params[$key])) {
            if (null !== $default) {
                return $default;
            }
            throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
        }

        $string = \trim($params[$key]);

        if ($notEmpty && '' == $string) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return \addslashes($string);
    }

    protected function _getString($key, $default = null, array $params = null, $notEmpty = false)
    {
        if (empty($params)) {
            $params = $this->params;
        }

        if (!isset($params[$key])) {
            if (null !== $default) {
                return $default;
            }
            throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
        }

        $string = \trim($params[$key]);

        if ($notEmpty && '' == $string) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return \addslashes($this->decodeParams($string));
    }

    protected function getStrings($params, $key, $notEmpty = false)
    {
        $params = (array)$params;
        $strings = (\array_key_exists($key, $params) && !empty($params[$key])) ? \array_map('trim', (array)$params[$key]) : array();

        if (!empty($notEmpty) && empty($strings)) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return \array_map("addslashes", $strings);
    }

    protected function _getStrings($key, array $params = null, $notEmpty = false)
    {
        if (empty($params)) {
            $params = $this->params;
        }
        $strings = !empty($params[$key]) ? \array_map('trim', (array)$params[$key]) : array();

        if (!empty($notEmpty) && empty($strings)) {
            throw new common\GameException('params no empty', common\ERROR::PARAM_ERROR);
        }

        return \array_map("addslashes", $strings);
    }

    protected function getJson(array $params, $key, $default = null, $array = true)
    {

        if (!isset($params[$key])) {
            if (null !== $default) {
                return $default;
            }
            throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
        }

        if (\is_array($params[$key]) || \is_object($params[$key])) {
            return $params[$key];
        }

        if ('fdata' == $key && empty($params['encrypt_params'])) {
            return \json_decode(common\Utils::fdataUnpack(urldecode($params['fdata'])), $array);
        }

        return \json_decode($this->decodeParams($params[$key]), $array);
    }

    protected function _getZPack($key, $default = null, array $params = null, $array = true)
    {
        if (empty($params)) {
            $params = $this->params;
        }

        if (!isset($params[$key])) {
            if (null !== $default) {
                return $default;
            }
            throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
        }

        if (\is_array($params[$key]) || \is_object($params[$key])) {
            return $params[$key];
        }

        return \json_decode(common\Utils::fdataUnpack(urldecode($params[$key])), $array);
    }

    protected function _getJson($key, $default = null, array $params = null, $array = true)
    {
        if (empty($params)) {
            $params = $this->params;
        }

        if (!isset($params[$key])) {
            if (null !== $default) {
                return $default;
            }
            throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
        }

        if (\is_array($params[$key]) || \is_object($params[$key])) {
            return $params[$key];
        }

        if ('fdata' == $key && empty($params['encrypt_params'])) {
            return \json_decode(common\Utils::fdataUnpack(urldecode($params['fdata'])), $array);
        }

        return \json_decode($this->decodeParams($params[$key]), $array);
    }

    protected function getArray(array $params, $key, $default = null)
    {

        if (!isset($params[$key])) {
            if (null !== $default) {
                return $default;
            }
            throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
        }

        if (\is_array($params[$key])) {
            return $params[$key];
        }

        return [];
    }

    protected function _getArray($key, $default = null, array $params = null)
    {
        if (empty($params)) {
            $params = $this->params;
        }

        if (!isset($params[$key])) {
            if (null !== $default) {
                return $default;
            }
            throw new common\GameException("no params {$key}", common\ERROR::PARAM_ERROR);
        }

        if (\is_array($params[$key])) {
            return $params[$key];
        }

        return [];
    }

    protected function decodeParams($paramContent)
    {
        if (isset($this->params['encode']) && $this->params['encode'] == "base64") {
            return base64_decode($paramContent);
        } else {
            return urldecode($paramContent);
        }
    }


    /**
     * 跳转
     * @param $action
     * @param $method
     * @param $params
     * @return array
     */
    public static function jump($action, $method, $params = array(), $data = [])
    {

        $url = ZRoute::makeUrl($action, $method, $params);
        if (common\Utils::isAjax()) {
            return array(
                '_view_mode' => 'Json',
                'target' => 'top',
                'code' => isset($data['code']) ? $data['code'] : 0,
                'url' => $url,
                'data' => $data,
            );
        }
        header('Location: ' . $url);
        return null;
    }

    public static function jumpToUrl($url, $data = [])
    {
        if (common\Utils::isAjax()) {
            return array(
                '_view_mode' => 'Json',
                'target' => 'top',
                'code' => isset($data['code']) ? $data['code'] : 0,
                'url' => $url,
                'data' => $data,
            );
        }
        header('Location: ' . $url);
        return null;
    }


}
