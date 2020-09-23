
var nonce = jQuery('#mesajkolik_nonce').val();
var nonceserialize = "";
jQuery(function() {
  nonce = jQuery('#mesajkolik_nonce').val();
  nonceserialize = "&mesajkolik_nonce="+nonce;
  //başlangıçta tüm switchlerin valueleri arraya yükleniyor
  jQuery('.user-select-bulk').each(function() {
    pushToggle( jQuery.trim(jQuery(this).val()) );
  });

  // - LABEL
  jQuery('.mesajkolik_label').on('click', function() {
    var data = jQuery(this).parent().parent().attr('data-id');
    var val = jQuery('#pills-auto-sms div[data-id="' + data + '"] textarea').val();
    jQuery('#pills-auto-sms div[data-id="' + data + '"] textarea').val(val + ' ' + jQuery(this).html());
  });

  jQuery('.mesajkolik_label_bulk').on('click', function() {
    var data = jQuery(this).parent().parent().attr('data-id');
    var val = jQuery('#parent-modal-bulk textarea').val();
    jQuery('#parent-modal-bulk textarea').val(val + ' ' + jQuery(this).html());

  });

  // - SWITCH
  jQuery('.mesajkolik_check').on('change', function() {
    var data = jQuery(this).parent().parent().attr('data-id');
    if (jQuery(this).is(':checked')) {
      jQuery('div.mesajkolik_option[data-id="' + jQuery(this).attr('data-id') + '"]').fadeIn();
    } else {
      jQuery('div.mesajkolik_option[data-id="' + jQuery(this).attr('data-id') + '"]').fadeOut();
    }
  });

  //Datatables
  jQuery('#users-bulk-table').DataTable({
    stateSave: true,
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [0, 1, 2, 3]
    }],
    "paging": false,
    "ordering": false,
    "info": false
  });

  jQuery('#users-bulk-table').on('click', '.toggle-group', function(){
      // ... skipped ...
  });

  //Select All Toggle
  var change = false;
  jQuery('#toggle-select-all-users').change(function() {
    if (!change) {
      change = true;
      var allTog = jQuery(this).is(':checked') ? true : false;
      jQuery('.user-select-bulk').bootstrapToggle(jQuery(this).is(':checked') ? 'on' : 'off');
      jQuery('.user-select-bulk').each(function() {
        allTog ? pushToggle( jQuery.trim(jQuery(this).val()) ) : unPushToggle( jQuery.trim(jQuery(this).val()) );
      });
      change = false;
    }
  });
  //Select User Toggle
  jQuery('.user-select-bulk').on('change', function() {
    if (!change) {
      change = true;
      jQuery(this).is(':checked') ? pushToggle( jQuery.trim(jQuery(this).val()) ) : unPushToggle( jQuery.trim(jQuery(this).val()) );
      var checked = jQuery('.user-select-bulk').length == jQuery('.user-select-bulk:checked').length;
      if (jQuery('#toggle-select-all-users').is(':checked') != checked) {
        jQuery('#toggle-select-all-users').bootstrapToggle(checked ? 'on' : 'off');
      }
      change = false;
    }
  });
  jQuery('.mesajkolik_check').change(function() {
    var checked = jQuery(this).prop('checked') ? '1' : '0';
    jQuery(this).val(checked);
  })


  jQuery('#mesajkolik_status').change(function() {
    var stat = jQuery(this).prop('checked') ? '1' : '0';
    mesajkolik_alert_responser(true);
    jQuery.post(ajaxurl, {action: 'mesajkolik_status_change',mesajkolik_status: stat,mesajkolik_nonce:nonce}, function(data){
      console.log(data);
      mesajkolik_alert_responser(false);
    });
  });

  // - CLICK EVENTS
  jQuery("#form-sms-bulk").on('submit', function(e) {
    e.preventDefault();
    mesajkolik_alert_responser(true);
    jQuery.post(ajaxurl, jQuery(this).serialize()+nonceserialize, function(data){
      data = JSON.parse(data);
      mesajkolik_alert_responser(false);
      if(data.result){
        mesajkolik_alert('SMS Gönderimi Başarılı !', true);
        jQuery(this).trigger('reset');
      }else{
        mesajkolik_alert(data.message, false);
      }
    });
  });

  // - FORM EVENTS
  jQuery('#form-auto-sms').on('submit', function(e){
    e.preventDefault();
    var cont=true;
    jQuery('form#form-auto-sms input').each(function() {
      if (jQuery.trim(jQuery(this).val()) == '') {
        cont = false;
        mesajkolik_alert('Lütfen Tüm Alanları Doldurunuz', false);
      }
    });
    if (cont) {
      mesajkolik_alert_responser(true);
      jQuery.post(ajaxurl, jQuery(this).serialize()+nonceserialize, function(data){
        console.log(data);
        data = JSON.parse(data);
        mesajkolik_alert_responser(false);
        if(data.result){
          mesajkolik_alert('Ayarlarınız Başarıyla Kayıt Edildi', true);
        }else{
          mesajkolik_alert(data.message, false);
        }
      });
    }
  });

  jQuery("#form-group-name").on('submit', function(e) {
    e.preventDefault();
    mesajkolik_alert_responser(true);
    jQuery.post(ajaxurl, jQuery(this).serialize()+nonceserialize, function(data){
      mesajkolik_alert_responser(false);
      data = JSON.parse(data);
      mesajkolik_alert(data.message, data.result);
      if(data.result) jQuery(this).trigger('reset');
    });
  });

  jQuery('.form_private_sms').on('submit', function(e){
    e.preventDefault();
    mesajkolik_alert_responser(true);
    jQuery.post(ajaxurl, jQuery(this).serialize()+nonceserialize, function(data){
      data = JSON.parse(data);
      mesajkolik_alert_responser(false);
      if(data.result){
        mesajkolik_alert('SMS Gönderimi Başarılı !', true);
        jQuery(this).trigger('reset');
      }else{
        mesajkolik_alert('SMS Gönderiminde Bir<br> Problem Oluştu.', false);
      }
    });
  });


  // - BULK SMS MODAL
  jQuery('#bulkPrivateSmsModal').on('show.bs.modal', function (event) {
    var allselected = jQuery("#form-sms-bulk").serializeArray();
    var send = [];
    allselected = jQuery.each(allselected, function(i, field){
        send.push(field.value);
    });
    var button = jQuery(event.relatedTarget)
    var phone = button.data('phone')
    var modal = jQuery(this)
    if (phone == '0') {
      modal.find('.modal-body #recipient-name').val(selectedtoggle)
    }else {
      modal.find('.modal-body #recipient-name').val(phone)
    }
  });

});


// - ALERT EVENTS
function mesajkolik_alert(text, success){
  jQuery('#alert-modal-mesajkolik .mesajkolik_alert_success').hide();
  jQuery('#alert-modal-mesajkolik .mesajkolik_alert_danger').hide();
  if(success !== undefined){
    jQuery('#alert-modal-mesajkolik .mesajkolik_alert_'+(success ? 'success' : 'danger')).show();
  }
  jQuery('#alert-modal-desc').html(text);
  jQuery('#alert-modal').modal('show');
}

function mesajkolik_alert_responser(e){
  var stat = e ? 'show' : 'hide';
  jQuery('#modal-responser').modal({backdrop: 'static', keyboard: false});
  jQuery('#modal-responser').modal(stat);
}

function afterBulkSms(){
  jQuery('#toggle-select-all-users ,.user-select-bulk').bootstrapToggle('on');
}

var selectedtoggle=[];
function pushToggle(e){
  if (!selectedtoggle.includes(e)) {
    selectedtoggle.push(e);
  }

}
function unPushToggle(e){
  if (selectedtoggle.includes(e)) {
    var index = selectedtoggle.indexOf(e);
    selectedtoggle.splice(index, 1);
  }
}
