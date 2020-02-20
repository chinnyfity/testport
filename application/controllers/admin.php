<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//session_start();

class Admin extends CI_Controller {

        public $xauth;
        public $showname;

        public function __construct(){
            parent::__construct();

            $this->load->helper(array('form', 'url', 'html', 'directory', 'cookie', 'file'));
            $this->load->library(array('form_validation', 'security', 'pagination', 'session', 'excel'));
            $this->perPage = 25;
            $this->load->model('sql_models');
            @date_default_timezone_set('Africa/Lagos');

            if(!$this->sql_models->validate_adminx()){
                $this->xauth = 0;
            }else{
                $this->xauth = 1;
            }

            // $this->getid1 = $this->sql_models->getPaidMemIDs1();

            // $this->unread_msg = $this->sql_models->getUnreadMsgCount(0);
            // $this->admin_type = $this->input->cookie('admin_type', TRUE);
            // $this->subadmin_name = $this->sql_models->get_subadmin_name();


            function convertTime($difference){
                //Calculate how many days are within $difference
                $days = intval($difference / 86400); 
                //$days = round($difference / 86400); 
                //Keep the remainder
                $difference = $difference % 86400;
                //Calculate how many hours are within $difference 
                $hours = intval($difference / 3600)+($days*24); 
                //Keep the remainder
                $difference = $difference % 3600;
                //Calculate how many minutes are within $difference 
                $minutes = intval($difference / 60); 
                //Keep the remainder
                $difference = $difference % 60;
                //Calculate how many seconds are within $difference 
                $seconds = intval($difference); 
                //return "Days: ".$days."<br> Hours: ".$hours."<br> Minutes: ".$minutes."<br> Seconds: ".$seconds."<br>";
                //return $hours." hours, ".$minutes." mins more";
                return ($days);
            }
            
        }



    public function login(){
        $data['page_name'] = "login";
        $data['page_title'] = "Login";
        if(!$this->xauth){
            $this->load->view("admin/login", $data);
        }else{
            redirect('admin/');
        }
    }


    function logout(){
        $cookie = array(
            'name'   => 'adm_password_testpt',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );

        $cookie1 = array(
            'name'   => 'adm_username_testpt',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );

        delete_cookie($cookie);
        delete_cookie($cookie1);
        redirect('admin/login');
    }



       // Show view Page
    public function index(){
        if($this->sql_models->validate_adminx()){
            $data['page_name'] = "";
            $data['page_title'] = "Administrator";
            $data['getId'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $data['webviews'] = $this->sql_models->totalCounts('user_locations', '');
            $data['totalmems'] = $this->sql_models->totalCounts('members', '');
            $data['centres_cnt'] = $this->sql_models->totalCounts('centres', '');
            $data['carts_cnt'] = $this->sql_models->totalCounts('cart', '');
            $data['res_cnt'] = $this->sql_models->totalCounts('resources', '');
            $data['tests'] = $this->sql_models->totalCounts('quizes_intro', '');
            $data['fetchMembers'] = $this->sql_models->fetchRecords('members');
            $data['resources1'] = $this->sql_models->fetchRecords('resources');
            $data['url_id'] = "";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    
    
    public function settings(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "settings";
            $data['page_title'] = "Admin Settings";
            $data['url_id'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function cart(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "cart";
            $data['page_title'] = "Cart Items";
            $data['url_id'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function students_performance(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "students_performance";
            $data['page_title'] = "Students Performance";
            $data['url_id'] = "";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function visitors(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "visitors";
            $data['page_title'] = "Our Visitors";
            $data['url_id'] = "";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function resources(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "resources";
            $data['page_title'] = "Resources";
            $data['url_id'] = "";
            $data['counts'] = $this->sql_models->totalCounts('resources', '');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function logos(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "logos";
            $data['page_title'] = "Logos";
            $data['url_id'] = "";
            $data['counts'] = $this->sql_models->totalCounts('logos', '');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function forum(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "forum";
            $data['page_title'] = "Forum/Discussion";
            $data['url_id'] = "";
            $data['counts'] = $this->sql_models->totalCounts('forums', '');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function forum_rep(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "forum_rep";
            $data['page_title'] = "Forum Replies/Discussion";
            $data['url_id'] = "";
            $data['counts'] = $this->sql_models->totalCounts('forums', '');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }

    

    public function upload_advert(){
        $url_id = $this->uri->segment(3);
        $user_types = $this->input->cookie('user_types', TRUE);
        $data['user_types'] = $this->input->cookie('user_types', TRUE);
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "upload_advert";
            $data['page_title'] = "Upload Advert";
            $data['url_id'] = $url_id;
            $data['unread_msg'] = $this->unread_msg;
            $data['getId'] = "";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function edit_advert(){
        $url_id = $this->uri->segment(3);
        $user_types = $this->input->cookie('user_types', TRUE);
        $data['user_types'] = $this->input->cookie('user_types', TRUE);
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "edit_advert";
            $data['page_title'] = "Edit Advert";
            $data['url_id'] = $url_id;
            $data['unread_msg'] = $this->unread_msg;
            $data['getId'] = $this->sql_models->get_ID($url_id, 'adverts');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function add_centres(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $data['show_name'] = "Admin";
            $data['page_name'] = "add_centres";
            $data['page_title'] = "Add Centres";
            $data['getId'] = "";
            $data['tbs'] = $this->sql_models->fetchRecs('test_boards', 'id, test_types');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function add_resources(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $data['show_name'] = "Admin";
            $data['page_name'] = "add_resources";
            $data['page_title'] = "Add Resources";
            $data['getId'] = "";
            $data['tbs'] = $this->sql_models->fetchRecs('test_boards', 'id, test_types');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }

    
    public function add_logo(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $data['show_name'] = "Admin";
            $data['page_name'] = "add_logo";
            $data['page_title'] = "Add Company Logo";
            $data['getId'] = "";
            //$data['tbs'] = $this->sql_models->fetchRecs('logos', 'id, test_types');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function edit_resources(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $data['show_name'] = "Admin";
            $data['page_name'] = "edit_resources";
            $data['page_title'] = "Edit Resources";
            $data['url_id'] = "";
            $data['getId'] = $this->sql_models->get_ID($url_id, 'resources');
            $data['tbs'] = $this->sql_models->fetchRecs('test_boards', 'id, test_types');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function edit_logo(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $data['show_name'] = "Admin";
            $data['page_name'] = "edit_logo";
            $data['page_title'] = "Edit Company Logo";
            $data['url_id'] = "";
            $data['getId'] = $this->sql_models->get_ID($url_id, 'logos');
            $data['tbs'] = $this->sql_models->fetchRecs('logos', 'id, urls');
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function support_ticket(){
        if($this->sql_models->validate_adminx()){
            $data['page_name'] = "support_ticket";
            $data['page_title'] = "Support";
            $data['getId'] = "";
            $data['show_name'] = "Admin";
            $data['unread_msg'] = $this->unread_msg;
            $data['locs'] = $this->sql_models->fetchLocation();
            $data['cats'] = $this->sql_models->fetchCat();
            $data['url_id'] = "";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function set_test(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $url_id1 = $this->uri->segment(4);
            $data['getMainID'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $data['getMainSess'] = "";
            $data['fetchQuests'] = "";
            $data['url_id'] = "";
            $data['url_idx'] = $url_id;
            $data['url_id1'] = $url_id1;
            $data['tbs'] = $this->sql_models->fetchRecs('test_boards', 'id, test_types');
            $data['subjts'] = $this->sql_models->fetchRecs('subjects', 'id, subjs');
            $data['schs'] = $this->sql_models->fetchRecs('schools', 'id, name_of_sch');
            $data['show_name'] = "Admin";
            $data['page_name'] = "set_test";
            $data['page_title'] = "Upload Test";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function edit_test(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $url_id1 = $this->uri->segment(4);
            //if($this->sql_models->check_link($url_id, 'quizes_intro')){
                // $data['getMainID'] = $this->sql_models->getMainID($url_id);
                $data['getQuizes'] = $this->sql_models->getQuizes($url_id);
                $data['getQuizes1'] = $this->sql_models->getQuizes1($url_id);

                // $data['getQuizesID'] = $this->sql_models->getQuizesID($url_id);
                $data['url_id'] = $url_id;
                $data['url_id1'] = $url_id1;
                $data['url_idx'] = $url_id;
                $data['tbs'] = $this->sql_models->fetchRecs('test_boards', 'id, test_types');
                $data['subjts'] = $this->sql_models->fetchRecs('subjects', 'id, subjs');
                $data['schs'] = $this->sql_models->fetchRecs('schools', 'id, name_of_sch');
                $data['show_name'] = "Admin";
                $data['page_name'] = "edit_test";
                $data['page_title'] = "Edit Test";
                $this->load->view("admin/header", $data);
                $this->load->view("admin/index", $data);
            // }else{
            //     redirect('admin/upload_quiz');
            // }
        }else{
            redirect('admin/login');
        }
    }



    public function upload_questions(){
        if($this->sql_models->validate_adminx()){
            //$url_id = $this->uri->segment(3);
            //$url_id1 = $this->uri->segment(4);
            $data['getMainID'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $data['getMainSess'] = "";
            //$data['fetchQuests'] = "";
            $data['url_id'] = "";
            //$data['url_idx'] = $url_id;
            //$data['url_id1'] = $url_id1;
            //$data['tbs'] = $this->sql_models->fetchRecs('test_boards', 'id, test_types');
            //$data['subjts'] = $this->sql_models->fetchRecs('subjects', 'id, subjs');
            //$data['schs'] = $this->sql_models->fetchRecs('schools', 'id, name_of_sch');
            $data['show_name'] = "Admin";
            $data['page_name'] = "upload_questions";
            $data['page_title'] = "Upload Questions";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function edit_questions(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $url_id1 = $this->uri->segment(4);
            if($this->sql_models->check_link($url_id, 'quizes2')){
                $data['getQuizes'] = $this->sql_models->getQuizesID($url_id);
                $data['url_id'] = $url_id;
                $data['url_id1'] = $url_id1;
                $data['url_idx'] = $url_id;
                //$data['tbs'] = $this->sql_models->fetchTestBoards();
                $data['show_name'] = "Admin";
                $data['page_name'] = "edit_questions";
                $data['page_title'] = "Edit Question";
                $this->load->view("admin/header", $data);
                $this->load->view("admin/index", $data);
            }else{
                redirect("admin/viewquestions/$url_id1/");
            }
        }else{
            redirect('admin/login');
        }
    }


    public function uploadblog(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['unread_msg'] = $this->unread_msg;
            $data['show_name'] = "Admin";
            $data['page_name'] = "uploadblog";
            $data['page_title'] = "Upload Blog";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function edit_blog(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            if($this->sql_models->check_link($url_id, 'blogs')){
                $data['url_id'] = $url_id;
                $data['url_id1'] = "";
                $data['unread_msg'] = $this->unread_msg;
                $data['show_name'] = "Admin";
                $data['page_name'] = "edit_blog";
                $data['page_title'] = "Edit Blog";
                $data['getId'] = $this->sql_models->get_ID($url_id, 'blogs');
                $this->load->view("admin/header", $data);
                $this->load->view("admin/index", $data);
            }else{
                redirect('admin/viewblog');
            }
        }else{
            redirect('admin/login');
        }
    }


    public function viewblog(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['unread_msg'] = $this->unread_msg;
            $data['show_name'] = "Admin";
            $data['page_name'] = "viewblog";
            $data['page_title'] = "View Blog";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function edit_centres(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $data['show_name'] = "Admin";
            $data['page_name'] = "edit_centres";
            $data['page_title'] = "Edit Centres";
            $data['url_id'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            //$data['cats'] = $this->sql_models->fetchCat();
            //$data['locs'] = $this->sql_models->fetchLocation();
            $data['getId'] = $this->sql_models->get_ID($url_id, 'centres');
            //$country_id = $data['getId']['country'];
            $data['tbs'] = $this->sql_models->testBoards();
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function members(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "members";
            $data['page_title'] = "View Members";
            $data['url_id'] = "";
            //$data['unread_msg'] = $this->unread_msg;
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function centres(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "centres";
            $data['page_title'] = "View Centres";
            $data['url_id'] = "";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function view_test(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "view_test";
            $data['page_title'] = "View Tests";
            $data['url_id'] = "";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }

    
    public function view_subscription(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "view_subscription";
            $data['url_id'] = "";
            $data['unread_msg'] = $this->unread_msg;
            $data['page_title'] = "View Member Subscription";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function view_advert(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "view_advert";
            $data['page_title'] = "View Adverts";
            $data['url_id'] = "";
            $data['unread_msg'] = $this->unread_msg;
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }

    
    public function subadmins(){
        if($this->sql_models->validate_adminx()){
            if($this->admin_type == sha1('admin')){
                $data['show_name'] = "Admin";
                $data['page_name'] = "subadmins";
                $data['url_id'] = "";
                $data['unread_msg'] = $this->unread_msg;
                $data['page_title'] = "View Sub Admins";
                $this->load->view("admin/header", $data);
                $this->load->view("admin/index", $data);
            }else{
                redirect('admin/');    
            }
        }else{
            redirect('admin/login');
        }
    }


    public function leader_board(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "leader_board";
            $data['unread_msg'] = $this->unread_msg;
            $data['page_title'] = "View Leader Board";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function quiz_winners(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "quiz_winners";
            $data['unread_msg'] = $this->unread_msg;
            $data['page_title'] = "Quiz Winners";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }


    public function winners(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $url_id = substr($url_id, 0, -5);
            if($this->sql_models->check_link(md5($url_id), 'scholarships')){
                $campg = $this->sql_models->fetchCampaigns_single($url_id, '');
                $data['url_id'] = $url_id;
                $data['url_id'] = "";
                $data['url_id1'] = "";
                $data['campname'] = $campg['titles'];
                $data['show_name'] = "Admin";
                $data['page_name'] = "winners";
                $data['unread_msg'] = $this->unread_msg;
                $data['page_title'] = "Quiz Winners";
                $this->load->view("admin/header", $data);
                $this->load->view("admin/index", $data);
            }else{
                redirect('admin/login');
            }
        }else{
            redirect('admin/login');
        }
    }


    public function viewquiz(){
        if($this->sql_models->validate_adminx()){
            $data['show_name'] = "Admin";
            $data['page_name'] = "viewquiz";
            $data['page_title'] = "View Quiz";
            $data['url_id'] = "";
            $data['unread_msg'] = $this->unread_msg;
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function viewquestions(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $data['url_id'] = $url_id;
            //$data['unread_msg'] = $this->unread_msg;
            $data['show_name'] = "Admin";
            $data['page_name'] = "viewquestions";
            $data['page_title'] = "View Questions";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }



    public function view_application(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['unread_msg'] = $this->unread_msg;
            $data['page_name'] = "view_application";
            $data['page_title'] = "View Applications";
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
        }else{
            redirect('admin/login');
        }
    }




    public function update_password(){
        if($this->sql_models->validate_adminx()){
            $data['page_name'] = "changepasswords";
            $data['page_title'] = "Change Password";
            $data['url_id'] = "";
            $data['unread_msg'] = $this->unread_msg;
            $this->load->view("admin/header", $data);
            $this->load->view("admin/index", $data);
            //$this->load->view("admin/footer");
        }else{
            redirect('admin/login');
        }
    }



    public function fetch_all_logos(){
        $fetch_data = $this->sql_models->make_datatables('logos', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->id;
            $urls = $row->urls;
            $files = $row->files;
            $dates = $row->dates;
            
            if($files!=""){
                $files1 = "<img src='".base_url()."images/logos/$files' id='im10'>";
            }else{
                $files1 = "";
            }

            $btns1 = '<button class="btn btn-primary btn-xs edit_me" mypage="edit_logo" captn="0" data-title="Edit" data-toggle="modal" data-target="#myPopup_" id="'.md5($ids).'"><span class="fa fa-pencil"></span> </button> &nbsp;';

            $btns1 .= '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="forums">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = "<a href='$urls' target='_blank'>$urls</a>";
            $sub_array[] = $files1;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('logos', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('logos', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_all_forum(){
        $fetch_data = $this->sql_models->make_datatables('forums', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->ids;
            $fulls = ucwords($row->names);
            $topics = $row->topics;
            $messages = nl2br($row->messages);
            $views = $row->views;
            $files = $row->files;
            $dates = $row->dates;
            $repliesCount = $this->sql_models->getrepliesCount($ids);

            $ttls = $this->sql_models->getTopicName($topics, 'id', 'test_boards', 'test_types', 'row');
            
            if($files!=""){
                $files1 = "<img src='".base_url()."forum_files/$files' id='im10'>";
            }else{
                $files1 = "";
            }

            $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="forums">
            <span class="fa fa-trash-o"></span></button>';
            
            $sub_array[] = $conts;
            $sub_array[] = $fulls;
            $sub_array[] = $ttls;
            $sub_array[] = $repliesCount;
            $sub_array[] = $views;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $sub_array[] = $messages;
            $sub_array[] = $files1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('forums', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('forums', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    public function fetch_all_forum_rep(){
        $fetch_data = $this->sql_models->make_datatables('forum_reply', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->ids;
            $fulls = ucwords($row->names);
            $messages = nl2br($row->messages);
            $replies = $row->replies;
            $replies1 = $replies;
            $files = $row->files;
            $dates = $row->dates;
            $memid1 = $row->memid1;
            if(strlen($replies) > 120){
                $replies=substr($replies,0,120);
                $replies=$replies.'..';
            }
            $replies = nl2br($replies);
            $repliedto = $this->sql_models->getMemberID($memid1);
            
            if($files!=""){
                $files1 = "<img src='".base_url()."forum_files/$files' id='im10'>";
            }else{
                $files1 = "";
            }

            $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="forum_reply">
            <span class="fa fa-trash-o"></span></button>';
            
            $sub_array[] = $conts;
            $sub_array[] = ucfirst($replies);
            $sub_array[] = $fulls;
            $sub_array[] = $repliedto;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $sub_array[] = ucfirst($messages);
            $sub_array[] = ucfirst($replies1);
            $sub_array[] = $files1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('forums', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('forums', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    


    public function fetch_questions(){
        $url_task = $this->uri->segment(3);
        $fetch_data = $this->sql_models->make_datatables('quizes2', $url_task, $url_task);
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $id4 = $row->id1;
            $questions = ucfirst($row->questions);
            $files = $row->files;
            $op1 = ucwords($row->op1);
            $op2 = ucwords($row->op2);
            $op3 = ucwords($row->op3);
            $op4 = ucwords($row->op4);
            $ans1 = ucwords($row->ans1);
            $explanations = $row->explanations;

            if($files!="")
            $files1 = "<img src='".base_url()."quizes/$files' id='im10'>";
            else
            $files1 = "";

            $btns1 = '<button class="btn btn-primary btn-xs edit_me" mypage="edit_questions" captn="0" data-title="Edit" data-toggle="modal" data-target="#myPopup_" id="'.md5($id4).'" url_task="'.$url_task.'"><span class="fa fa-pencil"></span> </button> &nbsp;';

            $btns1 .= '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$id4.'" for_page="trivia">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = $btns1;
            $sub_array[] = $questions;
            $sub_array[] = $files1;
            $sub_array[] = $op1;
            $sub_array[] = $op2;
            $sub_array[] = $op3;
            $sub_array[] = $op4;
            $sub_array[] = $ans1;
            $sub_array[] = $explanations;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('quizes2', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('quizes2', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    function fetch_resources(){
        $txtmem = $this->uri->segment(3);
        $fetch_data = $this->sql_models->make_datatables('resources', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->id;
            $ids2 = $ids.substr(time(), -5);
            $media_type = $row->media_type;
            $test_board = $row->test_board;
            $titles = ucfirst($row->titles);
            $descrip = $row->descrip;
            $img_cover = $row->img_cover;
            $files = $row->files;
            $file_type = $row->file_type;
            $price = $row->price;
            $years = $row->years;
            $views = $row->views;
            $downloads = $row->downloads;
            $date_posted = $row->date_uploaded;
            if($price<=0) $price1="FREE"; else $price1="&#8358;".@number_format($price);

            $test_board1 = $this->sql_models->fetchBoards($test_board);
            $test_types2 = "";
            foreach ($test_board1 as $row) {
                $test_types1 = $row['test_types'];
                $test_types2 .= "$test_types1, ";
            }
            $test_types2 = substr($test_types2, 0, -2);

            $media_files = base_url()."resourcesfiles/$files";
            $media_files1 = "./resourcesfiles/$files";
            if($img_cover!="")
                $media_img = base_url()."resourcesfiles/$img_cover";
            else
                $media_img = base_url()."images/no-video.jpg";

            if($media_type=="vid"){
                $media_type1="Video";
                $lnks = "tutorial-videos";
            }else{
                $media_type1="File";
                $lnks = "past-questions";
            }

            $fsize = filesize($media_files1); // bytes
            if($fsize>921600)
                $fsize = round($fsize / 1024 / 1024, 1)."MB"; // kilobytes with two 
            else
                $fsize = round($fsize / 1024, 2)."KB"; // kilobytes with two 

            $files2 = "<a href='$media_files' target='_blank'>$files</a>";
            $files3 = "<img src='$media_img' id='im10'>";
            
            $btns1 = '<button class="btn btn-primary btn-xs edit_me" mypage="edit_resources" data-title="Edit" data-toggle="modal" 
                data-target="#myPopup_" id="'.md5($ids).'" url_task=""><span class="fa fa-pencil"></span> </button> &nbsp;';
            
            $btns1 .= '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="upload_centres">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = "<a href='".base_url()."resources/view/$lnks/$ids2/' target='_blank'>".$titles."</a>";
            $sub_array[] = $test_types2;
            $sub_array[] = $fsize;
            $sub_array[] = "<label style='font-size:16px; color:#09C; font-weight:normal'>$price1</label>";
            $sub_array[] = $years;
            $sub_array[] = $media_type1;
            $sub_array[] = $views;
            $sub_array[] = $downloads;
            $sub_array[] = ucwords($file_type);
            $sub_array[] = $date_posted;
            $sub_array[] = $files2;
            $sub_array[] = $files3;
            $sub_array[] = $descrip;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('resources', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('resources', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }




    public function fetch_LB(){
        $fetch_data = $this->sql_models->make_datatables('stud_ans', 'lb', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->sa_id;
            $names = ucwords($row->names);
            $titles = $row->titles;
            $scores = $row->scores;
            $scholarship_id = $row->scholarship_id;
            $time_finished = $row->time_finished;
            $coins = $row->coins;
            $answers = $row->answers;
            $date_taken = $row->date_taken;
            $date_taken = date("D jS M, Y h:ia", $date_taken);
            $countQuiz = $this->sql_models->countQuiz($scholarship_id);

            $answers = explode('||', $answers);
            $answers1 = count($answers);
            if($countQuiz <= 0)
                $attempted = "<i style='color:#777'>No questions attempted</i>";
            else
                $attempted = "Attempted <b>$answers1 questions</b> out of <b>$countQuiz</b>";

            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = ucfirst($titles);
            $sub_array[] = "<b>$scores%</b>";
            $sub_array[] = "$attempted";
            $sub_array[] = $time_finished;
            $sub_array[] = "<b>$coins</b>";
            $sub_array[] = $date_taken;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('stud_ans', 'lb'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('stud_ans', 'lb', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }




    public function fetch_performance(){
        $fetch_data = $this->sql_models->make_datatables('stud_ans', 'users', '');
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
            $years = $this->sql_models->fetchSubjYears($subject_id, 'arrays', $test_board_id);
            $yrs="";
            if($years){
                foreach($years as $years1){
                    $yrs .= $years1['years'].", ";
                }
                $yrs=substr($yrs, 0, -2);
            }

            $mins1 = round($time_finished/60);
            $time_finished1 = $mins1." minutes";


            $myPerform=$this->sql_models->showMyPerformanceTbl($id4, $subject_id, '', $test_board_id);
            $ids = $myPerform['ids'];
            $answers = $myPerform['answers'];

            $ids = explode(',', $ids);
            $answers = explode('||', $answers);

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
                        //echo $ids1."ss<br>";
                        $mem_ans = $answers[$index];
                        $get_quiz_origin = $this->sql_models->getQuizOrigin($ids1);
                        if($get_quiz_origin){
                            $questions1 = $get_quiz_origin['questions'];
                            $ans1 = $get_quiz_origin['ans1'];
                            $explanations = $get_quiz_origin['explanations'];
                            if($explanations=="") $explanations="<i style='color:#666;'>None</i>";

                            if($ans1 == $mem_ans){
                                $ticks = "<img src='".base_url()."images/tick2.png' style='width:15px !important'>";
                            }else{
                                $ticks = "<img src='".base_url()."images/wrong.png' style='width:14px !important'>";
                            }

                            if($mem_ans=="nill") $mem_ans="<label style='font-size:13px; color:#FF5E5E'>Not answered</label>";
                            $mem_ans = ucfirst($mem_ans);
                            $counts1 = $index+1;

                            $myanswers .= "<tr><td>$counts1</td>
                            <td>$questions1</td>
                            <td style='color:#666'>$mem_ans</td>
                            <td style='text-align: center;'>$ticks</td>
                            <td style='color:#666'>$ans1</td>
                            <td style=''>$explanations</td>
                            </tr>";
                        // }else{
                        //     $myanswers .= "<tr><td colspan='6' style='text-align:center'><b>No records found!</b></td></tr>";
                        //     break;
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


            $sub_array[] = $conts;
            $sub_array[] = "<span class='expose_tbl' ids='$conts'><b>$test_board</b><br><b style='font-size:17px; display:block; line-height:20px; margin-top:4px; background:#FF9'>[Click to View]</b></span> $test_board_f";
            $sub_array[] = $subject_names;
            $sub_array[] = "$scores1";
            $sub_array[] = $yrs;
            $sub_array[] = $set_time." minutes";
            $sub_array[] = "<font style='color:#06C'>$time_finished1</font>";
            $sub_array[] = $date_taken;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data1('stud_ans', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('stud_ans', 'users'),
            "data"              =>  $data
        );
        echo json_encode($output);
    }




    public function fetch_carts(){
        $fetch_data = $this->sql_models->make_datatables('cart', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->id1;
            $res_id = $row->res_id.substr(time(), -5);
            $memid = $row->memid;
            $phone = $row->phone;
            if($phone!="") $phone="<a href='tel:+$phone'>($phone)</a>";
            $names = ucwords($row->names)."<p style='margin-top:4px;'>$phone</p>";
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
                    $paid = "<font class='approve_me' tbls='cart' columns='paid' caps='Payment pending...' id='approve_me$ids' id1='$ids' style='color:red; cursor:pointer; font-size:13px;'><b>Payment pending...</b></font>";
                }
            }

            $sub_array[] = $conts;
            $sub_array[] = $names;
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
            "recordsTotal"      =>  $this->sql_models->get_all_data('cart', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('cart', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_visitors(){
        $fetch_data = $this->sql_models->make_datatables('user_locations', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $statee = $row->statee;
            //$citys = $row->citys;
            $countVisitors = $this->sql_models->countVisitors($statee, 'user_locations');

            $sub_array[] = $conts;
            //$sub_array[] = "sss";
            $sub_array[] = $statee;
            $sub_array[] = "<b style='font-size:16px; color:#09C'>$countVisitors</b>";
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('user_locations', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('user_locations', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    function addOrdinalNumberSuffix($num) {
        if (!in_array(($num % 100),array(11,12,13))){
          switch ($num % 10) {
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
          }
        }
        return $num.'th';
    }



    public function fetch_winners1(){
        $url_id = substr($this->uri->segment(3), 0, -5);
        $fetch_data = $this->sql_models->make_datatables('stud_ans', 'lb', $url_id);
        $data = array();
        $conts = 1;
        $conts1 = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->sa_id;
            $names = ucwords($row->names);
            $scores = $row->scores;
            $time_finished = $row->time_finished;
            $coins = $row->coins;
            $date_taken = $row->date_taken;
            $date_taken = date("D jS M, Y h:ia", $date_taken);

            if($scores > 0)
                $conts1 = "<b style='color:#F60'>".$this->addOrdinalNumberSuffix($conts1)."</b>";
            else
                $conts1 = "<b>0</b>";

            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = "<b>$scores%</b>";
            $sub_array[] = $conts1;
            $sub_array[] = $time_finished." minutes";
            $data[] = $sub_array;
            $conts++;
            $conts1++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('stud_ans', 'lb'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('stud_ans', 'lb', $url_id, '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }




    public function fetch_all_blogs(){
        $fetch_data = $this->sql_models->make_datatables('blogs', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->id;
            $rands = $row->rands;
            $titles = ucwords($row->titles);
            $descrip = $row->descrip;
            $views = $row->views;
            $dates = $row->created_at;
            $files = $this->sql_models->getBlogPics('blog_media', $rands);

            $myphotos="";
            if($files):
                $myphotos="<div class='evnt_pics'>";
                foreach($files as $rws)
                {
                    $files1 = $rws['files'];
                    $exts = pathinfo($files1, PATHINFO_EXTENSION);
                    $myphotos .= "<img src='".base_url()."blogs/$files1' id='im10'>";
                }
                $myphotos .= "</div>";
            endif;
            
            $btns1 = '<button class="btn btn-primary btn-xs edit_blog" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.md5($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;';

            if($this->admin_type == sha1('admin')){
                $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
                data-target="#delete_dv" for_id="'.$ids.'" for_page="events">
                <span class="fa fa-trash-o"></span></button>';
            }else{
                $btns1 = '<button class="btn btn-danger btn-xs no_delete"><span class="fa fa-trash-o"></span></button>';
            }
            
            $sub_array[] = $conts;
            $sub_array[] = $titles;
            $sub_array[] = $views;
            $sub_array[] = $dates;
            $sub_array[] = $descrip;
            $sub_array[] = $myphotos;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('blogs', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('blogs', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    

    public function logme_adm(){
        $this->form_validation->set_rules('txtuser', 'username', 'required|trim');
        $this->form_validation->set_rules('txtpas1s', 'password', 'required|trim');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $data = array(
                'emails' => $this->input->post('txtuser'),
                'pass1'=> sha1($this->input->post('txtpas1s'))
                    );
            $is_correct = $this->sql_models->get_admin_logins($data);
            if($is_correct){
                $user_mail = $this->input->post('txtuser');
                $user_mail = sha1(strtolower($user_mail));
                $user_pass = sha1($this->input->post('txtpas1s'));

                $newdata = array(
                    'adm_uname_ider'  => $user_mail,
                    'pass1s_ider'     => $user_pass,
                    'logged_in_ider' => TRUE
                );
                $this->session->set_userdata($newdata);
                    echo "success1";
                
            }else{
                
                echo "Login credentials do not match!";

            }
        }
    }

    

    public function delete_rows(){
        $txtall_id = $this->input->post('txtall_id');
        $txt_dbase_table = $this->input->post('txt_dbase_table');
        $is_deleted = $this->sql_models->do_delete($txtall_id, $txt_dbase_table);

        if($is_deleted){
            echo "deleted";
        }else{
            echo "Failed! Network connection error!";
        }
    }



    public function delete_records(){
        $txtall_id = $this->input->post('txtall_id');
        $txt_dbase_table = $this->input->post('txt_dbase_table');
        $is_deleted = $this->sql_models->do_delete($txtall_id, $txt_dbase_table);
         if($is_deleted)
            echo 1;
         else
            echo 0;
    }




    function fetch_centres(){
        $txtmem = $this->uri->segment(3);
        $fetch_data = $this->sql_models->make_datatables('centres cen', $txtmem, '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $id = $row->id;
            $test_boards = $row->test_types;
            $centre_name = ucwords($row->centre_name);
            $approved = $row->approved;
            $locations = $row->locations;
            $views = $row->views;
            $dates = $row->date_posted;
            $dates = date("D jS M, Y h:ia", strtotime($dates));

            if($approved == 1){
                if($txtmem<=0){
                    $approved_1 = "<font class='approve_me' tbls='centres' columns='approved' caps='Approved' id='approve_me$id' id1='".$id."' style='color:#090; font-size:16.5px; cursor:pointer'><b>Approved</b></font>";
                }else{
                    $approved_1 = "<font style='color:#090; font-size:16.5px;'><b>Approved</b></font>";
                }

            }else{
                if($txtmem<=0){
                    $approved_1 = "<font class='approve_me' tbls='centres' columns='approved' caps='Not Approved' id='approve_me$id' id1='".$id."' style='color:red; font-size:16.5px; cursor:pointer'><b>Not Approved</b></font>";
                }else{
                    $approved_1 = "<font style='color:red; font-size:16.5px;'><b>Not Approved</b></font>";
                }
            }

            $btns1 = '<button class="btn btn-primary btn-xs edit_me" mypage="edit_centres" usertype="'.$txtmem.'" data-title="Edit" data-toggle="modal" 
                data-target="#myPopup_" id="'.md5($id).'" url_task=""><span class="fa fa-pencil"></span> </button> &nbsp;';
            
            $btns1 .= '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$id.'" for_page="upload_centres">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = $centre_name;
            $sub_array[] = $test_boards;
            $sub_array[] = $approved_1;
            $sub_array[] = $locations;
            $sub_array[] = $views;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('centres cen', $txtmem, ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('centres cen', $txtmem, ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    function fetch_tickets(){
        $txtmem = $this->uri->segment(3);
        $msg_types = $this->uri->segment(4);
        $fetch_data = $this->sql_models->make_datatables('support', $txtmem, $msg_types);
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $id = $row->id1;
            $sent_from = $row->sent_from;
            $memid1 = $row->memid;
            $names = $row->names;
            $subj = ucfirst($row->subj);
            $message = $row->message;
            $message_1 = nl2br($message);
            $subj1 = base64_encode($subj);
            $message1 = base64_encode($message_1);
            $has_read = $row->has_read;
            $dates = $row->date_posted;
            $dates = date("D jS M, Y h:ia", strtotime($dates));
            if(strlen($message)>100)
                $message = substr($message, 0, 100)."...";

            if($msg_types=="inbox"){
                if($memid1 == $this->getid1)
                    $names1 = "Admin";
                else
                    $names1 = ucwords($names);

            }else{ // sent

                if($sent_from == $this->getid1)
                    $names1 = "Admin";
                else
                    $names1 = ucwords($names);
            }


            $has_read1 = "";
            if($has_read == 1){
                $has_read1 .= "<i style='color:#999; font-size:14px;' class='php_read$id'>Read</i>";
            }else{
                $has_read1 .= "<font style='color:#090; font-size:13px;' class='php_read$id'><b>New Message</b></font>";
            }
            $has_read1 .= "<i style='color:#999; font-size:14px; display:none;' class='java_read$id'>Read</i>";

            $sub_array[] = $names1;
            $sub_array[] = $has_read1;
            $sub_array[] = "<span data-toggle='modal' data-target='#open_message' class='open_message' subj='$subj1' msgs='$message1' msg_id='$id' memid1='$memid1' sent_from='$sent_from' myname='$names1' mydate='$dates'>$subj</span>";
            $sub_array[] = "<span data-toggle='modal' data-target='#open_message' class='open_message' subj='$subj1' msgs='$message1' msg_id='$id' memid1='$memid1' sent_from='$sent_from' myname='$names1' mydate='$dates'>$message</span>";
            $sub_array[] = $dates;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('support', $txtmem),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('support', $txtmem),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    


    function fetch_adverts(){
        $txtmem = $this->uri->segment(3);
        $fetch_data = $this->sql_models->make_datatables('adverts', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $id = $row->id;
            $image = $row->image;
            $banner = $row->banner;
            $expiry = $row->expiry;
            $duration = $row->durations;
            $created_at = $row->created_at;

            if($image=="")
                $image1 = "No image";
            else{
                $image1 = base_url()."adverts/$image";
                $image1 = "<img src='$image1' style='width:auto !important;'>";
            }

            if($expiry <= 0)
                $expiry1 = "<i style='color:#777; font-weight:normal'>No Expiry</i>";
            else{
                if($expiry < time())
                    $expiry1 = "<label style='color:red'>Expired ($duration)</label>";
                else
                    $expiry1 = date("D jS M, Y h:ia", $expiry);
            }

            $created_at = date("D jS M, Y h:ia", strtotime($created_at));


            if($banner == "skyscraper") $banner1 = "Skyscraper (600w x 74h)";
            else if($banner == "square") $banner1 = "Square (300w x 250h)";
            else if($banner == "rectangle") $banner1 = "Rectangle (750w x 150h)";
            else $banner1 = "Leaderboard (289 x 373)";

            $btns1 = '<button class="btn btn-primary btn-xs edit_adv" usertype="'.$txtmem.'" data-title="Edit" data-toggle="modal" 
                data-target="#myPopup_" id="'.md5($id).'"><span class="fa fa-pencil"></span> </button> &nbsp;';
            
            if($this->admin_type == sha1('admin') || $txtmem > 0){
                $btns1 .= '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
                data-target="#delete_dv" for_id="'.$id.'" for_page="">
                <span class="fa fa-trash-o"></span></button>';
            }else{
                $btns1 .= '<button class="btn btn-danger btn-xs no_delete">
                <span class="fa fa-trash-o"></span></button>';
            }
            
            $sub_array[] = $conts;
            $sub_array[] = $banner1;
            $sub_array[] = $expiry1;
            $sub_array[] = $created_at;
            $sub_array[] = $image1;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('adverts', $txtmem),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('adverts', $txtmem),
            "data"              =>  $data
        );
        echo json_encode($output);
    }





    function fetch_members(){
        $fetch_data = $this->sql_models->make_datatables('members', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->id;
            $names = ucwords($row->names);
            $emails = $row->emails;
            $phones = $row->phone;
            $gender = $row->gender;
            $approved = $row->approved;
            if($gender=="m") $gender="Male";
            if($gender=="f") $gender="Female";
            $ipaddr = $row->location;
            $dates = $row->created_at;
            $dates = date("D jS M Y h:ia", strtotime($dates));
            $getLoc = $this->sql_models->getLoc($ipaddr);

            if($approved == 0){
                $approved_1 = "<font class='approve_me' tbls='members' columns='approved' caps='Approved' id='approve_me$ids' id1='$ids' style='color:#090; cursor:pointer; font-size:16.5px;'><b>Approved</b></font>";
            }else{
                $approved_1 = "<font class='approve_me' tbls='members' columns='approved' caps='Blocked' id='approve_me$ids' id1='$ids' style='color:red; cursor:pointer; font-size:16.5px;'><b>Blocked</b></font>";
            }

            //$paid = "<font class='approve_me' tbls='cart' columns='paid' caps='Payment pending...' id='approve_me$ids' id1='$ids' style='color:red; cursor:pointer; font-size:13px;'><b>Payment pending...</b></font>";
            
            $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="members">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = $approved_1;
            $sub_array[] = $names;
            $sub_array[] = "<a style='color:#09C;' href='mailto:$emails'>$emails</a>";
            $sub_array[] = "<a style='color:#09C;' href='tel:$phones'>$phones</a>";
            $sub_array[] = $gender;
            $sub_array[] = $getLoc;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('members', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('members', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    function fetch_tests(){
        $fetch_data = $this->sql_models->make_datatables('quizes_intro', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->ids;
            $instructn = $row->instructn;
            $sessions = $row->sessions;
            $aprvd = $row->aprvd;
            $set_time = $row->set_time;
            $test_board = $row->test_board;
            $subject_id = $row->subject_id;
            $years = $row->years;

            //$years = $this->sql_models->getTestYears($sessions);
            //$years = "2016, 2018";
            $test_types = $row->test_types;
            $subjs = $this->sql_models->getTestDetails2($sessions, '', 'subjs', 'ss');
            $subj_ids = $this->sql_models->getTestDetails2($sessions, '', 'subject_id', 'qi');
            $name_of_sch = $this->sql_models->getSchName2($sessions);
            $dates = $row->dates;
            $dates = date("D jS M Y h:ia", strtotime($dates));
            $noOfQuest = $this->sql_models->countQuiz3($test_board, $subj_ids, $years);

            $btns1 = '<button class="btn btn-primary btn-xs edit_me" mypage="edit_test" usertype="" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.md5($ids).'" url_task=""><span class="fa fa-pencil"></span> </button>&nbsp;';
            
            $btns1 .= '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="members">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = $test_types."<p style='line-height:18px; margin-top:5px;'><a href='".base_url()."admin/viewquestions/$sessions/'>View Questions ($noOfQuest)</a></p>";
            $sub_array[] = $subjs;
            $sub_array[] = $name_of_sch;
            $sub_array[] = $years;
            $sub_array[] = $set_time."mins";
            $sub_array[] = $instructn;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('quizes_intro', '', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('quizes_intro', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    function fetch_applicatns(){
        $fetch_data = $this->sql_models->make_datatables('applications', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->appid;
            $names = ucwords($row->names);
            $titles = ucfirst($row->titles);
            $emails = $row->emails;
            $phones = $row->phone;
            $countrys = $row->country;
            $qualification = $row->qualification;
            $briefs = $row->briefs;
            $files = $row->files;
            $created_at = $row->dates;
            $files1 = "<a href='".base_url()."application_files/$files' target='_blank' title='Download file'>$files</a>";

            if($this->admin_type == sha1('admin')){
                $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
                data-target="#delete_dv" for_id="'.$ids.'" for_page="members">
                <span class="fa fa-trash-o"></span></button>';
            }else{
                $btns1 = '<button class="btn btn-danger btn-xs no_delete"><span class="fa fa-trash-o"></span></button>';
            }

            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = $titles;
            $sub_array[] = "<a style='color:#09C;' href='mailto:$emails'>$emails</a>";
            $sub_array[] = "<a style='color:#09C;' href='tel:$phones'>$phones</a>";
            $sub_array[] = $countrys;
            $sub_array[] = $qualification;
            $sub_array[] = $files1;
            $sub_array[] = $briefs;
            $sub_array[] = $created_at;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('applications', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('applications', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_quiz(){
        $fetch_data = $this->sql_models->make_datatables('quizes_intro', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->ids;
            $approved = $row->aprvd;
            $titles = $row->titles;
            //$titles = ucwords($titles);
            $sessions1 = $row->sessions1;
            $set_time = $row->set_time;
            //$timings = $row->timings;
            $dates = $row->dates;

            if($approved == 1){
                $approved_1 = "<font id='approve_quiz' caps='Approved' class='approve_quiz$ids' id1='".md5($ids)."' style='color:#090; font-size:16.5px; cursor:pointer'><b>Approved</b></font>";
            }else{
                $approved_1 = "<font id='approve_quiz' caps='Not Approved' class='approve_quiz$ids' id1='".md5($ids)."' style='color:red; font-size:16.5px; cursor:pointer'><b>Not Approved</b></font>";
            }
            
            $btns1 = '<button class="btn btn-primary btn-xs edit_quiz" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.md5($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;';
            

            if($this->admin_type == sha1('admin')){
                $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
                data-target="#delete_dv" for_id="'.$ids.'" for_page="quizes_intro">
                <span class="fa fa-trash-o"></span></button>';
            }else{
                $btns1 = '<button class="btn btn-danger btn-xs no_delete"><span class="fa fa-trash-o"></span></button>';
            }

            $sub_array[] = $conts;
            $sub_array[] = ucfirst($titles)."<br><a href='".base_url()."admin/viewquestions/$sessions1/' style='color:#09C'>(View this)</a>";
            $sub_array[] = $approved_1;
            $sub_array[] = $set_time;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('quizes_intro', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('quizes_intro', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_mem_subs(){
        $fetch_data = $this->sql_models->make_datatables('member_subscription', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->id;
            $names = ucwords($row->names);
            $emails = $row->emails;
            $subscription = $row->subscription;
            $expiry = $row->expiry;
            $payment_type = $row->payment_type;
            $paid = $row->paid;
            $created_at = $row->created_at;

            if($expiry == 0){
                $expiry = "<b>-----</b>";
            }else{
                $expiry = @date("jS M, Y", $expiry);
            }

            if($subscription == 0){
                $subscription1 = "<b>-----</b>";
            }
            if($subscription == 3){
                $subscription1 = "Monthly (3 USD)";
            }
            if($subscription == 15){
                $subscription1 = "Yearly (15 USD)";
            }
            // if($subscription == 99){
            //     $subscription1 = "Yearly (99 USD)";
            // }

            if($payment_type=="mp")
                $payment_type1="Manual Payment";
            else if($payment_type=="online")
                $payment_type1="Online Transaction";
            else
                $payment_type1="Free User";
            
            if($paid == 1){
                $paid = "<font style='color:#093; cursor:default; font-size:14px;'><b>Paid</b></font>";
            }else{
                if($payment_type==""){
                    $paid = "<b>-----</b>";
                }else{
                    $paid = "<font id='approve_paid' class='approve_paid$ids' ids='$ids' subscription='$subscription' names='$names' emails='$emails' style='color:red; cursor:pointer; font-size:13px;'><b>Payment pending...</b></font>";
                }
            }

            if($this->admin_type == sha1('admin')){
                $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
                data-target="#delete_dv" for_id="'.$ids.'" for_page="view_subscription">
                <span class="fa fa-trash-o"></span></button>';
            }else{
                $btns1 = '<button class="btn btn-danger btn-xs no_delete"><span class="fa fa-trash-o"></span></button>';
            }


            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = $subscription1;
            $sub_array[] = $paid;
            $sub_array[] = $payment_type1;
            $sub_array[] = $expiry;
            $sub_array[] = $created_at;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('member_subscription', ''),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('member_subscription', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



}
