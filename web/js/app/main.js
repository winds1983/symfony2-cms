/**
 * http://www.ruanyifeng.com/blog/2012/11/require_js.html
 */

require.config({
	paths: {
		"jquery": "../libs/jquery/jquery-1.8.3.min",
		"underscore": "../libs/underscore/underscore.min",
		"backbone": "../libs/backbone/backbone.min"
	}
});

require(["js/libs/jquery/jquery-1.8.3.min"], function($){
	$(function(){
		alert('123');
	});
});