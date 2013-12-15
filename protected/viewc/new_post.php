<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $data['title']; ?></title>
<?php echo $data['head']; ?>
<link rel="Shortcut Icon" href="<?php echo $data['baseurl']; ?>global/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo $data['baseurl']; ?>global/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $data['baseurl']; ?>global/ueditor/themes/default/css/umeditor.min.css" media="screen" />
<script src="<?php echo $data['baseurl']; ?>global/js/Q.js"></script>
<script src="<?php echo $data['baseurl']; ?>global/js/ui.js"></script>
<script type="text/javascript" charset="utf-8">
	window.UEDITOR_HOME_URL = "<?php echo $data['baseurl']; ?>global/ueditor/";	
	window.BASE_URL = "<?php echo $data['baseurl']; ?>";
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo $data['baseurl']; ?>global/ueditor/jquery-1.10.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $data['baseurl']; ?>global/ueditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $data['baseurl']; ?>global/ueditor/umeditor.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $data['baseurl']; ?>global/swfupload/swfupload.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $data['baseurl']; ?>global/swfupload/swfUploadHandler.js"></script>
</head><body>
<?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//top.php"; ?>
<div class="wrap"> 
  <div class="content">
    <div class="left mbox f">
      <div class="post-box">
        <h2>发布文章</h2>
        <form method="POST" action="<?php echo $data['baseurl']; ?>post/saveNew" id="AjaxForm">  
          <div class="field"> <strong>文章标题: </strong>
            <input type="text" size="60" name="title" class="input"/>
          </div>      
          <div class="field"> <strong>文章主图: </strong>
          	<div class="thumbnails-container">
            	<div id="ThumbnailsDiv" class="thumbnails"></div>
                <div id="ThumbnailsTips" class="thumbnails-tips">暂无缩略图,点击上传</div>
                <div id="ThumbnailsBtn" class="thumbnails-btn"><div id="DivButtonPlaceholder" class="btn"></div></div>
            </div>
          	<input type="hidden" name="thumbnails" id="Thumbnails" value=""/>
          </div>
          <?php if( $data['menu'] ): ?>
          <div class="field" id="CatBox"> <strong>文章分类: </strong> 
            <?php foreach($data['menu'] as $k1=>$v1): ?>
            <label>
              <input type="checkbox" name="cat" value="<?php echo $v1->name; ?>">
              <?php echo $v1->name; ?> </label>
            <?php endforeach; ?> 
          </div>
          <input type="hidden" name="cats" id="CatsInput" value="" />
          <?php endif; ?>
          <div class="field"> <strong>文章摘要: </strong>
            <textarea class="textarea" name="summary"></textarea>
          </div>
          <div class="field"> <strong>文章内容: </strong> 
            <script type="text/plain" id="editor" name="content"></script> 
          </div>
          <div class="field"> <strong>标签:<em>用逗号分隔不同的标签。</em> </strong>             
      		<div class="tag-box" id="TagBox">
            <?php if (!Q::cache('front')->getPart('randomTag', 300)): ?>
<?php Q::cache('front')->start('randomTag'); ?> 
            <?php foreach($data['randomTags'] as $k1=>$v1): ?> 
            <a href="<?php echo $data['baseurl']; ?>tag/<?php echo $v1->name; ?>"><?php echo $v1->name; ?></a>
            <?php endforeach; ?> 
            
<?php Q::cache('front')->end(); ?>
<?php endif; ?>
            </div>
            <input type="text" size="60" name="tags" id="TagsInput" class="input" />
          </div>
          <div class="field"> <strong>商品价格: </strong>
            <input type="text" size="60" name="price" class="input" style="width:100px;"/> 元
          </div> 
          <div class="field"> <strong>商品地址: </strong>
            <input type="text" size="60" name="sourceurl" class="input"/>
          </div> 
          <div class="field">
            <input type="submit" name="submit" value="确认发布"  class="btn btn-big" id="SubmitBtn" />
          </div>
        </form>
      </div>
    </div>
    <div class="right"> </div>
    <div class="clear">&nbsp;</div>
  </div>
</div>
<?php include Q::conf()->SITE_PATH .  Q::conf()->PROTECTED_FOLDER . "viewc//bottom.php"; ?> 
<script language="javascript" type="text/javascript">
var G = {
	saveSuccess : "<?php echo $data['baseurl']; ?>post/saveSuccess"
};
</script> 
<script src="<?php echo $data['baseurl']; ?>global/js/post.js"></script>

<script type="text/javascript">
var ue = UM.getEditor('editor', {
	imageUrl:"<?php echo $data['baseurl']; ?>/post/imageUp",
	imagePath:"",
	lang:/^zh/.test(navigator.language || navigator.browserLanguage || navigator.userLanguage) ? 'zh-cn' : 'en',
	langPath:UMEDITOR_CONFIG.UMEDITOR_HOME_URL + "lang/",
	focus: true
});

// Create the SWFUpload Object
var settings = new SWFUpload({
	upload_url : "<?php echo $data['baseurl']; ?>post/thumbUp",
	post_params: {"PHPSESSID": "NONE"},
	flash_url : "<?php echo $data['baseurl']; ?>global/swfupload/swfupload.swf",
	file_size_limit : "1024",
	file_post_name : "thumbFile",
	file_types : "*.jpg;*.gif;*.png;*.jpeg",
	file_types_description: "图片文件",
	file_upload_limit : 100,
	file_queue_limit : 1,
	
	ile_queued_handler : swfUploadHandler.fileQueued,
	file_queue_error_handler : swfUploadHandler.uploadErrorEventHandler,
	file_dialog_complete_handler : swfUploadHandler.fileDialogComplete,
	upload_start_handler : swfUploadHandler.uploadStartEventHandler,
	upload_error_handler : swfUploadHandler.uploadErrorEventHandler,
	upload_success_handler : swfUploadHandler.uploadSuccessEventHandler,
	upload_complete_handler : swfUploadHandler.uploadCompleteEventHandler,

	
	// Button Settings
	button_placeholder_id : "DivButtonPlaceholder",
	button_image_url : "<?php echo $data['baseurl']; ?>global/img/transparent.png",
	button_width: 235,
	button_height: 235,
	button_text_top_padding: 2,
	button_text_left_padding: 15,
	button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
	button_cursor: SWFUpload.CURSOR.HAND,
});
</script>
</body>
</html>
