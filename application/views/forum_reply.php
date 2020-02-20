  

    
    <?php if($page_name == "replyloads" || $page_name == "viewreplies"){ ?>
        <script type="text/javascript" src="<?=base_url()?>js/jquery-2.2.4.min.js"></script>
    <?php } ?>
    
    <!-- <script src="<?=base_url(); ?>js/jscripts1.js"></script> -->
    <script>
    var jq = $.noConflict();
    (function($){
        var site_urls = $('#txtsite_url').val();
        $(".uploadimage1_forum_rep").on('submit',(function(e) {
            e.preventDefault();
            $(".errs_rep").hide();
            var selecteds1 = retrieve_cookie('selected_file1');
            var edit_ids = $('#edit_ids').val();
            var memid_rep = $('#memid_rep').val();
            var txtrep_cnts = $('#txtrep_cnts').val();
            var new_cnt = parseInt(txtrep_cnts)+1;
            
            if($('#post_content_rep').val() != '' || selecteds1 == 1){ // 1 means u uploaded a file
                $('#cmdPosts').attr('disabled', true).css({'opacity': '0.5'});
                $(".hide_txtbox_rep").fadeIn('fast');
                $.ajax({
                    url : site_urls+"node/post_comments_rep",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        if(data=="inserted" || data=="updateds"){
                            $('#txtrep_cnts').val(new_cnt);
                            $('.newcount').html(new_cnt);
                            $("#form3")[0].reset();
                            $('#cmdPosts').removeAttr('disabled').css({'opacity': '1'});
                            bringProducts_rep(memid_rep);
                            $('#selectedCaption1_rep').empty().html('No file selected');
                            setTimeout(function(){
                                $(".hide_txtbox_rep").fadeOut('fast');
                            },500);
                        }else{
                        
                            $('#cmdPosts').removeAttr('disabled').css({'opacity': '1'});
                            $(".errs_rep").fadeIn('fast').html(data);
                            setTimeout(function(){
                            $(".hide_txtbox_rep").fadeOut('fast');
                            },500);
                        }
                    
                    },error : function(data){
                        $(".errs_rep").fadeIn('fast').html('Error! Network Connection Failed!');
                        $('#cmdPosts').removeAttr('disabled').css({'opacity': '1'});
                    }
                });
            }else{
                $(".errs_rep").fadeIn('fast').html('Please reply on this or upload an image.');
            }
        }));



        function bringProducts_rep(memid_rep){
            var fr_ids = $('#fr_ids').val();
            var page = 0;
            var datastring1='page='+page
            +'&fr_ids='+fr_ids
            +'&txtmemsid='+memid_rep;

            $('.srch_captn').show();
            $(".loaders_rep").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");
            $("html, body").animate({ scrollTop: 400 }, "fast");
            $.ajax({
                type : "POST",
                url : site_urls+"node/getForums_reps",
                data : datastring1,
                cache : false,
                success : function(data){
                    $("#ajax_table_forum_rep").empty().append(data);
                    $('#load_more_mba_rep').data('val', ($('#load_more_mba_rep').data('val')));
                    $(".loaders_rep").hide();
                },error : function(data){
                    $(".loaders_rep").hide();
                }
            });
        } 



        $('body').on('click', '#load_more_mba_rep', function () {
            var page = $(this).data('val');
            var fr_ids = $('#fr_ids').val();
            var txtmemsid = $('#memid_rep').val();
            
            $('#load_more_mba_rep').hide();
            $('#load_more_mba_rep1').show();
            var datastring='page='+page
            +'&txtmemsid='+txtmemsid
            +'&fr_ids='+fr_ids;
            
            $.ajax({
                type : "POST",
                url : site_urls+"node/getForums_reps",
                data : datastring,
                cache : false,
                success : function(data){
                var responseReturn = data.match(/Edit this post/g);
                
                if(responseReturn != null){
                    $("#ajax_table_forum_rep").append(data);
                    $('.load_more_bt_rep').data('val', ($('.load_more_bt_rep').data('val')+1));
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                }else{
                    $('#load_more_mba_rep').hide();
                    $('#load_more_mba_rep1').show();
                    $('.load_more_bt_rep').html('<font style="color:#666 !important;">No more replies!</font>');
                }

                },error : function(data){
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                }
            });
        });


        $(document).ready(function(){
            var page = 0;
            var txtparams = $('#txtparams').val();
            var txtmemsid = $('#memid_rep').val();
            $('#load_more_mba_rep').hide();
            $('#load_more_mba_rep1').show();
            var fr_ids = $('#fr_ids').val();
            var datastring1='page='+page
            +'&fr_ids='+fr_ids
            +'&txtmemsid='+txtmemsid;
            $(".loaders_rep").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");
            $.ajax({
                type : "POST",
                url : site_urls+"node/getForums_reps",
                data : datastring1,
                cache : false,
                success : function(data){
                    var responseReturn = data.match(/Delete this/g);
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                    if(responseReturn != null){
                        if(data.match(/^.*No saved.*$/)){
                            $('.load_more_bt_rep').hide();
                        }else{
                            $('#load_more_mba_rep').data('val', ($('#load_more_mba_rep').data('val')+1));
                        }
                        $("#ajax_table_forum_rep").empty().append(data);
                        $(".loaders_rep").hide();
                    }else{
                        $('#load_more_mba_rep').hide();
                        $('#load_more_mba_rep1').show();
                        $('.load_more_bt_rep').html('<font style="color:#666 !important;">No more replies!</font>');
                        $("#ajax_table_forum_rep").empty().append(data);
                        $(".loaders_rep").hide();
                    }
                    
                },error : function(data){
                    $(".loaders_rep").hide();
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                }
            });


            
            $('body').on('contextmenu', '.forumBox4', function(e) {
                e.stopPropagation();
                var ids = $(this).attr('ids');
                $('.copy_texts').hide();
                $('#copy_texts'+ids).fadeIn('fast');
                $('#cover_contents1'+ids).fadeIn('fast');
                return false;
            });
        });
    })(jq);


    </script>


    <div class="mobile_goback"><i class="fa fa-arrow-left"></i> Go Back</div>

    <section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col ash_color2">
        <!-- <div class="icon-default icon-default2">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
        </div> -->

        
        
        <div class="container shft_top">
            <div class="row _mobiles">
                
				<input type="hidden" id="txtcats1" value="0">

                <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 p-0 left_pics txtcreate_topic">
                    <p class="for_desktop">&nbsp;</p>                    
                    <div class="scrols1">
                        <?php
                        if($forums){
                            $id1 = $forums['id'];
                            $names = ucwords($forums['names']);
                            $topics = $forums['topics'];
                            $messages = nl2br($forums['messages']);
                            $messagesi = $messages;
                            $pics = base_url()."images/no_passport.jpg";
                            $files = $forums['files'];
                            $views = $forums['views'];
                            $views = @number_format($views);
                            $dates = $forums['dates'];
                            //$pic_path = base_url()."watermark.php?image=".base_url()."forum_files/$files&watermark=".base_url()."images/watermrk.png";

                            $pic_path = base_url()."forum_files/$files";
                            
                            $ttls = $this->sql_models->getTopicName($topics, 'id', 'test_boards', 'test_types', 'row');

                            $replies_cnt = $this->sql_models->replyCounts($id1);
                            $replies_cnti = $replies_cnt;
                            $replies_cnt = @number_format($replies_cnt);

                            if(strlen($names)>14)
                                $names_mobile = substr($names, 0, 14)."...";
                            else
                                $names_mobile = $names;
                            ?>
                            <p></p>
                            <div id='forumBox2' class="forumBox4" ids="<?=$id1;?>">
                                <div id="forumBox">
                                    <div class="first_sec nofadediv fadediv<?=$id1;?>">
                                        <div class="forum_img">
                                            <img src='<?=$pics;?>' alt='Loading...' style='border-radius:30px; border:1px #999 solid;'>
                                        </div>

                                        <div class="forum_contents">
                                            <div class="for_dates">
                                                <p style="font-size:16px; color:#8A8A00">
                                                    <b>
                                                        <a href="javascript:;" class="for_desktop1" style="color:#8A8A00;"><?=$names;?></a>

                                                        <a href="javascript:;" class="for_mobile1" style="color:#8A8A00;"><?=$names_mobile;?></a>
                                                    </b>
                                                    <font style="font-size:14px; margin-left:4px; color:#444"><?=time_ago($dates);?> <i class="fa fa-clock-o"></i></font>
                                                </p>
                                                <p style="font-size:15px; color:#444; margin-top:-3px !important;">
                                                    <b>Category:</b> <font style="margin-left:4px;"><?=$ttls;?></font>
                                                </p>
                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                    </div>


                                    <?php
                                        $gen_num1=time();
                                        $gen_num1=substr($gen_num1,6);
                                        $url1 = base_url()."replies/$id1$gen_num1/";
                                        $messages = str_replace("#", "", $messages);
                                        $tweets = $messages;
                                    ?>

                                    <div class="row_contents row_contents1">
                                        <?php if($files!=""){ ?>
                                            <div class="cmt_img cmt_img1 col-md-10 col-sm-10 col-xs-10 nofadediv fadediv<?=$id1;?>">
                                                <span><img src='<?=$pic_path;?>' alt='image'></span>
                                            </div>
                                            <div style="clear: both;"></div>

                                            <div class="col-md-12 col-sm-12 col-xs-12 containerx nofadediv fadediv<?=$id1;?>" style="margin-top: 20px;">
                                                <span>
                                                    <?php
                                                    // if($topics==2) // if its job, allow links
                                                    //     echo makeLinks3(ucfirst($messages));
                                                    // else
                                                        echo makeLinks2(ucfirst($messages));
                                                    ?>
                                                </span>
                                            </div>
                                            
                                        <?php }else{ ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12 containerx nofadediv fadediv<?=$id1;?>">
                                                <span>
                                                <?php
                                                // if($topics==2) // if its job, allow links
                                                //     echo makeLinks3(ucfirst($messages));
                                                // else
                                                    echo makeLinks2(ucfirst($messages));
                                                ?>
                                                </span>
                                            </div>
                                        <?php } ?>
                                        
                                        <label id='copyTarget<?=$id1;?>' style='display:none'>
                                            <?php
                                            // if($topics==2)
                                            //     echo makeLinks3(ucfirst($messagesi))."<br><br>".$url1;
                                            // else
                                                echo makeLinks2(ucfirst($messagesi))."<br><br>".$url1;
                                            ?>
                                        </label>
                                        <div class="cover_contents" id="cover_contents1<?=$id1;?>"></div>
                                        <div class="copy_texts" ids='<?=$id1;?>' id="copy_texts<?=$id1;?>"><spans>Copy Text</spans></div>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-15 comment_stats">
                                        <div class="col-md-4 col-sm-4 col-xs-3 for_cmts" style="backgrounds:blue">
                                            <a href="javascript:;" class="open_comment" frid="<?=$id1;?>" tils="<?=$ttls;?>"><i class="fa fa-comment fa_comment"></i> <?=$replies_cnt;?></a>
                                        </div>

                                        
                                        <div class="col-md-4 col-sm-4 col-xs-5 socials">
                                            <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><i class="fa fa-facebook"></i></a>&nbsp;

                                            <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><i class="fa fa-twitter"></i></a>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4" style="color: #222">
                                            <?=$views;?> views
                                        </div>
                                    </div>

                                </div>

                                <div style="clear:both"></div>
                                <div class="small_comments inputboxes">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="for_dates_">
                                            <form method="post" id="form3" class="uploadimage1_forum_rep" enctype="multipart/form-data" autocomplete="off">
                                                <input type="hidden" name="memid_rep" id="memid_rep" value="<?=$get_mems_id;?>">
                                                <input type="hidden" name="fr_ids" id="fr_ids" value="<?=$frids;?>">

                                                <div class="hide_txtbox_rep" style="display:none;">
                                                    <p style="margin-top:1.6em; font-size:15px; color:#222; text-align: center;"><img src='<?=base_url()?>images/loader.gif' style='width:40px !important;' alt='Loading'/><br>Uploading...</p>
                                                </div>

                                                <p class="main_cmts reply_cmt reply_cmt1">
                                                    <textarea id="post_content_rep" name="post_content_rep" placeholder="Reply this..."></textarea>
                                                    <div id='imgpreview1_rep'></div>
                                                    <div style="clear:both"></div>
                                                    <div class="errs_rep"></div>

                                                    <div class="button_events buttonevent">
                                                        <?php
                                                        if($validate_mem)
                                                        echo '<input type="submit" id="cmdPosts_rep" value="Reply this" class="btn_">';
                                                        else
                                                        echo '<input type="button" id="cmdnoPosts__" value="Reply this" style="opacity:0.5;" class="no_start_tests php_login">';
                                                        ?>

                                                        <?php if($validate_mem){ ?>
                                                            <span id="uploadfiles1_rep"><img style="cursor:pointer; width:auto !important" src="<?=base_url();?>images/upload1.png"></span>
                                                        <?php }else{ ?>
                                                            <span id="cmdnoPosts__" class="no_start_tests php_login"><img style="cursor:pointer; width:auto !important" src="<?=base_url();?>images/upload1.png"></span>
                                                        <?php } ?>
                                                        <span style="margin:5px 0 3px 7px; float:none;"><label style="font-size:14px; color:#333;" id="selectedCaption1_rep">(No file selected)</label></span>
                                                    </div>
                                                    <input type="file" id="file4_rep" name="file4_rep" style="font-size:0.9em; visibility:hiddens; display:none;">
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                            <div style="clear:both"></div>

                            <div class="loaders_rep" style="position:relative; text-align:center !important; color:#777; bottom:1em; margin:2em 0 -5em 0; z-index:99; font-style:italic;"></div>

                            <div id="ajax_table_forum_rep">
                            </div>

                            <div style="clear:both"></div>
                            <a style="clear:both" href="javascript:;" class="load_more_bt_rep wow fadeIn" id="load_more_mba_rep" data-val = "0" data-wow-delay="0.2s">Load more replies </a>
            		        
                            <a href="javascript:;" class="load_more_bt_rep wow fadeIn" id="load_more_mba_rep1" style="color:#ccc; display:none;" data-wow-delay="0.2s"><i>Loading...</i> <img src="<?php echo str_replace('index.php','',base_url()) ?>images/loader.gif" width="18"> </a>

                            <?php
                            }else{
                                echo "<p style='font-size:15px; text-align:center; color:#555; padding-top:15px'>No posts found on your search, redefine your search to find what you are looking for.</p>";
                            }
                            ?>
                    </div>
					<input type="hidden" class="successm" style="display:nones;">
                </div>
            </div>
        </div>
    </section>
    
        
        