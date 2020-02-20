
//var kk = jQuery.noConflict();

var jq = $.noConflict();
(function($){
$(document).ready( function () {
  var site_urls = $("#txtsite_url").val();
  var txtpage_name = $("#txtpage_name").val();
  //resize_me();
  $('.cmd_trigger').trigger('click');

  if($(window).width() < 760){ // mobile
    $('.navbar-static-side').hide();
  }else{
    $('.navbar-static-side').show();
  }

  
  $.ajax({
      type : "POST",
      url : site_urls+"node/storeLocs1",
      cache : false,
      dataType: 'json',
      success : function(data){
      }
    });

  $(".mm_menu li.menu-item a font").css('font-size', '16.8px');


  var txtcounts = $("#txtcounts").val();  
  if(txtcounts<=15){
    $('.load_more_bt').hide();
    $('#load_more_mba1').html('<font style="color:#999 !important;">No more records!</font>').show();
  }

  
  var elems = $('.ks-cboxtags input:checkbox');

  $('body').on('change', elems, function () {
    var allVals = [];
    var allIDS = [];
    $('.ks-cboxtags :checked').each(function(i) {    
      allVals.push((i!=0?"\r\n":"")+ " " + $(this).val());
      allIDS.push((i!=0?"\r\n":"")+ " " + $(this).attr('id1'));
    });
    $('.selected_subjs').val(allVals).attr('rows', allVals.length);
    $('.selected_subjs_ids').val(allIDS).attr('rows', allIDS.length);
    if(allVals!="")
      $('.selecteds').html("<b>Selected:</b> "+$('.selected_subjs').val()).show(); 
    else
      $('.selecteds').html("").hide(); 
  });



  $(window).on('resize', function(){
    //resize_me();
    $('.cmd_trigger').trigger('click');

  });


  $('body').on('click', '.add_questns span', function () {
    var ids = $(this).attr("sess");
    window.location = site_urls+"admin/upload_questions/"+ids+"/new/";
    //http://localhost/exams_real2/admin/edit_questions/37693cfc748049e45d87b8c7d8b9aacd/145544/
  });

  
  $('body').on('click', '.cmd_done_home', function () {
    window.location = site_urls;
  });

  


  $('body').on('click', '.expose_tbl', function (e) {
    e.stopPropagation();
    var ids = $(this).attr('ids');
    $('.show_answer').slideUp('fast');
    $('#show_answer'+ids).slideDown('fast');
  });

  

  $('body').on('click', '.navbar_toggle', function (e) {
    e.stopPropagation();
    $('.navbar-static-side').slideToggle('fast');
  });


  $('body').on('click', '.navbar-static-side', function (e) {
    e.stopPropagation();
    $('.navbar-static-side').show();
  });

  

  $('body').on('click', '.download_file', function () {
    var ids = $(this).attr('ids');
    var files = $(this).attr('files');
    $('#download_file'+ids).html('Downloading...');
    window.location = site_urls+"resourcesfiles/"+files;
    setTimeout(function(){
      $('#download_file'+ids).html('<b>Download file</b>');
    },1000);
  });


  //$('.basic_uploader').live("click",function(e){
  $('body').on('click', '.basic_uploader', function (e) {
    $('.basic_uploader').hide();
    $('#txt_bma_pic').show();
    $('#hide_basic_uploader').show();
  });


  //$('#hide_basic_uploader').live("click",function(e){
  $('body').on('click', '#hide_basic_uploader', function (e) {
    $('#hide_basic_uploader').hide();
    $('#txt_bma_pic').hide();
    $('.basic_uploader').show();
  });


  $('body').on('click', '#im1_bma', function (e) {
    $("#txt_bma_pic").click();
  });



  $('body').on('click', '#img_prev1_bma span', function (e) {    
    var srcs = $('#im1_bma').attr('src1');
    $("#txtlogo_bma").replaceWith('<input type="file" name="txt_bma_pic" id="txt_bma_pic" style="padding:4px; font-size:13px; display:none" />');
    $("#img_prev1_bma").html("<span>remove</span><img src='"+srcs+"' src1='"+srcs+"' id='im1_bma'>");
    $("#ad_logo_check1_up_bma").val(0);
    $(this).hide();
  });




  $('body').on('change', '#txt_bma_pic', function (e) {    
    var imgg = $("#im1_bma");
    var img_prev = $("#img_prev1_bma");
    var fls = $("#txt_bma_pic").val();
    var fileExtension = ['jpeg', 'jpg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
    alert("Formats allowed are : "+fileExtension.join(', '));
    $("#txt_bma_pic").val('');
    return false;
    }
    if(fls!=""){
    $(img_prev).show();
    readURL(this, imgg);
    //$("#img_prev1 span").show();
    $("#ad_logo_check1_bma").val(1);
    }else if(fls.length <= 1){
    $(imgg).hide();
    }
  });


  function readURL(input, idf){
    if(input.files && input.files[0]){
      var reader = new FileReader();
      reader.onload=function(e){
      $(idf).attr('src',e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    }
  }


  
  
  $('body').on('click', '.cmd_trigger', function () {
  //function resize_me(){
    var txtpage_name = $("#txtpage_name").val();
    if(txtpage_name == "tests"){
      var started_val = $('.started_text_value').val();
      if($(window).width() < 760){ // mobile
        if(started_val==1){
          $('.div_contents').hide();
          $('.myheaders_mobile').hide();
          $('.quiz_details').show();
        }else{
          $('.myheaders_mobile').show();
        }
      }else{
        //alert(started_val)
        $('.div_contents').show();
        //$('.myheaders').show();
        $('.myheaders_mobile').hide();
        $('.quiz_details').hide();
      }
    }
  });




  $(".uploadimage2_bma").on('submit',(function(e) {
    e.preventDefault();
    //var txtmember = $('#txtmember').val();
    $(".alert_msg2").hide();
    $('#cmd_update_profile_user').attr('disabled', true).css({'opacity': '0.7', 'color': '#ccc'}).val('Updating...');

    $.ajax({
      type : "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      url : site_urls+"node/upload_profile",
      success : function(data){
        //alert(data)
        if(data.trim() == 'done_2'){
          $(".alert_msg2").fadeIn('fast').html('<div class="Errormsg">Your Account has Been Updated</div>').removeClass('alert-danger').addClass('alert-success');

        }else{
          $(".alert_msg2").show().html('<div class="Errormsg">'+data+'</div>').removeClass('alert-success').addClass('alert-danger');
        }

        setTimeout(function(){
          $('.alert_msg2').hide();
        },3000);

        $('#cmd_update_profile_user').removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val('Update Your Profile');

      },error : function(data){
        $('#cmd_update_profile_user').removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val('Update Your Profile');
        $(".alert_msg2").show().html('<div class="Errormsg">Poor Network Connection!</div>').removeClass('alert-success').addClass('alert-danger');
      }
    });
  }));
  



  $(".uploadimage1_forum").on('submit',(function(e) {
    e.preventDefault();
    $(".errs").hide();
    
    var counters = retrieve_cookie('counters');
    var selecteds1 = retrieve_cookie('selected_file1');
    var edit_ids = $('#edit_ids').val();
    if($('#post_content').val() != '' || selecteds1 == 1){
        $('#cmdPosts').attr('disabled', true).css({'opacity': '0.5'});
        $(".hide_txtbox").fadeIn('fast');
        $.ajax({
            url : site_urls+"node/post_comments_forum",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              if(data=="inserted" || data=="updateds"){
                bringProducts(edit_ids);

                setTimeout(function(){
                    $("#form2")[0].reset();
                    $('.txtselectcat').fadeOut('fast');
                    $('.textareas').slideUp('fast');
                    $('#txt_srch_forum1').hide();
                    $('.clickforum').show();

                    $('#cmdPosts').removeAttr('disabled').css({'opacity': '1'});
                },200);

                create_cookie('selected_file1', 0);
                $('#selectedCaption1').empty().html('No file selected');
                setTimeout(function(){
                    $(".hide_txtbox").fadeOut('fast');
                    
                },300);
              }else{
              
                  $('#cmdPosts').removeAttr('disabled').css({'opacity': '1'});
                  $(".errs").fadeIn('fast').html(data);
                  setTimeout(function(){
                  $(".hide_txtbox").fadeOut('fast');
                  },800);
              }
            
            },error : function(data){
                $(".errs").fadeIn('fast').html('Error! Network Connection Failed!');
                $('#cmdPosts').removeAttr('disabled').css({'opacity': '1'});
            }
        });
    }else{
        $(".errs").fadeIn('fast').html('Please write a comment or upload an image.');
    }
  }));



  function bringProducts(edit_ids){
    var txtsrch = $('#txt_srch_forum').val();
    var txtcats1 = $('#txtcats1').val();
    var txtmemsid = $('#txtmemsid').val();
    var page = 0;
    var datastring1='page='+page
    +'&txtcats1='+txtcats1
    +'&txtmemsid='+txtmemsid
    +'&txtsrch='+txtsrch;
    $('.srch_captn').show();
    $(".loadersmall").show();
    $(".loaders_").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");

    if($(window).width()<760){
        if(edit_ids!="")
            $("html, body").animate({ scrollTop: 300 }, "fast");
        else
            $("html, body").animate({ scrollTop: 270 }, "fast");

    }else{

        if(edit_ids!="")
            $("html, body").animate({ scrollTop: 200 }, "fast");
        else
            $("html, body").animate({ scrollTop: 200 }, "fast");
    }

    $.ajax({
      type : "POST",
      url : site_urls+"node/getForums",
      data : datastring1,
      cache : false,
      success : function(data){
        $("#ajax_table_forum").empty().append(data);
        $('#load_more_mba').data('val', ($('#load_more_mba').data('val')));
        $(".loaders_").hide();
      },error : function(data){
        $(".loaders_").hide();
      }
    });
  }




  $("#upload_form_centre").on('submit',(function(e) {
    e.preventDefault();
    $(".alert_msg").hide();
    $('#cmd_upload_content').attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
    $(".alert_msg").hide();
    var txtsch_id = $("#txt_id").val();
    
    $.ajax({
      url : site_urls+"node/upload_centres",
      type: "POST",
      data: new FormData(this),
      contentType: false, 
      cache: false,
      processData:false,
      timeout: 30000, // 30 second timeout
      success: function(data){
        if(data=="createds"){
          $('#cmd_upload_content').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
          //$('.main_actvs1').html(txttitle);
          if(txtsch_id==""){
            $("#upload_form_centre")[0].reset();
            quill.setText('');
          }

          $('.first_create_form').hide();
          $('.success_form').slideDown('fast');

          setTimeout(function(){
            $(".alert_msg").hide();
          },2500);
        }else{
          $(".alert_msg").show().html('<div class="Errormsg">'+data+'</div>');
        }

        $('#cmd_upload_content').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
      
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $('#cmd_upload_content').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
      }
    });
  }));




  $("#upload_form_res").on('submit',(function(e) {
    e.preventDefault();
    $(".alert_msg").hide();
    $('#cmd_upload_content').attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
    $(".alert_msg").hide();
    var txt_id = $("#txt_id").val();
    if(txt_id!="") var captions = "Update Resource"; else var captions = "Upload Resource";
    
    $.ajax({
      url : site_urls+"node/upload_res",
      type: "POST",
      data: new FormData(this),
      contentType: false, 
      cache: false,
      processData:false,
      dataType: 'json',
      timeout: 30000, // 30 second timeout
      success: function(data){
        //alert(data);
        if(data.msg.trim()=="createds" || data.msg.trim()=="updateds"){
          $('#cmd_upload_content').removeAttr('disabled').css({'color': '#fff'}).html(captions);

          if(txt_id==""){
            $("#upload_form_res")[0].reset();
            quill.setText('');
          }

          $('.first_create_form').hide();
          $('.success_form').slideDown('fast');

          setTimeout(function(){
            $(".alert_msg").hide();
          },2500);

        }else{
          $(".alert_msg").show().html('<div class="Errormsg">'+data.msg+'</div>');
        }

        $('#cmd_upload_content').removeAttr('disabled').css({'color': '#fff'}).html(captions);
      
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $('#cmd_upload_content').removeAttr('disabled').css({'color': '#fff'}).html(captions);
      }
    });
  }));



  $("#upload_form_logo").on('submit',(function(e) {
    e.preventDefault();
    $(".alert_msg").hide();
    $('#cmd_upload_content').attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
    $(".alert_msg").hide();
    var txt_id = $("#txt_id").val();
    if(txt_id!="") var captions = "Update Logo"; else var captions = "Upload Logo";
    
    $.ajax({
      url : site_urls+"node/upload_logo",
      type: "POST",
      data: new FormData(this),
      contentType: false, 
      cache: false,
      processData:false,
      dataType: 'json',
      timeout: 30000, // 30 second timeout
      success: function(data){
        if(data.msg.trim()=="createds" || data.msg.trim()=="updateds"){
          $('#cmd_upload_content').removeAttr('disabled').css({'color': '#fff'}).html(captions);

          if(txt_id==""){
            $("#upload_form_logo")[0].reset();
          }

          $('.first_create_form').hide();
          $('.success_form').slideDown('fast');

          setTimeout(function(){
            $(".alert_msg").hide();
          },2500);

        }else{
          $(".alert_msg").show().html('<div class="Errormsg">'+data.msg+'</div>');
        }

        $('#cmd_upload_content').removeAttr('disabled').css({'color': '#fff'}).html(captions);
      
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $('#cmd_upload_content').removeAttr('disabled').css({'color': '#fff'}).html(captions);
      }
    });
  }));




  $("#create_quiz_form").on('submit',(function(e) {
    e.preventDefault();
    $(".alert_msg1").hide();
    var txtquizid = $('#txtquizid').val();
    //alert('sss')
      
    $('#cmd_create_quiz').attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
    $(".alert_msg1").hide();
    
    $.ajax({
      url : site_urls+"node/save_quiz_settings1",
      type: "POST",
      data: new FormData(this),
      contentType: false, 
      cache: false,
      processData: false,
      timeout: 40000, //60 second timeout
      success: function(data){
        if(data=='inserted' || data=='updated2'){

          $('.first_create_game').hide();
          $('.third_create_form').fadeIn('fast');
          
          if(txtquizid=="") $("#create_quiz_form")[0].reset();

          setTimeout(function(){
            $(".alert_msg1").fadeOut('fast');
          },3000);

        }else{
          
          $(".alert_msg1").fadeIn().html(data);
        }
        $('#cmd_create_quiz').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
      
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        
        $('#cmd_create_quiz').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
      }
    });
  }));




  $("#create_quiz_form1").on('submit',(function(e) {
    e.preventDefault();
    var txt_upload_type = $("#txt_upload_type").val();
    $(".alert_msg1").hide();
    var txtquestions = $("#txtquestions").val();
    var txtquizid = $("#txtquizid").val();
    
    txtquestions = txtquestions.replace('<p><br></p>', '');

    if(txt_upload_type == "type"){ // type the questions

      if(txtquestions == '' ){
        $(".alert_msg1").fadeIn('fast').removeClass('alert-success').addClass('alert-danger').html('<div class="Errormsg">Please type a question!</div>');
      }else{
        
        $('#cmd_submit_quiz').attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
        $(".alert_msg1").hide();
        
        $.ajax({
          url : site_urls+"node/submit_my_questions",
          type: "POST",
          data: new FormData(this),
          contentType: false, 
          cache: false,
          processData:false,
          timeout: 30000, // 30 second timeout
          success: function(data){
            
            if(data=='inserted'){
              $(".alert_msg1").fadeIn().removeClass('alert-danger').addClass('alert-success').html('<div style="font-size:15px; text-align:center;">Your question has been saved!</div>');
              
              setTimeout(function(){
                $(".alert_msg1").fadeOut('fast');
              },3000);

              setTimeout(function(){
                $("html, body").animate({ scrollTop: 140 }, "fast");
              },1000);
              
              if(txtquizid==""){
                $('#create_quiz_form1 .form-control, #create_quiz_form1 select').val('');
                quill.setText('');
              }
              
            }else{
              
              $(".alert_msg1").fadeIn().html(data);
            }
            $('#cmd_submit_quiz').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
          
          },error : function(data, timeouts){
            if(timeouts==="timeout") {
              alert("Time out, please try again later");
            }else{
              alert('Error! Network Connection Failed!');
            }
            $('#cmd_submit_quiz').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
          }
        });
      }
      
    }else{ // just upload the questions

      $('#cmd_submit_quiz').attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
      $(".alert_msg1").hide();
      
      $.ajax({
        url : site_urls+"node/upload_my_questions",
        type: "POST",
        data: new FormData(this),
        contentType: false, 
        cache: false,
        processData:false,
        timeout: 30000, // 30 second timeout
        success: function(data){
          //alert(data)
          
          if(data=='inserted'){
            //alert('bbb');
            $(".alert_msg1").fadeIn().removeClass('alert-danger').addClass('alert-success').html('<div style="font-size:15px; text-align:center;">Your questions have been saved!</div>');
            
            setTimeout(function(){
              $(".alert_msg1").fadeOut('fast');
            },3000);

            setTimeout(function(){
              $("html, body").animate({ scrollTop: 140 }, "fast");
            },1000);

            $("#uploadFile").val('');

          }else{
            //alert('eee');
            $(".alert_msg1").fadeIn().html(data);
          }

          $('#cmd_submit_quiz').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
        
        },error : function(data, timeouts){
          if(timeouts==="timeout") {
            alert("Time out, please try again later");
          }else{
            alert('Error! Network Connection Failed!');
          }
          $('#cmd_submit_quiz').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
        }
      });
    }
  }));


  
  $('body').on('click', '#cmd_done_add_test', function () {
    window.location = site_urls+"admin/set_test/";
  });
  
  
  $('body').on('click', '#post_content', function () {
    $('.bold_info1').slideUp('fast');
  });


  $('body').on('click', '.close-search', function () {
    $('.bring_search').fadeToggle('fast');
    $('.navs2 .hide_lnks').show();
  });




  $('body').on('click', '#load_more_mba_forum', function () {
    var page = $(this).data('val');
    var txtsrch_test = $('.txtsrch_test').val();
    //var txtparams = $('#txtparams').val();
    var txtmemsid = $('#txtmemsid').val();
    var txtkeywd1 = retrieve_cookie('txtkeywd1');
    if(txtkeywd1=="" || txtkeywd1=="undefined") var txtkeywd1 = "";

    if(txtsrch_test=="")
      var txtsrch_test = retrieve_cookie('cats_f');

    $('#load_more_mba_forum').hide();
    $('#load_more_mba_forum1').show();
    var datastring='page='+page
    //+'&txtparams='+txtparams
    +'&txtkeywd1='+txtkeywd1
    +'&txtmemsid='+txtmemsid
    +'&txtsrch_test='+txtsrch_test;

    $.ajax({
        type : "POST",
        url : site_urls+"node/getForums",
        data : datastring,
        cache : false,
        success : function(data){
        var responseReturn = data.match(/Category/g);
        if(responseReturn != null){
            $("#ajax_table_forum").append(data);
            $('.load_more_bt').data('val', ($('.load_more_bt').data('val')+1));
            $('#load_more_mba_forum').show();
            $('#load_more_mba_forum1').hide();
        }else{
            $('#load_more_mba_forum').hide();
            $('#load_more_mba_forum1').show();
            $('.load_more_bt, .load_more_bma1').html('<font style="color:#999 !important;">No more posts!</font>');
        }

        },error : function(data){
            $('#load_more_mba_forum').show();
            $('#load_more_mba_forum1').hide();
        }
    });
});




  $('body').on('click', '.filters', function (e) {
    e.stopPropagation();
    $('.search_contents').slideToggle(80);
  });

  $('body').on('click', '.search_contents select, .search_contents input', function (e) {
    e.stopPropagation();
  });


  $('body, html').on('click', function (e) {
    e.stopPropagation();
    $('.search_contents').slideUp('fast');
    if($(window).width() < 760) // mobile
      $('.navbar-static-side').slideUp('fast');
    $('#country_list_id').hide();
    $('.show_answer').slideUp('fast');
    $('.edit_div').slideUp('fast');
    $('.edit_div1').slideUp('fast');
  });


  $('body').on('change', '#uploadFile', function () {
    var fls = $("#uploadFile").val();
    var fileExtension = ['xlsx', 'xls'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
      alert("Excel formats allowed are : "+fileExtension.join(', '));
      $("#uploadFile").val('');
      return false;
    }
  });


  $('body').on('change', '#txtfile', function () {
    var fls = $("#txtfile").val();
    var fileExtension = ['pdf', 'doc', 'mp4'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
      alert("Formats allowed are : "+fileExtension.join(', '));
      $("#txtfile").val('');
      return false;
    }
  });


  $('body').on('change', '#txtfile1', function () {
    var fls = $("#txtfile1").val();
    var fileExtension = ['jpg', 'jpeg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
      alert("Formats allowed are : "+fileExtension.join(', '));
      $("#txtfile").val('');
      return false;
    }
  });

  

  $('body').on('click', '.search_college', function () {
    $("#txtcollege1").trigger('change');
  });



  $('#load_more_mba').click(function(){
    var page = $(this).data('val');
    var txtsources = $("#txtsources").val();
    
    $('#load_more_mba').hide();
    $('#load_more_mba1').show();
    var datastring='page='+page
    +'&txtsources='+txtsources;
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/getMoreRecords",
      data : datastring,
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        var responseReturn = data.match(/Downloads/g);
        //alert(responseReturn);
        if(responseReturn != null){
          $("#ajax_table_bma").append(data);
          $('.load_more_bt').data('val', ($('.load_more_bt').data('val')+1));
          $('#load_more_mba').show();
          $('#load_more_mba1').hide();
        }else{
          $('#load_more_mba').hide();
          $('#load_more_mba1').show();
          $('.load_more_bt, .load_more_bma1').html('<font style="color:#999 !important;">No more records!</font>');
        }
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $('#load_more_mba').show();
        $('#load_more_mba1').hide();
      }
    });
  });



  $(".upload_questions").click(function(){
    $(".alert_msg1").hide();
    $(".write_quest_div").hide();
    $(".uploadQuests").fadeIn('fast');
    $("#txt_upload_type").val('upload');
  });


  $(".type_questions").click(function(){
    $(".alert_msg1").hide();
    $(".uploadQuests").hide();
    $(".write_quest_div").fadeIn('fast');
    $("#txt_upload_type").val('type');
  });



  $('body').on('click', '.cmd_search_res', function () {
    var keywords = $(".txtkeywd").val();
    var locs = $(".txtsrch_state").val();
    
    var datastring='keywords='+keywords
    +'&wholesearch=0'
    +'&locs='+locs;

    $(".loaders").show();
    $.ajax({
      type : "POST",
      url : site_urls+"node/filterCentres",
      data : datastring,
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        $(".loaders").hide();
        $(".filterCentres1").html(data);
        $("html, body").animate({scrollTop: $('.scrollhere2').offset().top-120 }, 20);
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $(".loaders").hide();
      }
    });
  });



  $('body').on('click', '.cmd_search_test', function () {
    var keywords = $(".txtkeywd1").val();
    var tests = $(".txtsrch_test").val();
    var txtsources = $("#txtsources").val();
    
    var datastring='keywords='+keywords
    +'&txtsources='+txtsources
    +'&tests='+tests;

    $(".loaders").show();
    $.ajax({
      type : "POST",
      url : site_urls+"node/filterRes",
      data : datastring,
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        $("#ajax_table_bma").html(data);
        $("html, body").animate({scrollTop: $('.scrollhere1').offset().top-60 }, 20);
        $(".loaders").hide();
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $(".loaders").hide();
      }
    });
  });


  create_cookie('txtkeywd1', '');

  $('body').on('click', '.cmd_search_forum', function () {
    var vals = $(this).attr('vals');
    var txtkeywd1 = $('.txtkeywd1').val();
    var txtsrch_test = $('.txtsrch_test').val();
    var urls = site_urls+"node/getForums";

    if(txtkeywd1!=""){
      create_cookie('txtkeywd1', txtkeywd1);
    }
    
    $(".loaders_").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");
    

    if($(window).width()<760)
    $("html, body").animate({scrollTop:$('.topics_2').offset().top-40}, "fast");
    else
    $("html, body").animate({scrollTop:$('.topics_2').offset().top-390}, "fast");

    var datastring='txtkeywd1='+txtkeywd1
    +'&txtsrch_test='+txtsrch_test;
    +'&page=0';
    $.ajax({
      type : "POST",
      url : urls,
      data : datastring,
      success : function(data){
        $(".loaders_, .reply_forum").hide();
        $("#ajax_table_forum").html(data).fadeIn('fast');
      },error : function(data){
      }
    });
  });


  
  $('body').on('click', '.close_map', function () {
    var id1 = $(this).attr('id1');
    $(".open_map").fadeOut('fast');
    $(".filterCentres1").fadeIn('slow');
    setTimeout(function(){
      $("html, body").animate({scrollTop: $('.scrollhere'+id1).offset().top-80 }, 20);
    },200);
  });


  $('body').on('click', '.open_map', function () {
    var id1 = $(this).attr('id1');
    $(this).fadeOut('fast');
    $(".filterCentres1").fadeIn('slow');
    setTimeout(function(){
      $("html, body").animate({scrollTop: $('.scrollhere'+id1).offset().top-80 }, 20);
    },200);

    // $(".open_map").fadeOut('fast');
    // $(".filterCentres1").fadeIn('slow');
    // setTimeout(function(){
    //   $("html, body").animate({scrollTop: $('.scrollhere'+id1).offset().top-80 }, 20);
    // },200);
  });





  $('body').on('click', '.menu_icn', function (e) {
    e.stopPropagation();
    var ids = $(this).attr("ids");
    $('#edit_div'+ids).slideToggle('fast');
  });


  $('body').on('click', '.menu_icn1', function (e) {
    e.stopPropagation();
    var ids = $(this).attr("ids");
    $('#edit_div1'+ids).slideToggle('fast');
  });



  $('body').on('click', '#editpost', function () {
    var ids = $(this).attr("ids");
    var messages1 = $(this).attr("messages1");
    var files = $(this).attr("files");
    var topics = $(this).attr("topics");
    var counters = $(this).attr("counters");
    create_cookie('counters', counters);
    //alert(topics)
    $('#edit_div'+ids).slideToggle('fast');
    $('#selectedCaption1').html(files);
    $('#edit_ids').val(ids);
    $('#former_file1').val(files);
    $('#post_content').val(messages1);
    $("#txtcats").val(topics);
    $("#cmdPosts").val("Edit Comment");
    
    $("html, body").animate({scrollTop: $('.txtcreate_topic').offset().top-50 }, "fast");
    
    setTimeout(function(){
      $('.clickforum').click();
    },500);
  });



  $('body').on('click', '#delpost', function () {
    var ids = $(this).attr("ids");
    if(confirm("Proceed to delete this post?")){
      $('.forumBox_scroll'+ids).slideUp('fast');
      var datastring='post_id='+ids
      +'&type1=forums';
      $.ajax({
        type : "POST",
        url : site_urls+"node/delete_post",
        data: datastring,
        //cache : false,
        success : function(data){
        },error : function(data){
        }
      });
      return false;
    }
  });



  $('body').on('click', '#delpost2', function (){
    var ids = $(this).attr("ids");
    var ids2 = $(this).attr("ids2");
    $('.forum_rep'+ids2).slideUp('fast');
    
    var txtrep_cnts = $('#txtrep_cnts').val();
    var new_cnt = parseInt(txtrep_cnts)-1;

    $('#txtrep_cnts').val(new_cnt);
    $('.newcount').html(new_cnt);

    var datastring='post_id='+ids
    +'&type1=forum_reply';
    $.ajax({
      type : "POST",
      url : site_urls+"node/delete_post",
      data: datastring,
      success : function(data){

      },error : function(data){
      }
    });
    return false;
  });


  
  $('body').on('mousedown', '#uploadfiles1', function (){
    $("#imgpreview1").html('');
    $('#file4').click();
  });


  $('body').on('mousedown', '#uploadfiles1_rep', function (){
    $("#imgpreview1_rep").html('');
    $('#file4_rep').click();
  });


  create_cookie('selected_file1', 0);


  $('body').on('change', '#file4', function (){
    var myfile = $('#file4').val();
    var extn = myfile.slice(-7);
    
    if(myfile.length > 16){
    var myfile1 = myfile.substring(0,16);
    var combined_one1 = myfile1+'...'+extn;
    }else{
    var combined_one1 = myfile;
    }
    
    if(myfile1 == ''){
      $('#selectedCaption1').html('No file selected');
      create_cookie('selected_file1', 0);
    }else{
      $('#selectedCaption1').html('<b style="color:#996600; font-size:0.9em;">Selected:</b> '+combined_one1);
      create_cookie('selected_file1', 1);
    }
    
    $("#imgpreview1").html('').show();
    //this code below is for the uploading to stay right beside the box
    $("#form2").ajaxForm({
      target: '#imgpreview1'
    }).submit()
    //to bring all the chats from a function
    setTimeout(function(){
    $("#imgpreview1").html('');
    $("#imgpreview1").hide();
    $('#selectedCaption1').empty().html('No file selected');
    },1300);
  });



  $('body').on('change', '#file4_rep', function (){
    var myfile = $('#file4_rep').val();
    var extn = myfile.slice(-7);
    
    if(myfile.length > 16){
    var myfile1 = myfile.substring(0,16);
    var combined_one1 = myfile1+'...'+extn;
    }else{
    var combined_one1 = myfile;
    }
    
    if(myfile1 == ''){
      $('#selectedCaption1_rep').html('No file selected');
      create_cookie('selected_file1', 0);
    }else{
      $('#selectedCaption1_rep').html('<b style="color:#996600; font-size:0.9em;">Selected:</b> '+combined_one1);
      create_cookie('selected_file1', 1);
    }
    
    $("#imgpreview1_rep").html('').show();
    //this code below is for the uploading to stay right beside the box
    $("#form2").ajaxForm({
      target: '#imgpreview1_rep'
    }).submit()
    //to bring all the chats from a function
    setTimeout(function(){
    $("#imgpreview1_rep").html('');
    $("#imgpreview1_rep").hide();
    $('#selectedCaption1_rep').empty().html('No file selected');
    },1300);
  });




  $('body').on('click', '.view_maps', function () {
    var id1 = $(this).attr('id1');
    var addrs = $(this).attr('addrs');
    var centre_name = $(this).attr('centre_name');
    $(".open_map .open_inner_map").html('<img src="'+site_urls+'images/loaderq.gif"></div>');
    
    var datastring='addrs='+addrs
    +'&id1='+id1
    +'&centre_name='+centre_name;
    //alert(datastring)
    $(".filterCentres1").hide();
    $(".open_map").fadeIn('fast').css('display', 'flex');
    $.ajax({
      type : "POST",
      url : site_urls+"node/findMap",
      data : datastring,
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        $(".open_map").attr('id1', id1);
        $(".open_map .open_inner_map").html(data);
        //$(".loaders").hide();
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }
      }
    });
  });


  
  $('body').on('change', '#txtaction', function () {
    var txtaction = $(this).val();
    if(txtaction=="all"){
      window.location = site_urls+"admin/members/";
    }
  });


  $('body').on('change', '#txtaction1', function () {
    var txtaction = $(this).val();
    if(txtaction=="all"){
      window.location = site_urls+"admin/resources/";
    }
  });


  $('body').on('click', '#cmd_back_tofirst', function () {
    $('.success_form').hide();
    $('.first_create_form').fadeIn('fast');
  });


  $('body').on('click', '.view_changes', function () {
    var pages = $(this).attr("pages");
    window.location = site_urls+"admin/"+pages+"/";
  });



  $(".remove_file").click(function(){
    var files = $(this).attr("files");
    var folders = $(this).attr("folders");
    var id2 = $(this).attr("id2");
    var imgfile = $(this).attr("imgfile");
    
    var datastring='files='+files
    +'&id2='+id2
    +'&folders='+folders;

    if(confirm("Proceed to delete this?")){
      $(this).hide();
      $("#update_imgs1_"+id2).slideUp('fast');

      $.ajax({
        type: "POST",
        url : site_urls+"node/delete_imgs",
        data: datastring,
        cache: false,
        success : function(data){
          
        },error : function(data){

        }
      });
    }
  });



  $('body').on('click', '.approve_me', function () {
    var id1 = $(this).attr("id1");
    var caps = $(this).attr("caps");
    var tbls = $(this).attr("tbls");
    var columns = $(this).attr("columns");
    
    $('#approve_me'+id1).html('<b>.......</b>').removeClass('approve_me');
    
    if(tbls=="cart"){
        var caps1="This cannot be undone, Proceed?";

    }else if(tbls=="members"){
        if(caps!="Approved")
          var caps1="Proceed to unblock this member?";
        else
          var caps1="Proceed to block this member?";
    }else{
      if(caps!="Approved")
        var caps1="Approving this will make it visible on the platform.\r\nProceed?";
      else
        var caps1="Proceed to disapprove this?";
    }

    if(confirm(caps1)){
      var datastring='id1='+id1
      +'&tbls='+tbls
      +'&columns='+columns;
      //alert(datastring)
      $.ajax({
        type : "POST",
        url : site_urls+"node/approve_tables",
        data: datastring,
        timeout: 30000, // 30 second timeout
        success : function(data){
            dataTable.clear().draw();
            dataTable.rows.add(NewlyCreatedData);
            dataTable.columns.adjust().draw();
          
        },error : function(data, timeouts){
          if(timeouts==="timeout") {
            alert("Time out, please try again later");
          }
          $('#approve_me'+id1).html('<b>'+caps+'</b>').addClass('approve_me');
        }
      });
      return false;
    }else{
      $('#approve_me'+id1).html('<b>'+caps+'</b>').addClass('approve_me');
    }
    return false;
  });



  $('body').on('click', '.edit_me', function () {
    var ids = $(this).attr("id");
    var usertype = $(this).attr("usertype");
    var mypage = $(this).attr("mypage");
    var url_task = $(this).attr("url_task");
    if($.isNumeric(usertype) && parseInt(usertype)>0){
      window.location = site_urls+"dashboard/"+mypage+"/"+ids+"/";
    }else{
      if(url_task!="")
        window.location = site_urls+"admin/"+mypage+"/"+ids+"/"+url_task+"/";
      else
        window.location = site_urls+"admin/"+mypage+"/"+ids+"/";
    }
  });

  

  $('body').on('change', '#txtyears', function () {
    var txtyears = $(this).val();
    var ids_arr = $(this).attr('ids_arr');
    var name_of_sch = $(this).attr('name_of_sch');

    var txtsubjid = $('.txtsubjid').val();
    var txttest_board = $('.txttest_board').val();
    
    var datastring='txtyears='+txtyears
    +'&txtsubjid='+txtsubjid
    +'&ids_arr='+ids_arr
    +'&name_of_sch='+name_of_sch
    +'&txttest_board='+txttest_board;

    //alert(datastring)

    $(".no_of_quests").html('Loading...');
    $.ajax({
      type : "POST",
      url : site_urls+"node/noofquest",
      data : datastring,
      cache : false,
      success : function(data){
        $(".no_of_quests").html(data);
        $("#txt_no_of_quests").val(data);
      },error : function(data){
      }
    });
  });




  function copyToClipboard(element) {
    var $temp = $("<textarea>");
    $("body").append($temp);
    var x = $(element).html().trim().replace(/<br>/g, '\n').replace(/<\/?[^>]+>/g, '');
    $temp.val(x).select();
    document.execCommand("copy");
    $temp.remove();
  }


  $('body').on('click', '.copy_text', function () {
    var ids = $(this).attr('ids');
    copyToClipboard(document.getElementById("copyTarget"+ids));
    $('.copy_text').fadeOut(30);
    $('#cover_contents1'+ids).fadeOut('fast');
  });


  $('body').on('click', '.copy_texts', function () {
    var ids = $(this).attr('ids');
    copyToClipboard(document.getElementById("copyTarget"+ids));
    $('.copy_texts').fadeOut(30);
    $('#cover_contents1'+ids).fadeOut('fast');
  });




  $('body').on('click', '.open_comment', function () {
    var frid = $(this).attr('frid');
    var tils = $(this).attr('tils');
    //var directs1 = $(this).attr('directs1');
    create_cookie('frid', frid);
    create_cookie('tils', tils);
    // if(directs1!=""){
    //   window.location = site_urls+directs1;
    // }else{
      open_comment();
    //}
  });


  function open_comment(){
    //hide_all_no_e();
    //var hash = location.hash.substring(1);
    var frid = retrieve_cookie('frid');
    var tils = retrieve_cookie('tils');

    if($(window).width()<760)
    $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
    else
    $("html, body").animate({scrollTop:$('.scrltotop').offset().top+120}, "fast");

    //create_cookie('urls_prev', hash);
    create_cookie('frid', frid);
    //$(".forum_view").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading replies...</div><br><br><br><br><br>');

    $('.main_forum').hide();
    $('.reply_forum').fadeIn('fast').html('<div style="text-align:center"><img src="'+site_urls+'images/loader.gif"> Loading replies...</div><br><br><br><br>');

    var datastring='frid='+frid;
    //+'&activityid='+activityid;
    //alert(datastring)
    $.ajax({
      type : "POST",
      url : site_urls+"node/forum_view_loads",
      data : datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        $('.reply_forum').html(data);
        setTimeout(function(){
          $('#fr_ids').val(frid);
        },100);
      },error : function(data){
      }
    });
  }



  $('body').on('mousedown', '.read_mores', function () {
    $('.start_about').slideUp('fast');
    $('.contd_about').slideDown('fast');
  });


  $('body').on('mousedown', '.read_lesss', function () {
    $('.contd_about').slideUp('fast');
    $('.start_about').slideDown('fast');
  });




  $('body').on('change', '#txtcollege1', function () {
    var txtcollege1 = $(this).val();
    var test_logo = $(this).attr('test_logo');
    var test_board1 = $(this).attr('test_board1');

    var datastring='colleges='+txtcollege1
    +'&test_logo='+test_logo
    +'&test_board1='+test_board1;

    var src1 = $(".img_test_logo img").attr('src1');
    $(".loaders").show();
    $.ajax({
      type : "POST",
      url : site_urls+"node/display_subjects",
      data : datastring,
      cache : false,
      dataType: 'json',
      timeout: 30000, // 30 second timeout
      success : function(data){
        $(".sch_contents").html(data.msg);
        if(data.logos!="")
          $(".img_test_logo img").attr('src', site_urls+"logos_files/"+data.logos);
        else
          $(".img_test_logo img").attr('src', src1);
        $(".loaders").hide();
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $(".loaders").hide();
      }
    });
  });



  $('body').on('click', '.start_here', function () {
    $("html, body").animate({scrollTop: $('.educate').offset().top-30 }, 1000);
  });


  $('body').on('click', '.select_test', function () {
    $('.explore_cats').slideUp('fast');
    $('.explore_1').slideDown('fast');
  });


  $('body').on('click', '.back_btn', function () {
    $('.explore_cats').slideDown('fast');
    $('.explore_1').slideUp('fast');
  });


  $('body').on('click', '.login_btn', function () {
    $('.div_contents').hide();
    $('#div_contents, .choose_subjects').hide();
    $('.div_reg_login').fadeIn('fast');
    $(this).html('&laquo; Back').removeClass('login_btn').addClass('back_to_main');
  });


  $('body').on('click', '.login_btn_j', function () {
    $('.div_contents').hide();
    $('#div_contents, .choose_subjects').hide();
    $('.div_reg_login').fadeIn('fast');
    //$(this).html('&laquo; Back').removeClass('login_btn').addClass('back_to_main');
  });


  
  $('body').on('click', '.empty_tests', function () {
    alert('Cannot proceed! No questions in this subject!')
  });

  

  $('body').on('click', '.mobile_goback', function () {
    $('.main_forum').fadeIn('fast');
    $('.reply_forum').hide();
  });



  $('body').on('click', '.no_start_tests', function () {
    var selected_subjs = $('.selected_subjs').val();
    var counts = selected_subjs.split(',').length;
    var isSubjects = $(this).attr('isSubjects');

    if(isSubjects==1){
      if(counts < 2){
        $('.selecteds').html("<div class='errs'>Please select at least 2 subjects</div>").show();
        return false;

      }else if(counts > 6){
        $('.selecteds').html("<div class='errs'>You can only select maximum of 6 subjects</div>").show();
        return false;

      }else{
        $('.login_btn').html('&laquo; Back').removeClass('login_btn').addClass('back_to_main');
        $('.login_btn_i').html('&laquo; BACK').removeClass('login_btn_i').addClass('back_to_main');
      }
      $('.div_contents').hide();
      $('.div_reg_login').fadeIn('fast');
    }else{
      $('.div_contents').hide();
      $('.div_reg_login').fadeIn('fast');
      //return false;
    }
    $('.choose_subjects').hide();
    
  });


  
  $('body').on('click', '.cmd_back2', function () {
    create_cookie('onGoingTest', 0);
    create_cookie('s_id1', '');
    create_cookie('s_selected_subjs', '');
    create_cookie('s_test_board2', '');
    create_cookie('s_txtcollege1', '');
    create_cookie('s_name_of_sch', '');
    create_cookie('s_arrays', '');
    create_cookie('s_counts', '');
    create_cookie('s_memid', '');
    create_cookie('txtpage_number', '');
    create_cookie('txttotalquiz', '');
    create_cookie('subjects', '');
    create_cookie('selected_subjs', '');
    create_cookie('counts', '');
    create_cookie('id1', '');
    create_cookie('test_types', '');

    $(".subject_instruc").hide();
    $(".main_test_page").html('').hide();
    if($(window).width() < 760) $('.myheaders_mobile').show();
    $('.choose_subjects').fadeIn('fast');
  });
  


  $('body').on('click', '.cmd_back_details', function () {
    $(".buybtn_online").css({'opacity': '1', 'color': '#ddd'}).html("Pay Online <i class='fa fa-arrow-right'></i>").addClass('buybtn_online');
    $(".alert_msgs").hide();
    $(".myBookDetails_Pay").hide();
    $('.myBookDetails').fadeIn('fast');
  });


  // $('body').on('click', '.cmd_back_lists', function () {
  //   window.location = site_urls+"resources/past-questions/";
  // });


  
  $('body').on('click', '.cmd_buythis', function () {
    $(".myBookDetails").hide();
    $(".myBookDetails_Pay").fadeIn('fast');
  });


  $('body').on('click', '.buybtn', function () {
    var self = this;
    var ids = $(this).attr('ids');
    var titles = $(this).attr('titles');
    var txtwrite = $('.txtwrite').val();
    if(txtwrite==1)
      var txtlocatn = $('#txtlocatn').val();
    else
      var txtlocatn = "";

    $(".alert_msgs").hide();

    if(confirm("Proceed to submit this using bank transfer?")){
      $(self).css({'opacity': '0.6', 'color': '#ccc'}).html("Please wait...").removeClass('buybtn');
      var datastring='ids='+ids
      +'&txtlocatn='+txtlocatn
      +'&txtwrite='+txtwrite
      +'&pay_type=manual'
      +'&titles='+titles;

      $.ajax({
        type: "POST",
        url : site_urls+"node/submit_orders",
        data: datastring,
        timeout: 30000, // 30 second timeout
        success : function(data){
          //alert(data)
          if(data=="submitted"){
            $(self).css({'opacity': '1', 'color': '#ddd'}).html("Use Mobile Transfer <i class='fa fa-arrow-right'></i>").addClass('buybtn');
            $('.myBookDetails_Pay').hide();
            $('.myBookDetails_Success').fadeIn('fast');
          }else{
            $(".alert_msgs").fadeIn('fast').html(data).addClass('alert-danger');
            $(self).css({'opacity': '1', 'color': '#ddd'}).html("Use Mobile Transfer <i class='fa fa-arrow-right'></i>").addClass('buybtn');
          }
        },error : function(data, timeouts){
          if(timeouts==="timeout") {
            alert("Time out, please try again later");
          }
          $(self).css({'opacity': '1', 'color': '#ddd'}).html("Use Mobile Transfer <i class='fa fa-arrow-right'></i>").addClass('buybtn');
          $(".alert_msgs").fadeIn('fast').html(data).addClass('alert-danger');
        }
      });
    }
  });



  $(".buybtn_online").click(function(){
    var self = this;
    var ids = $(this).attr('ids');
    var titles = $(this).attr('titles');
    var txtwrite = $('.txtwrite').val();
    var myemail = $(this).attr("myemail");
    var amts = $(this).attr("amts");
    if(txtwrite==1)
      var txtlocatn = $('#txtlocatn').val();
    else
      var txtlocatn = "";

    $(self).css({'opacity': '0.6', 'color': '#ccc'}).html("Please wait...").removeClass('buybtn_online');
    $(".alert_msgs").hide();

    var datastring='ids='+ids
      +'&txtlocatn='+txtlocatn
      +'&txtwrite='+txtwrite
      +'&titles='+titles;

    $.ajax({
      type: "POST",
      url : site_urls+"node/submit_orders_verify",
      data: datastring,
      cache: false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        if(data=="verified"){
          var handler = PaystackPop.setup({
            key: 'pk_test_7a186fe10e37f8cbcb70c59eceedec05dc7dd32a',
            //key: 'pk_live_0cb98f972c8c916632114df231f0b294d1bdac57',
            email: myemail,
            amount: amts,
            ref: ''+Math.floor((Math.random() * 1000000000) + 1),
            callback: function(response){
              var datastring='ids='+ids
              +'&txtlocatn='+txtlocatn
              +'&txtwrite='+txtwrite
              +'&pay_type='+response.reference
              +'&titles='+titles;
              $.ajax({
                type: "POST",
                url : site_urls+"node/submit_orders",
                data: datastring,
                cache: false,
                timeout: 30000, // 30 second timeout
                success : function(data){
                  //alert(data)
                  if(data=="submitted"){
                    $(self).css({'opacity': '1', 'color': '#ddd'}).html("Pay Online <i class='fa fa-arrow-right'></i>").addClass('buybtn_online');
                    $('.myBookDetails_Pay').hide();
                    $('.myBookDetails_Success').fadeIn('fast');
                  }else{
                    $(".alert_msgs").fadeIn('fast').html(data).addClass('alert-danger');
                    $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#ddd'}).html("Pay Online <i class='fa fa-arrow-right'></i>").addClass('buybtn_online');
                  }
                },error : function(data, timeouts){
                  if(timeouts==="timeout") {
                    alert("Time out, please try again later");
                  }
                  $(self).css({'opacity': '1', 'color': '#ddd'}).html("Pay Online <i class='fa fa-arrow-right'></i>").addClass('buybtn_online');
                  $(".alert_msgs").fadeIn('fast').html(data).addClass('alert-danger');
                }
              });
            },
            onClose: function(){
              $(self).css({'opacity': '1', 'color': '#ddd'}).html("Pay Online <i class='fa fa-arrow-right'></i>").addClass('buybtn_online');
            }
          });
          handler.openIframe();
        }else{
          $(".alert_msgs").fadeIn('fast').html(data).addClass('alert-danger');
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#ddd'}).html("Pay Online <i class='fa fa-arrow-right'></i>").addClass('buybtn_online');
        }
      }
    });
  });



  // var jQ = jQuery.noConflict()
  // jQ('body').on('click', '.cmd_enter_sch', function () {
  //   var txtschs = jQ("#txtschs").val();
  //   var datastring2='txtschs='+txtschs;
  //   jQ.ajax({
  //     type: "POST",
  //     url : site_urls+"node/add_to_schs",
  //     data: datastring2,
  //     timeout: 30000, // 30 second timeout
  //     success : function(data){
  //       if(data=="exists"){
  //         alert('The school name already exists');
  //         return false;
  //       }
  //       jQ(".div_sch").html(data);
  //       jQ("#txtschs").val('');
  //       jQ('.cover_body').hide();
  //       jQ('#add_schs').fadeOut('fast');
  //     }
  //   });
  // });



  
  $('body').on('click', '.cmd_enter_sch', function () {
    var txtschs = $("#txtschs").val();
    var datastring2='txtschs='+txtschs;
    $.ajax({
      type: "POST",
      url : site_urls+"node/add_to_schs",
      data: datastring2,
      timeout: 30000, // 30 second timeout
      success : function(data){
        if(data=="exists"){
          alert('The school name already exists');
          return false;
        }
        $(".div_sch").html(data);
        $("#txtschs").val('');
        $('.cover_body').hide();
        $('#add_schs').fadeOut('fast');
      }
    });
  });



  $('body').on('click', '.cmd_enter_sub', function () {
    var txtsub = $("#txtsub").val();
    var datastring2='txtsub='+txtsub;
    $.ajax({
      type: "POST",
      url : site_urls+"node/add_to_subjs",
      data: datastring2,
      timeout: 30000, // 30 second timeout
      success : function(data){
        if(data=="exists"){
          alert('The subject name already exists');
          return false;
        }
        $(".div_subject").html(data);
        $("#txtsub").val('');
        $('.cover_body').hide();
        $('#add_subj_dv').fadeOut('fast');
      }
    });
  });


  // $('body').on('click', '.noclickforum, #cmdnoPosts', function () {
  //   if(confirm("You cannot use this feature, please login and continue.\r\nDo you want to login or register?")){
  //     window.location = site_urls;
  //   }
  //   return false;
  // });



  $('body').on('click', '.txt_srch_forums', function (e) {
    e.stopPropagation();
    if($(window).width()<760)
    $(".mobile_cats").animate({height:'270'})
  });


  //$('.clickforum').live("click",function(){
  $('body').on('click', '.clickforum', function () {
    $('.txtselectcat').fadeIn('fast');
    $('.textareas').slideDown('fast');
    $('.clickforum').hide();
    $('#txt_srch_forum1').show();
  });



  $('body').on('click', '.cancel_posts', function () {
    $("#form2")[0].reset();
    $('.txtselectcat').fadeOut('fast');
    $('.textareas').slideUp('fast');
    $('#txt_srch_forum1').hide();
    $('.clickforum').show();
    $('#selectedCaption1').empty().html('No file selected');
    $(".errs").hide();
    $('.bold_info1').hide();
  });



  $('body').on('click', '.view_formats', function () {
    $('.bold_info1').fadeToggle('fast');
  });



  $('body').on('click', '.cmd_downloadthis', function () {
    var self = this;
    var ids = $(this).attr('ids');
    var files = $(this).attr('files');

    $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'}).html("Please wait...");

    var datastring='ids='+ids;
    $.ajax({
      type: "POST",
      url : site_urls+"node/download_file",
      data: datastring,
      timeout: 30000, // 30 second timeout
      success : function(data){
        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#ddd'}).html("Download Now");
        window.location = site_urls+"resourcesfiles/"+files;
        //window.location = site_urls+"images/1.jpg";
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          alert('Error! Network Connection Failed!');
        }
        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#ddd'}).html("Download Now");
      }
    });
  });


  
  $('body').on('click', '.alert_msgs', function () {
    $(this).fadeOut('fast');
  });


  
  $('body').on('click', '.show_performance span', function () {
    if(confirm("It will open a new page to view it, continue?")){
      window.location = site_urls+"dashboard/performance/";
    }
  });



  $('body').on('click', '.start_tests', function () {
    var inits = false;
    var subjects = $(this).attr('subjects');
    var isSubjects = $(this).attr('isSubjects');
    var memid = $(this).attr('memid');
    var subject_id = $(this).attr('subject_id');
    $('.selecteds').html('').hide();
    $('.login_info').hide();
    //var selected_subjs = $('.selected_subjs').val();
    

    var selected_subjs1 = retrieve_cookie('s_selected_subjs');
    var subjects1 = retrieve_cookie('subjects');
    var id1 = retrieve_cookie('s_id1');
    var test_board2 = retrieve_cookie('s_test_board2');
    //var txtcollege1 = retrieve_cookie('s_txtcollege1');
    var s_arrays = retrieve_cookie('s_arrays');
    var counts = retrieve_cookie('s_counts');
    //var memid = retrieve_cookie('s_memid');

    if(subjects1==""){
      create_cookie('subjects', subjects);
      $('.selected_subjs').val(subjects);
    }else{
      $('.selected_subjs').val(subjects1);
    }


    if(selected_subjs1==""){
      var selected_subjs = $('.selected_subjs').val();
      create_cookie('s_selected_subjs', selected_subjs);
    }else{
      var selected_subjs = selected_subjs1;
    }


    if(counts==""){
      var counts = selected_subjs.split(',').length;
      create_cookie('counts', counts);
    }


    if(id1==""){
      var id1 = $(this).attr('id1');
      create_cookie('id1', id1);
    }


    if(test_board2==""){
      var test_types = $(this).attr("test_types");
      create_cookie('test_types', test_types);
    }else{
      var test_types = test_board2;
    }

    if(s_arrays==""){
      var ids = "non_arrays";
    }else{
      var ids = "arrays";
    }


    if(memid==0 || memid==""){
      $('.login_info').fadeIn('fast');
      return false;
    }

    $('.choose_subjects').slideUp('fast');
    $('.subject_instruc').slideDown('slow');

    var emps="";

    var datastring='id1='+id1
    +'&selected_subjs='+selected_subjs
    +'&test_board2='+test_types
    +'&txtcollege1='+emps
    +'&name_of_sch='+emps
    +'&subject_id='+subject_id
    +'&ids='+ids
    +'&counts='+counts;

    // var datastring='id1='+id1
    // +'&selected_subjs='+selected_subjs
    // +'&test_board2='+test_board2
    // +'&txtcollege1='+txtcollege1
    // +'&name_of_sch='+name_of_sch1
    // +'&ids=arrays'
    // +'&counts='+counts;

    //alert(datastring)

    $.ajax({
      type : "POST",
      url : site_urls+"node/display_subject_details",
      data : datastring,
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        $(".subject_instruc").html(data);
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }
        $(".subject_instruc").html(data);
      }
    });
  });




  $('body').on('click', '.start_tests_proceed', function () {
    var inits = false;
    var subjects = $(this).attr('subjects');
    var isSubjects = $(this).attr('isSubjects');
    var id1 = $('.selected_subjs_ids').val();
    var txtcollege1 = $('#txtcollege1').val();
    $('.selecteds').html('').hide();
    var memid = $(this).attr('memid');
    var test_board2 = $(this).attr('test_board2');
    var name_of_sch = $(this).attr('name_of_sch');
    
    $('.login_info').hide();

    var selected_subjs = $('.selected_subjs').val();
    var counts = selected_subjs.split(',').length;

    //alert(counts);

    if(counts < 2){
      $('.selecteds').html("<div class='errs1'>Please select at least 2 subjects</div>").show();
      return false;

    }else if(counts > 6){
      $('.selecteds').html("<div class='errs1'>You can only select maximum of 6 subjects</div>").show();
      return false;

    }else{

      var id1_i = id1.replace(/\n/gi, "");
      var selected_subjs_i = selected_subjs.replace(/\n/gi, "");

      ////// store in cookies incase i refresh //////
      create_cookie('s_id1', id1_i);
      create_cookie('s_selected_subjs', selected_subjs_i);
      create_cookie('s_test_board2', test_board2);
      create_cookie('s_txtcollege1', txtcollege1);
      create_cookie('s_name_of_sch', name_of_sch);
      create_cookie('s_arrays', 'arrays');
      create_cookie('s_counts', counts);
      create_cookie('s_memid', memid);
      ////// store in cookies incase i refresh //////
      
      if(memid==0 || memid==""){
        $('.login_info').fadeIn('fast');
        return false;
      }

      $('.choose_subjects').slideUp('fast');
      $('.subject_instruc').slideDown('slow');

      var emps="";
      
      var datastring='id1='+id1
      +'&selected_subjs='+selected_subjs
      +'&test_board2='+test_board2
      +'&txtcollege1='+txtcollege1
      +'&name_of_sch='+name_of_sch
      +'&subject_id='+emps
      +'&ids=arrays'
      +'&counts='+counts;

      //alert(datastring)

      $.ajax({
        type : "POST",
        url : site_urls+"node/display_subject_details",
        data : datastring,
        cache : false,
        timeout: 30000, // 30 second timeout
        success : function(data){
          $(".subject_instruc").html(data);
        },error : function(data, timeouts){
          if(timeouts==="timeout") {
            alert("Time out, please try again later");
          }
          $(".subject_instruc").html(data);
        }
      });
    }
  });



  function start_tests_proceed_func(){
    $('.selecteds').html('').hide();
    
    var selected_subjs = retrieve_cookie('s_selected_subjs');
    var id1 = retrieve_cookie('s_id1');
    var test_board2 = retrieve_cookie('s_test_board2');
    var txtcollege1 = retrieve_cookie('s_txtcollege1');
    var name_of_sch1 = retrieve_cookie('s_name_of_sch');
    var s_arrays = retrieve_cookie('s_arrays');
    var counts = retrieve_cookie('s_counts');
    var memid = retrieve_cookie('s_memid');
    $('.login_info').hide();

    var txtpage_number = retrieve_cookie('txtpage_number');
    var txttotalquiz = retrieve_cookie('txttotalquiz');

    $("#txttotalquiz").val(txttotalquiz);
    $("#txtpage_number").val(txtpage_number);

    $('.selected_subjs').val(selected_subjs);
    $('.selected_subjs_ids').val(id1);

     //alert(selected_subjs);
    // alert(counts);
     //alert(id1);
    // alert(test_board2);
    // alert(txtcollege1);
    // alert(s_arrays);
    // alert(counts);
    // alert(memid);


    if(memid==0 || memid==""){
      $('.login_info').fadeIn('fast');
      return false;
    }

    $('.choose_subjects').slideUp('fast');
    $('.subject_instruc').slideDown('slow');
    var emps="";

    var datastring='id1='+id1
    +'&selected_subjs='+selected_subjs
    +'&test_board2='+test_board2
    +'&txtcollege1='+txtcollege1
    +'&name_of_sch='+name_of_sch1
    +'&subject_id='+emps
    +'&ids=arrays'
    +'&counts='+counts;

    $.ajax({
      type : "POST",
      url : site_urls+"node/display_subject_details",
      data : datastring,
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        $(".subject_instruc").html(data);
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }
        $(".subject_instruc").html(data);
      }
    });
  }




  $('body').on('click', '#cmd_submit_answers_timeout', function () {
    $('.tawk_to').show();

    $('.cmd_next_quiz').hide();
    $('.cmd_next_quiz1').show();
    $('.cmd_next_quiz2').show();
    //$('.quiz_starts').hide();
    create_cookie('onGoingTest', 0);
    create_cookie('s_id1', '');
    create_cookie('s_selected_subjs', '');
    create_cookie('s_test_board2', '');
    create_cookie('s_txtcollege1', '');
    create_cookie('s_name_of_sch', '');
    create_cookie('s_arrays', '');
    create_cookie('s_counts', '');
    create_cookie('s_memid', '');
    create_cookie('txtpage_number', '');
    create_cookie('txttotalquiz', '');
    create_cookie('subjects', '');
    create_cookie('selected_subjs', '');
    create_cookie('counts', '');
    create_cookie('id1', '');
    create_cookie('test_types', '');

    var qid_intro = $(this).attr('id_sch');
    var subject_id = $(this).attr('subject_id');
    var test_board = $(this).attr('test_board');
    var ids_arr = $(this).attr('ids_arr');

    //$(".cmd_sub_answers").click();
    clearThisSession(qid_intro, subject_id, test_board, ids_arr);
  });




  $('body').on('click', '.cancel_test span', function () {
    var id_sch = $(this).attr('id_sch');
    var subject_id = $(this).attr('subject_id');
    var ids_arr = $(this).attr('ids_arr');

    $('.tawk_to').show();

    if(confirm("Are you sure you want to cancel this test?")){

      totalAmount = 0;
      clearTimeout(timeloop);
      localStorage.removeItem('countDown');


      create_cookie('onGoingTest', 0);
      create_cookie('s_id1', '');
      create_cookie('s_selected_subjs', '');
      create_cookie('s_test_board2', '');
      create_cookie('s_txtcollege1', '');
      create_cookie('s_name_of_sch', '');
      create_cookie('s_arrays', '');
      create_cookie('s_counts', '');
      create_cookie('s_memid', '');
      create_cookie('txtpage_number', '');
      create_cookie('txttotalquiz', '');
      create_cookie('subjects', '');
      create_cookie('selected_subjs', '');
      create_cookie('counts', '');
      create_cookie('id1', '');
      create_cookie('test_types', '');

      $('.fade_questions').show();

      $('.cmd_next_quiz').show();
      $('.cmd_next_quiz1').hide();

      $('.cmd_next_quiz2').hide();
      $('.subject_instruc').hide();
      $('.main_test_page').html('');
      $('.main_test_page').hide();
      $('.quiz_starts').hide();
      $('.choose_subjects').fadeIn('fast');
      if($(window).width() < 760) $('.myheaders_mobile').show();

      var datastring2='id_sch='+id_sch
      +'&subject_id='+subject_id
      +'&ids_arr='+ids_arr;

      $.ajax({
        type: "POST",
        url : site_urls+"node/remove_started_test",
        data: datastring2,
        success : function(data){
          
        }
      });
    }
  });




  var onGoingTest = retrieve_cookie('onGoingTest');

  if(onGoingTest == 1){
    $(".start_tests").click();
    //start_tests_proceed_func();
  }

  
  var s_arrays = retrieve_cookie('s_arrays');
  //alert(s_arrays)

  if(s_arrays == "arrays"){
    start_tests_proceed_func();
  }



  $('body').on('click', '.close_list', function (e) {   
    e.stopPropagation();
  });


  $('body').on('click', '.close_list i', function (e) {
    $('#country_list_id').hide();
  });


  $('body').on('click', '#cmd_goto_first', function (e) {
    $('.third_create_form').hide();
    $('.first_create_game').fadeIn('fast');
  });


  $('body').on('click', '#cmd_goto_questions', function (e) {
    window.location = site_urls+"admin/upload_questions/";
  });


  
  $('body').on('keyup', '.txtkeywd', function (e) {    
    e.stopPropagation();
    var keyword = $('.txtkeywd').val();
    
    var datastring='keyword='+keyword;
    //+'&search_type='+search_type;
    if(keyword != ""){
      $.ajax({
        url : site_urls+"node/getSearches",
        type: 'POST',
        data: datastring,
        timeout: 30000, // 30 second timeout
        success:function(data){
          //alert(data);
          if(data != ""){
            $('#country_list_id').show();
            $('#country_list_id').html(data);
          }else{
            $('#country_list_id').hide();
            $('#country_list_id').html('');
          }
        },error : function(data){
          
        }
      });
    }else{
      $('#country_list_id').hide();
    }
  });



  
  $('body').on('click', '.set_item', function (e) {
    e.stopPropagation();
    var thisname = $(this).attr('thisname');
    $('.txtkeywd').val(thisname);

    var txtkeywd = $('.txtkeywd').val();
    var datastring='keywords='+txtkeywd
    +'&wholesearch=1';

    $(".loaders").show();
    $.ajax({
      type : "POST",
      url : site_urls+"node/filterCentres",
      data : datastring,
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        //alert(data)
        $(".loaders").hide();
        $(".filterCentres1").html(data);
        $("html, body").animate({scrollTop: $('.scrollhere2').offset().top-120 }, 20);
      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }
        $(".loaders").hide();
      }
    });
  });



  var myEditor = document.querySelector('#editor');
  if(myEditor != null){
    var editor_html = myEditor.children[0].innerHTML;
    var editor = $("#txteditor").val(editor_html);
    var editor = $("#txtquestions").val(editor_html);
    //var editor = $("#txtdescrip").val(editor_html);
  }

  
  $('body').on('blur, keyup, focusout', '#editor', function () {
    var myEditor = document.querySelector('#editor');
    var editor_html = myEditor.children[0].innerHTML;
    var editor = $("#txteditor").val(editor_html);
    var editor = $("#txtquestions").val(editor_html);
    //var editor = $("#txtdescrip").val(editor_html);
  });


  $('body').on('click', '.add_sch', function () {
    $('.cover_body').show();
    $('#add_schs').fadeIn('fast');
  });


  $('body').on('click', '.add_subj', function () {
    $('.cover_body').show();
    $('#add_subj_dv').fadeIn('fast');
  });


  $('body').on('click', '.cover_body, .cmd_close_sch', function () {
    $("#txtschs").val('');
    $('.cover_body').hide();
    $('#delete_dv').hide();
    $('#add_schs').fadeOut('fast');
  });


  $('body').on('click', '.cover_body, .cmd_close_sub', function () {
    $("#txtsub").val('');
    $('.cover_body').hide();
    $('#delete_dv').hide();
    $('#add_subj_dv').fadeOut('fast');
  });



  $('body').on('click', '.cmd_remove_adm', function () {    
    var txtall_id = $("#txtall_id").val();
    var txt_dbase_table = $("#txt_dbase_table").val();

    $(".cmd_remove_adm").hide();
    $(".cmd_remove_adm1").show();
    
    var datastring='txtall_id='+txtall_id
    +'&txt_dbase_table='+txt_dbase_table;

    $.ajax({
      type: "POST",
      url : site_urls+"node/delete_records",
      data: datastring,
      cache: false,
      success: function(html){
        $(".cmd_remove_adm").show();
        $(".cmd_remove_adm1").hide();
        $('.cmd_close_sch').click();
        
        dataTable.clear().draw();
        dataTable.rows.add(NewlyCreatedData);
        dataTable.columns.adjust().draw();
      
      },error : function(html){
        alert('Error! Network Connection Failed!');
        $(".cmd_remove_adm").show();
        $(".cmd_remove_adm1").hide();
      }
    });
  });




  $('body').on('click', '#cmd_update_pass_admin', function (e) {
    e.preventDefault();
    var self = this;
    $(".alert_msg1").hide();
    
    $(self).attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/update_my_pass",
      data: $("#edit_pass").serialize(),
      timeout: 30000, // 30 second timeout
      success : function(data){

        if(data=="pass1_updated"){
          $(self).removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
          
          $(".alert_msg1").show().html('<div style="text-align:center">Your password has been updated!</div>').removeClass('alert-danger').addClass('alert-success');
          $("#edit_pass")[0].reset();
          
          setTimeout(function(){
            $(".alert_msg1").hide();
          },2500);
        
        }else{
          $(self).removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
          $(".alert_msg1").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data, timeouts){
        if(timeouts==="timeout") {
          alert("Time out, please try again later");
        }else{
          $(".alert_msg1").show().html('<div class="Errormsg">Poor Network Connection!</div>');
        }
        $(self).removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
      }
    });
  });



  $('body').on('click', '.cmd_sub_answers', function () {
    var txt_time_finished = $("#txt_time_finished").val();
    var tminus = $("#tminus").val();
    var id_sch = $(this).attr('id_sch');
    var subject_id = $(this).attr('subject_id');
    var test_board = $(this).attr('test_board');
    var ids_arr = $(this).attr('ids_arr');

    $('.tawk_to').show();

    if(confirm("Proceed to submit this?")){

      create_cookie('onGoingTest', 0);
      create_cookie('s_id1', '');
      create_cookie('s_selected_subjs', '');
      create_cookie('s_test_board2', '');
      create_cookie('s_txtcollege1', '');
      create_cookie('s_name_of_sch', '');
      create_cookie('s_arrays', '');
      create_cookie('s_counts', '');
      create_cookie('s_memid', '');
      create_cookie('txtpage_number', '');
      create_cookie('txttotalquiz', '');
      create_cookie('subjects', '');
      create_cookie('selected_subjs', '');
      create_cookie('counts', '');
      create_cookie('id1', '');
      create_cookie('test_types', '');

      totalAmount = 0;
      clearTimeout(timeloop);
      localStorage.removeItem('countDown');

      var datastring2='id_sch='+id_sch
      +'&subject_id='+subject_id
      +'&test_board='+test_board
      +'&ids_arr='+ids_arr
      +'&txt_time_finished='+txt_time_finished;

      $.ajax({
        type: "POST",
        url : site_urls+"node/save_my_ansas",
        data: datastring2,
        success : function(data){
          //alert(data)
          $('.cmd_next_quiz').show();
          $('.cmd_next_quiz1').hide();
          $('.cmd_next_quiz2').hide();
          $('.subject_instruc').hide();
          $('.main_test_page').show();
          $('.quiz_starts').hide();
          //alert(tminus+"tminus")
          if(tminus=="0:00")
            $('.div_success_test_timeout').fadeIn('fast');
          else
            $('.div_success_test').fadeIn('fast');
        }
      });
    }
  });




  $('body').on('click', '.contd_quiz', function () {
    $('.tawk_to').hide();

    $('.start_main_test').hide();
    $('.start_main_test1').show();
    var self = this;
    //var txtans1 = $("#txtans1").val();
    $('.started_text_value').val(1);
    $(".loaders").show();
    var txtrandom_quiz = $("#txtrandom_quiz").val();
    var txtpage_number = $(this).attr('txtpage_number');
    create_cookie('onGoingTest', 1);

    var studid = $(this).attr('studid');
    var id1 = $(this).attr('id1');
    var is_new_rec = $(this).attr('is_new_rec');

    $('.choose_subjects').slideUp('fast');

    var instructn = $(this).attr('instructn');
    var set_time = $(this).attr('set_time');
    var test_types = $(this).attr('test_types');
    var test_board = $(this).attr('test_board');
    //var noOfQuest = $(this).attr('noOfQuest');
    var noOfQuest = $("#txt_no_of_quests").val();
    var subject_id = $(this).attr('subject_id');
    var noOfYrs = $("#txtyears").val();
    var schs = $(this).attr('schs');
    var ids = $(this).attr('ids');
    var subjects_caption = $(this).attr('subjects_caption');

    //var txtans1 = $("#txtans1").val();
    //var txtrandom_quiz = $("#txtrandom_quiz").val();
    
    continueTest(studid, id1, is_new_rec, self, instructn, set_time, test_types, test_board, noOfQuest, subject_id, noOfYrs, schs, txtrandom_quiz, txtpage_number, ids, subjects_caption);
  });




  function continueTest(studid, id1, is_new_rec, self, instructn, set_time, test_types, test_board, noOfQuest, subject_id, noOfYrs, schs, txtrandom_quiz, txtpage_number, ids, subjects_caption){
    //setTimeout(function(){
      $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'}).val("Please wait...");
      
      $('.cmd_trigger').trigger('click');

      var datastring='id1='+id1
      +'&schs='+schs
      +'&set_time='+set_time
      +'&test_types='+test_types
      +'&test_board='+test_board
      +'&noOfQuest='+noOfQuest
      +'&subject_id='+subject_id
      +'&noOfYrs='+noOfYrs
      +'&studid='+studid
      +'&ids='+ids
      +'&subjects_caption='+subjects_caption
      +'&instructn='+instructn
      +'&is_new_rec='+is_new_rec;

      //alert(datastring)

      $.ajax({
        type: "POST",
        url : site_urls+"node/getUnanswered",
        data: datastring,
        success : function(data){
          $("html, body").animate({ scrollTop: 0 }, "fast");

          $('.fade_questions').fadeOut('fast');
          var txtpage_number1 = parseInt(txtpage_number) + 1;
          $('.subject_instruc').hide();

          if(txtpage_number < noOfQuest){
            $("#txtpage_number").val(txtpage_number1);
            $('.cmd_next_quiz').show();
            $('.cmd_next_quiz1').hide();
            $('.fade_questions').show();

            //setTimeout(function(){
              $('.start_main_test1').hide();
              $('.start_main_test').show();
              $('.main_test_page').fadeIn('fast').html(data);
            //},500);
            //alert('sss')

          }else{ // if the total question is equal to the page number, show done and submit to database
            
            $('.cmd_next_quiz').hide();
            $('.cmd_next_quiz1').show();
            $('.cmd_next_quiz2').show();
            
            clearThisSession(id1, subject_id, test_board, ids);
          }
          
          $('#txtans1').val('');
          $('.fade_questions').fadeOut('fast');
          //$('.scroll_inner_quiz').fadeIn('fast').html('data');
          $("#txtpage_number_h").html(txtpage_number1+".");

          $(".loaders").hide();
          //alert('sss')
          setTimeout(function(){
            $("html, body").animate({ scrollTop: 0 }, "fast");
          },300);
        }
      });

      
    //},1500);
  }



  function clearThisSession(id_sch, subject_id, test_board, ids_arr){
    var txt_time_finished = $("#txt_time_finished").val();
    var tminus = $("#tminus").val();

    create_cookie('onGoingTest', 0);
    create_cookie('s_id1', '');
    create_cookie('s_selected_subjs', '');
    create_cookie('s_test_board2', '');
    create_cookie('s_txtcollege1', '');
    create_cookie('s_name_of_sch', '');
    create_cookie('s_arrays', '');
    create_cookie('s_counts', '');
    create_cookie('s_memid', '');
    create_cookie('txtpage_number', '');
    create_cookie('txttotalquiz', '');

    create_cookie('subjects', '');
    create_cookie('selected_subjs', '');
    create_cookie('counts', '');
    create_cookie('id1', '');
    create_cookie('test_types', '');

    totalAmount = 0;
    clearTimeout(timeloop);
    localStorage.removeItem('countDown');

    var datastring2='id_sch='+id_sch
    +'&subject_id='+subject_id
    +'&test_board='+test_board
    +'&ids_arr='+ids_arr
    +'&txt_time_finished='+txt_time_finished;

    $.ajax({
      type: "POST",
      url : site_urls+"node/save_my_ansas",
      data: datastring2,
      success : function(data){
        //alert(data)
        $('.cmd_next_quiz').show();
        $('.cmd_next_quiz1').hide();
        $('.cmd_next_quiz2').hide();
        $('.subject_instruc').hide();
        $('.main_test_page').show();
        $('.quiz_starts').hide();
        //alert(tminus+"tminus")
        if(tminus=="0:00")
          $('.div_success_test_timeout').fadeIn('fast');
        else
          $('.div_success_test').fadeIn('fast');
      }
    });
  }
  
  $('.kingster-copyright-left').html("<font style='line-height:24px;'>Copyright &copy; 2019. TestPort.ng<br><font style='color:#999; font-size:14px;'>Developed by <a href='mailto:donchibobo@gmail.com'>CATech</a></font></font>");



  $('body').on('click', '.quiz_options li input', function () {
    var class1 = $(this).attr("value");
    $('#txtans1').val(class1);
  });


  
  $('body').on('click', '.view_answers', function () {
    var id_sch = $(this).attr("id_sch");
    var ids_arr = $(this).attr("ids_arr");
    var subject_id = $(this).attr("subject_id");

    $('.view_answers').hide();
    $('.view_answers1').show();

    var datastring='id_sch='+id_sch
    +'&ids_arr='+ids_arr
    +'&subject_id='+subject_id;

    $.ajax({
      type: "POST",
      url : site_urls+"node/show_my_answers",
      data: datastring,
      timeout: 30000, // 30 second timeout
      success : function(data){

        $('.view_answers').show();
        $('.view_answers1').hide();
        $('.div_success_test_timeout, .div_success_test').hide();
        
        $('.div_show_perfomance').html(data).fadeIn('fast');
    
      },error : function(data, timeouts){
        $('.view_answers').show();
        $('.view_answers1').hide();

        if(timeouts==="timeout"){
          alert("Time out, please try again later");
        }else{
          $(".err_msg").show().html('<div class="Errormsg">Poor Network Connection!</div>');
        }
      }
    });
  });



  $('body').on('click', '.btn_delete', function () {
    $('#delete_dv').show();
    $('.cover_body').show();
    var for_id = $(this).attr("for_id");
    var for_page = $(this).attr("for_page");
    $('#txtall_id').val(for_id);
    $('#txtall_page').val(for_page);
  });



  $('body').on('click', '.cmd_next_quiz', function () {
    var isitChecked = $('.quiz_options li input').is(":checked");
    if(isitChecked == true){
      var checkedIds = $(".chk:checked").map(function() {
        return this.value;
      }).toArray();
      $('#txtans1').val(checkedIds.join(", "));
    }

    var txtans1 = $("#txtans1").val();
    var txtrandom_quiz = $("#txtrandom_quiz").val();
    var txttotalquiz = $("#txttotalquiz").val();
    var txtpage_number = $("#txtpage_number").val();
    var qid_intro = $("#qid_intro").val();
    var subject_id = $(this).attr("subject_id");
    var test_types = $(this).attr("test_types");
    var test_board = $(this).attr("test_board");
    var ids_arr = $(this).attr("ids_arr");
    var noOfYrs = $(this).attr("noOfYrs");

    var txtpage_number1 = retrieve_cookie('txtpage_number');
    var txttotalquiz1 = retrieve_cookie('txttotalquiz');

    if(txtpage_number1!="" && txttotalquiz1!=""){ // incase i refresh, it shud retain the page num
      var txttotalquiz = txttotalquiz1;
      var txtpage_number = txtpage_number1;
    }

    $(".alert_msg").hide();
    create_cookie('onGoingTest', 1);
    
    // if(txtans1==""){
    //   $(".alert_msg").fadeIn('fast').html('<div>Please select an answer!</div>');
    //   return false;
    // }else{

    $('.fade_questions').show();
    $('.cmd_next_quiz').hide();
    $('.cmd_next_quiz1').show();

    var datastring='txtans1='+txtans1
    +'&txtrandom_quiz='+txtrandom_quiz
    +'&qid_intro='+qid_intro
    +'&test_types='+test_types
    +'&test_board='+test_board
    +'&noOfYrs='+noOfYrs
    +'&ids_arr='+ids_arr
    +'&tasks=nexts'
    +'&subject_id='+subject_id;


    // alert(txtpage_number)
    // alert(txttotalquiz)

    create_cookie('txtpage_number', parseInt(txtpage_number)+1);
    create_cookie('txttotalquiz', txttotalquiz);

    $.ajax({
      type: "POST",
      url : site_urls+"node/store_my_ansa",
      data: datastring,
      timeout: 30000, // 30 second timeout
      success : function(data){

        $('.cmd_prev_quiz_i').show();
        $('.cmd_prev_quiz_j').hide();

        var txtpage_number1 = parseInt(txtpage_number) + 1;

        if(parseInt(txtpage_number) < parseInt(txttotalquiz)){
          $("#txtpage_number").val(txtpage_number1);
          $('.cmd_next_quiz').show();
          $('.cmd_next_quiz1').hide();


        }else if(parseInt(txtpage_number) >= parseInt(txttotalquiz)){ // if the total question is equal to the page number, show done and submit to database
        //}else{

          // alert(txtpage_number)
          // alert(txttotalquiz)

          $('.cmd_next_quiz').hide();
          $('.cmd_next_quiz1').show();
          $('.cmd_next_quiz2').show();
          //alert('ddd')
          //$(".cmd_sub_answers").click();
          //clearThisSession(id1, subject_id);
          clearThisSession(qid_intro, subject_id, test_board, ids_arr);

        }
        
        $('#txtans1').val('');
        setTimeout(function(){
          $('.fade_questions').fadeOut('fast');
          $('.scroll_inner_quiz').fadeIn('fast').html(data);
          $("#txtpage_number_h").html(txtpage_number1+".");
          //$('.cmd_prev_quiz_i').show();
          // $('.cmd_prev_quiz_i').hide();
          // $('.cmd_prev_quiz_j').hide();
        },200);

        setTimeout(function(){
          $("html, body").animate({scrollTop:$('.scroll_inner_quiz').offset().top-200}, 300);
        },700);

        // clear the cookies bcos im active again
        //create_cookie('txtpage_number', '');
        //create_cookie('txttotalquiz', '');
    
      },error : function(data, timeouts){
        if(timeouts==="timeout"){
          alert("Time out, please try again later");
        }else{
          $(".err_msg").show().html('<div class="Errormsg">Poor Network Connection!</div>');
        }
        $('.cmd_next_quiz').show();
        $('.cmd_next_quiz1').hide();
      }
    });
    //}
  });



  $('body').on('click', '.cmd_prev_quiz', function () {
    var txtans1 = $("#txtans1").val();
    var txtrandom_quiz = $("#txtrandom_quiz").val();
    var txttotalquiz = $("#txttotalquiz").val();
    var txtpage_number = $("#txtpage_number").val();
    var qid_intro = $("#qid_intro").val();
    var subject_id = $(this).attr("subject_id");
    var test_types = $(this).attr('test_types');
    var test_board = $(this).attr('test_board');
    var ids_arr = $(this).attr("ids_arr");
    var noOfYrs = $("#txtyears").val();

    var txtpage_number1 = retrieve_cookie('txtpage_number');
    var txttotalquiz1 = retrieve_cookie('txttotalquiz');

    if(txtpage_number1!="" && txttotalquiz1!=""){ // incase i refresh, it shud retain the page num
      var txttotalquiz = txttotalquiz1;
      var txtpage_number = txtpage_number1;
    }

    $(".alert_msg").hide();
  
    $('.cmd_prev_quiz').hide();
    $('.cmd_prev_quiz1').show();

    var datastring='txtans1='+txtans1
    +'&txtrandom_quiz='+txtrandom_quiz
    +'&qid_intro='+qid_intro
    +'&test_types='+test_types
    +'&test_board='+test_board
    +'&noOfYrs='+noOfYrs
    +'&ids_arr='+ids_arr
    +'&tasks=prevs'
    +'&subject_id='+subject_id;

    //alert(txtpage_number)
    //alert(txttotalquiz)

    create_cookie('txtpage_number', parseInt(txtpage_number)-1);
    create_cookie('txttotalquiz', txttotalquiz);

    if(txtpage_number == 2){
        $('.cmd_prev_quiz1').hide();
    }

    $.ajax({
      type: "POST",
      //url : site_urls+"node/store_my_ansa_prev", // for prev
      url : site_urls+"node/store_my_ansa",
      data: datastring,
      timeout: 30000, // 30 second timeout
      success : function(data){

        $('.cmd_prev_quiz_i').hide();
        $('.cmd_prev_quiz_j').hide();

        if(txtpage_number == 2){
          $('.cmd_prev_quiz1').hide();
        }else{

          if(txtpage_number < txttotalquiz){
            var txtpage_number1 = parseInt(txtpage_number) - 1;
            if(txtpage_number1 <= 1) txtpage_number1 = 1;

            $("#txtpage_number").val(txtpage_number1);
            $('.cmd_prev_quiz').show();
            $('.cmd_prev_quiz1').hide();
            $('.fade_questions').show();

            $('.cmd_prev_quiz_i').show();
            $('.cmd_prev_quiz_j').hide();

          }else{ // if the total question is equal to the page number, hide the prev btn
            $('.cmd_prev_quiz').hide();
            $('.cmd_prev_quiz1').show();
            //$('.cmd_next_quiz2').show();
            //$(".cmd_sub_answers").click();

            $('.cmd_prev_quiz_i').show();
            $('.cmd_prev_quiz_j').hide();
          }
        }

        if(txtpage_number1==undefined){
          txtpage_number1 = 1;
        }
      
        $('#txtans1').val('');
        setTimeout(function(){
          $('.fade_questions').fadeOut('fast');
          $('.scroll_inner_quiz').fadeIn('fast').html(data);
          $("#txtpage_number_h").html(txtpage_number1+".");
        },200);

        setTimeout(function(){
          $("html, body").animate({scrollTop:$('.scroll_inner_quiz').offset().top-200}, 300);
        },700);

        // clear the cookies bcos im active again
        create_cookie('txtpage_number', '');
        create_cookie('txttotalquiz', '');
    
      },error : function(data, timeouts){
        $('.cmd_prev_quiz').show();
        $('.cmd_prev_quiz1').hide();
        if(timeouts==="timeout"){
          alert("Time out, please try again later");
        }else{
          $(".err_msg").show().html('<div class="Errormsg">Poor Network Connection!</div>');
        }
      }
    });

  });



  $('body').on('click', '.start_main_test', function () {
    var self = this;
    $('.tawk_to').hide();
    $('.started_text_value').val(1);
    create_cookie('onGoingTest', 1);

    //resize_me();
    $('.cmd_trigger').trigger('click');
    $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'});
    var studid = $(this).attr('studid');
    var id1 = $(this).attr('id1');
    var is_new_rec = $(this).attr('is_new_rec');

    var instructn = $(this).attr('instructn');
    var set_time = $(this).attr('set_time');
    var test_types = $(this).attr('test_types');
    var test_board = $(this).attr('test_board');
    
    //var noOfQuest = $(this).attr('noOfQuest');
    var noOfQuest = $("#txt_no_of_quests").val();
    var subject_id = $(this).attr('subject_id');
    var noOfYrs = $("#txtyears").val();
    var schs = $(this).attr('schs');
    var ids = $(this).attr('ids');
    var subjects_caption = $(this).attr('subjects_caption');

    //var txtrandom_quiz = $("#txtrandom_quiz").val();

    testStart(studid, id1, is_new_rec, self, instructn, set_time, test_types, test_board, noOfQuest, subject_id, noOfYrs, schs, ids, subjects_caption);

    //alert('Still in progress.....');
  });



  function testStart(studid, id1, is_new_rec, self, instructn, set_time, test_types, test_board, noOfQuest, subject_id, noOfYrs, schs, ids, subjects_caption){
    //setTimeout(function(){
      $(".loaders").hide();
      //$('.subject_instruc').hide();
      //$('.main_test_page').fadeIn('fast');
      
      totalAmount = 0;
      clearTimeout(timeloop);
      localStorage.removeItem('countDown');

      var datastring='id1='+id1
      +'&schs='+schs
      +'&set_time='+set_time
      +'&test_types='+test_types
      +'&test_board='+test_board
      +'&noOfQuest='+noOfQuest
      +'&subject_id='+subject_id
      +'&noOfYrs='+noOfYrs
      +'&studid='+studid
      +'&ids='+ids
      +'&subjects_caption='+subjects_caption
      //+'&txtrandom_quiz='+txtrandom_quiz
      +'&instructn='+instructn
      +'&is_new_rec='+is_new_rec;

      //alert(datastring);

      $.ajax({
        type : "POST",
        url : site_urls+"node/start_main_quiz",
        data : datastring,
        timeout: 30000, // 30 second timeout
        success : function(data){
          $("html, body").animate({ scrollTop: 0 }, "fast");
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'});
          $('.subject_instruc').hide();
          $('.main_test_page').html(data).fadeIn('fast');
          var reqVal = $('#request').val();
          var parAmt = parseInt(reqVal);
          if (timeloop) {
              clearTimeout(timeloop);
          }
          totalAmount = parAmt * 60;
          $('#request').val(" ");
          timeSet();

          
          setTimeout(function(){
            $('.fade_questions').fadeOut('fast');
          },400);

        },error : function(data, timeouts){
          if(timeouts==="timeout"){
            alert("Time out, please try again later");
          }
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'});
        }
      });
  }




  $('body').on('click', '.blog_pagn a', function (e) {
    e.preventDefault();
    var self = $(this);
    var pageNum = self.attr('data-ci-pagination-page');

    var isitChecked = $('.quiz_options li input').is(":checked");
    if(isitChecked == true){
      var checkedIds = $(".chk:checked").map(function() {
        return this.value;
      }).toArray();
      $('#txtans1').val(checkedIds.join(", "));
    }

    var txtans1 = $("#txtans1").val();
    var txtrandom_quiz = $("#txtrandom_quiz").val();
    var txttotalquiz = $("#txttotalquiz").val();
    var txtpage_number = $("#txtpage_number").val();
    var qid_intro = $("#qid_intro").val();
    var subject_id = $('.blog_pagn span').attr("subject_id");
    var test_types = $('.blog_pagn span').attr("test_types");
    var test_board = $('.blog_pagn span').attr("test_board");
    var ids_arr = $('.blog_pagn span').attr("ids_arr");
    var noOfYrs = $('.blog_pagn span').attr("noOfYrs");
    var actns = $(this).attr("actns");

    $(".alert_msg").hide();
    create_cookie('onGoingTest', 1);

    //alert(actns)
    
    $('.fade_questions').show();
    // $('.cmd_next_quiz').hide();
    // $('.cmd_next_quiz1').show();

    //$('.next_prev_btn').removeClass('next_prev_btn').addClass('next_prev_btn1');

    var datastring='txtans1='+txtans1
    +'&txtrandom_quiz='+txtrandom_quiz
    +'&qid_intro='+qid_intro
    +'&test_types='+test_types
    +'&test_board='+test_board
    +'&noOfYrs='+noOfYrs
    +'&ids_arr='+ids_arr
    +'&tasks='+actns
    +'&subject_id='+subject_id;

    //alert(pageNum);
    //alert(datastring);

    $.ajax({
      type: "POST",
      //url : site_urls+"node/store_my_ansa",
      url: site_urls+'node/questions/'+pageNum,
      data: datastring,
      timeout: 30000, // 30 second timeout
      success : function(data){

        var txtpage_number1 = parseInt(pageNum) + 1;

        // if(pageNum <= 1){
        //   $('.include_class').addClass('next_prev_btn_no_radius');
        // }

        if(parseInt(pageNum) < parseInt(txttotalquiz)){
          $("#txtpage_number").val(txtpage_number1);

        }else if(parseInt(pageNum) > parseInt(txttotalquiz)){ // if the total question is equal to the page number, show done and submit to database
          clearThisSession(qid_intro, subject_id, test_board, ids_arr);
          return false;
        }
        
        $('#txtans1').val('');
        setTimeout(function(){
          $('.fade_questions').fadeOut('fast');
          $('.scroll_inner_quiz').fadeIn('fast').html(data);
          //$("#txtpage_number_h").html(txtpage_number1+".");
          $("#txtpage_number_h").html(pageNum+".");
        },200);

        setTimeout(function(){
          $("html, body").animate({scrollTop:$('.scroll_inner_quiz').offset().top-200}, 300);
        },700);
    
      },error : function(data, timeouts){
        if(timeouts==="timeout"){
          alert("Time out, please try again later");
        }else{
          $(".err_msg").show().html('<div class="Errormsg">Poor Network Connection!</div>');
        }
        $('.cmd_next_quiz').show();
        $('.cmd_next_quiz1').hide();
      }
    });

  });




  var totalAmount = localStorage.getItem('countDown') || 0,
  timeloop;


  if (totalAmount) {
    timeSet();
  }


  function timeSet () {
    totalAmount--;
    // Refresh value in localStorage
    localStorage.setItem('countDown', totalAmount);

    // If countdown is over, then remove value from storage and clear timeout
    if (totalAmount < 0 ) {
        localStorage.removeItem('countDown');
        totalAmount = 0;
        clearTimeout(timeloop);

        //$('.subject_instruc').hide();
        //$('.main_test_page').show();
        //$('.quiz_starts').show();
        //$('.div_success_test_timeout').fadeIn('fast');

        $('#txt_time_finished').val(0);

        setTimeout(function(){
          $("html, body").animate({scrollTop:$('.scroll_inner_quiz').offset().top-240}, 300);
          $('#cmd_submit_answers_timeout').trigger('click');
          //alert('sssddd');
        },400);

        return;
    }
    $('#txt_time_finished').val(totalAmount);

    var minutes = parseInt(totalAmount/60);
    var seconds = parseInt(totalAmount%60);

    if(seconds < 10)
        seconds = "0"+seconds;

    if(minutes == 0 && seconds == 5){
      $('.contd_quiz').trigger('click');
    }

    if(minutes <= 0 && seconds <= 59){
      $('#tminus_1').css('color', 'red');
      $('#tminus_2').css('color', 'red');
    }else{
      $('#tminus_1').css('color', '#5AF');
      $('#tminus_2').css('color', '#093');
    }

    $('#tminus').val(minutes + ":" + seconds);
    $('#tminus_1').html(minutes + "mins, " + seconds+"secs");
    $('#tminus_2').html(minutes + "mins, " + seconds+"secs");

    timeloop = setTimeout(timeSet, 1000);
  }


  $("#resets").click(function(){
    totalAmount = 0;
    clearTimeout(timeloop);
    localStorage.removeItem('countDown');
  });




  $('body').on('click', '.login_btn_i', function () {
    $('.div_contents').hide();
    $('#div_contents, .choose_subjects').hide();
    $('.div_reg_login').fadeIn('fast');
    $(this).html('&laquo; BACK').removeClass('login_btn_i').addClass('back_to_main');
  });


  $('body').on('click', '.back_to_main', function () {
    $('.div_reg_login').hide();
    $('.div_contents, .choose_subjects').fadeIn('fast');

    $('.back_to_main').removeClass('back_to_main').addClass('login_btn').html('<i class="fa fa-lock"></i> Login');
    $('.back_to_main1').removeClass('login_btn').addClass('back_to_main').html('&laquo; BACK');
  });


  
  $('body').on('mousedown', '.create_acct', function () {
    myMaths1();
    $('.from_login').hide();
    $('.from_reg').fadeIn('fast');
  });


  $('body').on('mousedown', '.forgot_pass', function () {
    $('.from_login').hide();
    $('.from_f_password').fadeIn('fast');
  });


  $('body').on('mousedown', '.login_here', function () {
    $('.from_reg, .from_f_password').hide();
    $(".alert_msg1").hide();
    $('.from_login').fadeIn('fast');
  });



  $('body').on('click', '.cmd_done', function () {
    $(".sec_form, .sec_form_resp").hide();
    $(".alert_msg1").hide();
    $(".first_form").fadeIn('fast');
    // direct me to the test to pertake on it
  });



  $('body').on('click', '.cmd_done_buy, .cmd_back_lists', function () {
    window.location = site_urls+"resources/past-questions/";
  });


  $('body').on('click', '.cmd_back_lists1', function () {
    window.location = site_urls+"resources/tutorial-videos/";
  });


  $('body').on('click', '.click_link', function () {
    var sources = $(this).attr('sources');
    var id1 = $(this).attr('id1');
    window.location = site_urls+"resources/view/"+sources+"/"+id1+"/";
  });



  $('body').on('click', '.cmd_create_acct', function () {
    var self = this;
    $(".alert_msg1").hide();
    $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'}).val("Please wait...");

    $.ajax({
      type : "POST",
      url : site_urls+"node/signup_acct",
      data: $(".form_acct").serialize(),
      cache : false,
      dataType: 'json',
      timeout: 30000, // 30 second timeout
      success : function(data){
        //alert(data.msg)
        if(data.type=="success"){
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("Create Account");
          $(".first_form").hide();
          $(".sec_form").fadeIn('slow');
          $(".alert_msg1").hide();

          //var names = $("#txtnames").val();
          var names = data.msg;
          var firstWord = names.split(' ')[0];

          $(".php_login, .php_login1, .login_btn_j").hide();
          $(".java_login1").show().html('<i class="fa fa-user"></i> '+firstWord);
          $(".java_login2").show();
          $(".java_login").show();
          $(".java_login a").html('<i class="fa fa-user"></i> '+firstWord);
          $(".java_logout, .java_logout1").show();
          $(".form_acct")[0].reset();

          $(".java_login_show").show();
          $(".java_login_show").attr('memid', data.memid);

          setTimeout(function(){
            myMaths1();
          },400);

        }else{
          $(".alert_msg1").show().html('<div class="Errormsg">'+data.msg+'</div>').addClass('alert-danger');
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("Create Account");
        }

      },error : function(data, timeouts){
        if(timeouts==="timeout"){
          alert("Time out, please try again later");
        }else{
          //$(".alert_msg1").show().html('<div class="Errormsg">Poor Network Connection!</div>').addClass('alert-danger');
          $(".alert_msg1").show().html('<div class="Errormsg">'+data.msg+'</div>').addClass('alert-danger');
        }
        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("Create Account");
      }
    });
  });



  $('body').on('click', '.cmd_res_pass', function () {
    var self = this;
    $(".alert_msg1").hide();
    $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'}).val("Please wait...");

    $.ajax({
      type : "POST",
      url : site_urls+"node/send_pass_code",
      data: $(".form_resp").serialize(),
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        if(data=="msg_sent"){
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("Reset Password");
          $(".first_form_resp").hide();
          $(".sec_form_resp").fadeIn('slow');
          $(".alert_msg1").hide();
          $(".form_resp")[0].reset();

        }else{
          $(".alert_msg1").show().html('<div class="Errormsg">'+data+'</div>').addClass('alert-danger');
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("Reset Password");
        }

      },error : function(data, timeouts){
        if(timeouts==="timeout"){
          alert("Time out, please try again later");
        }else{
          $(".alert_msg1").show().html('<div class="Errormsg">'+data+'</div>').addClass('alert-danger');
        }
        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("Reset Password");
      }
    });
  });



  var unames = retrieve_cookie('unames');
  var pass1 = retrieve_cookie('pass1');
  var isitChecked = retrieve_cookie('isitChecked');

  if(unames!="") $("#txtuser").val(unames); else $("#txtuser").val('');
  if(pass1!="") $("#txtpass").val(pass1); else $("#txtpass").val('');
  if(isitChecked!="") $("#rememberme").prop('checked', true); else $("#rememberme").prop('checked', false);




  $(".cmd_signin").click(function(){
    var self = this;
    $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'}).val("Please wait...");
    $(".alert_msg_login").hide();
    var txtuser = $("#txtuser").val();
    var txtpass = $("#txtpass").val();
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/logmein",
      data: $(".login_form").serialize(),
      cache : false,
      dataType: 'json',
      timeout: 30000, // 30 second timeout
      success : function(data){
        if(data.type=="success"){

          var isitChecked = $('#rememberme').is(":checked");
          if(isitChecked == true){
            create_cookie('unames', txtuser);
            create_cookie('pass1', txtpass);
            create_cookie('isitChecked', isitChecked);
          }else{
            create_cookie('unames', "");
            create_cookie('pass1', "");
            create_cookie('isitChecked', "");
          }

          //alert(isitChecked)
          $(".login_form")[0].reset();

          $(".php_login, .php_login1, .login_btn_j").hide();
          $(".java_login1").show().html('<i class="fa fa-user"></i> '+data.msg);
          $(".java_login2").show();
          $(".java_login").show();
          $(".java_login_show").show();
          $(".java_logout, .java_logout1").show();
          $(".back_to_main").click();
          $(".java_login a").html('<i class="fa fa-user"></i> '+data.msg);

          $(".java_login_show").attr('memid', data.memid);
          
          setTimeout(function(){
            $(".alert_msg_login").hide();
          },700);

        }else{
          $(".alert_msg_login").show().html('<div class="Errormsg">'+data.msg+'</div>').addClass('alert-danger');
        }

        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("LOGIN");

      },error : function(data, timeouts){
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("LOGIN");
          if(timeouts==="timeout"){
            alert("Time out, please try again later");
          }else{
            $(".alert_msg_login").show().html('<div class="Errormsg">Poor Network Connection!</div>').addClass('alert-danger');
          }
      }
    });
  });


  $(".cmd_res_pass1").click(function(){
    var self = this;
    $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'}).val("Please wait...");
    $(".alert_msg_res").hide();
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/logmein_reset",
      data: $(".reset_form").serialize(),
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        if(data=="success"){
          $(".reset_form")[0].reset();
          setTimeout(function(){
            $(".alert_msg_res").hide();
          },700);

          $(".from_reset").hide();
          $(".from_reset1").fadeIn('fast');

        }else{
          $(".alert_msg_res").show().html('<div class="Errormsg">'+data+'</div>').addClass('alert-danger');
        }

        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("RESET PASSWORD");

      },error : function(data, timeouts){
          $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("RESET PASSWORD");
          if(timeouts==="timeout"){
            alert("Time out, please try again later");
          }else{
            $(".alert_msg_res").show().html('<div class="Errormsg">Poor Network Connection!</div>').addClass('alert-danger');
          }
      }
    });
  });



  $(".send_message").click(function(){
    var self = this;
    $(self).attr('disabled', true).css({'opacity': '0.6', 'color': '#ccc'}).val("Please wait...");
    $(".alert_msg_contact").hide();
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/send_contact_msg",
      data: $(".contact_msg").serialize(),
      cache : false,
      timeout: 30000, // 30 second timeout
      success : function(data){
        if(data=="msg_sent"){
          $(".contact_msg")[0].reset();
          $(".alert_msg_contact").show().html('<div class="Errormsg"><b>Your message has been sent!</b></div>').removeClass('alert-danger').addClass('alert-success');
          
          setTimeout(function(){
            $(".alert_msg_contact").hide();
          },1500);

        }else{
          $(".alert_msg_contact").show().html('<div class="Errormsg">'+data+'</div>').addClass('alert-danger');
        }

        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("SEND MESSAGE");

      },error : function(data, timeouts){
        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'}).val("SEND MESSAGE");
        if(timeouts==="timeout"){
          alert("Time out, please try again later");
        }else{
          $(".alert_msg_contact").show().html('<div class="Errormsg">Poor Network Connection!</div>').addClass('alert-danger');
        }
      }
    });
  });




  /**
    * Disable right-click of mouse, F12 key, and save key combinations on page
    * By Arthur Gareginyan (arthurgareginyan@gmail.com)
    * For full source code, visit https://mycyberuniverse.com
    */
  window.onload = function() {
    document.addEventListener("contextmenu", function(e){
      e.preventDefault();
    }, false);
    document.addEventListener("keydown", function(e) {
    //document.onkeydown = function(e) {
      // "I" key
      if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
        disabledEvent(e);
      }
      // "J" key
      if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
        disabledEvent(e);
      }
      // "S" key + macOS
      if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
        disabledEvent(e);
      }
      // "U" key
      if (e.ctrlKey && e.keyCode == 85) {
        disabledEvent(e);
      }
      // "F12" key
      if (event.keyCode == 123) {
        disabledEvent(e);
      }
    }, false);
    function disabledEvent(e){
      if (e.stopPropagation){
        e.stopPropagation();
      } else if (window.event){
        window.event.cancelBubble = true;
      }
      e.preventDefault();
      return false;
    }
  };
  
  

  

  // $(function() {
  //   var f = function() {
  //     $(this).next().text($(this).is(':checked') ? ' ON' : ' OFF');
  //   };
  //   $('input').change(f).trigger('change');
  // });


  $('body').on('change', '#rememberme', function () {
    $(this).next().text($(this).is(':checked') ? ' ON' : ' OFF');
  });

  setTimeout(function(){
    //$('#rememberme').trigger('change');
    $("#rememberme").prop('checked', true);
  },300);



  function myMaths1(){
  var rndnum=Math.random()*(9-1)+1;
  var rndnum1=Math.random()*(9-1)+1;
  rndnum=Math.ceil(rndnum);
  rndnum1=Math.ceil(rndnum1);
  document.getElementById('txtsum1').value = rndnum+rndnum1;
  $("#txtmaths").attr("placeholder", 'What is '+rndnum+'+'+rndnum1+'=?');
}





})

})(jq);




function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
                     'expires=' + expires + ';' +
                     'path=' + path + ';';
}


function retrieve_cookie(name) {
  var cookie_value = "",
    current_cookie = "",
    name_expr = name + "=",
    all_cookies = document.cookie.split(';'),
    n = all_cookies.length;
 
  for(var i = 0; i < n; i++) {
    current_cookie = all_cookies[i].trim();
    if(current_cookie.indexOf(name_expr) == 0) {
      cookie_value = current_cookie.substring(name_expr.length, current_cookie.length);
      break;
    }
  }
  return cookie_value;
}