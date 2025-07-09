<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



//$idp = intval($_GET['idp']);
$idp = $_GET['idp'];
$anno = intval($_GET['anno']);
$lvl = intval($_GET['lvl']);
$coco = intval($_GET['coco']);
$prj = $_GET['prj'];
$ruo = $_GET['ruo'];
$ini = $_GET['ini'];
$fin = $_GET['fin'];
$note = $_GET['note'];
$sez = $_GET['sez'];
$nome = $_GET['nome'];
$cognome = $_GET['cognome'];
echo $idp, $ruo,$ini,$fin,$sez, $nome, $cognome;


$myrates=array("BA"=>4.05, "BO"=>3.8, "CT"=> 4.05, "FI"=> 3.8, "GE"=> 3.7, "LNF"=> 3.7, "LNL"=> 3.8, "MIB"=> 3.7, "NA"=> 3.95, "PD"=> 3.8, "PV"=> 3.7, "PG"=>3.95, "PI"=> 3.8, "RM1"=> 3.7, "TO"=> 3.7, "TS"=> 3.95);

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
if (($lvl>0) && ($lvl<3)){
    $metamp=(5-($lvl*2));
  }
else $metamp=0;
$metarich=$myrates[$sez];
$metarich*=$metamp;
$a=(int)$metarich;
if (($metarich-$a)<0.5) {$metarich=$a;}
else $metarich=$a+0.5;
if (($lvl>0) && ($lvl<3)) {
  if ($coco>0) {	
        $respstr=$prj." L".$lvl."/coconv/".$ruo."/".$metamp."mp*".$myrates[$sez]."kEuro/mp ".$nome." ".$cognome;
    } else {
	$respstr=$prj." L".$lvl."/".$ruo."/".$metamp."mp*".$myrates[$sez]."kEuro/mp ".$nome." ".$cognome;
//	$respstr=$prj." L".$lvl."/".$ruo."/".$metamp."mp*".$myrates[$sez]."kEuro/mp ".$metarich."kEur ".$nome." ".$cognome;
  }
} else {
$metarich=0;
if ($lvl>2) {$respstr=$prj." L".$lvl."/".$ruo."/ ".$nome." ".$cognome;}
else { $respstr=$prj."/".$ruo."/ ".$nome." ".$cognome;}
}
$respstr=addslashes($respstr);
echo $respstr;;
echo "<br>";
$myid=0;
if (($lvl>0) && ($lvl<3)) {
	$sql2="INSERT into Richieste (anno,sez,capitolo,tag,wbs,richiesta,keur,sigla) values (".$anno.",'".$sez."','missioni','".$prj."-RESP','','".$respstr."','".$metarich."','cms')"; 
        $result2 = mysqli_query($con,$sql2);
        $myid=mysqli_insert_id($con);
}
$ruo=addslashes($ruo);
$ini=addslashes($ini);
$fin=addslashes($fin);
$note=addslashes($note);
$sql="INSERT INTO Responsabilities (id_person,anno,lvl,progetto,ruolo,coconv,inizio,fine,note,id_richiesta) values('".$idp."','".$anno."','".$lvl."','".$prj."','".$ruo."','".$coco."','".$ini."','".$fin."','".$note."','".$myid."')";
$result = mysqli_query($con,$sql);
$reqid=mysqli_insert_id($con);

echo $sql;

mysqli_close($con);
?>

