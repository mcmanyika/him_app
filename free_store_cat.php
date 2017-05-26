<?php require_once('Connections/connection.php'); ?>

<?php
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


$maxRows_prod = 35;
$pageNum_prod = 0;
if (isset($_GET['pageNum_prod'])) {
  $pageNum_prod = $_GET['pageNum_prod'];
}
$startRow_prod = $pageNum_prod * $maxRows_prod;

$colname_prod = "-1";
if (isset($_GET['category'])) {
  $colname_prod = $_GET['category'];
}
mysql_select_db($database_connection, $connection);
$query_prod = sprintf("SELECT * FROM products WHERE subscriptions = 'Free' and category = %s ORDER BY id DESC", GetSQLValueString($colname_prod, "text"));
$query_limit_prod = sprintf("%s LIMIT %d, %d", $query_prod, $startRow_prod, $maxRows_prod);
$prod = mysql_query($query_limit_prod, $connection) or die(mysql_error());
$row_prod = mysql_fetch_assoc($prod);

if (isset($_GET['totalRows_prod'])) {
  $totalRows_prod = $_GET['totalRows_prod'];
} else {
  $all_prod = mysql_query($query_prod);
  $totalRows_prod = mysql_num_rows($all_prod);
}
$totalPages_prod = ceil($totalRows_prod/$maxRows_prod)-1;



$queryString_prod = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_prod") == false && 
        stristr($param, "totalRows_prod") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_prod = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_prod = sprintf("&totalRows_prod=%d%s", $totalRows_prod, $queryString_prod);
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
           <div class="page_content">
            <div class="blog-posts" style="background-color: #000000; opacity: 0.6;">
             <h2 class="page_title">
           <a href="#" data-panel="right" class="open-panel">Browse by Category</a>
         </h2>

              <ul>
              <?php do { ?>
                <li>
                  <nav class="user-nav">
                    <ul>
                     <li><img src="images/headphones1.png" class="img-responsive">                        
                      <span style="font-size:12px">
                      <a href="store-single.php?recordID=<?php echo $row_prod['id']; ?>" style="font-size:16px">
                      <?php echo $row_prod['title']; ?></a><br />
                      <b>Category: <?php echo $row_prod['category']; ?></b>
                      <br /><?php echo $row_prod['subscriptions']; ?></span>
                     </li>
                   </ul>
                </li>
                <?php } while ($row_prod = mysql_fetch_assoc($prod)); ?>
              </ul>
              
            <div class="clear"></div>  
            <div id="loadMore"><img src="images/load_posts.png" alt="" title="" /></div> 
            <div id="showLess"><img src="images/load_posts_disabled.png" alt="" title="" /></div> 
            </div>
      </div>
</div>
     
 <!-- InstanceEndEditable -->
              </div>
              </div>
      	 </div>
  		</div>
  </body>
<!-- InstanceEnd --></html>
<?php

mysql_free_result($prod);


?>