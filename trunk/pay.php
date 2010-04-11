<?php require_once('Connections/conn.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO `transaction` (`number`, body, `date`, dr) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['number'], "int"),
                       GetSQLValueString($_POST['body'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['dr'], "double"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsCard = "-1";
if (isset($_GET['cid'])) {
  $colname_rsCard = $_GET['cid'];
}
mysql_select_db($database_conn, $conn);
$query_rsCard = sprintf("SELECT * FROM card WHERE cid = %s", GetSQLValueString($colname_rsCard, "int"));
$rsCard = mysql_query($query_rsCard, $conn) or die(mysql_error());
$row_rsCard = mysql_fetch_assoc($rsCard);
$totalRows_rsCard = mysql_num_rows($rsCard);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>Pay</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>Card: <?php echo $row_rsCard['number']; ?></p>
  <p>Amount: <span id="sprytextfield1">
  <label>
    <input type="text" name="dr" id="dr" />
  </label>
  <span class="textfieldRequiredMsg">A value is required.</span></span></p>
  <p>
    <input type="submit" name="button" id="button" value="Submit" />
    <input name="number" type="hidden" id="number" value="<?php echo $row_rsCard['number']; ?>" />
    <input name="date" type="hidden" id="date" value="<?php echo date('Y-m-d'); ?>" />
    <input name="body" type="hidden" id="body" value="Paid By Bank" />
  </p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"], hint:"Enter Amount To Pay"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rsCard);
?>
