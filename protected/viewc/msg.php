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
<div class="wrap">
<?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//top.php"; ?>
<div class="content mbox f"> 
  <?php if( isset($data['status']) ): ?>
  <div class="message message-<?php echo $data['status']; ?>"> 
    <?php else: ?>
    <div class="message message-success"> 
      <?php endif; ?> 
      <span class="close"></span> 
      <?php if( isset($data['title']) ): ?>
      <header><?php echo $data['title']; ?></header>
      <?php endif; ?> 
      <?php echo $data['content']; ?> </div>
  </div>
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
</div>
</body>
</html>