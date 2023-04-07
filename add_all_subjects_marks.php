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
require_once 'sand_box.php';


if (isset($_SESSION['user'])) {

    if ($BATCH_MARKS_CHANGES=="0") {
        echo "<div class='bg-danger'>
                Limited Permission.View this page is Not Allowed.
              </div>";
        exit;
    }
    $link=connect();
    if (isset($_GET['submit'])) {
        $roll_no=$_GET['rollno'];
        /* Urdu */
        $urd_marks=$_GET['urd'];
        /* Arabic */
        $ara_marks=$_GET['ara'];
        /* Science */
        $sci_marks=$_GET['sci'];
        /* Maths */
        $mat_marks=$_GET['mat'];
        /* Islamayat */
        $isl_marks=$_GET['isl'];
        /* Nazira */
        $naz_marks=$_GET['naz'];
        /* English */
        $eng_marks=$_GET['eng'];
        /* HPE */
        $hpe_marks=$_GET['hpe'];
        /* History and Geopraphy */
        $his_marks=$_GET['his'];
        /* Qirat */
        $qir_marks=$_GET['qir'];
        /* Computer Science */
        $csc_marks=$_GET['csc'];
        /* Mutaliq Quran */
        $mqu_marks=$_GET['mqu'];
        /* Drawing */
        $dra_marks=$_GET['dra'];
        /* Social Study */
        $soc_marks=$_GET['soc'];
        /* Pashto */
        $pas_marks=$_GET['pas'];
        /* Bio */
        $bio_marks=$_GET['bio'];
        /* Chemistry */
        $che_marks=$_GET['che'];
        /* Physics */
        $phy_marks=$_GET['phy'];


        $q="INSERT INTO marks (
  Roll_No,
  English_Marks,
  Urdu_Marks,
  Maths_Marks,
  Science_Marks,
  Arabic_Marks,
  Islamyat_Marks,
  Nazira_Marks,
  Hpe_Marks,
  History_Marks,
  Qirat_Marks,
  Computer_Marks,
  Mutalia_Marks,
  Drawing_Marks,
  Social_Marks,
  Pashto_Marks,
  Biology_Marks,
  Chemistry_Marks,
  Physics_Marks

  ) VALUES
  ('$roll_no',
  '$eng_marks',
  '$urd_marks',
  '$mat_marks',
  '$sci_marks',
  '$ara_marks',
  '$isl_marks',
  '$naz_marks',
  '$hpe_marks',
  '$his_marks',
  '$qir_marks',
  '$csc_marks',
  '$mqu_marks',
  '$dra_marks',
  '$soc_marks',
  '$pas_marks',
  '$bio_marks',
  '$che_marks',
  '$phy_marks'

  )";
        $q="SELECT Roll_No from marks WHERE Roll_No='$roll_no'";
        $check_exe=mysqli_query($link, $q);
        $record=mysqli_num_rows($check_exe);
        if ($record==0) {
            $exe=mysqli_query($link, $q)
            or
            die('error in marks insertion'.mysqli_error($link));
            if ($exe) {
                echo
                "<div class='alert alert-success alert-dismissible'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>
                        &times;</a>
                    <strong>Success!</strong> $roll_no   Marks Added Successfully.
                </div>";
            } else {
                echo 'error in insertion of marks';
            }

        } else {
            echo "<div class='bg-warning'>
            Already Exist.. Not neeed to enter again.
            </div>";
            redirection(2, 'add_all_subjects_marks.php');

        }
       
    }

    /* This section is for add keyboard tab functionality to
    * minimize data entry time.
    */
    /* Tab index block  */
    $query_index="SELECT * FROM tab_index";
    $execute_index=mysqli_query($link, $query_index) or
    die('error in tab index selection'.mysqli_error($link));
    $index_result=mysqli_fetch_assoc($execute_index);
    $eng_index=$index_result['English'];
    $urd_index=$index_result['Urdu'];
    $mat_index=$index_result['Maths'];
    $hpe_index=$index_result['Hpe'];
    $naz_index=$index_result['Nazira'];
    $sci_index=$index_result['Science'];
    $ara_index=$index_result['Arabic'];
    $isl_index=$index_result['Islamyat'];
    $his_index=$index_result['History'];
    $com_index=$index_result['Computer'];
    $mut_index=$index_result['Mutalia'];
    $qir_index=$index_result['Qirat'];
    $dra_index=$index_result['Drawing'];
    $pas_index=$index_result['Pashto'];
    $soc_index=$index_result['Social'];
    $bio_index=$index_result['Biology'];
    $che_index=$index_result['Chemistry'];
    $phy_index=$index_result['Physics'];
    ?>

    <?php Page_header("Add All Subjects Marks"); ?>
</head>
<body>
  <div class="bg-warning text-center">
    <h4>Enter All Subjects Marks</h4>
  </div>
    <?php  include_once 'nav.html';?>
<div class="container">
      <form class="" action="#">
      <div class="row">
        <div class="form-group">
          <small class="p-2 text-primary font-weight-bold">
            Note: Please Enter Roll No, Make sure this Roll No is
            already registered in students page,
            other wise it will not work. For Absent Student add minus one as
            marks  (marks = -1)  </small> <br>
          <label for="rollno">Roll No:</label>
          <span id="aj_result" class="text-danger"></span>
          <input type="number" class="form-control" id="rollno"  min="1"
          name="rollno" tabindex="1" placeholder="type roll no" required
          autofocus required onfocusout="check_roll_no_marks()">
        </div>
</div> <!-- End of top row -->
        <div class="row">
          <!-- English Marks input -->
          <div class="form-group col-md-3">
          <label for="english">English:</label>
          <input type="number" class="form-control" id="english" max="100" min="-1"
                 name="eng" value="0" placeholder="type english marks"
                 tabindex="<?php echo $eng_index ?>"  required />
          </div>
          <!-- Urdu Marks input -->
          <div class="form-group col-md-3">
            <label for="urdu">Urdu:</label>
            <input type="number" class="form-control" id="urdu" max="100" min="-1"
            name="urd" value="0" placeholder="type urdu marks"
            tabindex="<?php echo $urd_index ?>" required>
          </div>
          <!-- Maths Marks input -->
            <div class="form-group col-md-3">
              <label for="maths">Maths:</label>
              <input type="number" class="form-control" id="maths" max="100" min="-1"
              value="0" name="mat"  placeholder="type maths marks"
              tabindex="<?php echo $mat_index ?>" required>
            </div>
            <!-- HPE Marks input -->
            <div class="form-group col-md-3">
              <label for="hpe">HPE:</label>
              <input type="number" class="form-control" id="hpe" max="100" min="-1"
              name="hpe" value="0" placeholder="type hpe marks"
              tabindex="<?php echo $hpe_index ?>" required>
            </div>
</div> <!-- End of row 1 -->
<div class="row">
  <!-- Nazira Marks input -->
            <div class="form-group col-md-3">
              <label for="nazira">Nazira:</label>
              <input type="number" class="form-control" id="nazira"
              max="100" min="-1"
              name="naz" value="0" placeholder="type nazira marks"
              tabindex="<?php echo $naz_index ?>" required>
            </div>
            <!-- Science Marks input -->
            <div class="form-group col-md-3">
              <label for="science">Science:</label>
              <input type="number" class="form-control" id="science"
              max="100" min="-1"
              name="sci" value="0" placeholder="type science marks"
              tabindex="<?php echo $sci_index ?>" required>
            </div>
            <!-- Arabic Marks input -->
            <div class="form-group col-md-3">
              <label for="arabic">Arabic:</label>
              <input type="number" class="form-control" id="arabic"
              max="100" min="-1"
              name="ara" value="0" placeholder="type arabic marks"
              tabindex="<?php echo $ara_index ?>" required>
            </div>
            <!-- Islamyat Marks input -->
            <div class="form-group col-md-3">
              <label for="islamyat">Islamyat:</label>
              <input type="number" class="form-control" id="islamyat" max="100"
              min="-1" name="isl" value="0" placeholder="type islamyat marks"
               tabindex="<?php echo $isl_index ?>" required>
            </div>
</div>  <!-- End of row 2 -->
<div class="row">
      <!-- History And Geography Marks input -->
            <div class="form-group col-md-3">
              <label for="history">History & Geopraphy:</label>
              <input type="number" class="form-control" id="history"
               max="100" min="-1"
               name="his" value="0" placeholder="type history and geography marks"
              tabindex="<?php echo $his_index ?>" required>
            </div>
            <!-- Computer Science Marks input -->
            <div class="form-group col-md-3">
              <label for="cs">Computer Science:</label>
              <input type="number" class="form-control" id="cs" max="100" min="-1"
              name="csc" value="0" placeholder="type computer science marks"
              tabindex="<?php  echo$com_index ?> "required>
            </div>
            <!-- Mutalia Quran Marks input -->
            <div class="form-group col-md-3">
              <label for="mutalia">Mutalia Quran:</label>
              <input type="number" class="form-control" id="mutalia"
              max="100" min="-1"
              name="mqu" value="0" placeholder="type mutalia Quran marks"
              tabindex="<?php echo $mut_index ?>" required>
            </div>
            <!-- Qirat Marks input -->
            <div class="form-group col-md-3">
              <label for="qirat">Qirat:</label>
              <input type="number" class="form-control" id="qirat" max="100" min="-1"
              name="qir" value="0" placeholder="type qirat marks"
              tabindex="<?php echo $qir_index ?>" required>
            </div>
</div> <!-- End of row 3 -->
<div class="row">
            <!-- Drawing Marks input -->
            <div class="form-group col-md-3">
              <label for="drawing">Drawing:</label>
              <input type="number" class="form-control" id="drawing"
              max="100" min="-1"
              name="dra" value="0" placeholder="type drawing marks"
              tabindex="<?php echo $dra_index ?>" required>
            </div>

            <!-- Social Study / Pak Study Marks input -->
          <div class="form-group col-md-3">
            <label for="social">Social Study/Pak Study:</label>
            <input type="number" class="form-control" id="social" max="100" min="-1"
              name="soc" value="0" placeholder="type social/Pak study marks"
              tabindex="<?php echo $soc_index ?>" required>
            </div>
            <!-- Pashto Marks input -->
            <div class="form-group col-md-3">
              <label for="pashto">Pashto:</label>
              <input type="number" class="form-control" id="pashto"
              max="100" min="-1"
              name="pas" value="0" placeholder="type pashto marks"
              tabindex="<?php echo $pas_index ?>" required>
            </div>

            <!-- Biology Marks input -->
            <div class="form-group col-md-3">
              <label for="biology">Biology:</label>
              <input type="number" class="form-control" id="biology"
              max="100" min="-1"
              name="bio" value="0" placeholder="type biology marks"
              tabindex="<?php echo $bio_index ?>" required>
             </div>
</div> <!-- End of Row 4 -->
<div class="row">
  <!-- Chemistry Marks input -->
            <div class="form-group col-md-3">
              <label for="chemistry">Chemistry:</label>
              <input type="number" class="form-control" id="chemistry"
              max="100" min="-1"
              name="che" value="0" placeholder="type chemistry marks"
              tabindex="<?php echo $che_index ?>" required>
            </div>
<!-- Physics Marks input -->
            <div class="form-group col-md-3">
              <label for="physics">Physics:</label>
              <input type="number" class="form-control" id="physics"
                max="100" min="-1"
              name="phy" value="0" placeholder="type physics marks"
              tabindex="<?php echo $phy_index ?>" required>
            </div>

            <div class=" col-md-3"><!-- Currently Empty 3rd div--> </div>

<div class=" col-md-3"> <!-- Currently Empty 4th div--></div>
</div> <!-- End of Row 4-->
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <?php

} else {
    echo "Please login. Then come back. Redirecting...";
    redirection(3, 'login.php');
}

Page_close();
?>
