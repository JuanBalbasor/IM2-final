<?php
include('C:\xampp\htdocs\Library\api\dbcon.php');
header("Content-type: application/json");

$action = isset($_GET['action']) ? $_GET['action'] : exit();
$output = array('error' => false);


if ($action == "getAllBook") {
    try {
        $sql = "call getBook()";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt) {
            $book = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($book, $row);
            }
            $output['error'] = false;
            $output['books'] = $book;
        } else {
            return array();
        }
    } catch (PDOException $err) {
        echo 'Error in getAllBook' . $err->getMessage();
    }
} else if ($action == "saveBook") {

    $name = isset($_POST['Name']) ? $_POST['Name'] : '';
    $qty_stock = isset($_POST['Qty_stock']) ? $_POST['Qty_stock'] : '';
    $rr_date = isset($_POST['r_date']) ? $_POST['r_date'] : '';

    try {
        $sql = "call insertBook('" . $name . "',
                                '" . $qty_stock . "', 
                                '" . $rr_date . "')";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "New BOOK added!" . $name;
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in saveUser' . $err->getMessage();
    }
} else if ($action == "updateBook") {

    $bok_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $name = isset($_POST['Name']) ? $_POST['Name'] : '';
    $qty_stock = isset($_POST['Qty_stock']) ? $_POST['Qty_stock'] : '';
    $rr_date = isset($_POST['r_date']) ? $_POST['r_date'] : '';

    try {
        $sql = "call updateBook('" . $bok_id . "',
                                    '" . $name . "',
                                    '" . $qty_stock . "', 
                                    '" . $rr_date . "')";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt) {
            $output['error'] = false;
            $output['message'] = "Book successfully updated: " . $name;
        } else {
            $output['error'] = true;
        }
    } catch (PDOException $err) {
        echo 'Error in saveUser' . $err->getMessage();
    }
} else if ($action == "saveRequest") {

    $student_id = isset($_POST['Student_id']) ? $_POST['Student_id'] : '';
    $bok_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $requestedby = isset($_POST['RequestedBy']) ? $_POST['RequestedBy'] : '';
    $role = isset($_POST['Role']) ? $_POST['Role'] : '';
    $requestedfor = isset($_POST['RequestedFor']) ? $_POST['RequestedFor'] : '';
    $requeststatus = isset($_POST['Requeststatus']) ? $_POST['Requeststatus'] : '';

    $bok_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $qty_stock = isset($_POST['Qty_stock']) ? $_POST['Qty_stock'] : '';
    $qty_issued = isset($_POST['Qty_issued']) ? $_POST['Qty_issued'] : '';
    $total = isset($_POST['Total']) ? $_POST['Total'] : '';
    $qty_requested = isset($_POST['Qty_requested']) ? $_POST['Qty_requested'] : '';

    try {

        if ($role == 'Admin') {
            $requeststatus = "Approved";
            $sql = "call insertBookRequest('" . $student_id . "',
                                                '" . $bok_id . "',
                                                '" . $requestedby . "',
                                                '" . $requestedfor . "',
                                                '" . $qty_requested . "',
                                                '" . $requeststatus . "',
                                                '" . $requestedby . "')";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if ($stmt) {

                $sql2 = "call getRequestBook('" . $bok_id . "')";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();

                if ($stmt2) {
                    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $newQtyStock = ($row['Qty_stock'] - $qty_requested);
                    $newQtyIssued = ($row['Qty_issued'] + $qty_requested);
                    $stmt2->closeCursor();

                    $sql3 = "call updateBookStock('" . $bok_id . "','" . $newQtyStock . "','" . $newQtyIssued . "')";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                }

                $output['error'] = false;
                $output['message'] = "You've successfully requested for a BOOK.";
            } else {
                $output['error'] = true;
            }
        } else {
            $requeststatus = "Pending For Approval";
            $sql = "call insertBookRequest('" . $student_id . "',
                                                '" . $bok_id . "',
                                                '" . $requestedby . "',
                                                '" . $requestedfor . "',
                                                '" . $qty_requested . "',
                                                '" . $requeststatus . "',
                                                '" . $requestedby . "')";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if ($stmt) {
                $output['error'] = false;
                $output['message'] = "BOOK successfully requested.";
            } else {
                $output['error'] = true;
            }
        }
    } catch (PDOException $err) {
        echo 'Error in saveUser' . $err->getMessage();
    }
} else if ($action == "getAllRequest") {
    try {
        $sql = "SELECT * 
                FROM request mr 
                LEFT JOIN student st USING(Student_id) 
                LEFT JOIN inventory mi USING(book_id)";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt) {
            $reqs = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($reqs, $row);
            }
            $output['error'] = false;
            $output['request'] = $reqs;
        } else {
            return array();
        }
    } catch (PDOException $err) {
        echo 'Error in getAllBook' . $err->getMessage();
    }
} else if ($action == "updateRequestStatus") {

    $request_id = isset($_POST['Request_id']) ? $_POST['Request_id'] : '';
    $bok_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $requestedby = isset($_POST['RequestedBy']) ? $_POST['RequestedBy'] : '';
    $role = isset($_POST['Role']) ? $_POST['Role'] : '';
    $requeststatus = isset($_POST['Requeststatus']) ? $_POST['Requeststatus'] : '';
    $qty_stock = isset($_POST['Qty_stock']) ? $_POST['Qty_stock'] : '';
    $qty_issued = isset($_POST['Qty_issued']) ? $_POST['Qty_issued'] : '';
    $qty_requested = isset($_POST['Qty_requested']) ? $_POST['Qty_requested'] : '';

    try {
        if ($role == 'Admin') {
            $requeststatus = "Approved";
            $sql = "call updateBookRequest('" . $request_id . "','" . $requeststatus . "','" . $requestedby . "')";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if ($stmt) {
                
                $sql2 = "call getRequestBook('" . $bok_id . "')";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();

                if ($stmt2) {
                    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $newQtyStock = ($row['Qty_stock'] - $qty_requested);
                    $newQtyIssued = ($row['Qty_issued'] + $qty_requested);
                    $stmt2->closeCursor();

                    $sql3 = "call updateBookStock('" . $bok_id . "','" . $newQtyStock . "','" . $newQtyIssued . "')";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                }

                $output['error'] = false;
                $output['message'] = "Book Successfully Approved!" . $request_id . "";
            } else {
                $output['error'] = true;
            }
        }
    } catch (PDOException $err) {
        echo 'Error in updateRequestStatus' . $err->getMessage();
    }
}
echo json_encode($output);
