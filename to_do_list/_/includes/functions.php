<?php
//prep fields for mysql
function mysql_prep($value){
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string"); // PHP >= v4.3
	if($new_enough_php){
		//undo any magic quote effects and apply mysql_real_escape_string instead
		if($magic_quotes_active){
			$value = mysql_real_escape_string($value);
		}else{
			//if PHP before v4.3 add slashes manually if magic quotes are not on
			if(!$magic_quotes_active){
				$value = addslashes($value);
			}
		}
	}
	return $value;
}
//for error testing
function confirm_query($result_set) {
	if (!$result_set) {
		die("Database connection failed: " . mysql_error());
	}
}
// validation
function form_validation($field){
		
		$error_message = "";
		
	if(empty($field)){
	
	 	$error_message = "Ummm...you didn't type anything!";
	 	
	 	return $error_message;
	 	
	}else{
		global $db;
		$query = "SELECT item FROM list_items
			WHERE item = '{$field}'
			LIMIT 1";
		$result = mysql_query($query, $db);
		confirm_query($result);
		if($todo_exists = mysql_fetch_array($result)){
		
			$error_message = "This is already on your list!";
	
			return $error_message;
		}
	}
}
// counts number of todos that exist
function count_todos(){
	global $db;
	$count = 0;
	
	$query = "SELECT item FROM list_items";
		$result = mysql_query($query, $db);
		confirm_query($result);
		
		while($todo_exists = mysql_fetch_array($result)){
			$count += 1;
		}
		return $count;
}
//checks if todos were checked off as complete
function check_if_complete($item){
	global $db;
	$query = "SELECT complete FROM list_items WHERE item = '{$item}'";
		$complete = mysql_query($query, $db);
		confirm_query($complete);
		return $complete;
} 
//gets all todos
function get_todo_items() {
	global $db;
	$query = "SELECT * FROM list_items";
		$items = mysql_query($query, $db);
		confirm_query($items);
		return $items;
}
?>
