<?php

header('content-Type: text/html; charset=utf-8');
session_start();
date_default_timezone_set('PRC');
require ('zhimin/core/Zhimin.php');
Zhimin::run(realpath('app'));

?>
