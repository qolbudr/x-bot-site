var url = $('body').attr('domain');
var bot_id = $('body').attr('bot_id');

function enableClick() {
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
}

function startChat() {
  var count = $(".wrapper > div").length;
  if(sessionStorage['lastContent']) {
    $('.wrapper').html(sessionStorage['lastContent']);
    if(sessionStorage['lastChat'] !== 'end') {
      var obj = JSON.parse(sessionStorage['lastChat']);
      getChat(obj.element_id);
    } else {
      getChat('end');
    }
  } else {
    getChat("start");
  }
}

function getChat(element_id) {
  appendReply();
  new Typed('#typed',{
    strings : ['Typing...'],
    typeSpeed : 50,
    delaySpeed : 50
  });

  $(".close-btn,.chat-bubble-close").off('click');

  setTimeout(function() {
    if(element_id !== 'end') {
      $.ajax({
        type: 'post',
        url: `${url}query/getResponse`,
        data: `element_id=${element_id}&bot_id=${bot_id}`,
        success: function(result) {
          enableClick()
          sessionStorage['lastChat'] = JSON.stringify(result);
          if(result.style == 'option') {
            replaceText(result);
            enableButton(result);
          } else if(result.style == 'question') {
            replaceText(result);
            enableText(result);
          } else {
            replaceText(result);
          }
        }  
      })
    } else {
      // replaceText("Thank you  for contacting us!");
      $('.current').html("Thank you  for contacting us!");
      $('.current').removeClass('current');
      sessionStorage['lastChat'] = 'end';
      if(sessionStorage['variable']) {
        $.ajax({
          type: 'post',
          url: `${url}/query/saveData`,
          data: `data=${sessionStorage['variable']}&bot_id=${bot_id}`,
          success: function(result) {
            sessionStorage.removeItem('variable');
          }   
        })
      }
      enableClick();
      changeScroll();
    }
  }, 1500)
}

function changeScroll() {
  // $('.wrapper').slimScroll({destroy:true});
  var scrollTo_int = $('.wrapper').prop('scrollHeight') + 'px';
  $('.wrapper').slimScroll({scrollTo : scrollTo_int, height: '65vh'});
}

function appendReply() {
  $(".wrapper").append(`<div class="chat-reply"><div class="text current"><span class="typed" id="typed"></span></div></div>`);
  changeScroll();
}

function appendSend(text, variable) {
  $(".wrapper").append(`<div class="chat-send"><div class="text">${text}</div></div>`);
  if(variable !== "") {
    if(sessionStorage['variable']) {
      var store = JSON.parse(sessionStorage['variable']);
    } else {
      var store = {};
    }
    store[variable] = text;
    sessionStorage["variable"] = JSON.stringify(store);
  }
  var content = $('.wrapper').html();
  sessionStorage['lastContent'] = content;
  changeScroll();
}

function replaceText(result) {
  var text = result.text;
  text = changeVariable(text);
  $('.current').html(text);
  $('.current').removeClass('current');
  changeScroll();
  if(result.style == 'text') {
    var content = $('.wrapper').html();
    sessionStorage['lastContent'] = content;
    getChat(result.goto);
  }
}

function changeVariable(text) {
  if(text.includes('{{') && text.includes('}}')) {
    var txt = text.match(/{{[\w\d]+}}/g);
    var data = '';
    for(var i=0; i < txt.length; i++) {
      txt[i] = txt[i].replace(/[{}]/g, '');
      var obj = JSON.parse(sessionStorage['variable']);
      text = text.replace('{{'+txt[i]+'}}', obj[txt[i]]);
    }
  }

  return text;
} 

function enableButton(result) {
  var data = result.button;
  $(".chat-button").html('');
  $(".chat-button").css('visibility', 'visible');
  data.forEach(function(item) {
    $('.chat-button').append(`<div class="btn-answer ml-2 mb-2" data-variable="${result.save}" data-goto="${item.goto}">${item.text}</div>`);
  })

  var height = $('.wrapper').height();
  var buttonArea = $('.chat-button').height();
  var fixed = height - buttonArea + 30;
  var scroll = $('.wrapper').prop('scrollHeight'); 
  $('.wrapper').slimScroll({scrollTo : scroll + 'px', height: fixed + 'px'});

  $('.btn-answer').click(function() {
    var variable = $(this).attr('data-variable');
    var goto = $(this).attr('data-goto');
    var text = $(this).html();
    $(".chat-button").html('');
    $(".chat-button").css('visibility', 'hidden');
    appendSend(text, variable);
    getChat(goto);    
  })
}

function enableText(result) {
  $(".chat-text-answer").css('visibility', 'visible');
  if(result.save) {
    $('.chat-text-answer').append(`<input class="input-answer" data-variable="${result.save}" data-goto="${result.goto}" placeholder="Type text....">`);
  } else {
    $('.chat-text-answer').append(`<input class="input-answer" data-variable="" data-goto="${result.goto}" placeholder="Type text....">`);
  }

  var height = $('.wrapper').height();
  var inputArea = $('.chat-text-answer').height();
  var fixed = height - inputArea + 30;
  var scroll = $('.wrapper').prop('scrollHeight'); 
  $('.wrapper').slimScroll({scrollTo : scroll + 'px', height: fixed + 'px'});

  $(".input-answer").on('keydown', function (e) {
    if(e.keyCode === 13) {
      var variable = $(".input-answer").attr('data-variable');
      var goto = $(".input-answer").attr('data-goto');
      var text = $(".input-answer").val();
      $(".chat-text-answer").html('');
      $(".chat-text-answer").css('visibility', 'hidden');
      appendSend(text, variable);
      getChat(goto);
    }
  })
}

export { startChat };