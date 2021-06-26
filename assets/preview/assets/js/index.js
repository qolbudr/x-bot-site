import { startChat } from './bot.js'; 

$(document).ready(function() {
  $(".chat-box").css('visibility', 'hidden');
   // window.scrollTo(0, 0);
});

$(".chat-bubble").click(function() {
	window.parent.postMessage({message: 'maximize'}, '*');
	$(".chat-box").css({'left':'1vh', 'visibility':'visible', 'right':'1vh', 'opacity':100});
	$(".chat-bubble").hide();
	$(".chat-bubble-close").css({'visibility':'visible'});
  	startChat();
})

$(".reload-btn").click(function() {
	sessionStorage.clear();
	$(".chat-send,.chat-reply").remove();
	$(".chat-input-answer,.chat-button").css({'visibility':'hidden'});
	startChat();
})

$(".close-btn,.chat-bubble-close").click(function() {
	$(".chat-box").css({'left':'100vw', 'visibility':'hidden', 'right':'-100vw', 'opacity':0});
	$(".chat-bubble").show();
	$(".chat-send,.chat-reply").remove();
	$(".chat-input-answer,.chat-button").css({'visibility':'hidden'});
	$(".chat-bubble-close").css({'visibility':'hidden'});
	setTimeout(function() {
		window.parent.postMessage({message: 'minimize'}, '*');
	}, 500)
})