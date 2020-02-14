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
		} catch (\PDOException $e) {
		     throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
		echo '<h1>Tasks</h2>';
        $tasks = $conn->query('SELECT *,(SELECT MAX(days_ago) FROM task_log
										WHERE user_ID = 1 AND task_ID = t.ID
										AND days_ago = row_num
										ORDER BY `log_date` DESC) success FROM tasks t;');
		while ($task = $tasks->fetch()){
			 try{
    			    $logs = $conn->prepare('SELECT * FROM task_log WHERE task_ID = :task_ID AND user_ID = :user_ID');
    			    $logs->execute(['task_ID' => $task['ID'], 'user_ID' => 1]);
			    } catch (\PDOException $e) {
        		     throw new \PDOException($e->getMessage(), (int)$e->getCode());
        		}
                while($log = $logs->fetch()){
                        $days[strtotime('midnight',$log['log_date'])] +=1; 
                }

			    echo "<h2>{$task['label']}</h2>
			    <p>{$task['descr']}</p>
			    <dl>
			        <dt>Logging Streak:</dt><dd>".((int)$task['success'])."<dd>
			        <dt>Success Streak:</dt><dd>".((int)$task['success'])."<dd>
			    </dl>
			    <a href='#'>Task Analytics</a>
			    
			    <table>
			        <thead>
			            <tr>
			                <th>Log History</th>
			            </tr>
			        </thead>";
			        	$labels = [];
			        	$data = [];
			        	for ($i=strtotime('today midnight'); $i > strtotime('1 week ago'); $i-=86400){
			        		echo "<tr><td>".jewishdate($i)."</td><td>".($days[$i]?'Logged':'<a href="log_entry.php?task=1&date='.$i.'" target="_blank">Log Now</a>')."</td></tr>";
			   				array_unshift($labels, jewishdate($i));
	                        array_unshift($data,(int)$days[$i]);

                        }
			    echo '</table>';
			}
		?>
		<div class="container" style="width:50%;margin:50px auto;"></div>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.js"></script>
		<script>
		window.onload = function() {
			var container = document.querySelector('.container')
		       var div = document.createElement('div');
				div.classList.add('chart-container');

				var canvas = document.createElement('canvas');
				div.appendChild(canvas);
				container.appendChild(div);

				var ctx = canvas.getContext('2d');
		    var myLineChart = new Chart(ctx,  {
				type: 'line',
				data: {
					labels: <?php echo json_encode($labels);?>,
					datasets: [{
						label: 'Daily Mikvah',
						steppedLine: true,
						data: <?php echo json_encode($data);?>,
						borderColor:"rgb(54, 162, 235)",
						fill: true,
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Daily Mikvah',
					},
					scales: {
                    yAxes: [{
                        ticks: {
                            max: 1,
                            min: 0,
                            stepSize: 1
                        }
                    }]
                }
				}
			});
		};
		</script>
</body>
</html>

