<?php
    
$dbname = ''; // Enter DB Here
$username = ''; // Enter Username Here
$password = ''; // Enter Password Here

$conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
  $result = $conn->query('SELECT *
		  FROM $dbname.{table}
		  WHERE time > DATE_SUB(NOW(), INTERVAL 24 HOUR)
		  AND time <= NOW();');
  
  $rows = array();
  $table = array();
  $table['cols'] = array(array('label' => 'Datetime', 'type' => 'string'),array('label' => 'Temp', 'type' => 'number'));
    
  foreach($result as $r) {

  $data = array();
  $data[] = array('v' => (string) $r['datetime']); 
  $data[] = array('v' => (int) $r['temp']); 
      
  $rows[] = array('c' => $data);
  
  }

$table['rows'] = $rows;

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

try {
  $result2 = $conn->prepare("SELECT `datetime`, `temp` $dbname.{table}
		  WHERE time > DATE_SUB(NOW(), INTERVAL 1 HOUR)
		  AND time <= NOW();");
		  
  $result2->execute();

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
	
?>