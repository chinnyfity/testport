
<div class="topics_2"></div>

<div class="kingster-page-wrapper" id="kingster-page-wrapper">
    <div class="gdlr-core-page-builder-body" style="background-color: #ddd;">

<!-- <input type="hidden" id="txtcounts" value="<?=$pq_count?>" />
<input type="hidden" id="txtsources" value="<?=$sources?>" /> -->


<div class="choose_subjects">



<div class="div_contents_" style="display: nones;"> <!-- Choose Subjects -->
            
    <div class='div_contents_res div_contents_res1'>
        <h3 class='main_titles_res'><?=$page_title?></h3>
        <p class="lil_info lil_info1">Discussion time! Interract with other members here...</p>
    </div>

    <div class="container" style="text-align: center;">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="search_contents">
              <div class="container">
                <div class="col-md-offset-1 col-md-10">
                <div class="row pt-10">

                  <div class="col-lg-6 col-xs-12 p-xs-0">
                    <div class="form-group">
                      <input name="txtkeywd1" type="text" placeholder="Search Keyword" class="form-control txtkeywd1">
                    </div>
                  </div>

                  <div class="col-lg-4 col-sm-8 col-xs-8 pr-lg-5 pl-lg-5 p-md-0 pr-md-0 pl-md-15 pr-xs-0 pl-xs-15 mt-xs--5">
                    <div class="form-group">
                      <select class="txtsrch_test form-control required" name="txtsrch_test">
                        <option value="">All Tests</option>
                          <?php
                            foreach($test_boards as $row):
                                $id = $row['id'];
                                $test_types = $row['test_types'];
                              ?>
                              <option value='<?=$id?>' ><?=$test_types?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                  </div>


                  <div class="col-lg-2 col-sm-3 col-xs-4 p-0 mt-xs--5">
                    <div class="form-group">
                      <button type="button" class="btn btn-lg cmd_search_forum"><i class="fa fa-search"></i> Search</button>
                    </div>
                  </div>
                </div>

                </div>
                </div>
              </div>
              <a name="!"></a>
              <div class="filters">Search here</div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="container pt-40 pb-60 test_div scrollhere1" style="text-align: center;">
        <div class="row pr-sm-0 pl-sm-0">

            <!-- <p style="margin: -20px 0 7px 0; text-align: center; color: #333; padding:0 8px;" class="font-17 font-sm-16 line-height-22"><b>View and download our various past questions and answers for different years and different schools</b></p> -->

            <div class="loaders" style="display:none;"><img src="<?=base_url();?>images/loaderq.gif"></div>

            <!-- <div class="filterResources" style="display: nones;"> -->
                <!-- <p style="text-align: center; font-size: 17px; color: #333 !important;" class="mb-40">Total of <b><?=$pq_count?></b> <?=$sources2?> found</p> -->

                <div class="col-lg-3 col-sm-3 pr-30 pl-5 pr-xs-5 pl-xs-5 for_desktop">
                    <div class="navigates">STATISTICS</div>
                    <div class="navs navs1">
                        <p><b><?=$t_mems?></b> members discussing</p>
                        <p><b><?=$t_thread?></b> threads made</p>
                        <p><b><?=$t_media?></b> media uploaded</p>
                        <p><b><?=$t_discu?></b> topics been discussed</p>
                        <p>Last post made by <b><?=$last_post?></b></p>
                    </div>
                </div>

                <!-- <div class="for_mobile border-bottom-gray1 mt--10 mr-20 ml-20 mb-md-30"></div> -->




                <div class="col-lg-offset-0 col-lg-8 col-md-offset-1 col-md-10 col-sm-12 mt-md-0 mt-sm-0 p-xs-0 mt-xs--20 left_pics txtcreate_topic txtcreate_topic1">
                    <p class="for_desktop scrols">&nbsp;</p>

                    <div class="main_forum">
                        <div class="blog-left-search blog-common-wide btn_house" style="position:relative; z-index:9;">
                            <form method="post" id="form2" class="uploadimage1_forum" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" name="txtmemsid" id="txtmemsid" value="<?=$this->memid;?>">
                                <input type="hidden" name="former_file1" id="former_file1">
                                <input type="hidden" name="edit_ids" id="edit_ids">
                                <?php
                                echo '<span id="txt_srch_forum" class="clickforum" style="display:nones;">Click here to start a new topic <fonts>Post Comment</fonts></span>';
                                ?>
                                <span id="txt_srch_forum1" style="display:none;">
                                <?php if($this->validate_mem){ ?>
                                    <span id="uploadfiles1"><img src="<?=base_url();?>images/upload1.png"> Upload image</span>
                                <?php }else{ ?>
                                    <span id="cmdnoPosts__" class="no_start_tests"><img src="<?=base_url();?>images/upload1.png"> Upload image</span>
                                <?php } ?>
                                    <span style="margin:5px 0 3px 7px; float:none;"><label style="font-size:14px; color:#555;" id="selectedCaption1">(No file selected)</label></span>
                                </span>

                                <select class="txtselectcat" name="txtcats" id="txtcats" style="display:none; background: #fff !important; color: #444 !important;">
                                    <option value="">Select Topic</option>
                                    <option value="0">General Discussion</option>
                                    <?php
                                    if($test_boards){
                                        foreach($test_boards as $row){
                                            $id = $row['id'];
                                            $test_types = $row['test_types'];
                                            echo "<option value='$id'>$test_types</option>";
                                        }
                                    }
                                    ?>
                                </select>


                                <input type="hidden" class="selected_subjs" />

                                

                                <div class="textareas" style="display:none">
                                    <p class="bold_info" style="font-size:15px;">
                                        Apply bold text by surrounding what to bold with * sign, <font class="view_formats">view more of this</font>
                                    </p>
                                    <p class="bold_info1" style="display:none;">
                                        Example: This platform is *awesome*<br>
                                        Gives you "This platform is <b style="color:#000">awesome</b>"<br>
                                        Example: This platform is _awesome_<br>
                                        Gives you "This platform is <bs style="color:#000"><u>awesome</u></bs>"<br>
                                    </p>
                                    <textarea id="post_content" name="post_content" placeholder="Write a comment..."></textarea>


                                    <?php
                                        if(!$this->validate_mem)
                                        echo "<div class='user_login php_login'>Please login to comment!</div>";
                                    ?>
                                    
                                    <div class="errs" style="display: none; clear: both;"></div>

                                    <div class="button_events button_forum">
                                        <?php
                                        if($this->validate_mem)
                                        echo '<input type="submit" id="cmdPosts" value="Post Comment" class="btn_">';
                                        else
                                        echo '<input type="button" id="cmdnoPosts_" class="no_start_tests php_login" value="Post Comment" isSubjects="0" style="opacity:0.5;">';
                                        ?>

                                        <input type="submit" id="cmdPosts" value="Post Comment" class="btn_ java_login_show" style="display:none !important;">

                                        <!-- <input type="button" id="cmdPosts1" value="Post Comment" style="opacity:0.7; display:none !important;"> -->

                                        <a href="javascript:;" class="cancel_posts"><span class="btn-cancel"><span class="fa fa-close"></span> Cancel</span></a>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>

                                <input type="file" id="file4" name="file4" style="font-size:0.9em; visibility:hiddens; display:none;">
                            </form>
                        </div>

                        <p class="topics1">All Threads</p>
                        <p class="job_info" style="display:none;">
                            Any fake jobs posted here will warrant a permanent termination of your account with us!
                        </p>

                        <div class="hide_txtbox" style="display:none;">
                            <p style="margin-top:1.6em; font-size:15px; color:#222; text-align: center;"><img src='<?=base_url()?>images/loader.gif' alt='Loading'/><br>Uploading...</p>
                        </div>

                        <div id='imgpreview1'></div>
                        
                        <div class="loaders_" style="position:relative; text-align:center; color:#777; bottom:1em; margin:2em 0 -5em 0; z-index:9999; font-style:italic;"></div>

                        <div id="ajax_table_forum">
                            <p style="padding:5px;">&nbsp;</p>

                            <?php
                            $page = 0;
                            $txtsrch = "";
                            $txtcats1 = 0;
                            $txtmemsid = $this->memid;


                            
                            $forums = $this->sql_models->fetchForum($page, $txtsrch, $txtcats1);
                            if($forums){
                                foreach ($forums as $rs) {
                                    $id1 = $rs['idf'];
                                    $conid = $rs['conid'];
                                    $names = ucwords($rs['names']);
                                    $topics = $rs['topics'];
                                    $pics = base_url()."images/no_passport.jpg";
                                    $messages = nl2br($rs['messages']);
                                    $messagesi = $messages;
                                    $messages2 = $messages;
                                    $files = $rs['files'];
                                    $views = $rs['views'];
                                    $views = @number_format($views);
                                    $dates = $rs['dates'];
                                    //$pic_path = base_url()."watermark.php?image=".base_url()."forum_files/$files&watermark=".base_url()."images/watermrk.png";

                                    $pic_path = base_url()."forum_files/$files";

                                    if(strlen($messages)>300)
                                        $messages = substr($messages, 0, 300)."...<span style='font-weight:normal; color:#69C;'>read more</span>";

                                    if(strlen($messages2)>150)
                                        $messages2 = substr($messages2, 0, 150)."...";

                                    if(strlen($names)>14)
                                        $names_mobile = substr($names, 0, 14)."...";
                                    else
                                        $names_mobile = $names;

                                    $ttls = $this->sql_models->getTopicName($topics, 'id', 'test_boards', 'test_types', 'row');

                                    $replies_cnt = @number_format($this->sql_models->replyCounts($id1));
                                    ?>
                                    <div id='forumBox2' class="forumBox3 forumBox_scroll<?=$id1;?>" ids="<?=$id1;?>">
                                        <div id="forumBox">
                                            <div class="first_sec">

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
                                                        <?php if($conid==$txtmemsid){ ?>
                                                            <p class="menu_icn" id="menu_icn" ids="<?=$id1;?>"><img src="<?=base_url()?>images/menu_icon1.png"></p>
                                                        <?php }else{ ?>
                                                            <p class="menu_icn">&nbsp;</p>
                                                        <?php } ?>
                                                    </div>

                                                    <?php if($conid==$txtmemsid){ ?>
                                                    <div class="edit_div" id="edit_div<?=$id1;?>">
                                                        <span id='editpost' counters="<?=$id1;?>" messages1="<?=strip_tags(ucfirst($messagesi));?>" topics="<?=$topics;?>" ids="<?=$id1;?>" files="<?=$files;?>" style='cursor:pointer'><a href='javascript:;'>Edit this post &raquo;</a></span>
                                                        <span style='border:none; color:red; cursor:pointer' id='delpost' ids="<?=$id1;?>"><a href='javascript:;' style='color:red;'>Delete this post &raquo;</a></span>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <?php
                                                $gen_num1=time();
                                                $gen_num1=substr($gen_num1,6);
                                                $url1 = base_url()."replies/$id1$gen_num1/";
                                                $messages2 = str_replace("#", "", $messages2);
                                                $tweets = $messages2;
                                            ?>

                                            <div class="row_contents">
                                                <?php if($files!=""){ ?>
                                                    <div class="cmt_img col-md-3 col-sm-12 col-xs-12 img_forum" style="backgrounds:blue">
                                                        <span class="open_comment" frid="<?=$id1;?>" tils="<?=$ttls;?>"><img src='<?=$pic_path;?>' alt='image'></span>
                                                    </div>
                                                    <div class="cmt_note_ mt-md-20 mb-md-10 col-md-9 col-sm-12 col-xs-12 containerx" style="backgrounds:red; line-height:20px;">
                                                        <span class="open_comment" frid="<?=$id1;?>" tils="<?=$ttls;?>">
                                                            <label>
                                                            <?php
                                                            if($topics==2) // if its job, allow links
                                                                echo makeLinks3(ucfirst($messages));
                                                            else
                                                                echo makeLinks2(ucfirst($messages));
                                                            ?>
                                                            </label>
                                                        </span>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="cmt_note_ col-md-12 col-sm-12 col-xs-12 containerx" style="line-height:20px;">
                                                        <span class="open_comment" frid="<?=$id1;?>" tils="<?=$ttls;?>">
                                                            <label>
                                                            <?php
                                                            if($topics==2) // if its job, allow links
                                                                echo makeLinks3(ucfirst($messages));
                                                            else
                                                                echo makeLinks2(ucfirst($messages));
                                                            //echo "here";
                                                            ?>
                                                            </label>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <label id='copyTarget<?=$id1;?>' style='display:none'>
                                                    <?php
                                                    if($topics==2)
                                                        echo makeLinks3(ucfirst($messagesi))."<br><br>".$url1;
                                                    else
                                                        echo makeLinks2(ucfirst($messagesi))."<br><br>".$url1;
                                                    ?>
                                                </label>

                                                <div class="cover_contents" id="cover_contents<?=$id1;?>"></div>
                                                <div class="copy_text" ids='<?=$id1;?>' id="copy_text<?=$id1;?>"><spans>Copy Text</spans></div>
                                            </div>

                                            <div class="col-md-12 col-sm-12 col-xs-12 comment_stats">
                                                <div class="col-md-4 col-sm-4 col-xs-3 for_cmts" style="backgrounds:blue">
                                                    <a href="javascript:;" class="open_comment" frid="<?=$id1;?>" tils="<?=$ttls;?>"><i class="fa fa-comment fa_comment"></i> <?=$replies_cnt;?></a>
                                                </div>

                                                
                                                <div class="col-md-4 col-sm-4 col-xs-5 socials">
                                                    <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><i class="fa fa-facebook"></i></a>&nbsp;

                                                    <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><i class="fa fa-twitter"></i></a>
                                                </div>

                                                <div class="col-md-4 col-sm-4 col-xs-4" style="color: #111">
                                                    <?=$views;?> views
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $forums_rp = $this->sql_models->fetchForumRep1($id1);
                                        if($forums_rp){
                                            $id1i = $forums_rp['id'];
                                            $conid = $forums_rp['conid'];
                                            $ful_namei = ucwords($forums_rp['names']);
                                            $replies = nl2br($forums_rp['replies']);
                                            $filesi = $forums_rp['files'];
                                            $pics = base_url()."images/no_passport.jpg";
                                            $datesi = $forums_rp['dates'];
                                            if(strlen($replies)>90)
                                                $replies = substr($replies, 0, 90)."...read more";

                                            $mydatesi= date("jS F, Y h:i a", strtotime($datesi));
                                            //$path_picsi = base_url()."watermark.php?image=".base_url()."celebs_uploads/$picsi&watermark=".base_url()."images/watermrk.png";  
                                            ?>
                                                <div class="small_comments">
                                                    <div class="col-md-1 col-sm-1 col-xs-2">
                                                        <img src='<?=$pics;?>' alt='image' style='border-radius:30px; border:1px #999 solid;'>
                                                    </div>

                                                    <div class="col-md-10 col-sm-11 col-xs-10">
                                                        <div class="for_dates_">
                                                            <p style="font-size:14px; text-align:left; color:#8A8A00"><b><a href="javascript:;" style="color:#8A8A00;"><?=$ful_namei;?></a></b></p>
                                                            <p class="main_cmts">
                                                                <span class="open_comment" style="cursor:pointer" frid="<?=$id1;?>" tils="<?=$ttls;?>"><?=makeLinks2(ucfirst($replies)); ?></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                        }else{
                                            echo "<p style='margin-bottom:-10px;'>&nbsp;</p>";
                                        }
                                        ?>

                                    </div>
                                    <div style="clear:both"></div>

                                <?php
                                }
                                ?>
                            
                            <?php
                            }else{
                                echo "<p style='font-size:15px; text-align:center; color:#555; padding:15px 8px 0 5px; margin-bottom:3.5em; line-height:20px;'>No posts found on your search, redefine your search to find what you are looking for.</p>";
                            }
                            ?>
                            
                        </div>

                        <!-- <a href="javascript:;" class="load_more_bt wow fadeIn" id="load_more_mba" data-val = "0" data-wow-delay="0.2s">Load more posts </a>
                        <a href="javascript:;" class="load_more_bt wow fadeIn" id="load_more_mba1" style="color:#ccc; display:none;" data-wow-delay="0.2s"><i>Loading...</i> <img src="<?php echo str_replace('index.php','',base_url()) ?>images/loader.gif" width="18"> </a>
                        <input type="hidden" class="successm" style="display:nones;">    -->                    
                            
                        
                        <div class="col-lg-offset-1_ col-lg-12 col-sm-12 mt-30 mb-30 mb-sm-20 ml-xs-0">
                            <a class="load_more_bt" style="text-align: center; margin: 0 auto; font-size: 15px;" data-val = "1" id="load_more_mba_forum" href="javascript:;"><b>LOAD MORE</b></a>

                            <a class="load_more_bt" id="load_more_mba_forum1" style="color:#999; display:none; border:1px solid #ccc; background: #eee; text-align: center; margin: 0 auto;" href="javascript:;">
                                <b><i>Loading...</i> <img src="<?=base_url()?>images/loader.gif" style="widths: 18px !important"></b>
                            </a>
                        </div>
                    </div>



                    <div class="reply_forum">

                    </div>


                </div>
            <!-- </div> -->
        </div>
    </div>
</div> <!-- Choose Subjects -->




</div>
