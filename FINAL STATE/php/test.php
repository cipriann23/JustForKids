<?php
	session_start();
	//Oracle DB user name
	$username = 'STUDENT';

	// Oracle DB user password
	$password = 'STUDENT';

	// Oracle DB connection string
	$connection_string = 'localhost/xe';

	//Connect to an Oracle database
	$connection = oci_connect(
	$username,
	$password,
	$connection_string
	);

	if(isset($_GET['category'])){
       $_SESSION['category']=$_GET['category'];
 	}
 	 if(!$_SESSION['id']){
 	 	echo "<meta http-equiv=\"refresh\" content=\"0;URL=..\login.html\">";
 	 }

 	 
	// Get last question resolved checkpoint
	$stid = oci_parse($connection, "SELECT * FROM TW_checkpoint where id_kid=:id and category=:id1");
	oci_bind_by_name($stid, ":id", $_SESSION['id']);
	oci_bind_by_name($stid, ":id1", $_SESSION['category']);
	oci_execute($stid);

	$last_test=1;
    $last_question=1;
		
	while (($row = oci_fetch_row($stid)) != false) {
    	$last_test=$row[1];
    	$last_question=$row[2];
	}
	oci_free_statement($stid);
	
	// Get kid level
	$stid = oci_parse($connection, "SELECT * FROM TW_kid where id=:id");
	oci_bind_by_name($stid, ":id", $_SESSION['id']);
	oci_execute($stid);
	$age=7;
	while (($row = oci_fetch_row($stid)) != false) {
    	$parent_id=$row[1];
    	$age=$row[2];
	}

	if($age<10){
		$level='easy';
		$dificulty=0;
	}else{
		$level='hard';
		$dificulty=1;
	}
	oci_free_statement($stid);
	
	// Get question and answers
	$stid = oci_parse($connection, "SELECT * FROM TW_test where dificulty=:dif and id=:id1 and id_question=:id2 and category=:id3");
	oci_bind_by_name($stid, ":dif", $dificulty);
	oci_bind_by_name($stid, ":id1", $last_test);
	oci_bind_by_name($stid, ":id2", $last_question);
	oci_bind_by_name($stid, ":id3", $_SESSION['category']);
	oci_execute($stid);

	
	while (($row = oci_fetch_row($stid)) != false) {
    	$question=$row[4];
    	$var1=$row[5];
    	$var2=$row[6];
    	$var3=$row[7];
    	$var4=$row[8];
    	$var_corecta=$row[9];
	}
	oci_free_statement($stid);

	if($_SESSION['category']==0){
		$category='matematica';
	}
	if($_SESSION['category']==1){
		$category='geografie';
	}
	if($_SESSION['category']==2){
		$category='biologie';
	}

	$points=null;
					// Submit answer
					if(isset($_GET['choosen'])){
				        $answer=$_GET['choosen'];
				        $var_corecta;
				        if($answer!=$var_corecta){
				        	$solved=0;
				        }else{
				        	$solved=1;
				        }
				        $solved;

				        $stid = oci_parse($connection, "INSERT INTO TW_answers VALUES (:id0,:id1,:id2,:ans,:sol,CURRENT_TIMESTAMP)");
						oci_bind_by_name($stid, ":id0", $_SESSION['id']);
						oci_bind_by_name($stid, ":id1", $last_test);
						oci_bind_by_name($stid, ":id2", $last_question);
						oci_bind_by_name($stid, ":ans", $answer);
						oci_bind_by_name($stid, ":sol", $solved);
						oci_execute($stid);
						oci_free_statement($stid);

						// update checkpoint
						
						$stid = oci_parse($connection, "SELECT max(id) FROM TW_test where dificulty=:dif and id=:id1");
						oci_bind_by_name($stid, ":dif", $dificulty);
						oci_bind_by_name($stid, ":id1", $last_test);
						oci_execute($stid);

						while (($row = oci_fetch_row($stid)) != false) {
					    	$count=$row[0];
						}

						if($last_test==$count && $last_question==10){
							$last_test=1;
						}
						if($last_question==10 && $last_test!=$count){
							$last_test=$last_test+1;
						}
						

						if($last_question<10){
							$last_question=$last_question+1;
						}else{
							$last_question=1;
						}
						oci_free_statement($stid);

						$stid = oci_parse($connection, "UPDATE TW_checkpoint SET id_test=:id1, id_intrebare=:id2 where id_kid=:id 
															and category=:id3");
						oci_bind_by_name($stid, ":id", $_SESSION['id']);
						oci_bind_by_name($stid, ":id1", $last_test);
						oci_bind_by_name($stid, ":id2", $last_question);
						oci_bind_by_name($stid, ":id3", $_SESSION['category']);
						oci_execute($stid);
						oci_free_statement($stid);
						
						/// CALCULATE POINTS
						    $stid = oci_parse($connection, "SELECT get_punctaj(:id,:id1) from dual");
							oci_bind_by_name($stid, ":id", $_SESSION['id']);
							oci_bind_by_name($stid, ":id1", $last_test);
							oci_execute($stid);
							
							while (($row = oci_fetch_row($stid)) != false) {
						    	$points=$row[0];
							}
							oci_free_statement($stid);

					}
	// Send email raport
	if($points!=null && $last_question==1){
			//get parent name and email
			$stid = oci_parse($connection, "SELECT * FROM TW_LOGIN where id=:id1");
			oci_bind_by_name($stid, ":id1", $parent_id);
			oci_execute($stid);
			while (($row = oci_fetch_row($stid)) != false) {
				$p_firstname=$row[2];
				$p_lastname=$row[3];
				$p_email=$row[6];
			}
			oci_free_statement($stid);
			//get gid name 
			$stid = oci_parse($connection, "SELECT * FROM TW_LOGIN where id=:id1");
			oci_bind_by_name($stid, ":id1", $_SESSION['id']);
			oci_execute($stid);
			while (($row = oci_fetch_row($stid)) != false) {
				$k_firstname=$row[2];
				$k_lastname=$row[3];
			}
			oci_free_statement($stid);


			$to = $p_email;
            $subject  = 'Test Result';
            $message  = 'Hi '.$p_firstname.' '.$p_lastname.' copilul dvs. '.$k_firstname.' '.$k_lastname.' a obtinut '.$points.
                        ' puncte din 100 la testul de '.$_SESSION['category'];
            $headers  = 'From: [game.report.status]@gmail.com' . "\r\n" .
                        'MIME-Version: 1.0' . "\r\n" .
                        'Content-type: text/html; charset=utf-8';
            mail($to, $subject, $message, $headers);
            
	}
				    ///////////
	//// GET INFOO
	// Get last question resolved checkpoint
	$stid = oci_parse($connection, "SELECT * FROM TW_checkpoint where id_kid=:id and category=:id1");
	oci_bind_by_name($stid, ":id", $_SESSION['id']);
	oci_bind_by_name($stid, ":id1", $_SESSION['category']);
	oci_execute($stid);

	$last_test=1;
    $last_question=1;
		
	while (($row = oci_fetch_row($stid)) != false) {
    	$last_test=$row[1];
    	$last_question=$row[2];
	}
	oci_free_statement($stid);
	
	// Get kid level
	$stid = oci_parse($connection, "SELECT * FROM TW_kid where id=:id");
	oci_bind_by_name($stid, ":id", $_SESSION['id']);
	oci_execute($stid);
	$age=7;
	while (($row = oci_fetch_row($stid)) != false) {
    	$parent_id=$row[1];
    	$age=$row[2];
	}

	if($age<10){
		$level='easy';
		$dificulty=0;
	}else{
		$level='hard';
		$dificulty=1;
	}
	oci_free_statement($stid);
	
	// Get question and answers
	$stid = oci_parse($connection, "SELECT * FROM TW_test where dificulty=:dif and id=:id1 and id_question=:id2 and category=:id3");
	oci_bind_by_name($stid, ":dif", $dificulty);
	oci_bind_by_name($stid, ":id1", $last_test);
	oci_bind_by_name($stid, ":id2", $last_question);
	oci_bind_by_name($stid, ":id3", $_SESSION['category']);
	oci_execute($stid);

	
	while (($row = oci_fetch_row($stid)) != false) {
    	$question=$row[4];
    	$var1=$row[5];
    	$var2=$row[6];
    	$var3=$row[7];
    	$var4=$row[8];
    	$var_corecta=$row[9];
	}
	oci_free_statement($stid);

	
?>


<!DOCTYPE html>
<html>
<head>
	<title>TEST <?php  echo $last_test ?></title>
	<link rel="stylesheet" type="text/css" href="..\css\testsstyle.css">
	<style type="text/css" >
	input[type='checkbox'].first {
    	background: url(../resources/test/<?php echo $category."/".$level."/".$var1 ?>);
    	background-repeat: no-repeat;
    	background-size: cover;
	}
	input[type='checkbox'].second {
    	background: url(../resources/test/<?php echo $category."/".$level."/".$var2 ?>);
    	background-repeat: no-repeat;
    	background-size: cover;
	}
	input[type='checkbox'].third {
    	background: url(../resources/test/<?php echo $category."/".$level."/".$var3 ?>);
    	background-repeat: no-repeat;
    	background-size: cover;
	}
	input[type='checkbox'].last {
    	background: url(../resources/test/<?php echo $category."/".$level."/".$var4 ?>);
    	background-repeat: no-repeat;
    	background-size: cover;
	}
	input[type='checkbox']:checked {
    background: url(../resources/check.png) ;
    background-repeat: no-repeat;
    background-size: cover;
    </style>
</head>
<body>


		
		<form action="test.php" method="GET">
		<div class="statusboard">
			<img src="..\resources\Status_Board.png" class="status">
			<h1>TEST__<?php  echo $last_test ?></h1>
			<p class="points">Total Points: <?php  echo $points ?></p>
			<p class="solved">Questions solved: <?php  echo $last_question ?> of 10</p>
			<input class="prev" type="image" src="..\resources\next.png">
			<a href="prev.php"><img src="..\resources\prev.png" class="prev"></a>
		</div>
		<img src="..\resources\blank.png" class="blank">
		<div class="operationalboard">
			<img src="..\resources\Black_School_Board.png" class="operational">
			<h2>QUESTION__<?php  echo $last_question ?></h2>
			<p class="question"><?php  echo $question ?> </p>
			
				<input class="first" type="checkbox" name="choosen" value="1"> 
				<input class="second" type="checkbox" name="choosen" value="2"> 
				<input class="third" type="checkbox" name="choosen" value="3"> 
				<input class="last" type="checkbox" name="choosen" value="4"> 
			
		</div>
		</form>
</body>
</html>