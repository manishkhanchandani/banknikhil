<?php require_once('Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	mysql_select_db($database_conn, $conn);
	$query_rsItems = "SELECT * FROM `items` WHERE id = '".$_POST['items']."'";
	$rsItems = mysql_query($query_rsItems, $conn) or die(mysql_error());
	$row_rsItems = mysql_fetch_array($rsItems);
	$_POST['body'] = $row_rsItems['item'];
	$_POST['cr'] = $row_rsItems['rate'];
	$_POST['date'] = date('Y-m-d');
}
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO `transaction` (`number`, body, `date`, cr) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['number'], "int"),
                       GetSQLValueString($_POST['body'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['cr'], "double"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "account.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['user_id'])) {
  $colname_Recordset1 = $_SESSION['user_id'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM `transaction`, card WHERE `transaction`.number = card.number AND card.user_id = %s ORDER BY id DESC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_rsCard = "-1";
if (isset($_SESSION['user_id'])) {
  $colname_rsCard = $_SESSION['user_id'];
}
mysql_select_db($database_conn, $conn);
$query_rsCard = sprintf("SELECT * FROM `card` WHERE user_id = %s", GetSQLValueString($colname_rsCard, "int"));
$rsCard = mysql_query($query_rsCard, $conn) or die(mysql_error());
$row_rsCard = mysql_fetch_assoc($rsCard);
$totalRows_rsCard = mysql_num_rows($rsCard);

mysql_select_db($database_conn, $conn);
$query_rsItems = "SELECT * FROM `items` ORDER BY item ASC";
$rsItems = mysql_query($query_rsItems, $conn) or die(mysql_error());
$row_rsItems = mysql_fetch_assoc($rsItems);
$totalRows_rsItems = mysql_num_rows($rsItems);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>Welcome <strong><?php echo $_SESSION['MM_Username']; ?></strong></p>
<p>Payment</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
Card:
  <select name="number" id="number">
    <?php
do {  
?>
    <option value="<?php echo $row_rsCard['number']?>"><?php echo $row_rsCard['number']?></option>
    <?php
} while ($row_rsCard = mysql_fetch_assoc($rsCard));
  $rows = mysql_num_rows($rsCard);
  if($rows > 0) {
      mysql_data_seek($rsCard, 0);
	  $row_rsCard = mysql_fetch_assoc($rsCard);
  }
?>
  </select> 
  Paid For: 
  <select name="items" id="items">
    <?php
do {  
?>
    <option value="<?php echo $row_rsItems['id']?>"><?php echo $row_rsItems['item']?> / <?php echo $row_rsItems['rate']; ?></option>
    <?php
} while ($row_rsItems = mysql_fetch_assoc($rsItems));
  $rows = mysql_num_rows($rsItems);
  if($rows > 0) {
      mysql_data_seek($rsItems, 0);
	  $row_rsItems = mysql_fetch_assoc($rsItems);
  }
?>
  </select> 
  <input type="submit" name="button" id="button" value="Pay Now" />
  <input type="hidden" name="body" id="body" />
  <input type="hidden" name="cr" id="cr" />
  <input type="hidden" name="date" id="date" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>Transaction</p>
<table border="1">
  <tr>
    <td>number</td>
    <td>body</td>
    <td>date</td>
    <td>dr</td>
    <td>cr</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_Recordset1['number']; ?></td>
    <td><?php echo $row_Recordset1['body']; ?></td>
    <td><?php echo $row_Recordset1['date']; ?></td>
    <td><?php if($row_Recordset1['dr']) echo '$ '.$row_Recordset1['dr']; $dr += $row_Recordset1['dr'];  ?></td>
    <td><?php if($row_Recordset1['cr']) echo '$ '.$row_Recordset1['cr']; $cr += $row_Recordset1['cr']; ?></td>
  </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Total: &nbsp;</td>
    <td colspan="2">$ <?php echo $dr - $cr; ?>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsCard);

mysql_free_result($rsItems);
?>
