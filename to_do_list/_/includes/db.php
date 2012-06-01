<?php
// create database connection
$db = mysql_connect("localHost:8889", "root", "root");
if (!$db) {
	die("Database connection failed: " . mysql_error());
}
// Select database
$db_select = mysql_select_db("todo_list", $db);
if (!$db_select) {
	die("Database connection failed: " . mysql_error());
}

?>