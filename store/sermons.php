<?php require_once('../Connections/connection.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sermons = 10;
$pageNum_sermons = 0;
if (isset($_GET['pageNum_sermons'])) {
  $pageNum_sermons = $_GET['pageNum_sermons'];
}
$startRow_sermons = $pageNum_sermons * $maxRows_sermons;

mysql_select_db($database_connection, $connection);
$query_sermons = "SELECT * FROM products";
$query_limit_sermons = sprintf("%s LIMIT %d, %d", $query_sermons, $startRow_sermons, $maxRows_sermons);
$sermons = mysql_query($query_limit_sermons, $connection) or die(mysql_error());
$row_sermons = mysql_fetch_assoc($sermons);

if (isset($_GET['totalRows_sermons'])) {
  $totalRows_sermons = $_GET['totalRows_sermons'];
} else {
  $all_sermons = mysql_query($query_sermons);
  $totalRows_sermons = mysql_num_rows($all_sermons);
}
$totalPages_sermons = ceil($totalRows_sermons/$maxRows_sermons)-1;

$queryString_sermons = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sermons") == false && 
        stristr($param, "totalRows_sermons") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sermons = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sermons = sprintf("&totalRows_sermons=%d%s", $totalRows_sermons, $queryString_sermons);
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/base2.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="../images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="../apple-touch-startup-image-640x1096.png">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Heartfelt International Ministries</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="../css/framework7.css">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/colors/blue.css">
<link type="text/css" rel="stylesheet" href="../css/swipebox.css" />
<link type="text/css" rel="stylesheet" href="../css/animations.css" />
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
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
               <a href="events.html"><img src="images/icons/white/back.png" alt="" title="" /></a>
             </div>
            </div>
         <div id="pages_maincontent"><!-- InstanceBeginEditable name="maincontent" -->
       <div class="page_content">
            <div class="blog-posts" style="background-color: #000000; opacity: 0.6; color:#ffffff;">
              <h2 class="page_title"><a href="#" data-panel="right" class="open-panel" style="color:#ffffff">Browse by Category</a></h2>              
             <ul class="posts">
                <li>
                    <div class="post_entry">
                        <?php do { ?>
                        <div class="post_title">
                            <h3><a href="sermons-single.php?recordID=<?php echo $row_sermons['id']; ?>" class="external"><?php echo $row_sermons['title']; ?></a></h3>
                          </div>
                          <?php } while ($row_sermons = mysql_fetch_assoc($sermons)); ?>
                    </div>
                </li>
              </ul>
            </div>
      	</div>
 <!-- InstanceEndEditable -->
              
      	 </div>
  		</div>
  </body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($sermons);
?>
