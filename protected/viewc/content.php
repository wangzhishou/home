<!doctype html>
<html>
<head>
<title><?php echo $data['title']; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="keywords" content="<?php echo $data['keywords']; ?>" />
<meta name="description" content="<?php echo $data['description']; ?>" />
<?php echo $data['head']; ?>
<link rel="Shortcut Icon" href="<?php echo $data['baseurl']; ?>global/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo $data['baseurl']; ?>global/css/style.css" media="screen" />
<script src="<?php echo $data['baseurl']; ?>global/js/Q.js"></script>
</head><body>
<div class="wrap"> 
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//top.php"; ?>
  <div class="content">
    <div class="box left">
      <h2><?php echo $data['post']->title; ?></h2>
      <div class="articles"> <?php echo $data['post']->content; ?>
        <div class="tagContainer"> <strong>标签: </strong> 
          <?php foreach($data['post']->Tag as $k1=>$v1): ?> 
          <span class="tag"><a href="<?php echo $data['baseurl']; ?>tag/<?php echo $v1->name; ?>"><?php echo $v1->name; ?></a></span> 
          <?php endforeach; ?> 
        </div>
        <em class="datePosted">Posted on <?php echo formatDate2($data['post']->createtime); ?></em> </div>
      <hr class="divider" />
      <div id="comments" name="comments"> 
        <?php if( isset($data['comments']) ): ?> 
        <strong>Total Comments (<?php echo $data['post']->totalcomment; ?>)</strong><br/>
        <br/>
        <?php foreach($data['comments'] as $k1=>$v1): ?> 
        <span id="comment<?php echo $v1->id; ?>" name="comment<?php echo $v1->id; ?>" style="font-weight:bold;"> 
        <?php if( !empty($v1->User) ): ?> 
        <a href="<?php echo $data['baseurl']; ?>user/<?php echo $v1->user_id; ?>"><?php echo $v1->User->username; ?></a> 
        <?php endif; ?> 
        </span> said on <em><?php echo formatDate($v1->createtime, 'd M y h:i:s A'); ?></em>,<br/>
        <div class="commentItem"><?php echo $v1->content; ?></div>
        <br/>
        <?php endforeach; ?>
        <hr class="divider"/>
        <?php endif; ?> 
      </div>
      <div>
      <!-- Baidu Button BEGIN -->
      <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"> <a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="bds_t163"></a> <span class="bds_more">更多</span> </div>
      <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=20900" ></script> 
      <script type="text/javascript" id="bdshell_js"></script> 
      <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
        </script> 
      <!-- Baidu Button END -->
<!-- 将此标记放在您希望显示like按钮的位置 -->
<div class="bdlikebutton" style="float:right"></div>

<!-- 将此代码放在适当的位置，建议在body结束前 -->
<script id="bdlike_shell"></script>
<script>
var bdShare_config = {
	"type":"small",
	"color":"blue",
	"uid":"20900"
};
document.getElementById("bdlike_shell").src="http://bdimg.share.baidu.com/static/js/like_shell.js?t=" + Math.ceil(new Date()/3600000);
</script>
<div class="clear"></div>
</div>
      <?php if( $data['user']['group'] == "admin" ): ?>
      <div class="admin-bar"> <a href="<?php echo $data['baseurl']; ?>post/edit/<?php echo $data['post']->id; ?>" class="btn blue-btn"><i class="icon-pencil"></i>编辑文章</a> </div>
      <?php endif; ?> 
      <?php if( $data['user']['id'] > 0 ): ?>
      <div class="post-box">
        <p><strong>参与评论：</strong></p>
        <form method="POST" action="<?php echo url('BlogController', 'newComment'); ?>">
          <input type="hidden" name="post_id" value="<?php echo $data['post']->id; ?>"/>
          <input type="hidden" name="user_id" value="<?php echo $data['user']['id']; ?>"/>
          <div class="field">
            <textarea cols="45" rows="6" name="content" class="textarea"></textarea>
          </div>
          <div class="field">
            <input type="submit" class="btn btn-big" value="发表评论"/>
          </div>
        </form>
      </div>
      <?php endif; ?> 
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
      <div style="text-align:center">
      </div>
    </div>
    <div class="clear">&nbsp;</div>
  </div>
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
</div>
</body>
</html>
