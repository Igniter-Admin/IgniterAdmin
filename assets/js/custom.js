$(document).ready(function() {

  $('body').on('click', '.mka_image_preview', function() {
    $('#mka_image_preview_modal').modal('show');
    $('#img01').attr('src', $(this).attr('src'));
  });

  // $('body').on('click', '.mka-copy', function() {
  //   $o = $(this);
  //   $o.addClass('copy');
  //   setTimeout(function() {
  //     $o.removeClass('copy');
  //   }, 900);
  // });
  // var clipboard = new Clipboard('.mka-copy');

  $('body').on('change', '.check_box', function() {
    $obj = $(this);
    if($obj.hasClass('required')){
      if($obj.is(":checked")){
        $obj.parents('.form-group').find('.check_box').prop('required', false);
      } else {
        $chk = 'yes';
        $obj.parents('.form-group').find('.check_box').each(function() {
          if($(this).is(":checked")) {
            $chk = 'no';
          }
        })
        if($chk == 'yes'){
          $obj.parents('.form-group').find(".check_box").prop('required', true);    
        }
        
      }
    }
  });
	
	/*$.validate({
	    modules : 'location, date, security, file',
	    onModulesLoaded : function() {
	      $('#country').suggestCountry();
	    }
  	});*/

    setTimeout(function() {
      $("#successMessage").hide('blind', {}, 500)
    }, 7000);


  	$('.cancel').on('click', function() {
  		window.location.href=$(this).attr('rel');
  	})

  	$('.selAll').on('click', function () {
  		$obj = $(this);
  		if($obj.is(':checked')){
  			$obj.parents('thead').siblings('tbody').find('input[name="selData"]').prop('checked', true);;
  		} else {
  			$obj.parents('thead').siblings('tbody').find('input[name="selData"]').removeAttr('checked');
  		}
  	});


    $('.sell_all').on('click', function() {
      $obj = $(this);
      if($obj.is(':checked')){
        $obj.parents('tr').first().find('input[type="checkbox"]').prop('checked', true);
      } else {
        $obj.parents('tr').first().find('input[type="checkbox"]').prop('checked', false);
      }
    });

    $('body').on('click', '.delSelected', function() {
      $obj = $(this);
      $tabClass = $obj.attr('rel');
      $base_url = $obj.attr('data-del-url');
      $arr = [];
      $('#cnfrm_delete').find('.modal-body').find('input[name="ids"]').remove();
      $('table.' + $tabClass).find('tbody').find('input[name="selData"]').each(function() {
        $inpObj = $(this);
        if($inpObj.is(':checked')){
          $arr.push($inpObj.val());
        }
      });
      if($arr.length > 0) {
        $('#cnfrm_delete').find('.yes-btn').attr('href', $base_url + $arr.join('-'));
        $('#cnfrm_delete').modal('show');
      } else {
        showNotification('Nothing is seleted to delete', 'danger');
      }
    });

  /* Script for profile page start here */

  $("#fileUpload").on('change', function () {
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#image-holder");
      image_holder.empty();
      var reader = new FileReader();
      reader.onload = function (e) {
        $("<img />", {
          "src": e.target.result,
          "class": "thumb-image setpropileam"
        }).appendTo(image_holder);
      }
      image_holder.show();
      reader.readAsDataURL($(this)[0].files[0]);
    } else {
      alert("This browser does not support FileReader.");
    }
  });


  $('#profileSubmit').on('click', function() {
    $res = 1;
    $('div.form-group').each(function() {
      if($(this).hasClass('has-error')){
        $res = 0;
      }
    });
    if($res == 1) {
      $('form').submit();
    }
  })

  $('#profileEmail').bind('change keyup', function() {
    $obj = $(this);
    $obj.parents('div.form-group')
        .removeClass('has-error')
        .find('span.text-red').remove();
    var email = $obj.val();
    var uId = $('[name="id"]').val();
    $.ajax({
      url:  $('body').attr('data-base-url') + 'user/checEmailExist',
      method:'post',
      data:{
        email :email,
        uId : uId
      }
    }).done(function(data) {
      if(data == 0) {
        $obj
        .after('<span class="text-red">This Email Already Exist...</span>')
        .parents('div.form-group')
        .addClass('has-error');
      }
      console.log(data);
    })
  })

  /* Script for profile page End here */

  /* Script for user page start here */
   $('.InviteUser').on('click', function() {
    $('#nameModal_user').find('.box-title').text('Invite People');
    $('#nameModal_user').find('.modal-body').html('<div class="row">'+
        '<div class="col-md-12 m-t-20 form-horizontal">'+
          '<div class="form-group form-float">'+
            '<div class="form-line">'+
              '<textarea name="emails" id="" rows="5" class="form-control"></textarea>'+
              '<label for="sEmail" class="form-label">Enter Email Address</label>'+
            '</div>'+ 
            '<span class="help-text">Enter Valid Emails Saperated by comma (,)</span>'+   
          '</div>'+
          '<p>'+
            '<button class="btn btn-primary pull-right send-btn">Send</button>'+
          '</p>'+
        '</div>'+
      '</div>');
    $('#nameModal_user').modal('show');
    $.AdminBSB.input.activate();
  });

  $('.modal-body').on('click', '.send-btn', function() {
    $obj = $(this);
    $obj.html('<i class="fa fa-cog fa-spin"></i> Send');
    $obj.parents('div.row').find('.msg-div').remove();
    $emails = $obj.parents('.modal-body').find('textarea').val();
    if($emails != ''){
      $.ajax({
        url: $('body').attr('data-base-url') + 'user/InvitePeople',
        method:'post',
        data: {
          emails: $emails
        },
        dataType: 'json'
      }).done(function(data){
        console.log(data);
        if(data) {
          var part = '';
          if(data.noTemplate != 0){
            part = '<p><strong>Info:</strong> '+data.noTemplate+'</p>';
          }
          $obj.parents('div.row').prepend('<div class="col-md-12 m-t-20 msg-div"><div class="alert alert-info" role="alert">'+
                                  '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>'+
                                  '<div class="msg-p">'+
                                  '<p><strong>Success:</strong> '+data.seccessCount+' Invitation Sent successfully</p>'+
                                  '<p><strong>Info:</strong> '+data.existCount+' Emails Already present in database</p>'+
                                  '<p><strong>Info:</strong> '+data.invalidEmailCount+' Invalid Emails Found</p>'+part+
                                  '</div>'+
                                  '</div>'+
                                '</div>');
          $obj.html('Send');
        }
      });            
    } else {
      alert('Enter Email First');
    }
  });   

  $(".content").on("click",".modalButtonUser", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'user/getModal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_user').find('.modal-body').html(data);
      $('#nameModal_user').modal('show'); 
    })
  });

/*  $("#nameModal_user").on("hidden.bs.modal", function(){
    $(this).find("iframe").html("");
    $(this).find("iframe").attr("src", "");
    });*/
  /* Script for user page end here */

  /* Script for Templates Starts here */
    $('body').on('click', '.view_template', function() {
      $obj = $(this);
      $tmp_id = $obj.attr('data-src');
      $.ajax({
        url: $('body').attr('data-base-url') + "templates/preview",
        method:'post',
        data:{
          template_id: $tmp_id
        }
      }).done(function(data) {
        $('#previewModal').find('div.modal-body').html(data);
        $('#previewModal').modal('show');
        $('#previewModal').find('a').attr('href', 'javascript:;');
      });
    });

  $("body").on("click",".templateModalButton", function(e) {  
    $.ajax({
      url : $('body').attr('data-base-url') + "templates/modalForm",
      method: "post", 
      data : {
      id: $(this).attr("data-src")
      }
      }).done(function(data) {
      $("#nameModal_Templates").find(".modal-body").html(data);
      $("#nameModal_Templates").modal("show"); 
    })
  });
  /* Script for Templates End here */

  $('.chk_update, .chk_delete, .chk_create').on('click', function() {
    $obj = $(this);
    if($obj.is(':checked')){
      $obj.parents('tr'). find('.chk_read').prop('checked', 'checked');
    }
  });

  $('.chk_read').on('click', function(){
    $obj = $(this);
    if(!$obj.is(':checked')) {
      $t = $obj.parents('tr');
      if($t.find('.chk_update').is(':checked') || $t.find('.chk_delete').is(':checked') || $t.find('.chk_create').is(':checked')) {
        return false;
      }
    }
  });

  $('body').on('click', 'i.remove_old', function() {
  if (confirm("Do you want to delete this File?")) {
      var check_old = $(this).parents('.form-group').find(":input.check_old").length;
      var check_required = $(this).parents('.form-group').find(":input.check_new").attr('data');
      if(check_old == 1){ 
        if(check_required == 'required'){
            var check_new = $(this).parents('.form-group').find(":input.check_new").attr('required','required');
        }
        $(this).parents('.wpb_old_files').remove();
      }else{
        $(this).parents('.wpb_old_files').remove();
      }
  }
});

/*  $('body').on('click','.btn-blk-del', function() {
    $obj = $(this);
    $ids = '';
    $('[name="selData"]').each(function(){
      if($(this).is(':checked')){
        $ids += $(this).val() + '-';
      }
    })
    if($ids != ''){
      $ids = $ids.slice(0, -1);
      $('#cnfrm_delete').find('.yes-btn').attr('href', $obj.attr('data-del-url') + $ids)
      $('#cnfrm_delete').modal('show');
    } else {
      alert('Nothig is seleted to delete...');
    }
  });*/

  $('body').on('click', 'ul.demo-choose-skin li', function(){
    setTheme($(this));
  });

  /*setTimeout(function() {
    setBtnColor();
  }, 300);*/

/*$('.datepicker').datepicker();*/

  $('body').on('click', '.rm-logo-img', function () {
    $the = $(this);
    /*$the.parents('form').find('div.pic_size').html('<span>No Logo</span>');
    $('input[name="fileOldlogo"]').val('');*/
    $img = $('body').attr('data-base-url');
    $img = $img.split('index.php');
    $img = $img[0] + '/assets/images/logo.png';
    $('img.setpropileam').attr('src', $img)
    $('input[name="fileOldlogo"]').val('logo.png');
  });




  $('.ad-u-type-btn').on('click', function() {
    $obj = $(this);
    $ia_obj = $('.ia_user_role_div');
    $ohtml = $ia_obj.find('div.row').first().clone();
    $ohtml.find('span.role-span').addClass('blind');
    $ohtml.find('div.form-line').removeClass('blind');
    $ohtml.find('button.btn').addClass('rm-u-type-btn');
    $ohtml.find('input.inp-field').val('')
    .attr('data-old-id', 'new')
    .attr('name', "new_user_name[]")
    .focus();

    $ia_obj.prepend($ohtml);
    console.log('html->',$ohtml);
    $.AdminBSB.input.activate();
  });

  $('.ia-edit-btn').on('click', function() {
    $obj = $(this);
    $('.ia_user_role_div').find('span.role-span').removeClass('blind')
    $('.ia_user_role_div').find('div.form-line').addClass('blind')
    $obj.parents('.row').first().find('span.role-span').addClass('blind');
    $obj.parents('.row').first().find('div.form-line').removeClass('blind').find('input').focus();
  });

  $('.ia-sel-role').on('click',  function() {
    $('.ia-sel-role').removeClass('active');
    $('.ia-permisssion-div').addClass('blind');
    $obj = $(this);
    $obj.addClass('active');
    $('.ia-permission-' + $obj.attr('rel')).removeClass('blind');
  });


  $('body').on('click', '.rm-u-type-btn', function() {
    $(this).parents('.form-group').after('<input type="hidden" name="rm_user_type[]" value="'+ $(this).parents('.row').first().find('input.inp-field').attr('data-old-id') +'">');
    $(this).parents('.row').first().remove();
  });

  $('body').on('click', '.ia-sel-image', function () {
    $('input#logoSite').trigger('click');
  });


  $("body").on('change', '#logoSite', function () {
    if (typeof (FileReader) != "undefined") {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('img.setpropileam').attr('src',  e.target.result );
      }
      reader.readAsDataURL($(this)[0].files[0]); } else { alert("<?php echo lang('this_browser_does_not_support_fileReader'); ?>."); }
  });


  $('li#system_update').on('click', function() {
    $('#system-update-setting').html('<div class="text-center m-t-30"> <img src="../../assets/images/widget-loader-lg.gif" alt="Loading..."> </div>');

    $.post( $('body').attr('data-base-url') + 'setting/getUpdateHtml', function( data ) {
      $('#system-update-setting').html(data);
    });
  });
  
});

function setId(id, module) {
  var url =  $('body').attr('data-base-url');
  $("#cnfrm_delete").find("a.yes-btn").attr("href",url+"/"+ module +"/delete/"+id);
}

function setDeleteId(id, module) {
  var url =  $('body').attr('data-base-url');
  $("#cnfrm_delete").find("a.yes-btn").attr("href",url+"/"+ module +"/"+id);
}

function resizeIframe(obj) { 
  obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
}

function setTheme(obj) {
  var url = $('body').attr('data-base-url');
  url = url+'setting/setThemeColorCookie';

  var theme = obj.attr('data-theme');
  var theme_color = 'theme-'+theme;

  $.ajax({
      url:  url,
      method:'post',
      data:{
        theme_color :theme_color
      }
    }).done(function(data) {
      if(data == 1) {
        $('body').removeClass();
        $('body').addClass(theme_color);
        /*setTimeout(function() {
          setBtnColor();
        }, 300);*/
    }
  });
}

function showNotification(text, type) {
    if (type === null || type === '') { type = 'success'; }
    if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
    //if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
    //if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
    var allowDismiss = true;

    $.notify({
        message: text
    },
        {
            type: 'alert-' + type,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 1000,
            placement: {
                from: 'top',
                align: 'right'
            },
            animate: {
                enter: 'animated zoomInRight',
                exit: 'animated zoomOutRight'
            },
            template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
}


var get_grid_info_box_val = function($controller) {
  if($('.mka-num').length > 0) {
    $request = {};
    $('.mka-num').each(function(k, v) {
      $o = $(this);
      $request[k]                   = {};
      $request[k]['action']         = $o.attr('data-action');
      $request[k]['table']          = $o.attr('data-table');
      $request[k]['con_field']      = $o.attr('data-c-fields');
      $request[k]['con_operator']   = $o.attr('data-c-operators');
      $request[k]['con_value']      = $o.attr('data-c-values');
      $request[k]['return_id']      = $o.attr('id');
      $request[k]['sum_field']      = $o.attr('data-sum-field');
      $request[k]['relation']       = $o.attr('data-relation');
      $request[k]['relation_table'] = $o.attr('data-relation-table');
      $request[k]['relation_from']  = $o.attr('data-relation-from');
      $request[k]['relation_where'] = $o.attr('data-relation-where');
    })
    $request_filter = {};
    $('select.filter-field, input.filter-field').each(function(k, v) {
      $request_filter[$(this).attr('name')] = $(this).val();
    });
    $.ajax({
      url: $('body').attr('data-base-url') + $controller + '/get_grid_info_box_val',
      type: 'GET',
      dataType: 'json',
      data: {request: $request, request_filter : $request_filter},
    }).done(function(data) {
      $.each(data, function(i, item) {
        $('#' + i).text(item);
      });
    });
    
  }
}

function validate_fileType(fileName,Nameid,arrayValu)
{
  var string = arrayValu;
  var tempArray = new Array();
  var tempArray = string.split(',');          
  var allowed_extensions =tempArray;
  var file_extension = fileName.split(".").pop(); 
  for(var i = 0; i <= allowed_extensions.length; i++)
  {
    if(allowed_extensions[i]==file_extension)
    { 
      $("#error_"+Nameid).html("");
      return true; // valid file extension
    }
  }
  $("#"+Nameid).val("");
  $("#error_"+Nameid).css("color","red").html("File format not support to upload");
  return false;
}

function chkLatestVersion(ia_back) {
  getLatestVersion(function(data) {
    if(data.latest_version > data.current_version) {
      getNotificationHtml(data)
      $('.navbar').find('.badge.bg-danger').text('1');
    }
  });
}

function getNotificationHtml(data){
  $.post( $('body').attr('data-base-url') + 'setting/getNotificationHtml', { "update_info" : data }, function( data ) {
      $('.notifications-wrapper').find('div.dropdown-menu').html(data);
  });
}

function getLatestVersion(ia_back) {
  getCurrentVersion(function(data) {
    if(data.action) {
      $.post( 'http://igniteradmin.com/version/', { "update_info" : true, "current_version" : data  }, function( ndata ) {
        ndata = jQuery.parseJSON( ndata );
        ndata.current_version = data.ia_data; 
        ia_back(ndata);
      });
    } else if(data.ia_data != '0') {
      //console.log(data);
      if(data.ia_data.latest_version > data.ia_data.current_version) {
        getNotificationHtml(data.ia_data);
        $('.navbar').find('.badge.bg-danger').text('1');
      }
    }
  });
}

function getCurrentVersion(ia_back) {
  $.post( $('body').attr('data-base-url') + 'setting/getCurrentVersion', function( data ) {
    if(data != 0) {
      ia_back(data); 
    }
  }, 'json');
}