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
  <div class="content">
    <div class="box left"> 
      <?php foreach($data['posts'] as $k1=>$v1): ?>
      <h2><?php echo $v1->title; ?></h2>
      <div class="articles"> <?php echo shorten($v1->content); ?>
        <div class="tagContainer"> <strong>Tags: </strong> 
          <?php foreach($v1->Tag as $k2=>$v2): ?> 
          <span class="tag"><a href="<?php echo $data['baseurl']; ?>tag/<?php echo $v2->name; ?>"><?php echo $v2->name; ?></a></span> 
          <?php endforeach; ?> 
        </div>
        <em class="datePosted">&nbsp;<a href="<?php echo url('BlogController', 'getArticle', 'postId=>'.$v1->id); ?>#comments" style="text-decoration:none;">Comments (<?php echo $v1->totalcomment; ?>)</a> | Posted on <?php echo formatDate($v1->createtime); ?></em> </div>
      <hr class="divider"/>
      <?php endforeach; ?>
      <div><?php echo $data['pager']; ?></div>
      <div class="clear">&nbsp;</div>
    </div>
    <div class="right">
      <div class="box"> <a href="<?php echo $data['baseurl']; ?>post/create">我要投稿</a>
        <h2>Tags :</h2>
        <?php if (!Q::cache('front')->getPart('randomTag', 300)): ?>
<?php Q::cache('front')->start('randomTag'); ?> 
        <?php foreach($data['randomTags'] as $k1=>$v1): ?> 
        <span class="tag"><a href="<?php echo $data['baseurl']; ?>tag/<?php echo $v1->name; ?>"><?php echo $v1->name; ?></a></span> 
        <?php endforeach; ?> 
        
<?php Q::cache('front')->end(); ?>
<?php endif; ?> 
      </div>
    </div>
    <div class="clear">&nbsp;</div>
  </div>
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
</div>
</body>
</html>
