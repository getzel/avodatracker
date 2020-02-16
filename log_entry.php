<?php require 'inc/header.php';	
		try{
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
<?php require 'inc/footer.php';	