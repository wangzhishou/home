var swfUploadHandler = {
	/**
	 * 开始上传回调
	 */
	uploadStartEventHandler: function(file) {
		var tips = document.getElementById("ThumbnailsTips");
		tips.style.color = "#6BC30D";
		tips.innerHTML = "正在上传......";
	},

	/**
	 * 上传成功回调
	 */
	uploadSuccessEventHandler: function(file, serverData) {
		if (serverData) {
			var obj = Q.jsonDecode(serverData);
			if (obj && obj.status) {
				if (obj.msg) {
					Q.alert(obj.msg);
				}
			} else {
				var tips = document.getElementById("ThumbnailsTips");
				tips.style.color = "#6BC30D";
				tips.innerHTML = "上传成功!";
				setTimeout(function() {
					tips.innerHTML = "";
				}, 3000);
				if (obj.data) {
					swfUploadHandler.addImage(obj.data);			
					var thumbInput = document.getElementById("Thumbnails");
					if(thumbInput){
						thumbInput.value = obj.data;
					}
				}	
			}
		}
	},

	/**
	 * 上传错误回调
	 */
	uploadErrorEventHandler: function(file, errorCode, message) {
		try {
			var tips = document.getElementById("ThumbnailsTips");
			tips.style.color = "#ff0000";
			switch (errorCode) {
				case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED: 		
					tips.innerHTML = "你上传的文件不能超过1个.";
					break;
				case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
					tips.innerHTML = "你上传的文件大小为零.";
					break;
				case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
					tips.innerHTML = "你上传的文件大小不能超过1兆.";
					break;
				case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
				case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
					tips.innerHTML = "无效文件，请重新选择.";
					break;
				default:
					tips.innerHTML = "上传错误，请选择重试";
					break;
			}
		} catch (ex) {

		}
	},

	/**
	 * 文件排队
	 */
	fileQueued : function() {

	},

	/**
	 * 文件选择完成操作
	 */
	fileDialogComplete: function(numFilesSelected, numFilesQueued) {
		try {
			if (numFilesQueued > 0) {
				this.startUpload();
			}
		} catch (ex) {
			this.debug(ex);
		}
	},

	/**
	 * 上传完成回调
	 */
	uploadCompleteEventHandler: function(file) {
		//alert("上传完成");
	},

	/**
	 * 添加图片到上传容器
	 */
	addImage: function(src) {
		var newImg = document.createElement("img");
		newImg.style.width = "315px";
		var tmb = document.getElementById("ThumbnailsDiv");
		tmb.innerHTML = "";
		tmb.appendChild(newImg);
		if (newImg.filters) {
			try {
				newImg.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 0;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				newImg.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 0 + ')';
			}
		} else {
			newImg.style.opacity = 0;
		}
		newImg.onload = function() {
			Q.fadeIn(newImg);
		};
		newImg.src = src;
	}
};