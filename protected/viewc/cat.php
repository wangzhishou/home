<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?php echo $data['title']; ?></title>
<?php echo $data['head']; ?>
<link rel="shortcut icon" href="<?php echo $data['baseurl']; ?>global/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo $data['baseurl']; ?>global/css/style.css" media="screen" />
<script src="<?php echo $data['baseurl']; ?>global/js/Q.js"></script>
</head><body>
<div class="wrap"> 
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//top.php"; ?>
  <div class="content">
    <div class="section1"> 
      <?php if( isset($data['posts'])==true ): ?>
      <?php $i=1; ?>
      <?php foreach($data['posts'] as $k1=>$v1): ?>
      <?php if($i > 1 && $i % 3 == 0) { ?>
      <div class="grid1 last">
      <?php } else { ?>
      <div class="grid1">
      <?php } ?>
        <article class="block offset"> <a href="<?php echo url('BlogController', 'getArticle', 'postId=>'.$v1->id); ?>" class="img"><img src="<?php echo $v1->thumbnails; ?>" onerror="this.src='/global/img/transparent.png'"> </a>
          <div class="intro">
          <h3> <a href="<?php echo url('BlogController', 'getArticle', 'postId=>'.$v1->id); ?>"><?php echo $v1->title; ?> </a> <span class="price"><?php echo $v1->price; ?>元</span></h3>
          <div class="tagList">
          <?php foreach($v1->Tag as $k2=>$v2): ?> 
          <a href="<?php echo $data['baseurl']; ?>tag/<?php echo $v2->name; ?>"><?php echo $v2->name; ?></a>
          <?php endforeach; ?>
          </div>
          </div>
        </article>
      </div>
      <?php $i++; ?>
      <?php endforeach; ?>
      
      
      <div class="clear">&nbsp;</div>
      <div><?php echo $data['pager']; ?></div> 
      <?php endif; ?> 
      
    </div>
  </div>
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
</div>
</body>
</html>
