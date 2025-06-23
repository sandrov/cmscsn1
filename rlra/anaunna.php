<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$q = intval($_GET['q']);
$f = $_GET['f'];
$t = $_GET['t'];

//echo $q;
echo "<h2> Anagrafica Anno ".$t."</h2>";

//print("f=".$f);
$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"cmsph2");
$sql="SELECT * FROM Persone,Anagrafica WHERE Persone.id = '".$q."' and Persone.id=Anagrafica.id_person and anno=".$t." and ".$f;
$result = mysqli_query($con,$sql);
$sql2="SELECT Progetto,lvl,ruolo,inizio,fine,note FROM Persone,Responsabilities WHERE Persone.id=Responsabilities.id_person and Persone.id='".$q."' and anno=".$t;
$result2= mysqli_query($con,$sql2);
//$sql3="SELECT documentazione,folder FROM Richieste,docs WHERE Richieste.id=docs.id_richiesta and Richieste.id='".$q."'";
//$result3= mysqli_query($con,$sql3);
$sql3="SELECT sigla FROM siglesin";
$result3 = mysqli_query($con,$sql3);

$siglesin=array();
while ($row3=mysqli_fetch_array($result3)) {
	array_push($siglesin,$row3['sigla']);
}

echo "
<div class=\"w3-responsive\">	
<table class=\"w3-table w3-striped w3-twothird w3-small\">
<tr>
<th>Nome</th>
<th>Cognome</th>
<th>Sezione</th>
<th>Percentuale CMS</th>
<th>Sinergica 1</th>
<th>Percentuale Sin1</th>
<th>Sinergica 2</th>
<th>Percentuale Sin2</th>
<th>Sinergica 3</th>
<th>Percentuale Sin3</th>
<th></th>
</tr>";

$totcms=0;
$totsin=0;
while($row = mysqli_fetch_array($result)) {
  $totcms+=$row['Percentuale_CMS']/100;
  $totsin+=$row['Percentuale_Sin1']/100;
  $totsin+=$row['Percentuale_Sin2']/100;
  $totsin+=$row['Percentuale_Sin3']/100;
  $respsez=$row['sez'];
  $respnome=$row['Nome'];
  $respcognome=$row['Cognome'];
  echo "<tr>";
  echo "<td>" . $row['Nome'] . "</td>";
  echo "<td>" . $row['Cognome'] . "</td>";
  echo "<td>" . $row['sez'] . "</td>";
  echo "<td><input type=\"text\" width=20 id=\"perccms\" name=\"percms\" value=\"".$row['Percentuale_CMS']."\"></td>";
//  echo "<td><input type=\"text\" id=\"sin1\" name=\"sin1\" value=\"".$row['SiglaSiner1']."\"></td>";
//  echo "<td>";
//  echo "<select class=\"w3-select\" id=\"sin1\" name=\"sin1\">";
//  echo "<option value=\"".$row['SiglaSiner1']."\">".$row['SiglaSiner1']."</option>";
//  echo "<option value=\"1_CLOUD_ML\">1_CLOUD_ML</option>";
//  echo "<option value=\"1_IGNITE\">1_IGNITE</option>";
//  echo "<option value=\"5_4DSHARE\">5_4DSHARE</option>";
//  echo "<option value=\"5_AI_INFN\">5_AI_INFN</option>";
//  echo "<option value=\"C3SN_DATACLOUD\">C3SN_DATACLOUD</option>";
//  echo "<option value=\"FE_4DSHARE-2022KLK4LB-PRIN\">FE_4DSHARE-2022KLK4LB-PRIN</option>";
//  echo "<option value=\"FE_AIDAINNOVA-EU\">FE_AIDAINNOVA-EU</option>";
//  echo "<option value=\"FE_ASIMOW-ERC\">FE_ASIMOW-ERC</option>";
//  echo "<option value=\"\"></option>";
//  echo "<option value=\"\"></option>";
//  echo "</select>";
//  echo "</td>";
  echo "<td><select id=\"sin1\" class=\"\">";
  echo "<option value=\"\">sigla:</option>";	  	
  foreach ($siglesin as $thesigla) {
       $myopt =  $row['SiglaSiner1'] == $thesigla ? ' selected="selected"' : '';
    echo "<option value=\"".$thesigla."\" ".$myopt.">".$thesigla."</option>";	  
  }
  echo "</select></td>";
  echo "<td><input type=\"text\" width=20 id=\"percs1\" name=\"pers1\" value=\"".$row['Percentuale_Sin1']."\"></td>";
  echo "<td><select id=\"sin2\" class=\"\">";
  echo "<option value=\"\">sigla:</option>";	  	
  foreach ($siglesin as $thesigla) {
       $myopt =  $row['SiglaSiner2'] == $thesigla ? ' selected="selected"' : '';
    echo "<option value=\"".$thesigla."\" ".$myopt.">".$thesigla."</option>";	  
  }
  echo "</select></td>";
  echo "<td><input type=\"text\" width=20 id=\"percs2\" name=\"pers2\" value=\"".$row['Percentuale_Sin2']."\"></td>";
  echo "<td><select id=\"sin3\" class=\"\">";
  echo "<option value=\"\">sigla:</option>";	  	
  foreach ($siglesin as $thesigla) {
       $myopt =  $row['SiglaSiner3'] == $thesigla ? ' selected="selected"' : '';
    echo "<option value=\"".$thesigla."\" ".$myopt.">".$thesigla."</option>";	  
  }
  echo "</select></td>";
  echo "<td><input type=\"text\" width=20 id=\"percs3\" name=\"pers3\" value=\"".$row['Percentuale_Sin3']."\"></td>";
 //echo "<td></td>";

//  echo "<td>";
//  echo "<table class=\"astab\">";
//  $edib=0;
//  while($row2 = mysqli_fetch_array($result2)) {
//     $edib=1;
//     $totass+=$row2['keur'];
//     echo "<tr class=\"astab\">";
//       echo "<td>" ."   " . "</td>";
//       echo "<td>" ."". $row2['keur'] . "</td>";
//       echo "<td>" ."". $row2['riunione'] . "</td>";
//       echo "<td>" ."". $row2['commenti'] . "</td>";
//     echo "</tr>";
//  }
//echo "</table></td>";
//  echo "<td>";
//  if ($row['todb']==1) {echo "<button class=\"w3-btn w3-lime\">DB</button>";};
//  echo "</td>";
//  echo "<td>";
//  if ($row['rl']==1) {echo "<button class=\"w3-btn w3-light-green\">RL</button>";};
//  echo "</td>";
//  echo "<td>";
 // if ($row['ra']==1) {echo "<button class=\"w3-btn w3-light-blue\">RA</button>";};
 // echo "</td>";
//  echo "<td>";
//  if ($row['rn']==1) {echo "<button class=\"w3-btn w3-cyan\">RN</button>";};
//  echo "</td>";
//  echo "<td>";
//  if ($row['aggio']==1) {echo "<button class=\"w3-btn w3-amber\">Agg</button>";};
//  echo "</td>";
  echo "<td>";
  if ($edib==0) {
//     echo "<a href=\"edita.php?q=".$q."\">";
     echo "<button id=\"edita\" onclick=\"aggiornaAnag(".$q.",".$t.");\"> aggiorna</button>"; 
//  echo "<button id=\"toDB\" onclick=\"aggiornaDB(".$q.",1);\"> DB</button>"; 
//  echo "<button id=\"toDB\" onclick=\"aggiornaDB(".$q.",2);\"> RL</button>"; 
//  echo "<button id=\"ra\" onclick=\"aggiornaDB(".$q.",3);\"> RA</button>"; 
//  echo "<button id=\"rn\" onclick=\"aggiornaDB(".$q.",4);\"> RN</button>"; 
//  echo "<button id=\"agg\" onclick=\"aggiornaDB(".$q.",5);\"> Agg</button>"; 
  }
  echo "</td>";
}
echo "</tr></table>";
echo "</div>";
echo "<br>";
echo "<div class=\"w3-conatiner\">";
echo "<b>Responsabilità:</b>";
echo "<br>";
echo "<table class=\" w3-half w3-small\">
<tr class=\"w3-green \">
<th>Progetto</th>
<th>Ruolo</th>
<th>LVL</th>
<th>CoConv</th>
<th>Inizio</th>
<th>Fine</th>
<th>Note</th>
</tr>
";
while($row2 = mysqli_fetch_array($result2)) {
  echo "<tr>";
//  echo "<td>" . $row['Anno'] . "</td>";
  echo "<td>" . $row2['Progetto'] . "</td>";
  echo "<td>" . $row2['ruolo'] . "</td>";
  echo "<td>" . $row2['lvl'] . "</td>";
  echo "<td>" . $row2['coconv'] . "</td>";
  echo "<td>" . $row2['inizio'] . "</td>";
  echo "<td>" . $row2['fine'] . "</td>";
  echo "<td>" . $row2['note'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

echo '
<div class="  w3-third w3-right w3-small w3-border w3-container">
<label>Progetto</label>
<select id="respprj" name="tag1" class="w3-select">
   <option value="">TAG-PRJ</option>
   <option value="CMS">CMS</option>
   <option value="CALCOLO">CALCOLO</option>
   <option value="DT">DT</option>
   <option value="FISICA">FISICA</option>
   <option value="ECAL">ECAL</option>
   <option value="GEM">GEM</option>
   <option value="L1TRIGGER">L1TRIGGER</option>
   <option value="ME0">ME0</option>
   <option value="MTD">MTD</option>
   <option value="MUON">MUON</option>
   <option value="PPS">PPS</option>
   <option value="RPC">RPC</option>
   <option value="BRIL">BRIL</option>
   <option value="TRACKER">TRACKER</option>
</select>
<label>Ruolo</label>
<input id="respruo" class="w3-input" type="text">
<label>LVL</label>
<select id="resplvl" name="tag3" class="w3-select" >
   <option value=""></option>
   <option value="0">L0</option>
   <option value="1">L1</option>
   <option value="2">L2</option>
   <option value="3">L3</option>
   <option value="">nc</option>
   <option value="1.5">L1.5</option>
</select>
<label>CoConv</label>
<select id="respcoco" name="tag3" class="w3-select">
   <option value=""></option>
   <option value="1">Co-Conv</option>
</select>
<label>Inizio</label>
<input id="respini" class="w3-input" type="text">
<label>Fine</label>
<input id="respfin" class="w3-input" type="text">
<label>Note</label>
<input id="respnote" class="w3-input" type="text">
';
echo "<button class=\"w3-btn w3-blue\" onclick=\"aggiungiResp(".$q.",".$t.",'".$respsez."','".$respnome."','".$respcognome."');\">Aggiungi</button>
</div>
<br>";
//<button class=\"w3-btn w3-blue\" onclick=\"alert(idp=".$q." anno=".$t.");\">Aggiungi</button>
//    xmlhttp.open('GET','annaunna.php?idp=".$idp."&anno=".$anno."&lvl=".$lvl."&prj=".$prj."&ruo=".$ruo."&ini=".$ini."&fin=".$fin."$note=".$note."',true);
//echo " <div class=\"w3-card-4 w3-third w3-right\">
//</div> <br> 
//<div class=\"w3-container w3-green\">
//  <h2>Header</h2>
//</div>
//
//<form class=\"w3-container w3-small\">
//</form>

//if ($row3) {
// echo "<fieldset>";
//echo"<legend> <b> Descrizione: </b> </legend> ";
// echo $row3['documentazione'];
//echo "</filedset>";
//};
echo "</div>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<button onclick=\"showRichie(richie.value);\">Back</button>";
echo "<div>";

//if($row3) {if ($row3['folder']!="") { 
//echo "<iframe src=\"https://cernbox.cern.ch/files/spaces/eos/user/v/venturas/cmscsn1/documentazione/CMS-ID".$q."\" width=75% height=600 title='docs folder'></iframe>";
//};};
echo "</div>";

echo "<span id=\"phpkeur\" hidden>";
echo $totcms;
echo "</span>";
echo "<span id=\"phpkeurSJ\" hidden>";
echo $totsin;
echo "</span>";

mysqli_close($con);
?>
