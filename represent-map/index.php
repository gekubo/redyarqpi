<?php
include_once "header.php";
?>
<!DOCTYPE html>
<html>
	<head prefix="og: https://ogp.me/ns#">
    <title>RedYarqPI - Red de yacimientos arqueológicos de la Península Ibérica</title>
    <meta name="description" content="Este mapa ha sido elaborado para mostrar y promocionar los yacimientos arqueológicos de la Península Ibérica, preciosa herencia de nuestro antiguo y rico legado. Iremos añadiendo lugares de interés pero necesitamos tu ayuda para mantenerlo activo y actualizado.">
    <meta name="author" content="Guillermo García Galindo">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="./images/favicon.ico"/>
    <link rel="apple-touch-icon" href="./images/favicon.png"/>
    <link href="./bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="./bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <!-- Google Authorship -->
	<link rel="author" href="https://plus.google.com/115933468521200727206"/>
	<link rel="publisher" href="https://plus.google.com/111601786821680623100"/>
	<!-- Google+ Schema markup -->
	<meta itemprop="name" content="RedYarqPI - Red de yacimientos arqueológicos de la Península Ibérica">
	<meta itemprop="description" content="Este mapa ha sido elaborado para mostrar y promocionar los yacimientos arqueológicos de la Península Ibérica, preciosa herencia de nuestro antiguo y rico legado. Iremos añadiendo lugares de interés pero necesitamos tu ayuda para mantenerlo activo y actualizado.">
	<meta itemprop="image" content="./images/thumb.png">
	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary"/>
	<meta name="twitter:url" content="https://redyarqpi.orientalia.com.es"/>
	<meta name="twitter:site" content="@orientweet"/>
	<meta name="twitter:creator" content="@gekubo"/>
	<meta name="twitter:title" content="RedYarqPI - Red de yacimientos arqueológicos de la Península Ibérica"/>
	<meta name="twitter:description" content="Este mapa ha sido elaborado para mostrar y promocionar los yacimientos arqueológicos de la Península Ibérica, preciosa herencia de nuestro antiguo y rico legado. Iremos añadiendo lugares de interés pero necesitamos tu ayuda para mantenerlo activo y actualizado."/>
	<meta name="twitter:image" content="./images/thumb.png"/>

	<!-- Facebook Open Graph data -->
	<meta property="og:title" content="RedYarqPI - Red de yacimientos arqueológicos de la Península Ibérica">
	<meta property="og:site_name" content="RedYarqPI">
	<meta property="og:description" content="Este mapa ha sido elaborado para mostrar y promocionar los yacimientos arqueológicos de la Península Ibérica, preciosa herencia de nuestro antiguo y rico legado. Iremos añadiendo lugares de interés pero necesitamos tu ayuda para mantenerlo activo y actualizado.">
	<meta property="og:type" content="website"/>
	<meta property="og:image" content="./images/thumb.png">
	<meta property="og:image:type" content="image/png">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="./bootstrap/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
	<script src="./bootstrap/js/bootstrap-typeahead.js" type="text/javascript" charset="utf-8"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key= AIzaSyCMSvQ8H4ZQ951EnBmesrp5JM8_s7PxvCA" type="text/javascript"></script>
	<script type="text/javascript" src="./scripts/label.js"></script>
	<script type="text/javascript" src="./scripts/menu.js"></script>
	<script type="text/javascript">
      var map;
      var infowindow = null;
      var gmarkers = [];
      var markerTitles =[];
      var highestZIndex = 0;
      var agent = "default";
      var zoomControl = true;

      // detect browser agent
      $(document).ready(function(){
        if(navigator.userAgent.toLowerCase().indexOf("iphone") > -1 || navigator.userAgent.toLowerCase().indexOf("ipod") > -1) {
          agent = "iphone";
          zoomControl = false;
        }
        if(navigator.userAgent.toLowerCase().indexOf("ipad") > -1) {
          agent = "ipad";
          zoomControl = false;
        }
      });

      // resize marker list onload/resize
      $(document).ready(function(){
        resizeList()
      });
      $(window).resize(function() {
        resizeList();
      });

      // resize marker list to fit window
      function resizeList() {
        newHeight = $('html').height() - $('#navbar').height();
        $('#list').css('height', newHeight + "px");
        $('#menu').css('margin-top', $('#navbar').height());
      }

      // initialize map
      function initialize() {
        // set map styles
        var mapStyles = [
         {
            featureType: "road",
            elementType: "geometry",
            stylers: [
              { hue: "#8800ff" },
              { lightness: 100 }
            ]
          },{
            featureType: "road",
            stylers: [
              { visibility: "on" },
              { hue: "#91ff00" },
              { saturation: -62 },
              { gamma: 1.98 },
              { lightness: 45 }
            ]
          },{
            featureType: "water",
            stylers: [
              { hue: "#005eff" },
              { gamma: 0.72 },
              { lightness: 42 }
            ]
          },{
            featureType: "transit.line",
            stylers: [
              { visibility: "off" }
            ]
          },{
            featureType: "administrative.locality",
            stylers: [
              { visibility: "on" }
            ]
          },{
            featureType: "administrative.neighborhood",
            elementType: "geometry",
            stylers: [
              { visibility: "simplified" }
            ]
          },{
            featureType: "landscape",
            stylers: [
              { visibility: "on" },
              { gamma: 0.41 },
              { lightness: 46 }
            ]
          },{
            featureType: "administrative.neighborhood",
            elementType: "labels.text",
            stylers: [
              { visibility: "on" },
              { saturation: 33 },
              { lightness: 20 }
            ]
          }
        ];

        // set map options
        var myOptions = {
          zoom: 6,
          //minZoom: 10,
          center: new google.maps.LatLng(40,-1),
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          streetViewControl: false,
          mapTypeControl: true,
          mapTypeControlOptions: {
	      style: google.maps.MapTypeControlStyle.DEFAULT,
	      position: google.maps.ControlPosition.TOP_RIGHT
	      },
          panControl: false,
          panControlOptions: {
	      position: google.maps.ControlPosition.RIGHT_BOTTOM
	      },
          zoomControl: zoomControl,
          styles: mapStyles,
          zoomControlOptions: {
            style: google.maps.ZoomControlStyle.DEFAULT,
            position: google.maps.ControlPosition.RIGHT_CENTER
          }
        };
        map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
        zoomLevel = map.getZoom();

        // prepare infowindow
        infowindow = new google.maps.InfoWindow({
          content: "cargando..."
        });

        // only show marker labels if zoomed in
        google.maps.event.addListener(map, 'zoom_changed', function() {
          zoomLevel = map.getZoom();
          if(zoomLevel <= 15) {
            $(".marker_label").css("display", "none");
          } else {
            $(".marker_label").css("display", "inline");
          }
        });

        // markers array: name, type (icon), lat, long, description, uri, address
        markers = [];
        <?php
          $types = Array(
              Array('paleo', 'paleo'),
              Array('neo','neo'),
              Array('calco','calco'),
              Array('colon', 'colon'),
              Array('pre', 'pre'),
              Array('roma', 'roma'),
              Array('media', 'media'),
              Array('otros', 'otros'),
              Array('event', 'Event'),
              );
          $marker_id = 0;
          foreach($types as $type) {
            $places = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM places WHERE approved='1' AND type='$type[0]' ORDER BY title");
            $places_total = mysqli_num_rows($places);
            while($place = mysqli_fetch_assoc($places)) {
              $place[title] = htmlspecialchars_decode(addslashes(htmlspecialchars($place[title])));
              $place[description] = str_replace(array("\n", "\t", "\r"), "", htmlspecialchars_decode(addslashes(htmlspecialchars($place[description]))));
              $place[uri] = addslashes(htmlspecialchars($place[uri]));
              $place[address] = htmlspecialchars_decode(addslashes(htmlspecialchars($place[address])));
              echo "
                markers.push(['".$place[title]."', '".$place[type]."', '".$place[lat]."', '".$place[lng]."', '".$place[description]."', '".$place[uri]."', '".$place[address]."']);
                markerTitles[".$marker_id."] = '".$place[title]."';
              ";
              $count[$place[type]]++;
              $marker_id++;
            }
          }
          if($show_events == true) {
            $place[type] = "event";
            $events = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM events WHERE approved='1' ORDER BY id DESC");
            $events_total = mysqli_num_rows($events);
            while($event = mysqli_fetch_assoc($events)) {
              $event[title] = htmlspecialchars_decode(addslashes(htmlspecialchars($event[title])));
              $event[organizer_name] = htmlspecialchars_decode(addslashes(htmlspecialchars($event[organizer_name])));
              $event[uri] = addslashes(htmlspecialchars($event[uri]));
              $event[address] = htmlspecialchars_decode(addslashes(htmlspecialchars($event[address])));
              $event[date] = htmlspecialchars_decode(addslashes(htmlspecialchars($event[date])));
              echo "
                markers.push(['".$event[title]."', 'event', '".$event[lat]."', '".$event[lng]."', '".$event[date]."', '".$event[uri]."', '".$event[address]."']);
                markerTitles[".$marker_id."] = '".$event[title]."';
              ";
              $count[$place[type]]++;
              $marker_id++;
            }
          }
        ?>

        // add markers
        jQuery.each(markers, function(i, val) {
          infowindow = new google.maps.InfoWindow({
            content: ""
          });

          // offset latlong ever so slightly to prevent marker overlap
          rand_x = Math.random();
          rand_y = Math.random();
          val[2] = parseFloat(val[2]) + parseFloat(parseFloat(rand_x) / 6000);
          val[3] = parseFloat(val[3]) + parseFloat(parseFloat(rand_y) / 6000);

          // show smaller marker icons on mobile
          if(agent == "iphone") {
            var iconSize = new google.maps.Size(16,19);
          } else {
            iconSize = null;
          }

          // build this marker
          var markerImage = new google.maps.MarkerImage("./images/icons/"+val[1]+".png", null, null, null, iconSize);
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(val[2],val[3]),
            map: map,
            title: '',
            clickable: true,
            infoWindowHtml: '',
            zIndex: 10 + i,
            icon: markerImage
          });
          marker.type = val[1];
          gmarkers.push(marker);

          // add marker hover events (if not viewing on mobile)
          if(agent == "default") {
            google.maps.event.addListener(marker, "mouseover", function() {
              this.old_ZIndex = this.getZIndex();
              this.setZIndex(9999);
              $("#marker"+i).css("display", "inline");
              $("#marker"+i).css("z-index", "99999");
            });
            google.maps.event.addListener(marker, "mouseout", function() {
              if (this.old_ZIndex && zoomLevel <= 15) {
                this.setZIndex(this.old_ZIndex);
                $("#marker"+i).css("display", "none");
              }
            });
          }

          // format marker URI for display and linking
          var markerURI = val[5];
          if(markerURI.substr(0,7) != "http://") {
            markerURI = "http://" + markerURI;
          }
          var markerURI_short = markerURI.replace("http://", "");
          var markerURI_short = markerURI_short.replace("www.", "");

          // add marker click effects (open infowindow)
          google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(
              "<div class='marker_title'>"+val[0]+"</div>"
              + "<div class='marker_uri'><a target='_blank' href='"+markerURI+"'>"+markerURI_short+"</a></div>"
              + "<div class='marker_desc'>"+val[4]+"</div>"
              + "<div class='marker_address'>"+val[6]+"</div>"
            );
            infowindow.open(map, this);
          });

          // add marker label
          var latLng = new google.maps.LatLng(val[2], val[3]);
          var label = new Label({
            map: map,
            id: i
          });
          label.bindTo('position', marker);
          label.set("text", val[0]);
          label.bindTo('visible', marker);
          label.bindTo('clickable', marker);
          label.bindTo('zIndex', marker);
        });


        // zoom to marker if selected in search typeahead list
        $('#search').typeahead({
          source: markerTitles,
          onselect: function(obj) {
            marker_id = jQuery.inArray(obj, markerTitles);
            if(marker_id > -1) {
              map.panTo(gmarkers[marker_id].getPosition());
              map.setZoom(15);
              google.maps.event.trigger(gmarkers[marker_id], 'click');
            }
            $("#search").val("");
          }
        });
      }


      // zoom to specific marker
      function goToMarker(marker_id) {
        if(marker_id) {
          map.panTo(gmarkers[marker_id].getPosition());
          map.setZoom(15);
          google.maps.event.trigger(gmarkers[marker_id], 'click');
        }
      }

      // toggle (hide/show) markers of a given type (on the map)
      function toggle(type) {
        if($('#filter_'+type).is('.inactive')) {
          show(type);
        } else {
          hide(type);
        }
      }

      // hide all markers of a given type
      function hide(type) {
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].type == type) {
            gmarkers[i].setVisible(false);
          }
        }
        $("#filter_"+type).addClass("inactive");
      }

      // show all markers of a given type
      function show(type) {
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].type == type) {
            gmarkers[i].setVisible(true);
          }
        }
        $("#filter_"+type).removeClass("inactive");
      }

      // toggle (hide/show) marker list of a given type
      function toggleList(type) {
        $("#list .list-"+type).toggle();
      }


      // hover on list item
      function markerListMouseOver(marker_id) {
        $("#marker"+marker_id).css("display", "inline");
      }
      function markerListMouseOut(marker_id) {
        $("#marker"+marker_id).css("display", "none");
      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    <? echo $head_html; ?>
  </head>
  <body>




    <!-- display error overlay if something went wrong -->
    <?php echo $error; ?>

    <!-- google map -->
    <div id="map_canvas"></div>

    <!-- navbar -->
    <div class="navbar" id="navbar">
      <div class="wrapper">
        <div class="right">
          <div class="share">
<div class="fb-share-button" data-href="https://redyarqpi.orientalia.com.es" data-layout="button_count"></div>
<a class="twitter-share-button" data-text="Mapa para situar yacimientos arqueológicos. AÑADE EL TUYO! Difundir para preservar!!!" data-via="orientweet" data-hashtags="heritage" href="https://redyarqpi.orientalia.com.es">Tweet</a>
<div class="g-plus" data-action="share" data-annotation="bubble"></div>
          </div>
          <div class="donate">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="7TPD2BY2D3TL2">
<input type="hidden" name="lc" value="ES">
<input type="hidden" name="item_name" value="RedYarqPI">
<input type="hidden" name="item_number" value="xxx">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHosted">
<input type="image" src="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Donación a RedYarqPI">
<img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
        </div>
        <div class="left">
         	<a id="navi" href="#sidr">#<br>MENU</a>
            <a class="logo" href="/"><img src="./images/logo.png" alt="RedYarqPI" /></a>
          <div class="buttons">
            <a href="#modal_info" class="btn btn-large btn-info" data-toggle="modal"><i class="icon-info-sign icon-white"></i>Acerca del proyecto</a>
            <a href="#modal_place" class="btn btn-large btn-success" data-toggle="modal"><i class="icon-plus-sign icon-white"></i>Añade un yacimiento</a>
          </div>
          <div class="search">
            <input type="text" name="search" id="search" placeholder="Buscar yacimientos..." data-provide="typeahead" autocomplete="off" />
          </div>
        </div>
      </div>
    </div>

    <!-- right-side menu -->
<div id="sidr">
      <ul class="list" id="list">
        <?php
          $types = Array(
              Array('paleo', 'Cuevas y abrigos'),
              Array('neo','Megalitismo'),
              Array('calco', 'Edad de los metales'),
              Array('colon', 'Colonizaciones'),
              Array('pre', 'Pueblos prerromanos'),
              Array('roma', 'Roma'),
              Array('media', 'Edad Media'),
              Array('otros', 'Posteriores')
              );
          if($show_events == true) {
            $types[] = Array('event', 'Excavaciones');
          }
          $marker_id = 0;
          foreach($types as $type) {
            if($type[0] != "event") {
              $markers = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM places WHERE approved='1' AND type='$type[0]' ORDER BY title");
            } else {
              $markers = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM events WHERE approved='1' ORDER BY id DESC");
            }
            $markers_total = mysqli_num_rows($markers);
            echo "
              <li class='category'>
                <div class='category_item'>
                  <div class='category_toggle' onClick=\"toggle('$type[0]')\" id='filter_$type[0]'></div>
                  <a href='#' onClick=\"toggleList('$type[0]');\" class='category_info'><img src='./images/icons/$type[0].png' alt='' />$type[1]<span class='total'> ($markers_total)</span></a>
                </div>
                <ul class='list-items list-$type[0]'>
            ";
            while($marker = mysqli_fetch_assoc($markers)) {
              echo "
                  <li class='".$marker[type]."'>
                    <a href='#' onMouseOver=\"markerListMouseOver('".$marker_id."')\" onMouseOut=\"markerListMouseOut('".$marker_id."')\" onClick=\"goToMarker('".$marker_id."');\">".$marker[title]."</a>
                  </li>
              ";
              $marker_id++;
            }
            echo "
                </ul>
              </li>
            ";
          }
        ?>
        <li class="blurb">
Este proyecto se ha lanzado con el objetivo de poner al alcance de aquellos interesados el mayor número posible de  yacimientos arqueológicos de la Península Ibérica. Ya sea para visitarlos, protegerlos o trabajar en ellos. La motivación como puedes comprobar no es un problema mientras el objetivo final sea el mismo: <b>¡¡¡difundir nuestro patrimonio como forma de preservarlo!!!</b>
        </li>
        <li class="attribution">
        	<!-- per our license, you may not remove this line -->
          <?=$attribution?>
        </li>
      </ul>
<div class="clear"></div>
</div>

    <!-- more info modal -->
    <div class="modal hide" id="modal_info">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Acerca del proyecto</h3>
      </div>
      <div class="modal-body">
        <p>
          Este mapa ha sido elaborado para mostrar y promocionar los yacimientos arqueológicos de la Península Ibérica, preciosa herencia de nuestro antiguo y rico legado. Iremos añadiendo lugares de interés pero necesitamos tu ayuda para mantenerlo activo y actualizado. Si no encuentras un yacimiento que consideras debiera estar incluido, por favor no dudes en <a href="#modal_place" data-toggle="modal" data-dismiss="modal">añadirlo aquí</a>.
          <h3>¡¡¡Difundir para preservar!!!</h3>
        </p>
        <p>
          ¿Preguntas? ¿Sugerencias? ¿Erratas? Contacta con nosotros a través de cualquiera de los siguiente medios:
          <ul>
          <li>blog: <a href="https://www.orientalia.com.es" target="_blank">Orientalia</a></li>
          <li>facebook: <a href="https://www.facebook.com/orientlike" target="_blank">orientlike</a></li>
          <li>twitter: <a href="https://www.twitter.com/orientweet" target="_blank">@orientweet</a></li>
          <li>e-mail: <a href="mailto:orientalia@outlook.com?subject=RedYarqPI">orientalia@outlook.com</a></li>
          </ul>
        </p>
        <img src="./images/logo.png" alt="RedYarqPI" align="middle"/>
        <p>Si quieres enlazar con nosotros para promocionar esta iniciativa, <a href="./images/banner.psd">aquí</a> encontrarás algunos divertidos banners que servirán a tal propósito. Si deseas contribuir de forma económica, puedes enviar tu donación a través de <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=7TPD2BY2D3TL2&lc=ES&item_name=RedYarqPI&item_number=xxx&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted" alt="Donación a RedYarqPI" target="_blank">PayPal®</a>. Todo lo recaudado irá destinado a la mejora de los servidores y mantenimiento de la web.</p>
        <p>Este mapa ha sido creado a partir de <a href="https://github.com/abenzer/represent-map">RepresentMap</a>, un proyecto de código abierto (open source) para ayudar a iniciativas de todo el Mundo que necesiten disponer de sus propios mapas.</p>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" style="float: right;">Cerrar</a>
      </div>
    </div>

    <!-- add something modal -->
    <div class="modal hide" id="modal_place">
      <form action="add1.php" id="modal_add1" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h3>Añade un yacimiento</h3>
        </div>
        <div class="modal-body">
           <p>¿Quieres añadir el yacimiento con el que disfrutaste una agradable y educativa visita, en el que te has deslomado trabajando o alguno que desees denunciar su estado de abandono? Es tan sencillo como rellenar el siguiente formulario y esperar a que revisemos tu solicitud.</p><br/>
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="add_owner_name">Nombre:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="owner_name" id="add_owner_name" maxlength="100">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_owner_email">Correo electrónico:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="owner_email" id="add_owner_email" maxlength="100">
                <p class="help-block">
                  No te preocupes. No será visible al resto de usuarios.
                </p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_title">Nombre del yacimiento:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="title" id="add_title" maxlength="100" autocomplete="off">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="input01">Cronología / tipo de yacimiento:</label>
              <div class="controls">
                <select name="type" id="add_type" class="input-xlarge">
                  <option value="paleo">Cuevas y abrigos</option>
                  <option value="neo">Megalitismo</option>
                  <option value="calco">Edad de los metales</option>
                  <option value="colon">Colonizaciones</option>
                  <option value="pre">Pueblos prerromanos</option>
                  <option value="roma">Roma</option>
                  <option value="media">Edad Media</option>
                  <option value="otros">Posteriores</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_address">Coordenadas geográficas</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="address" id="add_address">
                <p class="help-block">Puedes poner un lugar de referencia o especificar las coordenadas exactas para una mayor precisión, ejemplo "40.7278, -4.7011". Si conseguiste localizarlo en <a href="https://www.maps.google.es" target="_blank">Google Maps®</a> debería funcionarte aquí. Si tienes alguna duda consulta <a href="https://www.agenciacreativa.net/coordenadas_google_maps.php" target="_blank">esta página</a>.</p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_uri">Web informativa</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="add_uri" name="uri" placeholder="http://">
                <p class="help-block">
                  Debes poner un enlace a un sitio web que aporte información fiable y actualizada sobre el yacimiento, ejemplo: "http://www.yoursite.com"
                </p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_description">Descripción</label>
              <div class="controls">
              	<textarea class="input input-xlarge" id="add_description" name="description"></textarea>
                <p class="help-block">
                  Breve y concisa (máx. 500 caracteres). Sería conveniente responder a los siguientes puntos:
                  <ul>
                  	<li>Estado (abandono, exvacaciones en curso, visitable, museizado...)</li>
                  	<li>Acceso (coche, bici, pendiente pronunciada...)</li>
                  	<li>Duración media de la visita</li>
                  	<li>Otros atractivos (entorno, localidades...)</li>
                  </ul>
                </p>
              </div>
            </div>
          <p class="help-block"><span style="color:#f07979">NOTAS IMPORTANTES:</span><br/>1-Asegúrate que no se encuentra indexado haciendo un simple búsqueda en la barra inferior. <br/>2-Si quieres informarnos de alguna campaña arqueológica o taller es mejor que rellenes este otro <a href="#modal_event" data-toggle="modal" data-dismiss="modal">formulario</a>.</p>
          </fieldset>
          <div id="result"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Enviar para su revisión</button>
          <a href="#" class="btn" data-dismiss="modal" style="float: right;">Cerrar</a>
        </div>
      </form>
    </div>
    <script>
      // add modal form submit
      $("#modal_add1").submit(function(event) {
        event.preventDefault();
        // get values
        var $form = $( this ),
            owner_name = $form.find( '#add_owner_name' ).val(),
            owner_email = $form.find( '#add_owner_email' ).val(),
            title = $form.find( '#add_title' ).val(),
            type = $form.find( '#add_type' ).val(),
            address = $form.find( '#add_address' ).val(),
            uri = $form.find( '#add_uri' ).val(),
            description = $form.find( '#add_description' ).val(),
            url = $form.attr( 'action' );

        // send data and get results
        $.post( url, { owner_name: owner_name, owner_email: owner_email, title: title, type: type, address: address, uri: uri, description: description },
          function( data ) {
            var content = $( data ).find( '#content' );

            // if submission was successful, show info alert
            if(data == "success") {
              $("#modal_add1 #result").html("¡Todo correcto! Hemos recibido tu solicitud y será revisada con la mayor rapidez posible. ¡Gracias por colaborar!");
              $("#modal_add1 #result").addClass("alert alert-info");
              $("#modal_add1 p").css("display", "none");
              $("#modal_add1 fieldset").css("display", "none");
              $("#modal_add1 .btn-primary").css("display", "none");

            // if submission failed, show error
            } else {
              $("#modal_add1 #result").html(data);
              $("#modal_add1 #result").addClass("alert alert-danger");
            }
          }
        );
      });
    </script>

    <!-- add event modal -->
 <div class="modal hide" id="modal_event">
      <form action="add2.php" id="modal_add2" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h3>Infórmanos de un evento</h3>
        </div>
        <div class="modal-body">
          <p>¿Eres una universidad, asociación o empresa que necesita reclutar personal para sus trabajos arqueológicos? ¿Quieres dar a conocer el yacimiento donde pasaste aquel maravilloso verano, cuando te quemaste todos los miembros que se te olvidó cubrir y conociste a montón de buena gente con la que compartiste conocimientos y experiencias? En tal caso, no dudes en hacérnoslo saber para que actualicemos nuestra base de datos.</p><br/>
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="add_title">Título:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="title" id="add_title" maxlength="100">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_organizer_name">Organizador:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="organizer_name" id="add_organizer_name" maxlength="100">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_uri">Web:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="uri" id="add_uri" placeholder="http://">
                <p class="help-block">
                  Debes poner un enlace a un sitio web o cartel que aporte información fiable y actualizada sobre la excavación, ejemplo: "http://www.yoursite.com"
                </p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_uri">Fechas:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="date" id="add_date" maxlength="100">
                <p class="help-block">
                  Debes especificar el periodo de duración de la excavación y el número de turnos establecidos. Por ejemplo, "del 15 de agosto al 15 de septiembre de 2013 (dos turnos)"
                </p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="add_address">Lugar:</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="address" id="add_address">
                <p class="help-block">Puedes poner un lugar de referencia o especificar las coordenadas exactas para una mayor precisión, ejemplo "40.7278, -4.7011". Si conseguiste localizarlo en <a href="https://www.maps.google.es" target="_blank">Google Maps®</a> debería funcionarte aquí. Si tienes alguna duda consulta <a href="https://www.agenciacreativa.net/coordenadas_google_maps.php" target="_blank">esta página</a>.</p>
              </div>
            </div>
          </fieldset>
         <div id="result"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Enviar para su revisión</button>
          <a href="#" class="btn" data-dismiss="modal" style="float: right;">Cerrar</a>
        </div>
      </form>
    </div>
    <script>
      // add modal form submit
      $("#modal_add2").submit(function(event) {
        event.preventDefault();
        // get values
        var $form = $( this ),
            title = $form.find( '#add_title' ).val(),
            organizer_name = $form.find( '#add_organizer_name' ).val(),
            uri = $form.find( '#add_uri' ).val(),
            date = $form.find( '#add_date' ).val(),
            address = $form.find( '#add_address' ).val(),
            url = $form.attr( 'action' );

        // send data and get results
        $.post( url, { title: title, organizer_name: organizer_name, uri: uri, date: date, address: address },
          function( data ) {
            var content = $( data ).find( '#content' );

            // if submission was successful, show info alert
            if(data == "success") {
              $("#modal_add2 #result").html("¡Todo correcto! Hemos recibido tu solicitud y será revisada con la mayor rapidez posible. ¡Gracias por colaborar!");
              $("#modal_add2 #result").addClass("alert alert-info");
              $("#modal_add2 p").css("display", "none");
              $("#modal_add2 fieldset").css("display", "none");
              $("#modal_add2 .btn-primary").css("display", "none");

            // if submission failed, show error
            } else {
              $("#modal_add2 #result").html(data);
              $("#modal_add2 #result").addClass("alert alert-danger");
            }
          }
        );
      });
    </script>

 <script>
 	(function () {
 	$('#navi').sidr();
 	})();
 </script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>
	<script src="https://apis.google.com/js/platform.js" async defer>
</body>
</html>;
