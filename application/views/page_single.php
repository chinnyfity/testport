

<div class="kingster-page-wrapper" id="kingster-page-wrapper">
    <div class="gdlr-core-page-builder-body" style="background-color: #ddd;">

<input type="hidden" class="selected_subjs" />



<?php
  $urlid = $this->uri->segment(4);
  $urlid = strtolower(base64_encode(substr($urlid, 1, -4)));
  $urlid = str_replace("=", "", $urlid);

  $id = $pquests['id'];
  $ids = $id.substr(time(), -5);
  $titles = ucwords($pquests['titles']);
  $img_cover = $pquests['img_cover'];
  $price = $pquests['price'];
  $price2 = $price;
  if($price<=0)
      $price = "FREE";
  else
      $price = "&#8358;".@number_format($price);
  $years = $pquests['years'];
  $years = str_replace(",", ", ", $years);
  $files = $pquests['files'];
  $descrip = nl2br($pquests['descrip']);
  $media_type = $pquests['media_type'];
  $file_type = $pquests['file_type'];
  $downloads = @number_format($pquests['downloads']);
  $views = @number_format($pquests['views']);

  if($img_cover=="")
      $img_cover=base_url()."images/no-video.jpg";
  else
      $img_cover=base_url()."resourcesfiles/$img_cover";

  $media_files = base_url()."resourcesfiles/$files";
  $media_img = base_url()."resourcesfiles/$img_cover";
  $media_img1 = base_url()."images/no-video.jpg";

  if($media_type=="doc") $sources2 = "past-questions"; else $sources2 = "tutorial-videos";
  $links = base_url()."resources/view/$sources2/$ids/";

  if($media_type=="vid"){
    $for_img2 = "for_img2";

    $files2 = "<video id='my_video_1' style='width:100%; cursor: pointer;' class='video-js vjs-default-skin myVideo1 videos2 vidss video_divs1' controls controlsList='nodownload' preload='auto' poster='$media_img' oncontextmenu='return false;'>
          <source src='$media_files' type='video/mp4'>
          <source src='$media_files' type='video/webm'>
          </video>";

  }else{
    $files2 = "<div class='for_img for_img1'>
                  <img src='$img_cover'>
                  <div class='book_price book_price1'>".$price."</div>
              </div>";

  }

?>

<script src="https://js.paystack.co/v1/inline.js"></script>


<div class="div_contents_ choose_subjects" style="display: nones;"> <!-- Choose Subjects -->
            
    <div class='div_contents_res div_contents_res1'>
        <h3 class='main_titles_res'><?=$page_title1?></h3>
        <p class="lil_info lil_info1">Downloadable resource materials for your use</p>
    </div>

    

    <div class="container pt-40 pb-90 pb-xs-40 test_div" style="text-align: center;">
        <div class="row pr-sm-0 pl-sm-0">
            <p style="margin: -20px 0 0px 0; text-align: center; color: #333; padding:0 8px;" class="font-17 font-sm-16 mb-40 line-height-22"><b>View and download our various past questions and answers for different years and different schools</b></p>

            <div class="for_mobile border-bottom-gray1 mt--10 mr-20 ml-20 mb-30"></div>

            <div class="col-lg-3 col-sm-3 pr-30 pl-5 pr-xs-5 pl-xs-5 for_desktop">
                <div class="navigates">NAVIGATION</div>
                <div class="navs">
                    <p><a href="<?=base_url()?>resources/past-questions/">Past Questions (<?=$pq_count?>)</a></p>
                    <p><a href="<?=base_url()?>resources/tutorial-videos/">Tutorial Videos (<?=$pq_count1?>)</a></p>
                    <!-- <p><a href="javascript:;">Practice</a></p>
                    <p><a href="javascript:;">Tutorials</a></p> -->
                </div>
            </div>


            <?php
            if($media_type=="doc"){
              echo '<div class="col-lg-3 col-sm-4 col-xs-12">';
            }else{
              echo '<div class="col-lg-5">';
            }
            ?>
            
              <div class="row">
                <?=$files2?>
              </div>
            </div>


            <?php
            if($media_type=="doc")
              echo '<div class="col-lg-6 col-sm-8 col-xs-12 pl-20 pl-sm-30 pl-xs-15">';
            else
              echo '<div class="col-lg-4 pl-30 mt-sm-20 pl-sm-15 pl-xs-15 mt-xs-15">';
            ?>
              <div class="myBookDetails" style="display: nones;">
                <div class="row">
                  <div class="file_info file_info1 pr-xs-10 pl-xs-10">
                      <p class="book_name book_name1"><?=$titles?></p>

                      <?php
                      $titles_1 = str_replace(array(" ","/","(",")","*","%","^","%","'","\"","@",",","#","$","=","+","|","\\"), array("_","_or_"), $titles);
                      $titles_1 = str_replace("&", "and", $titles_1);

                      $titles_tweet = str_replace("_", " ", $titles_1);
                      $titles_tweet="Get $titles_tweet for $price";

                      $sell_title_whatsapp = str_replace("_", " ", $titles_1);
                      $sTitle_whatsapp = "*Get ".ucwords($sell_title_whatsapp)."* for *$price*%0A%0A$links";
                      ?>


                      <p class="mb-0 mb-sm-5">
                        <p class="gdlr-core-social-network-item mt-15 mb-10">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$links?>" target="_blank" class="gdlr-core-social-network-icon" title="facebook">
                                <i class="fa fa-facebook" ></i>
                            </a>

                            <a href="whatsapp://send?text=<?=$sTitle_whatsapp?>" target="_blank" class="gdlr-core-social-network-icon for_mobile1" title="whatsapp">
                                <i class="fa fa-whatsapp" ></i>
                            </a>

                            <a href="https://web.whatsapp.com/send?text=<?=$sTitle_whatsapp?>" target="_blank" class="gdlr-core-social-network-icon for_desktop1" title="whatsapp">
                                <i class="fa fa-whatsapp" ></i>
                            </a>

                            <a href="https://twitter.com/share?text=<?=ucwords($titles_tweet)?>&url=<?=$links?>" target="_blank" class="gdlr-core-social-network-icon" title="twitter">
                                <i class="fa fa-twitter" ></i>
                            </a>
                        </p>
                      </p>

                      <p><b>Type:</b> <span style="color: #069"><?=ucfirst($file_type)?></span></p>
                      <p><b>Year:</b> <span style="color: #069"><?=$years?></span></p>
                      <p>
                        <?php
                        if($media_type=="doc"){
                          echo "<b>Downloads:</b> <span style='color: #069'>$downloads</span> &nbsp;&bull;&nbsp;";
                        }
                        ?>
                        <b>Views:</b> <span style="color: #069"><?=$views?></span>
                      </p>
                      <p class="contents"><?=$descrip?></p>
                  </div>
                </div>


                <div class="mt-30">
                  <?php
                  if($media_type=="doc")
                    echo '<div class="col-md-offset-1 col-md-3 col-sm-offset-2 col-sm-3 col-xs-offset-2_ col-xs-8 pr-0 pl-0 pt-5 p-xs-5 ml-xs-50 mb-xs-10">';
                  else
                    echo '<div class="col-md-offset-1 col-md-8 col-sm-offset-4 col-sm-4 col-xs-offset-1 col-xs-10">';
                  
                  if($media_type=="doc")
                      echo '<div class="start_test_btn cmd_back_lists p-15 font-16" urlid="'.$urlid.'" style="opacity: 0.7;"><i class="fa fa-arrow-left"></i> Back</div>';
                    else
                      echo '<div class="start_test_btn cmd_back_lists1 p-15 font-16" urlid="'.$urlid.'" style="opacity: 0.7;"><i class="fa fa-arrow-left"></i> Back</div>';
                    ?>
                  </div>

                  <?php
                  if($media_type=="doc")
                    echo '<div class="col-md-5 col-sm-6 col-xs-12 p-0 ml--15 ml-sm--15 ml-sm-0 mb-xs-30">';
                  else
                    echo '<div class="col-md-offset-2 col-md-8 col-xs-offset-1 col-xs-10 p-0 mt-10 mb-xs-20">';
                  ?>
                    <?php
                    if($this->auths){
                      if($price2 > 0)
                        echo '<div class="start_test_btn cmd_buythis php_login p-20 p-sm-20 font-17" isSubjects="0">Buy This</div>';
                      else{
                        if($media_type=="doc")
                          echo '<div class="start_test_btn cmd_downloadthis php_login p-20 p-sm-20 font-17" files="'.$files.'" ids="'.$id.'">Download Now</div>';
                      }

                    }else{
                      if($price2 > 0)
                        echo '<div class="start_test_btn no_start_tests php_login p-20 p-sm-20 font-17" isSubjects="0">Buy This</div>';
                      else{
                        if($media_type=="doc")
                          echo '<div class="start_test_btn no_start_tests php_login p-20 p-sm-20 font-17" isSubjects="0">Download Now</div>';
                      }
                    }

                    if($price2 > 0)
                      echo '<div class="start_test_btn cmd_buythis java_login_show p-20 p-sm-20 font-17" isSubjects="0" style="display:none">Buy This</div>';
                    else
                      echo '<div class="start_test_btn cmd_downloadthis java_login_show p-20 p-sm-20 font-17" style="display:none" files="'.$files.'" ids="'.$id.'">Download Now</div>';
                    ?>

                  </div>
                </div>
              </div>


              <div class="myBookDetails_Pay" style="display: none;">
                <div class="row">
                  <div class="file_info file_info1 pr-xs-10 pl-xs-10">
                      <p class="book_name book_name1"><?=$titles?></p>
                      <?php
                        echo "<p class='mt-15 font-17' style='color:#090; line-height:21px !important'>Click on the button to submit this purchase so that we will get a notification about your interest on this file.</p>";

                        echo "<div class='mt-15 act_dets'>
                        <p style='color: #069; font-size: 16px !important; margin-bottom: 8px !important'><b>Company Account Details</b></p>
                        <p><b>Account Name:</b> TestPort LTD</p>
                        <p><b>Account Number:</b> 0693747543</p>
                        <p><b>Bank Name:</b> Diamond Bank</p>

                        <p style='margin-top:15px'><b style='color:#555;'>Want to Call Us?</b> <a href='tel:+2348117896926' style='color:#09C; font-size:18px !important;'>0811 789 6926</a></p>

                        </div>";
                      if($file_type=="hardcopy"){
                        echo '<input type="hidden" value="1" class="txtwrite">';
                        echo "<p class='mt-20' style='font-size: 16px !important;'><b>Deliver this hardcopy to my location</b></p>";
                        echo "<p>
                        <textarea  id='txtlocatn' placeholder='Type your location for delivery'></textarea>
                        </p>";
                      }else{
                        echo '<input type="hidden" value="0" class="txtwrite">';
                      }
                      ?>
                  </div>
                </div>

                <div class="alert alert_msgs alert_msg1 mt-20 mb--15"></div>

                <?php
                $tax1 = 100; // tax charged by paystack if the amt is more than 2500 is N100
                $paystack_tax1 = 1.5/100;

                if($price2 <= 2500)
                    $tax = $paystack_tax1 * $price2; // 0.015 * 1083 = 16.245
                else
                    $tax = ($paystack_tax1 * $price2) + $tax1; // 116.245

                $real_totals = $price2 + $tax; // 1083 + 16.245 = 1099.245
                $real_totals = round($real_totals, PHP_ROUND_HALF_DOWN)*100;
                ?>

                <div class="mt-30">
                  <div class="col-md-offset-1 col-md-3 col-sm-offset-2 col-sm-3 col-xs-offset-2_ col-xs-8 pr-0 pl-0 pt-5 p-xs-5 ml-xs-50 mb-xs-10">
                      <div class="start_test_btn change_color cmd_back_details p-15 font-16" style="opacity: 0.8;"><i class="fa fa-arrow-left"></i> Back</div>
                  </div>

                  <div class="col-md-6 col-sm-7 col-xs-12 p-0 ml--15 ml-xs-0">
                      <div class="start_test_btn change_color buybtn p-20 p-sm-20 font-17" titles="<?=$titles?>" ids="<?=$id?>">Use Mobile Transfer <i class="fa fa-arrow-right"></i></div>

                      <div style="clear: both;" class=" mb-15"></div>

                      <div class="start_test_btn change_color buybtn_online p-15 p-sm-20 font-17" titles="<?=$titles?>" ids="<?=$id?>" myemail="<?=$this->mymail?>" amts="<?=$real_totals?>">Pay Online <i class="fa fa-arrow-right"></i></div>
                  </div>


                </div>
              </div>


              <div class="myBookDetails_Success" style="display: none;">
                <div class="row">
                  <div class="pr-40 pl-40 pr-sm-0 pl-sm-0" style="text-align: center;">
                    <div class="thumbsup thumbsup1"></div>
                    <h4 style="color: #093"><b>Thank You</b></h4>
                    <p style="margin: -8px 0 -7px 0; padding: 0 7px" class="font-16 line-height-25">
                      <label style="font-weight: normal !important; color: #222; line-height: 23px;">
                        Thank you for your patronage! As soon as we receive a payment notification from you, we will activate the download of this file for your use. You may need to call us via our office line <a href="tel:+2348117896926">0811 789 6926</a> or write to us on our <a href="<?=base_url()?>contact/">contact page</a>.
                      </label>
                    </p>
                      <div class="row">
                        <div class="col-md-push-4 col-md-4 col-sm-push-4 col-sm-4 col-xs-push-3 col-xs-4">
                          <input class="gdlr-core-full-size pr-70 pl-70 mt-30 mb-5 pt-15 pb-15 font-16 border-radius-50px ml-md-0 ml-xs-0 cmd_done_buy" type="button" value="Done" />
                          <br>
                        </div>
                      </div>
                  </div>
                </div>

                <!-- <div class="start_test_btn_1 start_test_btn_2 buybtn mt-30 mb-10" ids="<?=$id?>">Submit</div> -->
              </div>

            </div>
        </div>
    </div>
</div>

