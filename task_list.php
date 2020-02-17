<?php require 'inc/header.php';?>
		<h1>Task Library</h1>
		<?php 
		$tasks = $conn->query('SELECT * FROM tasks t;');
		while ($task = $tasks->fetch()){
			 echo "<h2>{$task['label']}</h2>
				    <p>{$task['descr']}</p>
				    <a href=''>Commit to this task</a>
				    <a href='task.php?ID='{$task['ID']}>Edit this task</a>";
		}?>
<?php require 'inc/footer.php';	
