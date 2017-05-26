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

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_connection, $connection);
$query_Recordset1 = "SELECT * FROM videos ORDER BY id DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $connection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

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

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_prod = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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
         
<h2 class="page_title"><a href="#" data-panel="right" class="open-panel">Browse by Category</a></h2>
              <ul class="posts">
               <li>
                  <div class="post_entry">
                        <div class="post_title">
                        <div class="row">
                        	<h2><a href="live.php"  style="color:red">Live Events</a></h2>
                        </div>
                       </div>
                    </div> 
                </li>
              <?php do { ?>
                <li>
                    <div class="post_entry">
                        <div class="post_title">
                        <h2><a href="video-single.php?recordID=<?php echo $row_Recordset1['id']; ?>" style="color:#ffffff"><?php echo $row_Recordset1['header']; ?></a></h2>
                        </div>
                    </div>
                </li>
                <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              </ul>
              
            <div class="clear"></div>  
            <div id="loadMore"><img src="images/load_posts.png" alt="" title="" /></div> 
            <div id="showLess"><img src="images/load_posts_disabled.png" alt="" title="" /></div> 
            </div>
      
      <table border="1" align="center">
        <tr>
          <td>id</td>
          <td>header</td>
          <td>video</td>
          <td>category</td>
          
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="video-single.php?recordID=<?php echo $row_Recordset1['id']; ?>"> <?php echo $row_Recordset1['id']; ?>&nbsp; </a></td>
            <td><?php echo $row_Recordset1['header']; ?>&nbsp; </td>
            <td><?php echo $row_Recordset1['video']; ?>&nbsp; </td>
            <td><?php echo $row_Recordset1['category']; ?>&nbsp; </td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </table>
      <!-- InstanceEndEditable -->
              </div>
              </div>
      	 </div>
  		</div>
  </body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Recordset1);
?>
