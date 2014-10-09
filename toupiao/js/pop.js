jQuery.fn.extend({
	myalert:function(str){
		this.append($('<div>').css({position:'absolute',top:0,width:'100%',height:'100%',background:'rgba(122,34,55,.3)'}));
	}
});