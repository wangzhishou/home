/**
 * 整站的js
 */
var h = {
	/**
	 * 初始化
	 */
	init : function() {
		this.imgErrorHanler();
	},
	
	/**
	 * 图片错误处理
	 */
	imgErrorHanler : function() {
		var imgList =  document.querySelector("article.block img");
		for(var i = 0, n =imgList.length; i < n; i++) {
			var img = imgList[i];
			img.onerror = function() {
				this.src = "/global/img/transparent.png";
			}
		}
	}
};
h.init();