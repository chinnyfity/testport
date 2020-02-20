
(function ($) {
    "use strict";

    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit', function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        if(check == true){
            
            $('.login100-form-btn').attr('disabled', true).css({'background': '#FFA275', 'color': '#ccc'});
            $(".alert_msg").hide();
            var site_urls = $("#txtsite_url").val();
            //var txtselect = $("#txtselect").val();
            $.ajax({
                type : "POST",
                url : site_urls+"node/logme_adms",
                data: $(".login100-form").serialize(),
                //cache : false,
                success : function(data){
                  //alert(data)
                  if(data=="successor1"){
                      setTimeout(function(){
                        $(".alert_msg").fadeOut('slow');
                      },2500);

                      window.location = site_urls+"admin/";
                      $('.login100-form-btn').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});

                  }else{
                      $('.login100-form-btn').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
                      $(".alert_msg").show().html('<div class="Errormsg">'+data+'</div>');
                  }

                },error : function(data){
                    $('.login100-form-btn').removeAttr('disabled').css({'background': '#f7631b', 'color': '#fff'});
                    $(".alert_msg").show().html('<div class="Errormsg">'+data+'</div>');
                }
            });
        }

        //return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    

})(jQuery);