<?php

namespace common;

use utils\notify\NotifyManager;
use utils\notify\NotifyType;
use zhconvert\ZhConvert;
use ZPHP\Common\Formater,
    ZPHP\View\Factory as ZView,
    ZPHP\Core\ZConfig as ZConfig;
use ZPHP\Common\ZLog;
use ZPHP\Protocol\Response;
use ZPHP\Protocol\Request;
/**
 * 游戏异常基类
 *
 * @package exception
 *
 */
class AppException extends \Exception
{

    public $realCode = '';

    /**
     * 执行过程中产生的所有异常
     *
     * @var array
     */
    private static $exceptions = array();

    public function __construct($message, $code = 0)
    {
        $this->realCode = $code;
        parent::__construct($message, $code);
        self::$exceptions[] = $this;
    }

    /**
     * 获取执行过程中的异常发生次数
     *
     * @return int
     */
    public static function getExceptionNum()
    {
        $count =  \count(self::$exceptions);
        self::$exceptions = [];
        return $count;
    }

    public static function init()
    {
        self::$exceptions = [];
    }

    /**
     * 获取执行过程中的发生的最后一次异常
     *
     * @return AppException
     */
    public static function getLastException()
    {
        return empty(self::$exceptions) ? null : \end(self::$exceptions);
    }

    public static function removeLast()
    {
        return \array_pop(self::$exceptions);
    }

    public static function fatalHandler()
    {
        $error = \error_get_last();
        if(empty($error)) {
            return;
        }
        if(!in_array($error['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR))) {
            return;
        }

        $config = ZConfig::get('project');
        $debug = ZConfig::get('debug');
        $viewMode = ZConfig::getField('project', 'view_mode', 'Json');
        $exceptionView = ZView::getInstance($viewMode);
        if('Php' === $viewMode) {
            if($debug) {
                $exceptionView->setTpl('public/exception.php');
            } else {
                $exceptionView->setTpl('public/error.php');
            }
        }
        $exceptionView->setModel(Formater::fatal($error));
        $model = $exceptionView->getModel();
        ZLog::emergency("fatal", $model);

        $info['data'] = null;
        if ($debug) {
            $info['debug'] = $model;
        }
        $message = ErrorCode::getErrorMessage(ErrorCode::SYSTEM_ERROR);
        $info['msg'] = $message;
        $info['ts'] = time();
        $info['status'] = $config['status_error'];

        Response::status('200');
        Response::display($info);
    }

    /**
     * 异常处理回调函数
     *
     * @param \Exception $exception
     */
    public static function exceptionHandler($exception)
    {
        $config = ZConfig::get('project');
        $debug = ZConfig::get('debug');
        $viewMode = ZConfig::getField('project', 'view_mode', 'Json');
        $exceptionView = ZView::getInstance($viewMode);
        if('Php' === $viewMode) {
            if($debug) {
                $exceptionView->setTpl('public/exception.php');
            } else {
                $exceptionView->setTpl('public/error.php');
            }
        }
        if ($exception instanceof \Exception) {
            $exceptionView->setModel(Formater::exception($exception));
        } else {
            $exceptionView->setModel(Formater::error($exception));
        }
        $model = $exceptionView->getModel();
        $info['data'] = null;
        if ($debug) {
            $info['debug'] = $model;
        }
        if(!empty($exception->realCode)) {
            $info['msg'] = ErrorCode::getErrorMessage($exception->realCode);
            $info['code'] = $exception->realCode;
            $errorLevel = ErrorCode::getErrorLevel($exception->realCode);
            if ($errorLevel == "error") {
                ZLog::error("exception", $model);
            } else {
                ZLog::emergency("exception", $model);
            }
        } else{
            $info['msg'] = ErrorCode::getErrorMessage(ErrorCode::SYSTEM_ERROR);
            $info['code'] = $model['code'];
            ZLog::emergency("exception", $model);
        }

        $info['status'] = $config['status_error'];

        return Response::display($info);
    }

    public static function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        switch ($errno) {
            case E_USER_ERROR:
                break;

            case E_USER_WARNING:
                break;

            case E_USER_NOTICE:
                break;
            case E_STRICT:

                break;
            case E_WARNING:
                break;

            case E_NOTICE:
                break;

            default:
                break;
        }
    }

}
