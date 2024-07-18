<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$q = intval($_GET['q']);


$f = $_GET['f'];
$t = $_GET['t'];


$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
if ($q>2025) {$q=2025;};
mysqli_select_db($con,"cmsph2");
if ($q==0) { $sql="SELECT * FROM Richieste WHERE anno > 0 and anno<2026";}
else $sql="SELECT * FROM Richieste WHERE anno= '".$q."' ";
if ($f) $sql=$sql." AND (".$f.")";
$sql=$sql." ORDER BY anno DESC,capitolo,id DESC";
//print $sql;
$result = mysqli_query($con,$sql);

echo "<table class=\"w3-table w3-striped\">
<tr>
<th>Anno</th>
<th>Sigla</th>
<th>Sezione</th>
<th>Capitolo</th>
<th>keur</th>
<th>SJ</th>
<th>Richiesta</th>
</tr>";
$bkg="";
$totkeur=0;
$totkeurSJ=0;
$totrichieste=0;
$totassegna=0;
while($row = mysqli_fetch_array($result)) {
      $sql2="SELECT Assegnazioni.anno,Assegnazioni.keur,riunione,commenti FROM Richieste,Assegnazioni WHERE Richieste.id=Assegnazioni.id_richiesta and Richieste.id='".$row['id']."'";
      $result2= mysqli_query($con,$sql2);
      $row2=mysqli_fetch_array($result2);
  if ((($t>=10) && $row2) || ($t<10)) {   
  if (($t&1)==1) {
    echo "<tr class=\"".$bkg."\" >";  
  } else {
    echo "<tr class=\"".$bkg."\" onClick=showSingleRichie(".$row['id'].");>";
  };
  echo "<td>" . $row['anno'] . "</td>";
  echo "<td>" . $row['sigla'] . "</td>";
  echo "<td>" . $row['sez'] . "</td>";
  echo "<td>" . $row['capitolo'] . "</td>";
  echo "<td>" . number_format($row['keur'],1) . "</td>";
  $totrichieste+=1;
  $totkeur+= $row['keur'];
  echo "<td>" . number_format($row['keurSJ'],1). "</td>";
  $totkeurSJ+= $row['keurSJ'];
  
  echo "<td>";
	  $dbstr=$row['tag']."/";
	  if ($row['WBS']) $dbstr.= $row['WBS']."/";
	  $dbstr.=$row['richiesta']."      ".$row['note']." / CMS-". $row['id'];
  if (($t&1)==1) {
	  echo "<b>".$dbstr."</b>";
  }
  else
  {
	  echo $dbstr;
	  echo "</td><td>";
	  if ($row2) {echo "<button class=\"w3-btn w3-green\"> ass</button>";};
	  echo "</td><td>";
  }
	  if ($row2){
	  $totassegna+=$row2['keur'];
	  while ($row2=mysqli_fetch_array($result2)){ $totassegna+=$row2['keur'];};
  }
  echo "</td>";
  echo "</tr>";
 }
}
echo "</table>";
echo "<span id=\"phpkeur\" hidden>";
echo $totkeur;
echo "</span>";
echo "<span id=\"phpkeurSJ\" hidden>";
echo $totkeurSJ;
echo "</span>";
echo "<span id=\"phprich\" hidden>";
echo $totrichieste;
echo "</span>";
echo "<span id=\"phpasse\" hidden>";
echo $totassegna;
echo "</span>";
mysqli_close($con);
?>
