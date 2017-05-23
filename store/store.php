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

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_connection, $connection);
$query_Recordset1 = "SELECT * FROM products ORDER BY id DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $connection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['category'])) {
  $colname_Recordset1 = $_GET['category'];
}
mysql_select_db($database_connection, $connection);
$query_Recordset1 = sprintf("SELECT * FROM products WHERE category = %s ORDER BY id DESC", GetSQLValueString($colname_Recordset1, "text"));
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
                <?php do { ?>
                <li>
                    <div class="post_entry">
                        <h2><a href="store-single.php?recordID=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['title']; ?></a></h2>
                      </div>
                </li>
                  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              </ul>
            </div>
      	</div>
		 <!-- InstanceEndEditable -->
              
      	 </div>
  		</div>
  </body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Recordset1);
?>
