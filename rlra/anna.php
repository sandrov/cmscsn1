<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$q = intval($_GET['q']);

$f = $_GET['f'];
$t = $_GET['t'];

echo "<h2> Anagrafica Anno ".$q."</h2>";
$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"cmsph2");
if ($q==0) { $sql="SELECT * FROM Persone WHERE 1 ";}
else {
if	(($t&1)==0) {
	$sql="SELECT *,Persone.id as idp FROM Persone,Anagrafica WHERE anno=".$q." AND Persone.id=Anagrafica.id_person ";
} else {
         $sql="SELECT  *,Persone.id as idp FROM Persone,Anagrafica,Responsabilities  WHERE Responsabilities.anno= Anagrafica.anno AND Responsabilities.anno=".$q." AND Persone.id=Anagrafica.id_person and Persone.id=Responsabilities.id_person ";
}
        if ($f) $sql=$sql." AND (".$f.")";
        if ($t) $sql=$sql." AND (".$t.")";
}
$sql=$sql." ORDER BY Persone.Cognome ";
//print $sql;
$result = mysqli_query($con,$sql);
echo "<div class=\"w3-row \">";
echo "<table class=\"w3-table w3-striped w3-small \">
<tr>
<th>Cognome</th>
<th>Nome</th>
<th>Sezione</th>
<th>Profilo</th>
<th>Percentuale CMS</th>
<th>Sinergica 1</th>
<th>Percentuale Sin1</th>
<th>Sinergica 2</th>
<th>Percentuale Sin2</th>
<th>Sinergica 3</th>
<th>Percentuale Sin3</th>
</tr>";
$bkg="";
$totcms=0;
$totsin=0;
$totrichieste=0;
$totfte=0;
while($row = mysqli_fetch_array($result)) {
      $sql2="SELECT * from Responsabilities where id_person=".$row['idp']." and anno=".$q;
      $result2= mysqli_query($con,$sql2);
//      $row2=mysqli_fetch_array($result2);
  if ((($t>=10) && $row2) || ($t<10)) {   
    echo "<tr class=\"".$bkg."\" onClick=showSingleRichie(".$row['idp'].");>";
  echo "<td>" . $row['Cognome'] . "</td>";
  echo "<td>" . $row['Nome'] . "</td>";
  echo "<td>" . $row['sez'] . "</td>";
  echo "<td>" . $row['Profilo'] . "</td>";
  if ($q!=0) {
  echo "<td>" . number_format($row['Percentuale_CMS'],0) . "%</td>";
  echo "<td>" . $row['SiglaSiner1'] . "</td>";
  echo "<td>" . number_format($row['Percentuale_Sin1'],0) . "%</td>";
  echo "<td>" . $row['SiglaSiner2'] . "</td>";
  echo "<td>" . number_format($row['Percentuale_Sin2'],0) . "%</td>";
  echo "<td>" . $row['SiglaSiner3'] . "</td>";
  echo "<td>" . number_format($row['Percentuale_Sin3'],0) . "%</td>";
  $totrichieste+=1;
  $totcms+= $row['Percentuale_CMS']/100;
  $totsin+= $row['Percentuale_Sin1']/100;
  $totsin+= $row['Percentuale_Sin2']/100;
  $totsin+= $row['Percentuale_Sin3']/100;

  $row2=mysqli_fetch_array($result2);
  if ($row2['id']) { echo "<td><button class=\"w3-btn w3-small w3-amber\">Resp</button></td>";};
//	  echo "<button class=\"w3-btn w3-small  w3-amber\">Resp<</button>";};
//       }
  } 
//  if (($t&1)==1) {
//	  echo "<b>".$dbstr."</b>";
 // }
  //else
  //{
//	  echo $dbstr;
	  echo "</td><td>";
//	  if ($row['todb']==1) {echo "<button class=\"w3-btn w3-lime\">DB</button>";};
//	  if ($row2) {echo "<button class=\"w3-btn w3-green\"> ass</button>";};
	  echo "</td><td>";
//	  if ($row['rn']==1) {echo "<button class=\"w3-btn  w3-cyan\">RN</button>";};
//	  if ($row['ra']==1) {echo "<button class=\"w3-btn  w3-light-blue\">RA</button>";};
//	  if ($row['rl']==1) {echo "<button class=\"w3-btn  w3-light-green\">RL</button>";};
//	  if ($row['aggio']==1) {echo "<button class=\"w3-btn  w3-amber\">Agg</button>";};
  }
//	  $totassegna+=$row2['keur'];
//	  while ($row2=mysqli_fetch_array($result2)){ $totassegna+=$row2['keur'];};
//  }
  echo "</tr>";
// }
}
echo "</table>";
echo "</div>";
echo "<span id=\"phpkeur\" hidden>";
echo $totcms;
//echo $sql2;
echo "</span>";
echo "<span id=\"phpkeurSJ\" hidden>";
echo $totsin;
echo "</span>";
echo "<span id=\"phprich\" hidden>";
echo $totrichieste;
echo "</span>";
mysqli_close($con);
?>
