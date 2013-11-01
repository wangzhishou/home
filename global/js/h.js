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
				user.showError(target, "系统错误，请稍后重试！");
			}
		});
	}
};
h.init();