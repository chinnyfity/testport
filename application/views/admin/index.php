<?php
$page_name2 = str_replace('_', " ", $page_title);

//echo phpinfo();
//exit;
?>




<div id="page-wrapper" class="page-wrapper1">
    <div class="col-sm-12 float_left" style="padding:0 0 0 8px">
        <h1 class="page-header">
        <?php
        if($page_name == "")
            echo "Administrator";
        else
            echo $page_name2;
        ?>
        </h1>
    </div>

    <!-- <div class="col-sm-6 float_right" style="padding:0">
        <h1 class="page-header">
            
        </h1>
    </div> -->
</div>


<p style="text-align:center; font-size:16px;">
    <?php 
        // $url_seg = $this->uri->segment(3);
        // if($url_seg=="current")
        //     echo "Viewing current cart between interval of 5 days.";
        // else if($url_seg=="unapproved")
        //     echo "Viewing Unapproved Products";
    ?>
</p>

<div class="cover_body"></div>
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


<div class="cover_body"></div>
<div class="modal fade_" id="add_schs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times cmd_close_sch" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Enter School Name</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-success form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5" style="font-size:15px; display: block;">
                    <span class="fa fa-success"></span> Enter the name of school and click the button?
                    <input type="text" value="" placeholder="Enter School" name="txtschs" id="txtschs" class="form-control mt-5">
                </div>
            </div>

            <div class="modal-footer" style="border-top:none !important;">
                <button type="button" class="btn btn-success cmd_enter_sch" ><span class="fa fa-plus"></span>&nbsp;Add School</button>
                <button type="button" class="btn btn-default cmd_close_sch" data-dismiss="modal"><span class="fa fa-times"></span>&nbsp;No</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade_" id="add_subj_dv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times cmd_close_sub" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Enter Subject Name</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-success form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5" style="font-size:15px; display: block;">
                    <span class="fa fa-success"></span> Enter the name of subject and click the button?
                    <input type="text" value="" placeholder="Enter School" name="txtsub" id="txtsub" class="form-control mt-5">
                </div>
            </div>

            <div class="modal-footer" style="border-top:none !important;">
                <button type="button" class="btn btn-success cmd_enter_sub" ><span class="fa fa-plus"></span>&nbsp;Add Subject</button>
                <button type="button" class="btn btn-default cmd_close_sub" data-dismiss="modal"><span class="fa fa-times"></span>&nbsp;No</button>
            </div>
        </div>
    </div>
</div>



<?php 
if($page_name == ""){ 
?>

<div id="page-wrapper" class="small_box">

    <div class="row">
        <!--quick info section -->
        <div class="col-lg-3 boxes">
            <div class="alert alert-danger text-center">
                <i class="fa fa-user fa-3x"></i>&nbsp;Total of <b><?=@number_format($totalmems);?></b> Members
            </div>
        </div>

        <div class="col-lg-3 boxes">
            <div class="alert alert-success text-center">
                <i class="fa fa-map-marker fa-3x"></i>&nbsp;<?=@number_format($centres_cnt);?> Centres Uploaded
            </div>
        </div>

        <div class="col-lg-3 boxes">
            <div class="alert alert-info text-center">
                <i class="fa fa-shopping-cart fa-3x"></i><b><?=@number_format($carts_cnt);?></b> Items in a cart

            </div>
        </div>
        
        <div class="col-lg-3 boxes">
            <div class="alert alert-warning text-center">
                <?php //if($unread_msg<=0){ ?>
                    <i class="fa fa-upload fa-3x"></i><b><?=@number_format($res_cnt);?></b> Resources Uploaded
            </div>
        </div>
        <!--end quick info section -->
    </div>

    <div class="row">
        <div class="col-lg-8">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-user fa-fw"></i> Students (Last 8 students)
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12_">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped tbl_color">
                                    <thead>
                                        <tr>
                                            <th>Names</th>
                                            <th>Emails</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Location</th>
                                            <th>Date Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        $j=1;
                                        if(!empty($fetchMembers)): foreach($fetchMembers as $post): ?>
                                        <?php
                                            $fname = ucwords($post['names']);
                                            $approved = $post['approved'];
                                            $phones = $post['phone'];
                                            $ipaddr = $post['location'];
                                            $gender = $post['gender'];
                                            if($gender=="m") $gender="Male";
                                            if($gender=="f") $gender="Female";
                                            $dates = $post['created_at'];
                                            $dates = date("D jS M Y h:ia", strtotime($dates));
                                            $getLoc = $this->sql_models->getLoc($ipaddr);

                                            if($approved == 0){
                                                $approved_1 = "<font style='color:#090; cursor:default; font-size:16.5px;'><b>Approved</b></font>";
                                            }else{
                                                $approved_1 = "<font style='color:red; cursor:default; font-size:16.5px;'><b>Blocked</b></font>";
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$fname;?></td>
                                            <td><?=$approved_1;?></td>
                                            <td><a href="tel:<?=$phones;?>"><?=$phones;?></a></td>
                                            <td><?=$gender;?></td>
                                            <td><?=$getLoc;?></td>
                                            <td><?=$dates;?></td>
                                        </tr>
                                    <?php $j++; endforeach; else: ?>
                                    <tr><td colspan="6" style="text-align:center;">No members yet!</td></tr>
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


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-upload fa-fw"></i> Resources (Last 8 resources)
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12_">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped tbl_color">
                                    <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>Title</th>
                                            <th>Baords</th>
                                            <th>Price</th>
                                            <th>Views</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        $j=1;
                                        if(!empty($resources1)): foreach($resources1 as $post): ?>
                                        <?php
                                            $titles = ucfirst($post['titles']);
                                            $test_board = $post['test_board'];
                                            $price = @number_format($post['price']);
                                            $views = @number_format($post['views']);
                                            $media_type = $post['media_type'];
                                            if($media_type=="doc") $media_type1="Document"; else $media_type1="Video";
                                            
                                            if(strlen($titles)>80)
                                                $titles = substr($titles, 0, 80)."...";

                                            $test_board1 = $this->sql_models->fetchBoards($test_board);
                                            $test_types2 = "";
                                            foreach ($test_board1 as $row) {
                                                $test_types1 = $row['test_types'];
                                                $test_types2 .= "$test_types1, ";
                                            }
                                            $test_types2 = substr($test_types2, 0, -2);
                                        ?>
                                        <tr>
                                            <td><?=$j;?></td>
                                            <td><?=$titles;?></td>
                                            <td><?=$test_types2;?></td>
                                            <td><?=$price;?></td>
                                            <td><?=$views;?></td>
                                            <td><?=$media_type1;?></td>
                                        </tr>
                                    <?php $j++; endforeach; else: ?>
                                    <tr><td colspan="6" style="text-align:center;">No activities yet!</td></tr>
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

        <div class="col-lg-4">
            <div class="panel panel-primary text-center no-boder">
                <div class="panel-body red">
                    <i class="fa fa-edit fa-3x"></i>
                    <h3><?php echo @number_format($tests);?> </h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-eyecandy-title">Number of Tests Uploaded
                    </span>
                </div>
            </div>


            <!-- <div class="panel panel-primary text-center no-boder">
                <div class="panel-body green">
                    <i class="fa fa-edit fa-3x"></i>
                    <h3><?php echo @number_format($blogs);?> </h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-eyecandy-title">Blog Posts
                    </span>
                </div>
            </div> -->


            <div class="panel panel-primary text-center no-boder">
                <div class="panel-body blue">
                    <i class="fa fa-eye fa-3x"></i>
                    <h3><?php echo @number_format($webviews);?> </h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-eyecandy-title">Website Views
                    </span>
                </div>
            </div>

            
            <!-- <div class="panel panel-primary text-center no-boder">
                <div class="panel-body red">
                    <i class="fa fa-thumbs-up fa-3x"></i>
                    <h3>2,700 </h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-eyecandy-title">New User Registered
                    </span>
                </div>
            </div> -->


        </div>

    </div>

<br><br>
</div>


<?php } ?>






<?php if($page_name == "centres"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <p class="inner_links"><a href="<?=base_url();?>admin/add_centres/">Click To Add Centre</a></p>
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="centres1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Centre Name</th>
                            <th>TestBoard</th>
                            <th>Approved</th>
                            <th>Location</th>
                            <th>Views</th>
                            <th>Date Uploaded</th>
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



<?php if($page_name == "view_test"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <p class="inner_links"><a href="<?=base_url();?>admin/set_test/">Click To Add Test</a></p>
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="view_test" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>TestBoard</th>
                            <th>Subjects</th>
                            <th>Schools</th>
                            <th>Year</th>
                            <th>Time Set</th>
                            <th>Instruction</th>
                            <th>Date Uploaded</th>
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



<?php if($page_name == "view_advert"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="adverts" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Banner</th>
                            <th>Expiry</th>
                            <th>Uploaded</th>
                            <th class="none">Image</th>
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




<?php if($page_name == "subadmins"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="subadmin1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Names</th>
                            <th>Username</th>
                            <th>Approved</th>
                            <!-- <th>Status</th> -->
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




<?php if($page_name == "view_application"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="applicatn" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Names</th>
                            <th>Scholarship</th>
                            <th>Emails</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Qualification</th>
                            <th class="none">File Attached</th>
                            <th class="none">Brief Information</th>
                            <th class="none">Date Applied</th>
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



<?php 
if($page_name == "viewquestions"){
    $url_task1 = $this->uri->segment(3);
    //echo $usequiz1 = $this->sql_models->isUseQuests('quizes_intro', $url_task1);
    $getSchTitle = $this->sql_models->getQuizDetails('quizes', $url_task1);
    $test_types1 = $getSchTitle['test_types'];
    $subjs = $getSchTitle['subjs'];
    $schtitle="";
?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <p style="text-align: center; font-size: 15px;">
                        Viewing questions for <br><b><?=$subjs.", ".$test_types1;?></b>
                    </p>
                    <p style="text-align:center; font-size:16px;" class="add_questns"><span sess="<?=$url_task1;?>">Add Another Question</span></p>
                    <table id="myquestions" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Questions</th>
                            <th class="none">Image</th>
                            <th>Option1</th>
                            <th>Option2</th>
                            <th>Option3</th>
                            <th>Option4</th>
                            <th>Answer</th>
                            <th class="none">Explanation</th>
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




<?php 
if($page_name == "cart"){
?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="carts" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
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




<?php if($page_name == "students_performance"){ ?>
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




<?php 
if($page_name == "visitors"){
?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-md-6 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="carts" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <!-- <th>....</th> -->
                            <th>Location</th>
                            <th>Visitors</th>
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



<?php if($page_name == "resources"){ ?>
<div class="content mt-3" id="page-wrapper" style="">
    <div class="col-lg-12 container containerx house_tbl_">
        <p class="inner_links"><a href="<?=base_url();?>admin/add_resources/">Click To Add Resources</a></p>
        <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
            <div class="card-body all_tables">
                <table id="resources" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>TestBoard</th>
                        <th class="none">Size</th>
                        <th>Price</th>
                        <th>Years</th>
                        <th class="none">Media</th>
                        <th class="none">Views</th>
                        <th>Downloads</th>
                        <th class="none">File Type</th>
                        <th>Date Uploaded</th>
                        <th class="none">File</th>
                        <th class="none">Image</th>
                        <th class="none">Contents</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>



<?php if($page_name == "logos"){ ?>
<div class="content mt-3" id="page-wrapper" style="">
    <div class="col-lg-12 container containerx house_tbl_">
        <!-- <p class="inner_links"><a href="<?=base_url();?>admin/add_resources/">Click To Add Resources</a></p> -->
        <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
            <div class="card-body all_tables">
                <table id="logos" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>URL</th>
                        <th class="none">Logo</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>



<?php if($page_name == "forum"){ ?>
<div class="content mt-3" id="page-wrapper" style="">
    <div class="col-lg-12 container containerx house_tbl_">
        <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
            <div class="card-body all_tables">
                <table id="forum1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Users</th>
                        <th>Topic</th>
                        <th>Replies</th>
                        <th>Views</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                        <th class="none">Message</th>
                        <th class="none">Files</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>



<?php if($page_name == "forum_rep"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="forum_rep1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Replies</th>
                            <th>Users</th>
                            <th>Replied To</th>
                            <th>Dates</th>
                            <th>Action</th>
                            <th class="none">Post</th>
                            <th class="none">Replies</th>
                            <th class="none">Files</th>
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



<?php if($page_name == "add_resources" || $page_name == "edit_resources"){ ?>
    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>admin/resources/">Click To View Resources</a></p>
            <div class="card col-md-8 nopad" style="border:1px #ccc solid !important;">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                    if($getId!="")
                                    echo '<h3 class="text-center ttl"><b>Update This Resource</b></h3>';
                                    else
                                    echo '<h3 class="text-center"><b>Add A New Resource</b></h3>';
                                ?>
                            </div>
                            <hr>
                            <?php
                            echo form_open('', array('autocomplete'=>'off', 'id'=>'upload_form_res'));

                                if($getId!=""){
                                    $id1 = md5($getId['id']);
                                    $media_type = ucfirst($getId['media_type']);
                                    $test_board = $getId['test_board'];
                                    $titles = $getId['titles'];
                                    $descrip = nl2br($getId['descrip']);
                                    $img_cover = $getId['img_cover'];
                                    $files = $getId['files'];
                                    $file_type = $getId['file_type'];
                                    $price = $getId['price'];
                                    $years = $getId['years'];
                                    $captions1 = "Update Resource";


                                    //echo $test_board2 = substr($test_board, 0, -2);
                                    $test_board2 = explode(",", $test_board);
                                    $test_board = array_unique($test_board2);

                                    //$years1 = substr($years, 0, -2);
                                    $years1 = explode(",", $years);
                                    $years = array_unique($years1);
                                    //print_r($years);
                                    
                                }else{
                                    $id1="";$media_type="";$test_board="";$titles="";$files="";$file_type="";
                                    $captions1 = "Upload Resource";$descrip="";$img_cover="";$price="";
                                    $years="";
                                }

                                if($img_cover=="")
                                    $media_img1 = base_url()."images/film.jpg";
                                else
                                    $media_img1 = base_url()."resourcesfiles/$img_cover";
                            ?>
                                
                                <div class="first_create_form" style="display:nones;">

                                    <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <label class="control-label mb-1">Select Media</label>
                                        <select id="txtmedia" name="txtmedia">
                                            <option value='doc' <?php if($media_type=="doc") echo "selected"; ?> >File</option>
                                            <option value='vid' <?php if($media_type=="vid") echo "selected"; ?> >Video</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <label class="control-label mb-1">Select Test Board</label>
                                        <select name="txt_board[]" multiple="multiple" class="3col active form-control" id="txt_board" style="position: relative; z-index: 2">
                                            
                                            <?php
                                            if(!empty($tbs)): foreach($tbs as $post): 
                                                $id = $post['id'];
                                                $test_types = $post['test_types'];
                                            ?>
                                                <option value="<?=$id?>" <?php if($getId!=""){ if(in_array($id, $test_board)) echo "selected";} ?> ><?=$test_types?></option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>

                                        <script type="text/javascript">
                                          (function ($) {
                                            k('select[multiple].active.3col').multiselect({
                                                columns: 2,
                                                placeholder: '-Select Test Board-',
                                                search: true,
                                                searchOptions: {
                                                    'default': 'Search Test Board'
                                                },
                                                selectAll: true
                                            });
                                          })(jq);
                                        </script>
                                    </div>
                                    <div style="clear:both"></div>

                                    <div class="form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <label for="cc-payment" class="control-label mb-1">Resources Name</label>
                                        <input type="text" value="<?=$titles;?>" placeholder="Enter Name" name="txttitle" id="txttitle" class="form-control">
                                    </div>
                                    <div style="clear:both"></div>

                                    <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <label for="cc-payment" class="control-label mb-1">Price</label>
                                        <font style="font-size: 15px; color: #777;">(Enter 0 or leave empty when price is free)</font>
                                        <input type="number" value="<?=$price;?>" placeholder="Enter Price" name="txtprice" id="txtprice" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <label for="cc-payment" class="control-label mb-1">File Type</label>
                                        <select id="txtftype" name="txtftype">
                                            <option value='softcopy' <?php if($file_type=="softcopy") echo "selected"; ?> >SoftCopy</option>
                                            <option value='hardcopy' <?php if($file_type=="hardcopy") echo "selected"; ?> >HardCopy</option>
                                        </select>
                                    </div>
                                    <div style="clear:both"></div>


                                    <div class="form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <label class="control-label mb-1">Select Year (Optional)</label>
                                        <select name="txt_yr[]" multiple="multiple" class="4col active form-control" id="txt_yr">
                                            <?php
                                            for($i=2019; $i>=1990; $i--):
                                            ?>
                                                <option value="<?=$i?>" <?php if($getId!=""){ if(in_array($i, $years)) echo "selected";} ?> ><?=$i?></option>
                                            <?php endfor; ?>
                                        </select>

                                        <script type="text/javascript">
                                          (function ($) {
                                            k('select[multiple].active.4col').multiselect({
                                                columns: 4,
                                                placeholder: '-Select Year-',
                                                search: true,
                                                searchOptions: {
                                                    'default': 'Search Year'
                                                },
                                                selectAll: true
                                            });
                                          })(jq);
                                        </script>
                                    </div>


                                    <div class="form-group col-lg-12 col-sm-12">
                                        <label class="control-label mb-1">Content</label>
                                        <div id="editor" name="editor" style="height: 200px;">
                                            <?=$descrip;?>
                                        </div>
                                        <textarea name="txteditor" style="display: none;" id="txteditor"><?=$descrip;?></textarea>
                                    </div>


                                    <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <div class="form-group_">
                                            <input id="former_file_ph" name="former_file_ph" value="<?=$files?>" class="form-control" style="display:none;" />
                                          <label class="control-label mb-1">File</label>
                                          <input type="file" name="txtfile" id="txtfile" class="form-control" style="padding:10px; height: auto; font-size:15px; color: #333;" />
                                          <span style="font-size: 14px; font-weight: normal; color:#C64000;">(Accepted formats: mp4, doc, pdf. Max: 20MB)</span>
                                        </div>
                                        <?php
                                        if($getId){
                                            
                                            echo "<div class='update_imgs1' id='update_imgs1_1' id2='1' style='margin: 20px 0 20px 0;'>";
                                                echo "<div class='remove_file' id_img='$id1' files='$files' folders='resourcesfiles/'>Remove this media</div>";
                                            echo "</div><br>";
                                        }
                                        ?>
                                    </div>


                                    <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <div class="form-group_">
                                            <input id="former_file_ph1" name="former_file_ph1" value="<?=$img_cover?>" class="form-control" style="display:none;" />
                                          <label class="control-label mb-1">Cover Image (Optional)</label>
                                          <input type="file" name="txtfile1" id="txtfile1" class="form-control" style="padding:10px; height: auto; font-size:15px; color: #333;" />
                                          <span style="font-size: 14px; font-weight: normal; color:#C64000;">(Accepted formats: jpg, png. Max: 1MB)</span>
                                        </div>

                                        <?php
                                        
                                        if($img_cover!=""){
                                            $files2 = "<div class='div_media'><div class='play_btn play_btn1'></div><img src='$media_img1'></div>";

                                            if($getId){
                                                echo "<div class='update_imgs1' id='update_imgs1_2'>";
                                                echo $files2;
                                                    echo "<div class='remove_file' id2='2' id_img='$id1' files='$img_cover' folders='resourcesfiles/'>Remove</div>";
                                                echo "</div><br>";
                                            }
                                        }
                                        ?>
                                    </div>


                                    
                                    <div style="clear:both"></div>
                                    <input type="hidden" name="txt_id" id="txt_id" value="<?=$id1?>" />


                                    <div class="col-sm-offset-3 col-sm-6 mt-20">
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

                                    <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Go Back" id="cmd_back_tofirst" class="btn btn-lg btn-info btn-block">
                                        </div>
                                        <p style="margin: 1.2em 0 0 0;">
                                            <span class="view_changes" pages="resources">View Changes</span>
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



<?php if($page_name == "add_logo" || $page_name == "edit_logo"){ ?>
    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>admin/logos/">Click To View Company Logo</a></p>
            <div class="card col-md-8 nopad" style="border:1px #ccc solid !important;">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                    if($getId!="")
                                    echo '<h3 class="text-center ttl"><b>Update This Logo</b></h3>';
                                    else
                                    echo '<h3 class="text-center"><b>Add A New Company Logo</b></h3>';
                                ?>
                            </div>
                            <hr>
                            <?php
                            echo form_open('', array('autocomplete'=>'off', 'id'=>'upload_form_logo'));

                                if($getId!=""){
                                    $id1 = md5($getId['id']);
                                    $urls = ucfirst($getId['urls']);
                                    $img_cover = $getId['files'];
                                    $captions1 = "Update Logo";

                                }else{
                                    $id1="";$urls="";$img_cover="";
                                    $captions1 = "Upload Logo";
                                }

                                $media_img1 = base_url()."images/logos/$img_cover";
                            ?>
                                
                                <div class="first_create_form" style="display:nones;">

                                    <div class="form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <label for="cc-payment" class="control-label mb-1">Company Website/Email</label>
                                        <input type="text" value="<?=$urls;?>" placeholder="Enter Company Website or Email" name="txturl" id="txturl" class="form-control">
                                        <p style="font-size: 14px; margin-top: 3px; font-weight: normal; color:#C64000;">(All URL websites must start with <b>http:// or https://</b>)</p>
                                    </div>
                                    <div style="clear:both"></div>


                                    <div class="form-group col-md-12 col-sm-12 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                        <div class="form-group_">
                                            <input id="former_file_ph1" name="former_file_ph1" value="<?=$img_cover?>" class="form-control" style="display:none;" />
                                          <label class="control-label mb-1">Upload Logo</label>
                                          <input type="file" name="txtfile1" id="txtfile1" class="form-control" style="padding:10px; height: auto; font-size:15px; color: #333;" />
                                          <span style="font-size: 14px; font-weight: normal; color:#C64000;">(Accepted formats: jpg, png. Max: 1MB)</span>
                                        </div>

                                        <?php
                                        
                                        if($img_cover!=""){
                                            $files2 = "<div class='div_media'><div class='play_btn play_btn1'></div><img src='$media_img1'></div>";

                                            if($getId){
                                                echo "<div class='update_imgs1' id='update_imgs1_2'>";
                                                echo $files2;
                                                    echo "<div class='remove_file' id2='2' id_img='$id1' files='$img_cover' folders='images/logos/'>Remove</div>";
                                                echo "</div><br>";
                                            }
                                        }
                                        ?>
                                    </div>


                                    
                                    <div style="clear:both"></div>
                                    <input type="hidden" name="txt_id" id="txt_id" value="<?=$id1?>" />


                                    <div class="col-sm-offset-3 col-sm-6 mt-20">
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

                                    <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Go Back" id="cmd_back_tofirst" class="btn btn-lg btn-info btn-block">
                                        </div>
                                        <p style="margin: 1.2em 0 0 0;">
                                            <span class="view_changes" pages="logos">View Changes</span>
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



<?php if($page_name == "members"){ ?>
    
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="members" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Names</th>
                            <th>Emails</th>
                            <th>Phones</th>
                            <th>Gender</th>
                            <th>Location</th>
                            <th>Date Registered</th>
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



<?php if($page_name == "view_subscription"){ ?>
    
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="mem_subs1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Names</th>
                            <th>Subscription</th>
                            <th>Paid</th>
                            <th>Payment Method</th>
                            <th>Expiry</th>
                            <th>Date Subscribed</th>
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




<?php if($page_name == "viewquiz"){ ?>
    
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_quizes" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Scholarship</th>
                            <th>Approved</th>
                            <th>Time Set</th>
                            <th>Date</th>
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



<?php if($page_name == "viewblog"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_blogs" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Views</th>
                            <th>Date</th>
                            <th class="none">Content</th>
                            <th class="none">Media</th>
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




<?php if($page_name == "uploadblog" || $page_name == "edit_blog"){ ?>
    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>admin/viewblog/">Click To View Blog</a></p>
            <div class="card col-md-8 nopad" style="border:1px #ccc solid !important;">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                //echo md5(38);
                                if($url_id!="")
                                echo '<h3 class="text-center ttl"><b>Update This Post</b></h3>';
                                else
                                echo '<h3 class="text-center"><b>Create A New Blog Post</b></h3>';
                                ?>
                                <p>All blog contents/media uploaded here will be seen on the blog page
                                </p>
                            </div>
                            <hr>
                            <?php
                                if($url_id!=""){
                                    $id1 = md5($getId['id']);
                                    $rands1 = $getId['rands'];
                                    $titles = ucwords($getId['titles']);
                                    $descrip = $getId['descrip'];
                                    $captions1 = "Update Blog Post";
                                    $getFiles = $this->sql_models->getFiles('blog_media', $rands);
                                }else{
                                    $id1="";$titles="";$descrip="";$rands1="";
                                    $captions1 = "Upload Blog Post";
                                }
                            ?>
                                
                                <div class="first_create_form" style="display:nones;">
                                    <?php //echo form_open('', array('autocomplete'=>'off', 'id'=>'create_evts')); ?>
                                    <?php echo form_open_multipart('', array('class'=>'uploadblog', 'autocomplete'=>'off')); ?>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Title</label>
                                            <input type="text" value="<?=$titles;?>" placeholder="Enter title of event" name="txttitle" id="txttitle" class="form-control" style="text-transform:capitalize;">
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-name" class="control-label mb-1">Contents</label>
                                            <!-- <textarea id="txtdescrip" name="txtdescrip" style="height:20em !important;" placeholder="Write the contents of this this event" class="form-control"><?php echo ucfirst($descrip);?></textarea> -->

                                            <div id="editor" name="editor" style="height: 300px;">
                                                <?=$descrip;?>
                                            </div>
                                            <textarea name="txtdescrip" style="display: none;" id="txtdescrip"><?=$descrip;?></textarea>
                                        </div>

                                        <div class="form-group for_photos">
                                            <input id="former_file_ph" name="former_file_ph" value="<?php //echo $files; ?>" class="form-control" style="display:none;" />
                                            <?php
                                            if($url_id!=""){
                                                //echo "<div class='update_imgs1'>";
                                                if($getFiles):
                                                    foreach ($getFiles as $row) {
                                                        $ids = $row['id'];
                                                        $file1 = $row['files'];
                                                        $rands1 = $row['rands'];
                                                        echo "<div class='update_imgs1 update_imgs2$ids'>";
                                                            echo "<img src='".base_url()."blogs/$file1' id='im10'>";
                                                            echo "<font class='delete_imgs' id='delete_imgs$ids' files='$file1' ids='$ids'>Delete</font>";
                                                        echo "</div>";
                                                    }
                                                endif;
                                                //echo "</div>";
                                            }
                                            ?>
                                            <div style="clear: both;"></div>
                                            <label for="cc-number" class="control-label mb-1">Upload Images</label>
                                            <input type="file" name="blog_img[]" multiple id="blog_img" style="padding:4px; font-size:16px;" />
                                            <p>Accepted formats: jpg, png. Max: 3MB</p>
                                        </div>

                                        <input type="hidden" name="blogid" id="blogid" value="<?php echo $id1; ?>" />
                                        <input type="hidden" name="txtrand" id="txtrand" value="<?php echo $rands1; ?>" />


                                        <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                                            <div style="text-align:center; margin-top:1em;" id="buttons1">
                                                <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" id="cmd_upload_media" class="btn btn-lg btn-info btn-block inlines_">
                                                
                                                <?php 
                                                // if($id1!="")
                                                // echo '<input type="button" value="Go Next &raquo;" id="cmd_next_evt" actid="'.$id1.'" class="btn btn-lg btn-info btn-block inlines">';
                                                ?>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="alert alert-danger alert_msg"></div>
                                    <?php echo form_close(); ?>
                                </div>


                                <?php /* ?><div class="second_create_form" style=" display:none;">
                                    
                                    <div class="java_uploader">
                                        <div class='content'>
                                            <form action="<?php echo base_url() ?>upload.php" class="dropzone" id="myAwesomeDropzone"> 
                                                <div class="former_uploads" style="display:none"></div>
                                            </form>
                                        </div>
                                    </div>

                                    <?php echo form_open_multipart('', array('class'=>'uploadimage2', 'autocomplete'=>'off')); ?>
                                        <div class="simple_uploader" style="display:none; border:2px solid #ccc; padding:20px 4px 20px 4px; margin-left:-4px;">
                                            <p style="color:#444; margin-left:6px;">Select multiple photos</p>
                                            <input type="file" name="txt_bma_pic1[]" multiple id="txt_bma_pic1" style="padding:4px; font-size:15px; margin-top:8px;" />
                                        </div>

                                        <p style="margin:10px 0 10px 0; font-size:17px; text-align:center">
                                            <span style="color:#09C; cursor:pointer;" class="basic_uploader1"><b>Try the simple uploader</b></span>
                                            <span style="color:#09C; cursor:pointer; display:none" class="big_uploader"><b>Try normal Uploader</b></span>
                                        </p>
                                        
                                        <div class="col-md-offset-3 col-md-6">
                                            <div style="text-align:center; margin-top:1em;" id="buttons1" class="auto_uploader_div">
                                                <input type="button" value="Done" id="cmd_done_upload" class="btn btn-lg btn-info btn-block">
                                            </div>

                                            <div style="text-align:center; margin-top:1em; display:none;" id="buttons1" class="basic_uploader_div">
                                                <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" class="btn btn-lg btn-info btn-block cmddones_basic">
                                                <input type="button" value="<?=$captions2;?>" class="btn btn-lg btn-info btn-block cmddones_basic1" style="opacity:0.4; display:none;">
                                                <?php
                                                if($id1!="")
                                                echo '<input type="button" value="Go Next &raquo;" id="cmd_next_evt1" class="btn btn-lg btn-info btn-block inlines">';
                                                ?>
                                            </div>
                                        </div>

                                        <div style="clear:both"></div>
                                        <div class="err_div4"></div>
                                    <?php echo form_close(); ?>
                                </div> <?php */ ?>


                                <div class="third_create_form" style="display:none; text-align:center;">
                                    <p>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                          <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                          <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                        </svg>
                                    </p>
                                    <?php if($url_id!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>Blog post has been updated successfully</b></p>
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>Blog post has been uploaded successfully</b></p>
                                    <?php } ?>

                                    <p style="font-size:16px; color:#555;">
                                        This will reflect immediately and can be seen on the platform on the blog page
                                    </p>

                                    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Done" id="cmd_goto_firstform" class="btn btn-lg btn-info btn-block">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>

                                <br><br>

                        </div>
                    </div>

                </div>
            </div> 

        </div>

        <div style="clear:both;"></div>
        <br><br><br><br>
    </div>
    

<?php } ?>



<?php if($page_name == "upload_centres_" || $page_name == "edit_centres_"){ ?>
    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>admin/view_scholarship/">Click To View Scholarship</a></p>
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
                                    <input type="hidden" value="0" name="txtmem">
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
                                        <input type="text" value="<?=$titles;?>" placeholder="Enter title" name="txttitle" id="txttitle" class="form-control">
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

                                    <!-- <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                        <label class="control-label mb-1">Select State</label>
                                        <select class="form-control" name="txtstate1" id="txtstate1">

                                            <?php
                                            $selected="";
                                            if($fetchStates):
                                                foreach($fetchStates as $post):
                                                    $id = $post['id'];
                                                    $states1 = ucwords($post['name']);
                                                    ?>
                                                    <option value='<?=$id;?>' <?php if($states==$id) echo "selected"; ?> ><?=$states1;?></option>
                                                <?php
                                                endforeach;
                                            else:
                                                echo '<option value="" selected>Select State</option>';
                                            endif; ?>
                                        </select>
                                    </div> -->

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


                                    <div class="hide_this" style="display: none;">
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
                                            <span class="view_changes" pages="resources">View Changes</span>
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




<?php if($page_name == "add_centres" || $page_name == "edit_centres"){ ?>
    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>admin/centres/">Click To View Centres</a></p>
            <div class="card col-md-8 nopad" style="border:1px #ccc solid !important;">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                    if($getId!="")
                                    echo '<h3 class="text-center ttl"><b>Update This Centre</b></h3>';
                                    else
                                    echo '<h3 class="text-center"><b>Add A New Centre</b></h3>';
                                ?>
                            </div>
                            <hr>
                            <?php
                            echo form_open('', array('autocomplete'=>'off', 'id'=>'upload_form_centre'));
                                //$new1 = "";
                                if($getId!=""){
                                    $id1 = md5($getId['id']);
                                    $centre_name = ucfirst($getId['centre_name']);
                                    $test_board = $getId['test_board'];
                                    $locations = $getId['locations'];
                                    $statee = $getId['statee'];
                                    $city = $getId['city'];
                                    $captions1 = "Update Centre";
                                    
                                }else{
                                    $id1="";$centre_name="";$test_board="";$locations="";
                                    $captions1 = "Upload Centre";$statee="";$city="";
                                }
                            ?>
                                
                                <div class="first_create_form" style="display:nones;">
                                    <input type="hidden" value="0" name="txtmem">

                                    <div class="form-group col-lg-12">
                                        <label class="control-label mb-1">Select Board</label>
                                        <select id="txtboard" name="txtboard">
                                            <?php
                                            $selected="";
                                            foreach($tbs as $post):
                                                $id = $post['id'];
                                                $test_types = ucwords($post['test_types']);
                                                ?>
                                                <option value='<?=$id;?>' <?php if($test_board==$id) echo "selected"; ?> ><?=$test_types;?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group col-lg-12">
                                        <label for="cc-payment" class="control-label mb-1">Centre Name</label>
                                        <input type="text" value="<?=$centre_name;?>" placeholder="Enter Centre Name" name="txttitle" id="txttitle" class="form-control">
                                    </div>

                                    <input type="hidden" class="field" value="<?=$statee?>" id="txtstates1" name="txtstates1" />

                                    <input type="hidden" class="field contry_1" value="<?=$city?>" id="txtcity" name="txtcity" />

                                    <div class="form-group col-lg-12">
                                        <label class="control-label mb-1">Location</label>
                                        <label>Center Location <small>*</small> &nbsp;<span style="font-size: 14px; font-weight: normal; color:#C64000;">(Embeded with google location)</span></label>
                                        <input name="txtaddress" value="<?=$locations?>" id="pac-input" class="form-control required border-greyer1-1px" type="text" placeholder="Enter Center Location">
                                        <p style="font-size: 14px; font-weight: normal; color:#C64000;">This will be visible to members for easy location of your centre</p>
                                        <div id="map" style="display:none;"></div>
                                    </div>

                                    
                                    <div style="clear:both"></div>
                                    <input type="hidden" name="txt_id" id="txt_id" value="<?=$id1?>" />


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
                                            <span class="view_changes" pages="centres">View Changes</span>
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



<?php if($page_name == "quiz_winners"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="view_winners" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Scholarship</th>
                            <th>Member</th>
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




<?php if($page_name == "winners"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <p style="text-align: center;font-size: 16px; line-height: 25px;">
                        <b>Members Who Participated in the Scholarship<br><?=$campname?></b>
                    </p>
                    <table id="view_leaderb2" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Members</th>
                            <th>Scores</th>
                            <th>Position</th>
                            <th>Time Finished</th>
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




<?php if($page_name == "set_test" || $page_name == "edit_test"){ 
    $url_task1 = $this->uri->segment(3);
?>


    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>admin/view_test/">Click To View Test</a></p>
            <div class="card col-lg-8 col-md-9 nopad" style="border:1px #ccc solid !important;">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                    if($url_id!=""){
                                        //if($url_id1 == "1838747")
                                            echo '<h3 class="text-center"><b>Update This Test</b></h3>';
                                        // else
                                        //     echo '<h3 class="text-center"><b>Update This Test</b></h3>';
                                    }else{
                                        echo '<h3 class="text-center"><b>Create Questions For The Selected Test Board</b></h3>';
                                    }
                                    ?>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'create_quiz_form', 'enctype'=>'multipart/form-data'));
                                if($url_id!=""){
                                    // if(empty($getQuizes)){
                                    //     $getQuizes = $getQuizesID;
                                    //     $sessionsx="";

                                    // }else{
                                    //     $set_time1=$getQuizes['set_time'];
                                    //     $sessionsx=$getQuizes['sessions1'];
                                    //     $qi_id="";
                                    // }
                                    // $getSchQID = $this->sql_models->getSchQID('quizes_intro', $url_task1);
                                    // $qi_id = $getSchQID['id'];
                                    $set_time1 = $getQuizes1['set_time'];
                                    
                                    $id1 = $getQuizes1['ids'];
                                    $test_board=$getQuizes1['test_board'];
                                    $instructn=$getQuizes1['instructn'];
                                    $sessions=$getQuizes1['sessions'];
                                    $years1=$getQuizes1['years'];
                                    $subject_id=$getQuizes1['subject_id'];
                                    //$subjs1 = $this->sql_models->getTestDetails2($sessions, 'arrs', 'subject_id', 'qi');
                                    $name_of_schs = $this->sql_models->getTestDetails2($sessions, 'arrs', 'name_of_sch', 'qi');

                                    
                                    $subs = "";
                                    $name_of_sch3 = "";
                                    $years_i="";
                                    // foreach ($subjs1 as $row) {
                                    //     $subjs = $row['subject_id'];
                                    //     $subs .= "$subjs, ";
                                    // }
                                    // $subs1 = substr($subs, 0, -2);
                                    // $subjs1 = explode(", ", $subs1);
                                    // $subjs1 = array_unique($subjs1);

                                    foreach ($name_of_schs as $row) {
                                        $name_of_sch2 = $row['name_of_sch'];
                                        $name_of_sch3 .= "$name_of_sch2, ";
                                    }
                                    $name_of_schs1 = substr($name_of_sch3, 0, -2);
                                    $name_of_schs = explode(", ", $name_of_schs1);
                                    $name_of_schs = array_unique($name_of_schs);

                                    
                                    $captions1 = " Update Test ";
                                    echo "<input type='hidden' value='$url_id' name='quiz_ids'>";
                            
                                }else{
                                    $questions="";
                                    $sessionsx="";
                                    $set_time1="";
                                    $instructn = $this->sql_models->getLastInstr();
                                    $test_board="";$sessions="";$years1="";
                                    $qi_id="";
                                    $subject_id="";
                                    $Submits1 = " Set Test &raquo; ";
                                    $captions1 = "Set Test &raquo;";
                                    $id1 = "";
                                    $id3 = "";
                                    echo "<input type='hidden' value='' name='quiz_ids'>";

                                }

                            ?>
                            <!-- quizes_intro is $url_id -->
                            <input type="hidden" id="txtquizid" name="txtquizid" value="<?=$url_id;?>" />
                                
                                <div class="first_create_game" style="display:nones">
                                    <div class="form-group" style="position: relative; z-index: 9">
                                        <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5 colmd6_">
                                            <label for="cc-payment" class="control-label mb-1">Select Test Board</label>
                                            <select name="txt_board" id="txt_board" class="form-control" style="color:#666;">
                                                <option value="" <?php if($url_id=="") echo "selected"; ?> >-Select Test Board-</option>
                                                <?php
                                                if(!empty($tbs)): foreach($tbs as $post): 
                                                    $id = $post['id'];
                                                    $titles = $post['test_types'];
                                                ?>
                                                    <option value="<?=$id?>" <?php if($id==$test_board) echo "selected"; ?> ><?php echo $titles; ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>

                                            <!-- <select name="txt_board[]" multiple="multiple" class="3col active form-control" id="txt_board">
                                                  <?php
                                                  $selected="";
                                                  if($tbs):
                                                  foreach($tbs as $post):
                                                      $id = $post['id'];
                                                      $titles = ucwords($post['test_types']);
                                                      ?>
                                                      <option value='<?=$id;?>'><?=$titles;?></option>
                                                  <?php
                                                    endforeach;
                                                  endif;
                                                  ?>
                                            </select> -->

                                            <!-- <script type="text/javascript">
                                              $(function () {
                                                $('select[multiple].active.3col').multiselect({
                                                    columns: 2,
                                                    placeholder: '-Select Test Board-',
                                                    search: true,
                                                    searchOptions: {
                                                        'default': 'Search Test Board'
                                                    },
                                                    selectAll: true
                                                });
                                              });
                                            </script> -->
                                        </div>

                                        <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5 colmd6_">
                                            <label for="cc-payment" class="control-label mb-1">Select Subject</label> <span class="add_subj">(Add subject)</span>

                                            <div class="div_subject">
                                                <select name="txt_subj" id="txt_subj" class="form-control">
                                                    <option value="" <?php if($url_id=="") echo "selected"; ?> >-Select Subject-</option>
                                                    <?php
                                                    if(!empty($subjts)): foreach($subjts as $post): 
                                                        $id = $post['id'];
                                                        $subjs = $post['subjs'];
                                                    ?>
                                                        <option value="<?=$id?>" <?php if($id==$subject_id) echo "selected"; ?>><?=$subjs?></option>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>

                                            <!-- <select name="txt_subj[]" multiple="multiple" class="3col active form-control" id="txt_subj">
                                                  <?php
                                                  $selected="";
                                                  if($subjts): //subjs1
                                                  foreach($subjts as $post):
                                                      $id = $post['id'];
                                                      $subjs = ucwords($post['subjs']);
                                                      ?>
                                                      <option value='<?=$id;?>' <?php if($url_id!=""){ if(in_array($id, $subjs1)) echo "selected";} ?> ><?=$subjs;?></option>
                                                  <?php
                                                    endforeach;
                                                  endif;
                                                  ?>
                                            </select>

                                            <script type="text/javascript">
                                              (function ($) {
                                                k('select[multiple].active.3col').multiselect({
                                                    columns: 2,
                                                    placeholder: '-Select Subject-',
                                                    search: true,
                                                    searchOptions: {
                                                        'default': 'Search Subject'
                                                    },
                                                    selectAll: true
                                                });
                                              })(jq);
                                            </script> -->
                                        </div>

                                        <div class="form-group col-md-6 col-sm-6 pr-5 pl-5 pr-xs-5 pl-xs-5 colmd6_">
                                            <label for="cc-payment" class="control-label mb-1">Select School</label> <span class="add_sch">(Add school)</span>
                                            <!-- <select name="txt_sch" id="txt_sch" class="form-control">
                                            <option value="" <?php if($url_id=="") echo "selected"; ?> >-Select Subject School-</option>
                                                <?php
                                                if(!empty($schs)): foreach($schs as $post): 
                                                    $id = $post['id'];
                                                    $name_of_sch = ucwords($post['name_of_sch']);
                                                ?>
                                                    <option value="<?php echo $id; ?>"><?php echo $name_of_sch; ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select> -->

                                            <div class="div_sch">
                                                <select name="txt_sch[]" multiple="multiple" class="3cols active form-control" id="txt_sch">
                                                      <?php
                                                      $selected="";
                                                      if($schs):
                                                      foreach($schs as $post):
                                                          $id = $post['id'];
                                                          $name_of_sch = ucwords($post['name_of_sch']);
                                                          ?>
                                                          <option value='<?=$id;?>' <?php if($url_id!=""){ if(in_array($id, $name_of_schs)) echo "selected";} ?>><?=$name_of_sch;?></option>
                                                      <?php
                                                        endforeach;
                                                      endif;
                                                      ?>
                                                </select>
                                            </div>

                                            <script type="text/javascript">
                                              //var jq1 = $.noConflict();
                                              (function ($) {
                                                k('select[multiple].active.3cols').multiselect({
                                                    columns: 1,
                                                    placeholder: '-Select School-',
                                                    search: true,
                                                    searchOptions: {
                                                        'default': 'Search School'
                                                    },
                                                    selectAll: true
                                                });
                                              })(jq);
                                            </script>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6 pr-5 pl-5 col-sm-6 pr-xs-5 pl-xs-5 colmd6_" style="position: relative; z-index: 1">
                                        <label class="control-label" for="input-firstname">Timing <span style="color:#888; font-size:14px; font-weight:normal">(Note that the timing will be in minutes)</span></label><br>         
                                        <input type="number" class="form-control" name="txtquiz_time" value="<?=$set_time1;?>" id="txtquiz_time" placeholder="Example 20 which means 20 minutes" />
                                    </div>

                                    <div class="form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5 colmd6_">
                                        <label class="control-label" for="input-firstname">Test Year</label>
                                        <input type="text" class="form-control" name="txtyear" value="<?=$years1;?>" id="txtyear" placeholder="Example 2017, 2018, etc" />
                                    </div>

                                    <div class="form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5 colmd6_">
                                        <label class="control-label" for="input-firstname">Instruction <span style="color:#888; font-size:14px; font-weight:normal">(Optional)</span></label><br>         
                                        <textarea placeholder="Type test instructions" name="txtinstruc" class="form-control" style="height: 100px !important;" id="txtinstruc"><?=$instructn;?></textarea>
                                    </div>

                                    <div style="clear: both;"></div>
                                    <!-- <div class="border-bottom-gray1 mt-20 mb-30"></div> -->

                                    <div style="clear:both"></div>
                                    <div class="alert alert-danger alert_msgs alert_msg1" style="margin-bottom: 0px;"></div>
                                

                                    <div class="col-md-offset-4 col-md-4 pr-5 pl-5 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-sm-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" id="cmd_create_quiz" class="btn btn-lg btn-info btn-block">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>

                                

                                <div class="third_create_form" style="display:none; text-align:center;">
                                    <p>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                          <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                          <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                        </svg>
                                    </p>
                                    <?php if($url_id!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>This TestBoard has been updated successfully</b></p>
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>A Test Has Been Set!</b></p>
                                        <p style="font-size:16px; color:#093;">It will be seen immediately on the platform, you can also disapprove it for students to be unable to access it. Now click the <b>"Upload Questions" button</b> to upload the questions.
                                        </p>
                                    <?php } ?>

                                    <div class="col-md-offset-3 col-md-2 col-sm-offset-3 col-sm-2 col-xs-offset-3 col-xs-6">
                                        <div style="text-align:center; margin-top:1em; opacity: 0.8" id="buttons1">
                                            <input type="button" value="&laquo; Back" id="cmd_goto_first" class="btn btn-lg btn-info btn-block">
                                        </div>
                                    </div>

                                    <div class="col-md-offset-0 col-md-4 col-sm-offset-0 col-sm-4 col-xs-offset-1 col-xs-10">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Add Questions &raquo;" id="cmd_goto_questions" class="btn btn-lg btn-info btn-block">
                                        </div>
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





<?php if($page_name == "upload_questions" || $page_name == "edit_questions"){ 
    $url_task1 = $this->uri->segment(3);
?>
    <div class="content mt-3 container" id="page-wrapper">
        <div class="col-md-12 nopad1">
            <p class="inner_links"><a href="<?=base_url();?>admin/view_test/">Click To View Test</a></p>
            <div class="card col-md-8 nopad" style="border:1px #ccc solid !important;">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                    echo '<h3 class="text-center"><b>Add Questions</b></h3>';
                                    $testDets = $this->sql_models->getTestDetails();
                                    $test_types = $testDets['test_types'];
                                    $sessions = $testDets['sessions'];
                                    $testDets1 = $this->sql_models->getTestDetails1($sessions);

                                    $subjs1="";
                                    $sch_name1="";
                                    if($testDets1):
                                        foreach ($testDets1 as $row) {
                                            $subjs = $row['subjs'];
                                            //$subjs1.="$subjs, ";
                                            $subjs1="Adding Questions For <b>$subjs</b>";
                                            $name_of_sch = $row['name_of_sch'];

                                            if($name_of_sch>0){
                                                $schName = $this->sql_models->getSchName($name_of_sch);

                                                foreach ($schName as $row) {
                                                    $name_of_sch1 = $row['name_of_sch'];
                                                    $s_id = $row['id'];
                                                    if($s_id!=$name_of_sch){
                                                        $sch_name1.="$name_of_sch1, ";
                                                    }else{
                                                        $sch_name1="$name_of_sch1, ";
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        $sch_name1 = substr($sch_name1, 0, -2);
                                    endif;
                                ?>

                                <div class="test_infos">
                                    <p><?=$test_types?></p>
                                    <p class="subb"><?=$subjs1?></p>
                                    <p class="subb"><?=ucwords($sch_name1)?></p>
                                </div>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'create_quiz_form1', 'enctype'=>'multipart/form-data'));
                                if($url_id!=""){
                                    //$getSchQID = $this->sql_models->getSchQID('quizes_intro', $url_task1);
                                    //$qi_id = $getSchQID['id'];
                                    //$set_time1 = $getSchQID['set_time'];
                                    $sessionsx = $getQuizes['sessions'];
                                    $id1 = $getQuizes['id'];
                                    $questions=ucfirst($getQuizes['questions']);
                                    $files=$getQuizes['files'];
                                    //$id3=$getQuizes['id3'];
                                    //$instructn=$getQuizes['instructn'];
                                    $op1=ucwords($getQuizes['op1']);
                                    $op2=ucwords($getQuizes['op2']);
                                    $op3=ucwords($getQuizes['op3']);
                                    $op4=ucwords($getQuizes['op4']);
                                    $ans1=ucwords($getQuizes['ans1']);
                                    $explanations=$getQuizes['explanations'];
                                    $captions1 = " Update Question ";
                                    $captions2 = "Update Question &raquo;";
                                    echo "<input type='hidden' value='$url_id' name='quiz_ids'>";
                            
                                }else{
                                    $questions="";
                                    $files="";
                                    $sessionsx="";
                                    //$set_time1="";
                                    //$instructn="";
                                    $op1="";
                                    $op2="";
                                    $op3="";
                                    $op4="";
                                    $ans1="";
                                    $explanations="";
                                    $qi_id="";
                                    $Submits1 = " Add Question &raquo; ";
                                    $captions1 = "Add Question &raquo;";
                                    $captions2 = "Upload Question &raquo;";
                                    $id1 = "";
                                    $id3 = "";
                                    echo "<input type='hidden' value='' name='quiz_ids'>";
                                }
                            ?>

                                <input type="hidden" id="txt_upload_type" name="txt_upload_type" value="type">
                                <input type="hidden" id="txtsess" name="txtsess" value="<?=$sessions?>">
                                <input type="hidden" id="txtquizid" name="txtquizid" value="<?=$id1;?>" />
                                
                                <div class="first_create_game" style="display:nones">
                                    <div class="write_quest_div">
                                        <p style="font-size: 15px; color: #093; margin-bottom: 20px; text-align: center;">
                                            <span class="upload_questions" style="font-weight: bold; cursor: pointer; font-size: 19px;">
                                                Upload Questions From Excel Instead
                                            </span>
                                        </p>
                                        <div class="form-group col-md-12 pr-5 pl-5">
                                            <label for="cc-payment" class="control-label mb-1">Type Question</label>
                                            
                                            <div id="editor" style="height: 130px;"><?=$questions;?></div>

                                            <textarea name="txtquestions" class="form-control" style="display: none;" id="txtquestions"><?=$questions;?></textarea>

                                            <p style="font-size:15px; margin-top:14px;"><b>Upload Picture (Optional)</b></p>
                                            <p style="font-size:14px !important; margin-top:-5px; color:#993">Picture size <b style="font-size:14px;">2MB</b> of jpg, jpeg and png only!</p>

                                            <?php
                                            if($url_id!=""){
                                                echo "<font class='update_imgs'>";
                                                if($files!=''){
                                                    //echo "<img src='".base_url()."img/no_picture.jpg' src1='".base_url()."img/no_picture.jpg' id='im10_'>";
                                                //}else{
                                                    echo "<img src='".base_url()."quizes/$files' src1='".base_url()."img/no_picture.jpg' id='im10'>";
                                                }
                                                echo "</font>";
                                            }
                                            ?>

                                                <input id="former_file" name="former_file" value="<?php echo $files; ?>" class="form-control" style="display:none;" />
                                                <input type="file" name="file_quiz" id="file_quiz" style="padding:4px; font-size:15px; display:nones" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 pr-5 pl-5 col-sm-6 pr-xs-5 pl-xs-5">
                                            <label for="cc-name" class="control-label mb-1">Option A</label>
                                            <input type="text" name="txtop1" id="txtop1" value="<?php echo $op1; ?>" placeholder="Write Option A" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 pr-5 pl-5 col-sm-6 pr-xs-5 pl-xs-5">
                                            <label for="cc-name" class="control-label mb-1">Option B</label>
                                            <input type="text" name="txtop2" id="txtop2" value="<?php echo $op2; ?>" placeholder="Write Option B" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 pr-5 pl-5 col-sm-6 pr-xs-5 pl-xs-5">
                                            <label for="cc-name" class="control-label mb-1">Option C</label>
                                            <input type="text" name="txtop3" id="txtop3" value="<?php echo $op3; ?>" placeholder="Write Option C" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 pr-5 pl-5 col-sm-6 pr-xs-5 pl-xs-5">
                                            <label for="cc-name" class="control-label mb-1">Option D</label>
                                            <input type="text" name="txtop4" id="txtop4" value="<?php echo $op4; ?>" placeholder="Write Option D" class="form-control" />
                                        </div>


                                        <div class="form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                            <label for="cc-number" class="control-label mb-1">Specify the answer</label><br>
                                            <select name="txtans" id="txtans">
                                                <option value="" selected>-Select-</option>
                                                <option value="A" <?php if($ans1==$op1 && $op1!="") echo "selected"; ?> >A</option>
                                                <option value="B" <?php if($ans1==$op2 && $op2!="") echo "selected"; ?>>B</option>
                                                <option value="C" <?php if($ans1==$op3 && $op3!="") echo "selected"; ?>>C</option>
                                                <option value="D" <?php if($ans1==$op4 && $op4!="") echo "selected"; ?>>D</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12 pr-5 pl-5 pr-xs-5 pl-xs-5">
                                            <label class="control-label" for="input-firstname">Explanation <span style="color:#888; font-size:14px; font-weight:normal">(Optional)</span></label><br>         
                                            <textarea placeholder="Type the answer explanation" name="txtexplain" class="form-control" style="height: 100px !important;" id="txtexplain"><?=$explanations;?></textarea>
                                        </div>

                                        <div style="clear:both"></div>
                                        <div class="alert alert-danger alert_msgs alert_msg1" style="margin-bottom: 0px;"></div>

                                        <div class="col-md-offset-3 col-md-6 pr-5 pl-5 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-sm-6">
                                            <div style="text-align:center; margin-top:1em;" id="buttons1">
                                                <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" id="cmd_submit_quiz" class="btn btn-lg btn-info btn-block">


                                                <input type="button" value="&laquo; Done" id="cmd_done_add_test" class="btn btn-lg btn-info btn-block inlines_1">
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                

                                    <div class="uploadQuests" style="display:none">
                                        <p style="font-size: 15px; color: #093; margin-bottom: 20px; text-align: center;">
                                            <span class="type_questions" style="font-size: 19px; font-weight: bold; cursor: pointer;">Type Questions Instead</span>
                                        </p>

                                        <div style="font-size: 15px; margin-bottom: 15px; line-height: 24px; overflow: hidden; color: red; overflow-x: scroll;">
                                            <b style="font-size: 17px; ">Important Notice</b>:<br>
                                            Excel format uploads must be in this format:<br>
                                            <img src="<?=base_url()?>images/excel_format.png">
                                        </div>
                                        
                                        <!-- <form action="<?php echo base_url();?>form/uploadData" method="post" enctype="multipart/form-data"> -->
                                            <p style="font-size: 15px;"><b>Upload excel file:</b></p>
                                            <input type="file" name="uploadFile" id="uploadFile" value="" style="font-size: 17px;" />
                                            <p style="font-size:14px !important; margin:8px 0 26px 0; color:#993">Picture size <b style="font-size:14px;">6MB</b> of xls, xlsx only!</p>

                                            <!-- <input type="submit" name="submit" value="Upload" /> -->
                                        <!-- </form> -->

                                        <div style="clear:both"></div>
                                        <div class="alert alert-danger alert_msgs alert_msg1" style="margin-bottom: 0px;"></div>

                                        <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                                            <div style="text-align:center; margin-top:1em;" id="buttons1">
                                                <input type="submit" value="<?=$captions2;?>" actid="<?=$id1;?>" id="cmd_submit_quiz" class="btn btn-lg btn-info btn-block">
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                </div>



                                <div class="third_create_form" style="display:none; text-align:center;">
                                    <p>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                          <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                          <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                        </svg>
                                    </p>
                                    <?php if($url_id!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>This Activity has been updated successfully</b></p>
                                        <p style="font-size:16px; color:#093;">It will be updated as well. If you have selected <b>Trivia Games</b> please input the 
                                            trivia games first before you approve this activity.
                                        </p>
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>A question has been added successfully</b></p>
                                        <p style="font-size:16px; color:#093;">It will be seen immediately on the platform, you can also disapprove it for students to be unable to access it
                                        </p>
                                    <?php } ?>

                                    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Done" id="cmd_goto_first" class="btn btn-lg btn-info btn-block">
                                        </div>
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





<?php if($page_name == "support_ticket"){ ?>
    <div class="content mt-3 container" id="page-wrapper" style="">
        <div class="col-lg-6" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center msg_titles">Your Inbox</h3>
                                <p class="msg_links">
                                    <span class="show_msg_type" labels="inbox">Inbox</span> 
                                    <span class="show_msg_type" labels="sent">Sent Messages</span>
                                </p>
                            </div>
                            <hr>
                            <input type="hidden" value="0" id="txtmem">
                            <input type="hidden" value="inbox" id="txtmsg_type">

                            <div class="card-body all_tables inbox_div">
                                <table id="" class="table table-striped table-bordered display responsive wrap all_tables1_ tickets" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date Sent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
             
                                    </tbody>
                                </table>
                            </div>


                            <div class="card-body all_tables sent_div" style="display: none;">
                                <table class="table table-striped table-bordered display responsive wrap all_tables1_ tickets_sent" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Date Sent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
             
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div> 
        </div>


        <div class="col-lg-offset-1i col-lg-5" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body enter_messages">
                            <div class="card-title">
                                <h3 class="text-center">Send A Message</h3>
                                <p>Choose a member by clicking on the <b>"Reply button above"</b> first before you send a message.</p>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'send_support'));
                            ?>
                                <input type="hidden" value="0" name="txtmem" id="txtmem" class="txtmem">
                                <input type="hidden" value="admin" name="txtusr" id="txtusr">

                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="cc-payment" class="control-label mb-1">To:</label>
                                    <label class="to_who" style="font-weight: normal; font-size: 15px; color: #069">Anonymous Receipient</label>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Subject</label>
                                    <input id="txtsubj" name="txtsubj" type="text" class="form-control" placeholder="Enter the subject">
                                </div>
                                <div class="form-group">
                                    <label for="cc-name" class="control-label mb-1">Message</label>
                                    <textarea id="txtmsg" class="common-textarea form-control" name="txtmsg" placeholder="Enter your message" style="height:15em !important;"></textarea>               
                                </div>
                                
                                <div>
                                    <div style="text-align:center; margin-top:2em;" id="buttons1">
                                        <input type="button" value="Send Message" id="cmd_send_support" class="btn btn-lg btn-info btn-block">
                                    </div>
                                </div>
                                <div class="alert alert-danger alert_msg1"></div>
                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                </div>
            </div> 
        </div>

        <div style="clear:both;"></div>
        <br><br><br><br><br>
    </div>
<?php } ?>




<?php if($page_name == "settings"){ ?>
    <div class="content mt-3 container" id="page-wrapper" style="">
        <div class="col-lg-5" style="border:1px #ccc solid;">
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
                                <div>
                                    <div style="text-align:center; margin-top:2em;" id="buttons1">
                                        <input type="button" value="Update Password" id="cmd_update_pass_admin" class="btn btn-lg btn-info btn-block">
                                    </div>
                                </div>
                                <div class="alert alert-danger alert_msg1"></div>
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
    
    

    <!-- <script src="<?=base_url();?>assets/js/jquery-1.12.4.js" type="text/javascript"></script> -->



    <script src="<?=base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?=base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <script src="<?=base_url();?>assets/plugins/pace/pace.js"></script>
    <!-- <script src="<?=base_url();?>assets/scripts/siminta.js"></script> -->
    
    <script src="<?=base_url();?>assets_texteditor/libs/jquery/dist/jquery.min.js"></script>
    <!-- <script src="<?=base_url();?>assets/js/plugins.js"></script> -->

    <script src="<?=base_url();?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/fnReloadAjax.js"></script>
    <script src="<?=base_url();?>assets/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/js/responsive.bootstrap.min.js" type="text/javascript"></script>

    
    <script src="<?=base_url();?>assets_texteditor/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="<?=base_url();?>assets_texteditor/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>




    <script src="<?=base_url();?>assets_texteditor/libs/quill/dist/quill.min.js"></script>
    <script>
        
        $(".select2").select2();
        $('.demo').each(function() {
        $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                position: $(this).attr('data-position') || 'bottom left',

                change: function(value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });

        });
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });

        var toolbarOptions = [
          ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
          //['blockquote', 'code-block'],

          //[{ 'header': 1 }, { 'header': 2 }],               // custom button values
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
          //[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
          //[{ 'direction': 'rtl' }],                         // text direction

          [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

          [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
          [{ 'font': [] }],
          [{ 'align': [] }],

          ['clean']                                         // remove formatting button
        ];

        var quill = new Quill('#editor', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    </script>


    <script>
        var site_urls = jq('#txtsite_url').val();
        var txt_pagename = jq('#txt_pagename').val();
        var txt_pagename1 = jq('#txt_pagename1').val();
        var txtqry = jq('#txtqry').val();
        var txturl1 = jq('#txturl1').val();

        if(txt_pagename == "centres"){
            if(txtqry=="")
                var urls = site_urls+"admin/fetch_centres";
            else
                var urls = site_urls+"admin/fetch_centres/"+txtqry+"/";

        }else if(txt_pagename == "view_advert")
            var urls = site_urls+"admin/fetch_adverts";

        else if(txt_pagename == "view_test")
            var urls = site_urls+"admin/fetch_tests";    

        else if(txt_pagename == "members")
            var urls = site_urls+"admin/fetch_members";

        else if(txt_pagename == "view_subscription")
            var urls = site_urls+"admin/fetch_mem_subs";

        else if(txt_pagename == "viewquiz")
            var urls = site_urls+"admin/fetch_quiz";

        else if(txt_pagename == "view_application")
            var urls = site_urls+"admin/fetch_applicatns";

        else if(txt_pagename == "viewblog")
            var urls = site_urls+"admin/fetch_all_blogs";

        else if(txt_pagename == "leader_board")
            var urls = site_urls+"admin/fetch_LB";

        else if(txt_pagename == "quiz_winners")
            var urls = site_urls+"admin/fetch_winners";

        else if(txt_pagename == "cart")
            var urls = site_urls+"admin/fetch_carts";

        else if(txt_pagename == "visitors")
            var urls = site_urls+"admin/fetch_visitors";

        else if(txt_pagename == "resources")
            var urls = site_urls+"admin/fetch_resources";

        else if(txt_pagename == "forum")
            var urls = site_urls+"admin/fetch_all_forum";

        else if(txt_pagename == "forum_rep")
            var urls = site_urls+"admin/fetch_all_forum_rep";

        else if(txt_pagename == "logos")
            var urls = site_urls+"admin/fetch_all_logos";

        else if(txt_pagename == "winners")
            var urls = site_urls+"admin/fetch_winners1/"+txtqry+"/";

        else if(txt_pagename == "subadmins")
            var urls = site_urls+"admin/fetch_subadmins";

        if(txt_pagename == "students_performance")
            var urls = site_urls+"admin/fetch_performance/";

        else if(txt_pagename == "viewquestions")
            var urls = site_urls+"admin/fetch_questions/"+txturl1+"/";


        var dataTable = $('#centres1, #members, #view_test, #all_quizes, #myquestions, #performance1, #carts, #resources, #view_leaderb2, #subadmin1, #forum1, #forum_rep1, #logos, #visitors, #view_winners').DataTable({
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



    <script>
      function initialize() {
        initAutocomplete();
      }

      var map, marker;
      var user_lat, user_lng;

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name'
      };


      function initAutocomplete() {
        boundss = new google.maps.LatLngBounds(new google.maps.LatLng(9.077751,8.6774567))
        var map = new google.maps.Map(document.getElementById('map'), {
          // center: {lat:9.077751, lng: 8.6774567},
          center: {lat:6.5480357,lng:3.1438737},
          zoom: 10,
          mapTypeId: 'roadmap',
          bounds: boundss
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        
        //map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and n.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);

          var txtaddrs1 = document.getElementById('pac-input').value;
          var store_name = txtaddrs1.split(',')[0];
          var ocity = txtaddrs1.split(',')[1];
          var ostate = txtaddrs1.split(',')[2];
          var ocountry = txtaddrs1.split(',')[3];
          $("#txtstates1").val(ostate);
          $("#txtcity").val(ocity);
          
          
        });
      }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHRSSN3VdktXCDOpohx6btlXAAkka6aos&libraries=places&callback=initialize"
          async defer></script>


</body>

</html>
