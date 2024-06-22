<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


echo "<pre>"; print_r($_POST) ;  echo "</pre>";


$anno = isset($_POST['anno']) ? $_POST['anno'] : '';
$sez = isset($_POST['sez']) ? $_POST['sez'] : '';
$sigla = isset($_POST['sigla']) ? $_POST['sigla'] : '';
$capitolo = isset($_POST['capitolo']) ? $_POST['capitolo'] : '';
$tag1 = isset($_POST['tag1']) ? $_POST['tag1'] : '';
$tag2 = isset($_POST['tag2']) ? $_POST['tag2'] : '';
$tag3 = isset($_POST['tag3']) ? $_POST['tag3'] : '';
$wbs = isset($_POST['wbs']) ? $_POST['wbs'] : '';
$rich = isset($_POST['rich']) ? $_POST['rich'] : '';
$note = isset($_POST['note']) ? $_POST['note'] : '';
$keur = isset($_POST['keur']) ? $_POST['keur'] : '';
$sj = isset($_POST['sj']) ? $_POST['sj'] : '';
$documentazione = isset($_POST['descrizione']) ? $_POST['descrizione'] : '';
$folder = isset($_POST['folder']) ? $_POST['folder'] : '';





$wbs=addslashes($wbs);
$rich=addslashes($rich);
$note=addslashes($note);
$keur=addslashes($keur);
$sj=addslashes($sj);
$documentazione=addslashes($documentazione);
$folder=addslashes($folder);
$tag=addslashes($tag1."-".$tag2."   ".$tag3);

$con = mysqli_connect($server,$login,$pass,$db,$port);
//$con = mysqli_connect('localhost','cms','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"cmsph2");
$sql="INSERT INTO Richieste (anno,tag,WBS,sez,capitolo,keur,keurSJ,richiesta,note,sigla) values('".$anno."','".$tag."','".$wbs."','".$sez."','".$capitolo."','".$keur."','".$sj."','".$rich."','".$note."','".$sigla."')";
$result = mysqli_query($con,$sql);
echo "<BR>".$sql;
$sql="INSERT INTO docs (id_richiesta,documentazione,folder) values (".mysqli_insert_id($con).",'".$documentazione."','".$folder."')";
echo "<BR>".$sql;
$result = mysqli_query($con,$sql);
echo "<BR>";

echo "Richiesta inserita <BR>";

echo $anno."<BR>";
echo $sez."<BR>";
echo $sigla."<BR>";
echo $tag."<BR>";
echo $wbs."<BR>";
echo $documentazione."<BR>";
echo $rich."<BR>";
echo $keur."<BR>";
echo $sj."<BR>";
echo $folder."<BR>";

mysqli_close($con);
?>

