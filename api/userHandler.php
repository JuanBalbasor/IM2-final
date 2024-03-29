<?php
include('C:\xampp\htdocs\Library\api\dbcon.php');
header("Content-type: application/json");

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$action = isset($_GET['action']) ? $_GET['action'] : exit();
$output = array('error' => false);


if ($action == "getAllUsers") {
    try {
        $sql = "call getUser()";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt) {
            $users = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($users, $row);
            }
            $output['error'] = false;
            $output['users'] = $users;
        } else {
            return array();
        }
    } catch (PDOException $err) {
        echo 'Error in getAllUsers' . $err->getMessage();
    }
} else if ($action == "saveUser") {

    $username = isset($_POST['Username']) ? $_POST['Username'] : '';
    $password = isset($_POST['Password']) ? $_POST['Password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $first_name = isset($_POST['First_name']) ? $_POST['First_name'] : '';
    $last_name = isset($_POST['Last_name']) ? $_POST['Last_name'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $contact_number = isset($_POST['Contact_number']) ? $_POST['Contact_number'] : '';

    try {
        $sql = "call insertUser('" . $username . "',
                                '" . md5($password) . "',
                                '" . $role . "',
                                '" . $first_name . "', 
                                '" . $last_name . "', 
                                '" . $email . "', 
                                '" . $contact_number . "')";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully added new user " . $first_name . " " . $last_name . "";
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in saveUser' . $err->getMessage();
    }
} else if ($action == "updateUser") {

    $user_id = isset($_POST['User_id']) ? $_POST['User_id'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $first_name = isset($_POST['First_name']) ? $_POST['First_name'] : '';
    $last_name = isset($_POST['Last_name']) ? $_POST['Last_name'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $contact_number = isset($_POST['Contact_number']) ? $_POST['Contact_number'] : '';

    try {
        $sql = "call updateUser('" . $user_id . "',
                                '" . $role . "',
                                '" . $first_name . "', 
                                '" . $last_name . "', 
                                '" . $email . "', 
                                '" . $contact_number . "')";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully updated the role of this personnel!";
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in updateUser' . $err->getMessage();
    }
} else if ($action == "updateUserStatus") {

    $user_id = isset($_POST['User_id']) ? $_POST['User_id'] : '';
    $active_ind = isset($_POST['Active_ind']) ? $_POST['Active_ind'] : '';

    if ($active_ind == 1) {
        $msg = "inactive";
        $active_ind = 0;
    } else {
        $msg = "active";
        $active_ind = 1;
    }

    try {
        $sql = "call updateUserStatus('" . $user_id . "', '" . $active_ind . "')";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully set to " . $msg . "";
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in updateUserStatus' . $err->getMessage();
    }
} else if ($action == "resetUserPassword") {

    $user_id = isset($_POST['User_id']) ? $_POST['User_id'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $resetPass = $role == 'admin' ? 'admin1234' : '678902';

    try {
        $sql = "call resetPassword('" . $user_id . "', '" . md5($resetPass) . "')";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully reset the password of " . $_POST['First_name'] . " " . $_POST['Last_name'];
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in updateUserStatus' . $err->getMessage();
    }
} else if ($action == "changeUserPassword") {

    $user_id = isset($_POST['User_id']) ? $_POST['User_id'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $requestor_name = isset($_POST['requestor_name']) ? $_POST['requestor_name'] : '';
    $oldPassword = isset($_POST['oldPassword']) ? $_POST['oldPassword'] : '';
    $newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
    $confirmPass = isset($_POST['confirmPass']) ? $_POST['confirmPass'] : '';

    if ($newPassword == $confirmPass) {
        $newPassword = md5($newPassword);
    } else {
        $output['message'] = "Incorrect Password!";
    }

    try {
        $sql = "call resetPassword('" . $user_id . "', '" . md5($newPassword) . "')";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "You've successfully reset the password of " . $requestor_name . "";
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in updateUserStatus' . $err->getMessage();
    }
}
echo json_encode($output);
