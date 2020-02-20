<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="<?=base_url()?>images/logo2.png" rel="shortcut icon" type="image/png">
    <title><?=$page_title;?> | TestPort</title>
    <!-- Core CSS - Include with every page -->

    
    <link href="<?=base_url();?>assets/css2/dataTables.bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>css/bootstrap-3.min.css" rel="stylesheet"> <!--This is the main thing that causes the table to have good looking-->
    <link href='<?=base_url();?>assets/css2/responsive.bootstrap.min.css' rel='stylesheet' type='text/css'>
    
    <link href="<?=base_url();?>assets/css2/pe-icon-7-stroke.css" rel="stylesheet" />

    <link href="<?=base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=base_url();?>assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet" />
    <link href="<?=base_url();?>assets/css/main-style.css" rel="stylesheet" />

    <link href="<?=base_url();?>css/style.css" rel="stylesheet">
    <link href="<?=base_url();?>css/elegant_font/elegant_font.min.css" rel="stylesheet">

    <!-- <script src="<?=base_url();?>js/jscripts.js"></script> -->

    <!-- this library below is causing the menu not to show, will change the position -->
    <!-- <script src="<?=base_url();?>js/jquery-2.2.4.min.js" type="text/javascript"></script> -->
    <!-- this library above is causing the menu not to show -->


    <link href="<?=base_url();?>css/dropzone.css" rel="stylesheet">
    <link id="onyx-css" href="<?=base_url();?>css/style_dropzone.css" rel="stylesheet">

    <link id="onyx-css" href="<?=base_url();?>css/custom-bootstrap-margin-padding.css" rel="stylesheet">
    <link id="onyx-css" href="<?=base_url();?>css/utility-classes.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets_texteditor/libs/quill/dist/quill.snow.css">

    <!-- <script src="<?=base_url();?>js/jquery-1.12.4.js" type="text/javascript"></script> -->
    <!-- <script src="<?=base_url();?>js/jscripts.js"></script> -->

    <!-- For multiple selection of selectbox -->
    <link href="<?=base_url();?>css/jquery.multiselect.css" rel="stylesheet" />


    <script src="<?=base_url();?>js/jquery-1.12.4.js" type="text/javascript"></script>
    <script src="<?=base_url();?>js/jquery.multiselect.js"></script>
    <!-- For multiple selection of selectbox -->

    <script src="<?=base_url();?>js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>js/jscripts.js"></script>
    <script>
        var k = $.noConflict();
        //alert($j.fn.jquery);
    </script>

    
    <link href="https://fonts.googleapis.com/css?family=Karla&display=swap" rel="stylesheet">


   </head>

<?php $url_seg = $this->uri->segment(3); ?>
<body style="background:#fff;">
<input type="hidden" value="<?=base_url();?>" id="txtsite_url">
<input type="hidden" value="<?php echo $page_name; ?>" id="txt_pagename">
<input type="hidden" value="<?php echo $page_title; ?>" id="txt_pagename1">
<input type="hidden" value="<?php echo $url_seg;?>" id="txtqry">
    <!--  wrapper -->
    <div id="wrapper">

    
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle navbar_toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=base_url();?>">
                    <img src="<?=base_url();?>images/logo_white.png" style="width: 160px !important" alt="" />
                </a>


                <ul class="nav_ navbar-top-links_ navbar-right_ user_acct">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-2x"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?=base_url();?>admin/settings/">Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=base_url();?>admin/logout/">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div>

        </nav>



        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php $pics1 = base_url()."images/no_passport.jpg"; ?>
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-section-inner">
                                <img src="<?=$pics1;?>" alt="">
                            </div>
                            <div class="user-info">
                                <?php
                                echo "<div>&nbsp;Admin</div>";
                                ?>
                                <div class="user-text-online">
                                    <span class="user-circle-online "></span>&nbsp;
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    
                    <li <?php if($page_name=="") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>

                    <li <?php if($page_name=="members") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/members/"><i class="fa fa-users fa-fw"></i> View Members</a></li>

                    <li <?php if($page_name=="centres") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/centres/"><i class="fa fa-edit fa-fw"></i> Centres</a></li>

                    <li <?php if($page_name=="set_test") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/set_test/"><i class="fa fa-edit fa-fw"></i> Add Test</a></li>

                    <li <?php if($page_name=="view_test") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/view_test/"><i class="fa fa-eye fa-fw"></i> View Test</a></li>

                    <li <?php if($page_name=="cart") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/cart/"><i class="fa fa-shopping-cart fa-fw"></i> View Cart</a></li>

                    <li <?php if($page_name=="resources") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/resources/"><i class="fa fa-edit fa-fw"></i> Resources</a></li>

                    <li <?php if($page_name=="add_logo") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/add_logo/"><i class="fa fa-edit fa-fw"></i> Add Company Logo</a></li>

                    <li <?php if($page_name=="forum") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/forum/"><i class="fa fa-eye fa-fw"></i> Forum</a></li>

                    <li <?php if($page_name=="forum_rep") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/forum_rep/"><i class="fa fa-eye fa-fw"></i> Forum Replies</a></li>

                    <li <?php if($page_name=="students_performance") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/students_performance/"><i class="fa fa-user fa-fw"></i> Students Performance</a></li>

                    <li <?php if($page_name=="visitors") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/visitors/"><i class="fa fa-eye fa-fw"></i> Visitors</a></li>

                    <li <?php if($page_name=="settings") echo 'class="active"'; ?>><a href="<?=base_url();?>admin/settings/"><i class="fa fa-gears fa-fw"></i> Settings</a></li>

                    <li><a href="<?=base_url();?>admin/logout/"><i class="fa fa-power-off fa-fw"></i> Logout</a></li>
                    
                </ul>
            </div>
        </nav>
        <div style="clear:both;"></div>

    