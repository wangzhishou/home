<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>haotebie</title>
<?php echo $data['head']; ?>
<link rel="Shortcut Icon" href="<?php echo $data['baseurl']; ?>global/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo $data['baseurl']; ?>global/css/style.css" media="screen" />
<script src="<?php echo $data['baseurl']; ?>global/js/Q.js"></script>
</head><body>
<div class="wrap"> 
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//top.php"; ?>
  <div class="content">
    <div class="box left">
      <h2><a href="<?php echo $data['baseurl']; ?>article/<?php echo $data['post']->id; ?>"><?php echo $data['post']->title; ?></a></h2>
      <div class="articles"> <?php echo $data['post']->content; ?>
        <div class="tagContainer"> <strong>标签: </strong> 
          <?php foreach($data['post']->Tag as $k1=>$v1): ?> 
          <span class="tag"><a href="<?php echo $data['baseurl']; ?>tag/<?php echo $v1->name; ?>"><?php echo $v1->name; ?></a></span> 
          <?php endforeach; ?> 
        </div>
        <em class="datePosted">Posted on <?php echo formatDate($data['post']->createtime); ?></em> </div>
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
      <?php if( isset($data['user']) ): ?> 
      <?php if( $data['user']['group'] == "admin" ): ?> 
      <div class="admin-bar">
      <a href="<?php echo $data['baseurl']; ?>post/edit/<?php echo $data['post']->id; ?>" class="btn blue-btn"><i class="icon-pencil"></i>编辑文章</a>
      </div> 
      <?php endif; ?>      
      <?php endif; ?> 
      <?php if( isset($data['user']) ): ?> 
      <div class="post-box">
        <p><strong>参与评论：</strong></p>
        <form method="POST" action="<?php echo url2('BlogController', 'newComment'); ?>">
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
        <iframe allowtransparency="true" frameborder="0" height="250" hspace="0" id="google_ads_frame2" marginheight="0" marginwidth="0" name="google_ads_frame2" scrolling="no" src="http://googleads.g.doubleclick.net/pagead/ads?client=ca-pub-8328040831814117&amp;output=html&amp;h=250&amp;slotname=2843773429&amp;adk=2215773636&amp;w=250&amp;lmt=1382113387&amp;flash=11.8.800&amp;url=http%3A%2F%2Fwww.smzdm.com%2Fyouhui%2F328367%2F5%23comments&amp;dt=1382142187008&amp;bpp=3&amp;bdt=231&amp;shv=r20131015&amp;cbv=r20130906&amp;saldr=sa&amp;prev_slotnames=5541414173&amp;correlator=1382142187132&amp;frm=20&amp;ga_vid=1208351133.1379146440&amp;ga_sid=1382140851&amp;ga_hid=589907683&amp;ga_fc=1&amp;u_tz=480&amp;u_his=4&amp;u_java=1&amp;u_h=1080&amp;u_w=1920&amp;u_ah=1040&amp;u_aw=1920&amp;u_cd=32&amp;u_nplug=36&amp;u_nmime=88&amp;dff=arial&amp;dfs=12&amp;adx=1186&amp;ady=1141&amp;biw=1903&amp;bih=955&amp;eid=317150313&amp;oid=3&amp;ref=http%3A%2F%2Fwww.smzdm.com%2Fyouhui%2F328367%2F2&amp;brdim=0%2C0%2C0%2C0%2C1920%2C0%2C1920%2C1040%2C1920%2C955&amp;vis=1&amp;fu=0&amp;ifi=2&amp;dtd=373&amp;xpc=8LVtEanaaK&amp;p=http%3A//www.smzdm.com" vspace="0" width="250"></iframe>
      </div>
    </div>
    <div class="clear">&nbsp;</div>
  </div>
  <?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
</div>
</body>
</html>
