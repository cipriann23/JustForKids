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

	// Get last question resolved checkpoint
	$stid = oci_parse($connection, "SELECT * FROM TW_checkpoint where id_kid=:id");
	oci_bind_by_name($stid, ":id", $_SESSION['id']);
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
	$stid = oci_parse($connection, "SELECT * FROM TW_test where dificulty=:dif and id=:id1 and id_question=:id2");
	oci_bind_by_name($stid, ":dif", $dificulty);
	oci_bind_by_name($stid, ":id1", $last_test);
	oci_bind_by_name($stid, ":id2", $last_question);
	oci_execute($stid);

	
	while (($row = oci_fetch_row($stid)) != false) {
		$category=$row[1];
    	$question=$row[4];
    	$var1=$row[5];
    	$var2=$row[6];
    	$var3=$row[7];
    	$var4=$row[8];
    	$var_corecta=$row[9];
	}

	if($category=1){
		$category='geografie';
	}
	oci_free_statement($stid);

	$points=0;
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

						$_SESSION['id'];

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

						$stid = oci_parse($connection, "UPDATE TW_checkpoint SET id_test=:id1, id_intrebare=:id2 where id_kid=:id");
						oci_bind_by_name($stid, ":id", $_SESSION['id']);
						oci_bind_by_name($stid, ":id1", $last_test);
						oci_bind_by_name($stid, ":id2", $last_question);
						oci_execute($stid);
						oci_free_statement($stid);
						
						/// CALCULATE POINTS
						    $stid = oci_parse($connection, "SELECT get_punctaj(:id,:id1) from dual");
							oci_bind_by_name($stid, ":id", $_SESSION['id']);
							oci_bind_by_name($stid, ":id1", $last_test);
							oci_execute($stid);
							$points=0;
							while (($row = oci_fetch_row($stid)) != false) {
						    	$points=$row[0];
							}
							oci_free_statement($stid);

					}
				    ///////////
		//// GET INFOO
		// Get last question resolved checkpoint
	$stid = oci_parse($connection, "SELECT * FROM TW_checkpoint where id_kid=:id");
	oci_bind_by_name($stid, ":id", $_SESSION['id']);
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
	$stid = oci_parse($connection, "SELECT * FROM TW_test where dificulty=:dif and id=:id1 and id_question=:id2");
	oci_bind_by_name($stid, ":dif", $dificulty);
	oci_bind_by_name($stid, ":id1", $last_test);
	oci_bind_by_name($stid, ":id2", $last_question);
	oci_execute($stid);

	
	while (($row = oci_fetch_row($stid)) != false) {
		$category=$row[1];
    	$question=$row[4];
    	$var1=$row[5];
    	$var2=$row[6];
    	$var3=$row[7];
    	$var4=$row[8];
    	$var_corecta=$row[9];
	}

	if($category=1){
		$category='geografie';
	}
	oci_free_statement($stid);


	
?>


<!DOCTYPE html>
<html>
<head>
	<title>TEST <?php  echo $last_test ?></title>
	<link rel="stylesheet" type="text/css" href="..\css\teststyle.css">
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
			<img src="..\resources\prev.png" class="prev">
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