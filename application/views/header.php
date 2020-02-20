<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    <title><?=$page_title?> | TestPort.ng</title>
    <link href="<?=base_url()?>images/logo2.png" rel="shortcut icon" type="image/png">

    <meta name="keywords" content="jamb, waec, neco, masters, post-utme, unilag, lagos, chinny anthony, common entrance, mock, test, exams, computer, online exams, ican, n-power, pre degree, degree, aptitude, centres, learning, tutorials, location, past questions, questions, answers, questions and answers, videos, online test, online solution, cbt, practicals, education, professional, downloads, test forum, discussion, free, undergraduate, postgraduate, performance, free download,chinny,university of jos, unn, oau, unibadan, lasu, ABU, uniben, unijos, english, maths, mathematics, biology, chemistry, physics, agriculture, further mathematics, economics, accounting, computer science, download app, 2019, admission">

    <meta name="description" content="Testport.ng is an online preparatory CBT platform for all major exams in Nigeria, prospective candidate for various exams can learn, practice and build confidence."/>
    
    <link rel="canonical" href="http://testport.ng/" />
    <meta property="og:locale" content="en_US" />
    

    <?php
    if(isset($pquests)){
        $id = $pquests['id'];
        $ids = $id.substr(time(), -5);
        $titles = $pquests['titles'];
        $price = $pquests['price'];
        $titles_f = str_replace(array(" ", "’", "‘"), array("-", "", ""), strtolower($titles));
        $media_type = $pquests['media_type'];
        if($media_type=="doc") $sources2 = "past-questions"; else $sources2 = "tutorial-videos";
        
        $links = base_url()."resources/view/$sources2/$ids/";
        $files = $pquests['files'];
        $descrip = nl2br($pquests['descrip']);
    ?>
        <meta name="twitter:site" content="@testport" />
        <meta name="twitter:url" content="<?=$links;?>" />
        <meta name="twitter:title" content="Get <?=$titles;?> for NGN <?=@number_format($price)?>" />
        <meta property="og:title" content="Get <?=$titles;?> for NGN <?=@number_format($price)?>" />
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?=$links?>" />
        <meta property="og:image" content="<?=$files?>" />
        <meta property="og:description" content='<?=$descrip;?>' />

    <?php }else{ ?>

        <meta property="og:type" content="website" />
        <meta property="og:title" content="Jamb, WAEC, NECO, Common Entrance, Masters, Locate Centres, Past Questions & Answers" />

        <meta property="og:description" content="Testport.ng is an online preparatory CBT platform for all major exams in Nigeria, prospective candidate for various exams can learn, practice and build confidence." />

        <meta property="og:url" content="http://testport.ng/" />
        <meta property="og:image" content="<?=base_url()?>images/logo.png" />
        <meta property="og:image:secure_url" content="<?=base_url()?>images/logo.png" />
        
        <meta name="twitter:description" content="Testport.ng is an online preparatory CBT platform for all major exams in Nigeria, prospective candidate for various exams can learn, practice and build confidence." />
        <meta name="twitter:title" content="Jamb, WAEC, NECO, Common Entrance, Masters, Locate Centres, Past Questions & Answers" />
        <meta name="twitter:site" content="@testport" />
        <meta name="twitter:image" content="<?=base_url()?>images/logo.png" />
        <meta name="twitter:creator" content="@testport" />

    <?php } ?>

    <meta property="og:site_name" content="Testport.ng"/>
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="400" />


    <script data-cfasync="true" type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"WebSite","@id":"#website","url":"http:\/\/testport.ng\/","name":"TestPort | Jamb, WAEC, NECO, Common Entrance, Masters, Locate Centres, Past Questions & Answers","potentialAction":{"@type":"SearchAction","target":"http:\/\/testport.ng\/search\/result\/?search={search_term_string}","query-input":"required name=search_term_string"}}</script>

    <!-- <script data-cfasync="true" type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"Organization","url":"http://testport.ng","sameAs":["https:\/\/www.facebook.com\/Skynewsng-101296461412108","https:\/\/twitter.com\/Skynewsng_com"],"@id":"#organization","name":"TestPort","logo":"http://testport.ng/images/logofav.png"}</script> -->



    <link rel='stylesheet' href='<?=base_url()?>plugins/goodlayers-core/plugins/combine/style.css' type='text/css' media='all' />
    <link rel='stylesheet' href='<?=base_url()?>plugins/goodlayers-core/include/css/page-builder.css' type='text/css' media='all' />
    <link rel='stylesheet' href='<?=base_url()?>plugins/revslider/public/assets/css/settings.css' type='text/css' media='all' />
    <link rel='stylesheet' href='<?=base_url()?>css/style-core.css' type='text/css' media='all' />
    <link rel='stylesheet' href='<?=base_url()?>css/kingster-style-custom.css' type='text/css' media='all' />
    <link href="<?=base_url()?>css/font-awesome.min.css" rel="stylesheet" type='text/css' media='all'>

    <link href="<?=base_url()?>css/custom-bootstrap-margin-padding.css" rel="stylesheet" type='text/css' media='all'>
    <link href="<?=base_url()?>css/utility-classes.css" rel="stylesheet" type='text/css' media='all'>
    <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet" type='text/css' media='all'>

    <link href="https://fonts.googleapis.com/css?family=Karla&display=swap" rel="stylesheet">


    <?php if($page_name=="view"){ ?>
    <link href="<?=base_url()?>css/video-js.css" rel="stylesheet">
    <script src="<?=base_url()?>js/videojs-ie8.min.js"></script>
    <script src="<?=base_url()?>js/video.js"></script>
    <?php } ?>




</head>
<body class="home page-template-default page page-id-2039 gdlr-core-body woocommerce-no-js tribe-no-js kingster-body kingster-body-front kingster-full  kingster-with-sticky-navigation  kingster-blockquote-style-1 gdlr-core-link-to-lightbox" oncontextmenu="return false;">


<!--     <script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script>
contry_code = google.loader.ClientLocation.address.country_code;
city = google.loader.ClientLocation.address.city;
region = google.loader.ClientLocation.address.region;
alert(contry_code)
alert(city)
alert(region)
</script> -->

    <input type="hidden" value="<?=base_url();?>" id="txtsite_url">
    <input type="hidden" value="<?=$page_name;?>" id="txtpage_name">

    <div class="kingster-mobile-header-wrap myheaders myheaders_mobile for_mobile">
        <div class="kingster-mobile-header kingster-header-background kingster-style-slide kingster-sticky-mobile-navigation " id="kingster-mobile-header">

            <div class="kingster-mobile-header-container kingster-container_ clearfix">

                <div class="kingster-logo kingster-item-pdlr">
                    <div class="kingster-logo-inner">
                        <a class="" href="<?=base_url()?>"><img src="<?=base_url()?>images/logo_white.png" alt="" /></a>
                    </div>
                </div>

                <div class="kingster-mobile-menu-right">
                    <div class="kingster-main-menu-search" id="kingster-mobile-top-search"><i class="fa fa-search"></i></div>

                    <div class="kingster-top-search-wrap">
                        <div class="kingster-top-search-close"></div>
                        <div class="kingster-top-search-row">
                            <div class="kingster-top-search-cell">
                                <form role="search" method="get" class="search-form" action="#">
                                    <input type="text" class="search-field kingster-title-font" placeholder="Search..." value="" name="s">
                                    <div class="kingster-top-search-submit"><i class="fa fa-search"></i></div>
                                    <input type="submit" class="search-submit" value="Search">
                                    <div class="kingster-top-search-close"><i class="fa fa-close"></i></div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="kingster-mobile-menu">
                        <a class="kingster-mm-menu-button kingster-mobile-menu-button kingster-mobile-button-hamburger" href="#kingster-mobile-menu"><span></span></a>

                        <div class="kingster-mm-menu-wrap kingster-navigation-font" id="kingster-mobile-menu" data-slide="right">

                            <ul id="menu-main-navigation" class="m-menu mm_menu current-menu-item_">

                                <?php if($this->auths){ ?>
                                <li class="menu-item auth_link php_login" style="display: nones;"><a href="#"><i class="fa fa-user"></i> <font1 style="font-size: 16.5px !important;"><?=$this->getname?></font1></a>
                                    <ul class="sub-menu sub_menu">
                                        <li class="menu-item"><a href="<?=base_url()?>dashboard/"><i class="fa fa-dashboard" id="i_fd84_1"></i>Dashboard</a></li>
                                        <li class="menu-item"><a href="<?=base_url()?>dashboard/performance/"><i class="fa fa-dashboard" id="i_fd84_1"></i>My Performance</a></li>
                                        <li class="menu-item"><a href="<?=base_url()?>logout/"><i class="fa fa-power-off" id="i_fd84_1"></i>Logout</a></li>
                                    </ul>
                                </li>
                                <?php }else{ ?>
                                <li class="menu-item auth_link sft_right php_login"><a href="javascript:;" class="login_btn_i"><i class="fa fa-lock"></i> Login</a></li>
                                <?php } ?>

                                <li class="menu-item auth_link java_login" style="display: none;"><a href="#"></a>
                                    <ul class="sub-menu sub_menu">
                                        <li class="menu-item"><a href="<?=base_url()?>dashboard/"><i class="fa fa-dashboard" id="i_fd84_1"></i>Dashboard</a></li>
                                        <li class="menu-item"><a href="<?=base_url()?>logout/"><i class="fa fa-power-off" id="i_fd84_1"></i>Logout</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item menu-item-home <?php if($page_name=="") echo "current-menu-item1";?> menu-item-has-children_"><a href="<?=base_url()?>"><i class="fa fa-home"></i> Home</a></li>

                                <li class="menu-item menu-item-has-children <?php if($page_name=="tests") echo "current-menu-item1";?>"><a href="#"><i class="fa fa-edit"></i> <font>Take A Test</font></a>
                                    <ul class="sub-menu sub_menu">
                                        <?php
                                            if($test_boards){
                                                foreach($test_boards as $row){
                                                    $id = $row['id'];
                                                    $test_types = $row['test_types'];
                                                    $test_types_f = strtolower(str_replace(" ", "-", $test_types));
                                                    echo '<li class="menu-item"><a href="'.base_url().'tests/'.$test_types_f.'/">'.$test_types.'</a></li>';
                                                }
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <li class="menu-item <?php if($page_name=="resources") echo "current-menu-item1";?>"><a href="#"><i class="fa fa-download"></i> <font>Resources</font></a>
                                    <ul class="sub-menu sub_menu">
                                        <li class="menu-item"><a href="<?=base_url()?>resources/past-questions/#!">Past Questions</a></li>
                                        <!-- <li class="menu-item"><a href="javascript:;">Practice</a></li>
                                        <li class="menu-item"><a href="javascript:;">Tutorials</a></li> -->
                                        <li class="menu-item"><a href="<?=base_url()?>resources/tutorial-videos/#!">Tutorial Videos</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item <?php if($page_name=="centres") echo "current-menu-item1";?>"><a href="<?=base_url()?>centres/"><i class="fa fa-map-marker"></i> Locate Centres</a></li>

                                <li class="menu-item <?php if($page_name=="forum") echo "current-menu-item1";?>"><a href="<?=base_url()?>forum/"><i class="fa fa-edit"></i> Forum</a></li>

                                <li class="menu-item <?php if($page_name=="about") echo "current-menu-item1";?>"><a href="<?=base_url()?>about/"><i class="fa fa-history"></i> About</a></li>

                                <li class="menu-item <?php if($page_name=="contact") echo "current-menu-item1";?>"><a href="<?=base_url()?>contact/"><i class="fa fa-phone"></i> Contact</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="kingster-body-outer-wrapper">
        <div class="kingster-body-wrapper clearfix  kingster-with-frame">

            <div class="kingster-top-bar myheaders">
                <div class="kingster-top-bar-background"></div>
                <div class="kingster-top-bar-container kingster-container ">
                    <div class="kingster-top-bar-container-inner clearfix">
                        
                        <!-- <div class="kingster-top-bar-left kingster-item-pdlr"><i class="fa fa-envelope-open-o" id="i_fd84_0"></i> contact@KUTheme.edu <i class="fa fa-phone" id="i_fd84_1"></i> +1-3435-2356-222</div> -->

                        <div class="kingster-top-bar-right kingster-item-pdlr">
                            <ul id="kingster-top-bar-menu" class="sf-menu kingster-top-bar-menu kingster-top-bar-right-menu">
                                <i class="fa fa-phone" id="i_fd84_1"></i> <a href="tel:+2348117896926">0811 789 6926</a>
                                <font class="java_logout1" style="display: none;"><i class="fa fa-power-off" id="i_fd84_1"></i><a href="<?=base_url()?>logout/">Logout</a></font>

                                <?php
                                if($this->auths){
                                    echo "<font class='java_logout1'><i class='fa fa-power-off' id='i_fd84_1'></i><a href='".base_url()."logout/'>Logout</a></font>";
                                }
                                ?>

                                <?php if($this->auths){ ?>
                                    <font class="java_logout1"><i class="fa fa-dashboard" id="i_fd84_1"></i><a href="<?=base_url()?>dashboard/performance/" style="font-weight: normal">My Performance</a></font>
                                <?php }else{ ?>
                                    <font class="login_btn_j"><i class="fa fa-dashboard" id="i_fd84_1"></i><a href="javascript:;" style="font-weight: normal">My Performance</a></font>
                                <?php } ?>

                                <font class="java_login2" style="display: none;"><i class="fa fa-dashboard" id="i_fd84_1"></i><a href="<?=base_url()?>dashboard/performance/" style="font-weight: normal">My Performance</a></font>

                            </ul>
                            <div class="kingster-top-bar-right-social"></div>

                            <?php if($this->auths){ ?>
                            <a class="kingster-top-bar-right-button php_login1" href="<?=base_url()?>dashboard/"><i class="fa fa-user"></i> <?=$this->getname?></a>
                            <?php }else{ ?>
                            <a class="kingster-top-bar-right-button login_btn php_login1" href="javascript:;"><i class="fa fa-lock"></i> Login</a>
                            <?php } ?>

                            <a class="kingster-top-bar-right-button java_login1" href="<?=base_url()?>dashboard/" style="display: none;"></a>
                        </div>
                    </div>
                </div>
            </div>

<div class="scrltotop"></div>
            <header class="kingster-header-wrap kingster-header-style-plain kingster-style-menu-right kingster-sticky-navigation kingster-style-fixed myheaders" data-navigation-offset="75px">

                <div class="kingster-header-background"></div>
                <div class="kingster-header-container kingster-container">

                    <div class="kingster-header-container-inner clearfix">
                        <div class="kingster-logo kingster-item-pdlr">
                            <div class="kingster-logo-inner">
                                <a class="" href="<?=base_url()?>"><img src="<?=base_url()?>images/logo.png" alt="" /></a>
                            </div>
                        </div>

                        <div class="kingster-navigation kingster-item-pdlr clearfix ">
                            <div class="kingster-main-menu" id="kingster-main-menu">
                                <ul id="menu-main-navigation-1" class="sf-menu">
                                    <!-- <li class="menu-item menu-item-home <?php if($page_name=="") echo "current-menu-item";?> menu-item-has-children kingster-normal-menu"><a href="<?=base_url()?>" class="sf-with-ul-pre">Home</a></li> -->
                                    
                                    <li class="menu-item <?php if($page_name=="tests") echo "current-menu-item";?> menu-item-has-children kingster-normal-menu"><a href="javascript:;" class="sf-with-ul-pre">Take A Test <i class="fa fa-chevron-down"></i></a>
                                        <ul class="sub-menu">
                                            <?php
                                            if($test_boards){
                                                foreach($test_boards as $row){
                                                    $id = $row['id'];
                                                    $test_types = $row['test_types'];
                                                    $test_types_f = strtolower(str_replace(" ", "-", $test_types));
                                                    echo '<li class="menu-item" data-size="60"><a href="'.base_url().'tests/'.$test_types_f.'/">'.$test_types.'</a></li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>


                                    <li class="menu-item <?php if($page_name=="resources") echo "current-menu-item";?> menu-item-has-children kingster-normal-menu"><a href="javascript:;" class="sf-with-ul-pre">Resources <i class="fa fa-chevron-down"></i></a>
                                        <ul class="sub-menu">
                                            <li class="menu-item" data-size="60"><a href="<?=base_url()?>resources/past-questions/#!">Past Questions</a></li>
                                            <!-- <li class="menu-item" data-size="60"><a href="javascript:;">Practice</a></li>
                                            <li class="menu-item" data-size="60"><a href="javascript:;">Tutorials</a></li> -->
                                            <li class="menu-item" data-size="60"><a href="<?=base_url()?>resources/tutorial-videos/#!">Tutorial Videos</a></li>
                                        </ul>
                                    </li>

                                    <li class="menu-item <?php if($page_name=="centres") echo "current-menu-item";?> kingster-normal-menu"><a href="<?=base_url()?>centres/">Locate Centres</a></li>

                                    <li class="menu-item <?php if($page_name=="forum") echo "current-menu-item";?> kingster-normal-menu"><a href="<?=base_url()?>forum/">Forum</a></li>

                                    <li class="menu-item <?php if($page_name=="about") echo "current-menu-item";?> kingster-normal-menu"><a href="<?=base_url()?>about/">About</a></li>
                                    <li class="menu-item <?php if($page_name=="contact") echo "current-menu-item";?> kingster-normal-menu"><a href="<?=base_url()?>contact/">Contact</a></li>
                                </ul>
                                <div class="kingster-navigation-slide-bar" id="kingster-navigation-slide-bar"></div>
                            </div>
                            <div class="kingster-main-menu-right-wrap clearfix ">
                                <div class="kingster-main-menu-search" id="kingster-top-search"><i class="fa fa-search"></i></div>
                                <div class="kingster-top-search-wrap">
                                    <div class="kingster-top-search-close"></div>
                                    <div class="kingster-top-search-row">
                                        <div class="kingster-top-search-cell">
                                            <form role="search" method="get" class="search-form" action="#">
                                                <input type="text" class="search-field kingster-title-font" placeholder="Search..." value="" name="s">
                                                <div class="kingster-top-search-submit"><i class="fa fa-search"></i></div>
                                                <input type="submit" class="search-submit" value="Search">
                                                <div class="kingster-top-search-close"><i class="fa fa-close"></i></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </header>