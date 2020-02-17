<?php require 'inc/header.php';
	if($_GET['ID']){
		$task = $conn->prepare('SELECT * FROM tasks WHERE ID = :ID;');
		$task->execute(['ID' => $_GET['ID']]);
		$task = $task->fetch();
	}

	?><form>
		<label>Task Name <input type="text" name="label" value="<?php echo $task['label'];?>"><label>
		<label>Task Description <textarea name="descr"><?php echo $task['descr'];?></textarea> <label>
		<label>Task Prompt <textarea name="metric_label"><?php echo $task['metric_label'];?></textarea><label>
		<label>Task Recurs 
			<select name="schedule">
				<?php foreach ($sched_opts as $opt){?>
					<option value="<?php echo $opt;?>" <?php echo $task['schedule']==$opt?'selected':'';?>><?php echo ucfirst($opt);?></option>
				<?php } ?>
			</select><label>
		<input type="hidden" name="metric" value="E">
			

	</form>
<?php require 'inc/footer.php';?>