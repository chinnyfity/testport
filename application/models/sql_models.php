<?php

class Sql_models extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }



    function fetchLocation(){
        $SQL1 = "SELECT DISTINCT id, name FROM countries";
        $SQL2 = "SELECT DISTINCT id, name FROM states WHERE country_id=160";
        $SQL3 = "$SQL1 UNION $SQL2";
        $query = $this->db->query($SQL3);
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function delete_quiz_pics($file1){
        $in_folder1 = "quizes/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }


    function testBoards(){
        $this->db->select('*');
        $this->db->from('test_boards');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function fetchCat(){
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->order_by('cats', 'asc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchStates($country_id){
        $SQL1 = "SELECT DISTINCT id, name FROM states WHERE country_id=160";
        $SQL2 = "SELECT DISTINCT id, citys as name FROM user_locations WHERE statee!=NULL";
        $SQL3 = "$SQL1 UNION $SQL2";
        $query = $this->db->query($SQL3);
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }




    function countComments($blog_id){
        $this->db->select('count(bc.id) as allcount')->from('blog_comments bc')->where('bc.rands', $blog_id);
        $this->db->join('blogs', 'blogs.id = bc.rands');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }


    
    function deleteTblRecords($txt_dbase_table, $txtall_id){

        if($txt_dbase_table == "members"){
            $this->db->select('pics')->from('members')->where('id', $txtall_id);
            $query = $this->db->get();
            $files = $query->row('pics');
            $in_folder1="profile_pics/$files";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('memid', $txtall_id);
            $this->db->delete('cart');

            $this->db->select('files')->from('forums')->where('memid', $txtall_id);
            $query = $this->db->get();
            $files = $query->row('files');
            $in_folder1="forum_files/$files";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->select('files')->from('forum_reply')->where('memid', $txtall_id);
            $query = $this->db->get();
            $files = $query->row('files');
            $in_folder1="forum_files/$files";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('memid', $txtall_id);
            $this->db->delete('forums');

            $this->db->where('memid', $txtall_id);
            $this->db->delete('stud_ans');

            $this->db->where('memid', $txtall_id);
            $this->db->delete('stud_start_test');

            $this->db->where('id', $txtall_id);
            $query = $this->db->delete('members');
        }
        

        if($txt_dbase_table == "performance"){
            $this->db->where('id', $txtall_id);
            $this->db->delete('stud_ans');
        }


        if($txt_dbase_table == "centres"){
            $this->db->where('id', $txtall_id);
            $this->db->delete('centres');
        }


        if($txt_dbase_table == "logos"){
            $this->db->select('files')->from('logos')->where('id', $txtall_id);
            $query1 = $this->db->get();
            $files1 = $query1->row('files');

            $in_folder1="images/logos/$files1";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('id', $txtall_id);
            $this->db->delete('logos');
        }


        if($txt_dbase_table == "view_test"){
            $this->db->select('sessions')->from('quizes_intro')->where('id', $txtall_id);
            $query1 = $this->db->get();
            $sessions = $query1->row('sessions');

            $this->db->select('files')->from('quizes2')->where('sessions', $sessions);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $query1 = $query->result_array();
                foreach ($query1 as $row) {
                    $files = $row['files'];
                    $in_folder1="quizes/$files";
                    if(is_readable($in_folder1)) @unlink($in_folder1);
                }
            }

            $this->db->where('sessions', $sessions);
            $this->db->delete('quizes');

            $this->db->where('sessions', $sessions);
            $this->db->delete('quizes2');

            $this->db->where('id', $txtall_id);
            $this->db->delete('quizes_intro');
        }


        if($txt_dbase_table == "resources"){
            $this->db->select('files')->from('resources')->where('id', $txtall_id);
            $query1 = $this->db->get();
            $files1 = $query1->row('files');

            $in_folder1="resourcesfiles/$files1";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('id', $txtall_id);
            $this->db->delete('resourcesfiles');
        }


        if($txt_dbase_table == "forum"){
            $this->db->select('files')->from('forums')->where('id', $txtall_id);
            $query1 = $this->db->get();
            $files1 = $query1->row('files');

            $in_folder1="forum_files/$files1";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->select('files')->from('forum_reply')->where('forum_id', $txtall_id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $query1 = $query->result_array();
                foreach ($query1 as $row) {
                    $files = $row['files'];
                    $in_folder1="forum_files/$files";
                    if(is_readable($in_folder1)) @unlink($in_folder1);
                }
            }

            $this->db->where('forum_id', $txtall_id);
            $this->db->delete('forum_reply');

            $this->db->where('id', $txtall_id);
            $this->db->delete('forums');
        }


        if($txt_dbase_table == "forum_rep"){
            $this->db->select('files')->from('forum_reply')->where('id', $txtall_id);
            $query1 = $this->db->get();
            $files1 = $query1->row('files');

            $in_folder1="forum_files/$files1";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('id', $txtall_id);
            $this->db->delete('forum_reply');
        }
        

        if($query) return true; else return false;
    }




    function getQuizes($id){
        $this->db->select('qq.id AS id3, qq.years, qq.test_board');
        $this->db->from('quizes qq')->where('md5(qq.id)', $id);
        //$this->db->join('quizes_intro qi', 'qq.sessions = qi.sessions');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;    
        }
    }


    function getQuizes1($id){
        $this->db->select('qi.id AS ids, qi.set_time, qi.sessions, qi.instructn, qi.aprvd, qq.subject_id, qq.years, qq.test_board');
        $this->db->from('quizes_intro qi')->where('md5(qi.id)', $id);
        $this->db->join('quizes qq', 'qq.sessions = qi.sessions');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;    
        }
    }


    function getQuizDetails($tbl, $sess){
        $this->db->select('tbs.test_types, subs.subjs');
        $this->db->from('quizes qq')->where('qq.sessions', $sess);
        $this->db->join('subjects subs', 'subs.id = qq.subject_id');
        $this->db->join('test_boards tbs', 'tbs.id = qq.test_board');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;    
        }
    }


    function getQuizesID($id){
        $this->db->select('id, sessions, questions, explanations, files, op1, op2, op3, op4, ans1, explanations');
        $this->db->from('quizes2')->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;    
        }
    }



    function create_quiz_intro($data, $qid){
        $set_time = $data['set_time'];
        $txtsel_sch = $data['scholarship_id'];
        $instructn = $data['instructn'];

        $this->db->select('id')->from('quizes_intro')->where('set_time', $set_time)->where('scholarship_id', $txtsel_sch)->where('instructn', $instructn);
        $query = $this->db->get();
        if($query->num_rows() <= 0){
            if($qid!=""){
                $this->db->where('id', $qid)->update('quizes_intro', $data);
            }else{
                $this->db->insert('quizes_intro', $data);
            }
        }

        $this->db->select('sessions1')->from('quizes_intro')->where('set_time', $set_time)->where('scholarship_id', $txtsel_sch);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->row('sessions1');
    }



    public function getPrevQuestions(){
        $this->db->select('sch.titles, qi.dates, qi.sessions1');
        $this->db->from('quizes_intro qi');
        $this->db->join('quizes qz', 'qz.sessions1 = qi.sessions1');
        $this->db->join('scholarships sch', 'sch.id = qi.scholarship_id');
        $this->db->group_by('sch.titles');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    
    public function getFiles($tbl, $rands){
        $this->db->select('id, rands, files');
        $this->db->from($tbl)->where('rands', $rands);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }




    function update_inserts_quizes($data, $txtquizid, $sqls, $tbl, $params){
        $results = false;
        if($txtquizid != ""){
            
            $this->db->where('md5(id)', $txtquizid);
            $query1 = $this->db->update($tbl, $data);
        }else{
            if($sqls=="insert")
                $query1 = $this->db->insert($tbl, $data);
            else
                $query1 = $this->db->insert_batch($tbl, $data);
        }
        //return $this->db->insert_id();

        if($query1) $results = true; else $results = false;

        if($params==""){
            if($results){
                $this->db->select('sessions')->from($tbl);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get();
                if($query->num_rows() > 0){
                    return $query->row('sessions');
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            return ($results) ? true : false;
        }
    }


    public function importData($data) {
        $res = $this->db->insert_batch('quizes', $data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }



    function get_ID($id, $tbl){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }


    
    function fetchRecs($tbl, $coulmns){
        $this->db->select($coulmns);
        $this->db->from($tbl);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchRecs1($tbl, $coulmns, $tbl2, $column_order, $sorts, $memid){
        $this->db->select($coulmns);
        $this->db->from($tbl);
        if($memid!="")
            $this->db->where('crt.memid', $memid);
        $this->db->join($tbl2, 'res.id = crt.prod_id');
        $this->db->order_by($column_order, $sorts);
        $this->db->limit(5);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchPerform($memid){
        $this->db->select('sa.*, mem.names, sa.id AS sa_id, sa.subject_id, sa.time_finished, sa.scores, sa.date_taken, sa.quizintro_id, qi.set_time');
        $this->db->from('stud_ans sa')->where('qi.aprvd', 1);
        
        if($memid != "")
            $this->db->where('sa.memid', $memid);

        $this->db->join('subjects subs', 'subs.id = sa.subject_id');
        $this->db->join('members mem', 'mem.id = sa.memid');
        $this->db->join('quizes_intro qi', 'sa.quizintro_id = qi.id');
        $this->db->limit(5);
        $this->db->order_by('sa.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchLastTest(){
        $this->db->select('subs.subjs, sa.scores, sa.time_finished')->from('stud_ans sa');
        $this->db->join('subjects subs', 'subs.id = sa.subject_id');
        $this->db->order_by('sa.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }




    function storeLocs(){
        $ip = $_SERVER['REMOTE_ADDR'];
        //$ip = "41.190.31.43";
        //$ip = "197.210.10.9";
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        $citys = @$details->city;
        $states = @$details->region;
        if($states != ""){
            $this->db->select('id')->from('user_locations')->where('ipaddrs', $ip)->where('statee', $states);
            $query = $this->db->get();
            if($query->num_rows() <= 0){
                $data = array("ipaddrs" => $ip, "statee" => $states, "citys" => $citys);
                $this->db->insert('user_locations', $data);
            }
        }
        return true;
    }

    



    function fetchPastQuestions($sources, $keywords, $test_board, $page){
        $offset = 15*$page;
        $limit = 15;
        $this->db->select('res.*, res.id AS id1, res.test_board')->from('resources res');

        if($sources=="past-questions"){
            $this->db->where('res.media_type', 'doc');
        }else{
            $this->db->where('res.media_type', 'vid');
        }

        if($test_board!=""){
            $this->db->where("find_in_set('$test_board', res.test_board)");
        }
        
        if($keywords != ""){
            $srchs = "(res.titles like '%$keywords%' OR tbs.test_types like '%$keywords%')";
                $this->db->where("$srchs");
                $this->db->order_by('res.id', 'desc');
        }else{
            $this->db->order_by('res.id', 'desc');
        }

        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function fetchPastQuestionsCounts($sources, $keywords, $test_board, $page){
        $this->db->select('res.id AS id1')->from('resources res');

        if($sources=="past-questions"){
            $this->db->where('res.media_type', 'doc');
        }else{
            $this->db->where('res.media_type', 'vid');
        }

        if($test_board!=""){
            $this->db->where("find_in_set('$test_board', res.test_board)");
        }
        
        if($keywords != ""){
            $srchs = "(res.titles like '%$keywords%' OR tbs.test_types like '%$keywords%')";
                $this->db->where("$srchs");
                $this->db->order_by('res.id', 'desc');
        }else{
            $this->db->order_by('res.id', 'desc');
        }

        $this->db->join('test_boards tbs', 'tbs.id = res.test_board');
        return $this->db->count_all_results();
        
    }



    function getDataCount($tbls, $params, $params2, $keywords, $locs){
        $this->db->select("id");
        $this->db->from($tbls)->where('approved', 1);
        // if($params!="" || $params2!="")
        //     $this->db->where('city', $params2)->or_where('statee', $params);

        if($locs!=""){
            if($locs=="Abuja Federal Capital Territor"){
                $locs="Abuja";
            }
            $srchs = "(cntr.statee like '%$locs%' OR cntr.city like '%$locs%')";
            $this->db->where("$srchs");
        }

        if($params!=""){
            $this->db->where('cntr.statee', $params);
        }

        if($keywords != ""){
            $srchs = "(cntr.centre_name like '%$keywords%' OR cntr.locations like '%$keywords%' OR cntr.statee like '%$keywords%' OR tbs.test_types like '%$keywords%')";
                $this->db->where("$srchs");
                $this->db->order_by('cntr.id', 'desc');
        }else{
            $this->db->order_by('cntr.id', 'desc');
        }

        $this->db->join('test_boards tbs', 'tbs.id = cntr.test_board');
        return $this->db->count_all_results();
    }



    function fetchCentres($tbl, $sorts, $keywords, $locs, $rowno, $rowperpage, $statee, $citys, $wholesearch){
        $this->db->select('cntr.*, cntr.id AS id1, tbs.test_types')->from($tbl)->where('approved', 1);

        if($wholesearch==0){
            if($locs!=""){
                if($locs=="Abuja Federal Capital Territor"){
                    $locs="Abuja";
                }
                $srchs = "(cntr.statee like '%$locs%' OR cntr.city like '%$locs%')";
                $this->db->where("$srchs");
            }

            if($statee!=""){
                $this->db->where('cntr.statee', $statee);
            }

            if($keywords != ""){
                $srchs = "(cntr.centre_name like '%$keywords%' OR cntr.locations like '%$keywords%' OR cntr.statee like '%$keywords%' OR tbs.test_types like '%$keywords%')";
                    $this->db->where("$srchs");
                    $this->db->order_by('cntr.id', 'desc');
            }else{
                $this->db->order_by('cntr.id', 'desc');
            }

        }else{

            if($keywords != ""){
                $srchs = "(cntr.centre_name like '%$keywords%')";
                    $this->db->where("$srchs");
                    $this->db->order_by('cntr.id', 'desc');
            }else{
                $this->db->order_by('cntr.id', 'desc');
            }
        }

        if($rowperpage!="" || $rowno!="")
            $this->db->limit($rowperpage, $rowno);
        $this->db->join('test_boards tbs', 'tbs.id = cntr.test_board');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }





    function fetchPastQuestions_single($id){
        $this->db->select('*')->from('resources')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }




    function getLoc($ip){
        $this->db->select('statee')->from('user_locations')->where('ipaddrs', $ip);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('statee');
        }else{
            return "Not specified";
        }
    }
    


    function getLastInstr(){
        $this->db->select('instructn')->from('quizes_intro');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('instructn');
        }else{
            return "";
        }
    }



    function updateResultViews($tbl, $column, $id){
        if($tbl=="test_boards")
            $this->db->where('test_types', $id);
        else
            $this->db->where('id', $id);
        $this->db->set($column, "$column+1", FALSE);
        $this->db->update($tbl);
    }


    function getMemberID($id){
        $this->db->select('names')->from('members')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $names = $query->row('names');
            return ucwords($names);
        }else
            return false;
    }


    function countArrayData($tbl, $columns, $params){
        if($tbl=="stud_ans"){
            $this->db->distinct();
            $this->db->group_by('stud_ans.memid');
            $query = $this->db->get($tbl);
            return $query->num_rows();

        }else if($tbl=="centres" && $columns=="id"){
            $query = $this->db->get_where($tbl, array('approved'=>1));
            return $query->num_rows();

        }else if($tbl=="logos" && $columns=="id"){
            $query = $this->db->get($tbl);
            return $query->num_rows();

        }else if($tbl=="logos" && $columns=="urls, files"){
            $this->db->select($columns)->from($tbl);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result_array();
            }else{
                return false;
            }

        }else{
            $this->db->select($columns)->from($tbl);
            if($params!="")
                $this->db->where('media_type', $params);

            $query = $this->db->get();
            if($query->num_rows() > 0){
                $querys = $query->result_array();
                $myviews = 0;
                foreach ($querys as $row) {
                    $myviews += $row[$columns];
                }
                return $myviews;
            }else{
                return false;
            }
        }
    }



    function countArrayDataForum($tbl, $columns, $params){
        
        if($params=="medias"){
            $SQL1 = "SELECT DISTINCT files FROM forums WHERE files!=''";
            $SQL2 = "SELECT DISTINCT files FROM forum_reply WHERE files!=''";
            $SQL3 = "$SQL1 UNION $SQL2";
            $query = $this->db->query($SQL3);
            return $query->num_rows();

        }else if($params=="topics"){
            $SQL1 = "SELECT DISTINCT topics FROM forums";
            $SQL2 = "SELECT DISTINCT forum_id FROM forum_reply";
            $SQL3 = "$SQL1 UNION $SQL2";
            $query = $this->db->query($SQL3);
            return $query->num_rows();
            
        }else{
            $this->db->distinct();
            $this->db->group_by($columns);
            $query = $this->db->get($tbl);
            return $query->num_rows();
        }
    }


    function lastPost($tbl){
        $this->db->select('mem.names')->from($tbl);
        $this->db->join('members mem', 'mem.id = frm.memid');
        $this->db->order_by('frm.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return ucwords($query->row('names'));
        }else{
            return "<i>Name Deleted</i>";
        }
    }


    public function getrepliesCount($id) {
        $this->db->select('count(*) as allcount');
        $this->db->from('forum_reply');
        $this->db->where('forum_id', $id);
        $query = $this->db->get();
        $result = $query->result_array();      
        return $result[0]['allcount'];
    }



    function subjName($subject_id, $ids_arr, $qid_intro){
        $this->db->select('qz.subject_id')->from('quizes qz')->where('qi.id', $qid_intro);
        $this->db->join('quizes_intro qi', 'qi.sessions = qz.sessions');
        
        $subject_id_arr = $subject_id;
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $subject_id = $query->row('subject_id');

            $this->db->select('subjs')->from('subjects');
            if($ids_arr == "arrays"){
                $subject_id_arr = str_replace(array("\n", " "), "", $subject_id_arr);
                $subject_id_arr = explode(',', $subject_id_arr);
                $this->db->where_in('id', $subject_id_arr);
            }else{
                $this->db->where('id', $subject_id);
            }

            $query = $this->db->get();
            if($query->num_rows() > 0){
                if($ids_arr == "arrays"){
                    $subjNames = "";
                    $query2 = $query->result_array();
                    foreach ($query2 as $row) {
                        $subjs = $row['subjs'];
                        $subjNames .= "$subjs, ";
                    }
                    $subjNames1 = substr($subjNames, 0, -2);
                    return $subjNames1;
                }else{
                    return $query->row('subjs');
                }

            }else{
                return false;
            }
        }
        


    }



    function searchStr($keyword) {
        //$this->db->select('centre_name, locations, city, statee, id');
        $this->db->select('centre_name, locations');
        $this->db->order_by('id', 'DESC');
        //$this->db->like('centre_name', $keyword);
        //$this->db->or_like('locations', $keyword, 'both');
        $this->db->like('locations', $keyword, 'both');
        $this->db->or_like("city", $keyword, 'both');
        $this->db->or_like("statee", $keyword, 'both');
        return $this->db->get_where('centres', array('approved'=>1))->result_array();
    }



    function countQuestions($tasks, $qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr){
        $this->db->select('qq.id AS allcount')->from('quizes2 qq')->where('qi.aprvd', 1);

        if($ids_arr == "arrays"){
            $subject_id = str_replace(array("\n", " "), "", $subject_id);
            $subject_id = explode(',', $subject_id);
            $this->db->where_in('qz.subject_id', $subject_id);
        }else{
            $this->db->where('qz.subject_id', $subject_id);
        }

        if($test_board != "")
            $this->db->where('qz.test_board', $test_board);

        // if($quizid_taken){
        //     $quizid_taken_ = substr($quizid_taken, -1); 

        //     if($quizid_taken_ == ",") // incase of i answer one question and go prev let it remove the comma
        //         $quizid_taken = substr($quizid_taken, 0, -1);

        //     $quizid_taken = explode(',', $quizid_taken);
        //     $quizid_taken1 = array_unique($quizid_taken);
        // }

        if($noOfYrs != ""){
            if($noOfYrs!="rand")
                $this->db->where('qz.years', $noOfYrs);
        }
        
        $this->db->join('quizes_intro qi', 'qi.sessions = qq.sessions');
        $this->db->join('quizes qz', 'qz.sessions = qq.sessions');
        $this->db->order_by('qq.id', 'desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }



    
    function quizQuestions($tasks, $qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr, $rowno, $rowperpage){

        // $newdata3 = array(
        //         'allRandIDs'     => ""
        //     );
        //     $this->session->set_userdata($newdata3);

        // if already in session, use it instead of generating rand again
        $allRandIDs = $this->session->userdata('allRandIDs');

        if(!$allRandIDs){ // if not set
            $allRandIDs = $this->fetchRandomIDs($qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr);

            $newdata3 = array(
                'allRandIDs'     => $allRandIDs
            );
            $this->session->set_userdata($newdata3); // store quiz IDs instead of using rand()
        }


        $this->db->select('qq.id AS ids, qq.questions, qq.files, qq.op1, qq.op2, qq.op3, qq.op4, qq.ans1, qq.explanations')->from('quizes2 qq')->where('qi.aprvd', 1);
        //$this->db->where('qq.quizintro_id', $qid_intro);

        if($ids_arr == "arrays"){
            $subject_id = str_replace(array("\n", " "), "", $subject_id);
            $subject_id = explode(',', $subject_id);
            $this->db->where_in('qz.subject_id', $subject_id);
        }else{
            $this->db->where('qz.subject_id', $subject_id);
        }

        if($test_board != "")
            $this->db->where('qz.test_board', $test_board);


        $allQuizIDs2 = "";
        foreach ($allRandIDs as $value) {
            $allQuizIDs2 .= $value['id'].",";
        }

        $allQuizIDs2i = "";
        foreach ($allRandIDs as $value) {
            $allQuizIDs2i .= "'".$value['id']."',"; // so that it has '20', '18', '29'
        }

        $allQuizIDs3 = substr($allQuizIDs2i, 0, -1); // use it on order_by

        $allQuizIDs2 = substr($allQuizIDs2, 0, -1);
        $allQuizIDs2 = explode(',', $allQuizIDs2);
        $allQuizIDs1 = array_unique($allQuizIDs2);

        $this->db->where_in('qq.id', $allQuizIDs1);


        if($noOfYrs != ""){
            if($noOfYrs!="rand")
                $this->db->where('qz.years', $noOfYrs);
        }
        
        $this->db->join('quizes_intro qi', 'qi.sessions = qq.sessions');
        $this->db->join('quizes qz', 'qz.sessions = qq.sessions');
        
        $this->db->_protect_identifiers = FALSE;
        $this ->db->order_by("FIELD(qq.id, $allQuizIDs3)");
        $this->db->_protect_identifiers = TRUE;

        if($rowperpage!="" || $rowno!="")
            $this->db->limit($rowperpage, $rowno);


        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }



    function fetchRandomIDs($qid_intro, $subject_id, $test_types, $test_board, $noOfYrs, $ids_arr){
        $this->db->select('qq.id')->from('quizes2 qq')->where('qi.aprvd', 1);

        if($ids_arr == "arrays"){
            $subject_id = str_replace(array("\n", " "), "", $subject_id);
            $subject_id = explode(',', $subject_id);
            $this->db->where_in('qz.subject_id', $subject_id);
        }else{
            $this->db->where('qz.subject_id', $subject_id);
        }

        if($test_board != "")
            $this->db->where('qz.test_board', $test_board);
        
        if($noOfYrs != ""){
            if($noOfYrs!="rand")
                $this->db->where('qz.years', $noOfYrs);
        }
        
        $this->db->join('quizes_intro qi', 'qi.sessions = qq.sessions');
        $this->db->join('quizes qz', 'qz.sessions = qq.sessions');
        $this->db->order_by('rand()');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function showMyPerformanceTbl($id_sch, $subject_id, $memid, $test_board){
        $this->db->select('sa.answers, sa.ids')->from('stud_ans sa');
        $this->db->where('sa.id', $id_sch);
        if($memid!="")
        $this->db->where('sa.memid', $memid);
        $this->db->order_by('sa.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return 0;
        }
    }


    function showMyPerformanceTbl2($id_sch, $subject_id, $memid, $test_board){
        $this->db->select('sa.answers, sa.ids')->from('stud_ans sa');
        $this->db->where('sa.quizintro_id', $id_sch);
        if($memid!="")
        $this->db->where('sa.memid', $memid);
        $this->db->order_by('sa.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return 0;
        }
    }


    function getQuizOrigin($id){
        $this->db->select('ans1, questions, op1, op2, op3, op4, explanations')->from('quizes2')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return 0;
        }
    }


    

    function computeScores($ids1, $mem_ans){
        $mem_ans = str_replace(array("′", "'"), "&prime;", $mem_ans);
        $this->db->select('id')->from('quizes2');
        $this->db->where('id', $ids1)->where('ans1', $mem_ans);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }



    function insert_scores($data){
        $query1 = $this->db->insert('stud_ans', $data);
        if($query1)
            return true;
        else
            return false;
    }


    function totlQuestions($subject_id, $test_board, $ids_arr){
        $this->db->select('count(qu.id) as allcount')->from('quizes2 qu');
        //$this->db->where('qu.id', $id_sch)->where('qq.test_board', $test_board);
        $this->db->where('qq.test_board', $test_board);
        if($ids_arr=="arrays"){
            //$subject_id = explode(', ', $subject_id);
            $subject_id = str_replace(array("\n", " "), "", $subject_id);
            $subject_id = explode(',', $subject_id);
            $this->db->where_in('qq.subject_id', $subject_id);
        }else{
            $this->db->where('qq.subject_id', $subject_id);
        }
        $this->db->where('qi.aprvd', 1);
        $this->db->join('quizes_intro qi', 'qi.sessions = qu.sessions');
        $this->db->join('quizes qq', 'qq.sessions = qu.sessions');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }



    
    function fetctBoardID($test_board2){
        if($test_board2!="n-power")
            $test_board2 = str_replace("-", " ", $test_board2);
        $this->db->select('id')->from('test_boards');
        $this->db->where('test_types', $test_board2);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('id');
        }else{
            return false;
        }

    }



    function countMems($tbl, $id){
        // $SQL1 = "SELECT DISTINCT memid FROM $tbl WHERE quizintro_id_='$id'";
        // //$SQL1 = "SELECT DISTINCT subject_id FROM $tbl";
        // $query = $this->db->query($SQL1);
        // if($query->num_rows() > 0){
        //     $subject_arrs = $query->row('subject_id');
        //     $subject_arrs = explode(',', $subject_arrs);
        //     $mems=0;
        //     foreach ($subject_arrs as $row) {
        //         //if(in_array($row, $subject_id))
        //         if(in_array($row, $subject_arrs)){
        //             $mems += 1;
        //         }
        //     }
        //     return $mems
        $this->db->select('memid')->from($tbl)->where('quizintro_id', $id);
        $query = $this->db->get();
        return @number_format($query->num_rows());
    }



    function countRecs($tbl, $id, $subject_id, $test_board, $id_arrays, $name_of_sch1){
        $this->db->select('count(qu.id) as allcount')->from($tbl.' qu')->where('qi.aprvd', 1);
        if($id_arrays=="arrays"){
            //$txtsubjid = explode(',', $subject_id);
            $subject_id = str_replace(array("\n", " "), "", $subject_id);
            $subject_id = explode(',', $subject_id);
            $this->db->where_in('qi2.subject_id', $subject_id);
        }else{
            $this->db->where('qi2.subject_id', $subject_id);
        }

        if($tbl == "quizes2"){
            if($test_board!="")
                $this->db->where('qi2.test_board', $test_board);

            if($name_of_sch1!="")
                $this->db->where('qi2.name_of_sch', $name_of_sch1);
        }

        $this->db->join('quizes_intro qi', 'qi.sessions = qu.sessions');
        $this->db->join('quizes qi2', 'qi2.sessions = qu.sessions');
        //$query = $this->db->get();
        //$result = $query->result_array();
        return $this->db->count_all_results();
        //return $result[0]['allcount'];
    }



    function countQuiz($qid_intro, $subject_id){
        $this->db->select('count(qi.id) as allcount')->from('quizes qu')->where('qi.aprvd', 1);
        $this->db->where('qu.quizintro_id', $qid_intro)->where('qu.subject_id', $subject_id);
        $this->db->join('quizes_intro qi', 'qi.id = qu.quizintro_id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function countQuiz1($txtyears, $txtsubjid, $txttest_board, $ids_arr, $name_of_sch){
        $this->db->select('count(qu.id) as allcount')->from('quizes2 qu2');//->where('qi.aprvd', 1);
        $this->db->where('qu.test_board', $txttest_board);
        $this->db->where('qu.name_of_sch', $name_of_sch);

        if($txtyears!="rand"){
            $this->db->where('qu.years', $txtyears);
            if($ids_arr=="arrays"){
                $txtsubjid = str_replace(array("\n", " "), "", $txtsubjid);
                $txtsubjid = explode(',', $txtsubjid);
                $this->db->where_in('qu.subject_id', $txtsubjid);
            }
            else
                $this->db->where('qu.subject_id', $txtsubjid);
        }else{
            
            if($ids_arr=="arrays"){
                $txtsubjid = explode(',', $txtsubjid);
                $this->db->where_in('qu.subject_id', $txtsubjid);
            }
            else{
                $this->db->where('qu.subject_id', $txtsubjid);
            }
        }
        //$this->db->join('quizes_intro qi', 'qi.sessions = qu2.sessions');
        $this->db->join('quizes qu', 'qu.sessions = qu2.sessions');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }



    function countQuiz2($subject_id, $test_board, $name_of_sch){
        $this->db->select('qu.id')->from('quizes2 qu')->where('qi.aprvd', 1);
        $this->db->where('qq.subject_id', $subject_id)->where('qq.test_board', $test_board);
        $this->db->where('qq.name_of_sch', $name_of_sch);
        $this->db->join('quizes_intro qi', 'qi.sessions = qu.sessions');
        $this->db->join('quizes qq', 'qq.sessions = qu.sessions');
        $this->db->group_by('qq.sessions');
        return $this->db->count_all_results();
    }


    function countQuiz3($test_board, $subject_id, $years){
        $this->db->select('count(qu.id) as allcount')->from('quizes2 qu')->where('qi.aprvd', 1);
        //$this->db->where('qq.subject_id', $subject_id);
        $subject_id = explode(', ', $subject_id);
        //$years = explode(', ', $years);
        $this->db->where_in('qq.subject_id', $subject_id);

        $this->db->where('qq.test_board', $test_board);
        $this->db->join('quizes_intro qi', 'qi.sessions = qu.sessions');
        $this->db->join('quizes qq', 'qq.sessions = qu.sessions');
        $this->db->group_by('qq.id');
        $query = $this->db->get();
        $result = $query->result_array();
        $counts1 = @$result[0]['allcount'];
        if($counts1=="" || $counts1 <= 0)
            return 0;
        else
            return $counts1;
    }



    function countQuizMembers($memid, $scholarship_id){
        $this->db->select('count(sa.memid) as allcount')->from('stud_ans sa')->where('sch.approved', 1);
        $this->db->distinct();
        $this->db->where('sa.memid', $memid);
        $this->db->where('sa.scholarship_id', $scholarship_id);
        //$this->db->join('members mem', 'mem.id = sa.memid');
        $this->db->join('scholarships sch', 'sch.id = sa.scholarship_id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function countVisitors($statee, $tbls){
        $this->db->select("id");
        $this->db->from($tbls);
        if($statee!="")
            $this->db->where('statee', $statee);
        return $this->db->count_all_results();
    }


    function countRecs1($tbls, $columns, $params){
        $this->db->select("id");
        $this->db->from($tbls);
        if($columns!="")
            $this->db->where($columns, $params);
        return $this->db->count_all_results();
    }


    function update_password($new_pass, $oldpass, $admin_type){
        if($admin_type == sha1('admin'))
            $this->db->select('id')->from('admin_tbls');
        else 
            $this->db->select('id')->from('members');

        $this->db->where('passwords', $oldpass);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $this->db->where('passwords', $oldpass);
            $this->db->set('passwords', $new_pass);

            if($admin_type == sha1('admin'))
                $this->db->update('admin_tbls');
            else 
                $this->db->update('members');

            return true;
        }else{
            return false;
        }
    }



    function update_password1($new_pass, $email){
        $this->db->select('id')->from('members')->where('emails', $email)->or_where('phone', $email);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $this->db->where('emails', $email)->or_where('phone', $email);
            $this->db->set('passwords', hash_password($new_pass));
            $this->db->update('members');

            $this->db->where('emails', $email);
            $this->db->set('codes', 0);
            $this->db->update('email_verificatn');
            return true;
        }else{
            return false;
        }
    }



    function check_existing_details($memid, $ids, $tbl){
        $this->db->select('id')->from($tbl);
        if($tbl=="cart")
            $this->db->where('memid', $memid)->where('prod_id', $ids);
        if($tbl=="schools")
            $this->db->where('name_of_sch', $memid);
        if($tbl=="members")
            $this->db->where("(emails='$memid' or phone='$memid')");
        if($tbl=="email_verificatn")
            $this->db->where('codes', $memid)->where('codes >', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }



    function check_existing_codes($codes, $tbl){
        $this->db->select('emails')->from($tbl);
        $this->db->where('codes', $codes)->where('codes >', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('emails');
        }else{
            return false;
        }
    }



    function fetchForum($page, $txt_srch, $txtcats1){
        $offset = 30*$page;
        $limit = 30;
        $this->db->select('frm.id AS idf, mem.id AS conid, mem.names, frm.topics, frm.messages, frm.files, frm.views, frm.dates')->from('forums frm');
        $this->db->join('members mem', 'mem.id = frm.memid');
        if($txt_srch!=""){
            $srchs = "(mem.names like '%$txt_srch%' OR frm.messages like '%$txt_srch%')";
            $this->db->where("$srchs");
        }
        if($txtcats1 > 0){
            $this->db->where('topics', $txtcats1);
        }
        $this->db->order_by('frm.id', 'desc');
        //if($page!="")
            $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    function fetchARecord($id, $nodes1, $phps){
        if($phps=="phps")
            $id = substr($id, 0, -4);
        $this->db->select('frm.id, cons.names, frm.topics, frm.messages, frm.files, frm.views, frm.dates')->from('forums frm');
        $this->db->join('members cons', 'cons.id = frm.memid');
        $this->db->where('frm.id', $id);
        
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }



    function updateViews($id, $nodes1, $params){
        $this->db->select('views')->from($nodes1)->where('id', $id);
        $query = $this->db->get();
        $views1 = $query->row('views');
        if($views1==null || $views1=="") $views1=0;
        $this->db->set('views', $views1+1);
        $query1 = $this->db->where('id',$id)->update($nodes1);
        return true;
    }



    function replyCounts($id){
        $this->db->select('count(id) as allcount')->from('forum_reply');
        $this->db->where('forum_id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function fetchForumRep($page, $fr_ids){
        $offset = 30*$page;
        $limit = 30;
        $this->db->select('reps.id, cons.id AS conid, cons.names, reps.replies, reps.files, reps.dates')->from('forum_reply reps');
        $this->db->join('members cons', 'cons.id = reps.memid');
        $this->db->join('forums frm', 'frm.id = reps.forum_id');
        $this->db->where('reps.forum_id', $fr_ids);
        $this->db->order_by('reps.id', 'desc');
        if($page!="")
            $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    function deleteFrmPost($id, $type1){
        if($type1=="forums"){
            $this->db->select('files')->from("forum_reply")->where('id', $id); // first delete forum_reply files
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $qry1 = $query->result_array();
                foreach ($qry1 as $row) {
                    $files = $row['files'];
                    $in_folder1="forum_files/$files";
                    if(is_readable($in_folder1)) @unlink($in_folder1);
                }
            }

            $this->db->select('files')->from("forums")->where('id', $id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $files = $query->row('files');
                $in_folder1="forum_files/$files";
                if(is_readable($in_folder1)) @unlink($in_folder1);
            }

            $this->db->where('forum_id', $id);
            $query1 = $this->db->delete('forum_reply');

            $this->db->where('id', $id);
            $query1 = $this->db->delete("forums");

        }else{ // forum_reply

            $this->db->select('files')->from("forum_reply")->where('id', $id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $files = $query->row('files');
                $in_folder1="forum_files/$files";
                if(is_readable($in_folder1)) @unlink($in_folder1);
            }

            $this->db->where('id', $id);
            $query1 = $this->db->delete("forum_reply");
        }
        return ($query1) ? true : false;
    }



    function fetchForumRep1($fr_ids){
        $this->db->select('reps.id, mem.id AS conid, mem.names, reps.replies, reps.files, reps.dates')->from('forum_reply reps');
        $this->db->join('members mem', 'mem.id = reps.memid');
        $this->db->join('forums frm', 'frm.id = reps.forum_id');
        $this->db->where('reps.forum_id', $fr_ids);
        $this->db->order_by('reps.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }



    function already_started($get_mems_id, $qid_intro, $subject_id, $ids_arr){
        $this->db->select('attempts')->from('stud_start_test sst');
        $this->db->where('sst.quiz_intro_id', $qid_intro)->where('sst.memid', $get_mems_id)->where('sst.started_test', 1);

        // if($ids_arr == "arrays"){
        //     //$subject_id = explode(',', $subject_id);
        //     $subject_id = str_replace(array("\n", " "), "", $subject_id);
        //     $this->db->where("find_in_set('$subject_id', sst.subject_id)");
        // }
        // else{
            $subject_id = str_replace(array("\n", " "), "", $subject_id);
            $this->db->where('sst.subject_id', $subject_id);
        //}
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('attempts');
            //return true;
        }else{
            return 0;
        }
    }



    function submitted_attempts($get_mems_id, $qid_intro, $subject_id, $ids_arr){
        $this->db->select('id')->from('stud_ans');
        $this->db->where('quizintro_id', $qid_intro);
        $this->db->where('memid', $get_mems_id);
        return $this->db->count_all_results();
    }



    function attempts_and_written($get_mems_id, $qid_intro, $subject_id, $ids_arr){
        $this->db->select('sst.id')->from('stud_start_test sst');
        $this->db->where('sst.quiz_intro_id', $qid_intro)->where('sst.memid', $get_mems_id)->where('sst.started_test', 1);
        //->where('sst.subject_id', $subject_id);
        if($ids_arr == "arrays"){
            $subject_id = explode(', ', $subject_id);
            $this->db->where_in('sst.subject_id', $subject_id);
        }else{
            $this->db->where('sst.subject_id', $subject_id);
        }
        $this->db->where('sa.quizintro_id', $qid_intro);
        $this->db->join('stud_ans sa', 'sa.quizintro_id = sst.quiz_intro_id');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }



    
    function userAttempted($qid_intro, $memid, $campid){
        $nows = time();
        $this->db->select('id')->from('member_subscription')->where('memid', $memid)->where('expiry >=', $nows);
        $query = $this->db->get();
        if($query->num_rows() > 0){ // premium user

            //return true; // still current
            $echo = $this->submitted_attempts(sha1($memid), $qid_intro, $campid);
            $arrs = array('type'=>'premium', 'msg'=>$echo);

        }else{ // free user
            //return false;
            $echo = $this->submitted_attempts(sha1($memid), $qid_intro, $campid);
            $arrs = array('type'=>'free', 'msg'=>$echo);
        }
        return json_encode($arrs);
    }


    function delete_gal_pics($file1){
        $in_folder1 = "adverts/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }




    function fetchArrCountryName($country_ids){
        $country_ids = explode(',', $country_ids);
        $contry1 = "";
        foreach ($country_ids as $country_ids1) {
            if($country_ids1){
                $this->db->select('name');
                $this->db->from('countries');
                $this->db->where('id', $country_ids1);
                $query = $this->db->get();
                
                if($query->num_rows() > 0){
                    $contry = $query->row('name');
                    $contry1 .= "$contry, ";
                }else{
                    $contry1 .= "";
                }
            }
        }
        $contry2 = substr($contry1, 0, -2);
        return $contry2;
    }




    function fetchBoards($test_board){
        $this->db->select('test_types')->from('test_boards');
        $test_board = str_replace("\n", "", $test_board);
        $test_board1 = explode(",", $test_board);
        $this->db->where_in('id', $test_board1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function insert_datas($data, $txt_id, $tbl){
        if($txt_id!=""){
            $query = $this->db->where('md5(id)', $txt_id)->update($tbl, $data);
        }else{
            $query = $this->db->insert($tbl, $data);
        }
        return ($query) ? true : false;
    }


    function delete_images($file, $folders){
        $in_folder1 = $folders.$file;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }




    function get_user_logins($data){
        $emails = $data['emails'];
        $pass = $data['passwords'];
        $now = 865000;
        $this->db->select('names, passwords')->from('members');
        $this->db->where("(emails='$emails' or phone='$emails')")->where('approved', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0 && password_verify($pass, $query->row('passwords'))){
            $names = $query->row('names');
            $passwords = $query->row('passwords');
            $cookie = array(
                'name'   => 'tst_pass',
                'value'  => $passwords,
                'expire' => $now,
                'secure' => FALSE
            );
            $cookie1 = array(
                'name'   => 'tst_uname',
                'value'  => sha1($emails),
                'expire' => $now,
                'secure' => FALSE
            );
            set_cookie($cookie);
            set_cookie($cookie1);

            $names1 = explode(' ', $names);
            return ucwords($names1[0]);
            
        }else{
            return false;
        }
    }


    function get_user_ids($data){
        $emails = $data['emails'];
        $pass = $data['passwords'];
        $now = 865000;
        $this->db->select('id')->from('members')->where("(emails='$emails' or phone='$emails')")->where('approved', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('id');
        }else{
            return false;
        }
    }


    function getTopicName($id, $columns, $tbl, $columns2, $arr){
        $this->db->select($columns2)->from($tbl)->where($columns, $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            if($arr=="array")
                return $query->result_array();
            else
                return $query->row($columns2);
        }else{
            return false;
        }
    }



    function validate_adminx(){
        $admin_type = $this->input->cookie('admin_type', TRUE);
        $adm_uname = $this->input->cookie('adm_username_testpt', TRUE);
        $adm_pass = $this->input->cookie('adm_password_testpt', TRUE);
        if(isset($adm_pass) && $adm_pass!=''){
            $this->db->select('id')->from('admin_tbls')->where('pass1', $adm_pass)->where('sha1(uname)', $adm_uname);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }




    function validate_users(){
        $adm_uname = $this->input->cookie('tst_uname', TRUE);
        $adm_pass = $this->input->cookie('tst_pass', TRUE);
        if(isset($adm_pass) && $adm_pass!=''){
            $this->db->select('id')->from('members')->where('passwords', $adm_pass);
            //$this->db->where('sha1(emails)', $adm_uname)->where('approved', 0);
            $this->db->where("(sha1(emails)='$adm_uname' or sha1(phone)='$adm_uname')")->where('approved', 0);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }




    function insert_tbl($data, $id, $tbl){
        if($id!=""){
            $query = $this->db->where('md5(id)', $id)->update($tbl, $data);
        }else{
            $query = $this->db->insert($tbl, $data);
        }
        return ($query) ? true : false;
    }


    function insert_code($data, $mails, $tbl){
        $this->db->select('emails')->from($tbl)->where('emails', $mails);
        $query1 = $this->db->get();
        if($query1->num_rows() > 0){ // update the code incase the member click reset pass more than once
            $query = $this->db->where('emails', $mails)->update($tbl, $data);
        }else{
            $query = $this->db->insert($tbl, $data);
        }
        $this->db->select('codes')->from($tbl)->where('emails', $mails);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('codes');
        }else{
            return "";
        }
    }



    function auth_details($users, $passwords){
        $this->db->select('id')->from('admin_tbls')->where('pass1', sha1($passwords))->where('uname', $users);
        $now = 865000;
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $cookie = array(
                'name'   => 'adm_username_testpt',
                'value'  => sha1($users),
                'expire' => $now,
                'secure' => FALSE
            );
            $cookie1 = array(
                'name'   => 'adm_password_testpt',
                'value'  => sha1($passwords),
                'expire' => $now,
                'secure' => FALSE
            );
            set_cookie($cookie);
            set_cookie($cookie1);
            return true;
        }else{
            return false;
        }
    }




    function validateMember(){
        $suser = $this->input->cookie('tst_uname', TRUE);
        $spass = $this->input->cookie('tst_pass', TRUE);
        $this->db->select('id')->from('members')->where("(sha1(emails)='$suser' or sha1(phone)='$suser')")->where('passwords', $spass)->where('approved', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            //return sha1($query->row('id'));
            return true;
        }else{
            return false;
        }
    }



    function getContryByName($id){
        $this->db->select('name')->from('countries')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row('name');
        else
            return false;
    }

    function getStateByName($id){
        $this->db->select('name')->from('states')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row('name');
        else
            return false;
    }

    function getCityByName($id){
        $this->db->select('name')->from('cities')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row('name');
        else
            return false;
    }



    function getCatName($id){
        $this->db->select('cat')->from('categories')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('cat');
        }else
            return false;
    }



    function getSess($quizintro_id){
        $this->db->select('sessions')->from('quizes_intro')->where('id', $quizintro_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row('sessions');
        else
            return false;
    }

    

    function record_visitors($ipaddr){
        $this->db->select('ipaddrs')->from('visitors')->where('ipaddrs', $ipaddr);
        $query = $this->db->get();
        if($query->num_rows() <= 0){
            $data = array(
                'ipaddrs'  => $ipaddr
            );
            $this->db->insert('visitors', $data);
        }
        return true;
    }

    
    

    function getMemDetails(){
        $suser = $this->input->cookie('tst_uname', TRUE);
        $spass = $this->input->cookie('tst_pass', TRUE);
        $this->db->select('*')->from('members')->where("(sha1(emails)='$suser' or sha1(phone)='$suser')")->where('passwords', $spass)->where('approved', 0);
        $query = $this->db->get();
            //$id = $query->row('id');
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }


    function getMemOtherInfo($tbl, $id){
        $now = time();
        $this->db->select("paid, subscription")->from($tbl)->where('sha1(memid)', $id)->where('expiry >', $now);
        $query = $this->db->get();
            //$id = $query->row('id');
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }



    
    function getPaidMemIDs(){
        $suser = $this->input->cookie('tst_uname', TRUE);
        $spass = $this->input->cookie('tst_pass', TRUE);
        $nows = time();
        
        $this->db->select('id')->from('members')->where("(sha1(emails)='$suser' or sha1(phone)='$suser')")->where('passwords', $spass)->where('approved', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){ // if i have logged in
            return sha1($query->row('id'));
        }else{
            return 4; // not logged in
        }
    }



    function approveIDS($id1, $columns, $tbls){
        $query = $this->db->get_where($tbls, array('id' => $id1));
        if ($query->num_rows() > 0){
            $approved = $query->row()->$columns;
            $this->db->where('id', $id1);

            if($approved == 0){
                $this->db->set($columns, 1);
            }else{
                $this->db->set($columns, 0);
            }
            $query = $this->db->update($tbls);
            return ($query) ? true : false;
        }
    }



    function getMembersEmails(){
        $this->db->select('emails');
        $this->db->from('members');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $all_mails = "";
            $query2 = $query->result_array();
            foreach ($query2 as $row) {
                $emails = $row['emails'];
                $all_mails .= "'$emails', ";
            }
            $all_mails1 = substr($all_mails, 0, -2);
            return $all_mails1;
        }else{
            return false;
        }
    }



    function getTestDetails(){
        $cookie_sess = $this->input->cookie('cookie_sess', TRUE);
        $this->db->select('tb.test_types, qi.sessions')->from('quizes qi')->where('qi.sessions', $cookie_sess);
        $this->db->join('quizes_intro qz', 'qi.sessions = qz.sessions');
        $this->db->join('test_boards tb', 'tb.id = qi.test_board');
        $this->db->group_by('qi.subject_id');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }


    function getSchName($name_of_sch){
        $this->db->select('id, name_of_sch')->from('schools')->where('id', $name_of_sch);
        $this->db->group_by('name_of_sch');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            //return $query->row('name_of_sch');
            return $query->result_array();
        }else{
            return false;
        }
    }


    function getSchName2($sessions){
        $this->db->select('sch.name_of_sch')->from('quizes qi')->where('qi.sessions', $sessions);
        $this->db->join('quizes_intro qz', 'qi.sessions = qz.sessions');
        $this->db->join('subjects ss', 'ss.id = qi.subject_id');
        $this->db->join('schools sch', 'sch.id = qi.name_of_sch');
        $this->db->group_by('qi.name_of_sch');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $query2 = $query->result_array();
            $name_of_schs = "";
            foreach ($query2 as $row) {
                $name_of_sch = $row['name_of_sch'];
                $name_of_schs .= "$name_of_sch, ";
            }
            $name_of_sch1 = substr($name_of_schs, 0, -2);
            return ucwords($name_of_sch1);
        }else{
            return "";
        }
    }


    function getTestDetails1(){
        $cookie_sess = $this->input->cookie('cookie_sess', TRUE);
        $this->db->select('ss.subjs, qi.name_of_sch')->from('quizes qi')->where('qi.sessions', $cookie_sess);
        $this->db->join('quizes_intro qz', 'qi.sessions = qz.sessions');
        $this->db->join('test_boards tb', 'tb.id = qi.test_board');
        $this->db->join('subjects ss', 'ss.id = qi.subject_id');
        $this->db->group_by('qi.subject_id');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function getDetls($id_sch, $arrs, $subj, $params){
        if($params == "subjs"){
            $this->db->select('subjs');
            //$this->db->select($pres.'.'.$columns)->from('stud_ans sa');

            $subj = str_replace(array("\n", " "), "", $subj);
            $subj = explode(',', $subj);

            $this->db->from('subjects')->where_in('id', $subj);
            $this->db->order_by('id', 'desc');
            $query = $this->db->get();
            if($arrs=="arrays"){
                if($query->num_rows() > 0){
                    $query2 = $query->result_array();
                    $subjNames = "";
                    foreach ($query2 as $row) {
                        $subjs = $row['subjs'];
                        $subjNames .= "$subjs, ";
                    }
                    $subjNames1 = substr($subjNames, 0, -2);
                    return $subjNames1;
                }else{
                    return false;
                }
            }else{
                return $query->row('subjs');
            }

        }else{

            $this->db->select('tb.test_types, qq.test_board, sa.scores, sa.time_finished');
            $this->db->from('stud_ans sa')->where('sa.quizintro_id', $id_sch);
            // $this->db->join('quizes_intro qz', 'sa.quizintro_id = qz.id');
            // $this->db->join('quizes qq', 'qq.sessions = qz.sessions');

            $this->db->join('quizes qq', 'qq.id = sa.quizintro_id');
            $this->db->join('quizes_intro qz', 'qz.sessions = qq.sessions');

            $this->db->join('test_boards tb', 'qq.test_board = tb.id');
            $this->db->order_by('sa.id', 'desc');
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->row_array();
            }else{
                return false;
            }
        }
    }



    function getDetls___($id_sch, $arrs, $memid, $params){
        $this->db->select($pres.'.'.$columns)->from('stud_ans sa');
        $this->db->where('sa.quizintro_id', $id_sch)->where('sa.memid', $memid);
        $this->db->join('quizes_intro qz', 'sa.quizintro_id = qz.id');
        $this->db->join('subjects ss', 'ss.id = qi.subject_id');
        $this->db->order_by('id', 'desc');
        //$this->db->group_by('qi.subject_id, qi.years');
        $query = $this->db->get();
        if($arrs==""){
            if($query->num_rows() > 0){
                $query2 = $query->result_array();
                $subjNames = "";
                foreach ($query2 as $row) {
                    $subjs = $row[$columns];
                    $subjNames .= "$subjs, ";
                }
                $subjNames1 = substr($subjNames, 0, -2);
                return $subjNames1;
            }else{
                return false;
            }
        }else{
            return $query->result_array();
        }
    }



    function getTestDetails2($sessions, $arrs, $columns, $pres){
        $this->db->select($pres.'.'.$columns)->from('quizes qi')->where('qi.sessions', $sessions);
        $this->db->join('quizes_intro qz', 'qi.sessions = qz.sessions');
        $this->db->join('subjects ss', 'ss.id = qi.subject_id');
        $this->db->group_by('qi.subject_id, qi.years');
        $query = $this->db->get();
        if($arrs==""){
            if($query->num_rows() > 0){
                $query2 = $query->result_array();
                $subjNames = "";
                foreach ($query2 as $row) {
                    $subjs = $row[$columns];
                    $subjNames .= "$subjs, ";
                }
                $subjNames1 = substr($subjNames, 0, -2);
                return $subjNames1;
            }else{
                return false;
            }
        }else{
            return $query->result_array();
        }
    }


    function getTestYears($sessions){
        $this->db->select('qi.years')->from('quizes qi')->where('qi.sessions', $sessions);
        $this->db->join('quizes_intro qz', 'qi.sessions = qz.sessions');
        $this->db->join('subjects ss', 'ss.id = qi.subject_id');
        $this->db->group_by('qi.years');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $query2 = $query->result_array();
            $years1 = "";
            foreach ($query2 as $row) {
                $years = $row['years'];
                $years1 .= "$years, ";
            }
            $years2 = substr($years1, 0, -2);
            return $years2;
        }else{
            return false;
        }
    }



    function getPaidMemIDs1(){
        $suser = $this->input->cookie('tst_uname', TRUE);
        $spass = $this->input->cookie('tst_pass', TRUE);
        $this->db->select('id')->from('members')->where("(sha1(emails)='$suser' or sha1(phone)='$suser')")->where('passwords', $spass);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('id');
        }else{
            return false;
        }
    }


    function delete_forum_pics($file1){
        $in_folder1 = "forum_files/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }



    function update_insert_forum($data, $edit_ids){
        $topics = $data['topics'];
        $messages = $data['messages'];
        $memid = $data['memid'];
        if($edit_ids != ""){
            $query1 = $this->db->where('id', $edit_ids)->update('forums', $data);
            if($query1)
                return "updateds";
            else
                return false;
        }else{
            $this->db->select('id');
            $this->db->from('forums');
            $this->db->where('topics', $topics)->where('memid', $memid)->where('messages', $messages);
            $query = $this->db->get();
            if($query->num_rows() <= 0)
                $query1 = $this->db->insert('forums', $data);
            return "inserted";
        }
    }


    function update_insert_forum_reply($data, $edit_ids){
        $replies = $data['replies'];
        $memid = $data['memid'];
        $this->db->select('id');
        $this->db->from('forum_reply');
        $this->db->where('memid', $memid)->where('replies', $replies);
        $query = $this->db->get();
        if($query->num_rows() <= 0)
            $query1 = $this->db->insert('forum_reply', $data);
        return "inserted";
    }



    function getCountries(){
        $this->db->select('id, name');
        $this->db->from('countries');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function getStates($ids){
        $this->db->select('*');
        $this->db->from('states')->where('country_id', $ids);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function getCountryID($names){
        $query = $this->db->get_where('countries', array('name'=>$names));
        if ($query->num_rows() > 0)
            return $query->row('id');
       else
           return false;
    }

    function getStateID($names){
        $query = $this->db->get_where('states', array('name'=>$names));
        if ($query->num_rows() > 0)
            return $query->row('id');
       else
           return false;
    }

    function getCountryName($id){
        $query = $this->db->get_where('countries', array('id'=>$id));
        if ($query->num_rows() > 0)
            return $query->row('name');
       else
           return false;
    }

    function getStateName($id){
        $query = $this->db->get_where('states', array('id'=>$id));
        if ($query->num_rows() > 0)
            return $query->row('name');
       else
           return false;
    }

    


    function totalCounts($tbl, $params){
        $this->db->select('count(id) as allcount')->from($tbl);
        if($params!="")
            $this->db->where('paid', $params);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function fetchRecords($tbls){
        if($tbls == "members mem"){
            $this->db->select('*');
            //$this->db->join('countries cons', 'cons.id = mem.countrys');
            //$this->db->join('states ss', 'ss.id = mem.states');
            //$this->db->join('categories cats', 'cats.id = mem.interests');
        }

        if($tbls == "resources"){
            $this->db->select('titles, test_board, price, views, media_type');
        }
        $this->db->from($tbls);
        $this->db->order_by('id', 'desc');
        $this->db->limit(8);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    
    var $order_column = array(null, "*");


    function make_datatables($tbls, $params, $params2){
        $this->fetchUsers($tbls, $params, $params2);
        if($_POST["length"] != -1){
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get();
        return $query->result();
    }
    

    public function get_filtered_data($tbls, $params){
        $this->fetchUsers($tbls, '', '');
        if($params!="" && $params>0)
            $this->db->where('memid', $params);
        $query = $this->db->get();
        return $query->num_rows();
    }


    function get_all_data($tbls, $params, $params2){
        $this->db->select("*");
        $this->db->from($tbls);
        if($params!="" || $params2!="")
            $this->db->where('city', $params2)->or_where('statee', $params);
        return $this->db->count_all_results();
    }

    function get_all_data1($tbls, $params, $params2){
        $this->db->select("*");
        $this->db->from($tbls);
        if($params!="" || $params2!="")
            $this->db->where('memid', $params2);
        return $this->db->count_all_results();
    }




    function getMyLoc($ip){
        $this->db->select("citys, statee");
        $this->db->from("user_locations");
        $this->db->where('ipaddrs', $ip);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }



    function fetchUsers($tbls, $params, $params2){
        $nowtime = time();
        $txtsrchs = $_POST['search']['value'];

        
        if($tbls=="centres cen"){
            $this->db->select('cen.*, tb.test_types');
            $this->db->from($tbls);
            $this->db->join('test_boards tb', 'tb.id = cen.test_board');

            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(cen.centre_name like '%$txtsrchs%' OR cen.locations like '%$txtsrchs%' OR tb.test_types like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('cen.id', 'desc');
        }


        if($tbls=="resources"){
            $this->db->select('*');
            $this->db->from($tbls);
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(titles like '%$txtsrchs%' OR price like '%$txtsrchs%' OR years like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }


        
        if($tbls=="members"){
            $this->db->select('*');
            $this->db->from('members mem');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(mem.names like '%$txtsrchs%' OR mem.emails like '%$txtsrchs%' OR mem.gender like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('mem.id', 'desc');
        }


        
        if($tbls == "cart"){
            $this->db->select('crt.*, crt.id as id1, mem.names, mem.phone, res.titles, res.price, res.id as res_id');
            $this->db->from('cart crt');
            if($params != "")
                $this->db->where('crt.memid', $params);
            $this->db->join('members mem', 'mem.id = crt.memid');
            $this->db->join('resources res', 'res.id = crt.prod_id');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(mem.names like '%$txtsrchs%' OR res.titles like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('crt.id', 'desc');
        }


        if($tbls=="forums"){
            $this->db->select('frm.id AS ids, frm.topics, frm.messages, frm.files, frm.views, con.names, frm.dates');
            $this->db->from("forums frm");
            $this->db->join('members con', 'con.id = frm.memid');
            $this->db->join('test_boards tb', 'tb.id = frm.topics');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(con.names like '%$txtsrchs%' OR frm.messages like '%$txtsrchs%' OR tb.test_types like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('frm.id', 'desc');
        }

        if($tbls=="forum_reply"){
            $this->db->select('frs.id AS ids, frm.memid AS memid1, frm.messages, frs.replies, frs.files, con.names, frs.dates');
            $this->db->from("forum_reply frs");
            $this->db->join('members con', 'con.id = frs.memid');
            $this->db->join('forums frm', 'frm.id = frs.forum_id');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(con.names like '%$txtsrchs%' OR frs.replies like '%$txtsrchs%' OR frm.messages like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('frs.id', 'desc');
        }


        if($tbls == "user_locations"){
            $this->db->select('*');
            $this->db->from('user_locations')->where('statee !=', '');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(statee like '%$txtsrchs%' OR citys like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->group_by('statee');
            $this->db->order_by('statee', 'asc');
        }


        if($tbls == "logos"){
            $this->db->select('*');
            $this->db->from('logos');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(urls like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }


        if($tbls == "support"){
            $this->db->select('spt.*, mem.names, spt.id as id1');
            $this->db->from('support spt');

            if($params2 == "sent"){
                $this->db->where('sent_from', $params);
                if($params > 0) // if this is 0 then its the admin so no need for this below
                    $this->db->join('members mem', 'mem.id = spt.sent_from');
                else
                    $this->db->join('members mem', 'mem.id = spt.memid');
            }else{
                if($params != "")
                    $this->db->where('spt.memid', $params);

                if($params > 0)
                    $this->db->join('members mem', 'mem.id = spt.memid');
                else
                    $this->db->join('members mem', 'mem.id = spt.sent_from');
            }

            
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(mem.names like '%$txtsrchs%' OR spt.subj like '%$txtsrchs%' OR spt.message like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('spt.id', 'desc');
        }


        if($tbls=="quizes2"){
            $this->db->select('qq.subject_id, qq.years');
            $this->db->from('quizes2 q2');
            $this->db->where('q2.sessions', $params2);
            $this->db->join('quizes qq', 'qq.sessions = q2.sessions');
            $this->db->group_by('qq.subject_id, qq.years');
            $query = $this->db->get();
            $subject_ids = "";
            $years1 = "";
            $years2="";
            $subject_ids1 = "";

            if($query->num_rows() > 0){
                $query2 = $query->result_array();
                foreach ($query2 as $row) {
                    $subject_id = $row['subject_id'];
                    $subject_ids .= "$subject_id, ";
                }
                $subject_ids1 = substr($subject_ids, 0, -2);

                $query2 = $query->result_array();
                foreach ($query2 as $row) {
                    $years = $row['years'];
                    //$years1 .= "$years, ";
                }
                //$years2 = substr($years1, 0, -2);
                $years2 = $years;
            }



            $this->db->select('q2.*, q2.id AS id1');
            $this->db->from('quizes2 q2');
            if($params2 > 0)
                $this->db->where('q2.sessions', $params2);
            else
                $this->db->where('q2.sessions', $params);

            $subject_ids1 = explode(",", $subject_ids1);
            $subject_ids1 = array_unique($subject_ids1);

            // $years2 = explode(",", $years2);
            // $years2 = array_unique($years2);

            $this->db->where_in('qq.subject_id', $subject_ids1);
            $this->db->where_in('qq.years', $years2);

            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(q2.questions like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->join('quizes qq', 'qq.sessions = q2.sessions');
            $this->db->group_by('q2.questions');
            $this->db->order_by('q2.id', 'desc');
        }



        if($tbls=="quizes_intro"){
            $this->db->select('qi.id AS ids, qi.instructn, qi.aprvd, qi.sessions, qi.set_time, qi.dates, tb.test_types, qq.years, qq.test_board, qq.subject_id, qq.years')->where('qi.sessions !=', 0);
            $this->db->from("quizes_intro qi");
            $this->db->join('quizes qq', 'qq.sessions = qi.sessions');

            $this->db->join('test_boards tb', 'tb.id = qq.test_board');
            //$this->db->join('subjects sbs', 'sbs.id = qq.subject_id');
            //$this->db->join('schools sch', 'sch.id = qq.name_of_sch');

            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(sch.titles like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->group_by('qi.sessions');
            $this->db->order_by('qi.id', 'desc');
        }


        if($tbls=="blogs"){
            $this->db->select('*');
            $this->db->from($tbls);
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(titles like '%$txtsrchs%' OR descrip like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }


        if($tbls=="applications"){
            $this->db->select('apps.*, apps.id AS appid, sch.titles');
            $this->db->from('applications apps');
            $this->db->join('scholarships sch', 'sch.id = apps.scholarship_id');

            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(apps.names like '%$txtsrchs%' OR apps.country like '%$txtsrchs%' OR apps.qualification like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('apps.id', 'desc');
        }


        if($tbls=="stud_ans"){
            $this->db->select('sa.*, mem.names, sa.id AS sa_id, sa.subject_id, sa.time_finished, sa.scores, sa.date_taken, sa.quizintro_id, qi.set_time');
            $this->db->from('stud_ans sa')->where('qi.aprvd', 1);
            
            
            if($params2 != ""){
                $this->db->where('sa.memid', $params2);
                //$this->db->group_by('sa.memid');
            }

            $this->db->join('subjects subs', 'subs.id = sa.subject_id');
            $this->db->join('members mem', 'mem.id = sa.memid');
            $this->db->join('quizes_intro qi', 'sa.quizintro_id = qi.id');

            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(mem.names like '%$txtsrchs%' OR subs.subjs like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('sa.id', 'desc');
        }

    }




    public function getCountrys($country_ids){
        $country_ids = explode(',', $country_ids);
        $contry1 = "";
        foreach ($country_ids as $country_ids1) {
            if($country_ids1){
                $this->db->select('name');
                $this->db->from('countries');
                $this->db->where('id', $country_ids1);
                $query = $this->db->get();
                
                if($query->num_rows() > 0){
                    $contry = $query->row('name');
                    $contry1 .= "$contry, ";
                }else{
                    $contry1 .= "";
                }
            }
        }
        $contry2 = substr($contry1, 0, -2);
        return $contry2;
    }



    public function getBlogPics($tbl, $id){
        $this->db->select('files');
        $this->db->from($tbl);
        $this->db->where('rands', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    public function check_link($url, $tbl){
        $this->db->select('id');
        $this->db->from($tbl);
        $this->db->where('md5(id)', $url);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }



    function getMainID($id){
        $this->db->select('scholarship_id')->from('quizes_intro')->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('scholarship_id');
        }else{
            return false;
        }
    }

    

    function fetchSubjs($test_boards){
        $test_boards1 = str_replace("-", " ", $test_boards);
        
        $this->db->select('sbjs.subjs, sbjs.id AS subject_id, qz1.id as id1, qi.id as qi_id, qi.set_time, tbs.id AS test_board')->from('quizes qz1')->where('qi.aprvd', 1);
        $this->db->where('tbs.test_types', $test_boards1);

        $this->db->join('quizes_intro qi', 'qz1.sessions = qi.sessions');
        $this->db->join('subjects sbjs', 'sbjs.id = qz1.subject_id');
        $this->db->join('test_boards tbs', 'tbs.id = qz1.test_board');
        //$this->db->order_by('qz1.questions', 'desc');
        $this->db->group_by('qz1.subject_id');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }




    function fetchColleges($test_boards){
        $test_boards1 = str_replace("-", " ", $test_boards);
        $this->db->select('sch.name_of_sch')->from('quizes qz1')->where('qi.aprvd', 1);
        $this->db->join('test_boards tbs', 'tbs.id = qz1.test_board');
        $this->db->join('schools sch', 'sch.id = qz1.name_of_sch');
        $this->db->join('quizes_intro qi', 'qz1.sessions = qi.sessions');
        $this->db->where('tbs.test_types', $test_boards1);
        $this->db->order_by('sch.name_of_sch', 'asc');
        $this->db->group_by('sch.name_of_sch');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchExamBoards($id){
        $this->db->select('qi.id as id1, subj.subjs, subj.id')->from('quizes qi')->where('qi.test_board', $id);
        $this->db->join('subjects subj', 'subj.id = qi.subject_id');
        $this->db->order_by('subj.subjs', 'asc');
        $this->db->group_by('qi.subject_id', 'asc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function fetctSubjDets($ids_arrays, $id, $test_board, $name_of_sch1){ //$id quizes id
        if($ids_arrays == "arrays"){
            $id = explode(",", $id);
        }

        if($ids_arrays == "arrays")
            $this->db->select('qz.id as id1, qz.test_board, qz.subject_id, tb.test_types, qz.name_of_sch as name_of_sch1, sch.name_of_sch, qi.instructn, qi.set_time')->from('quizes qz');
        else
            $this->db->select('qi.id as id1, qz.test_board, qz.subject_id, tb.test_types, qz.name_of_sch as name_of_sch1, qi.instructn, qi.set_time')->from('quizes qz');

        if($ids_arrays == "arrays"){
            $id = str_replace(array("\n", " "), "", $id);
            $this->db->where_in('qz.subject_id', $id);
        }else{
            $this->db->where('qz.subject_id', $id);
        }

        if($name_of_sch1!="")
            $this->db->where('qz.name_of_sch', $name_of_sch1);
        $this->db->where('tb.id', $test_board);

        $this->db->join('subjects subj', 'subj.id = qz.subject_id');

        if($ids_arrays == "arrays")
            $this->db->join('schools sch', 'sch.id = qz.name_of_sch');

        $this->db->join('test_boards tb', 'tb.id = qz.test_board');
        $this->db->join('quizes_intro qi', 'qz.sessions = qi.sessions');

        if($ids_arrays == "arrays")
            $this->db->order_by('sch.name_of_sch', 'asc');
        else
            $this->db->order_by('qz.id', 'desc');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    
    function fetchSubjYears($subject_id, $id_arrays, $test_board, $name_of_sch1){
        //echo $subject_id;
        $this->db->select('years')->from('quizes');
        if($id_arrays=="arrays"){
            $subject_id = str_replace("\n", "", $subject_id);
            $subject_id1 = explode(",", $subject_id);

            $this->db->where_in('subject_id', $subject_id1);
        }else{
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->where('test_board', $test_board);
        if($name_of_sch1!="")
            $this->db->where('name_of_sch', $name_of_sch1);

        $this->db->group_by('years');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return "";
        }
    }



    function updateRecs1($id_sch, $subject_id, $memid, $ids_arr, $submitted_attempts){
        $this->db->select('id')->from('stud_start_test')
        ->where('memid', $memid)->where('quiz_intro_id', $id_sch);

        $subject_id = str_replace(array("\n", " "), "", $subject_id);
        $this->db->where('subject_id', $subject_id);

        $query = $this->db->get();
        $id1 = $query->row('id');

        if($query->num_rows() > 0){
            $this->db->where('id', $id1);
            //$this->db->set('attempts', "attempts-$submitted_attempts", FALSE);
            $this->db->set('attempts', $submitted_attempts, FALSE);
            $query = $this->db->update('stud_start_test');
            if(!$query){ // incase i open another test in a new window, it shud update my id instead

                $this->db->select('id')->from('stud_start_test')->where('memid', $memid)->where('attempts >', 0);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get();
                if($query->num_rows() > 0){
                    $this->db->where('memid', $memid)->where('attempts >', 0);
                    $this->db->set('attempts', $submitted_attempts, FALSE);
                    $query = $this->db->update('stud_start_test');

                }else{
                    $this->db->where('memid', $memid);
                    $query = $this->db->delete('stud_start_test');
                }
            }

        }else{ // delete
            $this->db->where('id', $id1);
            $query = $this->db->delete('stud_start_test');
        }
        if($query) return true; else return false;
    }


     

    function update_inserts_members($data, $memid){
        if($memid != "")
            $query1 = $this->db->where('sha1(id)', $memid)->update('members', $data);
        else
            $query1 = $this->db->insert('members', $data);

        if($query1){
            $names1 = explode(' ', $data['names']);
            return ucwords($names1[0]);
        }else{
            return false;
        }
    }

    

    

}

?>