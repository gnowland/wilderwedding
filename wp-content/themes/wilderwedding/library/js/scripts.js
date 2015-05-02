/*
Joints Scripts File

This file should contain any js scripts you want to add to the site.
Instead of calling it in the header or throwing it inside wp_head()
this file will be called automatically in the footer so as not to
slow the page load.

*/


// as the page loads, call these scripts
jQuery(document).ready(function($) {
	// load Foundation
	jQuery(document).foundation();

	// load gravatars
	$('.comment img[data-gravatar]').each(function(){
		$(this).attr('src',$(this).attr('data-gravatar'));
	});


/*
 * Add all your scripts here
 */

	// Animate Stars
	$('#scroll-container').scroll(function() {
	    var y = $('#scroll-container').scrollTop();
	    $("#stars").css('background-position', '0px ' + parseInt(-y / 40) + 'px');
	});


// //Modernizr Test for SVG, fallback
// if (!Modernizr.svg) {
//     var imgs = document.getElementsByTagName('img');
//     var svgExtension = /.*\.svg$/
//     var l = imgs.length;
//     for(var i = 0; i < l; i++) {
//         if(imgs[i].src.match(svgExtension)) {
//             imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
//             console.log(imgs[i].src);
//         }
//     }
//}

	/*
	 *
	 * Measure Scrollbars
	 *
	 */

	// Create the measurement node
	var scrollDiv = document.createElement("div");
	scrollDiv.className = "scrollbar-measure";
	document.body.appendChild(scrollDiv);

	// Get the scrollbar width
	var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
	$('#menu-home-menu').css('margin-right', scrollbarWidth);

	// Delete the measurement DIV
	document.body.removeChild(scrollDiv);

	/*
	 *
	 * Smoothly scroll to the href # id
	 * Older Chris Coyer scipt
	 * additional functionality from http://wibblystuff.blogspot.com/2014/04/in-page-smooth-scroll-using-css3.html
	 *
	 */
	$('a[href*=#]:not([href=#])').not('.panel-link').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[id=' + this.hash.slice(1) +']');
			if (target.length) {
				//var offset = (target.outerHeight(true) - target.outerHeight())/2; <- (not needed with new history.pushState)
				var offsetContainer = $('#scroll-container').scrollTop();
				$('#scroll-container').animate({ //html,body
				scrollTop: target.position().top + offsetContainer //+ ((target.outerHeight(true) - target.outerHeight())/2) //+ offset //offset().top
				}, 800, 'swing', function () {
					// window.location.hash = target.selector; <- caused jumping, replaced with the below:
					if(history.pushState) {
						 history.pushState(null, null, target.selector);
					}	else {
						location.hash = target.selector;
					}
				});
				return false;
			}
		}
	});

	$('#doAccordion').on('toggled', function (event, accordion) {
	  var containerPos = $(accordion).scrollTop();
	  var offsetContainer = $('#scroll-container').scrollTop();
	  var scrollPos = offsetContainer + containerPos;
	  $('#scroll-container').animate({ scrollTop: scrollPos }, 800, 'swing' );
	});

	/*
	 *
	 * Auto Close Menu
	 * (sub-nav not tested)
	 *
	 */

	$(document).mouseup(function (e){
		var container = $(".top-bar");
		var menuLinks = $(".menu-item a")

		if (!container.is(e.target) // if the target of the click isn't the container...
			&& container.has(e.target).length === 0){ // ... nor a descendant of the container
			container.removeClass('expanded');
		} else if (menuLinks.is(e.target)){
			container.removeClass('expanded');
		}
	});

}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
	var doc = w.document;
	if( !doc.querySelector ){ return; }
	var meta = doc.querySelector( "meta[name=viewport]" ),
		initialContent = meta && meta.getAttribute( "content" ),
		disabledZoom = initialContent + ",maximum-scale=1",
		enabledZoom = initialContent + ",maximum-scale=10",
		enabled = true,
		x, y, z, aig;
	if( !meta ){ return; }
	function restoreZoom(){
		meta.setAttribute( "content", enabledZoom );
		enabled = true; }
	function disableZoom(){
		meta.setAttribute( "content", disabledZoom );
		enabled = false; }
	function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
		if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );