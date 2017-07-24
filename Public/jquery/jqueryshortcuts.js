//jquery �ı�����
(function($) {
    $.fn.extend({
		shortcuts : function(){
			this.keydown(function(e){
				var _this = $(this);
				e.stopPropagation();
				if(e.ctrlKey){
					switch(e.keyCode){
						case 66:
							_this.insertContent('[b]'+ _this.selectionRange() +'[/b]');
							return false;
							break;
						case 73:
							_this.insertContent('[i]'+ _this.selectionRange() +'[/i]');
							return false;
							break;
						case 49:
							_this.insertContent('[h1]'+ _this.selectionRange() +'[/h1]');
							return false;
							break;
						case 50:
							_this.insertContent('[h2]'+ _this.selectionRange() +'[/h2]');
							return false;
							break;
						case 51:
							_this.insertContent('[h3]'+ _this.selectionRange() +'[/h3]');
							return false;
							break;
						case 52:
							_this.insertContent('[h4]'+ _this.selectionRange() +'[/h4]');
							return false;
							break;
						case 53:
							_this.insertContent('[h5]'+ _this.selectionRange() +'[/h5]');
							return false;
							break;
						case 54:
							_this.insertContent('[h6]'+ _this.selectionRange() +'[/h6]');
							return false;
							break;
					}
				}else if(e.altKey){
					switch(e.keyCode){
						case 67:
							_this.insertContent('[code]'+ _this.selectionRange() +'[/code]');
							return false;
							break;
						case 76:
							_this.insertContent('[li]'+ _this.selectionRange() +'[/li]');
							return false;
							break;
						case 80:
							_this.insertContent('[p]'+ _this.selectionRange() +'[/p]');
							return false;
							break;
						case 85:
							_this.insertContent('[url]'+ _this.selectionRange() +'[/url]');
							return false;
							break;
					}
				}	
			});
		},
        insertContent: function(myValue, t) {
            var $t = $(this)[0];
            if (document.selection) { //ie
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd("character", wee + t);
                    t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);

                    sel.select();
                }
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
                    this.focus();
                }
            }
            else {
                this.value += myValue;
                this.focus();
            }
        },
        selectionRange : function(start, end) {
        	var str = "";
        	var thisSrc = this[0];
        	if(start === undefined) {
          	//��ȡ��ǰѡ���������ݣ����ܸ���Ԫ�ص�ѡ������
          		if(/input|textarea/i.test(thisSrc.tagName) && /firefox/i.test(navigator.userAgent))
            		//�ı��������Firefox�µ��������
            		str = thisSrc.value.substring(thisSrc.selectionStart, thisSrc.selectionEnd);
          		else if(document.selection)
            		//���ı������
            		str = document.selection.createRange().text;
          		else
            		str = document.getSelection().toString();
        		} else {
          			//�����ı�����ؼ��Ĺ��λ��
          			if(!/input|textarea/.test(thisSrc.tagName.toLowerCase()))
            			//���ı�����ؼ�����Ч
            			return false;

          			//���粻���ڶ���������Ĭ�Ͻ�end��Ϊstart
          			(end === undefined) && (end = start);

    	      		//���ƹ��λ��
    		      	if(thisSrc.setSelectionRange) {
    		        	thisSrc.setSelectionRange(start, end);
    		        	this.focus();
    		      	} else {
    		        	var range = thisSrc.createTextRange();
    		        	range.move('character', start);
    		        	range.moveEnd('character', end - start);
    		        	range.select();
    		      	}
        		}
    	    if(start === undefined)
    	      return str;
    	    else
    	      return this;
      	}
    })
})(jQuery);