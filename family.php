<?php require_once('Connections/connection.php'); ?>

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO t_family (root_id) VALUES (%s)",
                       GetSQLValueString($_POST['root_id'], "int"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());

  $insertGoTo = "family.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_DetailRS1 = 6;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_connection, $connection);
$query_DetailRS1 = sprintf("SELECT * FROM devotions WHERE id = %s ORDER BY id DESC", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $connection) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;

$colname_family = "-1";
if (isset($_GET['root_id'])) {
  $colname_family = $_GET['root_id'];
}
mysql_select_db($database_connection, $connection);
$query_family = sprintf("SELECT * FROM my_family WHERE root_id = %s", GetSQLValueString($colname_family, "int"));
$family = mysql_query($query_family, $connection) or die(mysql_error());
$row_family = mysql_fetch_assoc($family);
$totalRows_family = mysql_num_rows($family);

$maxRows_DetailRS2 = 10;
$pageNum_DetailRS2 = 0;
if (isset($_GET['pageNum_DetailRS2'])) {
  $pageNum_DetailRS2 = $_GET['pageNum_DetailRS2'];
}
$startRow_DetailRS2 = $pageNum_DetailRS2 * $maxRows_DetailRS2;

$colname_DetailRS2 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS2 = $_GET['recordID'];
}
mysql_select_db($database_connection, $connection);
$query_DetailRS2 = sprintf("SELECT * FROM users  WHERE id = %s", GetSQLValueString($colname_DetailRS2, "int"));
$query_limit_DetailRS2 = sprintf("%s LIMIT %d, %d", $query_DetailRS2, $startRow_DetailRS2, $maxRows_DetailRS2);
$DetailRS2 = mysql_query($query_limit_DetailRS2, $connection) or die(mysql_error());
$row_DetailRS2 = mysql_fetch_assoc($DetailRS2);

if (isset($_GET['totalRows_DetailRS2'])) {
  $totalRows_DetailRS2 = $_GET['totalRows_DetailRS2'];
} else {
  $all_DetailRS2 = mysql_query($query_DetailRS2);
  $totalRows_DetailRS2 = mysql_num_rows($all_DetailRS2);
}
$totalPages_DetailRS2 = ceil($totalRows_DetailRS2/$maxRows_DetailRS2)-1;
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
<html><!-- InstanceBegin template="/Templates/base.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="apple-touch-startup-image-640x1096.png">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Heartfelt International Ministries</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/framework7.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/colors/blue.css">
<link type="text/css" rel="stylesheet" href="css/swipebox.css" />
<link type="text/css" rel="stylesheet" href="css/animations.css" />
<link rel="stylesheet" href="css/bootstrap.min.css">
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
<!-- InstanceBeginEditable name="head" -->
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
<!-- InstanceEndEditable -->
</head>
<body id="mobile_wrap">

    <div class="pages">
      <div data-page="projects" class="page no-toolbar no-navbar" style="background: url(images/colors/blue/blank.png) no-repeat center center;">
        <div class="page-content">
        
         <div class="navbarpages">
           <div class="nav_left_logo"><a href="index.php"><img src="images/logo.png" alt="" title="" /></a></div>
             <div class="nav_right_button">
               <a href="menu.html"><img src="images/icons/white/menu.png" alt="" title="" /></a>
               <a href="#" data-panel="right" class="open-panel"><img src="images/icons/white/search.png" alt="" title="" /></a>
               <a href="http://www.heartfeltonline.org/mobile/events.php"><img src="images/icons/white/back.png" alt="" title="" /></a>
             </div>
          </div>
         <div id="pages_maincontent">
              <div class="page_content"> 
              <div style="background-color: #000000; opacity: 0.6; color:#ffffff; padding:10px;">
		 <!-- InstanceBeginEditable name="maincontent" -->
         <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
           <table align="center">
             <tr valign="baseline">
               <td nowrap align="right">Root_id:</td>
               <td><input type="text" name="root_id" value="" size="32"></td>
             </tr>
             <tr valign="baseline">
               <td nowrap align="right">&nbsp;</td>
               <td><input type="submit" value="Insert record"></td>
             </tr>
           </table>
           <input type="hidden" name="MM_insert" value="form1">
         </form>
         <p>&nbsp;</p>
         
         
		 <!-- InstanceEndEditable -->
              </div>
              </div>
      	 </div>
  		</div>
</body>
<!-- InstanceEnd -->
		
<table border="1" align="center">
  
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS2['id']; ?> </td>
  </tr>
  <tr>
    <td>username</td>
    <td><?php echo $row_DetailRS2['username']; ?> </td>
  </tr>
  <tr>
    <td>password</td>
    <td><?php echo $row_DetailRS2['password']; ?> </td>
  </tr>
  <tr>
    <td>fname</td>
    <td><?php echo $row_DetailRS2['fname']; ?> </td>
  </tr>
  <tr>
    <td>lname</td>
    <td><?php echo $row_DetailRS2['lname']; ?> </td>
  </tr>
  <tr>
    <td>email</td>
    <td><?php echo $row_DetailRS2['email']; ?> </td>
  </tr>
  <tr>
    <td>phone</td>
    <td><?php echo $row_DetailRS2['phone']; ?> </td>
  </tr>
  <tr>
    <td>subscribe</td>
    <td><?php echo $row_DetailRS2['subscribe']; ?> </td>
  </tr>
  <tr>
    <td>date</td>
    <td><?php echo $row_DetailRS2['date']; ?> </td>
  </tr>
  
  
</table>
</html>
<?php
mysql_free_result($DetailRS1);

mysql_free_result($family);

mysql_free_result($DetailRS2);
?>
