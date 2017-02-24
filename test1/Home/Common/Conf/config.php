<?php
return array(
	//'配置项'=>'配置值'
	
	//******************************** ThinkPHP 相关配置 ***************************
    'MODULE_ALLOW_LIST' => array('Home'),   // 模块列表访问去掉Home
    //'DEFAULT_MODULE'    => 'Home',          // 默认访问模块
    'DEFAULT_CONTROLLER'=> 'Login',            // 默认控制器
    'DEFAULT_ACTION'    => 'index',            // 默认方法
    'TMPL_L_DELIM'      => '<{',               // 左侧符号
    'TMPL_R_DELIM'      => '}>',               // 右侧符号

    'SHOW_ERROR_MSG'    => true,               // 显示错误信息
    'URL_MODEL'         => 2,                  // URL模式

    'DB_FIELD_CACHE'    => false,              //关闭缓存
    'HTML_CACHE_ON'     => false,              //关闭缓存

    'SESSION_AUTO_START'=> true,               // 是否开启session
    //'LOG_RECORD'      => true,               // 开启日志
    //'LOG_LEVEL'       => 'EMERG,ALERT,CRIT,ERR,WARN ,NOTICE ,INFO ,DEBUG,SQL '

	
);