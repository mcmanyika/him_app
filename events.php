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


$maxRows_event = 35;
$pageNum_event = 0;
if (isset($_GET['pageNum_event'])) {
  $pageNum_event = $_GET['pageNum_event'];
}
$startRow_event = $pageNum_event * $maxRows_event;

mysql_select_db($database_connection, $connection);
$query_event = "SELECT * FROM events ORDER BY id DESC";
$query_limit_event = sprintf("%s LIMIT %d, %d", $query_event, $startRow_event, $maxRows_event);
$event = mysql_query($query_limit_event, $connection) or die(mysql_error());
$row_event = mysql_fetch_assoc($event);

if (isset($_GET['totalRows_event'])) {
  $totalRows_event = $_GET['totalRows_event'];
} else {
  $all_event = mysql_query($query_event);
  $totalRows_event = mysql_num_rows($all_event);
}
$totalPages_event = ceil($totalRows_event/$maxRows_event)-1;



$queryString_event = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_event") == false && 
        stristr($param, "totalRows_event") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_event = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_event = sprintf("&totalRows_event=%d%s", $totalRows_event, $queryString_event);
?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/base2.dwt" codeOutsideHTMLIsLocked="false" -->
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
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
<!-- InstanceBeginEditable name="head" -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="apple-touch-startup-image-640x1096.png">

<link rel="stylesheet" href="css/framework7.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/colors/blue.css">
<link type="text/css" rel="stylesheet" href="css/swipebox.css" />
<link type="text/css" rel="stylesheet" href="css/animations.css" />
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
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
<h2 class="page_title">Upcoming Events</h2>
              <ul class="posts">
              <?php do { ?>
                <li>
                    <div class="post_entry">
                        <div class="post_date">
                            <span class="day"><?php echo $row_event['day']; ?></span>
                            <span class="month"><?php echo $row_event['month']; ?></span>
                        </div>
                        <div class="post_title">
                        <h2><?php echo $row_event['title']; ?></h2>
                        </div>
                    </div>
                </li>
                <?php } while ($row_event = mysql_fetch_assoc($event)); ?>
              </ul>
              
            <div class="clear"></div>  
            <div id="loadMore"><img src="images/load_posts.png" alt="" title="" /></div> 
            <div id="showLess"><img src="images/load_posts_disabled.png" alt="" title="" /></div> 
            </div>
      
      </div>
         <!-- InstanceEndEditable -->
              
      	 </div>
  		</div>
  </body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($event);


mysql_free_result($events);


?>