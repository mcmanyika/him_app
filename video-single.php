<?php require_once('Connections/connection.php'); ?><?php
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

$maxRows_DetailRS1 = 10;
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
$query_DetailRS1 = sprintf("SELECT * FROM videos WHERE id = %s ORDER BY id DESC", GetSQLValueString($colname_DetailRS1, "int"));
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
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="apple-touch-startup-image-640x1096.png">
<title>Heartfelt International Ministries</title>
<link rel="stylesheet" href="css/framework7.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/colors/blue.css">
<link type="text/css" rel="stylesheet" href="css/swipebox.css" />
<link type="text/css" rel="stylesheet" href="css/animations.css" />
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
</head>
<body id="mobile_wrap">

<div class="pages">
  <div data-page="projects" class="page no-toolbar no-navbar homepage">
    <div class="page-content">
    
     <div class="navbarpages">
       <div class="nav_left_logo"><a href="index.php" class="external"><img src="images/logo.png" alt="" title="" /></a></div>
       <div class="nav_right_button">
       <a href="menu.html"><img src="images/icons/white/menu.png" alt="" title="" /></a>
       <a href="#" data-panel="right" class="open-panel"><img src="images/icons/white/search.png" alt="" title="" /></a>
       <a href="events.php"><img src="images/icons/white/back.png" alt="" title="" /></a>
       </div>
     </div>
     <div id="pages_maincontent">
          <div class="post_single"style="background-color: #000000; opacity: 0.9; color:#ffffff">

            <div class="featured_image">
            
				
              <div style="padding: 20px">
<div style="font-size: 24px">
            <?php echo $row_DetailRS1['header']; ?></div>
               <div class="videocontainer">
                	<iframe width="100%" height="180" src="<?php echo $row_DetailRS1['video']; ?>" frameborder="0"></iframe>
                </div>
              </div> 
              <div style="padding: 20px">

            </div>
                 
            <div class="page_content"> 
              <div class="entry">
              
              </div>
            </div>
            
          </div>
         
         
    </div>
  </div>
</div>





  </body>
</html><?php
mysql_free_result($DetailRS1);
?>