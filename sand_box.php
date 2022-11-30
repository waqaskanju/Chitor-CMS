<?php
  /**
   * All the general function of the website resides here.
   * php version 8.1
   *
   * @category Functions
   *
   * @package Functions
   *
   * @author Waqas Ahmad <waqaskanju@gmail.com>
   *
   * @license http://www.abc.com MIT
   *
   * @link Adfas
   **/

$link = include_once 'db_connection.php';
        require_once 'config.php';
/**
 *  For showing the title of the page
 *
 * @param string $page_name of the page
 *
 * @return void
 */
function Page_header($page_name)
{
    echo '<!DOCTYPE html>
					<html lang="en">
						<head>
			    			<title>' .$page_name.  '</title>
								<meta charset="utf-8">
								<meta name="viewport" content="width=device-width, initial-scale=1">
								<link rel="stylesheet" href="css/bootstrap.min.css">
								<link rel="stylesheet" href="css/custom.css">
								<link rel="stylesheet" href="css/style.css">
						  	<script type="text/javascript" src="js/jquery3.6.js">  </script>
						  	<script type="text/javascript" src="js/bootstrap.bundle.js">  </script>
						  	<script type="text/javascript" src="js/bootstrap.bundle.min.js.map">
							</script>
						  	<script type="text/javascript" src="js/custom.js"></script>';
}
/**
 *  For close the html and body tag
 *
 * @return void
 */
function Page_close()
{
    echo'</body>
					</html>';
}

/**
 *  Showing the class Name and combobox
 *
 * @param string $selected_class of the page
 *
 * @return void
 */
function select_class($selected_class)
{
    $selected="selected";
    echo "
<div class='form-group col-md-6'>
	<label for='class_exam'>Select Class Name: </label>
              <select class='form-control' name='class_exam' required>
                <option value=''>Select Class </option>
				<option value='6th'"; if ($selected_class=='6th') {
        echo "selected";
    }  echo ">6th </option>
				<option value='7th'"; if ($selected_class=='7th') {
        echo "selected";
    }  echo ">7th </option>
				<option value='8th'"; if ($selected_class=='8th') {
        echo "selected";
    }  echo ">8th </option>
				<option value='9th A'"; if ($selected_class=='9th A') {
        echo "selected";
    }  echo ">9th A </option>
				<option value='9th B'"; if ($selected_class=='9th B') {
        echo "selected";
    }  echo ">9th B </option>
				<option value='10th A'"; if ($selected_class=='10th A') {
        echo "selected";
    }  echo ">10th A </option>
				<option value='10th B'"; if ($selected_class=='10th B') {
        echo "selected";
    }  echo ">10th B </option>


              </select>
      </div>
";
}

function select_school($selected_school)
{
    $selected="selected";
    echo "
	<div class='form-group col-md-6'>
		<label for='school'>Select School Name: </label>
              <select class='form-control' name='school' required>
                <option value=''>Select School </option>
                <option value='GHSS Chitor'";if ($selected_school=='GHSS Chitor') {
        echo "selected";
    } echo "> GHSS Chitor</option>
                <option value='GMS Marghazar'";if ($selected_school=='GMS Marghazar') {
        echo "selected";
    } echo ">GMS Marghazar</option>
                <option  value='GMS Spal Bandai'"; if ($selected_school=='GMS Spal Bandai') {
        echo "selected";
    } echo ">GMS Spal Bandai</option>
                <option value='GPS Kokrai'"; if ($selected_school=='GPS Kokrai') {
        echo "selected";
    } echo ">GPS Kokrai</option>
                <option value='GPS Chitor'"; if($selected_school=='GPS Chitor') {
        echo "selected";
    } echo ">GPS Chitor</option>
              </select>
            </div>

    ";
}

function calculate_position($link,$class,$school)
{

    $class_name=$class;
    $school_name=$school;

    $q="SELECT Roll_No from students_info
	where Class='$class_name' AND School='$school_name' AND Status=1";
    $qr=mysqli_query($link, $q) or die('Error in Q 1'.mysqli_error($link));
    while ($qra=mysqli_fetch_assoc($qr)){
        $q2="SELECT * FROM marks WHERE Roll_No=".$qra['Roll_No'];
        $qr2=mysqli_query($link, $q2) or die('Error in Q 2'. mysqli_query($link));
        while ($qfa=mysqli_fetch_assoc($qr2)){
            $sum = 0;
          $sum=  $qfa['English_Marks'] + $qfa['Urdu_Marks'] +
                $qfa['Maths_Marks'] + $qfa['Hpe_Marks'] +
                $qfa['Nazira_Marks'] + $qfa['Science_Marks'] +
                $qfa['Arabic_Marks'] + $qfa['Islamyat_Marks'] +
                $qfa['History_Marks'] + $qfa['Computer_Marks'] +
                $qfa['Mutalia_Marks'] + $qfa['Qirat_Marks'] +
                $qfa['Social_Marks'] + $qfa['Pashto_Marks'] +
                $qfa['Drawing_Marks'] + $qfa['Biology_Marks'] +
                $qfa['Chemistry_Marks'] + $qfa['Physics_Marks'];

            $roll_no = $qfa['Roll_No'];
            $q3="INSERT INTO position (Roll_No, Total_Marks )
			VALUES ('$roll_no', '$sum')";

            $qr3 = mysqli_query($link, $q3) or die('Error in Q 3 '.mysqli_error($link));
            echo " Roll No: ". $qfa['Roll_No']  . " Completed <br>";

            $q4="Update students_info set Class_Position='' where Class='$class_name'";
            $qr4=mysqli_query($link, $q4);
            if($qr4){
                echo " successfully emptyfied Class_Position of".$class_name;
            }
            else {
                echo "error in emptying the".$class_name;
            }
        }
    }
    if($qr) {
        return 1;
    }
    else{
        return 0;
    }
}

function add_data_into_position($link)
{
    $count_row="SELECT COUNT(Total_Marks) as total_rows FROM position";
    $cqe=mysqli_query($link, $count_row) or die('Error Count Rows:'.mysqli_error($link));
    $cqa=mysqli_fetch_assoc($cqe);
    $total_entries=$cqa['total_rows'];
    for ($i=0;$i<$total_entries;$i++){
        $q="SELECT Total_Marks,Roll_No FROM position ORDER BY Total_Marks DESC LIMIT $i,1";
        $qr=mysqli_query($link, $q) or die('Error Select Distint total'. mysqli_query($link));
        $qra=mysqli_fetch_assoc($qr);
        $j=$i+1;
        if ($i==0) {
            $q="Update students_info set Class_Position='1st   out of $total_entries' WHERE Roll_No=".$qra['Roll_No'];
            mysqli_query($link, $q) or die('Error in first Position'.mysqli_error($link));
        }
        else if($i==1) {$q="Update students_info set Class_Position='2nd   out of $total_entries' WHERE Roll_No=".$qra['Roll_No'];
            mysqli_query($link, $q) or die('Error in 2nd Position'. mysqli_error($link));
        }
        else if ($i==2) {$q="Update students_info set Class_Position='3rd   out of $total_entries' WHERE Roll_No=".$qra['Roll_No'];
            mysqli_query($link, $q) or die('Error in 3rd Position'. mysqli_error($link));
        }
        else if ($i>2) {$q="Update students_info set Class_Position=' $j th out of $total_entries' WHERE Roll_No=".$qra['Roll_No'];
            mysqli_query($link, $q) or die('Error in nth Position'. mysqli_error($link));
        }
        else {echo "Some thing is wrong";
        }
    }
    if ($cqe) {
        echo "Data is Successfully Added to Positions";
    }
}


function empty_position_table($link)
{
    $q="DELETE from position";
    $qr=mysqli_query($link, $q) or die('Error:in deletion'.mysqli_error($link));
    if ($qr) {
        return 1;
    } else {
        return 0;
    }
}

function date_sheet($class)
{
    echo '
	<table border="1" class="m-b-4">
		<tr> <th colspan="19"> Date Sheet Class '; echo $class; echo'th  GHSS CHITOR </th> </tr>
		<tr> <td> Days </td>       <td colspan="2"> Saturday </td>    <td colspan="2"> Monday </td>       <td colspan="2"> Tuesday </td>   <td colspan="2"> Wednesday </td>   <td colspan="2"> Thursday </td>   <td colspan="2"> Friday </td>     <td colspan="2"> Saturday </td>   <td colspan="2"> Monday </td>    <td colspan="2"> Tuesday</td> </tr>
		<tr> <td> Date </td>       <td colspan="2"> 18-06-2022 </td> <td colspan="2"> 20-06-2022 </td> <td colspan="2"> 21-06-2022 </td>   <td colspan="2"> 22-06-2022 </td> <td colspan="2"> 23-06-2022 </td> <td colspan="2"> 24-06-2022 </td> <td colspan="2"> 25-06-2022 </td> <td colspan="2"> 27-06-2022 </td> <td colspan="2"> 28-06-2022 </td> </tr>
		<tr> <td>Class </td>  <td> 1 </td><td> II </td>  <td> 1 </td><td> II </td> <td> 1 </td><td> II </td> <td> 1 </td><td> II </td> <td> 1 </td><td> II </td> <td> 1 </td><td> II </td> <td> 1 </td><td> II </td> <td> 1 </td><td> II </td> <td> 1 </td><td> II </td>          </tr>';
    if($class==6) {
        echo    '<tr> <td> 6th </td> <td> Urdu </td><td> Arabic </td>  <td> General Science </td><td>----- </td> <td> Maths </td><td> --- </td> <td> Islamyat </td><td> Nazira </td> <td> English </td><td> HPE </td> <td> History / Geography </td><td> ----  </td> <td> Qirat </td><td> ---- </td> <td> Computer Science </td><td> Mutalia Quran </td> <td> Drawing </td><td> ---- </td>      </tr>';
    }
    echo'	</table';
}

$class_name="5";

/**
 * This function check if the subject is available for that class.
 *
 * @param string $class_name    Describe what this parameter is
 * @param string $subject_name  Describe what this parameter is
 * @param array  $subject_array Describe what this parameter is
 *
 * @return a blolean value.
 */
function Select_Class_subject($class_name, $subject_name,$subject_array)
{
    if ($class_name=="6th" or $class_name=="6th A" or $class_name=="6th B") {

        if (in_array($subject_name, $subject_array)) {
            return true;
        } else {
            return false;
        }

    } else if ($class_name=="7th" or $class_name=="7th A" or $class_name=="7th B") {
        if (in_array($subject_name, $subject_array)) {
            return true;
        } else {
            return false;
        }
    } else if ($class_name=="8th" or $class_name=="8th A" or $class_name=="8th B") {
        if (in_array($subject_name, $subject_array)) {
            return true;
        } else {
            return false;
        }

    } else if ($class_name=="9th" or $class_name=="9th A" or $class_name=="9th B") {
        if (in_array($subject_name, $subject_array)) {
            return true;
        } else {
            return false;
        }

    } else if ($class_name=="10th" or $class_name=="10th A"
        or $class_name=="10th B"
    ) {
        if (in_array($subject_name, $subject_array)) {
            return true;
        } else {
            return false;
        }

    } else {
        return "none selected";
    }


}

/**
 * This function Change dob to age.
 *
 * @param string $dob date of birth
 *
 * @return year.
 */
function calculate_age($dob)
{
    $date = new DateTime($dob);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->y;
}

/**
 * This function -1 to absent.
 *
 * @param Integer $marks date of birth
 *
 * @return Makrs of A for absent.
 */
function Show_absent($marks)
{
    if ($marks == -1) {
            $marks ="A";
    }
    return $marks;
}

/**
 * This function absent to zero for total marks calculation.
 *
 * @param Integer $marks_value date of birth
 *
 * @return Makrs of A for absent.
 */
function Change_Absent_tozero($marks_value)
{
    if ($marks_value == -1) {
            $marks_value=0;

    }
    return $marks_value;
}
?>


