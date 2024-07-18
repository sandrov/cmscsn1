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



$sql="select distinct capitolo from Richieste where anno='".$y."' and sigla='".$q."' order by capitolo";
$rescap=mysqli_query($con, $sql);

$sql="select distinct sez from Richieste where anno='".$y."' and sigla='".$q."' order by sez";
$ressez=mysqli_query($con, $sql);

if ($q=="cms") {
echo "<h1> CMS Richieste 2025 </h1><br>";
} else echo "<h1> CMS Fase2 Richieste 2025 </h1><br>";
//showing property
echo '<table class="w3-table-all">
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
	$resreq = mysqli_query($con, "select sez,capitolo,sum(keur) as keur,sum(keurSJ) as keurSJ from Richieste where sigla='".$q."' and anno='".$y."' and sez='".$mysez."' group by sez,capitolo order by sez,capitolo");
        while ($rowreq = mysqli_fetch_array($resreq)) {
		$sezkeur[$rowreq['capitolo']]=$rowreq['keur'];
		$sezsj[$rowreq['capitolo']]=$rowreq['keurSJ'];
	}
	echo '<tr>';
	echo '<td><a href="#'.$mysez.'">'.$mysez.'</a></td>';
	foreach ($mycaps as $ocap) {
		echo '<td><span>' .$sezkeur[$ocap].'</span>&nbsp<span class="w3-text-cyan">'.$sezsj[$ocap];
		if ($sezsj[$ocap]) echo "sj ";
		echo '</span></td>';
	}	
        echo '</tr>';
		
//		while ($row = mysqli_fetch_row($result)) {
 //   foreach ($row as $item) {
  //      echo '<td>' . htmlspecialchars($item) . '</td>'; //get items 
     }

	unset($sezkeur);
	unset($sezsj);
$resreq = mysqli_query($con, "select capitolo,sum(keur) as keur,sum(keurSJ) as keurSJ from Richieste where anno='".$y."' and sigla='".$q."'  group by capitolo order by capitolo");
        while ($rowreq = mysqli_fetch_array($resreq)) {
		$sezkeur[$rowreq['capitolo']]=$rowreq['keur'];
		$sezsj[$rowreq['capitolo']]=$rowreq['keurSJ'];
	}
	echo '<tr class="w3-yellow">';
	echo '<h2> <td> Totale</td>';
	foreach ($mycaps as $ocap) {
		echo '<td><span>' .$sezkeur[$ocap].'</span>&nbsp<span class="w3-text-cyan">'.$sezsj[$ocap];
		if ($sezsj[$ocap]) echo "sj ";
		echo '</span></td>';
	}	
        echo '</h2></tr>';
echo "</table>";

foreach ($thesezs as $asez) {
   echo' <div class="w3-container">';
   echo '<p> <div id='.$asez.'><h2 class="w3-text-sienna">  Sezione '.$asez.'</h2></div></p>';
   foreach ($mycaps as $ocap) {
                $resrich=mysqli_query($con, "select Richieste.id,richiesta,documentazione as descrizione,tag,wbs,keur,keurSJ from Richieste,docs where Richieste.id=id_richiesta and anno='".$y."' and sigla='".$q."' and capitolo='".$ocap."' and sez='".$asez."'");

                $rowrich = mysqli_fetch_array($resrich);
		if ($rowrich) {
		 echo '<h3 class="w3-text-amber">'.$ocap.'</h3>';
	         do {
                  echo "<div>";
                  echo "<div><span class=\"w3-light-gray\"><a href=\"unnarefe.php?q=".$rowrich['id']."\"><strong> CMS-ID".$rowrich['id']."</strong></a></div>";
   
                  echo "<div><span>".$rowrich['tag']."</span>&nbsp<span>".$rowrich['wbs']."</span>&nbsp<span>".$rowrich['richiesta']."</span></div>";
                  echo "<div>".$rowrich['keur']."kEur (".$rowrich['keurSJ']."SJ)</div>";
                   if (ltrim($rowrich['descrizione'])!="") {
                      echo "<div> Descrizione: <span>".$rowrich['descrizione']."</span></div>";
                    }
                  echo '</div>';
		  
		  $dirPath = 'documentazione/CMS-ID'.$rowrich['id'];
		  //echo 'files (in '.$dirPath.'):';
                  $files = scandir($dirPath);
		  if (count($files)>2) {
		    echo '<div class="w3-container">';
		      echo '<a href="https://cernbox.cern.ch/files/spaces/eos/user/v/venturas/cmscsn1/documentazione/CMS-ID'.$rowrich['id'].'">Allegati: </a><br>';
                      foreach ($files as $file) {
                        $filePath = $dirPath . '/' . $file;
                        if (is_file($filePath)) {
                          echo $file . "<br>";
			}
                       }
		    echo '</div>';
                  }
		  echo '<br>';

                 }
                while ($rowrich = mysqli_fetch_array($resrich)); 
		}
}
echo "</div><br>";
}

?>
