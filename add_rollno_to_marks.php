<?php
/**
 * Add  All Subjects Marks of Students
 * php version 8.1
 *
 * @category Exam
 *
 * @package None
 *
 * @author Waqas <admin@waqaskanju.com>
 *
 * @license http://www.waqaskanju.com/license MIT
 *
 * @link http://www.waqaskanju.com
 **/
session_start();
require_once 'db_connection.php';
require_once 'sand_box.php';
require_once 'config.php';
$link=connect();
// $selected_class=$CLASS_INSERT;
// $selected_school=$SCHOOL_INSERT;
$mode = $MODE;

if ($mode=="read") {
    echo '<div class="bg-danger text-center"> Not allowed!! </div>';
    exit;
}

/* Rules for Naming add under score between two words. */
if (isset($_GET['submit'])) {
    $q="SELECT Roll_No from Students_Info WHERE Status=1";
    $exe=mysqli_query($link, $q);
    While ($exer=mysqli_fetch_assoc($exe)) {
        $roll_no=$exer['Roll_No'];
        $q2="SELECT Roll_No from marks WHERE Roll_No='$roll_no'";
        $exe2=mysqli_query($link, $q2);
        $effect=mysqli_num_rows($exe2);
        if ($effect==0) {
            $q3="INSERT INTO marks (Roll_No) VALUES($roll_no)";
            $exe3=mysqli_query($link, $q3);
            if ($exe3) {
                echo "INSERTED $roll_no <br>";
            }
        } else {
            echo "$roll_no already present <br>";
        }
    }
}
?>
  <?php Page_header('Add Roll No to  Marks Table'); ?>
</head>

<body>

<form action="#" method="GET">
<input type="submit" class="btn btn-primary" 
       value="Insert Roll No in Marks Table" name="submit"> 
</form>

<?php Page_close(); ?>