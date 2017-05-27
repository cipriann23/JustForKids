
 <?php session_start();?>
 <?php
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

if (!$connection) {
	$m = oci_error();
	echo $m['message'], "\n";
	//error fuction returns an oracle message.
	exit; }

$name=$_POST['name'];
$pass=$_POST['pwd'];

$stid = oci_parse($connection, "SELECT * FROM TW_login where username=:name and password=:pass");
oci_bind_by_name($stid, ":name", $name);
oci_bind_by_name($stid, ":pass", $pass);

if (!$stid) {
    $e = oci_error($conn);  // For oci_parse errors pass the connection handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

oci_execute($stid);

$row = oci_fetch_array($stid);
//oci_fetch_array returns a row from the db.


 if ($row) {
 	$_SESSION['user']=$_POST['name'];
 	echo"log in successful";
    }else {
		echo("The person " . $name . " is not found .
		Please check the spelling and try again or check password");
		exit;
		}

oci_free_statement($stid);



$stidd = oci_parse($connection, "SELECT * FROM TW_login where username=:name and password=:pass");
oci_bind_by_name($stidd, ":name", $name);
oci_bind_by_name($stidd, ":pass", $pass);
oci_execute($stidd);

while (($row = oci_fetch_row($stidd)) != false) {
    //echo $row[2] . " " . $row[5] . "<br>\n";
    $test=$row[5];
    $_SESSION['id']=$row[0];
}
echo $test;

oci_close($connection);

if($test=='2' ){
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=..\admin.html\">";
}else{
	if($test=='1'){
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=..\parent.html\">";
	  }
	else {
		if($test=='0'){
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=..\kid.html\">";
	  }
	}
	}
//header function locates you to a welcome page saved
 ?>
