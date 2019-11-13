"use strict";!function(t,n,e,i){var o;i(function(){var t=setInterval(function(){youtube&&((o=i(".yt")).length&&o.each(function(){var t=i(this);new YT.Player(t.find(".yt__video")[0],{videoId:t.data("id"),host:"https://www.youtube.com",playerVars:{showinfo:1,enablejsapi:0,fs:0,origin:e.origin}})}),clearInterval(t))},500)})}(document,window,location,jQuery,WP);
//# sourceMappingURL=yt.js.map
