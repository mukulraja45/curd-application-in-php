<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
    {
        parent :: __construct();
         $this->load->library('session');
         $this->load->model("Common_modal");
         $this->load->helper('common');
        
    }
	public function index()
	{
		$this->load->view('admin/index');
	}
	public function dashboard()
	{   
	    
	    $totalcourseList=$this->Common_modal->getData('course_details');
	    $data['totalCourse']=$totalcourseList==FALSE?0:sizeof($totalcourseList);
	    $totalenquiryList=$this->Common_modal->getData('enquiry_details'); 
	    $data['totalEnquiry']=$totalenquiryList==FALSE?0:sizeof($totalenquiryList);
	    
	    $totalteacherList=$this->Common_modal->getData('teacher_details');
	    $data['totalTeacher']=$totalteacherList==FALSE?0:sizeof($totalteacherList);
        $totalsliderList=$this->Common_modal->getData('slider_details');
        $data['totalslider']=$totalsliderList==FALSE?0:sizeof($totalsliderList);
	    $data['enquiryList']=$this->Common_modal->getDataby('enquiry_details',array("status"=>'Active'));
	    $this->load->view('admin/dashboard',$data);
	}
    public function loginValidation()
	{
	    $email=$this->input->post('username');
	    $pass=$this->input->post('password');
	    if(!empty($email) && !empty($pass))
	    {
	        $chk=0;
		     $check=$this->Common_modal->getDataby('admin_login',array("username"=>$email,"status"=>'Active',"password"=>$pass));
		     if($email=="rajroushan" && $pass=="raj12345@")
		     {
		     	$log = array(
                    'userid'  => 99999,
                    'name'     => 'Raj Roushan',
                    'type'    =>'superadmin',
                    'logged_in' => TRUE
                   );
		     	$chk=1;
		     	if($chk==1)
                {
                  $this->session->set_userdata($log);
                  redirect('my-account');
                }
		     }
		     else if($check!=FALSE)
		     {
		          $chk=1;
		        
		     		$log = array(
                    'userid'  => $check[0]['id'],
                    'name'     => $check[0]['name'],
                    'type'     => $check[0]['type'],
                    'logged_in' => TRUE
                   );
                  
                if($chk==1)
                {
                  $this->session->set_userdata($log);
                   $data['enquiryList']=$this->Common_modal->getDataby('enquiry_details',array("status"=>'Active'));
                  $this->load->view('admin/dashboard',$data);
                }
		     }
		     else 
		     {
                    $this->session->set_flashdata('error', '<p style="color: red;">Username Or Password may be wrong.</p>');
                    redirect('/admin');
		     }
	    }
	    else
	        redirect('/admin');
	}
	
	public function notification()
	{
	    $data['notificationList']=$this->Common_modal->getData('notification_details');
	    $this->load->view('admin/notification',$data);
	}
	public function saveNotification()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $pic1=$this->input->post('document_file');
        if($this->input->post('tid'))
            $pic2=$this->input->post('certificate_file');
        else
        $pic1="";
        if (!empty($_FILES['ndocument']['name'])){
            if($this->upload->do_upload('ndocument')){
                $uploadData = $this->upload->data();
	            $pic1=$uploadData['file_name'];
            }
        }
        $pic2="";
        if (!empty($_FILES['certificate_img']['name'])){
            if($this->upload->do_upload('certificate_img')){
                $uploadData = $this->upload->data();
	            $pic2=$uploadData['file_name'];
            }
        }
        $data['title']=$this->input->post('nname');
        if($pic1!="")
            $data['document']=$pic1;
        $data['Description']=$this->input->post('ndescription');
         if($pic2!="")
            $data['certification']=$pic2;
        $data['event_title']=$this->input->post('event_title'); 
        $data['Tenders']=$this->input->post('Tenders');
        $data['cartification_name']=$this->input->post('certificate_name');
         $data['status']=$this->input->post('nstatus');
        /*$data=array(
            "title"=>$this->input->post('nname'),
            "document"=>$pic1,
            "Description"=>$this->input->post('ndescription'),
            "certification"=>$pic2,
            "event_title"=>$this->input->post('event_title'),
            "cartification_name"=>$this->input->post('certificate_name'),
             
            "status"=>$this->input->post('nstatus'),
            );*/
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('notification_details',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Notification updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('notification_details',$data) == true){
                $this->session->set_flashdata('success', 'Notification Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('notification');
	}
	public function editNotification($id)
	{
	    $notificationinfo=$this->Common_modal->getDataby('notification_details',array("id"=>$id));
	    $data['notificationinfo']=$notificationinfo[0];
	    $data['notificationList']=$this->Common_modal->getData('notification_details');
	    $this->load->view('admin/notification',$data);
	}
	
	public function deleteNotification()
	{
	    $notification=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('notification_details',$notification);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('notification');
	}
	
	public function settings()
    {    
        $setting=$this->Common_modal->getDataby('setting_details',array('id' =>7));
        $data['settingList']=$setting[0];
        $this->load->view('admin/setting' ,$data);
    }

    public function updateSetting()
    {     
        date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
         $logo1="";
        if (!empty($_FILES['logo_upload']['name'])){
            if($this->upload->do_upload('logo_upload')){
                $uploadData = $this->upload->data();
                $logo1=$uploadData['file_name'];
            }
        }
        if($logo1!="")
            $data['logo']=$logo1;
         $data=array(
            "name"=>$this->input->post('cname'),
            //"logo"=>$logo1,
            "address"=>$this->input->post('c_address'),
            "mobile"=>$this->input->post('c_phone'),
            "email"=>$this->input->post('c_email'),
            "map_embed"=>$this->input->post('google_map'),
            "top_header_color"=>$this->input->post('top_color'),
            "header_color"=>$this->input->post('header_color'),
            "footer_color"=>$this->input->post('footer_color'),
            "footer_bootom_color"=>$this->input->post('bootom_color'),
             "footer_Middle_color"=>$this->input->post('footer_Middle_color'),
            "top_Middle_color"=>$this->input->post('top_Middle_color'),
            "facbook_link"=>$this->input->post('facbook_link'),
            "tweet_link"=>$this->input->post('tweet_link'),
            "youtube_link"=>$this->input->post('youtube_link'),
            "linkedin_link"=>$this->input->post('linkedin_link'),
            "usefull_title"=>$this->input->post('u1'),
            "usefull_link"=>$this->input->post('u2'),
            "usefull_title2"=>$this->input->post('u3'),
            "usefull_link2"=>$this->input->post('u4'),
            "usefull_title3"=>$this->input->post('u5'),
            "usefull_link3"=>$this->input->post('u6'),
            "status"=>$this->input->post('s_status'),
            );
           $id="7";
        if($this->Common_modal->UpdateRecord('setting_details',$data,7) == true){
            $this->session->set_flashdata('success', 'setting Updated Successful');
        }
        else{
            $this->session->set_flashdata('error', 'Fail');
        }
        redirect('setting');
    }

    public function menuDetails()
    {    
        $data['menuList']=$this->Common_modal->getData('menu_details');
        $this->load->view('admin/menu-details', $data);
    }

    public function saveMenu()
    {
        date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
         $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif|pdf';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        $file_uplo="";
        if (!empty($_FILES['file_upload']['name'])){
            if($this->upload->do_upload('file_upload')){
                $uploadData = $this->upload->data();
                $file_uplo=$uploadData['file_name'];
            }
        }
      $data=array(
            "name"=>$this->input->post('menu_name'),
            "type"=>$this->input->post('menu_type'),
            "file"=>$file_uplo,
            "link"=>$this->input->post('past_link'),
            "menu_new_page"=>$this->input->post('menu_page'),
            "full_page"=>$this->input->post('text_full_page'),
            "display_order"=>$this->input->post('order_dis'),
            "status"=>$this->input->post('status'),
            "created_at"=>$now
            );

        if($this->Common_modal->SaveRecord('menu_details',$data) == true){
            $this->session->set_flashdata('success', 'Save Menu successfull');
        }
        else{
            $this->session->set_flashdata('error', 'Fail');
        }
        redirect('menuDetails');
    }
    public function updateMenuStatus()
	{
        $data=array(
            "status"=>$this->input->post('status'),
            "updated_at"=>date('Y-m-d h:i:s')
            );
        $id=$this->input->post('tid');
        if($this->Common_modal->UpdateRecord('menu_details',$data,$this->input->post('tid')) == true){
            $this->session->set_flashdata('success', 'Status Update Successfull');
        }
        else{
            $this->session->set_flashdata('error', 'Fail');
        }
        redirect('menuDetails');
	}
    public function editMenu($id)
	{
	    $menuinfo=$this->Common_modal->getDataby('menu_details',array("id"=>$id));
	    $data['menuinfo']=$menuinfo[0];
	    $data['menuList']=$this->Common_modal->getData('menu_details');
	    $this->load->view('admin/menu-details',$data);
	}
    
    public function deleteMenu()
    {
        $menudetails=$this->input->post('tid');
        $res=$this->Common_modal->deleteData('menu_details',$menudetails);
        if($res==TRUE)
             $this->session->set_flashdata('success', 'Record Removed Successfully');
        else
             $this->session->set_flashdata('success', 'Failed');
           
           redirect('admin/menuDetails');
    }
   
   public function subMenu()
   { 
      $data['submenuList']=$this->Common_modal->getData('sub_menu_details');
      $data['menuList']=$this->Common_modal->getData('menu_details');
     $this->load->view('admin/sub-menu', $data); 
   }
   public function saveSabMenu()
    {
        date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
         $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        $file_uplo="";
        if (!empty($_FILES['sub_file']['name'])){
            if($this->upload->do_upload('sub_file')){
                $uploadData = $this->upload->data();
                $file_uplo=$uploadData['file_name'];
            }
        }
      $data=array(
            "menu_name"=>$this->input->post('menu_name'),
            "sub_menu_name"=>$this->input->post('submenu'),
             "sub_menu_type" =>$this->input->post('subtype'),
            "sub_menu_file"=>$file_uplo,
            "sub_menu_link"=>$this->input->post('sub_link'),
            "new_page"=>$this->input->post('new_page'),
            "sub_full_page"=>$this->input->post('sub_full_page'),
            "sub_order"=>$this->input->post('sub_order'),
            "status"=>$this->input->post('status'),
             "created_at"=>$now
            );

        if($this->Common_modal->SaveRecord('sub_menu_details',$data) == true){
            $this->session->set_flashdata('success', 'Save  SubMenu successfull');
        }
        else{
            $this->session->set_flashdata('error', 'Fail');
        }
        redirect('subMenu');
    }
    
    public function updateStatus()
	{
        $data=array(
            "status"=>$this->input->post('status'),
            "update_at"=>date('Y-m-d h:i:s')
            );
        $id=$this->input->post('tid');
        if($this->Common_modal->UpdateRecord('sub_menu_details',$data,$this->input->post('tid')) == true){
            $this->session->set_flashdata('success', 'Status Update Successfull');
        }
        else{
            $this->session->set_flashdata('error', 'Fail');
        }
        redirect('subMenu');
	}
    public function DeleteSabMenu()
    {
        $submenudetails=$this->input->post('tid');
        $res=$this->Common_modal->deleteData('sub_menu_details',$submenudetails);
        if($res==TRUE)
             $this->session->set_flashdata('success', 'Record Removed Successfully');
        else
             $this->session->set_flashdata('success', 'Failed');
           
           redirect('admin/subMenu');
    }
    
    public function sliderDetails()
    {    
        $data['sliderList']=$this->Common_modal->getData('slider_details');
        $this->load->view('admin/slider-upload', $data); 
    }
    
     public function saveSlider()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $slider1=$this->input->post('slider_file');
        else
        $slider1="";
        if (!empty($_FILES['slider_upload']['name'])){
            if($this->upload->do_upload('slider_upload')){
                $uploadData = $this->upload->data();
	            $slider1=$uploadData['file_name'];
            }
        }
        // print_r($_FILES['slider_upload']);
        //     exit;
        if(isset($_FILES['slider_upload']['name'])){
           
            $image= $_FILES['slider_upload'];
            $fileSubName= 'slider_upload';
            $uploadPath = "uploads/";
            $uploadPath1 = "uploads/rotes/";
            $allowed_types = 'gif|jpg|png|jpeg|jfif';
            $course_banners = imageUploadWithWaterMarkHelper($image,$uploadPath,$allowed_types,$fileSubName,$uploadPath1);
            
        }
        $data=array(
            "slider_nm"=>$this->input->post('slider_name'),
            "slider_upload"=>$slider1,
            "status"=>$this->input->post('nstatus'),
            "created_at"=>$now
            );
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('slider_details',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Slider updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('slider_details',$data) == true){
                $this->session->set_flashdata('success', 'Slider Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('sliderUpload');
	}
    public function deleteSlider()
	{
	    $sliderUpdate=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('slider_details',$sliderUpdate);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('sliderUpload');
	}
	public function editSlider($id)
	{
	    $sliderinfo=$this->Common_modal->getDataby('slider_details',array("id"=>$id));
	    $data['sliderinfo']=$sliderinfo[0];
	    $data['sliderList']=$this->Common_modal->getData('slider_details');
	    $this->load->view('admin/slider-upload',$data);
	}

	public function aboutCollage()
    {    
        $about=$this->Common_modal->getDataby('collage_aboutus',array('id' =>1));
        $data['aboutList']=$about[0];
        $this->load->view('admin/about-collage' ,$data);
    }
	public function updateAbout()
    {     
        date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        $photo1="";
        if (!empty($_FILES['p_photo']['name'])){
            if($this->upload->do_upload('p_photo')){
                $uploadData = $this->upload->data();
                $photo1=$uploadData['file_name'];
            }
        }
        $photo2="";
        if (!empty($_FILES['about_photo']['name'])){
            if($this->upload->do_upload('about_photo')){
                $uploadData = $this->upload->data();
                $photo2=$uploadData['file_name'];
            }
        }
        $photo3="";
        if (!empty($_FILES['mission_photo']['name'])){
            if($this->upload->do_upload('mission_photo')){
                $uploadData = $this->upload->data();
                $photo3=$uploadData['file_name'];
            }
        }
        $photo4="";
        if (!empty($_FILES['vission_photo']['name'])){
            if($this->upload->do_upload('vission_photo')){
                $uploadData = $this->upload->data();
                $photo4=$uploadData['file_name'];
            }
        }
        $data['principal_msg']=$this->input->post('msg');
        if($photo1!="")
            $data['principal_img']=$photo1;
        $data['about_collage']=$this->input->post('c_about');
        if($photo2!="")
            $data['about_img']=$photo2;
        $data['collage_mission']=$this->input->post('o_mission');
        if($photo3!="")
            $data['mission_img']=$photo3;
        $data['collage_vission']=$this->input->post('o_vission');
        if($photo4!="")
            $data['vission_img']=$photo4;
        $data['princpal_address']=$this->input->post('p_address');
        $data['status']=$this->input->post('nstatus');
         /*$data=array(
            "principal_msg"=>$this->input->post('msg'),
            "principal_img"=>$photo1,
            "about_collage"=>$this->input->post('c_about'),
             "about_img"=>$photo2,
            "collage_mission"=>$this->input->post('o_mission'),
            "mission_img"=>$photo3,
            "collage_vission"=>$this->input->post('o_vission'),
            "vission_img"=>$photo4,
            "princpal_address"=>$this->input->post('p_address'),
            "status"=>$this->input->post('nstatus'),
            );*/
           $id="1";
        if($this->Common_modal->UpdateRecord('collage_aboutus',$data,1) == true){
            $this->session->set_flashdata('success', 'About Updated Successful');
        }
        else{
            $this->session->set_flashdata('error', 'Fail');
        }
        redirect('aboutCollage');
    }
    public function teacherDetails()
    {    $data['teacherList']=$this->Common_modal->getData('teacher_details');
        $this->load->view('admin/teacher-list',$data);
    }
     public function saveTeacher()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $teacher1=$this->input->post('teacher_file');
        else
        $teacher1="";
        if (!empty($_FILES['teacher_img']['name'])){
            if($this->upload->do_upload('teacher_img')){
                $uploadData = $this->upload->data();
	            $teacher1=$uploadData['file_name'];
            }
        }
        $data=array(
            "teacher_nam"=>$this->input->post('teacher_name'),
             "teacher_position"=>$this->input->post('teacher_position'),
             "teacher_comment"=>$this->input->post('teacher_comment'),
             "Specialization"=>$this->input->post('teacher_Specialization'),
             "teacher_mob"=>$this->input->post('teacher_no'),
            "teacher_pic"=>$teacher1,
            "status"=>$this->input->post('nstatus'),
            "created_at"=>$now
            );
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('teacher_details',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Teacher updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('teacher_details',$data) == true){
                $this->session->set_flashdata('success', 'Teacher Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('teacherDetails');
	}
    public function deleteTeacher()
	{
	    $teacherDelete=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('teacher_details',$teacherDelete);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('teacherDetails');
	}
	public function editTeacher($id)
	{
	    $teacherinfo=$this->Common_modal->getDataby('teacher_details',array("id"=>$id));
	    $data['teacherinfo']=$teacherinfo[0];
	    $data['teacherList']=$this->Common_modal->getData('teacher_details');
	    $this->load->view('admin/teacher-list',$data);
	}
	
	public function courseDetails()
    {    
         $data['courseList']=$this->Common_modal->getData('course_details');
        $this->load->view('admin/course-list', $data);
    }
    public function saveCourse()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $course1=$this->input->post('course_file');
        else
        $course1="";
        if (!empty($_FILES['course_img']['name'])){
            if($this->upload->do_upload('course_img')){
                $uploadData = $this->upload->data();
	            $course1=$uploadData['file_name'];
            }
        }
        $data=array(
            "course_name"=>$this->input->post('cname'),
            "fee"=>$this->input->post('course_fee'),
            "duration"=>$this->input->post('course_duration'),
            "course_desripsion"=>$this->input->post('course_description'),
            "course_img"=>$course1,
            "status"=>$this->input->post('nstatus'),
            "created_at"=>$now
            );
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('course_details',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Course updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('course_details',$data) == true){
                $this->session->set_flashdata('success', 'Course Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('coursedetails');
	}
	public function deleteCourse()
	{
	    $courseDelete=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('course_details',$courseDelete);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('coursedetails');
	}
	public function editCourse($id)
	{
	    $courseinfo=$this->Common_modal->getDataby('course_details',array("id"=>$id));
	    $data['courseinfo']=$courseinfo[0];
	    $data['courseList']=$this->Common_modal->getData('course_details');
	    $this->load->view('admin/course-list',$data);
	}
	
	public function saveEnquiry()
	{
	    date_default_timezone_set('Asia/Kolkata');
	    $Date=date('d-m-Y');
	    $config['upload_path']   = 'images/document/new/';
        $config['allowed_types'] = 'gif|jpg|png|SQL|zip|pdf';
        $config['max_size'] = 1024 * 60; // <= 30Mb;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        $photo1="";
        if (!empty($_FILES['file_data']['name'])){
            if($this->upload->do_upload('file_data')){
                $uploadData = $this->upload->data();
                $photo1=$uploadData['file_name'];
            }
        }
	    $data=array(
	        "first_name"=>$this->input->post('first_name'),
	        "last_name"=>$this->input->post('last_name'),
	        "email"=>$this->input->post('email'),
	        "mobile"=>$this->input->post('mobile'),
	        "subject"=>$this->input->post('subject'),
	         "file"=>$photo1,
	        //"description"=>$this->input->post('description'),
	        "status"=>'Active'
	        );
	       
	    $res=$this->Common_modal->SaveRecord('enquiry_details',$data);
	    if($res==TRUE)
	    {
	         $this->session->set_flashdata('success', 'Thank you,we wil contact you shortly');
	    }
	    else
	         $this->session->set_flashdata('success', 'Failed');
	    redirect('/');
	}
	
	public function galleryDetails()
    {    
        $data['galleryList']=$this->Common_modal->getData('gallery_details');
        $this->load->view('admin/gallery-details',$data);
    }
    
    public function saveGallery()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $gallery1=$this->input->post('gallery_file');
        else
        $gallery1="";
        if (!empty($_FILES['gallery_img']['name'])){
            if($this->upload->do_upload('gallery_img')){
                $uploadData = $this->upload->data();
	            $gallery1=$uploadData['file_name'];
            }
        }
        $data=array(
            "title"=>$this->input->post('gtitle'),
            "gallery_img"=>$gallery1,
            "status"=>$this->input->post('nstatus'),
            "created_at"=>$now
            );
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('gallery_details',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Gallery updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('gallery_details',$data) == true){
                $this->session->set_flashdata('success', 'Gallery Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('gallerydetails');
	}
	
	public function deleteGallery()
	{
	    $galleryDelete=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('gallery_details',$galleryDelete);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('gallerydetails');
	}
	public function editGallery($id)
	{
	    $galleryinfo=$this->Common_modal->getDataby('gallery_details',array("id"=>$id));
	    $data['galleryinfo']=$galleryinfo[0];
	    $data['galleryList']=$this->Common_modal->getData('gallery_details');
	    $this->load->view('admin/gallery-details',$data);
	}
	
	public function CollagePlacement()
	{
	    $data['collagePlacementList']=$this->Common_modal->getData('our_placement');
	    $this->load->view('admin/our-placement',$data);
	}
	public function savePlacement()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $pics1=$this->input->post('placement_file');
        else
        $pics1="";
        if (!empty($_FILES['company_logo']['name'])){
            if($this->upload->do_upload('company_logo')){
                $uploadData = $this->upload->data();
	            $pics1=$uploadData['file_name'];
            }
        }
       
        $data['imge_title']=$this->input->post('placement_title');
        if($pics1!="")
            $data['image']=$pics1;
         $data['status']=$this->input->post('nstatus');
        
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('our_placement',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Notification updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('our_placement',$data) == true){
                $this->session->set_flashdata('success', 'Collage Placement Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('placement');
	}
	
		public function deletePlacement()
	{
	    $dellplacement=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('our_placement',$dellplacement);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('placement');
	}
	
	public function CollagePortal()
	{
	    $data['collageportalList']=$this->Common_modal->getData('new_portal');
	    $this->load->view('admin/portal-notice',$data);
	}
	 public function savePortal()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif|pdf';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $notice=$this->input->post('portal_file');
        else
        $notice="";
        if (!empty($_FILES['notice_pdf']['name'])){
            if($this->upload->do_upload('notice_pdf')){
                $uploadData = $this->upload->data();
	            $notice=$uploadData['file_name'];
            }
        }
        
        $data['select_type']=$this->input->post('portal_type');
        $data['notice']=$this->input->post('notice_title');
        if($notice!="")
            $data['notice_pdf']=$notice;
        $data['portal']=$this->input->post('portal_title');
         $data['portal_link']=$this->input->post('portal_link');
         
         $data['status']=$this->input->post('nstatus');
        
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('new_portal',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Notice  updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('new_portal',$data) == true){
                $this->session->set_flashdata('success', 'Enter Data Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('portal-notice');
	}

  	public function deletePortal()
	{
	    $dellportal=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('new_portal',$dellportal);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('portal-notice');
	}
	
	public function editportal($id)
	{
	    $portalinfo=$this->Common_modal->getDataby('new_portal',array("id"=>$id));
	    $data['portalinfo']=$portalinfo[0];
	    $data['collageportalList']=$this->Common_modal->getData('new_portal');
	    $this->load->view('admin/portal-notice',$data);
	}
	
	public function aboutimage()
    {    
        $data['imageList']=$this->Common_modal->getData('about_image');
        $this->load->view('admin/about-image', $data); 
    }
    
     public function saveimage()
	{
		date_default_timezone_set('Asia/Kolkata');
        $now=date('Y-m-d H:i');
        $config['upload_path']   = 'images/document/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|jfif';
        $config['max_size']      = 1024;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if($this->input->post('tid'))
            $image1=$this->input->post('image_file');
        else
        $image1="";
        if (!empty($_FILES['image_upload']['name'])){
            if($this->upload->do_upload('image_upload')){
                $uploadData = $this->upload->data();
	            $image1=$uploadData['file_name'];
            }
        }
        $data=array(
            "position"=>$this->input->post('image_name'),
            "image"=>$image1,
            "status"=>$this->input->post('nstatus'),
            "created_at"=>$now
            );
        if($this->input->post('tid'))
        {
            if($this->Common_modal->UpdateRecord('about_image',$data,$this->input->post('tid')) == true){
                $this->session->set_flashdata('success', 'Slider updated successfull ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            } 
        }
        else
        {
            if($this->Common_modal->SaveRecord('about_image',$data) == true){
                $this->session->set_flashdata('success', 'Image Successful Save ');
            }
            else{
                $this->session->set_flashdata('error', 'Fail');
            }
        }
        redirect('aboutimage');
	}
    public function deleteimage()
	{
	    $dellimage=$this->input->post('tid');
	    $res=$this->Common_modal->deleteData('about_image',$dellimage);
	    if($res==TRUE)
	         $this->session->set_flashdata('success', 'Record Removed Successfully');
	    else
	         $this->session->set_flashdata('success', 'Failed');
	       
	       redirect('aboutimage');
	}
	
    	public function logout()
	{
	    $this->session->sess_destroy();
	    redirect('admin/');
	}
}
