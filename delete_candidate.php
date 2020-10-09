<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$name = $_POST['name'];
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
	$sql = "delete from candidate where name='$name'";
	$res = $conn->query($sql);
	if($res===TRUE){

		echo '<script>window.alert("Deleted Successfully!")</script>';
		echo "<script>setTimeout(function(){window.location.href='admin.html'},100);</script>";
		}

	else{
		echo '<script>window.alert("Error Occured Try Again!")</script>';
		echo "<script>setTimeout(function(){window.location.href='delete_candidate.html'},100);</script>";
	}

}


$conn->close();

?>
