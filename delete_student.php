<?php
  require_once('db_connection.php');
  require_once('sand_box.php');
  $link=connect();
  page_header('Delete Student');
?>
</head>
<body>

  <?php require_once('nav.php');?>
  <div class="container">
    <div class="row">
      <div class="col-md-12 ">
      <div class="bg-warning text-center">
    <h4>Delete Student</h4>
  </div>
  <form action="#" method="GET">
    <div class="row">
          <div class="col-lg-4"><label for="name"> Type Roll No to Delete data:</label> </div>
          <div class="col-lg-6"><input type="number" class="form-control" id="rollno" name="roll_no" required placeholder="type Roll No" min="1"> </div>
          <div class="col-lg-2"><input type="submit" name="submit" value="Delete"> </div>
    </div>
  </form>
      <?php
/* Rules for Naming add under score between two words. */
  if(isset($_GET['submit']))
  {
    $roll_no=$_GET['roll_no'];
    $qname="Select Name,FName from students_info where Roll_No=".$roll_no;
    $exe_name=mysqli_query($link,$qname);
    $name_data=mysqli_fetch_assoc($exe_name);
    $name=$name_data['Name'];
    $fname=$name_data['FName'];


    $q="update students_info set status=0 WHERE Roll_NO=".$roll_no;
    $exe=mysqli_query($link,$q);
    if($exe) { echo
        "<div class='alert alert-success' role='alert'> Roll No
        $roll_no . $name . $fname + Deleted Successfully  </div>";
        header("Refresh:5; url=delete_student.php");
      }
      else{ echo "Error in Delete Query". mysqli_error($link);}

  }

?>
    <?php page_close(); ?>