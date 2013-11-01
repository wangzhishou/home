/**
 * 用户注册登录逻辑使用js
 */
var user = {
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
		var email = Q("#Email");
		if(email) {
			Q.on(email, "blur", this.checkInput);
		}

		var password = Q("#Password");
		if(password) {
			Q.on(password, "blur", this.checkInput);
		}
	},

	/**
	 * 显示错误W
	 */
	showError : function(target, msg) {
		target.className = "border-red";
		var next = Q.next(target);
		if(next) {
			next.className = "label label-red";
			next.innerHTML = msg;
		}
	},
	
	/**
	 * 显示成功
	 */
	showSuccess : function(target, msg) {
		target.className = "";
		var next = Q.next(target);
		if(next) {
			next.className = "label label-green";
			next.innerHTML = msg;
		}		
	},

	/**
	 * 清除错误
	 */
	cleanError : function(target) {
		target.className = "";
		var next = Q.next(target);
		if(next) {
			next.className = "";
			next.innerHTML = "";
		}		
	},

	/**
	 * 检测输入的是否规范
	 */
	checkInput : function(e) {
		var evt = Q.getEvent(e);
		var target = Q.getTarget(evt);
		if(target) {
			var name = Q.attr(target, "name");
			user.showSuccess(target, "检测中......");
			if (name && G && G.checkUrl) {
				Q.ajax(G.checkUrl, {
					method : "POST",
					cache : false,
					data : name + "=" + target.value,
					/**
					 * 检测成功以后
					 */
					onSuccess: function(xhr) {
						var re = xhr.responseText;
						if (re) {
							var obj = Q.jsonDecode(re);
							if(obj && obj.status) {
								if(obj.msg) {
									user.showError(target, obj.msg);
								}
							} else {
								if(obj.msg) {
									user.showSuccess(target, obj.msg);
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
		}
	}
};
user.init();