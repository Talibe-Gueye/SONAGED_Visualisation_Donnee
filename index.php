<?php
include('header.php');
$circuits_b = $obj->getAllCirBal();

$c = $obj->findCoord();
$sn=1;
$nbr_cir=0;
// if(isset($_POST['update'])){

//     $user = $obj->getUserById();
//     $_SESSION['user'] = pg_fetch_object($user);
//     header('location:edit.php');
// }
// if(isset($_POST['delete'])){

//    $ret_val = $obj->deleteuser();
//    if($ret_val==1){
       
//       echo "<script language='javascript'>";
//       echo "alert('Record Deleted Successfully'){
//           window.location.reload();
//       }";
//       echo "</script>";
//   }
// }
?>

<div class="container-fluid bg-3 text-center">
  <!-- <a href="insert.php" class="btn btn-primary pull-right" style='margin-top:-30px'><span class="glyphicon glyphicon-plus-sign"></span> Add Record</a>
  <br> -->

  <!-- select -->
  <form action="traitement.php" method="POST">
  <!-- selectionner un circuit -->
  <select name="circuit" id="circuit" style="margin: 10px 15px 5px 15PX;padding:8px;font-size:20px;">
      <option selected="selected" value="balayage_globale_dk">balayage_globale_dk</option>
      <option value="collecte_globale_dk">collecte_globale_dk</option>
    </select>

  <select name="select" id="coord" style="margin: 10px 15px 5px 15PX;padding:8px;font-size:20px;">
    <option value="" selected='selected'>-- Séléctionner une coordination --</option>
  <?php while($coo = pg_fetch_object($c)): ?>
    <option name='co' value="<?php echo $coo->coordinati ?>"><?php echo $coo->coordinati ?></option>
  <?php endwhile;?>
  <input type="submit" value="Rechercher" class="btn btn-secondary">
  </select>
  
  </form>

  <div class="panel panel-primary">
        <div class="panel-heading" style="font-family:sans-serif;">TABLEAU D'AFFICHAGE</div>
             
            <div class="panel-body">
            <table class="table table-bordered table-striped">
    <thead>
      <tr class="active">
            <th>No.</th>       
            <th>Emplacements</th>
            <th>Communes</th>
            <th>Longueurs</th>
            <th>Coordinations</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    while($circuit_b = pg_fetch_object($circuits_b)): 
    ?>   
      <tr align="left">
        <td ><?=$sn++?></td>
        <td><?=$circuit_b->nom?></td>
        <td><?=$circuit_b->nomcommune?></td>
        <td><?=$circuit_b->longueur?> métres</td>
        <td><?=$circuit_b->coordinati?></td>
        <td>
            <!-- <form method="post"> -->
                <!-- <input type="submit" class="btn btn-success" name= "update" value="Update">   
                <input type="submit" onClick="return confirm('Please confirm deletion');" class="btn btn-danger" name= "delete" value="Delete"> -->
                <!-- <input type="hidden" value="" name="id">
            </form> -->
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
 
</div>
</div>


<!-- // $coord = "<script> -->
<!-- // document.getElementById('select').onchange = function(){
// document.write(document.querySelector('#select').value);
// }</script>"; -->

<!-- // $circuit_by_coord = $obj->findByCoordination($coord);
// $result = pg_query($dbconn,"select * from public.balayage_globale_dk where coordinati = ". $coord);

// if(!$result){
//   echo 'An error';
//   exit;
// }
// $arr=pg_fetch_all($result);
// var_dump($arr);
// while($coo = pg_fetch_object($c)):
//   echo $coo->coordinati;
// endwhile; -->
<script>
  document.getElementById("coord").onchange = function(){

    var liste, texte;
    liste = document.getElementById("coord");
    texte = liste.options[liste.selectedIndex].text;
    console.log(texte);

};

</script>
<?php include('footer.php');?>