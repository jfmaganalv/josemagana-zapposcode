<?php require_once("_/includes/db.php"); ?>
<?php require_once("_/includes/functions.php"); ?>
<?php	
		$deleteBtn = "";
		$saveBtn = "";
		$editable = 0;
				
		if(isset($_POST['toggle_todo'])) {
		
			$todo_item = $_POST['todo_item'];
			$complete = $_POST['toggle'];
			
			$query = "UPDATE list_items SET 
						complete = '{$complete}'
						WHERE item = '{$todo_item}'";
						
						$result_set = mysql_query($query, $db);
						confirm_query($result_set);
												
		}
		// Create to-do's 
		if(isset($_POST['submit']) && isset($_POST['new_todo'])){
			//mysql sanitizing
			$new_todo = mysql_prep($_POST['new_todo']);
			
			//validate fields
			$error_message = form_validation($_POST['new_todo']);
								
			$todos_count = count_todos();
			
			if($todos_count === 12){
				
				$error_message = "Uh oh, Looks like your board is full!";
			}
				
			if(empty($error_message)){
				
				$query = "INSERT INTO list_items (item,complete)
							VALUES( '{$new_todo}', 'no' )";
				
				$result_set = mysql_query($query, $db);
				confirm_query($result_set);			
			}	
		}
		// Display to-do edit buttons
		if(isset($_POST['edit_todo'])){
		
			$editable = 1;
	
		}
		// Update to-do's
		if(isset($_POST['save_todo'])){
		
			$editable = 1;
			$complete = "no";
			$updated_item = mysql_prep($_POST['todo_item']);
			$todo_item = $_POST['todo_item'];
			
			$todo_id = $_POST['todo_id'];
						
			$query = "UPDATE list_items SET 
						item = '{$todo_item}'
						WHERE item_id = {$todo_id}";
						$result_set = mysql_query($query, $db);
						confirm_query($result_set);
		}
		// Delete to-do's 
		if(isset($_POST['delete_todo'])){
		
			$editable = 1;	
									
			$todo_item = $_POST['todo_item'];			
			
			$query = "DELETE FROM list_items
			 		WHERE item = '{$todo_item}'";
			
			$result = mysql_query($query, $db);					
		}
?>	
<!doctype html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<meta charset="utf-8">
	
		<title>Zappos.Code() Application | To-Do List</title>
		
		<meta name="description" content="">
		<meta name="author" content="Jose Magana">

		<link rel="shortcut icon" href="_/img/favicon.ico">
		<link rel="stylesheet" href="_/css/style.css">
	</head>
	<body>
	<div id="header-wrap">
		<header class="clearfix">
			<nav>
				<p><a href="../index.html" title="Application Home">Home</a></p>
			</nav>
			<img src="_/img/project-num.jpg" alt="Project Number 2">
			<h1>To-Do List</h1>
			<h2>PHP/MySQL CRUD to-do list</h2>
		</header>		
	</div><!-- End header-stripe -->
	<div id="wrapper">
		<div class="content clearfix">
			
			<div class="todo-section">
				<div class="todo-title clearfix">
					<h3>My To-Do List:</h3> 
					<?php if ($editable === 1){
							echo "<form method=\"post\" action=\"index.php\">
								<input class=\"edit-btn\" type=\"submit\" value=\"Done\" name=\"done_todo\" />
							</form>";
						  }
						  else{
							echo "<form method=\"post\" action=\"index.php\">
								<input class=\"edit-btn\" type=\"submit\" value=\"Edit\" name=\"edit_todo\" />
							</form>";	
						  }	
					 ?>
					 <form class="add-bg" method="post" action="index.php">
						<fieldset>
							<label for="add-field">Add an item:</label><input id="add-field" type="text" maxlength="20" name="new_todo" />
							<input id="add-btn" type="submit" value="Add" name="submit" />
						</fieldset>
					</form>
				</div><!-- End todo-title -->
				<div class="todo-list">
					<?php 
						if(!empty($error_message)){ 
								echo "
								<p class=\"error-message\">{$error_message}</p>";
							}	
						if ($editable === 1){
							$deleteBtn = "<input class=\"delete-btn\" type=\"submit\" value=\"Delete\" name=\"delete_todo\" />";
							$saveBtn = "<input class=\"save-btn\" type=\"submit\" value=\"Save\" name=\"save_todo\" />";
							$todo_results = get_todo_items();
							
							echo "<ol class=\"todo-list-bg\">";
							
							while($todos = mysql_fetch_array($todo_results)){
								echo "
								<li class=\"todo-item-bg\"><form method=\"post\" action=\"index.php\">
									<fieldset class=\"item-box\">
										<input class=\"todo-item\" type=\"text\" value=\"{$todos["item"]}\" name=\"todo_item\" />
										<input class=\"edit-btn\" type=\"hidden\" value=\"{$todos["item_id"]}\" name=\"todo_id\" />"
										.$saveBtn
										.$deleteBtn											
									."</fieldset>
								</form></li>
								";
							}
							echo "</ol>";
						}else{							
							$todo_results = get_todo_items();
							
								echo "<ol class=\"todo-list-bg\">";
													
								}
								while($todos = mysql_fetch_array($todo_results)){
									
									$check = check_if_complete($todos["item"]);
									
									while($check_complete = mysql_fetch_array($check)){
										
										if ($check_complete["complete"] === "yes"){
											$value = "no";
											$cross_out = "cross-out";
										}else{
											$value = "yes";
											$cross_out = "";
										}
										echo "
											<li class=\"todo-item-bg\">
											<form method=\"post\" action=\"index.php\">
											<input type=\"hidden\" value=\"{$value}\" name=\"toggle\" />
											
											<input class=\"readonly {$cross_out}\" type=\"text\" value=\"{$todos["item"]}\" name=\"todo_item\" readonly=\"readonly\" />
											<input class=\"{$check_complete["complete"]} checkbox\" type=\"submit\" value=\"\" name=\"toggle_todo\" />
											</form></li>
										";
									}
								}
								echo "</ol>";				
					?>
				</div>
			</div><!-- todo-section -->
		</div><!-- End content -->
	</div><!-- End wrapper -->
	<div id="footer-wrap">
		<footer>
			<p><small>Zappos.code() Application -- Project #6: BONUS (THE SEQUEL)! To-do List -- Jose Magana</small></p>
		</footer>
	</div>
	</body>
</html>
<?php mysql_close($db);?>