<?php
include('header.php');
if (isset($_POST['submit'])) {
  if(isset($_POST['com'])){
  $geom = $obj->getTableJsonSS();
  $nomCoordination=$_POST['com'];
  }else{
  $geom = $obj->getTableJson();
  $nomCoordination=$_POST['coord'];
  }
  $circuit=$_POST['circuit'];
  $nbCircuit = $obj->getGeom();
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
  <p style="color: black;">La coordination de <span style="color: #0815B5 ;font-style: italic;"><?= $nomCoordination ?></span> compte <span style="color: #0815B5;font-style: italic;"><?= $n ?></span> circuits</p>
</div>
<?php include('footer.php'); ?>

<!-- script de leaflet -->
<script>
  var map = L.map('map').setView([14.764787, -17.415362], 8);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
  }).addTo(map);

  // type de balayage
  var circuitJS = <?php echo json_encode($circuit); ?>;
  // Add geojson vector layer
  var data = <?php echo json_encode($geojson); ?>;
  // style du texte sur popup
  var myStyle = {
    "color": "#151414",
    "weight": 5,
    "opacity": 0.65,
    "size": 15,
  };
  // test de changement de couleur des circuits
  var myLayer = L.geoJSON(data, {
    style: function(layer) {
        switch (circuitJS) {
            case 'balayage': return {color: "#0510C5 ",opacity: 0.85};
            case 'collecte':   return {color: "#050404",opacity: 0.85};
        }
    }
}).addTo(map);
  myLayer.bindPopup(function(layer) {
  return "<h4>Circuit " + layer.feature.properties.f2 + "<p>Longueur: " + layer.feature.properties.f4 + " métres</p></h4>";
  });
  // Control Layer
  var baseLayers = {
    "Base Map": myLayer
};
var controlLayer = L.control.layers(baseLayers).addTo(map);
// echelle
L.control.scale().addTo(map);

  // fin test de circuit

  // var dataArray = Object.entries(data);
  // var myLayer = L.geoJSON(data, {
  //   style: myStyle
  // }).addTo(map);
  // // Lancer le popup
  // myLayer.bindPopup(function(layer) {
  //   return "<h4>Circuit " + layer.feature.properties.f2 + "<p>Longueur: " + layer.feature.properties.f4 + " métres</p></h4>";
  // });
  // console.log(typeof(dataArray));
</script>