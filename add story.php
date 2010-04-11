<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>Add story</p>
<form id="form1" name="form1" method="post" action="">
  <p>Category:
    <label>
      <select name="category" id="category">
        <option value="General">General</option>
      </select>
    </label>
  </p>
  <p>Title: <span id="sprytextfield1">
  <label>
    <input type="text" name="title" id="title" />
  </label>
  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></p>
  <p>Body: </p>
  <p><span id="sprytextarea1">
  <label>
    <textarea name="body" id="body" cols="45" rows="5"></textarea>
    <span id="countsprytextarea1">&nbsp;</span></label>
  <span class="textareaRequiredMsg">A value is required.</span><span class="textareaMinCharsMsg">Minimum number of characters not met.</span></span></p>
  <p>&nbsp;</p>
  <p>
    <label>
      <input type="submit" name="Submit" id="Submit" value="Submit" />
    </label>
  </p>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"], minChars:2, maxChars:255});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"], counterType:"chars_count", counterId:"countsprytextarea1", minChars:20});
//-->
</script>
</body>
</html>