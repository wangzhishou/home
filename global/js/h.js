/**
 * 整站的js
 */
var h = {
	/**
	 * 喜欢前缀
	 */
	likePrefix: "like",

	/**
	 * 收藏前缀
	 */
	favPrefix: "fav",

	/**
	 * 初始化
	 */
	init: function() {
		this.addEvent();
		this.addLikeEvent();
		this.addFavEvent();
	},

	/**
	 * 喜欢事件
	 */
	addLikeEvent: function() {
		var likeList = Q(".like");
		for (var i = 0, n = likeList.length; i < n; i++) {
			var likeBtn = likeList[i];
			var pid = Q.attr(likeBtn, "pid");
			if (pid) {
				if (window.localStorage && window.localStorage[this.likePrefix + pid]) {
					likeBtn.innerHTML = "已喜欢";
				} else {
					Q.on(likeBtn, "click", this.likeHandler);
				}
			}
		}
	},

	/**
	 * 喜欢事件处理函数
	 */
	likeHandler: function(e) {
		var event = Q.getEvent(e);
		var element = Q.getTarget(event);
		Q.stopBubble(event);
		Q.preventDefault(event);
		var pid = Q.attr(element, "pid");
		Q.ajax(V.likeRequest, {
			/**
			 * 请求数据
			 */
			data: "pid=" + pid,
			/**
			 * ajax请求前
			 */
			onBeforeSend: function() {},

			/**
			 * 检测成功以后
			 */
			onSuccess: function(xhr) {
				var re = xhr.responseText;
				if (re) {
					var obj = Q.jsonDecode(re);
					if (obj && obj.status) {
						Q.tip(obj.msg);
					} else {
						if (window.localStorage && obj.data && obj.data["pid"]) {
							var pid = obj.data["pid"];
							window.localStorage[h.likePrefix + pid] = new Date().getTime();
						}
						Q.tip("参与成功！");
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
	 * 添加收藏事件
	 */
	addFavEvent: function() {
		var favList = Q(".fav");
		for (var i = 0, n = favList.length; i < n; i++) {
			var favBtn = favList[i];
			var pid = Q.attr(favBtn, "pid");
			if (pid) {
				if (window.localStorage && window.localStorage[this.favPrefix + pid]) {
					favBtn.innerHTML = "已收藏";
				} else {
					Q.on(favBtn, "click", this.favHandler);
				}
			}
		}
	},

	/**
	 * 收藏事件处理函数
	 */
	favHandler: function(e) {
		var event = Q.getEvent(e);
		var element = Q.getTarget(event);
		Q.stopBubble(event);
		Q.preventDefault(event);
		var pid = Q.attr(element, "pid");
		Q.ajax(V.favRequest, {
			/**
			 * 请求数据
			 */
			data: "pid=" + pid,
			/**
			 * ajax请求前
			 */
			onBeforeSend: function() {},

			/**
			 * 检测成功以后
			 */
			onSuccess: function(xhr) {
				var re = xhr.responseText;
				if (re) {
					var obj = Q.jsonDecode(re);
					if (obj && obj.status) {
						if(obj.needLogin) {
							window.location.href = V.loginRequest;
						} else {
							Q.alert(obj.msg);
						}
					} else {
						if (window.localStorage && obj.data && obj.data["pid"]) {
							var pid = obj.data["pid"];
							window.localStorage[h.favPrefix + pid] = new Date().getTime();
						}
						element.innerHTML = "已收藏";
						Q.tip("收藏成功");
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
	 * 绑定事件
	 */
	addEvent: function() {
		var submitBtn = Q("#AjaxSubmitBtn");
		if (submitBtn) {
			Q.on(submitBtn, "click", this.ajaxFromHandler);
		}
	},

	/**
	 * ajax提交表单
	 */
	ajaxFromHandler: function(e) {
		var event = Q.getEvent(e);
		var element = Q.getTarget(event);
		Q.stopBubble(event);
		Q.preventDefault(event);
		Q.ajaxForm("#AjaxForm", {
			/**
			 * ajax请求前
			 */
			onBeforeSend: function() {
				h.cleanError();
			},

			/**
			 * 检测成功以后
			 */
			onSuccess: function(xhr) {
				var re = xhr.responseText;
				if (re) {
					var obj = Q.jsonDecode(re);
					if (obj && obj.status) {
						if (obj.data) {
							h.showErrorData(obj.data);
						}
					} else {
						if (obj.msg) {
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
	cleanError: function() {
		var list = Q("input, textarea");
		if (list) {
			for (var i = 0, n = list.length; i < n; i++) {
				var next = Q.next(list[i]);
				if (next && Q.hasClass(next, "label-red")) {
					next.style.display = "none";
					next.innerHTML = "";
				}
			}
		}
	},

	/**
	 * 提示错误信息
	 */
	showErrorData: function(data) {
		for (var key in data) {
			var target = Q("input[name=" + key + "],textarea[name=" + key + "]");
			console.log(target);
			if (target && target.length > 0) {
				var next = Q.next(target[0]);
				next.style.display = "inline";
				next.innerHTML = h.errorMessage(data[key]);
			}
		}
	},

	/**
	 * 获取错误信息
	 */
	errorMessage: function(db) {
		for (var key in db) {
			return db[key];
		}
	}
};
h.init();