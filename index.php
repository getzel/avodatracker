<!DOCTYPE html>
<html>
<head>
	<title>It's Up to Us! > AvodaTracker 0.1</title>
</head>
<body>
	<?php 
		error_reporting(E_ALL);
		try{
			$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",DB_USER, DB_PASSWORD, [
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
			    echo "<h2>{$task['label']}</h2>
			    <p>{$task['descr']}</p>
			    <dl>
			        <dt>Logging Streak:</dt><dd>{$task['success']}<dd>
			        <dt>Success Streak:</dt><dd>{$task['success']}<dd>
			    </dl>
			    <a href='#'>Task Analytics</a>
			    
			    <table>
			        <thead>
			            <tr>
			                <th>Log History</th>
			            </tr>
			        </thead>";
			    try{
    			    $logs = $conn->prepare('SELECT * FROM task_log WHERE task_ID = :task_ID AND user_ID = :user_ID');
    			    $logs->execute(['task_ID' => $task['ID'], 'user_ID' => 1]);
			    } catch (\PDOException $e) {
        		     throw new \PDOException($e->getMessage(), (int)$e->getCode());
        		}
                while($log = $logs->fetch()){
                        $Today = gregoriantojd(date('n',$log['log_date']),date('j',$log['log_date']),date('Y',$log['log_date'])); 
                        $Month = jdmonthname($Today,4);
                        $Date = jdtojewish($Today); 
                        list($notused, $Day, $Year) = explode('/',$Date);
                    echo "<tr><td>$Month $Day, $Year ({$log['days_ago']} days ago)</td></tr>";
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
					labels: ['Shevat 11','Shevat 12', 'Shevat 13', 'Shevat 14', 'Shevat 15', 'Shevat 16', 'Shevat 17'],
					datasets: [{
						label: 'Daily Mikvah',
						steppedLine: true,
						data: [0,1,0,0,1,1,1],
						borderColor:"rgb(54, 162, 235)",
						fill: true,
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Daily Mikvah..',
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