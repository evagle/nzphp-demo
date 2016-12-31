<?php

$config = array(

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => true,

    /*
    |--------------------------------------------------------------------------
    | Application Server Mode
    |--------------------------------------------------------------------------
    |
    | You can choose Http/Socket/Cli/Rpc mode.
    |
    */
    'server_mode' => 'Http',

    /*
    |--------------------------------------------------------------------------
    | Application Project Name
    |--------------------------------------------------------------------------
    |
    | Give a name for your project.
    |
    */
    'project_name' => 'nzphp-demo',

    'app_path' => 'app',
    'ctrl_path' => 'controllers',
    'default_ctrl_name' => 'main\\main',
    'default_method_name' => "main",

    'serialize_type' => 'Msgpack',

    'view_mode'=> 'Php',

    /**
     * Exception and error handler
     */
    'exception_handler' => 'common\AppException::exceptionHandler',
    'fatal_handler' => 'common\AppException::fatalHandler',
    'error_handler' => 'common\AppException::errorHandler',

    'status_waring' => 1,
    'status_error' => 2,
    'app_host'=> isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "",
    'static_server'=> '/static/',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Shanghai',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    'time_zone' => 'Asia/Shanghai'
);

if (file_exists(__DIR__.'/includes.config.php')) {
    $config += include 'includes.config.php';
}

return $config;