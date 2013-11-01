var post = {
	/**
	 * 初始化
	 */
	init : function() {
		this.addEvent();		
	},

	/**
	 * 绑定事件
	 */
	addEvent : function() {
		var catBox = Q("#CatBox");
		if(catBox) {
			Q.on(catBox, "click", this.catBoxClick);
		}

		var tagBox = Q("#TagBox");
		if(tagBox) {
			Q.on(tagBox, "click", this.tagBoxClick);
		}
				
		var submitBtn = Q("#SubmitBtn");
		if(submitBtn) {
			Q.on(submitBtn, "click", this.ajaxFromHandler);
		}		
	},
	
	/**
	 * ajax提交表单
	 */
	ajaxFromHandler : function(e) {		
		var event = Q.getEvent(e);
		var element = Q.getTarget(event);
		Q.stopBubble(event);
		Q.preventDefault(event);
		Q.ajaxForm("#AjaxForm", {
			/**
			 * 检测成功以后
			 */
			onSuccess: function(xhr) {
				var re = xhr.responseText;
				if (re) {
					var obj = Q.jsonDecode(re);
					if(obj && obj.status) {
						if(obj.msg) {
							Q.alert(obj.msg);
						}
					} else {
						if(obj.msg) {
							Q.alert(obj.msg);
						}								
					}
				}
			},

			/**
			 * 检测失败
			 */
			onError: function() {
				alert("系统错误，请稍后重试！");
			}
		});
	},
	
	/**
	 * 分类点击选择
	 */
	catBoxClick : function(e) {		
		var evt = Q.getEvent(e);
		var target = Q.getTarget(evt);
		if(target && target.tagName.toLowerCase() == "input") {
			post.catsInput();
		}
	},
	
	/**
	 * 选择分类
	 */
	catsInput : function() {		
		var catsInput = Q("#CatsInput");		
		var catBox = Q("#CatBox");
		var listInput = catBox.getElementsByTagName("input");
		var data = [];
		for(var i = 0, n = listInput.length; i < n; i++) {
			var tmp = listInput[i];
			if(tmp.checked) {
				data.push(tmp.value);
			}
		}
		catsInput.value = data.join(",");
	},

	/**
	 * 标签点击选择
	 */
	tagBoxClick : function(e) {		
		var evt = Q.getEvent(e);
		var target = Q.getTarget(evt);
		Q.preventDefault(e);
		if(target && target.tagName.toLowerCase() == "a") {
			if(Q.hasClass(target, "selected")) {				
				Q.removeClass(target, "selected");
			} else {
				Q.addClass(target, "selected");
			}
			post.tagsInput(target);		
		}
	},	
	
	/**
	 * 选择分类
	 */
	tagsInput : function(target) {		
		var tagsInput = Q("#TagsInput");	
		if(!tagsInput) {
			return;
		}
		var tagsValue = Q.trim(tagsInput.value).replace("，", ",");	
		var tagBox = Q("#TagBox");
		var list = tagBox.getElementsByTagName("a");
		var data = [];
		if(tagsValue.length > 0) {
			data = tagsValue.split(",");
		}
		var obj = {};
		for(var i = 0, n = data.length; i < n; i++) {
			var v = Q.trim(data[i]);
			obj[v] = 1;
		}
		var value = Q.trim(target.innerHTML);
		if(Q.hasClass(target, "selected")) {
			obj[value] = 1;
		} else {
			if(obj[value]) {
				delete obj[value];
			}
		}
		for(var i = 0, n = list.length; i < n; i++) {
			var tmp = list[i];
			if(Q.hasClass(tmp, "selected")) {
				var v = Q.trim(tmp.innerHTML);
				obj[v] = 1;
			}
		}
		var data = [];
		for(var i in obj) {
			data.push(i);
		}
		tagsInput.value = data.join(",");
	},
};
post.init();