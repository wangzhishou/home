<header>
<div class="top">
  <div class="header">
    <div class="logo">
    	<a href="<?php echo $data['baseurl']; ?>"><img src="<?php echo $data['baseurl']; ?>global/img/logo.png"></a>
    </div>
    <nav>
      <ul class="nav">
        <?php if( isset($data['pinyin']) ): ?>
        <li> <a href="<?php echo $data['baseurl']; ?>">最新</a> </li>
        <?php else: ?>
        <li> <a href="<?php echo $data['baseurl']; ?>" class="selected">最新</a> </li>
        <?php endif; ?> 
        <?php if( $data['menu'] ): ?> 
        <?php foreach($data['menu'] as $k1=>$v1): ?> 
        <?php if( isset($data['pinyin']) && $v1->pinyin == $data['pinyin'] ): ?>
        <li> <a href="<?php echo $data['baseurl']; ?>c/<?php echo $v1->pinyin; ?>.html" class="selected"><?php echo $v1->name; ?></a> </li>
        <?php else: ?>
        <li> <a href="<?php echo $data['baseurl']; ?>c/<?php echo $v1->pinyin; ?>.html"><?php echo $v1->name; ?></a> </li>
        <?php endif; ?> 
        <?php endforeach; ?> 
        <?php endif; ?>
      </ul>
    </nav>
    <div class="head-right"> 
      <?php if( $data['user']['group'] == 'anonymous' ): ?> 
      <a href="<?php echo $data['baseurl']; ?>user/reg" class="join">注册</a> <a href="<?php echo $data['baseurl']; ?>user/login" id="login-link" class="btn btn-small">登录</a> 
      <?php else: ?>
      <p class="normal">Hi, <strong><?php echo $data['user']['username']; ?></strong>，欢迎登录！<a href="<?php echo $data['baseurl']; ?>u/index">个人中心</a>&nbsp;<a href="<?php echo $data['baseurl']; ?>user/logout" id="login-link" class="btn btn-small">退出</a></p>
      <?php endif; ?> 
    </div>
    <div class="clear"></div>
  </div>
</div>
</header>
