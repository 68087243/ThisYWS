(function(){
	//处理进度条问题
	var progressBar = $('.p-islide');
	var progressBarWidth = progressBar.css('width');
	if(parseInt(progressBarWidth) == '0')
	{
		progressBar.css('width','4%');
	}

	var complete = $('.task-complete');
	var completeTitle = $('.p-subtit');
	var completeNum = $('.p-subtit span');
	var num = complete.length;
	// alert(num);
	completeNum.text( num > 4 ? 4 : num);
	completeTitle.attr('title','已完成'+num+'项,待完成'+(4-parseInt(num))+'项');
})();