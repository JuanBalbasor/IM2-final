<?php
session_start();
include('C:\xampp\htdocs\Library\api\dbcon.php');

if (!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) {
    header('location: ../index.php');
} else {
    $navbarTitle = 'Library Management';
    $url = $_SERVER['REQUEST_URI'];

    try {
        $sql = "SELECT * FROM user WHERE User_id ='" . $_SESSION['user_id'] . "'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = $row['First_name'];
            $role = $row['role'];
            $user_id = $row['User_id'];
            $requestor_name = $row['First_name'] . " " . $row['Last_name'];
        }
    } catch (PDOException $err) {
        echo "Error: " . $err->getMessage();
    }

    switch ($url) {
        case '/vue/Library/view/student.php':
            $studentPage = true;
            $userPage = false;
            $bookPage = false;
            $inventoryPage = false;
            $requestPage = false;
            $issuedLogsPage = false;
            break;

        case '/vue/Library/view/user.php':
            $studentPage = false;
            $userPage = true;
            $bookPage = false;
            $inventoryPage = false;
            break;

        case '/vue/Library/view/inventory.php':
            $studentPage = false;
            $userPage = false;
            $bookPage = true;
            $inventoryPage = true;
            $requestPage = false;
            $issuedLogsPage = false;
            break;

        case '/vue/Library/view/request.php':
            $studentPage = false;
            $userPage = false;
            $bookPage = true;
            $inventoryPage = false;
            $requestPage = true;
            $issuedLogsPage = false;
            break;

        case '/vue/Library/view/issuedLogs.php':
            $studentPage = false;
            $userPage = false;
            $bookPage = true;
            $inventoryPage = false;
            $requestPage = false;
            $issuedLogsPage = true;
            break;

        default:
            # code...
            break;
    }

}



?>
<nav class="navbar navbar-expand-lg py-3 sticky-top shadow-sm" style="background-color: rgb(24, 54, 94);">
    <div class="container">

        <a class="navbar-brand" href="student.php">
            <img src="../imgs/book.png" width="50" height="50" class="d-inline-block align-middle mr-2">
            <span class="fw-bold text-white fs-4 font-monospace"><?= $navbarTitle ?></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse font-monospace text-end" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-dark text-white me-3 <?= $studentPage ? 'active' : '' ?>"
                        href="student.php">
                        Student
                    </a>
                </li>
                <?php if ($role == "Admin") { ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-dark text-white <?= $userPage ? 'active' : '' ?>"
                            href="user.php">
                            Management
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown me-5">
                    <a class="nav-link btn btn-outline-dark text-white ms-3 <?= $bookPage ? 'active' : '' ?>"
                        href="#" role="button" data-bs-toggle="dropdown">Books</a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item <?= $inventoryPage ? 'active' : '' ?>"
                                href="inventory.php">Inventory
                            </a>
                        </li>
                        <?php if ($role == "Admin") { ?>
                            <li>
                                <a class="dropdown-item <?= $requestPage ? 'active' : '' ?>" href="request.php">Book
                                    Requests
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <div class="dropdown">
                    <button class="btn btn-warning" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item disabled">
                            <?= $role; ?>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="logout.php">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
</nav>