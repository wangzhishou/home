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
<script src="<?php echo $data['baseurl']; ?>global/js/ui.js"></script>
</head><body>
<?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//top.php"; ?>
<div class="wrap">
<div class="banner"> <a href="<?php echo $data['baseurl']; ?>"><img src="<?php echo $data['baseurl']; ?>global/img/banner.png"></a> </div>
<div class="content">
  <div class="left"> 
    <?php if( isset($data['posts'])==true ): ?>
    <div class="grid-box">
    <ul class="grid">
    <?php foreach($data['posts'] as $k1=>$v1): ?>
      <li> <a href="<?php echo $data['baseurl']; ?>a/<?php echo $v1->id; ?>.html" class="img"><img src="<?php echo $v1->thumbnails; ?>" onerror="this.src='/global/img/transparent.png'"> </a>
        <h2><a href="<?php echo $data['baseurl']; ?>a/<?php echo $v1->id; ?>.html"><?php echo $v1->title; ?> </a> </h2> 
        <div class="grid-bar">
        <span class="like" pid="<?php echo $v1->id; ?>">喜欢(<?php echo $v1->totaldigg; ?>)</span> 
        <span class="fav" pid="<?php echo $v1->id; ?>">收藏(<?php echo $v1->totalfav; ?>)</span>
        <div class="price">￥<span><?php echo $v1->price; ?></span></div>
        </div>
      </li>
    <?php endforeach; ?>
    <div class="clear"></div>
    </ul> 
    <div class="clear"></div>
    </div>
    <div class="pager"><?php echo $data['pager']; ?></div>
    <?php endif; ?> 
  </div>
  <div class="right"> 
  	<div class="box">
    	<div class="btn-bar">
    <a href="<?php echo url('AdminController', 'createLink'); ?>" class="btn-post-link"><i class="icon-comment"></i>我要爆料</a><a href="<?php echo url('AdminController', 'createPost'); ?>" class="btn-post-edit"><i class="icon-pencil"></i>我要投稿</a>
    		<div class="clear"></div>
    	</div>
    </div>
    <div class="box">
    <h4>标签 :</h4>
    <div class="tag-box"> 
      <?php if (!Q::cache('front')->getPart('randomTag', 300)): ?>
<?php Q::cache('front')->start('randomTag'); ?> 
      <?php foreach($data['randomTags'] as $k1=>$v1): ?> 
      <a href="<?php echo $data['baseurl']; ?>tag/<?php echo $v1->name; ?>"><?php echo $v1->name; ?></a> 
      <?php endforeach; ?> 
      
<?php Q::cache('front')->end(); ?>
<?php endif; ?> 
    </div>
    </div>
  </div>
  <div class="clear">&nbsp;</div>
</div>
</div>
<?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
<script language="javascript" type="text/javascript">
var V = {
	likeRequest : "<?php echo $data['baseurl']; ?>post/like",
	favRequest : "<?php echo $data['baseurl']; ?>post/fav",
	loginRequest : "<?php echo $data['baseurl']; ?>user/login"
};
</script> 
<script src="<?php echo $data['baseurl']; ?>global/js/h.js"></script>
</body>
</html>
