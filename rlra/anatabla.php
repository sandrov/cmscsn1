<?php require 'dbinc.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

echo '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';

echo "<script>
  var _paq = window._paq = window._paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=\"https://webanalytics.web.cern.ch/\";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '639']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
";

$q = $_GET['q'];
$y = $_GET['y'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}



//get results from database
//$result = mysqli_query($connection, "SELECT * FROM products");
//$result = mysqli_query($con, "select sez,capitolo,sum(keur),sum(keurSJ) from Richieste where anno=2025 group by sez,capitolo order by sez,capitolo");



$sql="select distinct Profilo from Persone,Anagrafica  where Persone.id=Anagrafica.id_person and anno='".$y."' and sigla='".$q."' order by Profilo";
$rescap=mysqli_query($con, $sql);

$sql="select distinct sez from Persone,Anagrafica  where Persone.id=Anagrafica.id_person and anno='".$y."' and sigla='".$q."' order by sez";
$ressez=mysqli_query($con, $sql);

$myrates=array("BA"=>4.05, "BO"=>3.8, "CT"=> 4.05, "FI"=> 3.8, "GE"=> 3.7, "LNF"=> 3.7, "LNL"=> 3.8, "MIB"=> 3.7, "NA"=> 3.95, "PD"=> 3.8, "PV"=> 3.7, "PG"=>3.95, "PI"=> 3.8, "RM1"=> 3.7, "TO"=> 3.7, "TS"=> 3.95);

if ($q=="atlas") {
echo "<h1> ATLAS Anagrafica ".$y." </h1><br>";
} else echo "<h1> ATLAS Fase2 Richieste ".$y." </h1><br>";
//showing property
echo '<table class="w3-table-all w3-responsive w3-tiny">
        <tr class="w3-red">';  //initialize table tag
//while ($property = mysqli_fetch_field($result)) {
//    echo '<td>' . htmlspecialchars($property->name) . '</td>';  //get field name for header
//}
//
//$mycaps[];
echo '<td> sezione </td>';
while ($row = mysqli_fetch_row($rescap)) {
	$mycaps[]=$row[0];
	echo '<td>'.$row[0].'</td>'; 
}
echo '</tr>'; //end tr tag

//showing all data
unset($thesezs);
while ($row = mysqli_fetch_array($ressez)) {
	$mysez=$row['sez'];
	$thesezs[]=$row['sez'];
	unset($sezkeur);
	unset($sezsj);
	$resreq = mysqli_query($con, "select sez,Profilo,sum(Percentuale_CMS/100) as CMS,sum((Percentuale_Sin1+Percentuale_Sin2+Percentuale_Sin3)/100) as Sinergiche from Persone,Anagrafica where Persone.id=Anagrafica.id_person and sigla='".$q."' and anno='".$y."' and sez='".$mysez."' group by sez,Profilo order by sez,Profilo");
        while ($rowreq = mysqli_fetch_array($resreq)) {
		$sezkeur[$rowreq['Profilo']]=$rowreq['CMS'];
		$sezsj[$rowreq['Profilo']]=$rowreq['Sinergiche'];
	}
	echo '<tr>';
	echo '<td><a href="#'.$mysez.'">'.$mysez.'</a></td>';
	foreach ($mycaps as $ocap) {
		echo '<td><span>' .$sezkeur[$ocap].'</span>&nbsp<span class="w3-text-cyan">'.$sezsj[$ocap];
		if ($sezsj[$ocap]) echo " sin";
		echo '</span></td>';
	}	
        echo '</tr>';
		
//		while ($row = mysqli_fetch_row($result)) {
 //   foreach ($row as $item) {
  //      echo '<td>' . htmlspecialchars($item) . '</td>'; //get items 
     }

	unset($sezkeur);
	unset($sezsj);
$resreq = mysqli_query($con, "select Profilo,sum(Percentuale_CMS/100) as keur,sum((Percentuale_Sin1+Percentuale_Sin2+Percentuale_Sin3)/100) as keurSJ from Persone,Anagrafica where Persone.id=Anagrafica.id_person and anno='".$y."' and sigla='".$q."'  group by Profilo order by Profilo");
        while ($rowreq = mysqli_fetch_array($resreq)) {
		$sezkeur[$rowreq['Profilo']]=$rowreq['keur'];
		$sezsj[$rowreq['Profilo']]=$rowreq['keurSJ'];
	}
	echo '<tr class="w3-yellow">';
	echo '<h2> <td> Totale</td>';
	foreach ($mycaps as $ocap) {
		echo '<td><span>' .$sezkeur[$ocap].'</span>&nbsp<span class="w3-text-cyan">'.$sezsj[$ocap];
		if ($sezsj[$ocap]) echo " sin";
		echo '</span></td>';
	}	
        echo '</h2></tr>';
echo "</table>";

foreach ($thesezs as $asez) {
   echo' <div class="w3-container">';
   echo '<p> <div id='.$asez.'><h2 class="w3-text-sienna">  Sezione '.$asez.'</h2></div></p>';
//   foreach ($mycaps as $ocap) {
                $resrich=mysqli_query($con, "select count(Persone.id) as perso,sum(Percentuale_CMS/100) as cmsfte,sum((Percentuale_Sin1+Percentuale_Sin2+Percentuale_Sin3)/100) as sinfte from Persone,Anagrafica where Persone.id=Anagrafica.id_person and anno='".$y."' and sigla='".$q."' and sez='".$asez."'");

                $rowrich = mysqli_fetch_array($resrich);
		if ($rowrich) {
		 echo "<h3 class=\"w3-text-amber\">FTE</h3>";
		 echo "<div class=\"w3-container\"><span>Persone:".$rowrich['perso']."</span></div>";
		 echo "<div class=\"w3-container\"><span> FTE:".$rowrich['cmsfte']+$rowrich['sinfte']."</span></div>";
                 if ($rowrich['sinfte']) echo "<div class=\"w3-container\"><span>&nbsp di cui &nbsp".$rowrich['sinfte']."&nbsp da sigle sinergiche</span></div>";
//	         do {
		  echo '<br>';
                 echo "<div>";
                 echo "<div><span class=\"w3-light-gray\"><a href=\"#\"><strong> ATLAS-ID</strong></a></div>";
//                 echo "<div><span class=\"w3-light-gray\"><a href=\"unnarefe.php?q=".$rowrich['id']."\"><strong> ATLAS-ID".$rowrich['id']."</strong></a></div>";
 //  
//                  echo "<div><span>".$rowrich['tag']."</span>&nbsp<span>".$rowrich['wbs']."</span>&nbsp<span>".$rowrich['richiesta']."</span></div>";
		 //                 26.1fte*1mp/fte*3.8KEuro/mp duty e shift
		 $metarich=$myrates[$asez]*($rowrich['cmsfte']+$rowrich['sinfte']);
                  echo "<div><span>ATLAS-META/".$rowrich['cmsfte']+$rowrich['sinfte']."fte*1mp/fte*".$myrates[$asez]."kEuro/mp duty e shift</span>&nbsp&nbsp<span>".$metarich."kEur</span></div>";
                 echo "<div><span class=\"w3-light-gray\"><a href=\"#\"><strong> ATLAS-ID</strong></a></div>";
		 $metarich=$myrates[$asez]*($rowrich['cmsfte']+$rowrich['sinfte']);
                  echo "<div><span>ATLAS-ESP/".$rowrich['cmsfte']+$rowrich['sinfte']."fte*1mp/fte*".$myrates[$asez]."kEuro/mp duty e shift</span>&nbsp&nbsp<span>".$metarich."kEur</span></div>";
  //                echo "<div>".$rowrich['keur']."kEur (".$rowrich['keurSJ']."SJ)</div>";
  //                 if (ltrim($rowrich['descrizione'])!="") {
   //                   echo "<div> Descrizione: <span>".$rowrich['descrizione']."</span></div>";
    //                }
//                  echo '</div>';
		 echo "<h3 class=\"w3-text-amber\">Consumo</h3>";
                 echo "<div><span class=\"w3-light-gray\"><a href=\"#\"><strong> ATLAS-ID</strong></a></div>";
                $metarich=1.5*($rowrich['cmsfte']+$rowrich['sinfte']);
                  echo "<div><span>ATLAS-META/Consumi Metabolici/".$rowrich['cmsfte']+$rowrich['sinfte']."fte*1.5kEur/fte</span>&nbsp&nbsp<span>".$metarich."kEur</span></div>";
 
                $resresp=mysqli_query($con, "select count(Persone.id) as perso,sum(5-(lvl*2)) as totresp from Persone,Responsabilities where Persone.id=Responsabilities.id_person and anno='".$y."' and sez='".$asez."'") ;
		$row = mysqli_fetch_array($resresp);
		if ($row['perso']){
		//while ($row = mysqli_fetch_row($resresp)){
	         echo "<h3 class=\"w3-text-amber\">Resp.</h3>";
                 echo "<div class=\"w3-container\"><span>Ruoli:".$row['perso']."</span></div>";
                 echo "<div class=\"w3-container\"><span>Tot mp:".$row['totresp']."</span></div>";
                };
		  echo '</div>';
		  echo '<br>';
                $resresp=mysqli_query($con, "select lvl,coconv,ruolo from Persone,Responsabilities where Persone.id=Responsabilities.id_person and ((lvl=0) OR (lvl=1) OR (lvl=2)) and anno='".$y."' and sez='".$asez."'") ;
		while ($rowrich = mysqli_fetch_array($resresp)){
                 echo "<div><span class=\"w3-light-gray\"><a href=\"#\"><strong> ATLAS-ID</strong></a></div>";

		 $mlvl=(int)($rowrich['lvl']);
		 $metarich=$myrates[$asez]*(5-($mlvl*2));
		 $metamp=(5-($mlvl*2));
		 //CMS-RESP L1/Trigger Coordinator 3 mp*3.8 KEuro/mp 
                 echo "<div><span>ATLAS-RESP L".$rowrich['lvl']."/".$rowrich['ruolo']."/".$metamp."mp*".$myrates[$asez]."kEuro/mp </span>&nbsp&nbsp<span>".$metarich."kEur</span></div>";
		}
                 
//do                 }
//                while ($rowrich = mysqli_fetch_array($resrich)); 
//foreach		}
}
echo "</div><br>";
}

?>
