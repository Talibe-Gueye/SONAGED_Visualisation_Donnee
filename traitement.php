<?php
include('header.php');
if (isset($_POST['select'])) {
  $nbCircuit = $obj->getGeom();
  $geom = $obj->getTableJson();
  $cdn = $obj->findByCoordination();
  // geojson
  $features = [];
  $featureCollection = [];
  $n = 0;
  while ($nb = pg_fetch_object($nbCircuit)) :
    $n++;
  endwhile;
  while ($row = pg_fetch_object($geom)) :
    $tab = (array)$row;
    $geojson = json_decode($tab["features"]);
  // unset($tab['geom']);
  // unset($tab['geojson']);
  // array_push($features,$feature);
  // $tabFeature[]=["type"=>"Feature","properties"=>$tab];
  endwhile;
  // Fin geojson
}
?>

<div>
  <a href="index.php" class="btn btn-primary col-md-2 mt-3 mb-3" style="margin: 5px 0 5px 2px;">Retour sur la Page d'accueil</a>
</div>
<!-- map -->
<div id="map"></div>

<div class="md-10" style="width: 100%;background-color:#57A197;padding:5%;text-align:center;font-size:35px">
  <p style="color: black;">La coordination de <span style="color: #0815B5 ;font-style: italic;"><?= $_POST['select'] ?></span> compte <span style="color: #0815B5;font-style: italic;"><?= $n ?></span> circuits</p>
</div>
<?php include('footer.php'); ?>

<!-- script de leaflet -->
<script>
  var map = L.map('map').setView([14.764787, -17.415362], 12);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
  }).addTo(map);

  // Add geojson vector layer
  var data = <?php echo json_encode($geojson); ?>;
  // style du texte sur popup
  var myStyle = {
    "color": "#151414",
    "weight": 5,
    "opacity": 0.65,
    "size": 15,
  };

  // var dataArray = Object.entries(data);
  var myLayer = L.geoJSON(data, {
    style: myStyle
  }).addTo(map);
  // Lancer le popup
  myLayer.bindPopup(function(layer) {
    return "<h4>Circuit " + layer.feature.properties.f2 + "<p>Longueur: " + layer.feature.properties.f4 + " métres</p></h4>";
  });
  // console.log(typeof(dataArray));
</script>