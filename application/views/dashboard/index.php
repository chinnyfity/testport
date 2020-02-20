<?php
$page_name2 = str_replace('_', " ", $page_title);
?>


<div class="cover_body"></div>
<!-- <div class="modal" id="delete_dv" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true"> -->
<div class="modal fade_" id="delete_dv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times cmd_close_sch" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>

            <div class="modal-body">
                <input type="hidden" id="txtall_id">
                <div class="alert alert-danger" style="font-size:15px; display: block;"><span class="fa fa-warning"></span> Are you sure you want to delete this?</div>
            </div>

            <input type="hidden" id="txt_dbase_table" value="<?=$page_name;?>">

            <div class="modal-footer ">
                <button type="button" class="btn btn-success cmd_remove_adm" data-dismiss="modal" ><span class="fa fa-trash-o"></span>&nbsp;Yes</button>
                <button type="button" class="btn btn-default cmd_close_sch" id="cmd_close_del_" data-dismiss="modal"><span class="fa fa-times"></span>&nbsp;No</button>
            </div>
        </div>
    </div>
</div>


<div id="page-wrapper" class="page-wrapper1">
    <div class="col-sm-12 float_left" style="padding:0 0 0 8px">
        <h1 class="page-header">
        <?php
        if($page_name == "")
            echo "Dashboard";
        else
            echo $page_name2;
        ?>
        </h1>
    </div>

</div>




<?php 
if($page_name == ""){
    //$haspaid
    //if($get_info){
        // $haspaid = $get_info['paid'];
        // $hassub = $get_info['subscription'];
        // if($haspaid==1) $haspaid1="<p style='color:red; font-size:14px;'>Pending payments...</p>"; else $haspaid1="";
    //}
?>

<div id="page-wrapper" class="small_box">

    <div class="row">
        <?php
        $scores="";$subjs="";$time_finished1 = "";
        if($last_test){
            $scores = $last_test['scores'];
            $subjs = $last_test['subjs'];
            $time_finished = $last_test['time_finished'];

            $mins1 = round($time_finished/60);
            $time_finished1 = $mins1." minutes";
        }
        ?>
        <div class="col-lg-6 col-md-4 col-sm-12 boxes">
            <div class="alert alert-info text-center" style="line-height: 20px !important;">
                <i class="fa fa-money fa-3x"></i> You scored <b><?=$scores?></b> on your last test on<br>
                <b><?=$subjs?></b> finished at <b><?=$time_finished1?></b>
            </div>
        </div>


        <div class="col-lg-6 col-md-4 col-sm-12 mt-xs--10 mr-xs-40 boxes">
            <div class="alert alert-success text-center" style="line-height: 20px !important;">
                <i class="fa fa-shopping-cart fa-3x"></i> You have <b><?=$cart_cnt?></b> items on your cart<br>&nbsp;
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg-6">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-user fa-fw"></i> Last 5 of your Performances
                    <a class="view_more" href="<?=base_url()?>dashboard/performance/">View Full</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12_">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped tbl_color">
                                    <thead>
                                        <tr>
                                            <th>Test Board</th>
                                            <th>Subject</th>
                                            <th>Scores</th>
                                            <th>Time Set</th>
                                            <th>Time Finished</th>
                                            <th>Date Taken</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        $j=1;
                                        if(!empty($perform)): foreach($perform as $post): ?>
                                        <?php
                                            $id4 = $post['sa_id'];
                                            $sessions = "";
                                            $quizintro_id = $post['quizintro_id'];
                                            $subject_id = $post['subject_id'];
                                            $time_finished = $post['time_finished'];
                                            $scores = $post['scores'];
                                            $date_taken = date("jS M, Y h:ia", $post['date_taken']);
                                            $set_time = $post['set_time'];

                                            $sessions = $this->sql_models->getSess($quizintro_id);
                                            $id_sch = $this->sql_models->getTopicName($id4, 'id', 'stud_ans', 'quizintro_id', 'array');
                                            
                                            $test_board_id = $this->sql_models->getTopicName($sessions, 'sessions', 'quizes', 'test_board', 'row');
                                            $test_board = $this->sql_models->getTopicName($test_board_id, 'id', 'test_boards', 'test_types', 'row');
                                            $subject_names = $this->sql_models->subjName($subject_id, 'arrays', $quizintro_id);
                                            
                                            $mins1 = round($time_finished/60);
                                            $time_finished1 = $mins1." minutes";

                                            if($scores > 40){
                                                $scores1 = "<b style='color:green'>$scores</b>";
                                            }else{
                                                $scores1 = "<b style='color:red'>$scores</b>";
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$test_board;?></td>
                                            <td><?=$subject_names;?></td>
                                            <td><?=$scores1;?></td>
                                            <td><?=$set_time;?> minutes</td>
                                            <td><font style='color:#06C'><?=$time_finished1?></font></td>
                                            <td><?=$date_taken;?></td>
                                        </tr>
                                    <?php $j++; endforeach; else: ?>
                                    <tr><td colspan="6" style="text-align:center;">No records yet!</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pull-right">
                                <div class="btn-group">
                                    <select id="txtaction">
                                        <option value="" selected>-Select-</option>
                                        <option value="all">View All</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-briefcase fa-fw"></i> Last 5 of your Cart Items
                    <a class="view_more" href="<?=base_url()?>dashboard/cart/">View Full</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12_">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped tbl_color">
                                    <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>Items</th>
                                            <th>Price</th>
                                            <th>Paid</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        $j=1;
                                        if(!empty($mycarts)): foreach($mycarts as $post): ?>
                                        <?php
                                            $titles = ucfirst($post['titles']);
                                            $paid = $post['paid'];
                                            $id = $post['id'];
                                            $files = $post['files'];
                                            $price = @number_format($post['price']);
                                            $dates = $post['date_posted'];
                                            $dates = date("D jS M Y h:ia", strtotime($dates));

                                            if(strlen($titles)>80)
                                                $titles = substr($titles, 0, 80)."...";

                                            if($paid == 1){
                                                $paid = "<a href='javascript:;' class='download_file' files='$files' ids='$id' id='download_file$id' style='color:#093; font-size:14px;'><b>Download file</b></a>";
                                            }else{
                                                $paid = "<font style='color:red; cursor:pointer; font-size:13px; line-height:20px!important;'><b>Payment pending...</b></font>";
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$j;?></td>
                                            <td><?=$titles;?></td>
                                            <td>&#8358;<?=$price;?></td>
                                            <td><?=$paid;?></td>
                                            <td><?=$dates;?></td>
                                        </tr>
                                    <?php $j++; endforeach; else: ?>
                                    <tr><td colspan="6" style="text-align:center;">No carts found!</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pull-right">
                                <div class="btn-group">
                                    <select id="txtaction1">
                                        <option value="" selected>-Select-</option>
                                        <option value="all">View All</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

<br><br>
</div>


<?php } ?>




<?php if($page_name == "uploadscholarship" || $page_name == "edit_scholarship"){ ?>
    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>dashboard/view_scholarship/">Click To View/Edit Scholarship</a></p>
            <div class="card col-md-8 nopad" style="border:1px #ccc solid !important;">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                    if($getId!="")
                                    echo '<h3 class="text-center ttl"><b>Update This Scholarship</b></h3>';
                                    else
                                    echo '<h3 class="text-center"><b>Upload A New Scholarship Content</b></h3>';
                                ?>
                            </div>
                            <hr>
                            <?php
                            echo form_open('', array('autocomplete'=>'off', 'id'=>'upload_sch_form'));
                                //$new1 = "";
                                if($getId!=""){
                                    $id1 = md5($getId['id']);
                                    $types = $getId['types'];
                                    $titles = ucfirst($getId['titles']);
                                    $descrip = $getId['descrip'];
                                    $country = $getId['country'];
                                    $states = $getId['states'];
                                    $cats1 = $getId['cats'];
                                    $btn_type = $getId['btn_type'];
                                    $urls = $getId['urls'];
                                    $expiry = $getId['expiry'];
                                    $captions1 = "Update Content";
                                    
                                }else{
                                    $id1="";$types="";$titles="";$descrip="";$country="";$states="";$cats1="";$btn_type="";$urls="";$expiry="";
                                    $captions1 = "Upload Content";
                                }

                            ?>
                                
                                <div class="first_create_form" style="display:nones;">

                                    <input type="hidden" value="<?=$this->getid1;?>" name="txtmem">

                                    <div class="form-group col-lg-12">
                                        <label class="control-label mb-1">Select Type</label>
                                        <select id="txttypes" name="txttypes">
                                            <option value="qz" <?php if($types=="qz") echo "selected"; ?> >Quiz 4 Scholarship</option>
                                            <option value="sa" <?php if($types=="sa") echo "selected"; ?> >Scholarship Awards</option>
                                            <option value="op" <?php if($types=="op") echo "selected"; ?> >Opportunities</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="cc-payment" class="control-label mb-1">Title</label>
                                        <input type="text" value="<?=$titles;?>" placeholder="Enter title of activity" name="txttitle" id="txttitle" class="form-control">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label class="control-label mb-1">Select Country</label>
                                        <select class="js-example-basic-multiple" name="txtcountry[]" multiple="multiple" id="txtcountry">
                                            <?php if($country==""){ ?>
                                                <option value='160' selected="">Nigeria</option>
                                            <?php } ?>

                                            <?php
                                            $selected="";
                                            foreach($locs as $post):
                                                $id = $post['id'];
                                                $loctn = ucwords($post['name']);
                                                ?>
                                                <option value='<?=$id;?>' <?php if($country==$id) echo "selected"; ?> ><?=$loctn;?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group col-lg-12 col-sm-12">
                                        <label class="control-label mb-1">Content</label>
                                        <div id="editor" name="editor" style="height: 300px;">
                                            <?=$descrip;?>
                                        </div>
                                        <textarea name="txteditor" style="display: none;" id="txteditor"><?=$descrip;?></textarea>

                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label class="control-label mb-1">Select Specialization</label>
                                        <select class="form-control" name="txtcats" id="txtcats">
                                          <?php 
                                          if($cats):
                                            echo '<option value="" selected>-Specialization-</option>';
                                              foreach($cats as $post):
                                                $ids = $post['id'];
                                                $cat_name = $post['cats'];
                                                ?>
                                                <option value='<?=$ids;?>' <?php if($cats1==$ids) echo "selected"; ?> ><?=$cat_name;?></option>
                                                <?php
                                                ?>
                                            <?php endforeach; endif; ?>
                                            <option value='others'>Others</option>
                                        </select>

                                        <input style="margin-top:5px; display: none; text-transform: capitalize;" type="text" value="<?=$titles;?>" placeholder="Enter Specialization" name="txtcats2" id="txtcats2" class="form-control">
                                    </div>


                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label class="control-label mb-1">Scholarship Type</label>
                                        <select class="form-control" name="txtedu" id="txtedu">
                                            <option value="undergraduate" selected>Undergraduate</option>
                                            <option value="post graduate">Post graduate</option>
                                            <option value="masters">Masters</option>
                                            <option value="mba">MBA</option>
                                            <option value="phd">PhD</option>
                                            <option value="post-doctoral">Post-Doctoral</option>
                                            <option value="general">General</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-lg-5 col-md-6 col-sm-6">
                                        <p><label class="control-label mb-1">Select Button Type (Optional)</label></p>

                                        <label class="container1">External Link
                                          <input type="radio" <?php if($btn_type=="external") echo "checked"; ?> name="txtbtntype" value="external">
                                          <span class="checkmark"></span>
                                        </label> &nbsp; &nbsp; &nbsp;

                                        <label class="container1">Apply button
                                          <input type="radio" <?php if($btn_type=="internal") echo "checked"; ?> name="txtbtntype" value="internal">
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>


                                    <div class="form-group col-lg-7 col-md-6 col-sm-12">
                                        <label for="cc-payment" class="control-label mb-1">URL</label>
                                        <input type="text" value="<?=$urls;?>" placeholder="Enter URL" name="txturl" id="txturl" class="form-control">
                                    </div>
                                    


                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label for="cc-payment" class="control-label mb-1">
                                            Expiry Date <b>(month / day / year)</b>
                                        </label>
                                        <?php
                                            $expirys = strtotime('+3 days', time());
                                            $cur_date = date("Y-m-d", $expirys);

                                            if($expiry=="")
                                                $cur_date1 = $cur_date;
                                            else{
                                                $cur_date1 = date("Y-m-d", $expiry);
                                            }
                                        ?>
                                        <input type="date" value="<?=$cur_date1;?>" placeholder="Enter title of activity" name="txtexpiry" id="txtexpiry" class="form-control">
                                    </div>

                                    
                                    <div style="clear:both"></div>
                                    <input type="hidden" name="txtsch_id" id="txtsch_id" value="<?php echo $id1; ?>" />


                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" id="cmd_upload_content" class="btn btn-lg btn-info btn-block inlines_">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="alert alert-danger alert_msg"></div>
                                </div>


                                <div class="success_form" style="display:none; text-align:center;">
                                    <p>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                          <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                          <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                        </svg>
                                    </p>

                                    <?php if($getId!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>Updated Successfully</b></p>
                                        <p style="font-size:16px; color:#555;">Changes have been made. Make changes again or click the <b>view button</b> to view records.
                                        
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>Uploaded Successfully</b></p>
                                        <p style="font-size:16px; color:#555;">It will be seen immediately on the platform. You can also edit or delete if there's any mistake
                                        </p>
                                    <?php } ?>

                                    <div class="col-lg-offset-4 col-lg-4">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Go Back" id="cmd_back_tofirst" class="btn btn-lg btn-info btn-block">
                                        </div>
                                        <p style="margin: 1.2em 0 0 0;">
                                            <span class="view_changes">View Changes</span>
                                        </p>
                                    </div>

                                    <div style="clear:both"></div>
                                </div>

                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>

                </div>
            </div> 

        </div>

        <div style="clear:both;"></div>
        <br><br><br><br>
    </div>
    

<?php } ?>



<?php if($page_name == "cart"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="carts" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <!-- <input type="hidden" value="<?=$this->getid1;?>" id="txtmem"> -->
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Paid</th>
                            <th>Location</th>
                            <th>Payment Type</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>
<?php } ?>



<?php if($page_name == "performance"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="performance1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <!-- <input type="hidden" value="<?=$this->getid1;?>" id="txtmem"> -->
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Test Board</th>
                            <th>Subject</th>
                            <th>Scores</th>
                            <th>Years</th>
                            <th>Time Set</th>
                            <th>Time Finished</th>
                            <th>Date Taken</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>
<?php } ?>





<?php if($page_name == "profile"){
    $names = ""; $emails = ""; $phone = ""; $gender = ""; $countrys = ""; $states = ""; $picx = "";
    $imgs1=""; $yes_file=0;

    if($mems){
        $names = ucwords($mems['names']);
        $emails = $mems['emails'];
        $phone = $mems['phone'];
        $gender = $mems['gender'];
        $picx = $mems['pics'];
        //$countrys = $mems['countrys'];
        //$states = $mems['states'];

        if($picx!=''){
            $imgs1 = base_url()."profile_pics/$picx";
            $yes_file=1;
        }else{
            $imgs1 = base_url()."images/no_passport1.jpg";
            $yes_file=0;
        }
    }
    ?>
    <div class="content mt-3 container" id="page-wrapper" style="">
    
        <div class="col-lg-6 col-md-8" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center">Update Your Profile</h3>
                            </div>
                            <hr>
                            <?php
                            echo form_open_multipart('', array('id'=>'frm_update_profile', 'class'=>'uploadimage2_bma', 'autocomplete'=>'off')); 
                            ?>
                                <input type="hidden" name="txtmember" id="txtmember" value="<?=sha1($this->memid);?>">

                                <ul class="list-inline">
                                    <li id="img_prev1_bma" class="list-inline-item profile_pics3">
                                        <span>remove</span>
                                        <img src="<?php echo $imgs1; ?>" src1="<?php echo $imgs1; ?>" id="im1_bma">
                                        <input id="ad_logo_check1_bma" value="0" style="display:none;" />
                                        
                                        <input type="file" name="txt_bma_pic" id="txt_bma_pic" style="padding:4px; font-size:14.5px; margin-top:8px; border:1px solid #ccc; display:none" />
                                        <p style="color:#09C; font-size:14.5px; margin-top:4px; cursor:pointer; font-weight: 600; display:none" id="hide_basic_uploader">Hide this</p>
                                        
                                    </li>
                                    <input name="txt_yes_file_bma" type="hidden" value="<?=$yes_file;?>">

                                    <p style="margin:6px 0 5px 0; font-size:16px; font-weight: 600">
                                        <span style="color:#09C; cursor:pointer;" class="basic_uploader">OR try simple uploader</span>
                                    </p>
                                    <div class="show_infos">&#10004; Please click on the update button below to update this photo</div>
                                </ul>
                                
                                <input type="hidden" name="txtf0" value="<?=$picx;?>">
                                <div class="form-group" style="margin-top: 18px;">
                                    <label for="cc-payment" class="control-label mb-1">Names</label>
                                    <input id="cc-pament" name="txtnames" type="text" class="form-control" placeholder="Enter your name" value="<?=$names;?>">
                                </div>

                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Email</label>
                                    <input id="cc-pament" name="txtemail" type="text" class="form-control" placeholder="Enter your email" value="<?=$emails;?>">
                                </div>

                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Phone Number</label>
                                    <input id="cc-pament" name="txtph" type="text" class="form-control" placeholder="Enter your phone number" value="<?=$phone;?>">
                                </div>

                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Gender</label>
                                    <select class="txtgend" name="txtgend" required="">
                                        <option value="m" <?php if($gender=="m") echo "selected"; ?>>Male</option>
                                        <option value="f" <?php if($gender=="f") echo "selected"; ?>>Female</option>
                                    </select>
                                </div>


                                <div class="form-group_ col-lg-offset-3 col-lg-6 col-sm-offset-3 col-sm-6">
                                    <div style="text-align:center; margin-top:2em;" id="buttons1">
                                        <input type="submit" value="Update Your Profile" id="cmd_update_profile_user" class="btn btn-lg btn-info btn-block">
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="alert alert-danger alert_msg2"></div>
                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>

                </div>
            </div> 
        </div>



        <div class="col-lg-offset-1 col-lg-4 col-md-offset-0 col-md-8 mt-md-30" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center">Update your password</h3>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'edit_pass'));
                            ?>
                                
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                    <input id="cc-pament" name="txtpass1" type="password" class="form-control" placeholder="Enter your old password">
                                </div>
                                <div class="form-group">
                                    <label for="cc-name" class="control-label mb-1">New Password</label>
                                    <input id="cc-name" name="txtpass2" type="password" class="form-control cc-name" placeholder="Enter your new password">
                                </div>
                                <div class="form-group">
                                    <label for="cc-number" class="control-label mb-1">Confirm Password</label>
                                    <input id="cc-number" name="txtpass3" type="password" class="form-control cc-number" placeholder="Confirm your new password">
                                </div>
                                <input type="hidden" name="admin_type" id="admin_type" value="">
                                
                                <div class="alert alert-danger alert_msg1"></div>
                                <div class="col-lg-offset-2 col-lg-8 col-sm-offset-3 col-sm-6">
                                    <input type="button" value="Update Password" id="cmd_update_pass_admin" class="btn btn-lg btn-info btn-block">
                                </div>
                                <div style="clear: both;"></div>
                                
                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>

                </div>
            </div> 
        </div>


        <div style="clear:both;"></div>
        <br><br>
    </div>
<?php } ?>





    </div><!-- /#right-panel -->
    <input type="hidden" id="txturl1" name="txturl1" value="<?=$url_id;?>" />
    
    

    <script src="<?=base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?=base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <script src="<?=base_url();?>assets/plugins/pace/pace.js"></script>
    <!-- <script src="<?=base_url();?>assets/scripts/siminta.js"></script> -->
    
    <!-- <script src="<?=base_url();?>assets_texteditor/libs/jquery/dist/jquery.min.js"></script> -->
    <!-- <script src="<?=base_url();?>assets/js/plugins.js"></script> -->

    <script src="<?=base_url();?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/fnReloadAjax.js"></script>
    <script src="<?=base_url();?>assets/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/js/responsive.bootstrap.min.js" type="text/javascript"></script>

    
    <!-- <script src="<?=base_url();?>assets_texteditor/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/select2/dist/js/select2.min.js"></script> -->
    <!-- <script src="<?=base_url();?>assets_texteditor/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->




    <script src="<?=base_url();?>assets_texteditor/libs/quill/dist/quill.min.js"></script>
    <script>
        
        // $(".select2").select2();
        // $('.demo').each(function() {
        // $(this).minicolors({
        //         control: $(this).attr('data-control') || 'hue',
        //         position: $(this).attr('data-position') || 'bottom left',

        //         change: function(value, opacity) {
        //             if (!value) return;
        //             if (opacity) value += ', ' + opacity;
        //             if (typeof console === 'object') {
        //                 console.log(value);
        //             }
        //         },
        //         theme: 'bootstrap'
        //     });

        // });
        // jQuery('.mydatepicker').datepicker();
        // jQuery('#datepicker-autoclose').datepicker({
        //     autoclose: true,
        //     todayHighlight: true
        // });
        // var quill = new Quill('#editor', {
        //     theme: 'snow'
        // });
    </script>


    <script>
        var site_urls = jq('#txtsite_url').val();
        var txt_pagename = jq('#txt_pagename').val();
        var txt_pagename1 = jq('#txt_pagename1').val();
        var txtqry = jq('#txtqry').val();
        var txturl1 = jq('#txturl1').val();
        var txtmem = jq('#txtmem').val(); // sponsor id

        //alert(txtmem);

        if(txt_pagename == "cart"){
            var urls = site_urls+"node/fetch_carts";
        }

        if(txt_pagename == "performance"){
            var urls = site_urls+"node/fetch_performance/";
        }


        var dataTable = jq('#scholarships, #performance1, #carts').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "order":[],
            "ajax":{
                url : urls,
                type: "post"
            },
            "columnDefs":[
            {
                "target":[0,3,4],
                "orderable": false
            }
            ]
        });


        jq("#menu-toggle").click(function(e) {
          e.preventDefault();
          jq("#wrapper").toggleClass("toggled");
        });
    </script>


</body>

</html>
