<?php
////////////////////////////////////
///////    Configuration 	////////
////////////////////////////////////
/////// Edit This File Only ////////
////////////////////////////////////

$host = "127.0.0.1"; 	                // Host Name (Example: BlaBla\SQLEXPRESS or IP)
$user = "sa"; 							// SQL User (Default: sa)
$pass = "password sql"; 				// SQL Pass (As you put it when you installed the program)
$dbname = "GunzDB"; 					// DataBase Name

$connect = odbc_connect("Driver={SQL Server};Server={$host}; Database={$dbname}", $user, $pass) or die("Can't connect the MSSQL server. <b>Check ./modules/config.php<b>");

?>