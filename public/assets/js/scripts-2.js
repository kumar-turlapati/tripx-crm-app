$(window).load(function() {
  // Animate loader off screen
  $(".se-pre-con").fadeOut("slow");;
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

    //custom scrollbar
    
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

    // Prevent Enter key while submitting form.
    $('.noEnterKey').on('keypress keydown keyup', function (e) {
     if (e.keyCode == 13) {
       e.preventDefault();
     }
    });

    if(jQuery('#itemnames').length>0) {    
      $('#itemnames').Tabledit({
        url: '/async/add-thr-qty',
        editButton: false,
        deleteButton: false,
        hideIdentifier: false,
        columns: {
          identifier: [1,'mCode'],
          editable: [[3,'thQty']]
        },
        onAjax: function(action, serialize) {
        }
      });
    }

    if(jQuery('.inameAc').length>0) {
      $('.inameAc').autocomplete("/async/itemsAc", {
        width: 300,
        cacheLength:0,
        selectFirst:false,
        minChars:1,
        'max': 0,
      });            
    }

    jQuery('#paymentMode').on("change", function(e){
      var paymentMode = $(this).val();
      if(paymentMode==='b' || paymentMode==='p') {
          $('#refInfo').show();
      } else if(paymentMode==='c') {
          $('#refInfo').hide();
      }
    });

/********************************* Sales entry logic starts from here **********************************************/
    jQuery('.inameAc').on("blur", function(e){
      var itemName = jQuery(this).val();
      var itemIndex = jQuery(this).attr('index');
      if( itemName !== '' ) {
       var data = {itemname:itemName};
       jQuery.ajax("/async/getBatchNos", {
          data: data,
          method:"POST",
          success: function(response) {
            var objLength = Object.keys(response).length;
            if(objLength>0) {
              var availableQty = response.batch_nos[0].availableQty;
              var itemRate = response.batch_nos[0].itemRate;
              var taxRate = response.batch_nos[0].taxRate;
              $('#qtyava_'+itemIndex).val(availableQty);
              $('#mrp_'+itemIndex).val(itemRate);
              $('#saItemTax_'+itemIndex).val(parseInt(taxRate,10));
            }
          },
          error: function(e) {
            alert('An error occurred while fetching available item qty.');
          }
       });
      }
    });

    /* trigger on change if qty changes. */
    jQuery('.itemQty').on("change", function(e){
      var elemId = jQuery(this).attr('index');
      var itemQty = parseInt(jQuery(this).val());
      var itemRate = parseFloat(jQuery('#mrp_'+elemId).val());
      var qtyAvailable = $('#qtyava_'+elemId).val();
      if(parseInt(itemQty)>parseInt(qtyAvailable)) {
        $(this).val(0);
        alert('Sold Qty. should be less than or equal to Available Qty.');
        return false;
      } else if(parseFloat(itemQty)>0 && parseFloat(itemRate)>0) {
        updateSalesItemRow(elemId,itemQty,itemRate);  
      }
    });

    /** Show Card No and Authcode if Payment mode is credit **/
    /** Show Split Payment inputs as well */
    if( $('#saPaymentMethod').length>0 ) {
      $('#saPaymentMethod').on('change', function(){
        var paymentMethod = parseInt($(this).val());
        if(paymentMethod === 1 || paymentMethod === 2) {
          $('#containerCardNo, #containerAuthCode').show();
        } else {
          $('#containerCardNo, #containerAuthCode').hide();
        }
        /* enable multiple pay options if it is split payment */
        if(paymentMethod === 2) {
          $('#splitPaymentCash, #splitPaymentCard').attr('disabled', false);
        } else {
          $('#splitPaymentCash, #splitPaymentCard').val('');
          $('#splitPaymentCash, #splitPaymentCard').attr('disabled', true);
        }
      });
    }

    /* on change of discount method */
    if( $('#discountMethod').length>0 ) {
      $('#discountMethod').on("change", function(){
        var discountMethod = $(this).val();
        if( parseInt(discountMethod) === 1) {
          $('#couponCode').attr('disabled', false);
        } else {
          $('#couponCode').attr('disabled', true);
          $('#couponCode').val('');
        }
      });
    }

    /** trigger blur event when discount field loose focus **/
    jQuery('.saDiscount').on("change", function(e){
      var elemId = $(this).attr('id').split('_')[1];
      var itemQty = parseInt($('#qty_'+elemId).val());
      var itemRate = parseFloat(jQuery('#mrp_'+elemId).val());
      updateSalesItemRow(elemId,itemQty,itemRate);
    });

    /** update totals if tax calc. option is changed **/
    jQuery('.taxCalcOption').on("change", function(e){

      var netPay = iTotal = billAmount = totalAmount = roundOff = 0;
      var totBillAmount = totDiscount = totTaxableAmt = totTaxes = totTaxAmount = 0;

      $('.grossAmount').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).text());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totBillAmount  += parseFloat(iTotal);
        }
      });
      $('.taxableAmt').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).text());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totTaxableAmt  += parseFloat(iTotal);
        }
      });
      $('.saDiscount').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).val());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totDiscount  += parseFloat(iTotal);
        }
      });
      $('.saItemTaxAmount').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).val());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totTaxAmount  += parseFloat(iTotal);
        }
      });

      if($('#taxCalcOption').val() === 'e') {
        totalAmount = totTaxableAmt + totTaxAmount;
      } else {
        totalAmount = totTaxableAmt;
      }

      roundOff = parseFloat(Math.round(totalAmount)-totalAmount);
      netPay = parseFloat(totalAmount+roundOff);

      $('.billAmount').text(totBillAmount.toFixed(2));
      $('.discount').text(totDiscount.toFixed(2));
      $('.totalAmount').text(totTaxableAmt.toFixed(2));
      if($('#taxCalcOption').val() === 'e') {
        $('.gstAmount').text(totTaxAmount.toFixed(2));
      } else {
        $('.gstAmount').text("0.00");        
      }
      $('.roundOff').text(roundOff.toFixed(2));
      $('.netPayBottom').text(netPay.toFixed(2));      
      $('.netPayTop').val(netPay.toFixed(2));      
    });

    /** updates Row total and Tax amount **/
    function updateSalesItemRow(index, qty, rate) {
      var netPay = iTotal = billAmount = totalAmount = roundOff = 0;
      var totBillAmount = totDiscount = totTaxableAmt = totTaxes = totTaxAmount = 0;

      var taxableAmountId = jQuery('#taxableAmt_'+index);
      var grossAmountId = jQuery('#grossAmount_'+index);
      var discountAmountId = jQuery('#discount_'+index);
      var taxAmountId = jQuery('#saItemTaxAmt_'+index);
      var taxPercent = jQuery('#saItemTax_'+index).val();
      var saItemTotalId = jQuery('#saItemTotal_'+index);
      var itemTotal = (parseFloat(qty)*parseFloat(rate)).toFixed(2);
      var discount = parseFloat(discountAmountId.val());
      if(isNaN(discount)) {
        discount = 0;
      }
      var taxableAmount = itemTotal-discount;
      var taxAmount = (taxableAmount*taxPercent/100).toFixed(2);
      if(isNaN(taxAmount)) {
        taxAmount = 0;
      }
      grossAmountId.text(itemTotal);
      taxableAmountId.text(taxableAmount.toFixed(2));
      taxAmountId.val(taxAmount);
      saItemTotalId.val(parseFloat(taxableAmount)+parseFloat(taxAmount));
      $('#saItemTaxAmt_'+index).attr('data-rate', taxPercent);

      $('.grossAmount').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).text());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totBillAmount  += parseFloat(iTotal);
        }
      });
      $('.taxableAmt').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).text());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totTaxableAmt  += parseFloat(iTotal);
        }
      });
      $('.saDiscount').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).val());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totDiscount  += parseFloat(iTotal);
        }
      });
      $('.saItemTaxAmount').each(function(i, obj) {
        iTotal = parseFloat(jQuery(this).val());
        if( iTotal > 0 && !isNaN(iTotal) ) {
          totTaxAmount  += parseFloat(iTotal);
        }
      });

      if($('#taxCalcOption').val() === 'e') {
        totalAmount = totTaxableAmt + totTaxAmount;
      } else {
        totalAmount = totTaxableAmt;
      }

      roundOff = parseFloat(Math.round(totalAmount)-totalAmount);
      netPay = parseFloat(totalAmount+roundOff);

      $('.billAmount').text(totBillAmount.toFixed(2));
      $('.discount').text(totDiscount.toFixed(2));
      $('.totalAmount').text(totTaxableAmt.toFixed(2));
      if($('#taxCalcOption').val() === 'e') {
        $('.gstAmount').text(totTaxAmount.toFixed(2));
      } else {
        $('.gstAmount').text("0.00");        
      }
      $('.roundOff').text(roundOff.toFixed(2));
      $('.netPayBottom').text(netPay.toFixed(2));      
      $('.netPayTop').val(netPay.toFixed(2));
    }

    $('#reportsFilter').on("click",function(e){
      e.preventDefault();
      $('#reportsForm').submit();
    });

    $('#reportsReset').on("click",function(e){
      e.preventDefault();
      var redirectUrl = $('#reportHook').val();
      window.location.href='/report-options'+redirectUrl;
    });    

    $('.returnQty').on("change", function(e){
      var returnItemId = $(this).attr('id').split('_')[1];
      var returnRate = parseFloat($('#returnRate_'+returnItemId).text());
      var returnQty = parseFloat($(this).val());
      var returnValue = parseFloat(returnRate*returnQty);
      $('#returnValue_'+returnItemId).text(returnValue.toFixed(2));
      updateSalesReturnValue();
    });

    $('#mobileNo').on("blur", function(e){
      var refNo = $(this).val();
      if(refNo !== '') {
       jQuery.ajax("/async/getPatientDetails?refNo="+refNo+'&by=mobile', {
          method:"GET",
          success: function(customerDetails) {
            var objLength = Object.keys(customerDetails).length;
            if(objLength>0) {
              $('#name').val(customerDetails.customerName);
            } else {
              $('#name').val('');
            }
          },
          error: function(e) {
            console.log("Unable to retrieve customer information");
          }
       });
      }
    });

    $('.mmovement').on("change",function(e){
      if($(this).val()==='slow') {
        $('#count').val(1);
        $('#count').attr('disabled',true);
      } else if($(this).val()==='fast') {
        $('#count').val(0);
        $('#count').attr('disabled',false);      
      }
    });

    function updateSalesReturnValue() {
      var totalAmount = roundOff = netPay = 0;
      jQuery('.itemReturnValue').each(function(i, obj) {
        iTotal      =   jQuery(this).text();
        if(parseFloat(iTotal)>0) {
          totalAmount  += parseFloat(iTotal);
        }
      });

      roundOff = parseFloat(Math.round(totalAmount)-totalAmount);
      netPay = parseFloat(totalAmount+roundOff);

      jQuery('.totalAmount').text(totalAmount.toFixed(2));
      jQuery('.roundOff').text(roundOff.toFixed(2));
      jQuery('.netPay').text(netPay.toFixed(2));
    }

    /*chart functionality */

    if( $('#dbContainer').length>0 ) {
      var saleDates = [];
      var saleAmounts = [];
      // load daysales initially
      jQuery.ajax("/async/day-sales",{
          method:"GET",
          success: function(apiResponse) {
            if(apiResponse.status==='success') {
              var daySales = apiResponse.response.daySales[0];
              var cashSales = parseInt(daySales.cashSales);
              var creditSales = parseInt(daySales.creditSales);
              var cardSales = parseInt(daySales.cardSales);
              var salesReturns = parseInt(daySales.returnamount);
              var totalSales = parseInt(cashSales+creditSales+cardSales);
              var netSales = parseInt(totalSales-salesReturns);
              var cashInHand = cashSales-salesReturns;
              $('#ds-cashsale').text(cashSales.toFixed(2));
              $('#ds-cardsale').text(cardSales.toFixed(2));
              $('#ds-creditsale').text(creditSales.toFixed(2));
              $('#ds-totals').text(totalSales.toFixed(2));
              $('#ds-returns').text(salesReturns.toFixed(2));
              $('#ds-netsale').text(netSales.toFixed(2));
              $('#ds-cashinhand').text(cashInHand.toFixed(2));                                          
            }
          },
          error: function(e) {
            alert('An error occurred while fetching Day Sales');
          }
      });
    }

    $('#sfGraphReload').on("click", function(e){
      var curMonth = $('#sgf-month').val();
      var curYear =  $('#sgf-year').val();
      $('#saleMonth').val(curMonth);
      $('#saleYear').val(curYear);
      monthWiseSales();
    });

/*************************************** Javascript for handling Promotional Offers ******************************/
    if( $('#offerEntryForm').length>0 ) {

      $('#offerCancel').on('click', function(e){
        if(confirm("Are you sure. You want to close this page?") == true) {
          window.location.href = '/promo-offers/entry';
        } else {
          return false;
        }
        e.preventDefault();
      });

      $('#offerType').on('change', function(e){
        var offerType = $(this).val();
        $('#itemName, #discountOnProduct, #totalProducts, #freeProducts, #itemName, #discountOnProduct').val('');
        if(offerType === 'a') {
          $('#aContainer').show();
          $('#bContainer').hide();
          $('#cContainer').hide();
        } else if(offerType === 'b') {
          $('#aContainer').hide();
          $('#bContainer').show();
          $('#cContainer').hide();
        } else if(offerType === 'c') {
          $('#aContainer').hide();
          $('#bContainer').hide();
          $('#cContainer').show();
        } else {
          $('#aContainer').hide();
          $('#bContainer').hide();
          $('#cContainer').hide();          
        }
      });
    }
/*************************************** Inward Material Entry JS ************************************************/
    if( $('#inwardEntryForm').length>0 ) {

      $('#inwCancel').on('click', function(e){
        if(confirm("Are you sure. You want to close this page?") == true) {
          window.location.href = '/purchase/list';
        } else {
          return false;
        }
        e.preventDefault();
      });

      jQuery('.inwFreeQty').on("blur",function(e){
        var freeQty = parseFloat($(this).val());
        var idArray = $(this).attr('id').split('_');
        var rcvdId = '#inwRcvdQty_'+idArray[1];
        var rcvdQty = parseFloat($(rcvdId).val());
        if(isNaN(freeQty)) {
          freeQty = 0;
        }
        if(isNaN(rcvdQty)) {
          rcvdQty = 0;
        }

        if(freeQty>rcvdQty) {
          alert('Free Qty. must be less than or equal to Received Qty.');
          $('#inwFreeQty_'+idArray[1]).val(0);
          $('#inwBillQty_'+idArray[1]).val(rcvdQty)
        } else {
          $('#inwBillQty_'+idArray[1]).val((rcvdQty-freeQty));
          updateInwardItemAmount(idArray[1]);
          updateInwardItemsTotal();
        }
      });

      jQuery('.inwRcvdQty').on("blur",function(e){
        var rcvdQty = parseFloat($(this).val());
        var idArray = $(this).attr('id').split('_');
        var rowId = idArray[1];

        var freeId = '#inwFreeQty_'+idArray[1];
        var freeQty = parseFloat($(freeId).val());
        if(isNaN(freeQty)) {
          freeQty = 0;
        }
        if(isNaN(rcvdQty)) {
          rcvdQty = 0;
        }

        $('#inwBillQty_'+idArray[1]).val(rcvdQty-freeQty);

        updateInwardItemAmount(idArray[1]);
        updateInwardItemsTotal();
        updateInwardItemTaxAmount(rowId);
        updateInwardTaxAmounts();
      });

      jQuery('.inwItemRate').on("blur",function(){
        var taxAmount = 0;
        var idArray = $(this).attr('id').split('_');
        var rowId = idArray[1];
        updateInwardItemAmount(rowId);
        updateInwardItemsTotal();   
        updateInwardItemTaxAmount(rowId);
        updateInwardTaxAmounts();
      });

      jQuery('.inwItemTax').on("change", function(){
        var idArray = $(this).attr('id').split('_');
        var rowId = idArray[1];
        updateInwardItemTaxAmount(rowId, $(this).val());
        updateInwardTaxAmounts();
        updateInwardItemsTotal();
      });

      jQuery('.inwItemDiscount').on("blur", function(){
        var discountGiven = parseFloat($(this).val())
        if( !isNaN(discountGiven) ) {
          var idArray = $(this).attr('id').split('_');
          var rowId = idArray[1];
          var itemTotal = parseFloat($('#inwItemGrossAmount_'+rowId).val());
          var taxableAmount = parseFloat(itemTotal - discountGiven).toFixed(2);
          $('#inwItemAmount_'+rowId).val(taxableAmount);
          updateInwardItemTaxAmount(rowId);
          updateInwardTaxAmounts();
          updateInwardItemsTotal();
        }
      });

      jQuery('#inwAddlTaxes, #inwAdjustment, #inwShippingCharges').on("blur", function(){
        updateInwardItemsTotal();
      });      
    }
  /*************************************** End of Inward Material Entry JS ************************************************/

  if( $('#sendOtpBtn').length>0 ) {
    $('#sendOtpBtn').on('click', function(){
      sendOTP();
    });
    $('#submit-fp').on('click', function(e){
      var userId = $('#emailID').val();
      var otp = $('#pass-fp').val();
      var newPassword = $('#newpass-fp').val();
      if(userId === '' || otp === '' || newPassword === '') {
        alert('Userid, OTP and New password fields are mandatory to Reset your password.');
        $('#emailID').focus();
        return false;
      }
      /* hit server to reset the password */
      jQuery.ajax("/reset-password", {
        method:"POST",
        data: $('#forgotPassword').serialize(),
        success: function(response) {
          console.log(response);
          if(response.status===false) {
            alert(response.error);
            window.location.href = '/forgot-password';
          } else {
            alert('Password has been changed successfully.');
            window.location.href = '/login';
          }
        },
        error: function(e) {
          alert('Unable to reset password. Please try again.');
          window.location.href = '/forgot-password';
        }
      });

      e.preventDefault();
    });
  }

  if( $('#uploadInventory').length>0 ) {
    $('#uploadInventory').on('click', function(e){
      if($('#fileName').val().length) {
        $(this).attr('disabled', true);
        $('#invRefresh').attr('disabled', true);
        $('#reloadInfo').show();
        $('#frmInventoryUpload').submit();
      } else {
        alert('Please choose a file to upload.');
        return false;
      }
      e.preventDefault();
    });
  }
}

function sendOTP(fpType) {
  var userId = $('#emailID').val();
  var emailFilter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
  if(!emailFilter.test(userId)) {
    $('#emailID').focus();
    alert('Please enter a valid username.');
    return false;
  }

  /* hit server to get the OTP */
  jQuery.ajax("/send-otp", {
    method:"POST",
    data: $('#forgotPassword').serialize(),
    success: function(response) {
      if(response.status===false) {
        alert(response.errortext);
        return false;
      }
      if(response.status === true) {
        $('#success-msg-fp').show();
        $('#success-msg-fp').html(response.message);
        $('#pass-fp').attr('disabled', false);
        $('#submit-fp').attr('disabled', false);
        $('#newpass-fp').attr('disabled', false);
        $('#sendOtpBtn').attr('disabled', true);
        if(fpType==='resend') {
          alert('OTP has been resent successfully. Please use latest code to reset your password.');
        }
      } else {
        $('#error-msg-fp').show();
        $('#error-msg-fp').html(response.message);
        if(fpType==='resend') {
          alert('Unable to resend OTP.');
        }        
      }
    },
    error: function(e) {
      $('#emailID').focus();
      alert('An error occurred while processing your request.');
      return false;
    }
  });
}

function updateInwardItemAmount(rowId) {
  var itemRate = parseFloat($('#inwItemRate_'+rowId).val());
  var billedQty = parseFloat($('#inwBillQty_'+rowId).val());
  var itemAmount = 0;

  if(itemRate>0 && billedQty>0) {
    itemAmount = parseFloat(itemRate*billedQty);
    $('#inwItemAmount_'+rowId).val(itemAmount.toFixed(2));
    $('#inwItemGrossAmount_'+rowId).val(itemAmount.toFixed(2));    
  } else {
    $('#inwItemAmount_'+rowId).val('');
    $('#inwItemGrossAmount_'+rowId).val('');    
  }
}

function updateInwardItemTaxAmount(rowId, taxPercent) {
  var inwDiscountAmount = parseFloat($('#inwItemDiscount_'+rowId).val());
  if( isNaN(inwDiscountAmount) ) {
    inwDiscountAmount = 0;
  }

  var taxPercent = $('#inwItemTax_'+rowId).val();
  var itemValue = parseFloat($('#inwItemRate_'+rowId).val())*parseFloat($('#inwBillQty_'+rowId).val());
  var itemValueAfterDiscount = parseFloat(itemValue - inwDiscountAmount);
  var taxAmount = (itemValueAfterDiscount*taxPercent)/100;

  $('#inwItemTaxAmt_'+rowId).val(taxAmount);
  $('#inwItemTaxAmt_'+rowId).attr('data-rate', taxPercent);
}

function updateInwardItemsTotal(rowId) {
  var itemsTotal = billAmount = 0;
  var grandTotal = 0;
  var adjustments = 0;
  var netPay = 0;
  var roundedNetPay = 0;

  var adjustments = parseFloat($('#inwAdjustment').val());
  var shippingCharges = parseFloat($('#inwShippingCharges').val());

  jQuery('.inwItemAmount').each(function(i, obj) {
    iTotal = jQuery(this).val();
    if(parseFloat(iTotal)>0) {
      billAmount  += parseFloat(iTotal);
    }
  });

  grandTotal = billAmount + shippingCharges;

  // var inwItemDiscountVal = parseFloat($('#inwDiscountValue').text());
  // if(isNaN(inwItemDiscountVal)) {
  //   var finalAmount = billAmount;
  // } else {
  //   var finalAmount = billAmount-inwItemDiscountVal;
  // }

  if( parseFloat($('#inwAddlTaxes').val())>0 ) {
    var inwAddlTaxes = parseFloat($('#inwAddlTaxes').val());
  } else {
    var inwAddlTaxes = 0;
  }
  grandTotal += inwAddlTaxes;

  jQuery('.taxAmounts').each(function(i, obj) {
    iTotal = parseFloat(jQuery(this).text());
    if( iTotal > 0 ) {
      grandTotal  += parseFloat(iTotal);
    }
  });

  $('#inwItemsTotal').text(billAmount.toFixed(2));
  $('#inwTotalAmount').text(grandTotal.toFixed(2));

  if(isNaN(adjustments)) {
    adjustments = 0;
  }

  netPay = grandTotal + parseFloat(adjustments);
  roundedNetPay = Math.round(netPay);
  var finalAmount = netPay-parseFloat(roundedNetPay.toFixed(2));

  $('#roundOff').text(finalAmount.toFixed(2));
  $('#inwNetPay').text(roundedNetPay);
}

function updateInwardTaxAmounts() {
  var taxValues = [];
  jQuery('.taxPercents').each(function(i, obj) {
    var taxRate = $(this).val();
    var taxCode = $(this).attr('id');
    var totalTax = 0;
    $("input[data-rate='"+taxRate+"']").each(function(i, obj){
      if(parseFloat($(this).val())>0 ) {
        totalTax = parseFloat(totalTax) + parseFloat($(this).val());
      }
    });

    $("#taxAmount_"+taxCode).text(totalTax.toFixed(2));
  });
}

jQuery(document).ready(function(){
  initializeJS();
  if($('#dbContainer').length>0) {  
    monthWiseSales();
    monthWiseSalesReturns();
  }
});

function printSalesBill(bill_no) {
  var printUrl = '/print-sales-bill?billNo='+bill_no;
  window.open(printUrl, "_blank", "scrollbars=yes,titlebar=yes,resizable=yes,width=400,height=400");
}

function printSalesBillSmall(bill_no) {
  var printUrl = '/print-sales-bill-small?billNo='+bill_no;
  window.open(printUrl, "_blank", "scrollbars=yes,titlebar=yes,resizable=yes,width=400,height=400");
}

function printSalesBillGST(bill_no) {
  var printUrl = '/print-sales-bill-gst?billNo='+bill_no;
  window.open(printUrl, "_blank", "scrollbars=yes,titlebar=yes,resizable=yes,width=400,height=400");
}

function printGrn(grnCode) {
  var printUrl = '/print-grn/'+grnCode;
  window.open(printUrl,"_blank","scrollbars=yes,titlebar=yes,resizable=yes,width=400,height=400");
}

function printSalesReturnBill(returnCode) {
  var printUrl = '/print-sales-return-bill?returnCode='+returnCode;
  window.open(printUrl, "_blank", "scrollbars=yes, titlebar=yes, resizable=yes, width=400, height=400");
}

function resetFilter(url) {
  if(url !== '') {
    window.location.href=url;
  }
}

function monthWiseSales() {
  var sgfMonth = $('#saleMonth').val();
  var sgfYear = $('#saleYear').val();
  var saleDate = []
  var saleAmounts = [];
  jQuery.ajax("/async/monthly-sales?saleMonth="+sgfMonth+'&saleYear='+sgfYear, {
    method:"GET",
    success: function(apiResponse) {
      if(apiResponse.status==='success') {
        jQuery.each(apiResponse.response.daywiseSales, function (index, saleDetails) {
          var dateFormat = new Date(saleDetails.tranDate+'T12:00:30z');
          var amount = (
                          parseInt(saleDetails.cardSales)+
                          parseInt(saleDetails.cashSales)+
                          parseInt(saleDetails.creditSales)
                        );
          saleDate.push(dateFormat.getDate());
          saleAmounts.push(amount);
        });
      }

      $('#salesGraph').empty();
      $('#salesGraph').jqplot([saleAmounts,saleDate], {
        title:'',
        seriesDefaults:{
          showMarker: true,
          renderer:$.jqplot.BarRenderer,
          pointLabels:{
           show:true
          },
          rendererOptions: {
            varyBarColor: true
          },          
          showLine: true
        },
        axes:{
          xaxis:{
            renderer: $.jqplot.CategoryAxisRenderer,
            ticks: []
          },
          yaxis: {
            showTicks: true,
          }
        },
        grid: {
          drawBorder: false,
          shadow: false
        },
        /*
        legend: {
          show: true,
          location: 'n', 
          placement: 'outside',          
        }*/
      });      
    },
    error: function(e) {
      alert('An error occurred while loading Monthwise Sales');
    }
  });
}

function monthWiseSalesReturns() {
  var sgfMonth = $('#saleMonth').val();
  var sgfYear = $('#saleYear').val();
  var saleDate = []
  var returnAmounts = [];
  jQuery.ajax("/async/monthly-sales?saleMonth="+sgfMonth+'&saleYear='+sgfYear, {
    method:"GET",
    success: function(apiResponse) {
      if(apiResponse.status==='success') {
        jQuery.each(apiResponse.response.daywiseSales, function (index, saleDetails) {
          var dateFormat = new Date(saleDetails.tranDate+'T12:00:30z');
          saleDate.push(dateFormat.getDate());
          returnAmounts.push(parseInt(saleDetails.returnamount));
        });
      }
      $('#sreturnsGraph').jqplot([saleDate,returnAmounts], {
        title:'',
        // Provide a custom seriesColors array to override the default colors.
        // seriesColors:['#85802b', '#00749F', '#73C774', '#C7754C', '#17BDB8'],
        seriesDefaults:{
          showMarker: true,
          renderer:$.jqplot.BarRenderer,
          rendererOptions: {
            varyBarColor: true
          }
        },
        axes:{
          xaxis:{
            renderer: $.jqplot.CategoryAxisRenderer,
            tickOptions:{
              showGridline: true
            }
          }       
        },
        grid: {
          drawBorder: true,
          shadow: false
        }
      });      
    },
    error: function(e) {
      alert('An error occurred while loading Monthwise Sales Returns');
    }
  });
}