<?php
include "header.php";


if(isset($_GET['place_id'])) {
  $place_id = htmlspecialchars($_GET['place_id']); 
} else if(isset($_POST['place_id'])) {
  $place_id = htmlspecialchars($_POST['place_id']);
} else {
  exit; 
}


// get place info
$place_query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM places WHERE id='$place_id' LIMIT 1");
if(mysqli_num_rows($place_query) != 1) { exit; }
$place = mysqli_fetch_assoc($place_query);


// do place edit if requested
if($task == "doedit") {
  $title = str_replace( "'", "\\'", str_replace( "\\", "\\\\", $_POST['title'] ) );
  $type = $_POST['type'];
  $address = str_replace( "'", "\\'", str_replace( "\\", "\\\\", $_POST['address'] ) );
  $uri = $_POST['uri'];
  $description = str_replace( "'", "\\'", str_replace( "\\", "\\\\", $_POST['description'] ) );
  $owner_name = str_replace( "'", "\\'", str_replace( "\\", "\\\\", $_POST['owner_name'] ) );
  $owner_email = $_POST['owner_email'];
  $lat = (float) $_POST['lat'];
  $lng = (float) $_POST['lng'];
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE places SET title='$title', type='$type', address='$address', uri='$uri', lat='$lat', lng='$lng', description='$description', owner_name='$owner_name', owner_email='$owner_email' WHERE id='$place_id' LIMIT 1") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  
  // geocode
  //$hide_geocode_output = true;
  //include "../geocode.php";
  
  header("Location: index.php?view=$view&search=$search&p=$p");
  exit;
}

?>

<? echo $admin_head; ?>

<form id="admin" class="form-horizontal" action="edit.php" method="post">
  <h1>
    Editar marcador
  </h1>
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="">Yacimiento</label>
      <div class="controls">
        <input type="text" class="input input-xlarge" name="title" value="<?=$place[title]?>" id="">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="">Cronolog&iacute;a</label>
      <div class="controls">
        <select class="input input-xlarge" name="type">
	      <option<? if($place[type] == "paleo") {?> selected="selected"<? } ?>>paleo</option>
	      <option<? if($place[type] == "neo") {?> selected="selected"<? } ?>>neo</option>
          <option<? if($place[type] == "calco") {?> selected="selected"<? } ?>>calco</option>
          <option<? if($place[type] == "colon") {?> selected="selected"<? } ?>>colon</option>
          <option<? if($place[type] == "pre") {?> selected="selected"<? } ?>>pre</option>
          <option<? if($place[type] == "roma") {?> selected="selected"<? } ?>>roma</option>
          <option<? if($place[type] == "media") {?> selected="selected"<? } ?>>media</option>
          <option<? if($place[type] == "otros") {?> selected="selected"<? } ?>>otros</option>
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="">Web</label>
      <div class="controls">
        <input type="text" class="input input-xlarge" name="uri" value="<?=$place[uri]?>" id="">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="">Descripci&oacute;n</label>
      <div class="controls">
        <textarea class="input input-xlarge" name="description"><?=$place[description]?></textarea>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="">Coordenadas</label>
      <div class="controls">
        <input type="text" class="input input-xlarge" name="address" value="<?=$place[address]?>" id="">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="">Localizaci&oacute;n</label>
      <div class="controls">
        <input type="hidden" name="lat" id="mylat" value="<?=$place[lat]?>"/>
        <input type="hidden" name="lng" id="mylng" value="<?=$place[lng]?>"/>
        <div id="map" style="width:50%;height:300px;">
        </div>
        <script type="text/javascript">
          var map = new google.maps.Map( document.getElementById('map'), {
            zoom: 17,
            center: new google.maps.LatLng( <?=$place[lat]?>, <?=$place[lng]?> ),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            mapTypeControl: false
          });
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng( <?=$place[lat]?>, <?=$place[lng]?> ),
            map: map,
            draggable: true
          });
          google.maps.event.addListener(marker, 'dragend', function(e){
            document.getElementById('mylat').value = e.latLng.lat().toFixed(6);
            document.getElementById('mylng').value = e.latLng.lng().toFixed(6);
          });
        </script>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="">Nombre del colaborador</label>
      <div class="controls">
        <input type="text" class="input input-xlarge" name="owner_name" value="<?=$place[owner_name]?>" id="">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="">Email del colaborador</label>
      <div class="controls">
        <input type="text" class="input input-xlarge" name="owner_email" value="<?=$place[owner_email]?>" id="">
      </div>
    </div>  
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Guardar</button>
      <input type="hidden" name="task" value="doedit" />
      <input type="hidden" name="place_id" value="<?=$place[id]?>" />
      <input type="hidden" name="view" value="<?=$view?>" />
      <input type="hidden" name="search" value="<?=$search?>" />
      <input type="hidden" name="p" value="<?=$p?>" />
      <a href="index.php" class="btn" style="float: right;">Cancelar</a>
    </div>
  </fieldset>
</form>

<? echo $admin_foot; ?>