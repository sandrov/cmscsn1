<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


echo "<pre>"; print_r($_POST) ;  echo "</pre>";

$anno = intval($_GET['anno']);
$lvl = intval($_GET['lvl']);
$idp = intval($_GET['idp']);
$coco = intval($_GET['coco']);
$prj = $_GET['prj'];
$ruo = $_GET['ruo'];
$ini = $_GET['ini'];
$fin = $_GET['fin'];
$note = $_GET['note'];



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
mysqli_select_db($con,"cmsph2");

$sql="INSERT INTO Responsabilities (id_person,anno,lvl,progetto,ruolo,coconv,note) values('".$idp."','".$anno."','".$lvl."','".$prj."','".$ruo."','".$coco."','".$note."')";
//$result = mysqli_query($con,$sql);
//$reqid=mysqli_insert_id($con);

echo $sql;

mysqli_close($con);
?>

