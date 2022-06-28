<?php
include('header.php');
if (isset($_POST['select'])) {
  $geom = $obj->getGeom();
  $nb = 0;
  $cdn = $obj->findByCoordination();
  // geojson
  $features=[];
  while ($row = pg_fetch_object($geom)) :
    $tab = (array)$row;
    unset($tab['geom']);
    $feature=$tab['geometry'] = json_decode($tab['geometry']);
    unset($tab['geojson']);
    array_push($features,$feature);
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
    <p style="color: black;">La coordination de <span style="color: #0815B5 ;font-style: italic;"><?= $_POST['select'] ?></span> comptes <span style="color: #0815B5;font-style: italic;"><?= $nb ?></span> circuits</p>
  </div>
  <?php include('footer.php'); ?>

  <!-- script de leaflet -->
  <script>
    var map = L.map('map').setView([14.764787, -17.415362], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    // Add geojson vector layer
    var data = <?php echo json_encode($features); ?>;
    L.geoJSON(data).addTo(map);
  </script>