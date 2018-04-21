switch(window.location.origin){
    case 'https://file.payakapps.com': var baseUrl = 'https://file.payakapps.com/'; break;
    case 'https://stage.payakapps.com': var baseUrl = 'https://stage.payakapps.com/'; break;
    default: var baseUrl = 'http://localhost/file/'; break;
}

var apiUrl = baseUrl + "/api/dev";

function browserWidth(){
    var width = $(window).width();
    var height = $(window).height();
  
    return width;
  };
  
  function toggle(){
    var hide = true;
    $(".custom-toggle").click(function() {
      if(browserWidth() < 768) {
        if (hide) {
          $('#sidebar').css({'margin-left' : '0px'});
          hide = false;
        } else {
          $('#sidebar').css({'margin-left' : '-210px'});
          hide = true;
        }
      } else {
        if (hide) {
          $('#sidebar').css({'margin-left' : '-210px'});
          $('.main-content').css({'margin-left' : '0px'});
          $('.hidden-toggle').css({'display' : 'block'});
          hide = false;
        } else {
          $('#sidebar').css({'margin-left' : '0px'});
          $('.main-content').css({'margin-left' : '210px'});
          $('.hidden-toggle').css({'display' : 'none'});
          hide = true;
        }
      }
    });
  }
  
  $(document).ready(toggle());
  
  $(window).resize(function() {
    
    if(browserWidth() < 768) {
      $('#sidebar').css({'margin-left' : ''});
      $('.main-content').css({'margin-left' : ''});
      $('.hidden-toggle').css({'display' : ''});
    } else {
      // $('#sidebar').css({'margin-left' : ''});
      // $('.main-content').css({'margin-left' : ''});
    }
    
    toggle();
    
  });