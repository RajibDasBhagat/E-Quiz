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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO users (username, email, contact_no, password) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['contactno'], "int"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_User_Information, $User_Information);
  $Result1 = mysql_query($insertSQL, $User_Information) or die(mysql_error());

  $insertGoTo = "success.html";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_User_Information, $User_Information);
$query_User_Request = "SELECT * FROM users";
$User_Request = mysql_query($query_User_Request, $User_Information) or die(mysql_error());
$row_User_Request = mysql_fetch_assoc($User_Request);
$totalRows_User_Request = mysql_num_rows($User_Request);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="register.css" />
</head>

<body>

<div class="container">
  <div class="header">
    <div align="right"><a href="main.php"><img src="pics/logo.png" alt="Insert Logo Here" name="Insert_logo" width="180" height="90" id="Insert_logo" style="background-color: #C6D580; display:block;" align="left" /></a><a href="#" target="_parent"><!-- #BeginDate format:acEn1 -->Mon, 10-nov-14<!-- #EndDate -->
    </a></div> 
    
    <!-- end .header --></div>
  <div class="content">
    <h3 align="center">&nbsp;</h3>
    <h3 align="center">&nbsp;</h3>
    <h3 align="center"><u>Registration</u></h3>
    <form name="form" action="<?php echo $editFormAction; ?>" method="POST" >
      <p align="center">&nbsp;</p>
      <p align="center">Name    <input type="text" name="name" id="name" required></p>
      <p align="center">Contact no. <input type="text" name="contactno" id="contactno" required> </p>
      <p align="center">Email <input type="text" name="email" id="email" required> </p>
      <p align="center">Password <input type="password" name="password" id="password" required> </p>
      <p align="center">Re-password <input type="password" name="password" id="password" required> </p>
      <p align="center">
         <input type="reset" name="reset" id="reset" value=" Reset">
         <input type="submit" name="submit" id="submit" value="Register">
         
       </p>
      <input type="hidden" name="MM_insert" value="form">
      
      
    </form>
    <p align="center">&nbsp;</p>
    <p align="left">      <tt>*<u>please provide all the details</u></tt><u></u> </p>
<!-- end .content --></div>
  <div class="footer">
    <p align="left"><tt><a href="about.html">About</a> <a href="help.html">Help</a> <a href="contactus.php">Contact</a></tt></p>
    <p align="center"><tt>Copyright@2014 <u>info@cse.com</u></tt></p>
  </div>
  <!-- end .container --></div>
</body>
</html>
<?php
mysql_free_result($User_Request);
?>
