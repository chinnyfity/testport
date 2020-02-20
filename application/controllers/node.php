<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Node extends CI_Controller {

    public $xauth;
    public $show_name;

    public function __construct(){
        parent::__construct();

        $this->load->helper(array('form', 'url', 'html', 'directory', 'cookie'));
        //$this->load->library(array('form_validation', 'security', 'pagination', 'session', 'encrypt', 'Compress', 'nativesession'));
        $this->load->library(array('form_validation', 'security', 'pagination', 'session', 'Compress', 'nativesession'));
        
        $this->perPage = 20;
        $this->form_validation->set_message('valid_email', 'Invalid email entered');
        $this->form_validation->set_message('alpha_space', 'Invalid name entered');
        $this->form_validation->set_message('is_unique', 'This %s already exists');
        //$this->form_validation->set_message('max_length', 'The field "%s" is too long, cant\'t proceed!');
        $this->form_validation->set_message('regex_match[/^[0-9]{6,11}$/]', 'Phone must contain numbers and a maximum of 11 digits!');
        $this->load->model('sql_models');
        @date_default_timezone_set('Africa/Lagos');

        $this->mailHeader = "<!DOCTYPE html><head><title></title></head><body>";
        $this->mailFooter = "</body></html>";
        
        $this->test_boards = $this->sql_models->testBoards();
        if($this->validateMemberAuth()) $this->auths = true; else $this->auths = false;
        

        if($this->getMemName()){
            $myfname = $this->getMemName()['names'];
            $names1 = explode(' ', $myfname);
            $fname1 = $names1[0];
            $this->getname = ucwords($fname1);
            $this->myfname = ucwords($myfname);
            $this->mymail = $this->getMemName()['emails'];
            $this->memid = $this->getMemName()['id'];
            $this->validate_mem = $this->sql_models->validate_users();
        }else {
            $this->getname = "";
            $this->myfname = "";
            $this->mymail = "";
            $this->memid = "";
            $this->validate_mem = "";
        }



        
        function hash_password($password){
           return password_hash($password, PASSWORD_BCRYPT);
        }

        function time_ago($date){
            $periods=array("sec","min","hr","day","week","month","year","decade");
            $lengths=array("60","60","24","7","4.35","12","10");
            $now=time();
            @$mydate=strtotime($date);
            if($now>$mydate){
                $difference=$now-$mydate;
                $tense="ago";
            }else{
                $difference=$mydate-$now;
                $tense="from now";
            }
            for($j=0; $difference>=$lengths[$j] && $j<count($lengths)-1; $j++){
                $difference/=$lengths[$j];
            }
            $difference=intval($difference);
                //$difference=round($difference,PHP_ROUND_HALF_DOWN);
            if($difference!=1){
                $periods[$j].='s';
            }
            return "$difference $periods[$j] {$tense}";
        }


        function convertTime($difference){
            $days = intval($difference / 86400); 
            $difference = $difference % 86400;
            $hours = intval($difference / 3600)+($days*24); 
            $difference = $difference % 3600;
            $minutes = intval($difference / 60);
            $difference = $difference % 60;
            $seconds = intval($difference); 
            $check_zero = $days;
            if($check_zero<=0)
                return ("<font style='font-size:14px;'>".$hours."hrs</font>");
            else
                return ($days." days");
        }


        function convertTime1($difference){
            $days = intval($difference / 86400); 
            $difference = $difference % 86400;
            $hours = intval($difference / 3600)+($days*24); 
            $difference = $difference % 3600;
            $minutes = intval($difference / 60); 
            $difference = $difference % 60;
            $seconds = intval($difference); 
            $check_zero = $days;
            if($check_zero<=0)
                return ("$hours hrs, $minutes mins time");
                //return ("<font style='font-size:14px;'>$hours hrs, $minutes mins</font>");
            else
                return ("$days days time");
        }


        function makeLinks2($str) {
            $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
            $star_sign = "/\*(.*?)\*/";
            $underscores = "/\_(.*?)\_/";
            if(preg_match($reg_exUrl, $str, $url)) {                    
                if(strpos( $url[0], ":" ) === false){
                    $link = 'http://'.$url[0];
                }else{
                    $link = $url[0];
                }
                $str = preg_replace($reg_exUrl, '<span href="javascript:;" style="color:#09C; display:inline !important">link removed</span>', $str);
            }
            $str = preg_replace(array($star_sign, $underscores), array('<b style="font-size:15px; color:#222">$1</b>', '<u style="">$1</u>'), $str);
            return $str;
        }


        function makeLinks3($str) {
            $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
            $star_sign = "/\*(.*?)\*/";
            $underscores = "/\_(.*?)\_/";
            if(preg_match($reg_exUrl, $str, $url)) {                    
                if(strpos( $url[0], ":" ) === false){
                    $link = 'http://'.$url[0];
                }else{
                    $link = $url[0];
                }
                $str = preg_replace($reg_exUrl, '<a href="'.$link.'" target="_blank" style="color:#09C; display:inline !important">'.$link.'</a>', $str);
                
            }
            $str = preg_replace(array($star_sign, $underscores), array('<b style="font-size:15px; color:#06C">$1</b>', '<u style="">$1</u>'), $str);
            return $str;
        }


        function mylocation(){
            return ip_info($_SERVER['REMOTE_ADDR'], "Country");
        }


        function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
            $output = NULL;
            if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
                $ip = $_SERVER["REMOTE_ADDR"];
                if ($deep_detect) {
                    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
            $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
            $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
            $continents = array(
                "AF" => "Africa",
                "AN" => "Antarctica",
                "AS" => "Asia",
                "EU" => "Europe",
                "OC" => "Australia (Oceania)",
                "NA" => "North America",
                "SA" => "South America"
            );
            if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
                $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
                if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                    switch ($purpose) {
                        case "location":
                            $output = array(
                                "city"           => @$ipdat->geoplugin_city,
                                "state"          => @$ipdat->geoplugin_regionName,
                                "country"        => @$ipdat->geoplugin_countryName,
                                "country_code"   => @$ipdat->geoplugin_countryCode,
                                "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                                "continent_code" => @$ipdat->geoplugin_continentCode
                            );
                            break;
                        case "address":
                            $address = array($ipdat->geoplugin_countryName);
                            if (@strlen($ipdat->geoplugin_regionName) >= 1)
                                $address[] = $ipdat->geoplugin_regionName;
                            if (@strlen($ipdat->geoplugin_city) >= 1)
                                $address[] = $ipdat->geoplugin_city;
                            $output = implode(", ", array_reverse($address));
                            break;
                        case "city":
                            $output = @$ipdat->geoplugin_city;
                            break;
                        case "state":
                            $output = @$ipdat->geoplugin_regionName;
                            break;
                        case "region":
                            $output = @$ipdat->geoplugin_regionName;
                            break;
                        case "country":
                            $output = @$ipdat->geoplugin_countryName;
                            break;
                        case "countrycode":
                            $output = @$ipdat->geoplugin_countryCode;
                            break;
                    }
                }
            }
            return $output;
        }

    }



    function send_mail($from_email, $to_email, $identification, $messages, $subj){
        $this->load->library('email');
        $this->email->from($from_email, $identification);
        $this->email->to($to_email);
        $this->email->subject($subj);
        $this->email->message($messages);
        if($this->email->send())
            return true;
        else
            return false;
    }



    function validateMemberAuth(){
        return $this->sql_models->validateMember();
    }


    function getMemName(){
        return $this->sql_models->getMemDetails();
    }


    function getPaidID(){
        return $this->sql_models->getPaidMemIDs();
    }


    function getPaidID1(){
        return $this->sql_models->getPaidMemIDs1();
    }


    function compatibility_issues(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15)){
            return true;
        }
    }



    public function index(){
        if($this->compatibility_issues()) redirect('compatibility');
        $data['page_title'] = "Jamb, WAEC, NECO, Common Entrance, Masters, Locate Centres, Past Questions & Answers";
        $ipaddrs = $_SERVER['REMOTE_ADDR'];
        $this->sql_models->record_visitors($ipaddrs);
        $data['page_name'] = "";
        $data['page_header'] = "";
        $ipaddrs = $_SERVER['REMOTE_ADDR'];
        $data['test_boards'] = $this->test_boards;
        //$this->sql_models->storeLocs();
        $data['students_test'] = $this->sql_models->countArrayData('stud_ans', 'memid', '');
        $data['myviews_test'] = $this->sql_models->countArrayData('test_boards', 'views', '');
        $data['myviews_centres'] = $this->sql_models->countArrayData('centres', 'views', '');
        $data['mydownloads'] = $this->sql_models->countArrayData('resources', 'downloads', 'doc');
        $data['questviews'] = $this->sql_models->countArrayData('resources', 'views', 'doc');
        $data['watched'] = $this->sql_models->countArrayData('resources', 'views', 'vid');
        $data['mycentres'] = $this->sql_models->countArrayData('centres', 'id', '');
        $data['mylogos'] = $this->sql_models->countArrayData('logos', 'urls, files', '');
        $data['mylogos_cnt'] = $this->sql_models->countArrayData('logos', 'id', '');
        $this->load->view("header", $data);
        $this->load->view("index", $data);
        $this->load->view('footer', $data);
    }



    function storeLocs1(){
        $this->sql_models->storeLocs();
    }


    public function dashboard(){
        if($this->sql_models->validate_users()){
            $data['page_name'] = "";
            $data['page_title'] = ucwords($this->myfname);
            $data['getId'] = "";
            $data['perform'] = $this->sql_models->fetchPerform($this->memid);
            $data['cart_cnt'] = $this->sql_models->countRecs1('cart', 'memid', $this->memid);
            $data['last_test'] = $this->sql_models->fetchLastTest();
            $data['mycarts'] = $this->sql_models->fetchRecs1('cart crt', 'res.id, res.files, crt.paid, res.price, crt.date_posted, res.titles', 'resources res', 'crt.paid', 'asc', $this->memid);

            $data['url_id'] = "";
            $this->load->view("dashboard/header", $data);
            $this->load->view("dashboard/index", $data);
        }else{
            ?>
            <script>
            alert('You are not logged in!');
            window.location = '<?=base_url()?>';
            </script>
            <?php
        }
    }


    public function profile(){
        if($this->sql_models->validate_users()){
            $data['page_name'] = "profile";
            $data['page_title'] = ucwords($this->myfname);
            $data['getId'] = "";
            $data['mems'] = $this->sql_models->getMemDetails();
            $data['url_id'] = "";
            $this->load->view("dashboard/header", $data);
            $this->load->view("dashboard/index", $data);
        }else{
            redirect('');
        }
    }


    public function cart(){
        if($this->sql_models->validate_users()){
            $data['page_name'] = "cart";
            $data['page_title'] = "My Cart Items";
            $data['getId'] = "";
            $data['mems'] = $this->sql_models->getMemDetails();
            $data['url_id'] = "";
            $this->load->view("dashboard/header", $data);
            $this->load->view("dashboard/index", $data);
        }else{
            redirect('');
        }
    }



    public function upload_profile(){
        $this->form_validation->set_rules('txtnames', 'full names', 'required|trim|alpha_space|min_length[7]|max_length[40]');
        
        $this->form_validation->set_rules('txtph', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');

        $this->form_validation->set_rules('txtemail', 'email', 'required|trim|valid_email');

        $txtnames = $this->input->post('txtnames');
        $txtph = $this->input->post('txtph');
        $txtemail = $this->input->post('txtemail');
        $txtgend = $this->input->post('txtgend');
        $txtmember = $this->input->post('txtmember');
        $txtf0 = $this->input->post('txtf0');

        $txt_yes_file_bma = $this->input->post('txt_yes_file_bma');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $path4 = @$_FILES['txt_bma_pic']['name'];
            $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
            $img_ext_chk1 = array('jpg','png','jpeg');


            if(@$_FILES['txt_bma_pic']['name'] == "" && $txt_yes_file_bma==0)
                echo "Please upload your profile photo and continue<br>";
            else if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['name'] != "")
                echo "Please select a valid image for profile photo<br>";
            else if(isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['size'] > 4194304)
                echo "Your profile photo has exceeded 4MB<br>";
            else{
                $type = explode('.', @$_FILES["txt_bma_pic"]["name"]);
                $type = $type[count($type)-1];
                $randm = time();
                $rename_file = "$randm.$ext4";
                
                $url_source = "fake_fols/".$rename_file;
                $url_dest = "profile_pics/".$rename_file;
                
                $new_name4 = $rename_file;
                if(isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['name'] != ''){
                    $file_tmp = @$_FILES["txt_bma_pic"]["tmp_name"];
                    if(is_uploaded_file($file_tmp) && isset($_FILES['txt_bma_pic']['name']) ){
                        if($txtmember != "")
                            $this->sql_models->delete_images($txtf0, 'profile_pics/');

                        move_uploaded_file($file_tmp, $url_source);
                        $this->compress($url_source, $url_dest, 25);
                    }

                    $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                    if(is_readable($in_folder1)) @unlink($in_folder1);

                    $newdata3 = array(
                        'names'              => $txtnames,
                        'emails'             => $txtemail,
                        'phone'              => $txtph,
                        'gender'             => $txtgend,
                        'pics'               => $new_name4
                    );

                }else{ // image not set
                    
                    $newdata3 = array(
                        'names'              => $txtnames,
                        'emails'             => $txtemail,
                        'phone'              => $txtph,
                        'gender'             => $txtgend
                    );
                }

                $querys1 = $this->sql_models->update_inserts_members($newdata3, $txtmember);

                if($querys1){
                    $now = 865000;
                    $cookie = array(
                        'name'   => 'tst_uname',
                        'value'  => sha1($txtemail),
                        'expire' => $now,
                        'secure' => FALSE
                    );
                    set_cookie($cookie);
                    echo "done_2";
                }else{
                    echo "Error in updating your profile, please try again later.";
                }
            }
        }
    }




    public function performance(){
        if($this->sql_models->validate_users()){
            $data['page_name'] = "performance";
            $data['page_title'] = ucwords($this->myfname);
            $data['getId'] = "";
            $data['url_id'] = "";
            $this->load->view("dashboard/header", $data);
            $this->load->view("dashboard/index", $data);
        }else{
            redirect('');
        }
    }



    function approve_tables(){
        $id1 = $this->input->post('id1');
        $tbls = $this->input->post('tbls');
        $columns = $this->input->post('columns');
        $approve_it = $this->sql_models->approveIDS($id1, $columns, $tbls);
    }

    
    function approve_quiz_set(){
        $id1 = $this->input->post('id1');
        $approve_it = $this->sql_models->approveIDS($id1, '', 'quizes_intro');
    }



    function forum_view_loads(){
        $frid = $this->input->post('frid');
        $data['forums'] = $this->sql_models->fetchARecord($frid, 'forums', '');
        $data['fetch_views'] = $this->sql_models->updateViews($frid, 'forums', '');
        $data['validate_mem'] = $this->validate_mem;
        $data['get_mems_id'] = $this->sql_models->getPaidMemIDs1();
        $data['page_name'] = "replyloads";
        $data['frids'] = $frid;
        $data['param1'] = "pages";
        $this->load->view('forum_reply', $data);
    }



    function upload_res(){
        $this->form_validation->set_rules('txtmedia', 'Media', 'required|trim');
        $this->form_validation->set_rules('txt_board[]', 'TestBoard', 'required|trim');
        $this->form_validation->set_rules('txttitle', 'Resources Title', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('txtprice', 'Price', 'trim|max_length[10]|numeric');
        $this->form_validation->set_rules('txtftype', 'File Type', 'trim');

        if($this->form_validation->run() == FALSE){
            $arrs = array('type'=>'error', 'msg'=>validation_errors(), 'new_img'=>'', 'exts'=> '');

        }else{
            $txtmedia = $this->input->post('txtmedia');
            $txt_board = $this->input->post('txt_board');
            $txttitle = $this->input->post('txttitle');
            $txtprice = $this->input->post('txtprice');
            $txtftype = $this->input->post('txtftype');
            $txt_yr = $this->input->post('txt_yr');
            $txteditor = $this->input->post('txteditor');
            $former_file_ph = $this->input->post('former_file_ph');
            $former_file_ph1 = $this->input->post('former_file_ph1');
            $txtres_id = $this->input->post('txt_id');

            $txt_board1="";
            if($txt_board){
                foreach ($txt_board as $txt_boards) {
                    $txt_board1 .= "$txt_boards,";
                }
                $txt_board = substr($txt_board1, 0, -1);
            }

            $txt_yr1="";
            if($txt_yr){
                foreach ($txt_yr as $txt_yrs) {
                    $txt_yr1 .= "$txt_yrs,";
                }
                $txt_yr = substr($txt_yr1, 0, -1);
            }

            if($txtmedia=="doc"){
                $txtmedia1="document";
                $arrs = "pdf or doc";
                $img_ext_chk1 = array('pdf','doc');
            }else{
                $txtmedia1="video";
                $arrs = "mp4";
                $img_ext_chk1 = array('mp4');
            }

            $path1 = @$_FILES['txtfile']['name'];
            $path2 = @$_FILES['txtfile1']['name'];
            $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
            $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
            $ext = strtolower($ext1);
            $ext2 = strtolower($ext2);
            
            $img_ext_chk2 = array('jpg','png');
            $randm1 = time();

            if($ext1 == "" && $former_file_ph=="")
                $arrs = array('type'=>'error', 'msg'=>"Please select a $txtmedia1 to upload<br>", 'new_img'=>'', 'exts'=> '');

            else if(!in_array($ext1,$img_ext_chk1) && isset($_FILES['txtfile']['name']) && @$_FILES['txtfile']['name'] != "")
                $arrs = array('type'=>'error', 'msg'=>"Please select a valid file in $arrs format<br>", 'new_img'=>'', 'exts'=> '');

            else if(isset($_FILES['txtfile']['name']) && @$_FILES['txtfile']['size'] > 20971520)
                $arrs = array('type'=>'error', 'msg'=>'This image has exceeded 20MB<br>', 'new_img'=>'', 'exts'=> '');

            else if(!in_array($ext2,$img_ext_chk2) && isset($_FILES['txtfile1']['name']) && @$_FILES['txtfile1']['name'] != "")
                $arrs = array('type'=>'error', 'msg'=>'Please select a valid cover image in jpg, png format<br>', 'new_img'=>'', 'exts'=> '');

            else if(isset($_FILES['txtfile1']['name']) && @$_FILES['txtfile1']['size'] > 1048576)
                $arrs = array('type'=>'error', 'msg'=>'This image has exceeded 1MB<br>', 'new_img'=>'', 'exts'=> '');

            else{

                $rename_file = "$randm1.$ext1";
                $url = "resourcesfiles/".$rename_file;

                $rename_file1 = "$randm1.$ext2";
                $url_source = "fake_fols/".$rename_file1;
                $url_dest = "resourcesfiles/".$rename_file1;

                $file_tmp = $_FILES["txtfile"]["tmp_name"];
                $file_tmp1 = $_FILES["txtfile1"]["tmp_name"];
                $data0 = array();
                $data1 = array();

                if(isset($_FILES['txtfile']['name']) && @$_FILES['txtfile']['name'] != ""){
                    if(is_uploaded_file($file_tmp)){
                        if($txtres_id != "")
                            $this->sql_models->delete_images($former_file_ph, 'resourcesfiles/');
                        if(move_uploaded_file($file_tmp, $url)){
                            $data0 = array('files' => $rename_file);
                        }
                    }
                }

                if(isset($_FILES['txtfile1']['name']) && @$_FILES['txtfile1']['name'] != ""){
                    if(is_uploaded_file($file_tmp1)){
                        if($txtres_id != "")
                            $this->sql_models->delete_images($former_file_ph1, 'resourcesfiles/');
                        if(move_uploaded_file($file_tmp1, $url_source)){
                            $this->compress($url_source, $url_dest, 60);
                            $data1 = array('img_cover' => $rename_file1);
                        }
                    }
                }

                $data2 = array();
                if($txtres_id==""){
                    $data2 = array('views'=>0, 'downloads'=>0, 'date_uploaded'=>date("Y-m-d g:i a", time()));
                }

                $data3 = array(
                    'media_type'     => $txtmedia,
                    'test_board'     => $txt_board,
                    'titles'         => $txttitle,
                    'descrip'        => $txteditor,
                    'file_type'      => $txtftype,
                    'price'          => $txtprice,
                    'years'          => $txt_yr,
                );
                $newdata3 = array_merge($data0, $data1, $data3, $data2);

                if($this->sql_models->insert_datas($newdata3, $txtres_id, 'resources')){

                    if($txtres_id=="")
                        $arrs = array('type'=>'success', 'msg'=>'createds', 'new_img'=>$rename_file, 'exts'=> $ext);
                    else
                        $arrs = array('type'=>'success', 'msg'=>'updateds', 'new_img'=>$rename_file, 'exts'=> $ext);
                }else{
                    $arrs = array('type'=>'error', 'msg'=>'Error!', 'new_img'=>'', 'exts'=> '');
                }
            }
        }
        echo json_encode($arrs);
    }



    function upload_logo(){
        $this->form_validation->set_rules('txturl', 'Website URL', 'required|trim');

        if($this->form_validation->run() == FALSE){
            $arrs = array('type'=>'error', 'msg'=>validation_errors(), 'new_img'=>'', 'exts'=> '');

        }else{
            $txturl = $this->input->post('txturl');
            $former_file_ph1 = $this->input->post('former_file_ph1');
            $txtres_id = $this->input->post('txt_id');


            $path2 = @$_FILES['txtfile1']['name'];
            $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
            $ext2 = strtolower($ext2);
            
            $img_ext_chk2 = array('jpg','png');
            $randm1 = time();

            if($ext2 == "" && $former_file_ph1=="")
                $arrs = array('type'=>'error', 'msg'=>'Please select a logo<br>', 'new_img'=>'', 'exts'=> '');

            else if(!in_array($ext2,$img_ext_chk2) && isset($_FILES['txtfile1']['name']) && @$_FILES['txtfile1']['name'] != "")
                $arrs = array('type'=>'error', 'msg'=>'Please select a valid cover image in jpg, png format<br>', 'new_img'=>'', 'exts'=> '');

            else if(isset($_FILES['txtfile1']['name']) && @$_FILES['txtfile1']['size'] > 1048576)
                $arrs = array('type'=>'error', 'msg'=>'This image has exceeded 1MB<br>', 'new_img'=>'', 'exts'=> '');

            else{

                $rename_file1 = "$randm1.$ext2";
                $url_source = "fake_fols/".$rename_file1;
                $url_dest = "images/logos/".$rename_file1;

                $file_tmp1 = $_FILES["txtfile1"]["tmp_name"];
                $data0 = array();
                $data1 = array();

                if(isset($_FILES['txtfile1']['name']) && @$_FILES['txtfile1']['name'] != ""){
                    if(is_uploaded_file($file_tmp1)){
                        if($txtres_id != "")
                            $this->sql_models->delete_images($former_file_ph1, 'images/logos/');
                        if(move_uploaded_file($file_tmp1, $url_source)){
                            $this->compress($url_source, $url_dest, 55);
                            $data0 = array('files' => $rename_file1);
                        }
                    }
                }

                if($txtres_id==""){
                    $data1 = array('dates'=>date("Y-m-d g:i a", time()));
                }

                $data2 = array(
                    'urls'     => $txturl
                );
                $newdata3 = array_merge($data0, $data1, $data2);

                if($this->sql_models->insert_datas($newdata3, $txtres_id, 'logos')){

                    if($txtres_id=="")
                        $arrs = array('type'=>'success', 'msg'=>'createds', 'new_img'=>$rename_file1, 'exts'=> $ext2);
                    else
                        $arrs = array('type'=>'success', 'msg'=>'updateds', 'new_img'=>$rename_file1, 'exts'=> $ext2);
                }else{
                    $arrs = array('type'=>'error', 'msg'=>'Error!', 'new_img'=>'', 'exts'=> '');
                }
            }
        }
        echo json_encode($arrs);
    }




    function upload_centres(){
        $this->form_validation->set_rules('txtboard', 'Test Board', 'required|trim');
        $this->form_validation->set_rules('txttitle', 'Centre Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('txtaddress', 'Location', 'required|trim');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txtboard = $this->input->post('txtboard');
            $txttitle = $this->input->post('txttitle');
            $txtaddress = $this->input->post('txtaddress');
            $txtstates1 = $this->input->post('txtstates1');
            $txtcity = $this->input->post('txtcity');
            $txt_id = $this->input->post('txt_id'); // for edit

                
            if($txt_id!=""){ // for edit
                $data3 = array(
                    //'approved'          => 0,
                    'centre_name'       => $txttitle,
                    'test_board'        => $txtboard,
                    'locations'         => $txtaddress,
                    'statee'            => $txtstates1,
                    'city'              => $txtcity
                );
            }else{
                $data3 = array(
                    'approved'          => 1,
                    'centre_name'       => $txttitle,
                    'test_board'        => $txtboard,
                    'locations'         => $txtaddress,
                    'statee'            => $txtstates1,
                    'city'              => $txtcity,
                    'views'             => 0,
                    'date_posted'   => date("Y-m-d g:i a", time())
                );
            }
            if($this->sql_models->insert_tbl($data3, $txt_id, 'centres')){
                echo "createds";
            }else{
                echo "Error!";
            }
        }
    }




    function noofquest(){
        $txtyears = $this->input->post('txtyears');
        $txtsubjid = $this->input->post('txtsubjid');
        $txttest_board = $this->input->post('txttest_board');
        $ids_arr = $this->input->post('ids_arr');
        $name_of_sch = $this->input->post('name_of_sch');
        echo $this->sql_models->countQuiz1($txtyears, $txtsubjid, $txttest_board, $ids_arr, $name_of_sch);
    }
    



    function all_searches(){
        $cats = $this->input->post('cats');
        $locn = $this->input->post('locn');
        $keywords = $this->input->post('keywords');
        $campaignRecords = $this->sql_models->fetchCampaigns_rough('', $cats, '', $locn, $keywords, '', '');
        echo $campaignRecords;
    }




    function save_stud_test_start($qid_intro, $studid, $is_new_rec, $subject_id, $ids_arr){
        $newdata5 = array(
             'my_answers' => "",
             'quizid'     => "",
             'allRandIDs'    => ""
        );
        $this->session->set_userdata($newdata5);

        if($ids_arr == "arrays"){
            $subject_id = str_replace(array("\n", " "), "", $subject_id);
        }

        $newdata3 = array(
            'memid'             => $studid,
            'quiz_intro_id'     => $qid_intro,
            'subject_id'        => $subject_id,
            'started_test'      => 1,
            'attempts'          => 1
        );

        if($is_new_rec == "yes"){

            $this->db->select('attempts')->from('stud_start_test')->where('memid', $studid)
            ->where('quiz_intro_id', $qid_intro)->where('subject_id', $subject_id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $attempts1 = $query->row('attempts');
                if($attempts1==null || $attempts1=="") $attempts1=0;
                $this->db->set('attempts', $attempts1+1);
                $this->db->where('memid', $studid)->where('quiz_intro_id', $qid_intro)->where('subject_id', $subject_id)
                ->update('stud_start_test');

            }else{

                $this->db->insert('stud_start_test', $newdata3);
            }
        }else{
            /// update attempts
            $this->db->select('attempts')->from('stud_start_test');
            $this->db->where('memid', $studid)->where('subject_id', $subject_id)->where('quiz_intro_id', $qid_intro);
            $query = $this->db->get();
            $attempts = $query->row('attempts');
            if($attempts==null || $attempts=="") $attempts=0;
            $this->db->set('attempts', $attempts+1);
            $this->db->where('memid', $studid)->where('subject_id', $subject_id)->where('quiz_intro_id', $qid_intro)
            ->update('stud_start_test');
            /// update attempts
        }
        return true;
    }



    function getAttempted(){
        $qid_intro = trim($this->input->post('qid_intro'));
        $studid = trim($this->input->post('studid'));
        $campid = trim($this->input->post('campid'));

        $userAttempted = $this->sql_models->userAttempted($qid_intro, $studid, $campid);
        $result = json_decode($userAttempted);

        $types = $result->type;
        $msg = $result->msg;
        $myresults = "";

        $h3s = '<h3>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
              <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
              <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
            </svg>
        </h3>';


        $myresults1 = "";
        if($types == "free" && $msg == 1){
            $myresults .= '<p style=" font-size: 16px; text-align: center; margin: 15px 0 1em 0;">
                <font style="display:block; margin-bottom:15px;">You have already written this quiz once, you cannot pertake on this again as a free user. <br><a href="'.base_url().'dashboard/subscription/">Upgrade to premium</a></font>
            </p>';
            $myresults .= '<button class="primary-btn text-uppercase" id="cmd_finished">Done</button>';
            $myresults1 = $h3s.$myresults;
        }

        if($types == "premium" && $msg >= 1){
            if($msg >= 3){
                $myresults .= '<p style=" font-size: 16px; text-align: center; margin: 15px 0 1em 0;">
                    <font style="display:block; margin-bottom:15px;">You have attempted this 3 times, you cannot pertake on this again.</font>
                </p>';
                $myresults .= '<button class="primary-btn text-uppercase" id="cmd_finished">Done</button>';
            }else{

                $counts3 = 3 - $msg; // 2
                $myresults .= "<p style='font-size: 16px; text-align: center; margin: 15px 0 1em 0;''>
                    <font style='display:block; margin-bottom:15px;''>You have written this scholarship quiz before, you have $counts3 more chance(s) to pertake on this again</font>
                </p>";
                $myresults .= '<button class="primary-btn text-uppercase" id="cmd_try_more" style="font-weight:bold">Ok</button>';
            }
            $myresults1 = $h3s.$myresults;
        }
        echo $myresults1;
    }




    function download_file(){
        $ids = $this->input->post('ids');
        $this->sql_models->updateResultViews("resources", "downloads", $ids);
    }




    function questions($record=0){
        if(!$this->auths){
            echo "logged_out";
        }else{

            $txtans1 = trim($this->input->post('txtans1'));
            $txtrandom_quiz = trim($this->input->post('txtrandom_quiz'));
            $qid_intro = trim($this->input->post('qid_intro'));
            $subject_id = trim($this->input->post('subject_id'));
            $tasks = trim($this->input->post('tasks'));
            $test_types = trim($this->input->post('test_types'));
            $test_board = trim($this->input->post('test_board'));
            $noOfYrs = trim($this->input->post('noOfYrs'));
            $ids_arr = trim($this->input->post('ids_arr'));

            $my_answers = $this->session->userdata('my_answers');
            $quizid = $this->session->userdata('quizid');

            
            $txtans1 = str_replace("&dagger;", "+;", $txtans1);

            
            $allRandIDs = $this->session->userdata('allRandIDs');
            $allQuizIDs2 = "";
            foreach ($allRandIDs as $value) {
                $allQuizIDs2 .= $value['id'].",";
            }

            //if(strpos($quizid, $txtrandom_quiz) == false) {
                if(isset($my_answers) && $my_answers!=""){
                    $txtans2 = $my_answers;
                    //$txtrandom_quiz2 = $quizid;
                }else{
                    $txtans2 = "";
                    //$txtrandom_quiz2 = "";
                }
                $txtrandom_quiz2 = $quizid;
                
                $txtans2 .= $txtans1."||";
                $txtrandom_quiz2 .= "$txtrandom_quiz,";


                if(isset($allQuizIDs2) && !empty($allQuizIDs2)){
                    $txtrandom_quizes = $allQuizIDs2;
                }else{
                    $txtrandom_quizes = $txtrandom_quiz2;
                }

                $newdata3 = array(
                    'my_answers' => $txtans2,
                    'quizid'     => $txtrandom_quizes
                );

                if($tasks=="next")
                    $this->session->set_userdata($newdata3);  // write a script to exclude this on prev btn

            //}

            //$record=0;
            $recordPerPage = 1;
            if($record != 0){
                $record = ($record-1) * $recordPerPage;
            }

            $quiz_quests = $this->sql_models->quizQuestions('', $qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr, $record, $recordPerPage);

            $recordCount = $this->sql_models->countQuestions('', $qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr);

            $attempts = $this->sql_models->already_started($this->memid, $qid_intro, $subject_id, $test_types, $ids_arr);
            $submitted_attempts = $this->sql_models->submitted_attempts($this->memid, $qid_intro, $subject_id, $test_types, $ids_arr);
            $subj_name = $this->sql_models->subjName($subject_id, $ids_arr, $qid_intro);

            $config['base_url'] = base_url().'node/questions';
            
            ////////////////////
                $config["total_rows"] = $recordCount;
                $config["per_page"] = $recordPerPage;
                $config['use_page_numbers'] = TRUE;
                $config['num_links'] = 2;

                $config['first_link'] = FALSE;
                $config['first_tag_open'] = FALSE;
                $config['first_tag_close'] = FALSE;
                
                $config['last_link'] = FALSE;
                $config['last_tag_open'] = FALSE;
                $config['last_tag_close'] = FALSE;
                
                
                //Encapsulate whole pagination 
                $config['full_tag_open'] = '<ul class="pagination_ blog_pagn">';
                $config['full_tag_close'] = '</ul>';

                //For PREVIOUS PAGE Setup
                //$config['prev_link'] = 'prev';
                $config['prev_link'] = "<span aria-hidden='true' class='next_prev_btn prev_btn' id_sch='$qid_intro' test_types='$test_types' test_board='$test_board' ids_arr='$ids_arr' noOfYrs='$noOfYrs' subject_id='$subject_id'>
                    <span class='fa fa-arrow-left'></span> PREV
                </span>";

                $config['prev_tag_open'] = "<li>";
                $config['prev_tag_close'] = '</li>';


                //For NEXT PAGE Setup
                $config['next_link'] = "<span aria-hidden='true' class='next_prev_btn' id_sch='$qid_intro' test_types='$test_types' test_board='$test_board' ids_arr='$ids_arr' noOfYrs='$noOfYrs' subject_id='$subject_id'>
                    NEXT <span class='fa fa-arrow-right'></span>
                </span>";

                $config['next_tag_open'] = "<li>";
                $config['next_tag_close'] = '</li>';

                //For LAST PAGE Setup
                // $config['last_link'] = 'Last';
                // $config['last_tag_open'] = '<li>';
                // $config['last_tag_close'] = '</li>';

                //For CURRENT page on which you are
                // $config['cur_tag_open'] = '<li class="active"><a href="#">';
                // $config['cur_tag_close'] = '</a></li>';


                
                // $config['num_tag_open'] = '<li class="page-link">';
                // $config['num_tag_close'] = '</li>';
            ////////////////////

            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();


            if($quiz_quests){
                $qid = $quiz_quests['ids'];
                $questions = ucfirst($quiz_quests['questions']);
                $files = $quiz_quests['files'];
                $op1 = $quiz_quests['op1'];
                $op2 = $quiz_quests['op2'];
                $op3 = $quiz_quests['op3'];
                $op4 = $quiz_quests['op4'];
                $ans1 = $quiz_quests['ans1'];
                $explanations = $quiz_quests['explanations'];
                $op1_1=$op1; $op1_2=$op2; $op1_3=$op3; $op1_4=$op4;

            
                $all_options = array($op1, $op2, $op3, $op4);
                if($op1!="" && $op2!="" && $op3=="" && $op4=="") $all_options = array($op1, $op2);
                if($op1!="" && $op2!="" && $op3!="" && $op4=="") $all_options = array($op1, $op2, $op3);
                shuffle($all_options);
        
                $files1="";
                if($files!=""){
                    $paths = base_url()."quizes/$files";
                    $files1 = "<div style='margin-bottom:15px' class='quiz_img'><img src='$paths' style='width:100%'></div>";
                }
                    
                echo "<input type='hidden' name='txtrandom_quiz' id='txtrandom_quiz' value='$qid'>";
                echo "<input type='hidden' name='qid_intro' id='qid_intro' value='$qid_intro'>";

                $questions = str_replace(array('<p>', '</p>'), "", $questions);
                $questions = ucfirst($questions);

                echo "<ul class='quiz_question'>
                    <li style='font-size:16px; line-height:22px; color:#ddd; font-weight: 600;'><font id='txtpage_number_h'>1.</font> $questions</li>
                </ul>";

                echo "<ul class='quiz_options' ids='$qid'>";
                echo $files1;
                $k=1;

                $quizid_taken_ans = $this->session->userdata('my_answers');
                $quizid_taken_ans = substr($quizid_taken_ans, 0, -2);
                $quizid_taken2 = explode("||", $quizid_taken_ans);
                $quizid_taken2 = array_unique($quizid_taken2);

                //print_r($quizid_taken2);

                foreach($all_options as $keys){
                    if($k == 1) $m="<b>A)</b>";
                    else if($k == 2) $m="<b>B)</b>";
                    else if($k == 3) $m="<b>C)</b>";
                    //else if($k == 4) $m="<b>D)</b>";
                    else $m="<b>D)</b>";
                    $keys1 = ucfirst($keys);

                    echo "<li>
                        <label for='options$keys'>$m&nbsp;
                        <label class='container_radio'>$keys1";

                        $keys_i = str_replace("+", "&dagger;", $keys);
                        ?>

                        <input type='radio' name='options1' value='<?=$keys_i?>' class='<?=$keys?> chk' id='options<?=$keys?>' <?php if(in_array($keys, $quizid_taken2)) echo "checked"; ?> ids='<?=$qid?>'>
                        
                        <?php
                        echo "<span class='checkmark'></span>
                        </label>
                        </li>";
                    $k++;
                }
                echo "</ul>";
                //echo $results;
            }else{
                echo "No Questions";
            }
            ?>
            

            <div style='clear:both'></div>
            <div class="loaders" style="display: none;"><img src="<?=base_url();?>img/loader.gif">  Loading...</div>
            <?php echo $pagination; ?>
    <?php
        }
    }




    function update_my_pass(){
        $this->form_validation->set_rules('txtpass1', 'old password', 'required|trim');
        $this->form_validation->set_rules('txtpass2', 'new password', 'required|trim');
        $this->form_validation->set_rules('txtpass3', 'confirm password', 'required|trim|matches[txtpass2]');
        $oldpass = $this->input->post('txtpass1');
        $admin_type = $this->input->post('admin_type');
        if($admin_type=="")
            $pass_type="tst_pass";
        else
            $pass_type="adm_password_testpt";
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $new_pass = sha1($this->input->post('txtpass3'));
            $updated = $this->sql_models->update_password($new_pass, sha1($oldpass), $admin_type);
            if($updated){
                $now = 865000;
                $cookie = array(
                    'name'              => $pass_type,
                    'value'             => $new_pass,
                    'expire'            => $now,
                    'secure'            => FALSE
                );
                set_cookie($cookie);
                echo "pass1_updated";
            }else{
                echo "Invalid old password!";
            }
        }
    }





    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        // First get the platform?
        if (preg_match('/android/i', $u_agent)) {
          $platform = 'android';
        }else if (preg_match('/linux/i', $u_agent)) {
          $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
          $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
          $platform = 'windows';
        }
    
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
          $bname = 'Internet Explorer';
          $ub = "MSIE";
        } elseif(preg_match('/Firefox/i',$u_agent)) {
          $bname = 'Mozilla Firefox';
          $ub = "Firefox";
        } elseif(preg_match('/Chrome/i',$u_agent)) {
          $bname = 'Google Chrome';
          $ub = "Chrome";
        } elseif(preg_match('/Safari/i',$u_agent)) {
          $bname = 'Apple Safari';
          $ub = "Safari";
        } elseif(preg_match('/Opr|Opera/i',$u_agent) || preg_match('/Opera/i',$u_agent)) {
          $bname = 'Opera';
          $ub = "Opera";
        } elseif(preg_match('/Netscape/i',$u_agent)) {
          $bname = 'Netscape';
          $ub = "Netscape";
        }
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
          // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
          //we will have two since we are not using 'other' argument yet
          //see if version is before or after the name
          if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
          } else {
            $version= $matches['version'][1];
          }
        } else {
          $version= $matches['version'][0];
        }
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
      return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
        );
    }


    function is_mobile() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
        $mobile_agents = Array(
            "240x320",
            "acer",
            "acoon",
            "acs-",
            "abacho",
            "ahong",
            "airness",
            "alcatel",
            "amoi", 
            "android",
            "anywhereyougo.com",
            "applewebkit/525",
            "applewebkit/532",
            "asus",
            "audio",
            "au-mic",
            "avantogo",
            "becker",
            "benq",
            "bilbo",
            "bird",
            "blackberry",
            "blazer",
            "bleu",
            "cdm-",
            "compal",
            "coolpad",
            "danger",
            "dbtel",
            "dopod",
            "elaine",
            "eric",
            "etouch",
            "fly " ,
            "fly_",
            "fly-",
            "go.web",
            "goodaccess",
            "gradiente",
            "grundig",
            "haier",
            "hedy",
            "hitachi",
            "htc",
            "huawei",
            "hutchison",
            "inno",
            "ipad",
            "ipaq",
            "ipod",
            "jbrowser",
            "kddi",
            "kgt",
            "kwc",
            "lenovo",
            "lg ",
            "lg2",
            "lg3",
            "lg4",
            "lg5",
            "lg7",
            "lg8",
            "lg9",
            "lg-",
            "lge-",
            "lge9",
            "longcos",
            "maemo",
            "mercator",
            "meridian",
            "micromax",
            "midp",
            "mini",
            "mitsu",
            "mmm",
            "mmp",
            "mobi",
            "mot-",
            "moto",
            "nec-",
            "netfront",
            "newgen",
            "nexian",
            "nf-browser",
            "nintendo",
            "nitro",
            "nokia",
            "nook",
            "novarra",
            "obigo",
            "palm",
            "panasonic",
            "pantech",
            "philips",
            "phone",
            "pg-",
            "playstation",
            "pocket",
            "pt-",
            "qc-",
            "qtek",
            "rover",
            "sagem",
            "sama",
            "samu",
            "sanyo",
            "samsung",
            "sch-",
            "scooter",
            "sec-",
            "sendo",
            "sgh-",
            "sharp",
            "siemens",
            "sie-",
            "softbank",
            "sony",
            "spice",
            "sprint",
            "spv",
            "symbian",
            "tablet",
            "talkabout",
            "tcl-",
            "teleca",
            "telit",
            "tianyu",
            "tim-",
            "toshiba",
            "tsm",
            "up.browser",
            "utec",
            "utstar",
            "verykool",
            "virgin",
            "vk-",
            "voda",
            "voxtel",
            "vx",
            "wap",
            "wellco",
            "wig browser",
            "wii",
            "windows ce",
            "wireless",
            "xda",
            "xde",
            "zte"
        );
    
        $is_mobile = false;
        foreach ($mobile_agents as $device) {
            if (stristr($user_agent, $device)) {
                $is_mobile = true;
                break;
            }
        }
        return $is_mobile;
    }


    public function compatibility(){
        $data['page_title'] = "Not Subscribed";
        $data['page_name'] = "compatibility";
        $data['page_header'] = "Not Subscribed";
        $data['validate_mem'] = "";
        $data['pquests'] = "";
        $this->load->view("error", $data);
    }



    public function centres(){
        if($this->compatibility_issues()) redirect('compatibility');

        $sources = $this->uri->segment(2); // past questions
        $data['page_title'] = "Centres";
        $data['page_name'] = "centres";
        $data['test_boards'] = $this->test_boards;
        $data['param1'] = "";

        $record=0;
        $recordPerPage = 30;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }

        $ipaddrs = $_SERVER['REMOTE_ADDR'];
        $mylocs = $this->sql_models->getMyLoc($ipaddrs);
        $recordCount = $this->sql_models->getDataCount('centres cntr', '', '', '', '');

        $config['base_url'] = base_url().'node/centre';
        $config['use_page_numbers'] = TRUE;
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['total_rows'] = $recordCount;
        $config['per_page'] = $recordPerPage;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['centres'] = $this->sql_models->fetchCentres('centres cntr', '', '', '', $record, $recordPerPage, $mylocs['statee'], $mylocs['citys'], '');
        $data['fetchStates'] = $this->sql_models->fetchStates('160');
        $data['mylocs'] = $mylocs;
        $data['pq_count'] = $recordCount;
        $data['sources'] = $sources;
        $this->load->view("header", $data);
        $this->load->view("resources", $data);
        $this->load->view('footer', $data);
    }




    public function centre($record=0){
        $param1 = "pages";
        $recordPerPage = 30;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }       
        $recordCount = $this->sql_models->fetchEventsCount();
        $empRecord = $this->sql_models->fetchEvents('', '', $record, $recordPerPage);

        /////////////////////////
            $config['base_url'] = base_url().'node/media';
            $config['use_page_numbers'] = TRUE;
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Previous';
            $config['total_rows'] = $recordCount;
            $config['per_page'] = $recordPerPage;

            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination event_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            //$config['next_link'] = '<a href="javascript:;" class="pagination-next"><span>Next page</span> <i class="icon-right-4"></i></a>';
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            //$config['prev_link'] = '<a href="javascript:;" class="pagination-prev"><i class="icon-left-4"></i> <span>PREV page</span></a>';
            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
        /////////////////////////

        if($empRecord){
        foreach ($empRecord as $rs) {
            $id = $rs['id'];
            $titles = strtolower($rs['titles']);
            $titles = ucwords($titles);
            $titles1 = $titles;
            $descrip = ucfirst($rs['descrip']);
            $views = $rs['views'];
            $dates = $rs['dates'];
            $mydates = date("jS F, Y", strtotime($dates));
            $views = @number_format($views);
            $files = $this->sql_models->getPics($id);
            $cmts_counts = $this->sql_models->fetchCommentCounts($id);
            if(strlen($descrip)>110)
                $descrip = substr($descrip, 0, 110)."...";

            if(strlen($titles)>70)
                $titles = substr($titles, 0, 70)."...";

            $pic_path = base_url()."watermark.php?image=".base_url()."events_fols/$files&watermark=".base_url()."images/watermrk.png";

            if($param1!="pages"){
                $directs = base_url()."pages/#viewevents";
                $directs1 = "pages/#viewevents";
            }else{
                $directs = "javascript:;";
                $directs1 = "";
            }
        ?>
            <div class="col-md-6 col-sm-12 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="blog-right-listing blog-right-listing2">
                    <font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer; position:relative; z-index:99">
                        <div class="feature-img feature-img1">
                            <img src="<?=$pic_path;?>" alt="Image loading...">
                        </div>
                    </font>
                    <div class="event_date"><label><?=$mydates;?></label></div>
                    <div class="feature-info feature-info1">
                        <h5><font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer;"><?=$titles;?></font></h5>
                        <p><?=$descrip;?> <a href="<?=$directs;?>" class="open_event" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="font-weight:normal; color:#0CF;">read more<i class="icon-right-4"></i></a></p>
                        <p class="statss">
                        <?php
                        if($cmts_counts>0)
                        echo "<span><i class='icon-comment-5'></i> $cmts_counts Comments</span>";
                        else
                        echo "<span style='opacity:0.7;'><i class='icon-comment-5'></i> No Comments</span>";

                        if($views>0)
                        echo "<span><i class='icon-eye-6'></i> $views Views</span>";
                        else
                        echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> No Views</span>";
                        ?>

                        </p>
                        <!-- <a href="blog_single.html" class="button-default">View More <i class="icon-right-4"></i></a> -->
                    </div>
                </div>
            </div>

        <?php 
        }
        }else{
            echo "<p style='text-align:center; font-size:16px;'>No media found!</p>";
        }
        ?>
        <div style="clear:both"></div>
        
        <?=$pagination;?>

        <?php
    }




    public function resources(){
        if($this->compatibility_issues()) redirect('compatibility');

        $sources = $this->uri->segment(2); // past questions
        $keywords = $this->uri->segment(3); // searched word
        $keywords = str_replace(array("%20", "-"), " ", $keywords);
        $sources1 = ucwords(str_replace("-", " ", $sources));

        $data['media'] = $this->sql_models->fetchPastQuestions($sources, '', '', 0);
        $data['pq_count'] = $this->sql_models->fetchPastQuestionsCounts('past-questions', '', '', 0);
        $data['pq_count1'] = $this->sql_models->fetchPastQuestionsCounts('tutorial-videos', '', '', 0);

        $data['page_title'] = $sources1;
        $data['sources'] = $sources;
        $data['page_name'] = "resources";
        $data['test_boards'] = $this->test_boards;
        $this->load->view("header", $data);
        $this->load->view("resources", $data);
        $this->load->view('footer', $data);
    }




    public function view(){
        //if($this->compatibility_issues()) redirect('compatibility'); // its showing when sharing to social media
        $sources = $this->uri->segment(3); // past-question
        $bookid = $this->uri->segment(4);
        $bookid = substr($bookid, 0, -5);
        $sources1 = ucwords(str_replace("-", " ", $sources));
        $this->sql_models->updateResultViews("resources", "views", $bookid);

        $ipaddrs = $_SERVER['REMOTE_ADDR'];
        $this->sql_models->record_visitors($ipaddrs);

        $pquests = $this->sql_models->fetchPastQuestions_single($bookid);
        //if($campg || $camp_evnt=="events" || $camp_evnt=="campaign"){
            $titles = ucwords($pquests['titles']);
            if(strlen($titles)>50)
                $titles = substr($titles, 0, 50)."...";
            $data['page_title'] = "$titles";
            $data['page_title1'] = "$sources1";
            $data['pq_count'] = $this->sql_models->fetchPastQuestionsCounts('past-questions', '', '', 0);
            $data['pq_count1'] = $this->sql_models->fetchPastQuestionsCounts('tutorial-videos', '', '', 0);
            $data['pquests'] = $pquests;
            $data['page_name'] = "view";
            $data['test_boards'] = $this->test_boards;
            $this->load->view("header", $data);
            $this->load->view("page_single", $data);
            $this->load->view('footer', $data);
        // }else{
        //     redirect('');
        // }
    }



    public function getMoreRecords(){
        $page = $this->input->post('page');
        $sources = $this->input->post('txtsources');
        $media = $this->sql_models->fetchPastQuestions($sources, '', '', $page);
        if($media){
            foreach($media as $row){
                $id = $row['id1'];
                $titles = $row['titles'];
                $img_cover = $row['img_cover'];
                $price = $row['price'];
                if($price<=0)
                    $price = "FREE";
                else
                    $price = "&#8358;".@number_format($price);
                $years = $row['years'];
                $downloads = @number_format($row['downloads']);
                $views = @number_format($row['views']);
            ?>

                <div class="col-md-4 col-sm-6 col-xs-12 p-xs-10 mb-30 mb-sm-10">
                    <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js each_div each_div1"  data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.8">
                        <a href="#">
                            <div class="for_img">
                                <img src="<?=base_url()?>resources/<?=$img_cover?>">
                            </div>
                            <div class="book_price"><?=$price?></div>
                            <div class="file_info">
                                <p class="book_name"><?=$titles?></p>
                                <p>Year: <?=$years?></p>
                                <p>Downloads: <?=$downloads?> &nbsp;&bull;&nbsp; Views: <?=$views?></p>
                            </div>
                        </a>
                    </div>
                </div>

            <?php
            }
        }else{

            if($page<=0){
                echo '<div class="col-md-12 mt-10 mb-190 mb-sm-70" style="text-align: center; color:#555; font-weight:600; line-height:24px;">No resources yet, try again next time</div>';
            }
        }
    }



    public function filterRes(){
        $page = $this->input->post('page');
        $sources = $this->input->post('txtsources');
        $keywords = $this->input->post('keywords');
        $tests = $this->input->post('tests');
        $media = $this->sql_models->fetchPastQuestions($sources, $keywords, $tests, 0);
        $pq_count1 = $this->sql_models->fetchPastQuestionsCounts('past-questions', $keywords, $tests, 0);

        $pq_countx="";
        if($sources=="past-questions"){
            $sources2 = "past questions & answers";
        }else{
            $sources2 = "tutorial videos";
            //$pq_countx = $pq_count1;
        }
        $pq_countx = $pq_count1;
        ?>
        
        <p style="margin: -20px 0 7px 0; text-align: center; color: #333;" class="font-17 font-sm-16 line-height-22 pr-10 pl-10 pr-sm-25 pl-sm-25"><b>View and download our various past questions and answers for different years and different schools</b></p>
                        
        <p style="text-align: center; font-size: 17px; color: #333 !important;" class="mb-40 mb-xs-20 mr-20_">Total of <b><?=$pq_countx?></b> <?=$sources2?> found</p>

        <?php
        if($media){
            $cnts=1;
            foreach($media as $row){
                $id = $row['id1'].substr(time(), -4).$cnts;
                $titles = ucwords($row['titles']);
                $img_cover = $row['img_cover'];
                $media_type = $row['media_type'];
                $price = $row['price'];
                if($price<=0)
                    $price = "FREE";
                else
                    $price = "&#8358;".@number_format($price);
                $years = $row['years'];
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
            ?>

                <div class="col-md-4 col-sm-6 col-xs-offset-1_ col-xs-12 p-xs-10 mb-30 mb-sm-30 mb-xs-20">
                    <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js each_div each_div1 ml-xs-15 mr-xs-15">
                        <a href="<?=base_url()?>resources/view/<?=$sources?>/<?=$id?>/">
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
                                <p>Year: <?=$years?></p>
                                <p>Downloads: <?=$downloads?> &nbsp;&bull;&nbsp; Views: <?=$views?></p>
                            </div>
                        </a>
                    </div>
                </div>

            <?php
            $cnts++;
            }
        }else{

            echo '<div class="col-md-8 mt-10 mb-190 mb-sm-70 ml-sm-180 ml-xs-0" style="text-align: center; color:#555; font-weight:600; line-height:24px;">
            No files yet, try again next time
            </div>';
        }
    }



    function findMap(){
        $id1 = $this->input->post('id1');
        $addrs = $this->input->post('addrs');
        $centre_name = $this->input->post('centre_name');
        $addrs1 = str_replace(array(" ", ","), array("%20", "%2C"), $addrs);
        $this->sql_models->updateResultViews("centres", "views", $id1);

        echo "<p class='center_title'>$centre_name</p>";
        
        echo '<div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="500" style="width:100%; height:100%" id="gmap_canvas" src="https://maps.google.com/maps?q='.$addrs1.'&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/elementor-review/">is elementor pro worth it</a></div><style>.mapouter{position:relative;text-align:right;height:100%;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}</style></div>';
        echo "<div class='test_div'>
            <div class='col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-2 col-xs-8'>
                <div class='start_test_btn close_map p-20 p-xs-15 font-16' id1='".$id1."'><i class='fa fa-power-off'></i> CLOSE MAP</div>
            </div>
        </div>";
    }





    function add_to_schs(){
        $this->form_validation->set_rules('txtschs', 'Name of School', 'required|trim|max_length[30]|alpha_space');
        $txtschs = $this->input->post('txtschs');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $details_exists = $this->sql_models->check_existing_details($txtschs, '', 'schools');
            if(!$details_exists){
                $data = array(
                    'name_of_sch'  => $txtschs
                );
                $this->db->insert('schools', $data);
                ?>

                <script src="<?=base_url();?>js/jquery-1.12.4.js" type="text/javascript"></script>
                <script src="<?=base_url();?>js/jquery.multiselect.js"></script>

                <?php $schs = $this->sql_models->fetchRecs('schools', 'id, name_of_sch');
                echo '<select name="txt_sch[]" multiple="multiple" class="3cols active form-control" id="txt_sch">';
                $selected="";
                if($schs):
                foreach($schs as $post):
                  $id = $post['id'];
                  $name_of_sch = ucwords($post['name_of_sch']);
                  ?>
                  <option value='<?=$id;?>'><?=$name_of_sch;?></option>
                <?php
                endforeach;
                endif;
                echo '</select>';
                ?>
                <script type="text/javascript">
                  $(function () {
                    $('select[multiple].active.3cols').multiselect({
                        columns: 1,
                        placeholder: '-Select School-',
                        search: true,
                        searchOptions: {
                            'default': 'Search School'
                        },
                        selectAll: true
                    });
                  });
                </script>
                <?php
            }else{
                echo "exists";
            }
        }
    }




    function add_to_subjs(){
        $this->form_validation->set_rules('txtsub', 'Subject Name', 'required|trim|max_length[30]|alpha_space');
        $txtsub = $this->input->post('txtsub');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $details_exists = $this->sql_models->check_existing_details($txtsub, '', 'schools');
            if(!$details_exists){
                $data = array(
                    'subjs'  => $txtsub
                );
                $this->db->insert('subjects', $data);
                ?>

                <?php $schs = $this->sql_models->fetchRecs('subjects', 'id, subjs');
                echo '<select name="txt_subj" id="txt_subj" class="form-control">';
                    $selected="";
                    if($schs):
                    foreach($schs as $post):
                      $id = $post['id'];
                      $subjs = ucwords($post['subjs']);
                      ?>
                      <option value='<?=$id;?>'><?=$subjs;?></option>
                    <?php
                    endforeach;
                    endif;
                echo '</select>';
            }else{
                echo "exists";
            }
        }
    }




    function submit_orders(){
        $txtlocatn = $this->input->post('txtlocatn');
        $txtwrite = $this->input->post('txtwrite');
        $pay_type = $this->input->post('pay_type');
        $has_paid = 1;
        if($pay_type=="manual"){
            $pay_type="mp";
            $has_paid = 0;
        }
        
        if($txtwrite==1)
            $this->form_validation->set_rules('txtlocatn', 'location', 'required|trim');
        $ids = $this->input->post('ids');
        $titles = ucwords($this->input->post('titles'));
        $memid = $this->memid;
        
        if($txtwrite==1 && $this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $details_exists = $this->sql_models->check_existing_details($memid, $ids, 'cart');
            if(!$details_exists){
                $data = array(
                    'memid'         => $memid,
                    'prod_id'       => $ids,
                    'paid'          => $has_paid,
                    'locatn'        => $txtlocatn,
                    'payment_type'  => $pay_type,
                    'date_posted'   => date("Y-m-d g:i a", time())
                );
                $this->db->insert('cart', $data);

                if($txtlocatn!="")
                    $txtlocatn = " with a specified location to be delivered at $txtlocatn.";

                //////////////////FOR EMAILS/////////////////////////
                    $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://testport.ng/images/logo.png'></div>";
                    $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Admin,</b></p>";
                    $message_contents .= "<p style='font-size:14px; margin-top:10px'>
                    A student ".$this->myfname." has purchased a file <b>$titles</b>$txtlocatn. Please place a call on them to confirm their purchase.
                    </p>";

                    $message_contents .= "<p style='font-size:14px; margin:20px 0 20px 0'>Thank you!</p>";
                    $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                    $message_contents .= "<a href='http://testport.ng' style='color:#0066FF' target='_blank'>http://testport.ng</a></p>";

                    $from_email = "Purchase Alert <info@testport.ng>";
                    $subj = "Purchase Alert From ".$this->myfname;

                    $message_contents1 = $this->mailHeader.$message_contents.$this->mailFooter;

                    $this->send_mail($from_email, "info@testport.ng", $this->myfname, $message_contents1, $subj);
                //////////////////FOR EMAILS/////////////////////////

                echo "submitted";
            }else{
                echo "You have already purchased this";
            }
        }
    }



    function submit_orders_verify(){
        $txtlocatn = $this->input->post('txtlocatn');
        $txtwrite = $this->input->post('txtwrite');
        $pay_type = $this->input->post('pay_type');
        
        if($txtwrite==1){
            $this->form_validation->set_rules('txtlocatn', 'location', 'required|trim');
        }
        $ids = $this->input->post('ids');
        $titles = ucwords($this->input->post('titles'));
        $memid = $this->memid;
        
        if($txtwrite==1 && $this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $details_exists = $this->sql_models->check_existing_details($memid, $ids, 'cart');
            if($details_exists){
                echo "You have already purchased this";
            }else{
                echo "verified";
            }
        }
    }




    function save_my_ansas(){
        $id_sch = $this->input->post('id_sch');
        $subject_id = $this->input->post('subject_id');
        $test_board = $this->input->post('test_board');
        $subject_id = str_replace(array("\n", " "), "", $subject_id);
        $txt_time_finished = $this->input->post('txt_time_finished');
        $ids_arr = $this->input->post('ids_arr');
        
        $my_answers = $this->session->userdata('my_answers');
        $my_answers=substr($my_answers, 0, -2);

        $quizid = $this->session->userdata('quizid');
        $quizid=substr($quizid, 0, -1);

        $answers = explode('||', $my_answers);
        $ids = explode(',', $quizid);

        $sums=0;
        foreach($ids as $index=>$ids1){
            $mem_ans = $answers[$index];
            if($this->sql_models->computeScores($ids1, $mem_ans)){
                $sums+=1;
            }
        }

        $total_question = $this->sql_models->totlQuestions($subject_id, $test_board, $ids_arr); 

        if($total_question>0){
            $total_score = $sums/$total_question; // 4/6  i scored 4 = 0.66

            $total_score1 = $total_score*100; // 0.66 * 100 = 66.6  
            $total_score1 = round($total_score1);
            if($total_score1 < 0) $total_score1=0;
        }else{
            $total_score1=0;   
        }

        // echo "subject_id $subject_id<br>";
        // echo "test_board $test_board<br>";
        // echo "ids_arr $ids_arr<br><br>";

        // echo "total_question $total_question<br>";
        // echo "total_score1 $total_score1<br>";
        // echo "sums $sums<br>";
        // exit;

        $newdata3 = array(
            'memid'             => $this->memid,
            'quizintro_id'      => $id_sch,
            'subject_id'        => $subject_id,
            'answers'           => $my_answers,
            'ids'               => $quizid,
            'time_finished'     => $txt_time_finished,
            'scores'            => $total_score1,
            'date_taken'        => time()
        );
        $this->sql_models->insert_scores($newdata3);

        $newdata5 = array(
            'my_answers'    => "",
            'quizid'        => "",
            'allRandIDs'    => ""
            
        );
        $this->session->set_userdata($newdata5);
        echo "recorded";
    }



    public function contact(){
        if($this->compatibility_issues()) redirect('compatibility');
        $data['page_title'] = "Contact Us";
        $data['page_name'] = "contact";
        $data['test_boards'] = $this->test_boards;
        $this->load->view("header", $data);
        $this->load->view("contact", $data);
        $this->load->view('footer', $data);
    }


    public function tests(){
        if($this->compatibility_issues()) redirect('compatibility');
        $test_type = $this->uri->segment(2);
        $test_type_f = strtoupper(str_replace("-", " ", $test_type));
        $this->sql_models->updateResultViews("test_boards", "views", $test_type_f);
        $data['page_title'] = $test_type_f;
        $data['test_logo'] = $test_type;
        $data['page_name'] = "tests";
        $data['test_boards'] = $this->test_boards;
        
        $data['test_subj'] = $this->sql_models->fetchSubjs($test_type);
        $data['test_sch'] = $this->sql_models->fetchColleges($test_type);
        $this->load->view("header", $data);
        $this->load->view("tests", $data);
        $this->load->view('footer', $data);
    }

    


    function delete_images(){
        $ids = $this->input->post('ids');
        $files = $this->input->post('files');
        
        $this->db->select('id')->from('blog_media')->where('id', $ids);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            
            $in_folder1="blogs/".$files; // delete the image in the fake folder
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('id', $ids);
            $this->db->delete('blog_media');
            echo "deleted";
        }else{
            echo "error";
        }
    }




    public function about(){
        if($this->compatibility_issues()) redirect('compatibility');
        $data['page_title'] = "About Us";
        $data['page_name'] = "about";
        //$data['page_header'] = "About <font>Us</font>";
        $data['test_boards'] = $this->test_boards;
        $this->load->view("header", $data);
        $this->load->view("about", $data);
        $this->load->view('footer', $data);
    }

    
    public function reset_password(){
        if($this->compatibility_issues()) redirect('compatibility');
        $data['page_title'] = "Reset Password";
        $data['page_name'] = "reset_password";
        $data['test_boards'] = $this->test_boards;
        $this->load->view("header", $data);
        $this->load->view("reset_password", $data);
        $this->load->view('footer', $data);
    }


    public function forum(){
        if($this->compatibility_issues()) redirect('compatibility');
        $data['page_title'] = "Discussion";
        $data['page_name'] = "forum";
        $data['test_boards'] = $this->test_boards;
        $data['t_mems'] = $this->sql_models->countArrayDataForum('forums', 'memid', '');
        $data['t_thread'] = $this->sql_models->countArrayDataForum('forums', 'id', '');
        $data['t_media'] = $this->sql_models->countArrayDataForum('forums', 'memid', 'medias');
         $data['t_discu'] = $this->sql_models->countArrayDataForum('stud_ans', 'memid', 'topics');
         $data['last_post'] = $this->sql_models->lastPost('forums frm');

        $this->load->view("header", $data);
        $this->load->view("forum", $data);
        $this->load->view('footer', $data);
    }



    function display_cities(){
        $txtcountry = $this->input->post('country_id');
        $this->db->select('*')->from('states')->where('country_id', $txtcountry);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $fetch_data = $query->result_array();
            echo '<option value="" selected>-Select State-</option>';
            foreach($fetch_data as $row)
            {
                $ids1 = $row['id'];
                $cities = ucwords($row['name']);
                echo "<option value='$ids1'>$cities</option>";
            }
        }else{
            echo "";
        }
    }



    function post_comments_forum(){
        $this->form_validation->set_rules('txtcats', 'category', 'required|trim');
        $this->form_validation->set_rules('post_content', 'comment', 'required|trim');
    
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $txtmemsid = $this->input->post('txtmemsid');
            $txtcats = $this->input->post('txtcats');
            $post_content = $this->input->post('post_content');
            $former_file = $this->input->post('former_file1');
            $edit_ids = $this->input->post('edit_ids');
            
            if($txtmemsid!=""){ // if member id is not empty
                        
                $path4 = @$_FILES['file4']['name'];
                $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');

                if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['file4']['name']) && @$_FILES['file4']['name'] != "")
                    echo "Please select a valid image of the formats jpg, jpeg or png<br>";
                else if(isset($_FILES['file4']['name']) && @$_FILES['file4']['size'] > 4194304)
                    echo "Your profile photo has exceeded 4MB<br>";
                else{
                    $randm = time();
                    $rename_file = "$randm.$ext4";
                    
                    $url_source = "fake_fols/".$rename_file;
                    $url_dest = "forum_files/".$rename_file;
                    
                    $new_name4 = $rename_file;
                    if(isset($_FILES['file4']['name']) && @$_FILES['file4']['name'] != ''){
                        $file_tmp = @$_FILES["file4"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['file4']['name']) ){
                            if($edit_ids != "")
                                $this->sql_models->delete_forum_pics($former_file);

                            move_uploaded_file($file_tmp, $url_source);
                            $d = $this->compress($url_source, $url_dest, 40);
                        }

                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);


                        if($edit_ids==""){
                            $newdata3 = array(
                                'memid'      => $txtmemsid,
                                'topics'     => $txtcats,
                                'messages'   => $post_content,
                                'files'      => $new_name4,
                                'views'      => 0,
                                'dates'      => @date("Y-m-d g:i a", time())
                            );

                        }else{
                            $newdata3 = array(
                                'topics'     => $txtcats,
                                'messages'   => $post_content,
                                'files'      => $new_name4,
                            );
                        }

                    }else{ // image not set
                        if($edit_ids==""){
                            $newdata3 = array(
                                'memid'      => $txtmemsid,
                                'topics'     => $txtcats,
                                'messages'   => $post_content,
                                'views'      => 0,
                                'dates'      => @date("Y-m-d g:i a", time())
                            );

                        }else{
                            $newdata3 = array(
                                'memid'      => $txtmemsid,
                                'topics'     => $txtcats,
                                'messages'   => $post_content
                            );
                        }
                    }

                    //$newdata3 = $this->security->xss_clean($newdata3);
                    $querys1 = $this->sql_models->update_insert_forum($newdata3, $edit_ids);
                    echo $querys1;
                }
            }else{
                echo "Posting comment has failed, please login.";
            }
        }
    }


    
    function post_comments_rep(){
        $this->form_validation->set_rules('post_content_rep', 'reply', 'required|trim');
    
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $txtmemsid = $this->input->post('memid_rep');
            $post_content = $this->input->post('post_content_rep');
            //$former_file = $this->input->post('former_file1');
            $edit_ids = $this->input->post('fr_ids');
            
            if($txtmemsid!=""){ // if member id is not empty
                        
                $path4 = @$_FILES['file4_rep']['name'];
                $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');

                if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['file4_rep']['name']) && @$_FILES['file4_rep']['name'] != "")
                    echo "Please select a valid image of the formats jpg, jpeg or png<br>";
                else if(isset($_FILES['file4_rep']['name']) && @$_FILES['file4_rep']['size'] > 4194304)
                    echo "Your profile photo has exceeded 4MB<br>";
                else{
                    $randm = time();
                    $rename_file = "$randm.$ext4";
                    
                    $url_source = "fake_fols/".$rename_file;
                    $url_dest = "forum_files/".$rename_file;
                    
                    $new_name4 = $rename_file;
                    if(isset($_FILES['file4_rep']['name']) && @$_FILES['file4_rep']['name'] != ''){
                        $file_tmp = @$_FILES["file4_rep"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['file4_rep']['name']) ){
                            //if($edit_ids != "")
                                //$this->sql_models->delete_forum_pics($former_file);

                            move_uploaded_file($file_tmp, $url_source);
                            $d = $this->compress($url_source, $url_dest, 40);
                        }

                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        $newdata3 = array(
                            'memid'      => $txtmemsid,
                            'forum_id'   => $edit_ids,
                            'replies'    => $post_content,
                            'files'      => $new_name4,
                            'dates'      => @date("Y-m-d g:i a", time())
                        );

                    }else{ // image not set
                        $newdata3 = array(
                            'memid'      => $txtmemsid,
                            'forum_id'   => $edit_ids,
                            'replies'    => $post_content,
                            'files'      => "",
                            'dates'      => @date("Y-m-d g:i a", time())
                        );
                    }

                    //$newdata3 = $this->security->xss_clean($newdata3);
                    $querys1 = $this->sql_models->update_insert_forum_reply($newdata3, $edit_ids);
                    echo $querys1;
                }
            }else{
                echo "Posting comment has failed, please login.";
            }
        }
    }



    public function getForums(){
        $page = $this->input->post('page');
        $txtsrch_test = $this->input->post('txtsrch_test');
        $txtsrch = $this->input->post('txtkeywd1');
        $txtmemsid = $this->memid;
        
        $forums = $this->sql_models->fetchForum($page, $txtsrch, $txtsrch_test);
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

                            //https://rwbuildingmaterials.com/testportdemos_x/watermark.php?image=https://rwbuildingmaterials.com/testportdemos_x/forum_files/1579196566.jpg&watermark=https://rwbuildingmaterials.com/testportdemos_x/images/watermrk.png
                        ?>



                        <div class="row_contents">
                            <?php if($files!=""){ ?>
                                <div class="cmt_img col-md-3 col-sm-12 col-xs-12 img_forum" style="backgrounds:blue">
                                    <span class="open_comment" frid="<?=$id1;?>" tils="<?=$ttls;?>"><img src='<?=$pic_path;?>' alt='image'></span>
                                </div>
                                <div class="cmt_note_ col-md-9 col-sm-12 col-xs-12 containerx" style="backgrounds:red; line-height:20px;">
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
                        $picsi = base_url()."images/no_passport.jpg";
                        $datesi = $forums_rp['dates'];
                        if(strlen($replies)>90)
                            $replies = substr($replies, 0, 90)."...read more";
                        $mydatesi= date("jS F, Y h:i a", strtotime($datesi));
                        ?>
                            <div class="small_comments">
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <img src='<?=$picsi;?>' alt='image' style='border-radius:30px; border:1px #999 solid;'>
                                </div>

                                <div class="col-md-10 col-sm-11 col-xs-11">
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
    }



    function delete_post(){
        $post_id = $this->input->post('post_id');
        $type1 = $this->input->post('type1');
        if($this->sql_models->deleteFrmPost($post_id, $type1))
            echo "deleted";
        else
            echo "error";
    }



    public function getForums_reps(){
        $page = $this->input->post('page');
        $fr_ids = $this->input->post('fr_ids');
        $txtmemsid = $this->input->post('txtmemsid');
        $forums = $this->sql_models->fetchForumRep($page, $fr_ids);
        if($forums){
            $j=1;
            foreach ($forums as $row) {
                $id1i = $row['id'];
                $conid = $row['conid'];
                $fnamei = ucwords($row['names']);
                $replies = nl2br($row['replies']);
                $repliesi=$replies;
                $filesi = $row['files'];
                $picsi = base_url()."images/no_passport.jpg";
                $datesi = $row['dates'];
                $pic_pathi = base_url()."watermark.php?image=".base_url()."forum_files/$filesi&watermark=".base_url()."images/watermrk.png";

                if(strlen($fnamei)>14)
                    $fnamei_mobile = substr($fnamei, 0, 14)."...";
                else
                    $fnamei_mobile = $names;
            ?>
                <div class="small_comments small_comments1 forumBox3 forum_rep<?=$id1i.$j;?>" ids="<?=$id1i.$j;?>">
                    <div class="col-md-1 col-sm-2 col-xs-2 forum_img">
                        <img src='<?=$picsi;?>' alt='image' style='border-radius:30px; border:1px #999 solid;'>
                    </div>

                    <div class="col-md-11 col-sm-10 col-xs-10" style="line-height:20px;">
                        <div class="for_dates_1">
                            <p class="pss nofadediv fadediv<?=$id1i.$j;?>" style="font-size:14px; text-align:left; color:#009900; margin:-6px 0 0px 7px !important">
                                <!-- <b><a href="javascript:;" style="color:#009900;"><?=$fnamei;?></a></b> -->
                                <b>
                                    <a href="javascript:;" class="for_desktop1" style="color:#009900;"><?=$fnamei;?></a>

                                    <a href="javascript:;" class="for_mobile1" style="color:#009900;"><?=$fnamei_mobile;?></a>
                                </b>
                                <font style="color:#333; font-size:13px;">@ <?=time_ago($datesi);?></font>
                            </p>
                            
                            <?php if($conid==$txtmemsid){ ?>
                                <p class="menu_icn1" id="menu_icn1" style="margin:0 0 3px 0 !important" ids="<?=$id1i.$j;?>"><img src="<?=base_url()?>images/menu_icon1.png" style="position:relative; top:2px;"></p>
                            <?php }else{ ?>
                                <p class="menu_icn1" style="margin:0 0 3px 0 !important">&nbsp;</p>
                            <?php } ?>

                            <?php if($conid==$txtmemsid){ ?>
                                <div class="edit_div edit_divi" id="edit_div1<?=$id1i.$j;?>">
                                    <span style='border:none; color:red; cursor:pointer' id='delpost2' ids="<?=$id1i;?>" ids2="<?=$id1i.$j;?>"><a href='javascript:;' style='color:red;'>Delete this post &raquo;</a></span>
                                </div>
                            <?php } ?>

                            <div style="clear:both"></div>

                            <div class="img_descr">
                                <?php if($filesi!=""){ ?>
                                    <div class="cmt_img cmt_desc1 col-md-3 col-sm-12 col-xs-12 nofadediv fadediv<?=$id1i.$j;?>">
                                        <span class="open_comment_"><img src='<?=$pic_pathi;?>' alt='image'></span>
                                    </div>

                                    <div class="cmt_desc mt-10 col-md-9 col-sm-12 col-xs-12 nofadediv fadediv<?=$id1i.$j;?>">
                                        <span><?=makeLinks2(ucfirst($replies));?></span>
                                    </div>
                                <?php }else{ ?>

                                    <div class="cmt_desc col-md-9 col-sm-12 col-xs-12 nofadediv fadediv<?=$id1i.$j;?>">
                                        <span><?=makeLinks2(ucfirst($replies));?></span>
                                    </div>
                                <?php } ?>
                                <label id='copyTarget<?=$id1i.$j;?>' style='display:none'><?=makeLinks2(ucfirst($repliesi));?></label>
                                <div class="cover_contents" id="cover_contents<?=$id1i.$j;?>"></div>
                                <div class="copy_text" ids='<?=$id1i.$j;?>' id="copy_text<?=$id1i.$j;?>"><spans>Copy Text</spans></div>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <div style="clear:both"></div>

            <?php
            $j++;
            }
            ?>
        
        <?php
        }else{
            echo "<p style='font-size:16px; text-align:center; color:#333; padding-top:15px'>No reply found on this post.</p>";
        }
    }



    function show_my_answers(){
        $id_sch = $this->input->post('id_sch');
        $ids_arr = $this->input->post('ids_arr');
        $subject_id = $this->input->post('subject_id');
        $getSubs = $this->sql_models->getDetls($id_sch, $ids_arr, $subject_id, 'subjs');
        $getTests = $this->sql_models->getDetls($id_sch, '', '', '');
        //print_r($getTests); exit;
        $getTestB = $getTests['test_types'];
        $test_board_id = $getTests['test_board'];

        $time_finished = $getTests['time_finished'];
        $scores = $getTests['scores'];

        if($scores=="") $scores=0;

        $mins1 = round($time_finished/60);
        $time_finished1 = $mins1." minutes";

        // echo "$getTestB<br>";
        // echo "$test_board_id<br>";
        // echo "$time_finished<br>";
        // echo "$scores<br>";
        // echo "$time_finished1<br>";
        ?>

        <p style="font-size:25px; line-height: 25px !important;"><b style="color:#9FCFFF; font-weight: bold;">My Performance Details</b></p>

        <p style="color: #9FCFFF; font-size: 17px; margin-top: -6px" class="stats_per">
            <b>Test Board:</b> <?=$getTestB?> <br> 
            <b>Subject:</b> <?=ucwords($getSubs)?><br>
            <b>Scores:</b> <?=$scores?>%<br>
            <b>Finished in:</b> <?=$time_finished1?>
        </p>

        <div class="table_responsive"></div>

        <?php
        $myPerform=$this->sql_models->showMyPerformanceTbl2($id_sch, $subject_id, $this->memid, $test_board_id);

        //print_r($myPerform);

        $ids = $myPerform['ids'];
        $ids_1 = $ids;
        $answers = $myPerform['answers'];

        $ids = explode(',', $ids);
        $answers = explode('||', $answers);

        $ids = array_unique($ids);
        $answers = array_unique($answers);

        // echo "<br><br>";
        // print_r($answers);

        $myanswers = "<div class=''><table class='table table-bordered tables_2' id='tables_2' style='border:none !important'>";
            if($ids && $ids_1>0){
                foreach($ids as $index=>$ids1){
                    $mem_ans = @$answers[$index];
                    $get_quiz_origin = $this->sql_models->getQuizOrigin($ids1);
                    if($get_quiz_origin){
                        $questions = $get_quiz_origin['questions'];
                        $ans1 = $get_quiz_origin['ans1'];
                        $explanations = $get_quiz_origin['explanations'];

                        $op1 = $get_quiz_origin['op1'];
                        $op2 = $get_quiz_origin['op2'];
                        $op3 = $get_quiz_origin['op3'];
                        $op4 = $get_quiz_origin['op4'];

                        $op1_1=$op1;
                        $op1_2=$op2;
                        $op1_3=$op3;
                        $op1_4=$op4;

                        $all_options = array($op1, $op2, $op3, $op4);
                        if($op1!="" && $op2!="" && $op3=="" && $op4=="") $all_options = array($op1, $op2);
                        if($op1!="" && $op2!="" && $op3!="" && $op4=="") $all_options = array($op1, $op2, $op3);

                        if($explanations=="") $explanations="<i style='color:#555;'>None</i>";

                        $counts1 = $index+1;

                        $mem_ans1="";
                        if($mem_ans=="")
                            $mem_ans1="<label style='font-size:15px; background:#f7f7f7; padding:1px 6px; border-radius:3px; color:#FF5E5E'>Not Answered</label>";
                        ?>

                        <tr><td>

                            <?php $questions = str_replace(array('<p>', '</p>'), "", $questions); $questions = ucfirst($questions); ?>

                            <div class='quiz_question quiz_question1'>
                                <p style='font-size:16px; line-height:23px; color:#ddd; font-weight: 600;'><?=$counts1?>. <?=nl2br($questions);?> <?=$mem_ans1?></p>
                            </div>

                        <?php
                        $k=1;
                        foreach($all_options as $keys){
                            if($k == 1) $m="<b>A)</b>";
                            else if($k == 2) $m="<b>B)</b>";
                            else if($k == 3) $m="<b>C)</b>";
                            else $m="<b>D)</b>";
                            $keys1 = ucfirst($keys);
                            $ticks="";$colors="";

                            if(strtolower($keys1) == strtolower($mem_ans)){
                                $ticks = "<img src='".base_url()."images/wrong.png' style='width:14px!important'>";
                                $colors = "color:#FF9797;";
                            }

                            if(strtolower($keys1) == strtolower($ans1)){
                                $ticks = "<img src='".base_url()."images/tick2.png' style='width:14px!important'>";
                                $colors = "color:#6F6;";
                            }

                            ?>
                            <label class='perf_options'><b><?=$m?></b> 
                                <font style="<?=$colors?>"><?=$keys1?></font>
                                <?=$ticks?>
                            </label>

                        <?php
                        $k++;
                        }
                        ?>
                        <p class="explains"><b>Explanations:</b> <?=$explanations;?></p>
                        <tr><td>

                        <?php
                    }
                }
            }else{
                $myanswers .= "<tr style='background:none !important; border:none !important'><td colspan='6' style='text-align:center; border:none !important; color:#ccc !important'>No result found or you didn't pertake on any test!</td></tr>";
            }
        $myanswers .= "</table></div>";
        echo $myanswers;
        ?>



        <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-12 mt-30 mb-sm-50">
            <div class="nxt_btn_div">
                <div class="start_test_btn done_btn cmd_back2 p-15 p-sm-15 font-17" id_sch="<?=$id_sch;?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>">DONE!</div>
            </div>
        </div>

        <?php
    }



    function filterCentres(){
        $keywords = $this->input->post('keywords');
        $locs = $this->input->post('locs');
        $wholesearch = $this->input->post('wholesearch');

        $cap1="";$cap2="";
        if($keywords!="") $cap1 = " $keywords ";
        if($locs!="") $cap2 = " $locs ";

        $ipaddrs = $_SERVER['REMOTE_ADDR'];
        $mylocs = $this->sql_models->getMyLoc($ipaddrs);
        //$recordCount = $this->sql_models->getDataCount('centres cntr', $mylocs['statee'], $mylocs['citys'], $keywords, $locs);
        $recordCount = $this->sql_models->getDataCount('centres cntr', '', '', $keywords, $locs);
        $centres = $this->sql_models->fetchCentres('centres cntr', '', $keywords, $locs, 0, 30, '', '', $wholesearch);
        
        echo '<p style="margin: 0px 0 30px 0; text-align: center; font-size: 16px; color: #444;">Total of <b>'.$recordCount.'</b> centres found in your location</p>';

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
                <div class="col-md-4 col-sm-6 mb-40 mb-sm-20 custom-height custom-height-sm scrollhere<?=$id?>">
                    <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js each_div">
                        <p class="topics font-18"><?=$test_types?></p>
                        <div class="row divContent">
                            <div class="col-md-12 line-height-20 pt-5 font-17" style="color: #069">
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
        }else{

            $ipaddrs = $_SERVER['REMOTE_ADDR'];
            $mylocs = $this->sql_models->getMyLoc($ipaddrs);
            $mycity1="";
            $mystate=$mylocs['statee'];
            $mycity=$mylocs['citys'];
            if($mycity!="") $mycity1="$mycity, ";
            if($mycity==$mystate)
                $mylocs=$mystate;
            else
                $mylocs = $mycity1.$mystate;
            $mylocs = "No centres found at your location $mylocs, try selecting another location";

            if($locs != "")
                $mylocs = "No centres found at $locs yet, try selecting another location";


            echo '<div class="col-md-12 mt-10 mb-190 mb-sm-70" style="text-align: center; color:#555; font-weight:600; line-height:24px;">'.$mylocs.'</div>';
        }
    }
    


    function display_subjects(){
        $colleges = $this->input->post('colleges');
        $test_logo = $this->input->post('test_logo');
        $test_board = $this->input->post('test_board1');

        $this->db->select('qi.id as id1, subj.subjs, sch.sch_logo, subj.id, qi.test_board, qi.subject_id, qi.name_of_sch')->from('quizes qi')->where('sch.name_of_sch', $colleges);
        $this->db->join('subjects subj', 'subj.id = qi.subject_id');
        $this->db->join('schools sch', 'sch.id = qi.name_of_sch');
        
        $this->db->order_by('sch.name_of_sch', 'asc');
        $this->db->group_by('qi.subject_id', 'asc');
        $query = $this->db->get();
        $fetch_data = $query->result_array();
        $memids = $this->memid;
        $test_board2 = $test_logo;


        $results = "<div class='' style='margin:30px 0 50px 0 !important;'>";
        if($fetch_data){
            $results .= "<div style='clear:both;'></div>";
            $results .= '<ul class="ks-cboxtags">';
            $results .= "<p class='font-17' style='margin_: 0em 0 22px 0; line-height:20px;'>Select more than one subject and click on the start button</p>";
            foreach($fetch_data as $row){
                $id = $row['id'];
                $subjs = $row['subjs'];
                $sch_logo = $row['sch_logo'];
                $subject_id = $row['subject_id'];
                $name_of_sch = $row['name_of_sch'];
                
                $noOfQuest = $this->sql_models->countQuiz2($subject_id, $test_board, $name_of_sch);

                $results .= "<li><input type='checkbox' id1='$id' id='checkbox$id' value='$subjs'><label for='checkbox$id'>$subjs ($noOfQuest)</label></li>";
            }
            $results .= '</ul>';
            $results .= "<div style='clear:both;'></div>";
            $results .= "<div class='selecteds pr-70 pl-70 pr-sm-0 pl-sm-0 pb-10'>ddd</div>";
            //$results .= "<div clear='clearfix'></div>";
            
            if($this->auths){
                $results .= '<div class="start_test_btn_1 start_tests_proceed php_login mt-30 mb-10" style="margin-bottom:-20px;" subjects="" isSubjects="1" memid="'.$memids.'" test_board2="'.$test_board2.'" name_of_sch="'.$name_of_sch.'">PROCEED <i class="fa fa-arrow-right"></i></div>';
            }else{
                $results .= '<div class="start_test_btn_1 no_start_tests php_login mt-30 mb-10" style="margin-bottom:-20px;" isSubjects="1">PROCEED <i class="fa fa-arrow-right"></i></div>';
            }

            $results .= '<div class="start_test_btn_1 start_tests_proceed java_login_show mt-50 mb-10" style="margin-bottom:-20px; display:none" subjects="" isSubjects="1" memid="'.$memids.'" test_board2="'.$test_board2.'" name_of_sch="'.$name_of_sch.'">PROCEED <i class="fa fa-arrow-right"></i></div>';

            $logos = $sch_logo;

        }else{
            if($colleges=="aaaaa"){
                $results .= '<div class="mt-20 mb-70 mt--sm-30 mb-sm-40 sch_contents" style="text-align: center;"><span style="text-align: center; clear: both;">
                    <span style="color: #444 !important; display: block; margin: 10px 0 110px 0; line-height: 22px;">Select your university above and click search</span></div>';
            }else{
                $results .= '<div class="col-md-12 mt-10 mb-190 mb-sm-70" style="text-align: center; color:#555; font-weight:600; line-height:24px;">
                 No subjects on this '.$colleges.' yet, try again next time
                 </div>';
             }
             //$arrs = array('logos'=>'', 'msg'=>$results);
             $logos = "";
        }
        $results .= '</div>';

        $arrs = array('logos'=>$logos, 'msg'=>$results);
        echo json_encode($arrs);
    }




    function display_subject_details(){
        $ids = $this->input->post('ids');
        $id2 = $this->input->post('id1');  // subj_ids
        $test_board2 = $this->input->post('test_board2');
        $txtcollege1 = $this->input->post('txtcollege1');
        $subject_id = $this->input->post('subject_id');
        $name_of_sch2 = $this->input->post('name_of_sch');
        $test_board_id = $this->sql_models->fetctBoardID($test_board2);

        $selected_subjs = trim($this->input->post('selected_subjs'));
        $counts = $this->input->post('counts');
        $selected_subjs1 = str_replace(" ", "_", $selected_subjs);
        $selected_subjs2 = $selected_subjs;

        if($test_board2!="n-power")
            $test_board3 = str_replace("-", " ", $test_board2);
        else
            $test_board3 = $test_board2;
        //$test_board3 = strtoupper($test_board3);
        
        if($ids=="arrays")
            $results = $this->sql_models->fetctSubjDets($ids, $id2, $test_board_id, $name_of_sch2);
        else
            $results = $this->sql_models->fetctSubjDets($ids, $subject_id, $test_board3, $name_of_sch2);
        if($results){
            $id1 = $results['id1'];
            if($ids=="arrays")
                $name_of_sch = $results['name_of_sch'];
            else
                $name_of_sch = "";
            $name_of_sch1 = $results['name_of_sch1'];

            if(isset($name_of_sch)){
                if($txtcollege1!="")
                    $schsx = "<p><b>School Selected:</b>".ucwords($txtcollege1)."</p>";
                else
                    $schsx = "";
            }else{
                $schsx = "";
            }
            $instructn = ucfirst($results['instructn']);
            $set_time = $results['set_time'];
            $subject_id = $results['subject_id'];
            $test_types = $results['test_types'];

            if($ids!="arrays"){
                $test_board = $results['test_board'];
                //$test_types = $test_types;
            }else{
                $test_board = $test_board_id;
                $test_types = $test_board3;
                $subject_id = $id2;
            }

            
            $noOfQuest = $this->sql_models->countRecs('quizes2', $id1, $subject_id, $test_board, $ids, $name_of_sch2);
            $noOfYrs = $this->sql_models->fetchSubjYears($subject_id, $ids, $test_board, $name_of_sch2);

            ?>

            <input type="hidden" class="txtsubjid" value="<?=$subject_id?>" />
            <!-- <input type="hidden" class="txttest_board" value="<?=$test_board?>" /> -->
            <input type="hidden" class="txttest_board" value="<?=$test_board?>" />

            <div class="container p-20 p-sm-0 pr-sm-5 pl-sm-5 mt-10 text-black-222 font-17">
                <div class="col-md-4 col-sm-5 p-5 subjDetails">
                    <div class="font-22 mb-5" style="color: #093"><b>Subject Details</b></div>

                    <div class="gdlr-core-divider-item gdlr-core-divider-item-normal gdlr-core-left-align">
                        <div class="gdlr-core-divider-container" id="div_983a_5">
                            <div class="gdlr-core-divider-line gdlr-core-skin-divider" id="div_983a_6"></div>
                        </div>
                    </div>
                    
                    <p class="welcome_name font-18 font-sm-18"><b>Welcome </b> <label style="color: #06C;"><?=ucwords($this->myfname)?></label></p>
                    <p><b>Test Type: <font style="color: #06C" class="subdt"><?=strtoupper($test_types)?></font></b></p>
                    <p><b>Subject Selected:</b><br> <label style="color: #06C"><?=$selected_subjs2?></label></p>
                    <?=$schsx?>
                    <div class="">
                        <b>Select Year:</b>
                    </div>

                    <div class="gdlr-core-course-form col-md-9 col-xs-9 pr-0 pl-0">
                        <div class="gdlr-core-course-form-combobox txtcollege">
                            <select class="gdlr-core-skin-e-content" name="txtyears" id="txtyears" ids_arr="<?=$ids?>" name_of_sch="<?=$name_of_sch1?>">
                                <option value='rand' selected="">Random</option>
                                <?php
                                if($noOfYrs){
                                    foreach($noOfYrs as $row){
                                        $years = ucwords($row['years']);
                                        echo "<option value='$years'>$years</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix mb-20"></div>

                    <input type='hidden' id='txt_no_of_quests' name='txt_no_of_quests' value='<?=$noOfQuest;?>'>

                    <p><b>Total Questions:</b> <span class="no_of_quests"><?=$noOfQuest?></span></p>
                    <p><b>Duration:</b> <?=$set_time?> mins</p>
                    <p><b>Time Remaining:</b> <font id='tminus_2' style="font-weight: bold;"><?php echo "$set_time minutes"; ?></font></p>
                </div>

                <div class="col-md-8 col-sm-7 font-16 mt-sm-0 mt-xs-30">
                    <div class="font-22 mb-5" style="color: #093"><b>Instructions</b></div>
                    <div class="gdlr-core-divider-item gdlr-core-divider-item-normal gdlr-core-left-align">
                        <div class="gdlr-core-divider-container" id="div_983a_5">
                            <div class="gdlr-core-divider-line gdlr-core-skin-divider" id="div_983a_6"></div>
                        </div>
                    </div>

                    <div class="instr_notes">
                        <ul>
                            <?php if($instructn!="") echo "<li>$instructn</li>"; ?>

                            <li>Maximum time allowed for this test is <b><?=$set_time?> mins</b></li>
                            <li>You can decide to skip any question if you do not have an instant idea about it and attempt the rest then later go back to re-attempt your skipped questions in duration of your time. </li>

                            <li>If you are done answering the questions, you can re-check to make sure and then click on the submit button to submit the answers.</li>

                            <li><b style="color: red">Note that</b> if you are timed-out before answering all the questions, it will automatically submit your answers whether you finished or not.</li>
                        </ul>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-offset-2 col-md-10 col-sm-offset-2 col-sm-10 mt--30 mt-sm-30 mt-xs-30">
                    <div class="test_div">
                        <div class="col-md-offset-3 col-md-8 col-sm-offset-4 col-sm-8 mt-0 mt-sm-0 mb-sm-20 cmd_back_start">

                            <?php
                            $instructn1 = base64_encode($instructn);
                            ?>

                            <!-- <div class="col-md-3 col-sm-4 col-xs-offset-2 col-xs-8 pr-0 pl-0 pt-5 p-xs-5"> -->
                            <div class="col-md-offset-2 col-md-3 col-sm-4 col-xs-8 pr-0 pl-0 pt-5 p-xs-5 ml-xs-40">
                                <div class="start_test_btn change_color cmd_back2 p-15 font-16" style="opacity: 0.7;" isSubjects="0"><i class="fa fa-arrow-left"></i> Back</div>
                            </div>

                            <div class="col-md-5 col-sm-8 col-xs-12 p-0">

                                <?php
                                $my_ids=@substr($this->session->userdata('quizid'), 0, -2);
                                $counts = explode(",", $my_ids);
                                $counts1 = count($counts);
                                if($counts1 <= 0) $counts1=1;

                                $submitted_attempts = $this->sql_models->submitted_attempts($this->memid, $id1, $subject_id, $ids);

                                $attempts = $this->sql_models->already_started($this->memid, $id1, $subject_id, $ids);

                                $attempts_and_written = $this->sql_models->attempts_and_written($this->memid, $id1, $subject_id, $ids);

                                if($attempts > 0){ // if writing quiz and refreshed 
                                    if(!$attempts_and_written){ // attempts_and_written
                                        if($attempts > $submitted_attempts){ // submitted_attempts
                                            //echo "$attempts<br>";
                                            //echo "$submitted_attempts<br>";
                                ?>
                                
                                            <div class="start_test_btn change_color contd_quiz p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" txtpage_number="<?=$counts1;?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">CONTINUE <i class="fa fa-arrow-right"></i></div>

                                        <?php }else{ // submitted_attempts ?>

                                            <div class="start_test_btn change_color start_main_test p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">START TEST <i class="fa fa-arrow-right"></i></div>

                                        <?php } // submitted_attempts ?>

                                    <?php
                                    }else{  // attempts_and_written
                                        if($attempts > $submitted_attempts){
                                            //echo "$attempts kk<br>";
                                            //echo "$submitted_attempts ss$id1<br>";
                                    ?>

                                            <div class="start_test_btn change_color contd_quiz p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" txtpage_number="<?=$counts1;?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">CONTINUE <i class="fa fa-arrow-right"></i></div>

                                        <?php }else{ ?>

                                            <div class="start_test_btn change_color start_main_test p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">START TEST <i class="fa fa-arrow-right"></i></div>

                                        <?php } ?>

                                    <?php } // attempts_and_written ?>
                                
                                
                                <?php }else{  // if writing quiz and refreshed 
                                    if($attempts > 0){
                                        if(!$attempts_and_written){ // attempts_and_written
                                            if($attempts > $submitted_attempts){ // submitted_attempts
                                ?>
                                                <div class="start_test_btn change_color contd_quiz p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" txtpage_number="<?=$counts1;?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">CONTINUE <i class="fa fa-arrow-right"></i></div>
                                            <?php }else{ ?>
                                                <div class="start_test_btn change_color start_main_test p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">START TEST <i class="fa fa-arrow-right"></i></div>
                                            <?php } ?>

                                        <?php }else{ ?>
                                            <div class="start_test_btn change_color start_main_test p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">START TEST <i class="fa fa-arrow-right"></i></div>
                                        <?php } ?>

                                    <?php }else{ ?>
                                
                                        <div class="start_test_btn change_color start_main_test p-20 p-sm-20 font-17" id1="<?=$id1?>" ids="<?=$ids?>" schs="<?=$txtcollege1?>" subject_id="<?=$subject_id?>" instructn="<?=$instructn1?>" set_time="<?=$set_time?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" noOfQuest="<?=$noOfQuest?>" subjects_caption="<?=$selected_subjs2;?>" studid="<?=$this->memid;?>" is_new_rec="yes">START TEST <i class="fa fa-arrow-right"></i></div>

                                    <?php } ?>

                                    <div class="start_test_btn change_color start_main_test1 p-20 p-sm-20 font-17" style="display:none !important; opacity:0.6; color:#777;">START TEST <i class="fa fa-arrow-right"></i></div>
                                

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }else{
            echo "<p class='mt-30' style='text-align:center; padding:10px 5px; font-size:19px; color:#333;'><b>No questions found on this!</b></p>";
            echo '<div class="test_div mb-200 pb-100">
            <div class="col-md-offset-5 col-md-2 col-sm-offset-4 col-sm-4 col-xs-offset-2 col-xs-8 pr-0 pl-0 pt-5 p-xs-5">
                    <div class="start_test_btn change_color cmd_back2 p-20 font-18" style="opacity: 0.7;" isSubjects="0"><i class="fa fa-arrow-left"></i> Go Back</div>
                </div></div>';
        }
        //echo json_encode($arrs);
    }



    function getUnanswered(){
        $quiz_intro = trim($this->input->post('id1'));
        $subject_id = $this->input->post('subject_id');
        
        $results = "";
        $quizid_taken = $this->session->userdata('quizid');

        $qid_intro = $this->input->post('id1');
        $schs = $this->input->post('schs');
        $ids = $this->input->post('ids');
        $instructn = $this->input->post('instructn');
        $set_time = $this->input->post('set_time');
        $test_types = $this->input->post('test_types');
        $test_board = $this->input->post('test_board');
        $noOfQuest = $this->input->post('noOfQuest');
        $noOfYrs = $this->input->post('noOfYrs');
        $subject_id = $this->input->post('subject_id');
        $studid = $this->input->post('studid');
        $is_new_rec = $this->input->post('is_new_rec');
        $subjects_caption = $this->input->post('subjects_caption');
        //echo $subject_id; exit;

        $this->questionDiv($quizid_taken, $qid_intro, $schs, $instructn, $set_time, $test_types, $test_board, $noOfQuest, $noOfYrs, $subject_id, $studid, $is_new_rec, $ids, $subjects_caption);
    }



    function start_main_quiz(){
        $qid_intro = $this->input->post('id1');
        $schs = $this->input->post('schs');
        $instructn = $this->input->post('instructn');
        $set_time = $this->input->post('set_time');
        $test_types = $this->input->post('test_types');
        $test_board = $this->input->post('test_board');
        $noOfQuest = $this->input->post('noOfQuest');
        $noOfYrs = $this->input->post('noOfYrs');
        $subject_id = $this->input->post('subject_id');
        $studid = $this->input->post('studid');
        $is_new_rec = $this->input->post('is_new_rec');
        $ids_arr = $this->input->post('ids');
        $subjects_caption = $this->input->post('subjects_caption');

        $this->save_stud_test_start($qid_intro, $studid, $is_new_rec, $subject_id, $ids_arr);

        $this->questionDiv('', $qid_intro, $schs, $instructn, $set_time, $test_types, $test_board, $noOfQuest, $noOfYrs, $subject_id, $studid, $is_new_rec, $ids_arr, $subjects_caption);
    }




    function questionDiv($quizid_taken, $qid_intro, $schs, $instructn, $set_time, $test_types, $test_board, $noOfQuest, $noOfYrs, $subject_id, $studid, $is_new_rec, $ids_arr, $subjects_caption){ ?>

        <video width="0" height="0" autoplay loop>
          <source src="<?php echo base_url(); ?>sounds/JIVE_XG.mp3" type="video/mp4" />
        </video>

        <div class="pb-60 pb-sm-40">
            <div class="container pt-0 pr-0 pl-0 pt-xs-10">

                

                <?php
                $record=0;
                $recordPerPage = 1;
                if($record != 0){
                    $record = ($record-1) * $recordPerPage;
                }

                $quiz_quests = $this->sql_models->quizQuestions('', $qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr, $record, $recordPerPage);

                $recordCount = $this->sql_models->countQuestions('', $qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr);

                $attempts = $this->sql_models->already_started($this->memid, $qid_intro, $subject_id, $test_types, $ids_arr);
                $submitted_attempts = $this->sql_models->submitted_attempts($this->memid, $qid_intro, $subject_id, $test_types, $ids_arr);
                $subj_name = $this->sql_models->subjName($subject_id, $ids_arr, $qid_intro);


                $config['base_url'] = base_url()."questions/";


                ////////////////////
                    $config["total_rows"] = $recordCount;
                    $config["per_page"] = $recordPerPage;
                    $config['use_page_numbers'] = TRUE;
                    $config['num_links'] = 2;

                    $config['first_link'] = FALSE;
                    $config['first_tag_open'] = FALSE;
                    $config['first_tag_close'] = FALSE;
                    
                    $config['last_link'] = FALSE;
                    $config['last_tag_open'] = FALSE;
                    $config['last_tag_close'] = FALSE;
                    
                    
                    //Encapsulate whole pagination 
                    $config['full_tag_open'] = '<ul class="pagination_ blog_pagn">';
                    $config['full_tag_close'] = '</ul>';


                    //For NEXT PAGE Setup
                    $config['next_link'] = "<span aria-hidden='true' class='next_prev_btn next_prev_btn_no_radius' id_sch='$qid_intro' test_types='$test_types' test_board='$test_board' ids_arr='$ids_arr' noOfYrs='$noOfYrs' subject_id='$subject_id'>
                        NEXT <span class='fa fa-arrow-right'></span>
                    </span>";

                    $config['next_tag_open'] = "<li>";
                    $config['next_tag_close'] = '</li>';

                    // $config['num_tag_open'] = '<li class="page-link">';
                    // $config['num_tag_close'] = '</li>';
                ////////////////////

                $this->pagination->initialize($config);
                $pagination = $this->pagination->create_links();


                $id_sch = $qid_intro;
                $qid = $quiz_quests['ids'];
                $questions = ucfirst($quiz_quests['questions']);
                $files = $quiz_quests['files'];
                $op1 = $quiz_quests['op1'];
                $op2 = $quiz_quests['op2'];
                $op3 = $quiz_quests['op3'];
                $op4 = $quiz_quests['op4'];
                $ans1 = $quiz_quests['ans1'];
                $explanations = $quiz_quests['explanations'];
                $op1_1=$op1;
                $op1_2=$op2;
                $op1_3=$op3;
                $op1_4=$op4;

                
                $all_options = array($op1, $op2, $op3, $op4);
                if($op1!="" && $op2!="" && $op3=="" && $op4=="") $all_options = array($op1, $op2);
                if($op1!="" && $op2!="" && $op3!="" && $op4=="") $all_options = array($op1, $op2, $op3);

                $files1i="";
                if($files!=""){
                    $paths = base_url()."quizes/$files";
                    $files1i = "<div style='margin-bottom:15px' class='quiz_img'><img src='$paths' style='width:100%;'></div>";
                }

                if($noOfYrs == "rand") $noOfYrs1 = "Random"; else $noOfYrs1 = $noOfYrs;
                ?>



                
                <div class="col-md-7">
                    <div class="quiz_starts" style="display:nones;">
                        <?php
                        if(strlen($subj_name)>40)
                            $subj_name1 = substr($subj_name, 0, 40)."...";
                        else
                            $subj_name1 = $subj_name;
                        ?>

                        <div class="quiz_details for_mobile">
                            Name: <font style="color: #75BAFF"><?=$this->myfname?></font> &nbsp;&bull;&nbsp; Subject(s): 
                            <!-- <font style="color: #75BAFF"><?=$subj_name1?></font><br> -->
                            <font style="color: #75BAFF"><?=$subjects_caption?></font><br>

                            Test: <font style="color: #75BAFF; font-size: 14px;"><?=strtoupper($test_types)?></font> &nbsp;&bull;&nbsp; 
                            Year: <font style="color: #75BAFF"><?=$noOfYrs1?></font>
                        </div>

                        <div class="timeset mt-sm-50 mt-md-40">Time Set <font id='tminus_1'><?php echo "$set_time minutes"; ?></font>
                        </div>
                        <p style="color: #ccc; text-align: center; margin: -16px 0 23px 0; font-size: 15px;">Note that you cannot refresh this timer</p>

                        <div style="display:none">
                            <input id="tminus" placeholder="0:00" />
                            <input id="request" value="<?=$set_time;?>" />
                            <a href="javascript:;" class="button enterTime">Submit Time</a>
                            <input type="button" id="resets" value="Clear form" />
                        </div>

                        <input type='hidden' id='txtmember' name='txtmember' value='<?=$this->memid;?>'>
                        <input type='hidden' id='txttotalquiz' name='txttotalquiz' value='<?=$noOfQuest;?>'>
                        <input type='hidden' id='qid_intro' name='qid_intro' value='<?=$qid_intro;?>'>

                        <div class='fade_questions' style='display:nones'></div>

                        <?php
                        $my_ids=substr($this->session->userdata('quizid'), 0, -2);
                        $counts = explode(",", $my_ids);
                        $counts1 = count($counts);
                        if($counts1 <= 0) $counts1=1;

                        //if(!$quiz_quests)
                            //echo "<div class='fade_questions'></div>";
                        ?>

                        <input type='hidden' id="txtpage_number" value='<?=$counts1;?>'>

                        <div class='scroll_inner_quiz' style='text-align:left'>
                            
                            <input type='hidden' name='txtrandom_quiz' id="txtrandom_quiz" value='<?=$qid;?>'>

                            <div class="quest_title"><label>Question</label></div>
                            <?php $questions = str_replace(array('<p>', '</p>'), "", $questions); $questions = ucfirst($questions); ?>

                            <ul class='quiz_question'>
                                <li style='font-size:17px; line-height:23px; color:#ddd; font-weight: 600;'><font id="txtpage_number_h">1.</font> <?=nl2br($questions);?></li>
                            </ul>

                            <?php
                            echo "<ul class='quiz_options' ids='$qid'>";
                                echo $files1i;
                                $k=1;
                                shuffle($all_options);

                                $quizid_taken_ans = $this->session->userdata('my_answers');
                                $quizid_taken_ans = substr($quizid_taken_ans, 0, -2);
                                $quizid_taken2 = explode("||", $quizid_taken_ans);
                                $quizid_taken2 = array_unique($quizid_taken2);

                                foreach($all_options as $keys){
                                    if($k == 1) $m="<b>A)</b>";
                                    else if($k == 2) $m="<b>B)</b>";
                                    else if($k == 3) $m="<b>C)</b>";
                                    else $m="<b>D)</b>";
                                    $keys1 = ucfirst($keys);

                                    $keys_i = str_replace("+", "&dagger;", $keys);

                                    ?>
                                        <li>
                                        <label for='options<?=$keys?>'>
                                        <label class='container_radio'><b><?=$m?></b> <?=$keys1?>
                                          <input type='radio' name='options1' value='<?=$keys_i?>' class='<?=$keys?> chk' id='options<?=$keys?>' <?php if(in_array($keys, $quizid_taken2)) echo "checked"; ?> ids='<?=$qid?>'>
                                          <span class='checkmark'></span>
                                        </label>
                                        </li>
                                        <?php
                                    $k++;
                                }
                            echo "</ul>";

                            echo $pagination;

                        echo "</div>";

                        echo "<input type='hidden' name='txtans1' value='' id='txtans1' class='txtans1' style='color:#000 !important'>";
                        ?>

                        <input type='hidden' id_sch="<?=$id_sch;?>" name='txt_time_finished' id='txt_time_finished'>
                        
                        <div class="alert alert-danger alert_msg alert_msgs"></div>
                        
                        <?php if($quiz_quests){ ?>
                            <div class="col-md-offset-0 col-md-12 col-sm-12 col-xs-offset-0 col-xs-12 p-xs-0 m-xs-0 btns_2 mb-20" style="margin-top:5px !important;">


                                <div class="loaders" style="display: none;">
                                    <img src="<?php echo base_url(); ?>images/loader.gif" class="cmd_next_quiz2" style="color:#777;">
                                </div>

                                <?php /* ?>
                                <div class="nxt_btn_div">

                                    <?php
                                    $quizs = $this->session->userdata('quizid');
                                    $quizs1 = explode(",", $quizs);
                                    $quizs1 = count($quizs1);

                                    if($quizs1 >= 2){
                                    echo "<div class='next_prev_btn prev_btn cmd_prev_quiz cmd_prev_quiz_j p-15 p-sm-15 font-17' id_sch='$id_sch' test_types='$test_types' test_board='$test_board' ids_arr='$ids_arr' subject_id='$subject_id' style='opacity:0.7;'> <i class='fa fa-arrow-left'></i> Prev</div>";
                                    }

                                    echo "<div class='next_prev_btn prev_btn cmd_prev_quiz cmd_prev_quiz_i p-15 p-sm-15 font-17' id_sch='$id_sch' test_types='$test_types' test_board='$test_board' ids_arr='$ids_arr' subject_id='$subject_id' style='display:none; opacity:0.7;'> <i class='fa fa-arrow-left'></i> Prev</div>";

                                    ?>

                                    <div class="next_prev_btn prev_btn cmd_prev_quiz1 p-15 p-sm-15 font-17" id_sch="<?=$id_sch;?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" style="display:none; opacity:0.4; color:#ccc;"><i class="fa fa-arrow-left"></i> Prev</div>

                                    <div class="next_prev_btn start_test_btn_ _start_test_btn_w _inlines cmd_next_quiz p-15 p-sm-15 font-17" id_sch="<?=$id_sch;?>" test_types="<?=$test_types?>" test_board="<?=$test_board?>" ids_arr="<?=$ids_arr?>" noOfYrs="<?=$noOfYrs?>" subject_id="<?=$subject_id?>">NEXT <i class="fa fa-arrow-right"></i></div>

                                    <div class="next_prev_btn start_test_btn_ _start_test_btn_w _inlines cmd_next_quiz1 p-15 p-sm-15 font-17" style="display:none; opacity:0.6; color:#ccc;">NEXT ... <i class="fa fa-arrow-right"></i></div>

                                    <!-- <div class="start_test_btn start_test_btn_w p-15 p-sm-15 font-17" style="display:none;" id="cmd_submit_answers_timeout" test_types="<?=$test_types?>" test_board="<?=$test_board?>" ids_arr="<?=$ids_arr?>" noOfYrs="<?=$noOfYrs?>" subject_id="<?=$subject_id?>">Submit <i class="fa fa-power-off"></i></div> -->

                                    <div style="clear: both; display: none;" class="mb-xs-20 for_mobile_s"></div>

                                    <div class="cmd_submit_css pt-15 pb-15 pl-30 pr-30 p-sm-15 font-17" style="display:none;" id="cmd_submit_answers_timeout" test_board="<?=$test_board?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" id_sch="<?=$id_sch;?>" noOfYrs="<?=$noOfYrs?>">Submit <i class="fa fa-power-off"></i></div>


                                    <!-- <div class="nxt_btn_div"> -->
                                        <div class="cmd_submit_css pt-15 pb-15 pl-30 pr-30 p-sm-15 font-17 cmd_sub_answers" style="display:nones;" test_board="<?=$test_board?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" id_sch="<?=$id_sch;?>" noOfYrs="<?=$noOfYrs?>">Submit <i class="fa fa-power-off"></i></div>
                                    <!-- </div> -->

                                </div>
                                <?php */ ?>


                                <div class="nxt_btn_div">
                                    <div style="clear: both; display: none;" class="mb-xs-20 for_mobile_s"></div>

                                    <div class="cmd_submit_css pt-15 pb-15 pl-30 pr-30 p-sm-15 font-17" style="display:none;" id="cmd_submit_answers_timeout" test_board="<?=$test_board?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" id_sch="<?=$id_sch;?>" noOfYrs="<?=$noOfYrs?>">Submit <i class="fa fa-power-off"></i></div>


                                    <div class="cmd_submit_css pt-15 pb-15 pl-30 pr-30 p-sm-15 font-17 cmd_sub_answers" style="display:nones;" test_board="<?=$test_board?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" id_sch="<?=$id_sch;?>" noOfYrs="<?=$noOfYrs?>">Submit <i class="fa fa-power-off"></i></div>
                                </div>

                            </div>

                            <div style="clear: both;"></div>
                            <div class="mb-70 cancel_test"><span ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" test_board="<?=$test_board?>" id_sch="<?=$id_sch?>" noOfYrs="<?=$noOfYrs?>">Cancel Test</span></div>


                            <?php
                            }else{
                                // echo '<div class="nxt_btn_div">
                                //     <div class="start_test_btn start_test_btn_w cmd_submit_css more_width inlines p-15 p-sm-15 font-17 cmd_submit_answers_timeout" ids_arr="'.$ids_arr.'" subject_id="'.$subject_id.'" test_board="'.$test_board.'" id_sch="'.$id_sch.'" noOfYrs="'.$noOfYrs.'">Submit <i class="fa fa-power-off"></i></div>
                                // </div>';
                                // echo "<div style='clear:both'></div>";

                                echo "<p style='color:#999 !important;'>Error! No test found here. Please click the button below to go back</p>";

                                echo '<div class="nxt_btn_div">
                                    <div class="start_test_btn start_test_btn_w cmd_submit_css more_width inlines p-15 p-sm-15 font-17 cancel_test" ids_arr="'.$ids_arr.'" subject_id="'.$subject_id.'" test_board="'.$test_board.'" id_sch="'.$id_sch.'" noOfYrs="'.$noOfYrs.'">GO BACK <i class="fa fa-power-off"></i></div>
                                </div>';
                                echo "<div style='clear:both'></div>";
                                ?>

                                <!-- <div class="mb-70 mt-20 cancel_test"><span ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" test_board="<?=$test_board?>" id_sch="<?=$id_sch?>" noOfYrs="<?=$noOfYrs?>">Cancel Test</span></div> -->
                            <?php
                            }
                        ?>
                    </div>
                    

                    

                    <div class="div_success_test" style="display:none; text-align:center">
                        <p class="mt--30 mt--sm-50">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                              <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                              <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                            </svg>
                        </p>
                        <p style="font-size:25px; line-height: 32px !important;"><b style="color:#9FCFFF; font-weight: bold;"><?php echo strtoupper("$subj_name $test_types"); ?> Taken!</b></p>

                        <p style="margin:-10px 0 0 0; margin-top:0px; font-size: 16px; color: #ddd;" class="pr-10 pl-10">Thank you for participating on the test. Your performance has been computed, please click <b>"show my perfomance"</b> link to show all your answers or <b>"View Answers button"</b> to view your current perfomance.</p>
                        <p style="border-bottom:1px #666 dotted; margin:20px 0 20px 0;"></p>

                        <div class="mt-20 show_performance"><span ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" id_sch="<?=$id_sch;?>" test_board="<?=$test_board?>">Show all my performances</span></div>


                        <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-12 mt-30 mb-sm-50">
                            <div class="nxt_btn_div">
                                <div class="start_test_btn done_btn view_answers p-15 p-sm-15 font-17" id_sch="<?=$id_sch;?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>">VIEW ANSWERS</div>

                                <div class="start_test_btn done_btn view_answers1 p-15 p-sm-15 font-17" style="opacity: 0.5; display: none;">VIEW ANSWERS</div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="div_success_test_timeout" style="display:none; text-align:center">
                        <p class="mt-10 mt--sm-10">
                            <img style="width: auto; height: auto;" src="<?=base_url()?>images/errors.png">
                        </p>
                        <p style="font-size:25px; line-height: 32px !important;"><b style="color:#9FCFFF; font-weight: bold;">Test Timeout And Submitted!</b></p>

                        <p style="margin:-10px 0 0 0; margin-top:0px; font-size: 16px; color: #ddd;" class="pr-10 pl-10">Thank you for participating on the test. Your performance has been computed, please click <b>"show my perfomance"</b> link to show all your answers or <b>"View Answers button"</b> to view your current perfomance.</p>

                        <p style="border-bottom:1px #666 dotted; margin:20px 0 20px 0;"></p>

                        <div class="mt-20 show_performance"><span ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>" id_sch="<?=$id_sch;?>" test_board="<?=$test_board?>">Show all my performances</span></div>

                        <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-12 mt-30 mb-sm-50">
                            <div class="nxt_btn_div">
                                <div class="start_test_btn done_btn view_answers p-15 p-sm-15 font-17" id_sch="<?=$id_sch;?>" ids_arr="<?=$ids_arr?>" subject_id="<?=$subject_id?>">VIEW ANSWERS</div>

                                <div class="start_test_btn done_btn view_answers1 p-15 p-sm-15 font-17" style="opacity: 0.5; display: none;">VIEW ANSWERS</div>
                            </div>
                        </div>
                    </div>


                    <div class="div_show_perfomance" style="display:none;">
                        
                    </div>
                    <div style="clear: both;"></div>

                </div>


                <!-- <div class="col-md-1 put_border p-0 m-0"></div> -->


                <div class="col-md-4 pr-0 pl-0 m-0 for_desktop_i">
                    <div class="put_border pr-0">

                        <div class="col-md-12 mb-30 pr-0 pl-0 subjDetails1">
                            <div class="font-25 mb-15 subdt1" style="color: #093"><b>Subject Details</b></div>

                            <p><b>Welcome</b> <label style="color: #06C;" class="subdt"><?=ucwords($this->myfname)?></label></p>

                            <p><b>Test Type: <font class="subdt"><?=strtoupper($test_types)?></font></b></p>
                            <!-- <p><b>Subject Selected: </b> <font class="subdt"><?=$subj_name?></font></p> -->
                            <p><b>Subject Selected: </b> <font class="subdt"><?=$subjects_caption?></font></p>
                            
                            <?php if($schs!="")
                            echo '<p><b>School Selected:</b> <font class="subdt">'.$schs.'</font></p>';
                            ?>
                            <p><b>Exam Year:</b> <font class="subdt"><?=$noOfYrs1?></font></p>
                            <p><b>Total Questions:</b> <font class="subdt"><?=$noOfQuest?></font></p>
                            <p><b>Duration:</b> <font class="subdt"><?=$set_time?> mins</font></p>
                        </div>

                        <div class="col-md-12 font-16 mt-sm-0 mt-xs-50 pr-0 pl-0">
                            <div class="font-25 mb-15 subdt1" style="color: #093"><b>Instructions</b></div>
                            
                            <div class="instr_notes1">
                                <ul>
                                    <li><?=base64_decode($instructn)?></li>
                                    <li>Maximum time allowed for this test is <b><?=$set_time?></b> mins</li>
                                    <li>You can decide to skip any question if you do not have an instant idea about it and attempt the rest then later go back to re-attempt your skipped questions in duration of your time. </li>

                                    <li>If you are done answering the questions, you can re-check to make sure and then click on the submit button to submit the answers.</li>

                                    <li>Note that if you are timed-out before answering all the questions, it will automatically submit your answers whether you finished or not.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
                

            </div>
        </div>
    <?php }





    function signup_acct(){
        $this->form_validation->set_rules('txtnames', 'Full Names', 'required|trim|min_length[7]|max_length[30]');
        $this->form_validation->set_rules('txtph', 'Phone Number', 'required|trim|numeric|regex_match[/^[0-9\+]{6,11}$/]|is_unique[members.phone]');
        $this->form_validation->set_rules('txtemail', 'Email', 'required|trim|is_unique[members.emails]|valid_email');
        $this->form_validation->set_rules('txtgender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('txtpass1', 'Password', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('txtpass2', 'Confirm Password', 'required|trim|matches[txtpass1]');
        $this->form_validation->set_rules('txtsum1', 'correct', 'trim');
        $this->form_validation->set_rules('txtmaths', 'Maths', 'required|trim|matches[txtsum1]');
        
        if($this->form_validation->run() == FALSE){
            $arrs = array('type'=>'error', 'msg'=>validation_errors(), 'memid'=> '');
        }else{
            $txtnames = $this->input->post('txtnames');
            $txtph = $this->input->post('txtph');
            $txtemail = $this->input->post('txtemail');
            $txtgender = $this->input->post('txtgender');
            $txtpass1 = hash_password($this->input->post('txtpass1'));
            $ipaddrs = $_SERVER['REMOTE_ADDR'];

            $newdata2 = array(
                'names'         => $txtnames,
                'emails'        => $txtemail,
                'passwords'     => $txtpass1,
                'phone'         => $txtph,
                'gender'        => $txtgender,
                'location'      => $ipaddrs,
                'created_at'    => date("Y-m-d g:i a", time())
            );

            $mem_name = $this->sql_models->update_inserts_members($newdata2, '');
            $memids = $this->sql_models->get_user_ids($newdata2);

            if(!$mem_name){
                //echo "Error in network connection!";
                $arrs = array('type' => 'error', 'msg'=>'Error in network connection!', 'memid'=> '');
            }else{
                $now = 2147483647 - time();
                $cookie = array(
                    'name'   => 'tst_uname',
                    'value'  => sha1($txtemail),
                    'expire' => $now,
                    'secure' => FALSE
                );
                $cookie1 = array(
                    'name'   => 'tst_pass',
                    'value'  => $txtpass1,
                    'expire' => $now,
                    'secure' => FALSE
                );
                set_cookie($cookie);
                set_cookie($cookie1);

                $arrs = array('type'=>'success', 'msg'=>$mem_name, 'memid'=> $memids);
                //echo "registered";
            }
        }
        echo json_encode($arrs);
    }



    function send_pass_code(){
        $this->form_validation->set_rules('txtemail2', 'Email or Phone', 'required|trim');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txtemail2 = strtolower($this->input->post('txtemail2'));
            $details_exists = $this->sql_models->check_existing_details($txtemail2, '', 'members');
            if($details_exists){
                ///////////////////////////////
                    $res_code = substr(time(), -5);
                    $newdata2 = array(
                        'emails'         => $txtemail2,
                        'codes'          => $res_code
                    );

                    $codes = $this->sql_models->insert_code($newdata2, $txtemail2, 'email_verificatn');
                    if($codes!=""){
                        $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://testport.ng/images/logo.png'></div>";
                        $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello there,</b></p>";
                        $message_contents .= "<p style='font-size:16px; margin-top:10px'>This is your reset code <b>$codes</b></p>";
                        $message_contents .= "<p style='font-size:14px; margin:0px 0 20px 0'>Please click the link below to reset your password and continue.</p>";

                        $message_contents .= "<p style='font-size:14px; margin:0px 0 20px 0'>".base_url()."reset-password/</p><br><br>";

                        $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                        $message_contents .= "<a href='http://testport.ng' style='color:#0066FF' target='_blank'>http://testport.ng</a></p>";

                        $email3="Undisclosed Recipient <info@testport.ng>";
                        $subj = "Password Reset Link";

                        $message_contents1 = $this->mailHeader.$message_contents.$this->mailFooter;
                        $this->send_mail($email3, $txtemail2, "", $message_contents1, $subj);
                        echo "msg_sent";
                    }else{
                        echo "Error, please try again.";
                    }
                ///////////////////////////////

            }else{
                echo "The details you provided do not exist.";
            }
            
        }
    }



    function delete_records(){
        $txtall_id = $this->input->post('txtall_id');
        $txt_dbase_table = $this->input->post('txt_dbase_table');
        $profile_details = $this->sql_models->deleteTblRecords($txt_dbase_table, $txtall_id);
        if($profile_details) echo "deleted"; else echo "error";
    }

    

    function remove_started_test(){
        $id_sch = $this->input->post('id_sch');
        $subject_id = $this->input->post('subject_id');
        $ids_arr = $this->input->post('ids_arr');
        $memid = $this->memid;
        $submitted_attempts = $this->sql_models->submitted_attempts($this->memid, $id_sch, $subject_id, $ids_arr);
        //echo "$submitted_attempts vvv";
        $updates = $this->sql_models->updateRecs1($id_sch, $subject_id, $memid, $ids_arr, $submitted_attempts);
        if($updates){
            $newdata5 = array(
                'my_answers' => "",
                'quizid'     => "",
                'allRandIDs'    => ""
            );
            $this->session->set_userdata($newdata5);
            echo "updated";
        }else{
            echo "error";
        }
    }



    public function getSearches(){
        $keyword = $this->input->post('keyword');
        if(isset($keyword) && $keyword!=""){
            $result = $this->sql_models->searchStr($keyword);
            echo "<div class='close_list'><i class='fa fa-close'></i></div>";
            foreach ($result as $rs) {
                $locations = strtolower($rs['locations']);
                $centre_name = ucwords($rs['centre_name']);
                $centre_name1 = str_replace("&", "and", $centre_name);
                if(strlen($centre_name1)>25) $centre_name1 = substr($centre_name1, 0, 25);

                $locations = " <i>($locations)</i>";
                $returnStr = str_replace($this->input->post('keyword'), '<b style="color:#069">'.$this->input->post('keyword').'</b>', $centre_name.' '.$locations);
                
                echo '<li class="set_item" thisname="'.str_replace(array("'"), "\'", $centre_name1).'"><i class="fa fa-map-marker" style="color: #C00 !important; font-size: 15px;"></i>&nbsp;'.$returnStr.'</li>';
            }
        }
    }




    public function resizeImage($source_path, $target_path, $widths, $heights, $maintain_ratio){
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => $maintain_ratio,
          'width' => $widths,
          'height' => $heights,
      );
      $this->load->library('image_lib');
      $this->image_lib->initialize($config_manip);

      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }

      $this->image_lib->clear();
   }


   function compress($source, $destination, $quality) {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
        imagejpeg($image, $destination, $quality);
        return $destination;
    }



   function send_contact_msg(){
        $this->form_validation->set_rules('txtname', 'Names', 'required|trim|alpha_space');
        $this->form_validation->set_rules('txtemail', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('txtmessage', 'Message', 'required|trim');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            
            $txtname = $this->input->post('txtname');
            $txtemail = $this->input->post('txtemail');
            $txtmessage = $this->input->post('txtmessage');

            ///////////////////////////////
                $txtemail = strtolower($txtemail);
                $my_name = ucwords($txtname);

                $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://testport.ng/images/logo.png'></div>";
                $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Admin,</b></p>";
                $message_contents .= "<p style='font-size:14px; margin-top:10px'>You have a message from $my_name sent at testport.ng contact page. </p>";
                $message_contents .= "<p style='font-size:14px; margin:0px 0 20px 0'><b>Message</b><br>$txtmessage</p><br><br>";

                $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                $message_contents .= "<a href='http://testport.ng' style='color:#0066FF' target='_blank'>http://testport.ng</a></p>";

                $email3="Undisclosed Recipient <info@testport.ng>";
                $subj = "You have a message from $my_name";

                $message_contents1 = $this->mailHeader.$message_contents.$this->mailFooter;

                $this->send_mail($txtemail, "info@testport.ng", $my_name, $message_contents1, $subj);
                echo "msg_sent";
            ///////////////////////////////
        }
   }





    function use_quiz_questions(){
        $sess = $this->input->post('sess'); // prev sess 
        $txtsessions = $this->input->post('txtsessions'); // new ses
        $txtsch_id1 = $this->input->post('txtsch_id1');
        $querys = $this->sql_models->updateSessions($sess, $txtsessions, $txtsch_id1);
        if($querys) echo "updateds"; else "error!";
    }




    public function fetch_performance(){
        $fetch_data = $this->sql_models->make_datatables('stud_ans', 'users', $this->memid);
        //print_r($fetch_data); exit;
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $id4 = $row->sa_id;
            $sessions = "";
            $quizintro_id = $row->quizintro_id;
            
            $sessions = $this->sql_models->getSess($quizintro_id);
            $id_sch = $this->sql_models->getTopicName($id4, 'id', 'stud_ans', 'quizintro_id', 'array');
            $subject_id = $row->subject_id;
            $time_finished = $row->time_finished;
            $scores = $row->scores;
            $date_taken = date("jS M, Y h:ia", $row->date_taken);
            $set_time = $row->set_time;
            
            $test_board_id = $this->sql_models->getTopicName($sessions, 'sessions', 'quizes', 'test_board', 'row');
            $test_board = $this->sql_models->getTopicName($test_board_id, 'id', 'test_boards', 'test_types', 'row');
            $subject_names = $this->sql_models->subjName($subject_id, 'arrays', $quizintro_id);
            $years = $this->sql_models->fetchSubjYears($subject_id, 'arrays', $test_board_id, '');

            $yrs="";
            if($years){
                foreach($years as $years1){
                    $yrs .= $years1['years'].", ";
                }
                $yrs=substr($yrs, 0, -2);
            }

            $mins1 = round($time_finished/60);
            $time_finished1 = $mins1." minutes";


            $myPerform=$this->sql_models->showMyPerformanceTbl($id4, $subject_id, $this->memid, $test_board_id);
            $ids = $myPerform['ids'];
            $ids_i = $ids;
            $answers = $myPerform['answers'];

            $ids = explode(',', $ids);
            $answers = explode('||', $answers);

            $ids = array_unique($ids);
            $answers = array_unique($answers);

            $myanswers = "<div class='table-responsive'><table class='table table-bordered tables_2' id='tables_2$id4'>
                <tr>
                    <th>Sn</th>
                    <th>Question</th>
                    <th>Your Answer</th>
                    <th>Marks</th>
                    <th>Right Answer</th>
                    <th>Explanation</th>
                </tr>";

                if($ids){
                    foreach($ids as $index=>$ids1){
                        $mem_ans = @$answers[$index];
                        $mem_ans2 = $mem_ans;
                        $get_quiz_origin = $this->sql_models->getQuizOrigin($ids1);
                        if($get_quiz_origin){
                            $questions1 = $get_quiz_origin['questions'];
                            $ans1 = $get_quiz_origin['ans1'];
                            $explanations = $get_quiz_origin['explanations'];
                            if($explanations=="") $explanations="<i style='color:#666;'>None</i>";

                            if($ans1 == $mem_ans){
                                $ticks = "<img src='".base_url()."images/tick2.png' style='width:15px!important'>";
                            }else{
                                $ticks = "<img src='".base_url()."images/wrong.png' style='width:14px!important'>";
                            }

                            if($mem_ans=="nill" || $mem_ans==0) $mem_ans="<label style='font-size:13px; color:#FF5E5E'>Not answered</label>";
                            $mem_ans = ucfirst($mem_ans);
                            $counts1 = $index+1;

                            $myanswers .= "<tr><td>$counts1</td>
                            <td>$questions1</td>
                            <td style='color:#666'>$mem_ans</td>
                            <td style='text-align: center;'>$ticks</td>
                            <td style='color:#666'>$ans1</td>
                            <td style=''>$explanations</td>
                            </tr>";
                        }
                    }
                    $myanswers .= "<tr>
                    <td colspan='6' style='padding-bottom: 2em !important; border:none !important'></td>
                    </tr>";
                }else{
                    $myanswers .= "<tr><td colspan='6' style='text-align:center'><b>No records found!</b></td></tr>";
                }
            $myanswers .= "</table></div>";


            $test_board_f = "<div class='show_answer col-lg-10 col-md-9 col-xs-11 p-0' id='show_answer$conts'><span>$myanswers</span></div>";

            if($scores > 40){
                $scores1 = "<b style='color:green; font-size:17px;'>$scores</b>";
            }else{
                $scores1 = "<b style='color:red; font-size:17px;'>$scores</b>";
            }


            if($ids_i > 0 || strlen($ids_i) > 2){
                $view_me = "<span class='expose_tbl' ids='$conts'><b>$test_board</b><br><b style='font-size:17px; display:block; line-height:20px; margin-top:4px; background:#FF9'>[Click to View]</b></span> $test_board_f";

            }else{
                $view_me = "<span class='expose_tbl' ids='$conts'><b>$test_board</b></span> $test_board_f";
            }

            if(strlen($mem_ans2) < 2){
                
                $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" data-target="#delete_dv" for_id="'.$id4.'" for_page="stud_ans">
                <span class="fa fa-trash-o"></span></button>';
            }else{
                $btns1 = '';
            }


            $sub_array[] = $conts;
            $sub_array[] = $view_me;
            $sub_array[] = $subject_names;
            $sub_array[] = "$scores1";
            $sub_array[] = $yrs;
            $sub_array[] = $set_time." minutes";
            $sub_array[] = "<font style='color:#06C'>$time_finished1</font>";
            $sub_array[] = $date_taken;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data1('stud_ans', $this->memid, ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('stud_ans', 'users'),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_carts(){
        $fetch_data = $this->sql_models->make_datatables('cart', $this->memid, '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->id1;
            $res_id = $row->res_id.substr(time(), -5);
            $items = $row->titles;
            $paid = $row->paid;
            $price = $row->price;
            $payment_type = $row->payment_type;
            $locatn = $row->locatn;
            $date_posted = $row->date_posted;

            if($locatn=="") $locatn="<i>Not specified</i>";

            if($price<=0) $price1="FREE"; else $price1="&#8358;".@number_format($price);

            if($payment_type=="mp")
                $payment_type1="Manual Payment";
            else if($payment_type=="online")
                $payment_type1="Online Transaction";
            else
                $payment_type1="Free";
            
            if($paid == 1){
                $paid = "<font style='color:#093; cursor:default; font-size:15px;'><b>Paid</b></font>";
            }else{
                if($payment_type==""){
                    $paid = "<b>-----</b>";
                }else{
                    $paid = "<font style='color:red; cursor:default; font-size:13px;'><b>Payment pending...</b></font>";
                }
            }

            $sub_array[] = $conts;
            $sub_array[] = "<a href='".base_url()."resources/view/past-questions/$res_id/' target='_blank'>".ucfirst($items)."</a>";
            $sub_array[] = "<label style='font-size:17px; color:#09C; font-weight:normal'>$price1</label>";
            $sub_array[] = $paid;
            $sub_array[] = $locatn;
            $sub_array[] = $payment_type1;
            $sub_array[] = $date_posted;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data1('cart', $this->memid, ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('cart', $this->memid, '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }




    function submit_my_questions(){
        $this->form_validation->set_rules('txtquestions', 'Question', 'required|trim');
        $this->form_validation->set_rules('txtop1', 'Option A', 'required|trim');
        $this->form_validation->set_rules('txtop2', 'Option B', 'required|trim');
        $this->form_validation->set_rules('txtans', 'Specify Answer', 'required|trim');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $sessions = $this->input->post('txtsess');
            $txtquestions = $this->input->post('txtquestions');
            $txtop1 = $this->input->post('txtop1');
            $txtop2 = $this->input->post('txtop2');
            $txtop3 = $this->input->post('txtop3');
            $txtop4 = $this->input->post('txtop4');
            $txtans = $this->input->post('txtans');
            $txtexplain = $this->input->post('txtexplain');
            $txt_upload_type = $this->input->post('txt_upload_type');
            $quiz_ids = $this->input->post('txtquizid');
            $former_file = $this->input->post('former_file');


            if($txtans=="A") $txtans=$txtop1;
            else if($txtans=="B") $txtans=$txtop2;
            else if($txtans=="C") $txtans=$txtop3;
            else $txtans=$txtop4;
                        
            $path4 = @$_FILES['file_quiz']['name'];
            $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
            $ext4 = strtolower($ext4);
            $img_ext_chk1 = array('jpg','png','jpeg');

            if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['file_quiz']['name']) && @$_FILES['file_quiz']['name'] != "")
                echo "Please select a valid image of the formats jpg, jpeg or png<br>";
            else if(isset($_FILES['file_quiz']['name']) && @$_FILES['file_quiz']['size'] > 2097152)
                echo "The image has exceeded 2MB<br>";
            else{
                $randm = time();
                $rename_file = "$randm.$ext4";
                
                $url_source = "fake_fols/".$rename_file;
                $url_dest = "quizes/".$rename_file;
                
                $new_name4 = $rename_file;
                $data1_img = array();
                if(isset($_FILES['file_quiz']['name']) && @$_FILES['file_quiz']['name'] != ''){
                    $file_tmp = @$_FILES["file_quiz"]["tmp_name"];
                    if(is_uploaded_file($file_tmp) && isset($_FILES['file_quiz']['name']) ){
                        if($quiz_ids != "")
                            $this->sql_models->delete_quiz_pics($former_file);

                        move_uploaded_file($file_tmp, $url_source);
                        //$this->resizeImage($url_source, $url_dest, 650, 650, TRUE);
                        $this->compress($url_source, $url_dest, 55);
                    }
                    $data1_img = array('files' => $new_name4);
                }

                $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                if(is_readable($in_folder1)) @unlink($in_folder1);

                $txtquestions = str_replace("'", "&prime;", $txtquestions);
                $txtop1 = str_replace("'", "&prime;", $txtop1);
                $txtop2 = str_replace("'", "&prime;", $txtop2);
                $txtop3 = str_replace("'", "&prime;", $txtop3);
                $txtop4 = str_replace("'", "&prime;", $txtop4);
                $txtans = str_replace("'", "&prime;", $txtans);
                $txtexplain = str_replace("'", "&prime;", $txtexplain);

                if($quiz_ids==""){
                    $data_quizes = array(
                        'sessions'        => $sessions,
                        'questions'       => $txtquestions,
                        'op1'             => $txtop1,
                        'op2'             => $txtop2,
                        'op3'             => $txtop3,
                        'op4'             => $txtop4,
                        'ans1'            => $txtans,
                        'explanations'    => $txtexplain
                    );
                    $querys = "insert";
                    $quiz_ids = "";

                }else{ // updating....

                    $data_quizes = array(
                        'questions'       => $txtquestions,
                        'op1'             => $txtop1,
                        'op2'             => $txtop2,
                        'op3'             => $txtop3,
                        'op4'             => $txtop4,
                        'ans1'            => $txtans,
                        'explanations'    => $txtexplain
                    );
                    $querys = "update";
                    $quiz_ids=md5($quiz_ids);
                }

                $merge_arrs = array_merge($data1_img, $data_quizes);
                $query1 = $this->sql_models->update_inserts_quizes($merge_arrs, $quiz_ids, $querys, 'quizes2', 'questions');
                if($query1!=0) echo "inserted"; else echo "error";
            }
            
        }
    }




    function upload_my_questions(){
        $sessions = $this->input->post('txtsess');
        $quiz_ids = $this->input->post('txtquizid');

        $path4 = @$_FILES['uploadFile']['name'];
        $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
        $ext4 = strtolower($ext4);
        $img_ext_chk1 = array('xlsx','xls');

        if($ext4=="")
            echo "Please select an excel format to upload<br>";

        else if(!in_array($ext4, $img_ext_chk1) && isset($_FILES['uploadFile']['name']) && @$_FILES['uploadFile']['name'] != "")
            echo "Please select a valid excel formats of xls, xlsx<br>";
        else if(isset($_FILES['uploadFile']['name']) && @$_FILES['uploadFile']['size'] > 6291456)
            echo "The file has exceeded 6MB<br>";

        else{ // upload the excel and add to database
            $path = 'quizes/';
            require_once APPPATH . "third_party/PHPExcel.php";
            //require_once base_url().APPPATH . "third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if(!$this->upload->do_upload('uploadFile')) {
                //$error = array('error' => $this->upload->display_errors());
                echo $this->upload->display_errors();
                //$error = $this->upload->display_errors();
            }else{
                $data = array('upload_data' => $this->upload->data());
                //$error = array('error' => ""); // its empty no error
            
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
            
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;
                    foreach ($allDataInSheet as $value) {
                        if($flag){
                          $flag =false;
                          continue;
                        }

                        if(isset($value['A']) && $value['A']!="" || isset($value['B']) && $value['B']!="" || isset($value['C']) && $value['C']!="" || isset($value['F']) && $value['F']!=""){
                            @$inserdata[$i]['sessions']          = $sessions;
                            @$inserdata[$i]['questions']         = $value['A'];
                            @$inserdata[$i]['op1']               = $value['B'];
                            @$inserdata[$i]['op2']               = $value['C'];
                            @$inserdata[$i]['op3']               = $value['D'];
                            @$inserdata[$i]['op4']               = $value['E'];
                            @$inserdata[$i]['ans1']              = $value['F'];
                            @$inserdata[$i]['explanations']      = $value['G'];
                        }else{
                            echo "Error, the excel file is not in its correct format.";
                            exit;
                        }
                        $i++;
                    }

                    $result=$this->sql_models->update_inserts_quizes($inserdata, $quiz_ids, 'insert_batch', 'quizes2', 'questions');
                    if($result){
                        $in_folder1="quizes/".$data['upload_data']['file_name'];
                        if(is_readable($in_folder1)) @unlink($in_folder1);
                      echo "inserted";
                    }else{
                      echo "Error";
                    }             
     
                } catch (Exception $e) {
                   //die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            //. '": ' .$e->getMessage());
                   echo "Error loading file ".pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' .$e->getMessage();
                }
            }
        }
    }



    function save_quiz_settings1(){
        $this->form_validation->set_rules('txt_board', 'Test Board', 'required|trim');
        //$this->form_validation->set_rules('txt_subj[]', 'Subject', 'required|trim');
        $this->form_validation->set_rules('txt_subj', 'Subject', 'required|trim');
        $this->form_validation->set_rules('txtquiz_time', 'Set Timing', 'required|trim');
        $this->form_validation->set_rules('txtyear', 'Year', 'required|trim');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $txt_board = $this->input->post('txt_board');
            $txt_subj = $this->input->post('txt_subj');
            $txt_sch = $this->input->post('txt_sch');
            $txtquiz_time = $this->input->post('txtquiz_time');
            $txtyear = $this->input->post('txtyear');
            $txtinstruc = $this->input->post('txtinstruc');
            $quiz_ids = $this->input->post('txtquizid');
            $sessions = substr(time(), -6);

            if($quiz_ids==""){
                $data = array(
                    'sessions'      => $sessions,
                    'aprvd'         => 1,
                    'instructn'     => $txtinstruc,
                    'set_time'      => $txtquiz_time,
                    'dates'         => date("Y-m-d g:i a", time())
                );

                $query1 = $this->sql_models->update_inserts_quizes($data, $quiz_ids, 'insert', 'quizes_intro', '');

                $x=0;
                if($query1){
                    if($txt_sch){
                        foreach($txt_sch as $txt_schs){
                            //foreach($txt_subj as $index=>$txt_subj1){
                                $data1[$x]['test_board']    = $txt_board;
                                //$data1[$x]['subject_id']    = $txt_subj1;
                                $data1[$x]['subject_id']    = $txt_subj;
                                $data1[$x]['years']         = $txtyear;
                                $data1[$x]['sessions']      = $sessions;
                                $data1[$x]['name_of_sch']   = $txt_schs;
                                $x++;
                            //}
                        }
                    }else{
                        //foreach($txt_subj as $index=>$txt_subj1){
                            $data1[$x]['test_board']    = $txt_board;
                            //$data1[$x]['subject_id']    = $txt_subj1;
                            $data1[$x]['subject_id']    = $txt_subj;
                            $data1[$x]['years']         = $txtyear;
                            $data1[$x]['sessions']      = $sessions;
                            $data1[$x]['name_of_sch']   = 0;
                            $x++;
                        //}
                    }
                    $sess = $this->sql_models->update_inserts_quizes($data1, $quiz_ids, 'insert_batch', 'quizes', '');
                    $now = 2147483647 - time();
                    $cookie = array(
                        'name'   => 'cookie_sess',
                        'value'  => $sess,
                        'expire' => $now,
                        'secure' => FALSE
                    );
                    set_cookie($cookie);
                    echo "inserted";
                }else{
                    echo "error";
                }

            }else{ // updating....

                $data = array(
                    'instructn'     => $txtinstruc,
                    'set_time'      => $txtquiz_time
                );

                $query1 = $this->sql_models->update_inserts_quizes($data, $quiz_ids, 'update', 'quizes_intro', '');

                $x=0;
                if($query1){
                    if($txt_sch){
                        foreach($txt_sch as $txt_schs){
                            //foreach($txt_subj as $index=>$txt_subj1){
                            foreach($txt_subj as $index=>$txt_subj1){
                                //echo "$quiz_ids<br>";
                                //$mem_ans = $answers[$index];
                                //$data1['sessions'][$x]      = $quiz_ids;
                                // $data1['test_board'][$x]    = $txt_board;
                                // $data1['subject_id'][$x]    = $txt_subj1;
                                // $data1['years'][$x]         = $txtyear;
                                // //$data1[$x]['sessions']      = $sessions;
                                // $data1['name_of_sch'][$x]   = $txt_schs;
                                $x++;

                                $data1 = array( // another style of array
                                   //'sessions'       => $quiz_ids,
                                   'test_board'     => $txt_board,
                                   'subject_id'     => $txt_subj1,
                                   'years'          => $txtyear,
                                   'name_of_sch'    => $txt_schs
                                );
                            }
                        }
                    }else{
                        foreach($txt_subj as $index=>$txt_subj1){
                            //$data1[$x]['sessions']      = $quiz_ids;
                            $data1[$x]['test_board']    = $txt_board;
                            $data1[$x]['subject_id']    = $txt_subj1;
                            $data1[$x]['years']         = $txtyear;
                            $data1[$x]['name_of_sch']   = 0;
                            $x++;
                        }
                    }
                    $sess = $this->sql_models->update_inserts_quizes($data1, $quiz_ids, 'insert_batch', 'quizes', '');
                    $now = 2147483647 - time();
                    $cookie = array(
                        'name'   => 'cookie_sess',
                        'value'  => $sess,
                        'expire' => $now,
                        'secure' => FALSE
                    );
                    set_cookie($cookie);
                    echo "inserted";
                }else{
                    echo "error";
                }

            }
        }
    }





    function post_comments(){
        $this->form_validation->set_rules('txtcname', 'full names', 'required|trim|min_length[7]|max_length[30]');
        $this->form_validation->set_rules('txtcemail', 'email', 'required|trim|valid_email');
        $this->form_validation->set_rules('txtcmessage', 'message', 'required|trim');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txtcname = $this->input->post('txtcname');
            $txtcemail = $this->input->post('txtcemail');
            $txtcmessage = $this->input->post('txtcmessage');
            $txtblogid = $this->input->post('txtblogid');

            $newdata2 = array(
                'rands'        => $txtblogid,
                'names'        => $txtcname,
                'emails'       => $txtcemail,
                'message'      => $txtcmessage,
                'created_at'   => date("Y-m-d g:i a", time())
            );
            //$newdata2 = $this->security->xss_clean($newdata2);
            if($this->sql_models->insert_comments($newdata2)){
                echo "inserted";
            }else{
                echo "Network Error! Try inserting again or refresh the page";
            }
        }
    }


    
    function logmein(){
        $this->form_validation->set_rules('txtuser', 'username', 'required|trim');
        $this->form_validation->set_rules('txtpass', 'password', 'required|trim');

        if($this->form_validation->run() == FALSE){
            $arrs = array('type'=>'error', 'msg'=>validation_errors(), 'memid'=> '');
        }else{
            $data = array(
                'emails' => $this->input->post('txtuser'),
                'passwords' => $this->input->post('txtpass')
            );
            $mem_name = $this->sql_models->get_user_logins($data);
            $memids = $this->sql_models->get_user_ids($data);

            if($mem_name){
                $arrs = array('type'=>'success', 'msg'=>$mem_name, 'memid'=> $memids);
            }else{
                $arrs = array('type' => 'error', 'msg'=>'Invalid login credentials!', 'memid'=> '');
            }
        }
        echo json_encode($arrs);
    }




    function logmein_reset(){
        $this->form_validation->set_rules('txtcode1', 'Code', 'required|trim');
        $this->form_validation->set_rules('txtrpass1', 'password', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('txtrpass2', 'confirm password', 'required|trim|matches[txtrpass1]');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txtrpass1 = $this->input->post('txtrpass1');
            $txtcode1 = $this->input->post('txtcode1');

            $iscode = $this->sql_models->check_existing_codes($txtcode1, 'email_verificatn');

            if($iscode){
                $updated = $this->sql_models->update_password1($txtrpass1, $iscode);

                if($updated){
                    $now = 865000;
                    $cookie = array(
                        'name'         => "tst_pass",
                        'value'        => sha1($txtrpass1),
                        'expire'       => $now,
                        'secure'       => FALSE
                    );
                    set_cookie($cookie);
                    echo "success";
                }else{
                    echo "<p>Error in updating your password</p>";
                }
                
            }else{
                echo "<p>Wrong code entered, please check your email again.</p>";
            }

        }
    }




    public function set_upload_options($file_path) {
        $config = array();
        $config ['upload_path'] = $file_path;
        $config['allowed_types'] = "*";
        $config['max_size'] = '3072'; // 0 = no file size limit
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = FALSE;
        return $this->load->library('upload', $config);
        //return $config;
    }

    

    function logouts(){
        $cookie = array(
            'name'   => 'tst_uname',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );
        $cookie1 = array(
            'name'   => 'tst_pass',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );
        delete_cookie($cookie);
        delete_cookie($cookie1);
        redirect('');
    }




    function logme_adms(){
        $this->form_validation->set_rules('username', 'username', 'required|trim');
        $this->form_validation->set_rules('pass', 'password', 'required|trim');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $is_correct_id = $this->sql_models->auth_details(strtolower($this->input->post('username')), strtolower($this->input->post('pass')));

            if($is_correct_id){
                echo "successor1";
            }else{
                echo "Invalid details entered!";
            }
        }
    }










}






