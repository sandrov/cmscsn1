<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



$idp = intval($_GET['idp']);
$rid = intval($_GET['rid']);
//echo $rid."<br>";

//$con = mysqli_connect('localhost','cms','');
$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"cmsph2");
//echo "<br>";
$sql2="select id_richiesta from Responsabilities where id=".$rid; 
$result2 = mysqli_query($con,$sql2);
//echo $sql2."<br>";

$row=mysqli_fetch_array($result2);
if ($row['id_richiesta']>0){
  $sql="delete from Richieste where id=".$row['id_richiesta'];
  //echo $sql."<br>";
  $result = mysqli_query($con,$sql);
}

$sql="delete from Responsabilities where id=".$rid;
$result = mysqli_query($con,$sql);
//echo $sql;

mysqli_close($con);
?>

