

<div class="kingster-page-wrapper" id="kingster-page-wrapper">
    <div class="gdlr-core-page-builder-body" style="background-color: #ddd;">


<!-- <input type="hidden" class="selected_subjs" />
<input type="hidden" class="selected_subjs_ids" />
<input type="hidden" class="started_text_value" value="0" /> -->


<input type="hidden" id="txtcounts" value="<?=$pq_count?>" />
<input type="hidden" id="txtsources" value="<?=$sources?>" />


<div class="choose_subjects">



<?php if($page_name == "centres"){ ?>

<div class="div_contents_" style="display: nones;"> <!-- Choose Subjects -->
            
    <div class='div_contents_res'>
        <h3 class='main_titles_res'><?=$page_title?></h3>
        <p class="lil_info">Locate any tutorial centres near you...</p>
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
                    <div class="form-group input_container">
                      <input name="txtkeywd" type="text" placeholder="Search Keyword" class="form-control txtkeywd">
                      <ul id="country_list_id" class="country_list_id1"></ul>
                    </div>
                  </div>

                  <div class="col-lg-4 col-sm-8 col-xs-8 pr-lg-5 pl-lg-5 p-md-0 pr-md-0 pl-md-15 pr-xs-0 pl-xs-15 mt-xs--5">
                    <div class="form-group">
                      <select class="txtsrch_state form-control required" name="txtsrch_state">
                        <option value="">All States</option>
                          <?php

                            $mycity1="";
                            $mystate=$mylocs['statee'];
                            $mycity=$mylocs['citys'];
                            if($mycity!="") $mycity1="$mycity, ";
                            if($mycity==$mystate)
                                $mylocs=$mystate;
                            else
                                $mylocs = $mycity1.$mystate;
                            if(strlen($mylocs)>3){
                                $mylocs = ", $mylocs";
                            }

                            foreach($fetchStates as $post):
                              $ids = $post['id'];
                              $name1 = ucwords($post['name']);
                              ?>

                              <option value='<?=$name1?>' <?php if($name1==$mystate) echo "selected"; else if($ids==2671) echo "selected"; ?> ><?=$name1?></option>
                              
                          <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-2 col-sm-3 col-xs-4 p-0 mt-xs--5">
                    <div class="form-group">
                      <button type="button" class="btn btn-lg cmd_search_res"><i class="fa fa-search"></i> Search</button>
                    </div>
                  </div>
                </div>

                </div>
                </div>
              </div>
              <div class="filters">Search here</div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="open_map"><div class="open_inner_map"><img src="<?=base_url();?>images/loaderq.gif"></div></div>

    <div class="container pt-40 pb-30 test_div scrollhere2" style="text-align: center;">
        <div class="row pr-sm-0 pl-sm-0">

            <p style="margin: -20px 0 7px 0; text-align: center; color: #333; padding:0 8px;" class="font-17 font-sm-15 line-height-20"><b>List of professional tutorial centres with their respective locations that have partnered with us. Locate any one near you for physical practicals.</b></p>

            <div class="loaders" style="display:none;"><img src="<?=base_url();?>images/loaderq.gif"></div>

            <div class="filterCentres1" style="display: nones;">
                <?php if($centres){
                    $mycity1="";
                    $mystate=@$mylocs['statee'];
                    $mycity=@$mylocs['citys'];
                    if($mycity!="") $mycity1="$mycity, ";
                    if($mycity==$mystate)
                        $mylocs=$mystate;
                    else
                        $mylocs = $mycity1.$mystate;
                    if(strlen($mylocs)>3){
                        $mylocs = ", $mylocs";
                    }
                ?>
                    <p style="margin: 0px 0 30px 0; text-align: center; font-size: 17px; color: #333 !important;">Total of <b><?=$pq_count?></b> centres found in your location <?=$mylocs?></p>
                <?php } ?>

                <?php
                if($centres){
                    foreach($centres as $row){
                        $id = $row['id1'];
                        $centre_name = $row['centre_name'];
                        $centre_name1 = $centre_name;
                        if(strlen($centre_name)>60)
                            $centre_name = substr($centre_name, 0, 60)."...";
                        $test_types = $row['test_types'];
                        $statee = $row['statee'];
                        $citys = $row['city'];
                        $locs = "$citys, $statee";
                        $test_types = str_replace(array("Test", "test"), "Board", $test_types);
                        $locations = $row['locations'];
                        $views = $row['views'];
                    ?>
                        <div class="col-md-4 col-sm-6 mb-40 mb-sm-30 custom-height custom-height-sm scrollhere<?=$id?>">
                            <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js each_div" data-gdlr-animation="fadeInUp" data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.8">
                                <p class="topics font-18"><?=$test_types?></p>
                                <div class="row divContent">
                                    <div class="col-md-12 line-height-20 pt-5 font-18" style="color: #069">
                                        <i class="fa fa-home"></i> <b><?=$centre_name?></b>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-12 mt-10 font-15 line-height-20">
                                        <i class="fa fa-map-marker" style="color: #C00; font-size: 16px;"></i> <?=$locations?>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-12 mt-5 font-15">
                                        <i class="fa fa-location-arrow" style="color: #C00; font-size: 16px;"></i> <?=$locs?>

                                        <span class="cntr_view">
                                            <i class="fa fa-eye" style="color: #C00; font-size: 16px;"></i> <?=$views?>
                                        </span>
                                    </div>
                                    <div class="clearfix"></div>

                                    

                                    <div class="col-md-12 mt-15 btn_tst">

                                        <div class="start_test_btn view_maps" centre_name="<?=$centre_name1?>" addrs="<?=$locations?>" id1="<?=$id?>">VIEW MAP DIRECTION <i class="fa fa-arrow-right"></i></div>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>



                    <?php
                    }
                    //echo $pagination
                }else{

                    echo '<div class="col-md-12 mt-10 mb-190 mb-sm-70" style="text-align: center; color:#555; font-weight:600; line-height:24px;">
                    No centres found at your location '.$mylocs.', try selecting another location
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div> <!-- Choose Subjects -->





<?php } if($page_name == "resources"){ ?>

<div class="div_contents_" style="display: nones;"> <!-- Choose Subjects -->
            
    <div class='div_contents_res div_contents_res1'>
        <h3 class='main_titles_res'><?=$page_title?></h3>
        <p class="lil_info lil_info1">Downloadable resource materials for your use...</p>
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
                      <button type="button" class="btn btn-lg cmd_search_test"><i class="fa fa-search"></i> Search</button>
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

            <?php
            if($sources=="past-questions"){
                $sources2 = "past questions & answers";
                $pq_countx = $pq_count;
            }else{
                $sources2 = "tutorial videos";
                $pq_countx = $pq_count1;
            }
            ?>

            <!-- <div class="filterResources" style="display: nones;"> -->
                <!-- <p style="text-align: center; font-size: 17px; color: #333 !important;" class="mb-40">Total of <b><?=$pq_count?></b> <?=$sources2?> found</p> -->

                <div class="col-lg-3 col-sm-3 pr-30 pl-5 pr-xs-5 pl-xs-5 for_desktop">
                    <div class="navigates">RESOURCES</div>
                    <div class="navs">
                        <p><a href="<?=base_url()?>resources/past-questions/#!">Past Questions (<?=$pq_count?>)</a></p>
                        <p><a href="<?=base_url()?>resources/tutorial-videos/#!">Tutorial Videos (<?=$pq_count1?>)</a></p>
                    </div>
                </div>

                <div class="for_mobile border-bottom-gray1 mt--10 mr-20 ml-20 mb-md-30 mt--sm-20"></div>

                <div class="col-lg-9 col-sm-12 p-xs-0 mt-xs-20">
                    <div class="row" id="ajax_table_bma">
                        <p style="margin: -20px 0 7px 0; text-align: center; color: #333;" class="font-17 font-sm-16 line-height-22 pr-10 pl-10 pr-sm-25 pl-sm-25"><b>
                        <?php
                        if($sources=="past-questions"){
                            echo 'View and download our various past questions and answers for different years and different schools';
                        }else{
                            echo 'Click and watch our tutorial videos with 100% practicals where applicable.';
                        }
                        ?>

                        </b></p>


                        <p style="text-align: center; font-size: 17px; color: #333 !important;" class="mb-40 mb-xs-20 mr-20_">Total of <b><?=$pq_countx?></b> <?=$sources2?> found</p>
                        <?php
                        if($media){
                            $cnts=1;
                            foreach($media as $row){
                                $id = $row['id1'].$cnts.substr(time(), -4);
                                $titles = ucwords($row['titles']);
                                $img_cover = $row['img_cover'];
                                $media_type = $row['media_type'];
                                $price = $row['price'];
                                $file_type = ucwords($row['file_type']);
                                
                                if($price<=0)
                                    $price = "FREE";
                                else
                                    $price = "&#8358;".@number_format($price);
                                $years = $row['years'];
                                $years = str_replace(",", ", ", $years);
                                $downloads = @number_format($row['downloads']);
                                $views = @number_format($row['views']);

                                if($media_type=="doc") $for_img = "for_img"; else $for_img = "for_img_i";
                                if($img_cover=="")
                                    $img_cover=base_url()."images/no-video.jpg";
                                else
                                    $img_cover=base_url()."resourcesfiles/$img_cover";

                                if($media_type=="vid"){
                                    $files = "<div class='div_media $for_img'><div class='play_btn'></div><img src='$img_cover'></div>";
                                  }else{
                                    $files = "<div class='$for_img'><img src='$img_cover'></div>";
                                  }

                                  // $cntsx = strtolower(base64_encode(substr($cnts, 1, -4)));
                                  // $cntsx = str_replace("=", "", $cntsx);
                            ?>
                                <!-- <a name="<?=$cntsx?>"></a> -->
                                <div class="col-md-4 col-sm-6 col-xs-offset-1_ col-xs-12 p-xs-10 mb-30 mb-sm-30 mb-xs-20 scrollhere3">
                                    <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js each_div each_div1 ml-xs-15 mr-xs-15" data-gdlr-animation="fadeInUp" data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.8">
                                        <a href="javascript:;" sources="<?=$sources?>" id1="<?=$id?>" class="click_link">
                                            <?=$files?>
                                            <?php
                                            if($media_type=="doc"){
                                                echo "<div class='book_price'>$price</div>";
                                                echo '<div class="file_info pr-xs-10 pl-xs-10">';
                                            }else{
                                                echo '<div class="file_info pr-xs-10 pl-xs-10 mt-10">';
                                            }
                                            ?>
                                                <p class="book_name"><?=$titles?></p>
                                                <?php
                                                if($media_type=="doc")
                                                    echo "<p>Type: <font style='color:#093;'>$file_type</font></p>";
                                                ?>

                                                <p>Year: <?=$years?></p>
                                                <?php
                                                if($media_type=="doc"){
                                                    echo '<p>Views: '.$views.' &nbsp;&bull;&nbsp; Downloads: '.$downloads.'</p>';
                                                }else{
                                                    echo '<p>Views: '.$views.'</p>';
                                                }
                                                ?>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            <?php
                            $cnts++;
                            }
                        }else{

                            echo '<div class="col-md-offset-3 col-md-9 mt-10 mb-190 mb-sm-70 ml-sm-180 ml-xs-0" style="text-align: center; color:#555; font-weight:600; line-height:24px;">
                            No files yet, try again next time
                            </div>';
                        }
                        ?>
                    </div>

                    <div class="col-lg-offset-1 col-lg-10 col-sm-offset-1 col-sm-10 mt-20 mb-30 mb-sm-20 ml-xs-0">
                        <a class="load_more_bt" style="text-align: center; margin: 0 auto;" data-val = "1" id="load_more_mba" href="javascript:;"><b>LOAD MORE</b></a>

                        <a class="load_more_bt" id="load_more_mba1" style="color:#999; display:none; border:1px solid #ccc; background: #eee; text-align: center; margin: 0 auto;" href="javascript:;">
                            <b><i>Loading...</i> <img src="<?=base_url()?>images/loader.gif" style="widths: 18px !important"></b>
                        </a>
                    </div>

                </div>
            <!-- </div> -->
        </div>
    </div>
</div> <!-- Choose Subjects -->

<?php } ?>

</div>
