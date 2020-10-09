
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

    <style>
      .headerFont{
        font-family: 'Ubuntu', sans-serif;
        font-size: 24px;
      }

      .subFont{
        font-family: 'Raleway', sans-serif;
        font-size: 14px;

      }

      .specialHead{
        font-family: 'Oswald', sans-serif;
      }

      .normalFont{
        font-family: 'Roboto Condensed', sans-serif;
      }
    </style>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

	<div class="container">
  	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse
    " role="navigation">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
          <a href="index.html" class="navbar-brand headerFont text-lg"><strong>eVoting</strong></a>
        </div>

        <div class="collapse navbar-collapse" id="example-nav-collapse">
          <ul class="nav navbar-nav">
            <!--
            <li><a href="#featuresTab"><span class="subFont"><strong>Features</strong></span></a></li>
            <li><a href="#feedbackTab"><span class="subFont"><strong>Feedback</strong></span></a></li>
            <li><a href="#"><span class="subFont"><strong>About</strong></span></a></li>
        	-->
          </ul>


          <button type="submit" class="btn btn-success navbar-right navbar-btn"><span class="normalFont"><strong>Admin Panel</strong></span></button>
        </div>

      </div> <!-- end of container -->
    </nav>


    <div class="container" style="padding-top:150px;">
    	<div class="row">
    		<div class="col-sm-4"></div>
    		<div class="col-sm-4 text-center" style="border:2px solid gray;padding:50px;">

    			<?php
          session_start();
          require('config.php');





					if(isset($_POST["submit"])){
					if(isset($_POST["voterName"]) && isset($_POST["voterEmail"]) && isset($_POST["voterID"]) && isset($_POST["selectedCandidate"]))
					{
						$name= test_input($_POST["voterName"]);
						$email= test_input($_POST["voterEmail"]);
						$voterID= test_input($_POST["voterID"]);
						$selection= test_input($_POST["selectedCandidate"]);
					}
				}
				else
				{
					echo "<br>All Field Required";
				}

       $DB_HOST= "localhost";
       $DB_USER="root";
       $DB_PASSWORD="";
       $DB_NAME="db_evoting";


        $conn= @mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME)
        or die("Couldn't Connect to Database :");

        $sql1="SELECT * from voter where voterid='$voterID'";
        $result=$conn->query($sql1);
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
              if($name==$row['name'] && $voterID == $row['voterid']){
                $sql2="SELECT * from tbl_users where voter_id='$voterID'";
                $res=$conn->query($sql2);

                if($res->num_rows > 0){
                  echo '<script>window.alert("You are Already voted")</script>';
                  echo "<script>setTimeout(function(){window.location.href='index.html'},100);</script>";
                }
                else{
        				$_SESSION['name'] = $row['name'];
                $sql= "INSERT INTO db_evoting.tbl_users VALUES(null,'".$name."','".$email."','".$voterID."','".$selection."');";

                if(mysqli_query($conn, $sql)){
                  echo "<img src='images/success.png' width='70' height='70'>";
                  echo "<h3 class='text-info specialHead text-center'><strong>". $row["name"]. " YOU'VE  SUCCESSFULLY   VOTED.</strong></h3>";
                  echo "<a href='index.html' class='btn btn-primary'> <span class='glyphicon glyphicon-ok'></span> <strong> Finish</strong> </a>";
                }


                else
                {
                  echo "<img src='images/error.png' width='70' height='70'>";
                  echo "<h3 class='text-info specialHead text-center'><strong> SORRY! WE'VE SOME ISSUE..</strong></h3>";
                  echo "<a href='index.html' class='btn btn-primary'> <span class='glyphicon glyphicon-ok'></span> <strong> Finish</strong> </a>";
                }

            }
          }
        }
      }
        else{
            echo '<script>window.alert("You are not allowed to give your vote! Contact your admin")</script>';
            echo "<script>setTimeout(function(){window.location.href='index.html'},100);</script>";
          }



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
           $mail->Subject = "Voted Successfully";

           /* Set the mail message body. */
           $mail->Body = "Your vote has been submitted succesfully . Please give your feeback about our portal in the feeback section";

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



				?>



    		</div>
    		<div class="col-sm-4"></div>
    	</div>
    </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
