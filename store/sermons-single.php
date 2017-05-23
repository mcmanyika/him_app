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

$colname_sermon = "-1";
if (isset($_GET['id'])) {
  $colname_sermon = $_GET['id'];
}
mysql_select_db($database_connection, $connection);
$query_sermon = sprintf("SELECT * FROM products WHERE id = %s", GetSQLValueString($colname_sermon, "int"));
$sermon = mysql_query($query_sermon, $connection) or die(mysql_error());
$row_sermon = mysql_fetch_assoc($sermon);
$totalRows_sermon = mysql_num_rows($sermon);

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
$query_DetailRS1 = sprintf("SELECT * FROM products WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
<title>Heartfelt International Ministries</title>
<link rel="stylesheet" href="../css/framework7.css">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/colors/blue.css">
<link type="text/css" rel="stylesheet" href="../css/swipebox.css" />
<link type="text/css" rel="stylesheet" href="../css/animations.css" />
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
</head>
<body id="mobile_wrap">

    <div class="pages">
      <div data-page="projects" class="page no-toolbar no-navbar homepage">
        <div class="page-content">
        
         <div class="navbarpages">
           <div class="nav_left_logo"><a href="../index.html"><img src="../images/logo.png" alt="" title="" /></a></div>
             <div class="nav_right_button">
               <a href="../menu.html"><img src="../images/icons/white/menu.png" alt="" title="" /></a>
               <a href="#" data-panel="right" class="open-panel"><img src="../images/icons/white/search.png" alt="" title="" /></a>
               <a href="../events.html"><img src="../images/icons/white/back.png" alt="" title="" /></a>
             </div>
            </div>
         <div id="pages_maincontent">
     <div id="pages_maincontent">
       <div class="page_content">
            <div class="blog-posts"style="background-color: #000000; opacity: 0.6; color:#ffffff;">
              <ul class="posts">
                <li>
                    <div class="post_entry">
                      
                        <h1 style="font-size:18px; text-align:left !important"><?php echo $row_DetailRS1['title']; ?></h1>
                        
                      <div style="float:left; width:50%">
                      		<?php echo $row_DetailRS1['description']; ?>
                      </div>
                      <div style="float:left; width:40%; padding-left:20px">
                      		<audio controls>
                          <source src="<?php echo $row_DetailRS1['link']; ?>" type="audio/mpeg">
                          Your browser does not support the audio element. </audio>
                      </div>
                    </div>
                </li>
              </ul>
            </div>
      	</div>
     </div>
		 </div>
  		</div>
        
            <!-- Bottom Toolbar-->
        <div class="toolbar">
              <div class="toolbar-inner">
              <ul class="toolbar_icons">
              <li><a href="../#" data-panel="left" class="open-panel"><img src="../images/icons/white/user.png" alt="" title="" /></a></li>
              <li><a href="../quotes.html"><img src="../images/icons/white/photos.png" alt="" title="" /></a></li>
              <li class="menuicon"><a href="../menu.html"><img src="../images/icons/white/menu.png" alt="" title="" /></a></li>
              <li><a href="../events.php"><img src="../images/icons/white/blog.png" alt="" title="" /></a></li>
              <li><a href="../contact.html"><img src="../images/icons/white/contact.png" alt="" title="" /></a></li>
              </ul>
              </div>  
        </div>
      </div>
    </div>
    
    <!-- Login Popup -->
    <div class="popup popup-login">
    <div class="content-block-login">
      <h4>LOGIN</h4>
      <div class="form_logo"><img src="images/logo.png" alt="" title="" /></div>
            <div class="loginform">
            <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="LoginForm">
            <input type="text" name="email" value="" class="form_input required" placeholder="username" />
            <input type="password" name="password" value="" class="form_input required" placeholder="password" />
            <div class="forgot_pass"><a href="#" data-popup=".popup-forgot" class="open-popup">Forgot Password?</a></div>
            <input type="submit" name="submit" class="form_submit" id="submit" value="SIGN IN" />
            </form>
            <div class="signup_bottom">
            <p>Don't have an account?</p>
            <a href="#" data-popup=".popup-signup" class="open-popup">SIGN UP</a>            </div>
            </div>
      <div class="close_loginpopup_button"><a href="#" class="close-popup"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>
    </div>
    </div>
    
    <!-- Register Popup -->
    <div class="popup popup-signup">
    <div class="content-block-login">
      <h4>REGISTER</h4>
      <div class="form_logo"><img src="images/logo.png" alt="" title="" /></div>
            <div class="loginform">
            <form id="RegisterForm" method="post">
            <input type="text" name="Username" value="" class="form_input required" placeholder="username" />
            <input type="text" name="Email" value="" class="form_input required" placeholder="email" />
            <input type="password" name="Password" value="" class="form_input required" placeholder="password" />
            <input type="submit" name="submit" class="form_submit" id="submit" value="SIGN UP" />
            </form>
            <div class="signup_social">
            <a href="http://www.facebook.com/" class="signup_facebook external">FACEBOOK</a>
            <a href="http://www.twitter.com/" class="signup_twitter external">TWITTER</a>            
            </div>
            </div>
      <div class="close_loginpopup_button"><a href="#" class="close-popup"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>
    </div>
    </div>
    
    <!-- Login Popup -->
    <div class="popup popup-forgot">
    <div class="content-block-login">
      <h4>FORGOT PASSWORD</h4>
      <div class="form_logo"><img src="images/logo.png" alt="" title="" /></div>
            <div class="loginform">
            <form id="ForgotForm" method="post">
            <input type="text" name="Email" value="" class="form_input required" placeholder="email" />
            <input type="submit" name="submit" class="form_submit" id="submit" value="RESEND PASSWORD" />
            </form>
            <div class="signup_bottom">
            <p>Check your email and follow the instructions to reset your password.</p>
            </div>
            </div>
      <div class="close_loginpopup_button"><a href="#" class="close-popup"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>
    </div>
    </div>
    
    
    <!-- Social Popup -->
    <div class="popup popup-social">
    <div class="content-block">
      <h4>Follow Us</h4>
      <p>Help share the love of God through the following social media platforms</p>
      <ul class="social_share">
      <li><a href="http://twitter.com/" class="external"><img src="images/icons/white/twitter.png" alt="" title="" /></a></li>
      <li><a href="http://www.facebook.com/ApostleTavongaVutabwashe" class="external"><img src="images/icons/white/facebook.png" alt="" title="" /></a></li>
      <li><a href="http://www.youtube.com" class="external"><img src="images/icons/white/googleplus.png" alt="" title="" /></a></li>
      
      </ul>
      <div class="close_popup_button"><a href="#" class="close-popup"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>
    </div>
    </div>

    <!-- Categories Popup -->
    <div class="popup popup-categories">
    <div class="content-block">
      <h4>Category</h4>
      <p>Search by categories.</p>
      <ul class="social_share">
      
      </ul>
      <div class="close_popup_button"><a href="#" class="close-popup"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>
    </div>
    </div>
  </body>
</html>
<?php

mysql_free_result($DetailRS1);
?>