$(function(){
	var keys=$('#keys').attr('lang');
	if(keys!=0){
		for (var i = 0; i < keys; i++) {
			$('#group'+i).editable({
		        showbuttons: false
		    });
		}
	}
});