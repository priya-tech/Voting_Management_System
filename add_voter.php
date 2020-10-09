<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$voterName = $_POST['voterName'];
	$voterID = $_POST['voterID'];
}


$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_evoting';

$conn = new mysqli($server,$user,$pass,$db);

if($conn->connect_error){
	echo "<br>";
	echo "<div align = 'center'>";
	echo "Internal Database Error !";
	echo "</div>";
}
else{
	$sql = "insert into voter values('$voterName', '$voterID')";
	$res = $conn->query($sql);
	if($res===TRUE){

		echo '<script>window.alert("Registered Successfully!")</script>';
		echo "<script>setTimeout(function(){window.location.href='cpanel.php'},100);</script>";
		}

	else{
		echo '<script>window.alert("Error Occured Try Again!")</script>';
		echo "<script>setTimeout(function(){window.location.href='add_voter.html'},100);</script>";
	}

}


$conn->close();

?>
