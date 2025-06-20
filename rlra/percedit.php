<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



$idp = intval($_GET['idp']);
$anno = intval($_GET['anno']);
$perccms = intval($_GET['perccms']);
$sin1 = $_GET['sin1'];
$percs1 = intval($_GET['percs1']);
$sin2 = $_GET['sin2'];
$percs2 = intval($_GET['percs2']);
$sin3 = $_GET['sin3'];
$percs3 = intval($_GET['percs3']);



$prj=addslashes($prj);
$ruo=addslashes($ruo);
$ini=addslashes($ini);
$fin=addslashes($fin);
$note=addslashes($note);

$con = mysqli_connect($server,$login,$pass,$db,$port);
//$con = mysqli_connect('localhost','cms','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"atlasph2");

$sql="Update Anagrafica set Percentuale_CMS='".$perccms."', SiglaSiner1='".$sin1."',Percentuale_Sin1='".$percs1."', SiglaSiner2='".$sin2."',Percentuale_Sin2='".$percs2."', SiglaSiner3='".$sin3."',Percentuale_Sin3='".$percs3."' WHERE id_person='".$idp."' and anno='".$anno."'";
$result = mysqli_query($con,$sql);
$reqid=mysqli_insert_id($con);

echo $sql;

mysqli_close($con);
?>

