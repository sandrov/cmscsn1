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
//$f = $_GET['f'];

//$q='2026';
//$f="(sez='PG')";


echo "<h2> Anagrafica Anno ".$q."</h2>";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = mysqli_connect($server,$login,$pass,$db,$port);
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}



//get results from database
//$result = mysqli_query($connection, "SELECT * FROM products");
//$result = mysqli_query($con, "select sez,capitolo,sum(keur),sum(keurSJ) from Richieste where anno=2025 group by sez,capitolo order by sez,capitolo");



echo "<h3 class=\"w3-text-light-green\">SIGLE SINERGICHE</h3>";
                $resresp=mysqli_query($con, "select distinct siglesin.sigla,note from Persone,Anagrafica,siglesin  where Persone.id=Anagrafica.id_person and anno='".$q."' and (siglesin.sigla=SiglaSiner1 or siglesin.sigla=SiglaSiner2 or siglesin.sigla=SiglaSiner3) order by sigla") ;
                        echo '<table class="w3-table-all w3-responsive w3-small">';
		while ($row = mysqli_fetch_array($resresp)){
			echo "<tr>";
			echo "<td class w3-half >".$row['sigla']."</td><td>".$row['note']."</td>";
			echo "</tr>";

		}
			echo "</table>";

echo "</div><br>";

?>
