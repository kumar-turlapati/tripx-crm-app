$(window).load(function() {
  $(".se-pre-con").fadeOut("slow");
});

function initializeJS() {

  // Datepicker
  jQuery('.date').datepicker();
  
  // Timepicker
  jQuery('#timepicker1').timepicker();

  //tool tips
  jQuery('.tooltips').tooltip();

  //popovers
  jQuery('.popovers').popover();

    
  //for html
  jQuery("html").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '6', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: '', zindex: '1000'});
    
  //for sidebar
  jQuery("#sidebar").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});
  
  // for scroll panel
  jQuery(".scroll-panel").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});
  
  //sidebar dropdown menu
  jQuery('#sidebar .sub-menu > a').click(function () {
    var last = jQuery('.sub-menu.open', jQuery('#sidebar'));        
    jQuery(this).find('.menu-arrow').removeClass('arrow_carrot-right');
    jQuery('.sub', last).slideUp(200);
    var sub = jQuery(this).next();
    if (sub.is(":visible")) {
        jQuery(this).find('.menu-arrow').addClass('arrow_carrot-right');            
        sub.slideUp(200);
    } else {
        jQuery(this).find('.menu-arrow').addClass('arrow_carrot-down');            
        sub.slideDown(200);
    }
    var o = (jQuery(this).offset());
    diff = 200 - o.top;
    if(diff>0)
        jQuery("#sidebar").scrollTo("-="+Math.abs(diff),500);
    else
        jQuery("#sidebar").scrollTo("+="+Math.abs(diff),500);
  });

  // sidebar menu toggle
  jQuery(function() {
    function responsiveView() {
      var wSize = jQuery(window).width();
      if (wSize <= 768) {
        jQuery('#container').addClass('sidebar-close');
        jQuery('#sidebar > ul').hide();
      }
      if (wSize > 768) {
        jQuery('#container').removeClass('sidebar-close');
        jQuery('#sidebar > ul').show();
      }
    }
    jQuery(window).on('load', responsiveView);
    jQuery(window).on('resize', responsiveView);
  });

  jQuery('.toggle-nav').click(function () {
    if (jQuery('#sidebar > ul').is(":visible") === true) {
      jQuery('#main-content').css({
          'margin-left': '0px'
      });
      jQuery('#sidebar').css({
          'margin-left': '-180px'
      });
      jQuery('#sidebar > ul').hide();
      jQuery("#container").addClass("sidebar-closed");
    } else {
      jQuery('#main-content').css({
        'margin-left': '180px'
      });
      jQuery('#sidebar > ul').show();
      jQuery('#sidebar').css({
        'margin-left': '0'
      });
      jQuery("#container").removeClass("sidebar-closed");
    }
  });

  /************************************************************************/
  /* Business logic functions starts from here. don't alter below code.
  /************************************************************************/

  /* prevent enter key while submitting form. */
  $('.noEnterKey').on('keypress keydown keyup', function (e) {
   if (e.keyCode == 13) {
     e.preventDefault();
   }
  });

  /* fade out alert box after sometime */
/*  if( $('.alert-success').length > 0 ) {
    $('.alert-success').fadeOut(6000);
  }*/

  /* cancel confirmation */
  $('.cancelForm').on('click', function(e){
    e.preventDefault();
    var formName = $(this).attr('id');
    switch(formName) {
      case 'leadImport':
        var redirectUrl = '/lead/import';
        break;
      case 'leadCreate':
        var redirectUrl = '/lead/create';
        break; 
    }
    var cancelForm = confirm('Are you sure. You want to cancel this form?');
    if(cancelForm) {
      window.location.href = redirectUrl;
    }
    return false;
  });

  /* lead remove confirmation */
  $('.leadDelete').on('click', function(e) {
    e.preventDefault();
    var deleteLeadForm = confirm('Are you sure. You want to remove this lead?');
    var leadCode = $(this).attr('id');
    if(deleteLeadForm == true) {
      window.location.href = '/lead/remove/'+leadCode+'?pageNo='+$('#currentPage').val();
    } else {
      return false;
    }
  });

  /* lead remove duplicates choice while importing */
  $('#removeDuplicates').on('change', function(e){
    e.preventDefault();
    var userChoice = parseInt($(this).val());
    if(userChoice === 0) {
      $('#duplicatesDiv, #maErrorId').hide();
    } else if(userChoice === 1) {
      $('#duplicatesDiv').show();      
    }
  });

  /************************************************************************/
  /* End of business logic.
  /************************************************************************/
}

jQuery(document).ready(function(){
  initializeJS();
});