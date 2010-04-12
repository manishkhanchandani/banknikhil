<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connstory = "localhost";
$database_connstory = "story";
$username_connstory = "root";
$password_connstory = "";
$connstory = mysql_connect($hostname_connstory, $username_connstory, $password_connstory) or trigger_error(mysql_error(),E_USER_ERROR); 
?>