<?php
ini_set('display_errors', 1);
$con = mysqli_connect("localhost","admin","Pa$\$w0rd","temperatura");
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
} 
mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");

$senzor=$_REQUEST['senzor'];

$sql = "SELECT * FROM temperatura WHERE senzor = '" . $senzor . "' order by id desc limit 150";
$result = mysqli_query($con, $sql);

$podaci=array();
while ($row = mysqli_fetch_assoc($result)){
//	printf ("<p>%s, %s, %s, %s </p>", $row["id"], $row["senzor"], $row["temperatura"],$row["vreme"]); 
	array_push($podaci, array(
		'id' => $row["id"],
		'senzor' => $row["senzor"],
		'temperatura' => $row["temperatura"],
		'vreme' => $row["vreme"]));
}
//print_r($podaci);
echo json_encode($podaci);
mysqli_free_result($result);
mysqli_close($con);
?> 
