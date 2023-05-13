
<?php
   require_once('validation.php');
    include "../classfile/dbconnection.php";
    include "../classfile/admin.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin panel</title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="assets/dist/img/ico/favicon.png" type="image/x-icon">

   <?php include 'common/head.php'; ?>
   <?php $titlelist=$obj->getalltitle();
     $project='';
     $status='';
     $title='';
     $id='';
     if(isset($_GET['id']))
     {
        $id=$_GET['id'];
        $singledata =$obj->getdatataId($id);
        while($single=mysqli_fetch_assoc($singledata))
        {
            $title= $single['title'];
            $project =$single['project'];
            $status = $single['status'];
        }
     }

    ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
           <header class="main-header">
                <a href="index-2.html" class="logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <!--<b>A</b>H-admin-->
                        <img src="assets/dist/img/mini-logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <!--<b>Admin</b>H-admin-->
                        <img src="assets/dist/img/logo.png" alt="">
                    </span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top ">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-tasks"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Orders -->
                            <li class="dropdown messages-menu">
                               <a href="#" class="dropdown-toggle admin-notification" data-toggle="dropdown"> 
                                <i class="pe-7s-cart"></i>
                                <span class="label label-primary">5</span>
                            </a>
                            
                            <!-- Notifications -->
                            
                            
                            <!-- user -->
                            <li class="dropdown dropdown-user admin-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                                <div class="user-image">
                                <img src="../assets/admin/assets/dist/img/avatar4.png" class="img-circle" height="40" width="40" alt="User Image">
                                </div>
                                </a>
                                <ul class="dropdown-menu">
                                    
                                    <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
             <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="image pull-left">
                           <!--  <img src="assets/dist/img/avatar5.png" class="img-circle" alt="User Image"> -->
                        </div>
                        <div class="info">
                            <h4>Welcome : <?php echo $_SESSION['username']?></h4>
                            
                        </div>
                    </div>
                   
                    <!-- sidebar menu -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="dashboard.php"><i class="fa fa-hospital-o"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user-md"></i><span>Title</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="title_master.php">Add Title</a></li>
                               
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user-md"></i><span>Project</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="completed_project.php">Add Completed Project</a></li>
                                <li><a href="ongoing_project.php">Add Ongoing Project</a></li>
                                
                            </ul>
                        </li>
                    </ul>
                            
            </ul>
        </div> <!-- /.sidebar -->
    </aside>
            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="header-icon">
                        <i class="pe-7s-note2"></i>
                    </div>
                    <div class="header-title">
                        <form action="#" method="get" class="sidebar-form search-box pull-right hidden-md hidden-lg hidden-sm">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>  
                        <h1>Add Title</h1>
                        <small>Title list</small>
                        <ol class="breadcrumb hidden-xs">
                            <li><a href=""><i class="pe-7s-home"></i>Home</a></li>
                            <li><a href="#">Add Title</a></li>
                            <li class="active">Title list</li>
                        </ol>
                    </div>
                </section>
                <div class="">
                                             
                                             
                                         </div>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- Form controls -->
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group"> 
                                      
                                        <span class="key" style="color:red;font-weight:bolder"><?php echo $str; ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                   <form  class="col-sm-6">
                                            <div class="form-group">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <label>Select Page</label>
                                                <select class="form-control" name="project" id="project">
                                                    <option value="Ongoing" <?php if($project=='Ongoing') echo "selected";  ?>>Ongoing Project</option>
                                                    <option value="completed" <?php if($project=='completed') echo "selected"; ?>>Completed Project</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                            <label>Title</label>
                                                <input type="text" name="title"  id="title" class="form-control" value="<?php if(!empty($title) && $title!=NULL) echo $title; ?>"  placeholder="Enter Title">
                                            </div>
                                           
                                        
                                        <div class="form-check">
                                          <label>Status</label><br>
                                          <label class="radio-inline">
                                              <input type="radio" name="status" id="status" value="1" <?php if($status=='1') echo 'checked="checked"';  ?>  checked="checked">Active</label> 
                                              <label class="radio-inline">
                                                  <input type="radio" name="status" id="status" value="0" <?php if($status=='0') echo 'checked="checked"';  ?> >Inctive</label>  
                                              </div>   
                                                                            
                                             <!--  <div class="reset-button">
                                                 <?php if(!empty($id)) { ?>  
                                                  <button type="submit" class="btn btn-success" name="update_title_btn">Update</button>
                                               <a href="#" class="btn btn-warning">Reset</a>
                                               <?php } else { ?>
                                                <button type="button" class="btn btn-success" id="submit">Submit</button>
                                               <a href="#" class="btn btn-warning">Reset</a>
                                               <?php } ?>
                                           </div> -->
                                           <button type="button" class="btn btn-success" id="submit">Submit</button>
                                       </form>
                                       
                                        <div class="table-responsive">
                                          <form action="update.php" name="gst_list_form" method="post" class="form-horizontal" role="form">
                                   <div class="pull-right text-center MarLR10">
                                        <p><a class="btn btn-danger" onClick="validateRecordsBlock()"></a></p>
                                        <p>Block</p>
                                    </div>
                                    <div class="pull-right text-center MarLR10">
                                        <p><a class="btn btn-success" onClick="validateRecordsActivate()"></a></p>
                                        <p>Activate</p>
                                    </div>                               
                            <input type="hidden" name="task" id="task" value="" />
                                <table id="tableId" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="8%">Sl. No.</th>
                                            <th width="4%"><input type="checkbox" name="main_check" id="main_check" onClick="check_uncheck_All_records()" value="" /></th>
                                            <th width="*">Name</th>
                                            <th width="*">Code</th>
                                             <th width="*">Code</th>
                                            
                                            <th width="*">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php $c=0; while ($row = mysqli_fetch_assoc($titlelist)) {  $c++;
                                        $id=$row['id']; ?>
                 
                                                <tr>
                                                    <td><?php echo $c;?></td>
                                                    <td><input type="checkbox" name="sel_recds[]" id="sel_recds<?php echo $c; ?>" value="<?php echo $row['id']; ?>" /></td>
                                                    
                                                    <td><?php echo $row['project'];?></td>
                                                    <td><?php echo $row['title'];?></td>
                                                  
                                                   
                                                   <td><?php if($row['status']==1) { ?><span class="label-success label label-default">Active</span><?php } else { ?><span class="label-default label label-danger">Inactive</span> <?php } ?>
                                                <button class="btn btn-danger fa fa-trash" type="button" data-toggle="modal" data-target="#delete<?php echo $id; ?>">&nbsp;&nbsp;</button>
                                                  <a  class="btn btn-success shadow btn-xs sharp mr-1"  href="title_master.php?id=<?php echo $id; ?>"><i class="fa fa-pencil"></i></a>
                                            </td>
                                             <div id="delete<?php echo $id; ?>" class="modal fade" role="dialog">
                                                  <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                      <div class="modal-header" style="background-color:#d1e0e0;color:white;">
                                                        <h4 class="modal-title">Alert!!</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <p>Are you sure, you want to remove this data<br>(This action may lost your data permanently)</p>
                                                        <form action="" method="POST">
                                                             <input type="hidden" name="tid" value="<?php echo $id; ?>">
                                                            <button class="btn btn-danger" type="submit" name="btitle_delete">Yes</button>
                                                            <button class="btn btn-warning" type="button" data-dismiss="modal">No</button>
                                                        </form>
                                                      </div>
                                                      
                                                    </div>
                                                  </div>
                                                </div>
                                                </tr>
                  <?php } ?>
                                    </tbody>
                                </table>
                            </form>    

                            </div>
                                       </div>

                                   </div>
                               </div>
                           </div>
                       </div>
                   </section> <!-- /.content -->
               </div> <!-- /.content-wrapper -->
               <footer class="main-footer">
                <div class="pull-right hidden-xs"> <b>Version</b> 1.0</div>
                <strong>Copyright &copy; 2023 <a href="#"></a>.</strong> All rights reserved.
            </footer>
        </div> <!-- ./wrapper -->
        <!-- Start Core Plugins
        =====================================================================-->
        <script>  
        $(document).ready(function() {
            $('#export-pdf').click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'generate_pdf.php',
                    data: { 'cat':cat },
                    success: function(response) {
                        // handle the PDF response, for example, open it in a new window
                        window.open(response);
                    }
                });
            });
        });

        </script>
        <script>
        $(document).ready(function() {
 
            $("#submit").click(function() {
 
                var project = $("#project").val();
                var title = $("#title").val();
                var status = $("#status").val();
                
                if(project==''||title==''||status=='') {
                    alert("Please fill all fields.");
                    return false;
                }
 
                $.ajax({
                    type: "POST",
                    url: "store.php",
                    data: {
                        project: project,
                        title: title,
                        status: status
                       
                    },
                    cache: false,
                    success: function(data) {
                        alert(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
                 
            });
 
        });
    </script>
    <script type="application/javascript">
  function check_uncheck_All_records() // done
  {
    var mainCheckBoxObj = document.getElementById("main_check");
    var checkBoxObj = document.getElementsByName("sel_recds[]");
    
    for(var i = 0; i < checkBoxObj.length; i++){
      if(mainCheckBoxObj.checked)
        checkBoxObj[i].checked = true;
      else
        checkBoxObj[i].checked = false;
    }
  }

  function validateCheckedRecordsArray() // done
  {
    var checkBoxObj = document.getElementsByName("sel_recds[]");
    var count = true;
  
    for(var i = 0; i < checkBoxObj.length; i++){
      if(checkBoxObj[i].checked){
        count = false;
        break;
      }
    }
    
    return count;
  } 

  function validateRecordsActivate() // done
  {
    if(validateCheckedRecordsArray()){
      alert("Please select any record to activate.");
      document.getElementById("sel_recds1").focus();
      return false;
    }
    else{
      document.gst_list_form.task.value = 'active';
      document.gst_list_form.submit();
    }
  }
  
  function validateRecordsBlock() // done
  {
    if(validateCheckedRecordsArray()){
      alert("Please select any record to block.");
      document.getElementById("sel_recds1").focus();
      return false;
    }
    else{
      document.gst_list_form.task.value = 'block';
      document.gst_list_form.submit();
    }
  }
</script>

        <!-- jQuery -->
        <script src="../assets/admin/assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <!-- jquery-ui --> 
        <script src="../assets/admin/assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="../assets/admin/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- lobipanel -->
        <script src="../assets/admin/assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
        <!-- Pace js -->
        <script src="../assets/admin/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="../assets/admin/assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="../assets/admin/assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- Hadmin frame -->
        <script src="../assets/admin/assets/dist/js/custom1.js" type="text/javascript"></script>
       
        <!-- End Core Plugins
        =====================================================================-->
        <!-- Start Theme label Script
        =====================================================================-->
        <!-- Dashboard js -->
        <script src="../assets/admin/assets/dist/js/custom.js" type="text/javascript"></script>
        <!-- End Theme label Script
        =====================================================================-->
      
    </body>
</html>
