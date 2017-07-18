
$(function(){
	// 初始化插件
	$("#demo").zyUpload({
		width            :   "99%",                 // 宽度
		height           :   "",                 // 宽度
		itemWidth        :   "120px",                 // 文件项的宽度
		itemHeight       :   "120px",                 // 文件项的高度
		url              :   "createdo",  // 上传文件的路径
		multiple         :   true,                    // 是否可以多个文件上传
		dragDrop         :   true,                    // 是否可以拖动上传文件
		del              :   true,                    // 是否可以删除文件
		finishDel        :   true,  				  // 是否在上传文件完成后删除预览
		/* 外部获得的回调接口 */
		
	});
});

