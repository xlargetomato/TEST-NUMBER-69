<?php
error_reporting(E_ALL);
$done2 = 0;
$done = 0;
$db = 'if0_35791003_uni';
$host = 'sql303.infinityfree.com';
$user = 'if0_35791003';
$pass = 'OCPOTILNUF';
define("db",$db);
define("host",$host);
define("pass",$pass);
define("user",$user);
$MM = mysqli_connect(host,user,pass);
if (!$MM) {
    die('Could not connect: ' . mysqli_error($MM));
}

// Make $db the current database
$db_selected = mysqli_select_db($MM,db);

if (!$db_selected) {
  // If we couldn't, then it either doesn't exist, or we can't see it.
  $sql = "CREATE DATABASE ".db;

  if (mysqli_query($MM,$sql)) {
      echo "Database ". db ." created successfully" . "<br/>";
	  $done = 1;
  } else {
      echo 'Error creating database: ' . mysqli_error($MM) . "<br/>";
  }
}
mysqli_select_db($MM,db);
$query = "SELECT `name` FROM `usr`";
try{
$result = mysqli_query($MM, $query);
}catch(mysqli_sql_exception $e){
  echo "". $e->getMessage() ."";
}
// CREATING THE CONTENT TABLE
if(empty($result)) {
$query = "CREATE TABLE `content` (
  `pdfurl` varchar(225) NOT NULL,
  `note` varchar(225) NOT NULL,
  `subcode` varchar(255) NOT NULL,
  `lectnum` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$query2 = "CREATE TABLE `usr` (
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$query3 = "CREATE TABLE `subjects` (
    `code` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `doctor` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$query4 = "CREATE TABLE `quiz` (
    `id` int(11) AUTO_INCREMENT,
    `subj` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `ques` varchar(255) NOT NULL,
    `opt1` varchar(255) NOT NULL,
    `opt2` varchar(255) NOT NULL,
    `opt3` varchar(255) NOT NULL,
    `opt4` varchar(255) NOT NULL,
    `ans` varchar(255) NOT NULL,
    `corr` varchar(255) NOT NULL,
    PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$query6 = "CREATE TABLE `weekly` (
    `subj` varchar(255) NOT NULL,
    `date-to` varchar(255) NOT NULL,
    `content` varchar(255) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$rand = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

$query5 = "INSERT INTO `usr`(`username`, `name`, `password`, `level`) VALUES ('admin','admin',$rand,3)";

$res = mysqli_query($MM,$query);
$res2 = mysqli_query($MM,$query2);
$res3 = mysqli_query($MM,$query3);
$res4 = mysqli_query($MM,$query4);
$res5 = mysqli_query($MM,$query5);
$res6 = mysqli_query($MM,$query6);
if(empty($res) and empty($res2) and empty($res3) and empty($res4) and empty($res6)) {
      echo 'Error creating tables: ' . mysqli_error($MM) . "<br/>";
}elseif($res and $res2 and $res3 and $res4 and $res6){
      echo 'Done creating tables' . "<br/>";
	  $done2 = 1;
}
if($res5){
	echo "Admin info <br/>";
	echo "Username : admin <br/>";
	echo "Password : " . $rand . "<br/>";
}elseif(!$res5){
	echo "Error creating Admin password." . "<br/>";
}
}
if($done2 == 1 and $done = 1){
$MM = mysqli_connect(host,user,pass,db);
die("Refresh the page.");
}
$MM = mysqli_connect(host,user,pass,db);
mysqli_set_charset($MM,"utf8");
?>
</p>