<?php require_once('../Connections/connection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm")) {
  $insertSQL = sprintf("INSERT INTO users (id, username, password, email, subscribe) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['subscribe'], "text"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());

  $insertGoTo = "#!/registration_confirmation.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];


$maxRows_raw = 12;
$pageNum_raw = 0;
if (isset($_GET['pageNum_raw'])) {
  $pageNum_raw = $_GET['pageNum_raw'];
}
$startRow_raw = $pageNum_raw * $maxRows_raw;

mysql_select_db($database_connection, $connection);
$query_raw = "SELECT * FROM category ORDER BY id ASC";
$query_limit_raw = sprintf("%s LIMIT %d, %d", $query_raw, $startRow_raw, $maxRows_raw);
$raw = mysql_query($query_limit_raw, $connection) or die(mysql_error());
$row_raw = mysql_fetch_assoc($raw);

if (isset($_GET['totalRows_raw'])) {
  $totalRows_raw = $_GET['totalRows_raw'];
} else {
  $all_raw = mysql_query($query_raw);
  $totalRows_raw = mysql_num_rows($all_raw);
}
$totalPages_raw = ceil($totalRows_raw/$maxRows_raw)-1;

$queryString_raw = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_raw") == false && 
        stristr($param, "totalRows_raw") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_raw = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_raw = sprintf("&totalRows_raw=%d%s", $totalRows_raw, $queryString_raw);
?>
<?php

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "subscribe";
  $MM_redirectLoginSuccess = "#!/index.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connection, $connection);
  	
  $LoginRS__query=sprintf("SELECT email, password, subscribe FROM users WHERE email=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'subscribe');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="../images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="../apple-touch-startup-image-640x1096.png">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Heartfelt International Ministries</title>
<!-- TemplateEndEditable -->
<link rel="stylesheet" href="../css/framework7.css">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/colors/blue.css">
<link type="text/css" rel="stylesheet" href="../css/swipebox.css" />
<link type="text/css" rel="stylesheet" href="../css/animations.css" />
<link rel="stylesheet" href="../css/bootstrap.min.css">
<style>
.box_white {
	border-width:1px;
	border-color:#ffffff;
	border-style:solid;
	padding:5px;
	display: block;
    margin: auto;
}
.div_width {
	width:100% !important
	}

</style>
<!-- TemplateInfo codeOutsideHTMLisLocked="true" --!>
<!-- TemplateBeginEditable name="head" -->

<!-- TemplateEndEditable -->
</head>
<body id="mobile_wrap">

    <div class="pages">
      <div data-page="projects" class="page no-toolbar no-navbar" style="background: url(images/colors/blue/blank.png) no-repeat center center;">
        <div class="page-content">
        
         <div class="navbarpages">
           <div class="nav_left_logo"><a href="../index.php"><img src="../images/logo.png" alt="" title="" /></a></div>
             <div class="nav_right_button">
               <a href="../menu.html"><img src="../images/icons/white/menu.png" alt="" title="" /></a>
               <a href="#" data-panel="right" class="open-panel"><img src="../images/icons/white/search.png" alt="" title="" /></a>
               <a href="http://www.heartfeltonline.org/mobile/events.php"><img src="../images/icons/white/back.png" alt="" title="" /></a>
             </div>
            </div>
         <div id="pages_maincontent">
              <div class="page_content"> 
              <div style="background-color: #000000; opacity: 0.6; color:#ffffff; padding:10px;">
		 <!-- TemplateBeginEditable name="maincontent" -->
         
		 
		 
		 <!-- TemplateEndEditable -->
              </div>
              </div>
      	 </div>
  		</div>
  </body>
</html>
<?php
mysql_free_result($raw);

mysql_free_result($user);
?>