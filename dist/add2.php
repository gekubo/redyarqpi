<?php
include_once "header.php";

// This is used to submit new markers for review.
// Markers won't appear on the map until they are approved.

$title = parseInput($_POST['title']);
$organizer_name = parseInput($_POST['organizer_name']);
$uri = parseInput($_POST['uri']);
$date = parseInput($_POST['date']);
$address = parseInput($_POST['address']);

// validate fields
if(empty($uri) || empty($date) || empty($address) || empty($title) || empty($organizer_name)) {
  echo "Por favor rellena todos los campos";
  exit;
  
} else {
  
  
  
  // if startup genome mode enabled, post new data to API
  if($sg_enabled) {
    
    try {
      @$r = $http->doPost("/organization", $_POST);
      $response = json_decode($r, 1);
      if ($response['response'] == 'success') {
        include_once("startupgenome_get.php");
        echo "success"; 
        exit;
      }
    } catch (Exception $e) {
      echo "<pre>";
      print_r($e);
    }
    
    
  // normal mode enabled, save new data to local db
  } else {

    // insert into db, wait for approval
    $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO events (approved, uri, date, address, title, organizer_name) VALUES (null, '$uri', '$date', '$address', '$title', '$organizer_name')") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    // geocode new submission
    $hide_geocode_output = true;
    include "geocode.php";
    
    echo "success";
    exit;
  
  }

  
}