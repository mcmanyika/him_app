<?php require_once('Connections/connection.php'); ?>

<?php
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


$maxRows_raw = 60;
$pageNum_raw = 0;
if (isset($_GET['pageNum_raw'])) {
  $pageNum_new_pro = $_GET['pageNum_raw'];
}
$startRow_raw = $pageNum_raw * $maxRows_raw;

mysql_select_db($database_connection, $connection);
$query_raw = "SELECT * FROM locations ORDER BY Name ASC";
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

<!DOCTYPE html>
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
       </div>
     </div>
     <div id="pages_maincontent">
       <div class="page_content">
            <div class="blog-posts" style="background-color: #000000; opacity: 0.6; color:#ffffff;">
             <h2 class="page_title">Locations</h2>
              <ul class="posts">
              <?php do { ?>
                <li>
                    <div class="post_entry">
                        <div class="post_title">
                        <strong><a href="locations-single.php?recordID=<?php echo $row_raw['id']; ?>"><?php echo $row_raw['Name']; ?></a></strong><br />
                          <?php echo $row_raw['pastor']; ?>
                        </div>
                    </div>
                </li>
                <?php } while ($row_raw = mysql_fetch_assoc($raw)); ?>
              </ul>
              
            <div class="clear"></div>  
            <div id="loadMore"><img src="images/load_posts.png" alt="" title="" /></div> 
            <div id="showLess"><img src="images/load_posts_disabled.png" alt="" title="" /></div> 
            </div>
      
      </div>
      
      </div>
      
      
    </div>
  </div>
</div>


  </body>
</html>
<?php

mysql_free_result($raw);


?>