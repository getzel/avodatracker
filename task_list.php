<?php 
	require 'inc/base.php';
	require 'inc/conn.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>AvodaTracker 0.1</title>
</head>
<body>
	<h1>Task Library</h1>
	<?php 
	$tasks = $conn->query('SELECT * tasks t;');
	while ($task = $tasks->fetch()){
		 echo "<h2>{$task['label']}</h2>
			    <p>{$task['descr']}</p>
			    <a href='Commit to this task'></a>";
			    
			}
	}?>
</body>
</html>	
