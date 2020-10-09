<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $subject=$_POST['subject'];
  $message=$_POST['message'];
}


/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/* If you installed PHPMailer without Composer do this instead: */
require '/opt/lampp/htdocs/VotingPortal/PHPMailer-master/src/Exception.php';
require '/opt/lampp/htdocs/VotingPortal/PHPMailer-master/src/PHPMailer.php';
require '/opt/lampp/htdocs/VotingPortal/PHPMailer-master/src/SMTP.php';


/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$mail = new PHPMailer(TRUE);

/* Open the try/catch block. */
try {
   /* Set the mail sender. */
   $mail->setFrom('priyavadhanisankar@gmail.com', 'Priya');

   /* Add a recipient. */
   $mail->addAddress($email, $name);

   /* Set the subject. */
   $mail->Subject = $subject;

   /* Set the mail message body. */
   $mail->Body = $message;

   /* Use SMTP. */
$mail->isSMTP();

/* Google (Gmail) SMTP server. */
$mail->Host = 'smtp.gmail.com';

/* SMTP port. */
$mail->Port = 587;

/* Set authentication. */
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';

/* Username (email address). */
$mail->Username = 'priyavadhanisankar@gmail.com';

/* Google account password. */
$mail->Password = 'priya@2501';

   /* Finally send the mail. */
   $mail->send();
}
catch (Exception $e)
{
   /* PHPMailer exception. */
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   /* PHP exception (note the backslash to select the global namespace Exception class). */
   echo $e->getMessage();
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
	$sql = "insert into feedback values('$name','$message')";
	$res = $conn->query($sql);
	if($res===TRUE){

		echo '<script>window.alert("Mail Sent Successfully!")</script>';
		echo "<script>setTimeout(function(){window.location.href='index.html'},100);</script>";
		}

	else{
		echo '<script>window.alert("Error Occured Try Again!")</script>';
		echo "<script>setTimeout(function(){window.location.href='feedback.html'},100);</script>";
	}

}

?>
