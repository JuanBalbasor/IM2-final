<?php
include('C:\xampp\htdocs\Library\api\dbcon.php');
header("Content-type: application/json");

$action = isset($_GET['action']) ? $_GET['action'] : exit();
$output = array('error' => false);

if ($action == "getAllStudents") {
    try {
        $sql = "call getStudents()";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt) {
            $students = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($students, $row);
            }
            $output['error'] = false;
            $output['students'] = $students;
        } else {
            return array();
        }
    } catch (PDOException $err) {
        echo 'Error in getAllStudents' . $err->getMessage();
    }
} else if ($action == "insertStudent") {

    $first_name = isset($_POST['First_name']) ? $_POST['First_name'] : '';
    $last_name = isset($_POST['Last_name']) ? $_POST['Last_name'] : '';
    $birthday = isset($_POST['Birthday']) ? $_POST['Birthday'] : '';
    $gender = isset($_POST['Gender']) ? $_POST['Gender'] : '';
    $contact_number = isset($_POST['Contact_number']) ? $_POST['Contact_number'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $course = isset($_POST['Course']) ? $_POST['Course'] : '';
   
    try {
        $sql = "call insertStudent('" . $first_name . "', 
                                    '" . $last_name . "', 
                                    '" . $birthday . "', 
                                    '" . $gender . "', 
                                    '" . $contact_number . "', 
                                    '" . $email . "', 
                                    '" . $course . "')";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully added new student: " . $first_name . " " . $last_name;
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in insertStudent' . $err->getMessage();
    }
} else if ($action == "updateStudent") {

    $student_id = isset($_POST['Student_id']) ? $_POST['Student_id'] : '';
    $first_name = isset($_POST['First_name']) ? $_POST['First_name'] : '';
    $last_name = isset($_POST['Last_name']) ? $_POST['Last_name'] : '';
    $birthday = isset($_POST['Birthday']) ? $_POST['Birthday'] : '';
    $gender = isset($_POST['Gender']) ? $_POST['Gender'] : '';
    $contact_number = isset($_POST['Contact_number']) ? $_POST['Contact_number'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $course = isset($_POST['Course']) ? $_POST['Course'] : '';

    try {
        $sql = "call updateStudent('" . $student_id . "',
                                    '" . $first_name . "', 
                                    '" . $last_name . "', 
                                    '" . $birthday . "', 
                                    '" . $gender . "', 
                                    '" . $contact_number . "', 
                                    '" . $email . "', 
                                    '" . $course . "')";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully updated student";
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in updateStudent' . $err->getMessage();
    }
} else if ($action == "updateStudentStatus") {

    $student_id = isset($_POST['Student_id']) ? $_POST['Student_id'] : '';
    $active_ind = isset($_POST['Active_ind']) ? $_POST['Active_ind'] : '';

    if ($active_ind == 1) {
        $msg = "inactive";
        $active_ind = 0;
    } else {
        $msg = "active";
        $active_ind = 1;
    }

    try {
        $sql = "call updateStudentStatus('" . $student_id . "', '" . $active_ind . "')";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully set to " . $msg . "";
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in updateStudentStatus' . $err->getMessage();
    }
}
echo json_encode($output);
