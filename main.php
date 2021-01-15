<?php require_once('Connections/User_Information.php'); ?>
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

mysql_select_db($database_User_Information, $User_Information);
$query_User_Login = "SELECT email, password FROM users";
$User_Login = mysql_query($query_User_Login, $User_Information) or die(mysql_error());
$row_User_Login = mysql_fetch_assoc($User_Login);
$totalRows_User_Login = mysql_num_rows($User_Login);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "successful.php";
  $MM_redirectLoginFailed = "Access_denied.html";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_User_Information, $User_Information);
  
  $LoginRS__query=sprintf("SELECT email, password FROM users WHERE email=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $User_Information) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
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
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Main</title>
<link rel="stylesheet" href="main.css" />
</head>

<body>
<div class="container">
  <div class="header">
    <p align="right"><a href="main.php"><img src="pics/logo.png" alt="Insert Logo Here" 
	name="Insert_logo" width="180" height="90" id="Insert_logo" style="background-color: #C6D580; display:block;" align="left" /></a>
      <marquee>
      Welcome to the new generation of learning... :) :)
      </marquee>
    </p>
  </div>
  <div class="sidebar1">
    <p>Already have a account login?? </p>
    <form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="login">
    <p>Username<input name="username" type="text" autofocus id="username" required> </p>
    <p>Password <input type="password" name="password" id="password" required> </p>
    <div align="center">
      <input name="submit" type="submit" value="Submit">
    </div>
    </form>
      
    <hr>
    <p>Not Register yet!!</p>
    <p>Register yourself</p>
    <form name="form3" method="post" action="">
      <div align="center"><a href="register.php">Register</a></div>
    </form>
    <p>&nbsp;</p>
    <p align="center"><!-- #BeginDate format:acEn1 -->Mon, 10-nov-14<!-- #EndDate --> 
    </p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
  </div>
  <div class="content">
    <h1><tt>Introduction</tt></h1>
    <p>&nbsp;</p>
    <h4><tt><u><strong>e-Books</strong></u> </tt></h4>
    <p><tt><strong><u>Video</u></strong></tt></p>
    <p><tt><strong><u>Test yourself</u></strong></tt></p>
    <p><tt><u><strong>Puzzle</strong></u></tt><u><strong></strong></u></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <!-- end .content --></div>
  <div class="footer">
    <div class="footer">
      <p align="left"><tt><a href="about.html">About</a> <a href="help.html">Help</a> <a href="contactus.php">Contact</a></tt></p>
      <p align="center"><tt>Copyright@2014 <u>info@cse.com</u></tt></p>
      <!-- end .footer --></div>
  </div>
  <!-- end .container --></div>
</body>
</html>
<?php
mysql_free_result($User_Login);
?>
