<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imgs/book.png">
    <title>Students Information</title>

    <?php include('C:\xampp\htdocs\Library\lib\link.php'); ?>
</head>

<body>
    <div id="student">
        <?php require_once 'router.php'; ?>

        <div class="container mt-5">

            <div v-if="isSuccess" class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                {{ successMsg }}
                <button type="button" class="btn-close" @click="hideAlert" aria-label="Close"></button>
            </div>

            <div class="row mt-3 font-monospace">
                <div class="col-lg-6">
                    <h3 class="fw-bold">Students Information</h3>
                </div>
                <div class="col-lg-6">
                    <button class="btn btn-success add-student float-end fw-bold " data-bs-toggle="modal"
                        data-bs-target="#addStudentModal" @click="clearFields()">Add Student</button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card border-dark border-4 shadow-lg">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">Name</th>
                                    <th scope="col">Birthday</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Contact no.</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Course</th>
                                    <th class="text-end" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr v-for="student in visibileStudents" :key="student.Student_id">
                                    <td>{{ `${student.First_name} ${student.Last_name}` }}</td>
                                    <td>{{ student.Birthday }}</td>
                                    <td>{{ student.Gender }}</td>
                                    <td>09{{ student.Contact_number }}</td>
                                    <td>{{ student.Email }}</td>
                                    <td>{{ student.Course }}</td>
                                    <td class="text-end font-monospace">||
                                        <button class="btn btn-primary me-3" data-bs-toggle="modal"
                                            data-bs-target="#editStudentModal"
                                            @click="getStudentDetails(student)">Edit</button>
                                        <?php if ($role == "Admin") { ?>
                                            <button v-if="student.Active_ind == 1" class="btn btn-secondary"
                                                data-bs-toggle="modal" data-bs-target="#studentStatusModal"
                                                @click="getStudentDetails(student)">Disable</button>
                                            <button v-else class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#studentStatusModal"
                                                @click="getStudentDetails(student)">Enable</button>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr v-if="noData">
                                    <td colspan="8" style="text-align: center; border-collapse: collapse;">No Data
                                        Found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination justify-content-start mt-3">
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
                    </nav>
                </div>
            </div>
        </div>

        <!-- Add Student-->
        <div class="modal fade" id="addStudentModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Student</h5>
                        <button id="closeAdd" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <h2 class="mt-3">Personal Information:</h2>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="First Name"
                                        name="First_name" v-model="studentModel.First_name">
                                    <label for="floatingInput">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Last Name"
                                        name="Last_name" v-model="studentModel.Last_name">
                                    <label for="floatingInput">Last Name</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="floatingInput" placeholder="Birthday"
                                        name="Birthday" v-model="studentModel.Birthday">
                                    <label for="floatingInput">Birthday</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" name="Gender"
                                        v-model="studentModel.Gender">
                                        <option selected value="">Choose gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="floatingSelect">Gender</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="floatingInput"
                                        placeholder="Contact No." name="Contact_number"
                                        v-model="studentModel.Contact_number">
                                    <label for="floatingInput">Contact No. (+63)</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="Email"
                                        name="Email" v-model="studentModel.Email">
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="Course"
                                        name="Course" v-model="studentModel.Course">
                                    <label for="floatingInput">Course</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="submit" @click="saveStudent()">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Student Record Modal -->
        <div class="modal fade" id="editStudentModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"></h5>
                        <button id="closeUpdt" type="button" class="btn-close" data-bs-dismiss="modal"
                            @click="clearFields(); getStudent()"></button>
                    </div>

                    <div class="modal-body">
                        <h5 class="mt-3">Update Student Information</h5>
                        <hr class="2px">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="First Name"
                                        name="First_name" v-model="studentModel.First_name">
                                    <label for="floatingInput">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Last Name"
                                        name="Last_name" v-model="studentModel.Last_name">
                                    <label for="floatingInput">Last Name</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="floatingInput" placeholder="Birthday"
                                        name="Birthday" v-model="studentModel.Birthday">
                                    <label for="floatingInput">Birthday</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" name="Gender"
                                        v-model="studentModel.Gender">
                                        <option selected value="">Choose gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="floatingSelect">Gender</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="floatingInput"
                                        placeholder="Contact No." name="Contact_number"
                                        v-model="studentModel.Contact_number">
                                    <label for="floatingInput">Contact No.</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="Email"
                                        name="Email" v-model="studentModel.Email">
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="Course"
                                        name="Course" v-model="studentModel.Course">
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit"
                            @click="updateStudent()">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="clearFields(); getStudent()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Enable/Disable Modal -->
        <div class="modal fade" id="studentStatusModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 v-if="studentModel.Active_ind == 1" class="modal-title fs-5" id="exampleModalLabel">Disable
                            Student</h1>
                        <h1 v-else class="modal-title fs-5" id="exampleModalLabel">Enable Student</h1>
                        <button id="closeStatus" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 v-if="studentModel.Active_ind == 1" class="text-center">Disable student <b>{{
                                `${studentModel.First_name} ${studentModel.Last_name}` }}</b> ?</h6>
                        <h6 v-else class="text-center">Enable this student?<b>{{ `${studentModel.First_name}
                                ${studentModel.Last_name}` }}</b> ?</h6>
                    </div>
                    <div class="modal-footer">
                        <button v-if="studentModel.Active_ind == 1" type="button" class="btn btn-danger"
                            @click="updateStudentStatus(studentModel.Student_id, studentModel.Active_ind)">Disable</button>
                        <button v-else type="button" class="btn btn-success"
                            @click="updateStudentStatus(studentModel.Student_id, studentModel.Active_ind)">Enable</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Script -->
    <script src="../vue/student.js"></script>
</body>

</html>