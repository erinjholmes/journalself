<?php
$DBhostname = '198.57.150.36';
$DBusername = 'mikityuk_01';
$DBpassword = 'karabas00BARABAS';
$DBname = 'mikityuk_db';

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
