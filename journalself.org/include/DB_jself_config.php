<?php
$DBhostname = 'hostname';
$DBusername = 'username';
$DBpassword = 'password';
$DBname = 'dbname';

$DBcon = new mysqli($DBhostname, $DBusername, $DBpassword, $DBname);
if($DBcon->connect_error)
{
   $connection_error_flag=true; //{die("Connection with MySQL database failed: " . $DBcon->connect_error);} // Check connection
   $connection_error_message = $DBcon->connect_error;
}
else
{
   $connection_error_flag=false;
   $connection_error_message = "";
}
?>
