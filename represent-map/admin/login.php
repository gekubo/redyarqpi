<?
$page = "login";
include "header.php";

$is_loggedin = false;
$alert = "";

// logout
if($task == "logout") {
  setcookie("representmap_user", "", time()+3600000);
  setcookie("representmap_pass", "", time()+3600000);
  header("Location: login.php");
  exit;
}

// attempt login
if($task == "dologin") {
  $input_user = htmlspecialchars($_POST['user']);
  $input_pass = htmlspecialchars($_POST['pass']);
  if(trim($input_user) == "" || trim($input_pass) == "") {
    $alert = "Nupe. Inténtalo de nuevo";
  } else {
    if(crypt($input_user, $admin_user) == crypt($admin_user, $admin_user) && crypt($input_pass, $admin_pass) == crypt($admin_pass,$admin_pass)) {
      setcookie("representmap_user", crypt($input_user, $admin_user), time()+3600000);
      setcookie("representmap_pass", crypt($input_pass, $admin_pass), time()+3600000);
      header("Location: index.php");
      exit;
    } else {
      $alert = "Usuario o contraseña erróneos :(";
    }
  }
}

?>






<? echo $admin_head; ?>

<form class="well form-inline" action="login.php" id="login" method="post">
  <h1>
    RedYarqPI
  </h1>
  <?
    if($alert != "") {
      echo "
        <div class='alert alert-danger'>
          $alert
        </div>
      ";
    }
  ?>
  <input type="text" name="user" class="input-large" placeholder="Usuario">
  <input type="password" name="pass" class="input-large" placeholder="Contrase&ntilde;a">
  <button type="submit" class="btn btn-info">Acceder</button>
  <input type="hidden" name="task" value="dologin" />
</form>

<? echo $admin_foot; ?>