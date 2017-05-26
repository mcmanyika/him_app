<?php require_once('Connections/connection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm")) {
  $insertSQL = sprintf("INSERT INTO users (id, username, password, email, subscribe) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['subscribe'], "text"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());

  $insertGoTo = "#!/registration_confirmation.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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


$maxRows_raw = 12;
$pageNum_raw = 0;
if (isset($_GET['pageNum_raw'])) {
  $pageNum_raw = $_GET['pageNum_raw'];
}
$startRow_raw = $pageNum_raw * $maxRows_raw;

mysql_select_db($database_connection, $connection);
$query_raw = "SELECT * FROM category ORDER BY id ASC";
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
<!-- Latest compiled and minified CSS -->
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

</style>
</head>
<body id="mobile_wrap">

    <div class="statusbar-overlay"></div>

    <div class="panel-overlay"></div>

    <div class="panel panel-left panel-cover" style="background-color:rgb(0,102,153);">
          <div class="user_login_info">
                  <nav class="user-nav">
                    <ul><?php if (isset($_SESSION['MM_Username']))  
                                      { 
									  echo '<li><img src="images/icons/white/home.png" /><span><a href="account.php" class="close-panel">My Account</a></span></li>';
									  }
									  else {
                      						echo '<li><img src="images/icons/white/user.png" /><span>Welcome Guest</span></li>';
                                      } 
                         ?>
                      <li><a href="#" data-popup=".popup-categories" class="open-popup"><img src="images/icons/white/form.png" alt="" title="" /><span>Store</span></a></li>
                      <li><a href="itenerary.php" class="close-panel"><img src="images/icons/white/briefcase.png" alt="" title="" /><span>Itenerary</span></a></li>
                      <li><a href="partnership.php" class="external"><img src="images/icons/white/team.png" alt="" title="" /><span>Partnership</span></a></li>
                      <li><a href="locations.php" class="close-panel"><img src="images/icons/white/slider.png" alt="" title="" /><span>Branches</span></a></li>
                      <li><a href="events.php" class="close-panel"><img src="images/icons/white/blog.png" alt="" title="" /><span>Events</span></a></li>
                      <li><img src="images/icons/white/lock.png" alt="" title="" />
                        <span><?php if (isset($_SESSION['MM_Username']))  
                                      {
                                          echo '<a href="' . $logoutAction . '" class="external">Sign out</a>';
                                      } 
                                      else {
                                          echo '<a href="#" data-popup=".popup-login" class="open-popup">Sign in</a>';}?>
                        </span>
                      </li>
                      
                    </ul>
                  </nav>
          </div>
    </div>
    

    
    <div class="panel panel-right panel-cover" style="background-color:rgb(0,102,153)"> 
      <div class="user_login_info">
         <nav class="user-nav">
            <h3>BROWSE BY CATEGORY</h3>
            <ul>
            <?php if (isset($_SESSION['MM_Username'], $_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 'Premium') 
						  {
							  echo '<li><a href="premium_store_cat.php?category=couples" class="close-panel"><span>Couples</span></a></li>
              <li><a href="premium_store_cat.php?category=pioneers" class="close-panel"><span>Pioneers</span></a></li>
              <li><a href="premium_store_cat.php?category=ladies" class="close-panel"><span>Ladies Meeting</span></a></li>
              <li><a href="premium_store_cat.php?category=sunday" class="close-panel"><span>Sunday Service</span></a></li>
              <li><a href="premium_store_cat.php?category=mentorship" class="close-panel"><span>Mentorship</span></a></li>
              <li><a href="premium_store_cat.php?category=leaders" class="close-panel"><span>Leaders seminar</span></a></li>';
						  } 
						  else {
							  echo '<li><a href="free_store_cat.php?category=couples" class="close-panel"><span>Couples</span></a></li>
              <li><a href="free_store_cat.php?category=pioneers" class="close-panel"><span>Pioneers</span></a></li>
              <li><a href="free_store_cat.php?category=ladies" class="close-panel"><span>Ladies Meeting</span></a></li>
              <li><a href="free_store_cat.php?category=sunday" class="close-panel"><span>Sunday Service</span></a></li>
              <li><a href="free_store_cat.php?category=mentorship" class="close-panel"><span>Mentorship</span></a></li>
              <li><a href="free_store_cat.php?category=leaders" class="close-panel"><span>Leaders seminar</span></a></li>';
							  }
					     ?>
                         
                         </ul>
        </nav>
       </div>
    </div>

    <div class="views">
      <div class="view view-main">
        <div class="pages  toolbar-through">
          <div data-page="index" class="page" style="background:url(images/colors/blue/app_bk.jpg) no-repeat center; background-size: cover;">
             <div class="row">
                  <div class="col-xs-offset-6" style="padding-top:10px; background-color: #000000; opacity: 0.6;  color:#ffffff; height:1200px">
                       <div class="col-md-12" style="">
                       <img src="images/colors/blue/app_details.png" class="img-responsive">
                       </div>
                       <div class="col-md-12" style="padding-top:60px; color:#ffffff;"><center>
                       <div class="col-sm-10">
                       <?php if (isset($_SESSION['MM_Username'], $_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 'Premium') 
						  {
							  echo '<a href="premium_store.php"><img src="images/premium.png" class="img-responsive"></a>';
						  } 
						  else {
							  echo '<a href="free_store.php"><img src="images/limited.png" class="img-responsive"></a> <br />
							  <a href="packages.php">Register here to access unlimited materials</a>';
							  }
					     ?>
                       		</div>
                         </center>   
                       </div>
                  </div>
                  
             </div>
        	</div>
        </div>
        
        <!-- Bottom Toolbar-->
        <div class="toolbar">
              <div class="toolbar-inner">
              <ul class="toolbar_icons">
              <li><a href="#" data-panel="left" class="open-panel"><img src="images/icons/white/user.png" alt="" title="" /></a></li>
              <li><a href="photos.php"><img src="images/icons/white/photos.png" alt="" title="" /></a></li>
              <li class="menuicon"><a href="menu.html"><img src="images/icons/white/menu.png" alt="" title="" /></a></li>
              <li><a href="events.php" class="external"><img src="images/icons/white/blog.png" alt="" title="" /></a></li>
              <li><a href="contact.html"><img src="images/icons/white/contact.png" alt="" title="" /></a></li>
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
            <input type="text" name="email" value="" class="form_input required" placeholder="Email" />
            <input type="password" name="password" value="" class="form_input required" placeholder="Password" />
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
            <form action="<?php echo $editFormAction; ?>" id="RegisterForm" name="RegisterForm" method="POST">
            <input type="text" name="Username" value="" class="form_input required" placeholder="username" />
            <input type="text" name="Email" value="" class="form_input required" placeholder="email" />
            <input type="password" name="Password" value="" class="form_input required" placeholder="password" />
            <input type="submit" name="submit" class="form_submit" id="submit" value="SIGN UP" />
            <input type="hidden" name="MM_insert" value="RegisterForm">
            <input type="hidden" name="subscribe" value="Ordinary"/>
            </form>
            <p>&nbsp;</p>
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
      <?php do { ?>
      <li><div style="border-width: 1px; border-color: #fff; border-style: solid "><a href="<?php echo $row_raw['link']; ?>"  class="close-popup" style="color: #fff"><?php echo $row_raw['name']; ?></a></div></li>
      <?php } while ($row_raw = mysql_fetch_assoc($raw)); ?>
      </ul>
      <div class="close_popup_button"><a href="#" class="close-popup"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>
    </div>
    </div>
    
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/framework7.js"></script><?php echo $row_raw['']; ?>
<script type="text/javascript" src="js/my-app.js"></script>
<script type="text/javascript" src="js/jquery.swipebox.js"></script>
<script type="text/javascript" src="js/email.js"></script>
  </body>
</html>
<?php
mysql_free_result($raw);

mysql_free_result($user);
?>