

<div class="kingster-page-wrapper" id="kingster-page-wrapper">
    <div class="gdlr-core-page-builder-body" style="background-color: #ddd;">
        

<?php
$full_form = "";
$test_logo1 = "";

if($test_logo == "jamb-test"){
    $full_form = "Joint Admissions And Matriculation Board";
    $test_logo1 = "jamb.png";
}
else if($test_logo == "waec-test"){
    $full_form = "West African Examination Council";
    $test_logo1 = "waec.png";
}
else if($test_logo == "neco-test"){
    $full_form = "National Examination Council";
    $test_logo1 = "neco.png";
}
else if($test_logo == "unilag-diploma"){
    $full_form = "University of Lagos";
    $test_logo1 = "unilag.png";
}
else if($test_logo == "mock-test"){
    $full_form = "Multiple Option Checking Test";
    $test_logo1 = "";
}
else if($test_logo == "post-utme-test"){
    $full_form = "Post Unified Tertiary Matriculation Examination";
    $test_logo1 = "post_utme.png";
}


if($full_form!="")
    $full_form1 = "<p class='full_form full_form1'>($full_form)</p>";
else
    $full_form1 = "";

if($test_logo1!="")
    if($test_logo1=="post_utme.png")
        $test_logo2 = "<p class='img_test_logo img_test_logo1'><img src='".base_url()."images/test_logos/$test_logo1' src1='".base_url()."images/test_logos/$test_logo1'></p>";
    else
        $test_logo2 = "<p class='img_test_logo img_test_logo1'><img src='".base_url()."images/test_logos/$test_logo1' src1='".base_url()."images/test_logos/$test_logo1'></p>";
else
    $test_logo2 = "";

$memids = $this->memid;
?>

<input type="hidden" class="selected_subjs" />
<input type="hidden" class="selected_subjs_ids" />
<input type="hidden" class="started_text_value" value="0" />

<button type="button" style="display: none;" class="cmd_trigger"></button>



<div class="div_contents_ choose_subjects" style="display: nones;"> <!-- Choose Subjects -->
    <?php
    if($test_logo == "mock-test"){
        $headers_bg = "<div class='div_contents1 div_contents3'>
                $test_logo2
                <h3 class='main_titles main_titles1'>$page_title</h3>
                $full_form1
                <p class='subjs subjs1'>SELECT SUBJECTS</p>
            </div>";
        
    ?>

        <input type="hidden" id="txtcollege1" value="" />
        <?=$headers_bg?>
        <div class="login_info" style="display: none;">Cannot proceed from here, please login to continue.</div>
        <div class="container pt-40 pb-30 test_div mt-0 mb-50" style="text-align: center;">
            <div class="row pr-sm-10 pl-sm-10">

                <?php
                $fetchExamBoards = $this->sql_models->fetchExamBoards(5);
                $memids = $this->memid;

                $results = "";
                if($fetchExamBoards){
                    $results .= "<p class='font-17 mb-60' style='line-height:20px; color:#333; font-weight:600; text-align:center'>Select more than one subject and click on the start button</p>";
                    $results .= '<ul class="ks-cboxtags">';
                    foreach($fetchExamBoards as $row){
                        $id = $row['id'];
                        $subjs = $row['subjs'];

                        $results .= "<li><input type='checkbox' id1='$id' id='checkbox$id' value='$subjs'><label for='checkbox$id'>$subjs</label></li>";
                    }
                    $results .= '</ul>';
                    $results .= "<p class='selecteds pr-70 pl-70 pr-sm-0 pl-sm-0 pb-10'></p>";
                    $results .= "<div clear='clearfix'></div>";
                    
                    if($this->auths){
                        $results .= '<div class="start_test_btn_1 start_tests_proceed php_login mt-30 mb-10" style="margin-bottom:-20px;" subjects="" test_board2="'.$test_logo.'" isSubjects="1" memid="'.$memids.'">PROCEED <i class="fa fa-arrow-right"></i></div>';
                    }else{
                        $results .= '<div class="start_test_btn_1 no_start_tests php_login mt-30 mb-10" style="margin-bottom:-20px;" isSubjects="1">PROCEED <i class="fa fa-arrow-right"></i></div>';
                    }

                    $results .= '<div class="start_test_btn_1 start_tests_proceed java_login_show mt-50 mb-10" style="margin-bottom:-20px; display:none" subjects="" test_board2="'.$test_logo.'" isSubjects="1" memid="'.$memids.'">PROCEED <i class="fa fa-arrow-right"></i></div>';

                }else{
                    $results .= '<div class="col-md-12 mt-10 mb-190 mb-sm-70" style="text-align: center; color:#555; font-weight:600; line-height:24px;">
                     No subjects on this yet, try again next time
                     </div>';
                }

                echo $results;
                ?>

                



            </div>
        </div>
        



    <?php
    }else if($test_logo == "post-utme-test" || $test_logo == "masters"){

        
        $test_board1 = $test_subj[0]['test_board'];

        $headers_bg = "<div class='div_contents1 div_contents3'>
                $test_logo2
                <h3 class='main_titles main_titles1'>$page_title</h3>
                $full_form1
                <p class='subjs subjs1'>SELECT SUBJECTS</p>
            </div>";
    ?>
        <?=$headers_bg?>
        <div class="login_info" style="display: none;">Cannot proceed from here, please login to continue.</div>

        <div class="container pt-40 pb-30 mt-sm-20 test_div" style="text-align: center;">
            <div class="row pr-sm-10 pl-sm-10">
                <div class="gdlr-core-course-form form_acct col-md-12 mt--sm-20 mb-20 p-sm-0">

                    <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12 p-sm-0">
                        <div class="gdlr-core-course-form-combobox txtcollege gdlr-core-skin-e-background">
                            <select class="gdlr-core-skin-e-content" name="txtcollege1" id="txtcollege1" test_logo="<?=$test_logo?>" test_board1="<?=$test_board1?>">
                                <option value="aaaaa" selected="">Select Your Institution</option>
                                <?php
                                if($test_sch){
                                    foreach($test_sch as $row){
                                        //$id = $row['id1'];
                                        $name_of_sch = ucwords($row['name_of_sch']);
                                        echo "<option value='$name_of_sch'>$name_of_sch</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-md-offset-0 col-md-2 col-sm-offset-0 col-sm-3 col-xs-offset-3 col-xs-6 pl-0 mt-sm-0 mb-sm-30 pl-sm-10 mt-xs-20 mb-xs-30">
                        <div class="sel_college search_college" test_logo="<?=$test_logo?>"><i class="fa fa-search"></i> Search</div>
                    </div> -->

                    <div style="clear: both;"></div>
                </div>
                <div style="clear: both;"></div>

                <div class="loaders" style="display:none;"><img src="<?=base_url();?>images/loaderq.gif"></div>

                <div class="mt-0 mb-120 mt--sm-30_ mb-sm-170 mb-xs-110 sch_contents" style="text-align: center; clear: both;">
                    <span style="color: #444 !important; display: block; font-weight: bold; margin_: 10px 0 110px 0; line-height: 22px;">Select your university above and click search</span>
                </div>
            </div>
        </div>




    <?php
    }else{
        $headers_bg1 = "<div class='div_contents1 div_contents2 div_contents3'>
                $test_logo2

                <h3 class='main_titles main_titles1'>$page_title</h3>
                $full_form1
                <p class='subjs subjs1'>SUBJECTS</p>
            </div>";
    ?>

        <?=$headers_bg1?>
        <div class="login_info" style="display: none;">Cannot proceed from here, please login to continue.</div>
        <div class="container pt-40 pb-60 test_div" style="text-align: center;">
            <div class="row pr-sm-10 pl-sm-10">

                <?php
                if($test_subj){
                    foreach($test_subj as $row){
                        $id = $row['id1'];
                        $qi_id = $row['qi_id'];
                        $subjs = $row['subjs'];
                        $test_board = $row['test_board'];
                        $set_time = $row['set_time'];
                        $subject_id = $row['subject_id'];
                        $noOfQuest = $this->sql_models->countRecs('quizes2', '', $subject_id, $test_board, '', '');
                        //$noOfMems = $this->sql_models->countMems('stud_ans', $subject_id, $id);
                        $noOfMems = $this->sql_models->countMems('stud_ans', $qi_id);

                        if($noOfQuest <= 0)
                            $noOfQuest1 = "<label style='font-size: 15px; color:#666; font-weight:normal;'>None yet</label>";
                        else
                            $noOfQuest1 = $noOfQuest;

                        //echo $qi_id."<br>";
                    ?>

                        <div class="col-lg-3 col-md-4 col-sm-4 mb-40 mb-sm-20 p-xs-5">
                            <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js each_div" data-gdlr-animation="fadeInUp" data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.8">
                                <p class="topics"><?=$subjs?></p>
                                <div class="row divContent">
                                    <div class="col-md-6 col-sm-7 col-xs-6">
                                        <i class="fa fa-edit"></i> Questions
                                    </div>
                                    <div class="col-md-6 col-sm-5 col-xs-6">
                                        <?=$noOfQuest1?>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-6 col-sm-7 col-xs-6">
                                        <i class="fa fa-clock-o"></i> Duration
                                    </div>
                                    <div class="col-md-6 col-sm-5 col-xs-6">
                                        <?=$set_time?>mins
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-6 col-sm-7 col-xs-6">
                                        <i class="fa fa-users"></i> Members
                                    </div>
                                    <div class="col-md-6 col-sm-5 col-xs-6">
                                        <?=$noOfMems?>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-12 mt-15 btn_tst">

                                        <?php if($this->auths){ ?>
                                            <?php if($noOfQuest > 0){ ?>
                                                <div class="start_test_btn start_tests php_login" subjects="<?=$subjs?>" isSubjects="0" subject_id="<?=$subject_id?>" test_types="<?=$test_board?>" memid="<?=$memids?>" id1="<?=$id?>">START TEST <i class="fa fa-arrow-right"></i></div>
                                            <?php }else{ ?>
                                                <div class="start_test_btn empty_tests php_login" subjects="<?=$subjs?>" isSubjects="0" style="opacity: 0.7;" id1="<?=$id?>">START TEST <i class="fa fa-arrow-right"></i></div>
                                            <?php } ?>
                                        <?php }else{ ?>

                                        <?php if($noOfQuest > 0){ ?>
                                            <div class="start_test_btn no_start_tests php_login" isSubjects="0">START TEST <i class="fa fa-arrow-right"></i></div>
                                        <?php }else{ ?>
                                            <div class="start_test_btn empty_tests php_login" style="opacity: 0.7;" isSubjects="0">START TEST <i class="fa fa-arrow-right"></i></div>
                                        <?php } ?>

                                        <?php } ?>

                                        <?php if($noOfQuest > 0){ ?>
                                            <div class="start_test_btn start_tests java_login_show" subjects="<?=$subjs?>" isSubjects="0" subject_id="<?=$subject_id?>" id1="<?=$id?>" test_types="<?=$test_board?>" memid="<?=$memids?>" style="display: none;">START TEST <i class="fa fa-arrow-right"></i></div>
                                        <?php }else{ ?>
                                            <div class="start_test_btn empty_tests java_login_show" subjects="<?=$subjs?>" isSubjects="0" id1="<?=$id?>" style="display: none;">START TEST <i class="fa fa-arrow-right"></i></div>
                                        <?php } ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    <?php
                
                    }
                    
                }else{

                    echo '<div class="col-md-12 mt-10 mb-190 mb-sm-70" style="text-align: center; color:#555; font-weight:600; line-height:24px;">
                    No subjects on '.$page_title.' yet, try again next time
                    </div>';

                }
                ?>
            </div>
        </div>

    <?php
    }
    ?>

</div> <!-- Choose Subjects -->


<div class="subject_instruc mb-60 mb-sm-40" style="display: none;"> <!-- Choose Subjects -->
    <p style="text-align: center; margin: 20px 0">Please wait...Loading...<br><img src="<?=base_url()?>images/loader.gif"></p>
</div> <!-- Choose Subjects -->



<div class="main_test_page mb-0 mb-sm-0 sm-height-custom" style="display: none; background: #192f59;">
    <p style="text-align: center; margin: 0px 0; color: #ddd; padding: 1em;">Please wait...Loading...</p>

</div>


