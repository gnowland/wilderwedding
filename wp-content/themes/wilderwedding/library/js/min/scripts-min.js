/*
Joints Scripts File

This file should contain any js scripts you want to add to the site.
Instead of calling it in the header or throwing it inside wp_head()
this file will be called automatically in the footer so as not to
slow the page load.

*/// as the page loads, call these scripts
jQuery(document).ready(function(e){jQuery(document).foundation();e(".comment img[data-gravatar]").each(function(){e(this).attr("src",e(this).attr("data-gravatar"))});e("#scroll-container").scroll(function(){var t=e("#scroll-container").scrollTop();e("#stars").css("background-position","0px "+parseInt(-t/40)+"px")});var t=document.createElement("div");t.className="scrollbar-measure";document.body.appendChild(t);var n=t.offsetWidth-t.clientWidth;e("#menu-home-menu").css("margin-right",n);document.body.removeChild(t);e("a[href*=#]:not([href=#])").click(function(){if(location.pathname.replace(/^\//,"")==this.pathname.replace(/^\//,"")&&location.hostname==this.hostname){var t=e(this.hash);t=t.length?t:e("[id="+this.hash.slice(1)+"]");if(t.length){var n=e("#scroll-container").scrollTop();e("#scroll-container").animate({scrollTop:t.position().top+n},800,"swing",function(){history.pushState?history.pushState(null,null,t.selector):location.hash=t.selector});return!1}}});e(document).mouseup(function(t){var n=e(".top-bar"),r=e(".menu-item a");!n.is(t.target)&&n.has(t.target).length===0?n.removeClass("expanded"):r.is(t.target)&&n.removeClass("expanded")})});(function(e){function c(){n.setAttribute("content",s);o=!0}function h(){n.setAttribute("content",i);o=!1}function p(t){l=t.accelerationIncludingGravity;u=Math.abs(l.x);a=Math.abs(l.y);f=Math.abs(l.z);!e.orientation&&(u>7||(f>6&&a<8||f<8&&a>6)&&u>5)?o&&h():o||c()}if(!(/iPhone|iPad|iPod/.test(navigator.platform)&&navigator.userAgent.indexOf("AppleWebKit")>-1))return;var t=e.document;if(!t.querySelector)return;var n=t.querySelector("meta[name=viewport]"),r=n&&n.getAttribute("content"),i=r+",maximum-scale=1",s=r+",maximum-scale=10",o=!0,u,a,f,l;if(!n)return;e.addEventListener("orientationchange",c,!1);e.addEventListener("devicemotion",p,!1)})(this);