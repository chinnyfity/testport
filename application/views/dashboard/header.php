<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?=base_url()?>images/logo2.png" rel="shortcut icon" type="image/png">
    <title><?=$page_title;?> | TestPort</title>


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


   </head>

<?php $url_seg = $this->uri->segment(3); ?>
<body style="background:#fff;">
<input type="hidden" value="<?=base_url();?>" id="txtsite_url">
<input type="hidden" value="<?php echo $page_name; ?>" id="txt_pagename">
<input type="hidden" value="<?php echo $page_title; ?>" id="txt_pagename1">
<input type="hidden" value="<?php echo $url_seg; ?>" id="txtqry">
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
                    <img src="<?=base_url();?>images/logo_white.png" alt="" />
                </a>


                <ul class="nav_ navbar-top-links_ navbar-right_ user_acct">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-2x"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?=base_url();?>logout/">Logout</a></li>
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
                        <div class="user-section">
                            <div class="user-section-inner">
                                <img src="<?=$pics1;?>" alt="">
                            </div>
                            <div class="user-info">
                                <div>&nbsp;<?=ucwords($this->getname);?></div>
                                <div class="user-text-online">
                                    <span class="user-circle-online "></span>&nbsp;
                                </div>
                            </div>
                        </div>
                    </li>

                    <li <?php if($page_name=="") echo 'class="active"'; ?>><a href="<?=base_url();?>dashboard/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>

                    <li <?php if($page_name=="profile") echo 'class="active"'; ?>><a href="<?=base_url();?>dashboard/profile/"><i class="fa fa-user fa-fw"></i> Profile</a></li>

                    <li <?php if($page_name=="performance") echo 'class="active"'; ?>><a href="<?=base_url();?>dashboard/performance/"><i class="fa fa-dashboard fa-fw"></i> My Performance</a></li>

                    <li <?php if($page_name=="cart") echo 'class="active"'; ?>><a href="<?=base_url();?>dashboard/cart/"><i class="fa fa-shopping-cart fa-fw"></i> My Cart</a></li>

                    <li><a href="<?=base_url();?>logout/"><i class="fa fa-power-off fa-fw"></i> Logout</a></li>
                </ul>
            </div>
        </nav>
        <div style="clear:both;"></div>

    