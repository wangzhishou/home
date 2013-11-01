/**
 * 整站的js
 */
var h = {
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
		var submitBtn = Q("#AjaxSubmitBtn");
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
			 * ajax请求前
			 */
			onBeforeSend : function() {
				h.cleanError();
			},
			
			/**
			 * 检测成功以后
			 */
			onSuccess: function(xhr) {
				var re = xhr.responseText;
				if (re) {
					var obj = Q.jsonDecode(re);
					if(obj && obj.status) {
						if(obj.data) {
							h.showErrorData(obj.data);
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
				Q.alert("系统错误，请稍后重试！");
			}
		});
	},
	
	/**
	 * 清除错误信息
	 */
	cleanError : function() {
		var list = Q("input, textarea");
		if(list) {
			for(var i =0, n = list.length; i <n; i++) {
				var next = Q.next(list[i]);
				if(next && Q.hasClass(next, "label-red")) {
					next.style.display = "none";
					next.innerHTML = "";
				}			
			}
		}
	},
	
	/**
	 * 提示错误信息
	 */
	showErrorData : function(data) {
		for(var key in data) {
			var target = Q("input[name=" + key + "],textarea[name=" + key + "]");
			console.log(target);
			if(target && target.length > 0) {
				var next = Q.next(target[0]);
				next.style.display = "inline";
				next.innerHTML = h.errorMessage(data[key]);
			}
		}		
	},
	
	/**
	 * 获取错误信息
	 */
	errorMessage : function(db) {		
		for(var key in db) {
			return db[key];
		}		
	}
};
h.init();