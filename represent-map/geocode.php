<?php
include_once "header.php";

// Run this script after new markers have been added to the DB.
// It will look for any markers that are missing latlong values
// and automatically geocode them.

// google maps vars
define("MAPS_HOST", "maps.googleapis.com");

// geocode all markers
geocode("places");
geocode("events");




// geocode function
function geocode($table) {
  global $hide_geocode_output;

  // get places that don't have latlong values
  $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM $table WHERE lat=0 OR lng=0") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  // geocode and save them back to the db
  $delay = 0;
  $base_url = "http://" . MAPS_HOST . "/maps/api/geocode/xml";

  // Iterate through the rows, geocoding each address
  while ($row = @mysqli_fetch_assoc($result)) {
    $geocode_pending = true;

    while ($geocode_pending) {
      $address = $row["address"];
      $id = $row["id"];
      $request_url = $base_url . "?address=" . urlencode($address) . "&sensor=false";
      $xml = simplexml_load_file($request_url) or die("url not loading");
      
      $status = $xml->status;
      if ($status == "OK") {
        // Successful geocode
        $geocode_pending = false;
        $coordinates = $xml->result->geometry->location;
        // Format: Longitude, Latitude, Altitude
        $lat = $coordinates->lat;
        $lng = $coordinates->lng;

        $query = sprintf("UPDATE $table " .
              " SET lat = '%s', lng = '%s' " .
              " WHERE id = '%s' LIMIT 1;",
              ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $lat) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")),
              ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $lng) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")),
              ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $id) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")));
        $update_result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
        if (!$update_result) {
          die("Invalid query: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        }
      } else if (strcmp($status, "620") == 0) {
        // sent geocodes too fast
        $delay += 100000;
      } else {
        // failure to geocode
        $geocode_pending = false;
        //echo "Address " . $address . " failed to geocoded. ";
        //echo "Received status " . $status . " \n";
      }
      usleep($delay);
    }
  }

  // finish
  if(@$hide_geocode_output != true) {
    echo mysqli_num_rows($result)." $table geocoded<br />";
  }

}