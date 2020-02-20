<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    <!-- <title><?=$page_title?> | TestPort.ng</title> -->
    <title class="page_titl">Compatibility Issues | TestPort.ng</title>
    <link href="<?=base_url()?>images/logo2.png" rel="shortcut icon" type="image/png">

    <meta name="keywords" content="jamb, waec, neco, masters, post-utme, unilag, lagos, chinny anthony, common entrance, mock, test, exams, computer, online exams, ican, n-power, pre degree, degree, aptitude, centres, learning, tutorials, location, past questions, questions, answers, questions and answers, videos, online test, online solution, cbt, practicals, education, professional, downloads, test forum, discussion, free, undergraduate, postgraduate, perfomance, free download, university of jos, unn, oau, unibadan, lasu, ABU, uniben, unijos, english, maths, mathematics, biology, chemistry, physics, agriculture, further mathematics, economics, accounting, computer science, download app, 2019, admission">

    <meta name="description" content="Testpost.ng is an online preparatory CBT platform for all major exams in Nigeria, prospective candidate for various exams can learn, practice and build confidence."/>
    
    <link rel="canonical" href="https://testport.com/" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Jamb, WAEC, NECO, Common Entrance, Masters, Locate Centres, Past Questions & Answers" />

    <meta property="og:description" content="Testpost.ng is an online preparatory CBT platform for all major exams in Nigeria, prospective candidate for various exams can learn, practice and build confidence." />

    <meta property="og:url" content="https://testport.com/" />
    <meta property="og:site_name" content="TestPort.ng" />
    <meta property="og:image" content="<?=base_url()?>images/logo.png" />
    <meta property="og:image:secure_url" content="<?=base_url()?>images/logo.png" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="400" />
    
    <meta name="twitter:description" content="Testpost.ng is an online preparatory CBT platform for all major exams in Nigeria, prospective candidate for various exams can learn, practice and build confidence." />

    <meta name="twitter:title" content="Jamb, WAEC, NECO, Common Entrance, Masters, Locate Centres, Past Questions & Answers" />

    <meta name="twitter:site" content="@testport" />
    <meta name="twitter:image" content="<?=base_url()?>images/logo.png" />
    <meta name="twitter:creator" content="@testport" />

    <?php
    if(isset($pquests) && $pquests!=""){
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
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="400" />
        <meta property="og:site_name" content="Testpost.ng"/>
        <meta property="og:description" content='<?=$descrip;?>' />
    <?php } ?>


        <link href="<?=base_url()?>images/logo2.png" rel="shortcut icon" type="image/png">
        <link href="<?=base_url()?>css/font-awesome.min.css" rel="stylesheet" type='text/css' media='all'>
        <link rel='stylesheet' href='<?=base_url()?>css/style-core.css' type='text/css' media='all' />

        <style>
            .broswer1{width:30%; margin:0 auto; backgrounds:blue;}
            .broswer1 img{width:110px !important;}
            .broswer1 p{display:inline-block; width:40%;}
            .header0{background:#036; text-align:center; padding:10px; margin-bottom:3em;}
            .header0 img{width:150px !important;}
            .other_contents{padding:5px 1em;}
            .broswer1 span{display:block;}


            @media(max-width: 767px) {
                .header0{padding:7px; margin-bottom:2em;}
                .broswer1{width:100%;}
                .broswer1 img{width:100px !important;}
                .header0 img{width:140px !important;}
            }

        </style>
    </head>

    <body class="hide-overlay">
        <div class="containerxx" id="gotohere">
            <div class="header0"><img src="<?=base_url()?>images/logo_white.png"></div>
            <p style="text-align:center; font-size:1.7em; color:#333; line-height:28px !important;"><b>Your browser is not supported.</b></p>

            <div class="other_contents">
                <p style="text-align:center; margin-top:-10px; color:#444; font-weight:normal; font-size:16px; line-height:23px;">
                    Unfortunately this browser does not support the web technology that powers the extended features of TestPort.ng<br>
                    You'll need to try another browser. We recommend Chrome Browser or Mozilla Firefox.
                </p>
                
                <div style="text-align:center; margin-top:1.4em;" class="broswer1">
                    <p><img src="<?=base_url()?>images/chromes.jpg"><span>Google Chrome</span></p>
                    <p><img src="<?=base_url()?>images/firefoxs.jpg"><span>Mozilla Firefox</span></p>
                </div>
            </div>
        </div>
        <br>
    </body>
</html>


