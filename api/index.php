<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('connection.php');

$data = json_decode(file_get_contents('php://input'), true);

//print_r($data);

file_put_contents("abc.txt", json_encode($data));
foreach($data['measurements'] as $measure){
 print_r($measure);

	$sql = "INSERT INTO Table1(controller_id, measurement_time,sensor_id,temperature,humidity,pressure) VALUES (?,?,?,?,?,?)";
			$stmt= $conn->prepare($sql);
			

			$stmt->execute([$data['controller_id'], $data['measurement_time'], $measure['sensor_id'],$measure['temperature'],$measure['humidity'],$measure['pressure']]);
}
