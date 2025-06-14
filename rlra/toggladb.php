<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



echo "<pre>"; print_r($_GET) ;  echo "</pre>";


$id = isset($_GET['q']) ? $_GET['q'] : '';
$fla = isset($_GET['f']) ? $_GET['f'] : '';

echo "<pre>"; "f=".$fla ;  echo "</pre>";

if ($id>0) {
 $tbcon = mysqli_connect($server,$login,$pass,$db,$port);
//$tbcon = mysqli_connect('localhost','cms','');
 if (!$tbcon) {
 die('Could not connect: ' . mysqli_error($tbcon));
 }

 mysqli_select_db($tbcon,"atlasph2");
 $mfla="";
 if ($fla==1) {$mfla="todb";};
 if ($fla==2) {$mfla="rl";};
 if ($fla==3) {$mfla="ra";};
 if ($fla==4) {$mfla="rn";};
 if ($fla==5) {$mfla="aggio";};
 if ($mfla!="") {
 $sql="UPDATE Richieste set ".$mfla."=case when ".$mfla."=1 then 0 else 1 end WHERE id=".$id;
 print $sql;
 $result = mysqli_query($tbcon,$sql);
 }
// $sql="select ".$mfla." from Richieste WHERE id=".$id;
// $result = mysqli_query($tbcon,$sql);
 mysqli_close($tbcon);
}
?>

