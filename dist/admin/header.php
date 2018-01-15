<?php
include "../include/db.php";
header("Content-Type: text/html; charset=utf-8");
// get task
if(isset($_GET['task'])) { $task = $_GET['task']; }
else if(isset($_POST['task'])) { $task = $_POST['task']; }

// get view
if(isset($_GET['view'])) { $view = $_GET['view']; }
else if(isset($_POST['view'])) { $view = $_POST['view']; }
else { $view = ""; }

// get page
if(isset($_GET['p'])) { $p = $_GET['p']; }
else if(isset($_POST['p'])) { $p = $_POST['p']; }
else { $p = 1; }

// get search
if(isset($_GET['search'])) { $search = $_GET['search']; }
else if(isset($_POST['search'])) { $search = $_POST['search']; }
else { $search = ""; }

// make sure admin is logged in
if($page != "login") {
  if($_COOKIE["representmap_user"] != crypt($admin_user, $admin_user) OR $_COOKIE["representmap_pass"] != crypt($admin_pass, $admin_pass)) {
    header("Location: login.php");
    exit;
  }
}

// connect to db
($GLOBALS["___mysqli_ston"] = mysqli_connect($db_host,  $db_user,  $db_pass)) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $db_name)) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

// get marker totals
$total_approved = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM places WHERE approved='1'"));
$total_rejected = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM places WHERE approved='0'"));
$total_pending = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM places WHERE approved IS null"));
$total_all = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM places"));

// admin header
$admin_head = "
  <html>
  <head>
    <title>RedYarqPI - Panel de control</title>
    <link href='../bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css' />
    <link href='../bootstrap/css/bootstrap-responsive.css' rel='stylesheet' type='text/css' />
    <link rel='stylesheet' href='admin.css' type='text/css' />
    <script src='../bootstrap/js/bootstrap.js' type='text/javascript' charset='utf-8'></script>
    <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' type='text/javascript' charset='utf-8'></script>
  </head>
  <body>
";
if($page != "login") {
  $admin_head .= "
    <div class='navbar navbar-fixed-top'>
      <div class='navbar-inner'>
        <div class='container'>
          <a class='brand' href='/'>
            RedYarqPI
          </a>
          <ul class='nav'>
            <li"; if($view == "") { $admin_head .= " class='active'"; } $admin_head .= ">
              <a href='index.php'>Todos</a>
            </li>
            <li"; if($view == "approved") { $admin_head .= " class='active'"; } $admin_head .= ">
              <a href='index.php?view=approved'>
                Aprobados
                <span class='badge badge-info'>$total_approved</span>
              </a>
            </li>
            <li"; if($view == "pending") { $admin_head .= " class='active'"; } $admin_head .= ">
              <a href='index.php?view=pending'>
                Pendientes
                <span class='badge badge-info'>$total_pending</span>
              </a>
            </li>
            <li"; if($view == "rejected") { $admin_head .= " class='active'"; } $admin_head .= ">
              <a href='index.php?view=rejected'>
                Rechazados
                <span class='badge badge-info'>$total_rejected</span>
              </a>
            </li>
          </ul>
          <form class='navbar-search pull-left' action='index.php' method='get'>
            <input type='text' name='search' class='search-query' placeholder='Buscar' autocomplete='off' value='$search'>
          </form>
          <ul class='nav pull-right'>
            <li><a href='login.php?task=logout'>Cerrar sesi&oacute;n</a></li>
          </ul>
        </div>
      </div>
    </div>
  ";
}
$admin_head .= "
  <div id='content'>
";

// if startup genome enabled, show message here
if($sg_enabled) {
  $admin_head .= "
    <div class='alert alert-info'>
      Note: You have Startup Genome integration enabled in your config file (/include/db.php).
      If you want to make changes to the markers on your map, please do so from the
      <a href='http://www.startupgenome.com'>Startup Genome website</a>. Any changes
      you make here may not persist on your map unless you turn off Startup Genome mode.
    </div>
  ";
}

// admin footer
$admin_foot = "
    </div>
  </body>
</html>
";
