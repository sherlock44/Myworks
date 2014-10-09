jQuery.fn.extend({
	menu1 : function() {
		this.find('.menu_title').click(function(){
			$(this).next('.menu').stop().toggle(500);
		});
	},
	menu2 : function() {
		var menus = this.find('.menu');
		this.find('.menu_title').click(function(){
			var menu = $(this).next('.menu');
			menus.not(menu).hide(500);
			menu.stop().toggle(500);
		});
	},
	menu3 : function() {
		var menus = this.find('.menu').css({position:'absolute'}).mouseover(function(){return false;});
		this.append($('<div class="clear">'));
		var currentMenu = false;
		this.find('.menu_title').css({float:'left',marginLeft:1}).mouseover(function(){
			hideMenu();
			var me = $(this);
			var offset = me.offset();
			currentMenu = me.next('.menu').css({left:offset.left,top:offset.top+me.height()}).stop().slideDown(500);
			return false;
		});
		var hideMenu = function() {
			if( currentMenu ) {
				currentMenu.stop().slideUp(500);
			}
		}
		$(document).mouseover(hideMenu);
	}
});
