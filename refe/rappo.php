<?php require 'dbinc.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<html>
<title>CMS REPORT CSN1</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<head>
<style>
.size50 { 
  max-width: 200px;
}
</style>
<!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="https://webanalytics.web.cern.ch/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '639']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->

</head>

<?php  


$con = mysqli_connect($server,$login,$pass,$db,$port);
//$con = mysqli_connect('localhost','cms','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
//echo "quering DB tot<br>";

mysqli_select_db($con,"cmsph2");
$sql="select sum(Assegnazioni.keur) as tot  from Assegnazioni where id in (select distinct Assegnazioni.id from Richieste,Assegnazioni where Assegnazioni.id_richiesta=Richieste.id ) and Assegnazioni.anno<2025;";
//print $sql;
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
   $totcsn1=$row["tot"];
};
?>



<div class="w3-container w3-teal">
  <h1>Report CORE CMS</h1>
</div>

<div class="w3-container w3-half">
  <h2>CORE CMS CSN1</h2>
  <span class="w3-tag w3-jumbo w3-green w3-right">
   <span class="w3-xlarge">Totale Assegnazioni</span> 
     <?php 
       echo $totcsn1; 
      ?> 
  </span>
</div>
<div class="w3-container w3-half size50" >
<?php
//echo "quering DB years<br>";


$sql="select distinct anno from Assegnazioni order by anno;";
$result = mysqli_query($con,$sql);
while($row3= mysqli_fetch_array($result)) {
   $myanno=$row3["anno"];
   $sql="select sum(Assegnazioni.keur) as totanno  from Assegnazioni where id in (select distinct Assegnazioni.id from Richieste,Assegnazioni where Assegnazioni.id_richiesta=Richieste.id ) and Assegnazioni.anno='".$myanno."';";
//echo "anno ".$myanno."<br>";
   $result2 = mysqli_query($con,$sql);
   $totcum=0;
   while($row2 = mysqli_fetch_array($result2)) {
	   $totcum+=$row2["totanno"];
	   echo "<div class=\"w3-container w3-yellow\" width=100px >". $myanno."<br>";
	   echo "<div class=\"w3-xlarge\">".$row2["totanno"]."</div>";  
//	   echo "<div class=\"w3-xlarge\">".$totcum."</div><br>";  
	   echo "</div> ";
          }
};


?>
</div>
<div class="w3-container w3-xlarge">
<br><h2>
Subsystems
</h2></div>
<br>

<?php
$sql="select distinct tag from Richieste where instr(tag,'CORE')>0 order by tag";
$result4 = mysqli_query($con,$sql);
   while($row4 = mysqli_fetch_array($result4)) {
     $mysubs=$row4["tag"];
     //echo $mysubs;
     $sql="select sum(Assegnazioni.keur) as tot  from Assegnazioni where id in (select distinct Assegnazioni.id from Richieste,Assegnazioni where Assegnazioni.id_richiesta=Richieste.id and Richieste.tag='".$mysubs."') and Assegnazioni.anno<2025 ;";

//     print $sql;
     $result = mysqli_query($con,$sql);
     while($row = mysqli_fetch_array($result)) {
        $totcsn1=$row["tot"];
      //  print $totcsn1;
     };


     echo "<div class=\"w3-container\"></div>";
     echo "<br><div class=\"w3-container w3-half\">";
     echo "<p><h3>CORE ".$mysubs." </h3>";
     echo  "<span class=\"w3-tag w3-xlarge w3-green w3-right\">
        <span class=\"w3-large\">Totale Assegnazioni   </span>";
     echo $totcsn1;
     echo  "</span> </div>";
     echo "<div class=\"w3-container w3-half size50\" >";
//<?php
////echo "quering DB years<br>";
//

echo "<br><br>";
     $sql="select distinct anno from Assegnazioni order by anno;";
     $result = mysqli_query($con,$sql);
     while($row3= mysqli_fetch_array($result)) {
        $myanno=$row3["anno"];
        $sql="select sum(Assegnazioni.keur) as totanno  from Assegnazioni where id in (select distinct Assegnazioni.id from Richieste,Assegnazioni where Assegnazioni.id_richiesta=Richieste.id and instr(Richieste.tag,'".$mysubs."')>0 ) and Assegnazioni.anno='".$myanno."'";
//        echo "anno ".$myanno."<br>";
        $result2 = mysqli_query($con,$sql);
        $totcum=0;
        while($row2 = mysqli_fetch_array($result2)) {
           $totcum+=$row2["totanno"];
           echo "<div class=\"w3-container w3-yellow\" width=100px >". $myanno."<br>";
           echo "<div class=\"w3-xlarge\">".$row2["totanno"]."</div>";
//           echo "<div class=\"w3-xlarge\">".$totcum."</div><br>";  
           echo "</div> ";
          }
   };
   echo "<br>";
   echo "</div>";
};

?>










<?php


mysqli_close($con);

?>
</div>
<body>


</body>
</html>

