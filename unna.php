<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$q = intval($_GET['q']);

//echo $q;

$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"cmsph2");
$sql="SELECT * FROM Richieste WHERE id = '".$q."'";
$result = mysqli_query($con,$sql);
$sql2="SELECT Assegnazioni.anno,Assegnazioni.keur,riunione,commenti FROM Richieste,Assegnazioni WHERE Richieste.id=Assegnazioni.id_richiesta and Richieste.id='".$q."'";
$result2= mysqli_query($con,$sql2);
$sql3="SELECT documentazione,folder FROM Richieste,docs WHERE Richieste.id=docs.id_richiesta and Richieste.id='".$q."'";
$result3= mysqli_query($con,$sql3);

echo "<div><table class=\"w3-table w3-striped\">
<tr>
<th>Anno</th>
<th>Sigla</th>
<th>Tag</th>
<th>Sezione</th>
<th>Capitolo</th>
<th>keur</th>
<th>SJ</th>
<th>wbs</th>
<th>Richiesta</th>
<th>Note</th>
<th>ID</th>
<th></th>
<th>Assegnazioni</th>
</tr>";

$totkeur=0;
$totkeursj=0;
$totass=0;
while($row = mysqli_fetch_array($result)) {
  $totkeur+=$row['keur'];
  $totkeursj+=$row['keurSJ'];
  echo "<tr>";
  echo "<td>" . $row['anno'] . "</td>";
  echo "<td>" . $row['sigla'] . "</td>";
  echo "<td>" . $row['tag'] . "</td>";
  echo "<td>" . $row['sez'] . "</td>";
  echo "<td>" . $row['capitolo'] . "</td>";
  echo "<td>" . number_format($row['keur'],1) . "</td>";
  echo "<td>" . number_format($row['keurSJ'],1) . "</td>";
  echo "<td>" . $row['WBS'] . "</td>";
  echo "<td>" . $row['richiesta'] . "</td>";
  echo "<td>" . $row['note'] . "</td>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td></td>";

  echo "<td>";
  echo "<table class=\"astab\">";
  $edib=0;
  while($row2 = mysqli_fetch_array($result2)) {
     $edib=1;
     $totass+=$row2['keur'];
     echo "<tr class=\"astab\">";
       echo "<td>" ."   " . "</td>";
       echo "<td>" ."". $row2['keur'] . "</td>";
       echo "<td>" ."". $row2['riunione'] . "</td>";
       echo "<td>" ."". $row2['commenti'] . "</td>";
     echo "</tr>";
  }
  echo "</table></td>";
  echo "<td>";
  if ($row['todb']==1) {echo "<button class=\"w3-btn w3-orange\">DB</button>";};
  echo "</td>";
  echo "<td>";
  if ($edib==0) {
//     echo "<a href=\"edita.php?q=".$q."\">";
     echo "<button id=\"edita\" onclick=\"aggiorna(".$q.");\"> Edita</button>"; 
  echo "<button id=\"toDB\" onclick=\"aggiornaDB(".$q.");\"> DB</button>"; }
  echo "</td>";
}
echo "</tr></table>";
echo "<br>";
$row3 = mysqli_fetch_array($result3); 
echo "<div>";
if ($row3) {
 echo "<fieldset>";
echo"<legend> <b> Descrizione: </b> </legend> ";
 echo $row3['documentazione'];
echo "</filedset>";
};
echo "</div>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<button onclick=\"showRichie(richie.value);\">Back</button>";
echo "<div>";
if($row3) {if ($row3['folder']!="") { 
echo "<iframe src=".$row3['folder']." width=100% height=800 title='docs folder'></iframe>";
};};
echo "</div>";

echo "<span id=\"phpkeur\" hidden>";
echo $totkeur;
echo "</span>";
echo "<span id=\"phpkeurSJ\" hidden>";
echo $totkeursj;
echo "</span>";

mysqli_close($con);
?>
