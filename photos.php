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


$maxRows_quotes = 35;
$pageNum_quotes = 0;
if (isset($_GET['pageNum_quotes'])) {
  $pageNum_new_pro = $_GET['pageNum_quotes'];
}
$startRow_quotes = $pageNum_quotes * $maxRows_quotes;

mysql_select_db($database_connection, $connection);
$query_quotes = "SELECT * FROM quotes ORDER BY id desc";
$query_limit_quotes = sprintf("%s LIMIT %d, %d", $query_quotes, $startRow_quotes, $maxRows_quotes);
$quotes = mysql_query($query_limit_quotes, $connection) or die(mysql_error());
$row_quotes = mysql_fetch_assoc($quotes);

if (isset($_GET['totalRows_quotes'])) {
  $totalRows_quotes = $_GET['totalRows_quotes'];
} else {
  $all_quotes = mysql_query($query_quotes);
  $totalRows_quotes = mysql_num_rows($all_quotes);
}
$totalPages_quotes = ceil($totalRows_quotes/$maxRows_quotes)-1;



$queryString_quotes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_quotes") == false && 
        stristr($param, "totalRows_quotes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_quotes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_quotes = sprintf("&totalRows_quotes=%d%s", $totalRows_quotes, $queryString_quotes);
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
  <div data-page="projects" class="page no-toolbar no-navbar">
    <div class="page-content">
    
     <div class="navbarpages">
       <div class="nav_left_logo"><a href="index.php"><img src="images/logo.png" alt="" title="" /></a></div>
       <div class="nav_right_button"><a href="menu.html"><img src="images/icons/white/menu.png" alt="" title="" /></a></div>
     </div>
     <div id="pages_maincontent">
      
      <div class="page_title_photos">
               <h2>Quotes</h2>
               <div class="gallery_switch">        
                <a href="#" id="view13" class="switcher active"><img src="images/switch_13_active.png" alt="Grid"></a>
                <a href="#" id="view12" class="switcher"><img src="images/switch_12.png" alt="Grid"></a>
                <a href="#" id="view11" class="switcher"><img src="images/switch_11.png" alt="List"></a>
              </div>
      </div>
      

              
              <div class="tabs-animated-wrap photos_tabs">
                    <div class="tabs">
                          <div id="tab1p" class="tab active">
                             <ul id="photoslist" class="photo_gallery_13"><?php do { ?>
                                <li><a rel="gallery-3" href="<?php echo $row_quotes['img']; ?>" title="Photo title" class="swipebox"><img src="<?php echo $row_quotes['img']; ?>" alt="image"/></a></li>
                                <?php } while ($row_quotes = mysql_fetch_assoc($quotes)); ?>
                               <div class="clearleft"></div>
                              </ul>   
                          </div>
    
 
                          
                    </div>
              </div> 
      
      

                
                
     <div class="clearleft"></div> 
      </div>
      
      
    </div>
  </div>
</div>

  </body>
</html>
<?php

mysql_free_result($quotes);


?>