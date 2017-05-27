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
$u_type=1;


$firstname=$_POST['fname'];
$lastname=$_POST['lname'];
$country=$_POST['country'];
$city=$_POST['city'];
$email=$_POST['email'];



$stid = oci_parse($connection, "
                             Begin
                                :u_id := maxid(0)+1;
                             End;");

/* Parse connection and sql */
oci_bind_by_name($stid,":u_id",$u_id);
    
/* Execute */

oci_execute($stid);
oci_free_statement($stid);




$stidd = oci_parse($connection, "INSERT into TW_LOGIN (id,username,First_name,Last_name,password,user_type,email,city,country) 
						VALUES (:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8)");
oci_bind_by_name($stidd, ":var1", $u_id);
oci_bind_by_name($stidd, ":var2", $name);
oci_bind_by_name($stidd, ":var3", $firstname);
oci_bind_by_name($stidd, ":var4", $lastname);
oci_bind_by_name($stidd, ":var5", $pass);
oci_bind_by_name($stidd, ":var6", $u_type);
oci_bind_by_name($stidd, ":var7", $email);
oci_bind_by_name($stidd, ":var8", $city);
oci_bind_by_name($stidd, ":var9", $country);
oci_execute($stidd);

oci_close($connection);


echo "<meta http-equiv=\"refresh\" content=\"0;URL=login.html\">";

 ?>
