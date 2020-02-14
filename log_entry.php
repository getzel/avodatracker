<?php 
	function jewishdate($ts){
		$d = gregoriantojd(date('n',$ts),date('j',$ts),date('Y',$ts)); 
        $m = jdmonthname($d,4);
        $d = explode('/',jdtojewish($d)); 
        return "{$d[1]} $m {$d[2]}";
	}
	?>
<!DOCTYPE html>
<html>
<head>
	<title>AvodaTracker 0.1</title>
</head>
<body>
	<?php 
		error_reporting(E_ALL);
		try{
			$conn = new PDO("mysql:host=localhost;dbname=avoda;charset=utf8mb4", 'avoda_db', 'y}jh!u]wLx&+', [
				    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				    PDO::ATTR_EMULATE_PREPARES   => false]);
				    //once tzs are loaded , PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = 'UTC'"
			
			if($_REQUEST['entry']=='on'){
 				$entry = $conn->prepare('INSERT INTO `task_log` (`task_ID`, `user_ID`, `success`, `log_date`) VALUES (:task, 1,1,:date)');
			    if($entry->execute(['task' => $_REQUEST['task'],'date' => $_REQUEST['date']])){
			    	echo 'Entry successfully saved. <a href="index.php">Return to tasks page.</a>';
			    }else{
			    	echo 'Error';
			    }
			}else{
			    $task = $conn->prepare('SELECT * FROM tasks WHERE ID = :ID');
			    $task->execute(['ID' => $_REQUEST['task']]);
		    	
			    while ($t = $task->fetch()){
					echo '<h1>Log Entry for '.$t['label'].' - '.jewishdate($_REQUEST['date']).'</h1>
					<form>
						<label><input type="checkbox" name="entry"> '.$t['metric_label'].'</label>
						<input type="hidden" name="task" value="'.$_REQUEST['task'].'">
						<input type="hidden" name="date" value="'.$_REQUEST['date'].'">
						<br><input type="submit" value="Log This">
					</form>';
				}
			}
		}catch (\PDOException $e) {
		     throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
	?>
</body>

