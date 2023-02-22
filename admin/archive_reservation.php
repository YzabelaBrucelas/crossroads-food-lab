<?php
session_start();    

if (!isset($_SESSION['user_email'])) 
    {
        echo "<script> alert ('You are not an admin, Please log in first!')</script>";
        echo "<script>window.open('admin_login.php','_self')</script>";
    }
    else{
        
    }

                                global $con;

                                include("includes/db.php");
                                
                                  $get_logo = "select * from logo";
                                  $run_logo = mysqli_query($con, $get_logo);
                                  $row_logo = mysqli_fetch_array($run_logo);
                                            
                                  $logo_ID = $row_logo['id'];
                                  $logo_img = $row_logo['logo'];

                                $result1 = mysqli_query($con,'SELECT customer_ID, COUNT(customer_ID) FROM customers'); 
                                $row1 = mysqli_fetch_assoc($result1); 
                                $customer = $row1['COUNT(customer_ID)']; 

                                $result = mysqli_query($con,'SELECT inq_no, COUNT(inq_no) FROM inquiry'); 
                                $row = mysqli_fetch_assoc($result); 
                                $all_inquiry = $row['COUNT(inq_no)']; 


                                $inquiry = "SELECT count(*) as inquiry from inquiry where  status = 'unread'";
                                    $run = mysqli_query($con, $inquiry ); 
                                    $row=mysqli_fetch_array($run);
                                    
                                    $inquiries = $row['inquiry'];                 


                               
?>
                           
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Crossroads Food Lab</title>

    <link rel="icon" type="image" href="images/<?php echo"$logo_img" ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--ANIMATE-->
  <link rel="stylesheet" href="assets/css/animate.css">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="AdminLTE/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="AdminLTE/plugins/datatables/dataTables.style.min.css">

   <link rel="stylesheet" href="css/style1.css"/>
    <!-- Custom styles for this template -->

    <link rel="stylesheet" href="admin/assets/css/hover.css"/>

    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="js/style1.js"></script>
    

</head>



<body class="hold-transition sidebar-mini">
    
<div class="wrapper"><!--wrapper-->

  <!-- Main Sidebar Container-->
  <?php include("sidebar/side-archive_reservation.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Archive Reservations</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item">File Maintenance</li>
              <li class="breadcrumb-item">Archives</li>
              <li class="breadcrumb-item active">Reservation Archives</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<!-- Main content -->

  <!-- Main content -->
    <section class="content">

<div class="panel panel-default">
    <div class="panel-body">
 <div class="table-responsive">
<table id="example1" class="table table-bordered table-hover table-striped">
  <thead>
                                        <tr>
                    <td><center>Name</center></td>
                    <td><center>Date and Time Reserved</center></td>
                    <td><center>Status</center></td>
                    <td><center>Date Sent</center></td>
                     <td><center>Action</center></td>
                                            
                    
                                        </tr>
</thead>

 <tbody>

<?php
                                    include("includes/db.php");
                                    $get_inq = "SELECT * FROM archive_reservation order by sent_date desc";
                                    $run_inq = mysqli_query($con, $get_inq);
                                    $i = 0;

                                while ($row = mysqli_fetch_array($run_inq)) 
                                    {
                                         $res_id=$row['res_id'];
                                         $fname=$row['fname'];
                                        $lname=$row['lname'];
                                          $email=$row['email'];
                                        $contact_no=$row['contact_no'];
                                             $pax=$row['pax'];
                                       $res_date = $row['res_date'];
                                   $res_time=$row['res_time'];
                                    $status=$row['status'];
                              $sent_date=$row['sent_date'];

                                        if ($status=="confirmed") 
                                        {
                                           $flag="warning";
                                         $stat="warning fa-check-circle-o";
                                        }
                                        

                                        else if($status=="to be processed")
                                        {
                                          $flag="secondary";
                                        $stat="secondary fa-spinner";
                                        }
                                        
                                        else if($status=="cancel")
                                        {
                                          $flag="danger";
                                        $stat="danger fa-times";
                                        }
                                        
                                        else if($status=="finished")
                                        {
                                          $flag="success";
                                        $stat="success fa-check";
                                        }



                                        
                                        $i++;
                                    ?>



                    <tr>
                        <td><center><?php echo $fname;?> <?php echo $lname;?></center></td>
                        <td><center><?php echo $res_date;?> from <?php echo $res_time;?></center></td>
                        <td><center><b><?php echo $status;?></center></td>
                        <td><center><?php echo $sent_date;?></center></td>
                        <td><center>
                      <a class="btn btn-sm btn-success" onclick="return confirm('Are you sure do you want to restore this reservation ?')" href="archiverestore_res.php?restore_res=<?php echo $res_id;?>"> <i class="fa fa-refresh"></i></a>              
                                     

                      <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure do you want to delete this reservation permanently?')" href="archivedelete_res.php?delete_res=<?php echo $res_id;?>"> <i class="fa fa-trash-o"></i></a>   
         

                        </center></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </section>


  </div><!-- /.Content Wrapper. Contains page content -->
</div><!--./wrapper-->
<?php include("includes/footer.php");?>


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="AdminLTE/plugins/jquery/jquery.min.js"></script>

<script src="AdminLTE/plugins/style/js/style.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="AdminLTE/dist/js/demo.js"></script>

<!-- DataTables -->
<script src="AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="AdminLTE/plugins/datatables/dataTables.style.min.js"></script>

<!-- jVectorMap -->
<script src="AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>


<!-- PAGE SCRIPTS -->
<script src="AdminLTE/dist/js/pages/dashboard2.js"></script>

<!-- CK Editor -->
<script src="AdminLTE/plugins/ckeditor/ckeditor.js"></script>



   <!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>