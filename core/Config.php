<?php

session_start();
ob_start();

define('URL','http://localhost/desafio/');

define('CONTROLLER','Home');
define('METODO','index');

//Crendenciais de acesso ao BD
define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DBNAME','webjump');