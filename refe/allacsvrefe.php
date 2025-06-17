<?php require 'dbinc.php';

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=arcoexport.xls");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

$q = intval($_GET['q']);


$f = $_GET['f'];
$t = $_GET['t'];


$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
if ($q>2026) {$q=2026;};
mysqli_select_db($con,"cmsph2");
if ($q==0) { $sql="SELECT * FROM Richieste WHERE anno > 0 and anno<2027";}
else $sql="SELECT * FROM Richieste WHERE anno= '".$q."' ";
if ($f) $sql=$sql." AND (".$f.")";
$sql=$sql." ORDER BY anno DESC,capitolo,id DESC";
//print $sql;
$result = mysqli_query($con,$sql);

////echo "<table class=\"w3-table w3-striped\">
////<tr>
////<th>Anno</th>
////<th>Sigla</th>
////<th>Sezione</th>
////<th>Capitolo</th>
////<th>keur</th>
////<th>SJ</th>
////<th>Richiesta</th>
////</tr>";

$headcsv="Anno\tSigla\tSezione\tCapitolo\tkeur\tSJ\tRichiesta\tAssegnazione";
$bkg="";
$totkeur=0;
$totkeurSJ=0;
$totrichieste=0;
$totassegna=0;
$data="";
while($row = mysqli_fetch_array($result)) {
      $sql2="SELECT Assegnazioni.anno,Assegnazioni.keur,riunione,commenti FROM Richieste,Assegnazioni WHERE Richieste.id=Assegnazioni.id_richiesta and Richieste.id='".$row['id']."'";
      $result2= mysqli_query($con,$sql2);
  
	  $dbstr=$row['tag']."/";
	  if ($row['WBS']) $dbstr.= $row['WBS']."/";
	  $dbstr.=$row['richiesta']." ".$row['note']."/CMS-".$row['id'];


	  $linecsv= $row['anno'] ."\t".$row['sigla']."\t".$row['sez']."\t".$row['capitolo']."\t".number_format($row['keur'],1)."\t".number_format($row['keurSJ'],1)."\t".$dbstr;
	  $asstot=0;
          while($row2=mysqli_fetch_array($result2)){
		  $asstot+=$row2['keur'];
	  };
	  if ($asstot) {$linecsv.="\t".$asstot; };
	  $data .= trim( $linecsv ) . "\n";
 }
$data = str_replace( "\r" , "" , $data );
print "$headcsv\n$data";
mysqli_close($con);
?>
