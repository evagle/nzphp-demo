<?php
function swoole_version(){}

function swoole_cpu_num(){}

/**
 * @param $serv_host[required]
 * @param $serv_port[required]
 * @param $serv_mode[optional]
 * @param $sock_type[optional]
 * @return mixed
 */
function swoole_server_create($serv_host, $serv_port, $serv_mode=null, $sock_type=null){}

/**
 * @param $zobject[required]
 * @param $zset[required]
 * @return mixed
 */
function swoole_server_set($zobject, $zset){}

/**
 * @param $zobject[required]
 * @return mixed
 */
function swoole_server_start($zobject){}

/**
 * @param $zobject[required]
 * @param $conn_fd[required]
 * @param $send_data[required]
 * @param $from_id[optional]
 * @return mixed
 */
function swoole_server_send($zobject, $conn_fd, $send_data, $from_id=null){}

/**
 * @param $zobject[required]
 * @param $conn_fd[required]
 * @param $filename[required]
 * @return mixed
 */
function swoole_server_sendfile($zobject, $conn_fd, $filename){}

/**
 * @param $zobject[required]
 * @param $fd[required]
 * @return mixed
 */
function swoole_server_close($zobject, $fd){}

/**
 * @param $zobject[required]
 * @param $ha_name[required]
 * @param $cb[required]
 * @return mixed
 */
function swoole_server_handler($zobject, $ha_name, $cb){}

/**
 * @param $zobject[required]
 * @param $ha_name[required]
 * @param $cb[required]
 * @return mixed
 */
function swoole_server_on($zobject, $ha_name, $cb){}

/**
 * @param $zobject[required]
 * @param $host[required]
 * @param $port[required]
 * @param $sock_type[required]
 * @return mixed
 */
function swoole_server_addlisten($zobject, $host, $port, $sock_type){}

/**
 * @param $zobject[required]
 * @param $interval[required]
 * @return mixed
 */
function swoole_server_addtimer($zobject, $interval){}

function swoole_server_gettimer(){}

/**
 * @param $zobject[required]
 * @param $data[required]
 * @param $worker_id[optional]
 * @return mixed
 */
function swoole_server_task($zobject, $data, $worker_id=null){}

/**
 * @param $zobject[required]
 * @param $data[required]
 * @param $timeout[optional]
 * @param $worker_id[optional]
 * @return mixed
 */
function swoole_server_taskwait($zobject, $data, $timeout=null, $worker_id=null){}

/**
 * @param $zobject[required]
 * @param $data[required]
 * @return mixed
 */
function swoole_server_finish($zobject, $data){}

/**
 * @param $zobject[required]
 * @return mixed
 */
function swoole_server_reload($zobject){}

/**
 * @param $zobject[required]
 * @return mixed
 */
function swoole_server_shutdown($zobject){}

/**
 * @param $zobject[required]
 * @param $from_id[required]
 * @return mixed
 */
function swoole_server_heartbeat($zobject, $from_id){}

/**
 * @param $zobject[required]
 * @param $fd[required]
 * @param $from_id[optional]
 * @return mixed
 */
function swoole_connection_info($zobject, $fd, $from_id=null){}

/**
 * @param $zobject[required]
 * @param $start_fd[required]
 * @param $find_count[required]
 * @return mixed
 */
function swoole_connection_list($zobject, $start_fd, $find_count){}

/**
 * @param $fd[required]
 * @param $cb[required]
 * @return mixed
 */
function swoole_event_add($fd, $cb){}

function swoole_event_set(){}

/**
 * @param $fd[required]
 * @return mixed
 */
function swoole_event_del($fd){}

function swoole_event_exit(){}

function swoole_event_wait(){}

/**
 * @param $fd[required]
 * @param $data[required]
 * @return mixed
 */
function swoole_event_write($fd, $data){}

/**
 * @param $interval[required]
 * @param $cb[required]
 * @return mixed
 */
function swoole_timer_add($interval, $cb){}

/**
 * @param $interval[required]
 * @return mixed
 */
function swoole_timer_del($interval){}

function swoole_timer_after(){}

function swoole_timer_tick(){}

function swoole_timer_clear(){}

function swoole_async_set(){}

function swoole_async_read(){}

function swoole_async_write(){}

function swoole_async_readfile(){}

function swoole_async_writefile(){}

function swoole_async_dns_lookup(){}

function swoole_client_select(){}

function swoole_set_process_name(){}

function swoole_get_local_ip(){}

function swoole_strerror(){}

function swoole_errno(){}

