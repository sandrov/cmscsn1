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

$row3 = mysqli_fetch_array($result3);
//print_r($row3);
//

while($row = mysqli_fetch_array($result)) {
//print_r($row);
	$tag=$row['tag'];
	$tag= preg_replace('/\s+/', ' ',$tag);
        list($tag1, $tag2)=explode("-",$tag);
//	print "tag2=".$tag2;
	list($tag2, $tag3)=explode(" ",$tag2);
//	print "list ".$tag1."+".$tag2."+".$tag3;

?>
<script>
  function alla() { window.location = "alla.html";};
        var myrates={BA: 4.05, BO: 3.8, CT: 4.05, FI: 3.8, GE: 3.7, LNF: 3.7, LNL: 3.8, MIB: 3.7, NA: 3.95, PD: 3.8, PV: 3.7, PG:3.95, PI: 3.8,
                        RM1: 3.7, TO: 3.7, TS: 3.95};
        var mylvlmon={L0: 4, L1: 3, L2: 1, L3: 0,nc: 0, 'L1.5': 0}

        function respcalc() {
                 var msez= document.getElementById('sez').value;
                 var mlvl= document.getElementById('tag3').value;
                 document.getElementById('keur').value=myrates[msez]*mylvlmon[mlvl];
                 if (mylvlmon[mlvl]>0) {
                        document.getElementById('rich').value=mylvlmon[mlvl]+" mp*"+myrates[msez]+" KEuro/mp";}
                 else  document.getElementById('rich').value="";
                };

</script>
<style>
html {
  font-family:Montserrat,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;
  line-height:1.5
}
</style>

<h2> Modifica Richiesta: </h2>

<form id="myedit"  method="post">
<div class="w3-panel w3-border w3-sand  w3-round-xlarge">
<input id="ricid" type="hidden" name="ricid" value="<?=$row['id']?>"> 
<div> <b>ID: <?=$row['id']?> </b></div>
<select id="anno" name="anno" >
  <option value="0">Anno:</option>
  <option value="2024" <?=$row['anno'] == '2024' ? ' selected="selected"' : '';?>>2024</option>
  <option value="2025" <?=$row['anno'] == '2025' ? ' selected="selected"' : '';?>>2025</option>
  <option value="2026" <?=$row['anno'] == '2026' ? ' selected="selected"' : '';?>>2026</option>
  <option value="2027" <?=$row['anno'] == '2027' ? ' selected="selected"' : '';?>>2027</option>
  <option value="2028" <?=$row['anno'] == '2028' ? ' selected="selected"' : '';?>>2028</option>
</select>
<select id="sigla" name="sigla" >
  <option value="0">Sigla:</option>
  <option value="cms" <?=$row['sigla'] == 'cms' ? ' selected="selected"' : '';?>>cms</option>
  <option value="fase2" <?=$row['sigla'] == 'fase2' ? ' selected="selected"' : '';?>>fase2</option>
</select>
<select id="sez" name="sez" >
  <option value="0">Sezione:</option>
  <option value="BA" <?=$row['sez'] == 'BA' ? ' selected="selected"' : '';?>>BA</option>
  <option value="BO" <?=$row['sez'] == 'BO' ? ' selected="selected"' : '';?>>BO</option>
  <option value="CT" <?=$row['sez'] == 'CT' ? ' selected="selected"' : '';?>>CT</option>
  <option value="FI" <?=$row['sez'] == 'FI' ? ' selected="selected"' : '';?>>FI</option>
  <option value="GE" <?=$row['sez'] == 'GE' ? ' selected="selected"' : '';?>>GE</option>
  <option value="LNF" <?=$row['sez'] == 'LNF' ? ' selected="selected"' : '';?>>LNF</option>
  <option value="LNL" <?=$row['sez'] == 'LNL' ? ' selected="selected"' : '';?>>LNL</option>
  <option value="MIB" <?=$row['sez'] == 'MIB' ? ' selected="selected"' : '';?>>MIB</option>
  <option value="NA" <?=$row['sez'] == 'NA' ? ' selected="selected"' : '';?>>NA</option>
  <option value="PD" <?=$row['sez'] == 'PD' ? ' selected="selected"' : '';?>>PD</option>
  <option value="PG" <?=$row['sez'] == 'PG' ? ' selected="selected"' : '';?>>PG</option>
  <option value="PI" <?=$row['sez'] == 'PI' ? ' selected="selected"' : '';?>>PI</option>
  <option value="PV" <?=$row['sez'] == 'PV' ? ' selected="selected"' : '';?>>PV</option>
  <option value="RM1" <?=$row['sez'] == 'RM1' ? ' selected="selected"' : '';?>>RM1</option>
  <option value="TO" <?=$row['sez'] == 'TO' ? ' selected="selected"' : '';?>>TO</option>
  <option value="TS" <?=$row['sez'] == 'TS' ? ' selected="selected"' : '';?>>TS</option>
</select>

<select id="capitolo" name="capitolo" >
  <option value="0">Capitolo:</option>
  <option value="missioni" <?=$row['capitolo'] == 'missioni' ? ' selected="selected"' : '';?>>missioni</option>
  <option value="consumo" <?=$row['capitolo'] == 'consumo' ? ' selected="selected"' : '';?>>consumo</option>
  <option value="apparati" <?=$row['capitolo'] == 'apparati' ? ' selected="selected"' : '';?>>apparati</option>
  <option value="inventario" <?=$row['capitolo'] == 'inventario' ? ' selected="selected"' : '';?>>inventario</option>
  <option value="manutenzione" <?=$row['capitolo'] == 'manutenzione' ? ' selected="selected"' : '';?>>manutenzione</option>
  <option value="trasporti" <?=$row['capitolo'] == 'trasporti' ? ' selected="selected"' : '';?>>trasporti</option>
  <option value="licenze-sw" <?=$row['capitolo'] == 'licenze-sw' ? ' selected="selected"' : '';?>>licenze-sw</option>
  <option value="spservizi" <?=$row['capitolo'] == 'spservizi' ? ' selected="selected"' : '';?>>spservizi</option>
</select>

<!--
  <select id="tag" name="tag" >
   <option value="0">TAG</option>
   <option value="DT-CORE" <?=$row['tag'] == 'DT-CORE' ? ' selected="selected"' : '';?>>DT-CORE</option>
   <option value="ECAL-CORE" <?=$row['tag'] == 'ECAL-CORE' ? ' selected="selected"' : '';?>>ECAL-CORE</option>
   <option value="GEM-CORE" <?=$row['tag'] == 'GEM-CORE' ? ' selected="selected"' : '';?>>GEM-CORE</option>
   <option value="L1TRIGGER-CORE" <?=$row['tag'] == 'L1TRIGGER-CORE' ? ' selected="selected"' : '';?>>L1TRIGGER-CORE</option>
   <option value="ME0-CORE" <?=$row['tag'] == 'ME0-CORE' ? ' selected="selected"' : '';?>>ME0-CORE</option>
   <option value="MTD-CORE" <?=$row['tag'] == 'MTD-CORE' ? ' selected="selected"' : '';?>>MTD-CORE</option>
   <option value="RPC-CORE" <?=$row['tag'] == 'RPC-CORE' ? ' selected="selected"' : '';?>>RPC-CORE</option>
   <option value="TRACKER-CORE" <?=$row['tag'] == 'TRACKER-CORE' ? ' selected="selected"' : '';?>>TRACKER-CORE</option>
</select>
-->

<select id="tag1" name="tag1" class="entrasel">
   <option value="">TAG-PRJ</option>
   <option value="CMS" <?=$tag1== 'CMS' ? ' selected="selected"' : '';?>>CMS</option>
   <option value="CALCOLO" <?=$tag1== 'CALCOLO' ? ' selected="selected"' : '';?>>CALCOLO</option>
   <option value="DT" <?=$tag1== 'DT' ? ' selected="selected"' : '';?>>DT</option>
   <option value="FISICA" <?=$tag1== 'FISICA' ? ' selected="selected"' : '';?>>FISICA</option>
   <option value="ECAL" <?=$tag1== 'ECAL' ? ' selected="selected"' : '';?>>ECAL</option>
   <option value="GEM" <?=$tag1== 'GEM' ? ' selected="selected"' : '';?>>GEM</option>
   <option value="L1TRIGGER" <?=$tag1== 'L1TRIGGER' ? ' selected="selected"' : '';?>>L1TRIGGER</option>
   <option value="ME0" <?=$tag1== 'ME0' ? ' selected="selected"' : '';?>>ME0</option>
   <option value="MTD" <?=$tag1== 'MTD' ? ' selected="selected"' : '';?>>MTD</option>
   <option value="PPS" <?=$tag1== 'PPS' ? ' selected="selected"' : '';?>>PPS</option>
   <option value="RPC" <?=$tag1== 'RPC' ? ' selected="selected"' : '';?>>RPC</option>
   <option value="BRIL" <?=$tag1== 'BRIL' ? ' selected="selected"' : '';?>>BRIL</option>
   <option value="TRACKER" <?=$tag1== 'TRACKER' ? ' selected="selected"' : '';?>>TRACKER</option>
</select>
<select id="tag2" name="tag2" class="entrasel">
   <option value="">TAG-CAT</option>
   <option value="CORE" <?=$tag2== 'CORE' ? ' selected="selected"' : '';?>>CORE</option>
   <option value="CORE_EXTRACOSTO" <?=$tag2== 'CORE_EXTRACOSTO' ? ' selected="selected"' : '';?>>CORE_EXTRACOSTO</option>
   <option value="PREPROTO" <?=$tag2== 'PREPROTO' ? ' selected="selected"' : '';?>>PREPROTO</option>
   <option value="INFRA" <?=$tag2== 'INFRA' ? ' selected="selected"' : '';?>>INFRA</option>
   <option value="MOF_A" <?=$tag2== 'MOF_A' ? ' selected="selected"' : '';?>>MOF_A</option>
   <option value="MOF_B" <?=$tag2== 'MOF_B' ? ' selected="selected"' : '';?>>MOF_B</option>
   <option value="META" <?=$tag2== 'META' ? ' selected="selected"' : '';?>>META</option>
   <option value="RESP" <?=$tag2== 'RESP' ? ' selected="selected"' : '';?>>RESP</option>
   <option value="ESP" <?=$tag2== 'ESP' ? ' selected="selected"' : '';?>>ESP</option>
   <option value="FASE2" <?=$tag2== 'FASE2' ? ' selected="selected"' : '';?>>FASE2</option>
   <option value="FASE2_P2024" <?=$tag2== 'FASE2_P2024' ? ' selected="selected"' : '';?>>FASE2_P2024</option>
   <option value="M&C" <?=$tag2== 'M&C' ? ' selected="selected"' : '';?>>M&C</option>
</select>
<select id="tag3" name="tag3" class="entrasel" onchange="respcalc()">
   <option value="">LVL</option>
   <option value="L1" <?=$tag3== 'L1' ? ' selected="selected"' : '';?>>L1</option>
   <option value="L2" <?=$tag3== 'L2' ? ' selected="selected"' : '';?>>L2</option>
   <option value="L3" <?=$tag3== 'L3' ? ' selected="selected"' : '';?>>L3</option>
   <option value="nc" <?=$tag3== 'nc' ? ' selected="selected"' : '';?>>nc</option>
   <option value="L1.5" <?=$tag3== 'L1.5' ? ' selected="selected"' : '';?>>L1.5</option>
</select>

  <label for="wbs">wbs:</label>
  <input type="text" id="wbs" name="wbs" value="<?=$row['WBS'];?>">

<br><br>
</div>
<div class="w3-panel w3-border w3-khaki  w3-round-xlarge">
  <label for="rich">Richiesta:</label>
  <input type="text" id="rich" name="rich" size="80" height="100" value="<?=$row['richiesta'];?>"><br>
</div>
<div class="w3-panel w3-amber w3-round-xlarge">
   <label for="descrizione">Descrizione:</label>
  <textarea name="descrizione" form="myedit" rows="6" cols="80"> <?php if($row3!=NULL) {echo $row3['documentazione'];}?></textarea>
</div>

<div class="w3-panel w3-border w3-orange  w3-round-xlarge">
  <table class="w3-table w3-striped><tr><td>
  <label for="keur">kEur:</label><br>
  <input type="text" id="keur" name="keur" value="<?=$row['keur'];?>"><br><br>
  </td>
  <td>
  <label for="keurSJ">SJ:</label><br>
  <input type="text" id="keurSJ" name="keurSJ" value="<?=$row['keurSJ'];?>"><br><br>
  </td>
  <td>
  <label for="note">Note:</label><br>
    <input  type="text" id="note" name="note" value="<?=$row['note'];?>"><br><br>
  </td>
  </tr></table>
  </div>
  <label for="folderlink">Docs folder:</label><br>
  <input type="text" id="folder" name="folderlink" value="<?php if($row3) echo $row3['folder'];?>"><br><br>
  <input type="checkbox" id="cernbox" name="folder" value="folder">
  <label for="checkbox"> Create docs folder</label><br>
  <input type="submit" value="Confirm">
</form>
  <button onclick="document.getElementById('id04').style.display='none';showRichie(richie.value);">Cancel</button> 

<script>
console.log("you loaded the form");
var theform=document.getElementById("myedit");
   

theform.addEventListener("submit", function(event){
    event.preventDefault();
    theform.action="updata.php";
    fetch(theform.action, {
        method: "post",
        body: new URLSearchParams(new FormData(theform)) // for application/x-www-form-urlencoded
    })


    console.log("you submitted the form");
    document.getElementById('id02').style.display='block';
    showRichie(richie.value);
    document.getElementById('id04').style.display='none';
    console.log("list updated!");
    document.getElementById('entra').innerHTML='';
//    window.location = "alla.html";
});

</script>


<?php
}
mysqli_close($con);
?> 	
</html>
