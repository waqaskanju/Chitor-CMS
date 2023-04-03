<?php
/**
 * Show Student detail
 * php version 8.1
 *
 * @category Student
 *
 * @package None
 *
 * @author Waqas <waqas@waqaskanju.com>
 *
 * @license http://www.waqaskanju.com/license MIT
 *
 * @link http://www.waqaskanju.com/
 **/
  session_start();
  require_once 'db_connection.php';
  require_once 'sand_box.php';
  require_once 'config.php';
  $link=connect();
  $selected_class=$CLASS_NAME;
  $selected_school=$SCHOOL_NAME;
?>
<?php Page_header("Setting");
// Change Selected School, Class and Website Read Write Permission
if (isset($_SESSION['user'])) {

    if (isset($_GET['submit'])) {
        $school=$_GET['school'];
        $school_id =Convert_School_Name_To_id($school);
        $class=$_GET['class_exam'];
        $class_id=Convert_Class_Name_To_id($class);
        // Webiste Read write Permission.
        //$permission=$_GET['permission'];
        $user_id=$_SESSION['user'];
        $q="Update setting SET
            Selected_School_Id='$school_id', Selected_Class_Id='$class_id' 
            WHERE User_Id='$user_id'";

        $exe=mysqli_query($link, $q);
        if ($exe) {
            echo "<div class='alert alert-success' role='alert'>
                        Values Updated
                  </div> ";
            header("Refresh:1; url=setting.php");
        } else {
            echo "Values Not Update";
        }
    }
    // Change Exam Marks Lock
    if (isset($_GET['Lock_Form'])) {
        $class_name=$_GET['class_exam'];
        $class_id=Convert_Class_Name_To_id($class_name);
        $subject_name=$_GET['subject'];
        $subject_id=Convert_Subject_Name_To_id($subject_name);
        $school_name=$_GET['school'];
        $school_id=Convert_School_Name_To_id($school_name);
        $lock_status=$_GET['lock_status'];

        $q="Update class_subjects SET Lock_Status='$lock_status'
            WHERE Class_Id='$class_id' AND Subject_Id='$subject_id' AND
            School_Id='$school_id'";

        $exe=mysqli_query($link, $q);
        if ($exe) {
            echo "<div class='alert alert-success' role='alert'>
                        Lock Updated
                  </div>";
            header("Refresh:1; url=subject_link.php");
        } else {
            echo "Values Not Update";
        }
    }
    // End of session
    ?>
</head>

<body>
  <!-- School Class and Website read write Form -->
    <div class="bg-warning text-center">
        <h4>Setting Page</h4>
    </div>
    <?php include_once 'nav.html'; ?>
    <div class="container">
        <h3 class="text-info">Change Class and School Name</h3>
        <form method="GET" action="#" class="mt-3">
            <div class="row">
                <?php
                Select_class($selected_class);
                Select_school($selected_school);
                ?>
            </div>
                <div class="col-sm-4">
                    <button type="submit" name="submit" class="btn btn-primary mt-3">
                        Update School And Class
                    </button>
                </div>
        </form>
    </div>
<!-- Form For Update of Subject Lock -->
    <div class="container mt-3">
      <h3 class="text-info">Update Subject Lock</h3>
      <form method="GET" action="#">
        <div class="row">
        <?php
        $selected_class='';
        $selected_subject='';
        $selected_school='';
        Select_school($selected_school);
        Select_subject($selected_subject);
        Select_class($selected_class);
        ?>
        </div>
        <div class="row mt-3">
          <div class="col-md-6">
            <select class='form-control' name="lock_status">
                <option value="Select Lock Status" value='none'>
                    Select Permission
                </option>
                <option value="1">Lock</option>
                <?php
                if ($MARKS_LOCK_CHANGES=="1") {
                    ?>
                <option value="0">Unlock</option>
                <?php  } ?>
            </select>
          </div>
          <div class="col-md-4">
                <button type="submit" name="Lock_Form" class="btn btn-primary">
                    Update Lock
                </button>
          </div>
        </div> <!-- end of row -->
      </form>
    </div> <!-- end of container -->
    <?php
} else {
    echo "<h1 class='text-danger'>
    You are not logged in... Redirecting to Login Page
    </h1>";
    header("Refresh:3; url=login.php");

}


?>
