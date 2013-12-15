<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $data['title']; ?></title>
<?php echo $data['head']; ?>
<link rel="Shortcut Icon" href="<?php echo $data['baseurl']; ?>global/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo $data['baseurl']; ?>global/css/style.css" media="screen" />
<script src="<?php echo $data['baseurl']; ?>global/js/Q.js"></script>
</head><body>
<?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//top.php"; ?>
<div class="wrap"> 
  <div class="content">
    <div class="left mbox f">
      <div class="reg-container">
        <form class="reg-from" action="<?php echo $data['baseurl']; ?>user/reg" method="post">
          <fieldset>
            <div>
              <label for="Email">邮件地址:</label>
              <input id="Email" type="email" name="email" placeholder="Email Address">
              <span id="EmailTip" class=""></span> </div>
            <div>
              <label for="Password">密码:</label>
              <input id="Password" type="password" name="password" placeholder="Password">
              <span id="PasswordTip" class=""></span> </div>
            <div class="controls-bar">
              <button type="submit" class="submit-button green-btn">注册</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
    <div class="right"></div>
    <div class="clear"></div>
  </div>
</div>
<?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
<script language="javascript" type="text/javascript">
var G = {
	checkUrl : "/index.php/user/check"
};
</script> 
<script src="<?php echo $data['baseurl']; ?>global/js/user.js"></script>
</body>
</html>