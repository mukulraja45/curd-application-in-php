<?php
 //include "../classfile/admin.php";
 include "../classfile/dbconnection.php";
    $con=new config();

     if (isset($_POST['task']) && $_POST['sel_recds']) 
     {
         
                $entereddata=array();
        		//$entereddata['updated_at']=date('Y-m-d H:i:s');
        		//$entereddata['updated_by']=$this->session->userdata("sess_admuser_id");
        		$task = $_POST['task'];
        		if($task == 'active')
        			$entereddata['status']=1;
        		else
        			$entereddata['status']=0;
        		$sel_recds = $_POST['sel_recds'];
        		$insertStatus = $con->updateMultipleRecord($entereddata,'update_slider',$sel_recds);
        		if($insertStatus == 1) 
                    {
                    echo "<script>window.location.href ='title_master.php'</script>";
        		    echo "<script>alert('Update successfull.')</script>";
        		    $str="Update";
                    }
        		else
                    {
        			$str="fail";
                    }

                
   }
   
?>