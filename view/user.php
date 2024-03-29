<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imgs/book.png">
    <title>Administrators</title>

    <?php include('C:\xampp\htdocs\Library\lib\link.php'); ?>
</head>

<body>
    <div id="user">
        <?php require_once 'router.php'; ?>

        <div class="container mt-5">

            <div v-if="isSuccess" class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                {{ successMsg }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="row mt-3 font-monospace">
                <div class="col-lg-6">
                    <h3 class="fw-bold">Administrators Information</h3>
                </div>
                <div class="col-lg-6">
                    <button class="btn btn-success float-end fw-bold" data-bs-toggle="modal"
                        data-bs-target="#addUserModal" @click="clearFields()">Add Administrator</button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card border-dark border-4 shadow-lg">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-primary">

                                    <th scope="col">User Role</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact No.</th>
                                    <th class="text-end" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr v-for="user in visibileUsers" v-bind:key="user.User_id">
                                    <td>{{ user.role }}</td>
                                    <td>{{ `${user.First_name} ${user.Last_name}` }}</td>
                                    <td>{{ user.Email }}</td>
                                    <td>09{{ user.Contact_number }}</td>
                                    <td class="text-end font-monospace">||
                                        <button class="btn btn-primary me-3" data-bs-toggle="modal"
                                            data-bs-target="#editUserModal"
                                            @click="updateUserDetails(user)">Edit</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#userResetModal"
                                            @click="updateUserDetails(user)">Reset</button>
                                        <button v-if="user.Active_ind == 1" class="btn btn-secondary ms-3"
                                            data-bs-toggle="modal" data-bs-target="#userStatusModal"
                                            @click="updateUserDetails(user)">Disable</button>
                                        <button v-else class="btn btn-success ms-3" data-bs-toggle="modal"
                                            data-bs-target="#userStatusModal"
                                            @click="updateUserDetails(user)">Enable</button>
                                    </td>
                                </tr>
                                <tr v-if="noData">
                                    <td colspan="7" style="text-align: center; border-collapse: collapse;">No Data Found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- <nav>
                        <ul class="pagination justify-content-start mt-4">
                            <li class="page-item">
                                <a class="page-link" href="#" @click="onPageChange(currentPage = 1)"
                                    :class="{ disabled: totalPages === 1 || currentPage === 1 }">First</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" @click="onPageChange(currentPage - 1)"
                                    :class="{ disabled: totalPages === 1 || currentPage === 1 }">Prev</a>
                            </li>
                            <li class="page-item" v-for="pageNumber in visiblePageNumbers" :key="pageNumber"
                                :class="{ active: currentPage == pageNumber }">
                                <a class="page-link" href="#" @click="onPageChange(pageNumber)">{{ pageNumber }}</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" @click="onPageChange(currentPage + 1)"
                                    :class="{ disabled: totalPages === 1 || currentPage === totalPages }">Next</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" @click="onPageChange(currentPage = totalPages)"
                                    :class="{ disabled: totalPages === 1 || currentPage === totalPages }">Last</a>
                            </li>
                        </ul>
                    </nav> -->
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Personnel</h5>
                        <button id="closeAdd" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Username" name="Username"
                                        v-model="userModel.Username">
                                    <label for="floatingInput">Username</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" placeholder="Password" name="Password"
                                        v-model="userModel.Password">
                                    <label for="floatingInput">Password</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="role" v-model="userModel.role">
                                <option selected value="">Choose role</option>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                            <label for="floatingSelect">Role</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="First Name" name="First_name"
                                v-model="userModel.First_name">
                            <label for="floatingInput">First Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Last Name" name="Last_name"
                                v-model="userModel.Last_name">
                            <label for="floatingInput">Last Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="Email"
                                v-model="userModel.Email">
                            <label for="floatingInput">Email</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="Contact Number" name="Contact_number"
                                v-model="userModel.Contact_number">
                            <label for="floatingInput">Contact No. </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="submit" @click="saveUser">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Personnel Information</h5>
                        <button id="closeUpdt" type="button" class="btn-close" data-bs-dismiss="modal"
                            @click="clearFields(); getUser()"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="role" v-model="userModel.role">
                                <!-- <option selected value="">Choose role</option> -->
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                            <label for="floatingSelect">Role</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="First Name" name="First_name"
                                v-model="userModel.First_name">
                            <label for="floatingInput">First Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Last Name" name="Last_name"
                                v-model="userModel.Last_name">
                            <label for="floatingInput">Last Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="Email"
                                v-model="userModel.Email">
                            <label for="floatingInput">Email</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="Contact Number" name="Contact_number"
                                v-model="userModel.Contact_number">
                            <label for="floatingInput">Contact No.</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="submit" @click="updateUser()">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="clearFields(); getUser()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Enable/Disable Modal -->
        <div class="modal fade" id="userStatusModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 v-if="userModel.Active_ind == 1" class="modal-title fs-5" id="exampleModalLabel">Disable
                            Student</h1>
                        <h1 v-else class="modal-title fs-5" id="exampleModalLabel">Enable Student</h1>
                        <button id="closeStatus" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 v-if="userModel.Active_ind == 1" class="text-center">Disable <b>{{
                                `${userModel.First_name} ${userModel.Last_name}` }}</b> as your personnel?</h6>
                        <h6 v-else class="text-center">Enable <b>{{ `${userModel.First_name}
                                ${userModel.Last_name}` }}</b> ?</h6>
                    </div>
                    <div class="modal-footer">
                        <button v-if="userModel.Active_ind == 1" type="button" class="btn btn-danger"
                            @click="updateUserStatus(userModel.User_id, userModel.Active_ind)">Disable</button>
                        <button v-else type="button" class="btn btn-success"
                            @click="updateUserStatus(userModel.User_id, userModel.Active_ind)">Enable</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reset Password Modal -->
        <div class="modal fade" id="userResetModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
                        <button id="closeReset" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center">Are you sure you want to reset the password of <br><b>"{{
                                `${userModel.First_name} ${userModel.Last_name}` }}"</b> ?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="resetPassword()">Reset</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Script -->
    <script src="../vue/user.js"></script>
</body>

</html>