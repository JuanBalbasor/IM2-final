<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imgs/book.png">
    <title>Book Inventory</title>

    <?php include('C:\xampp\htdocs\Library\lib\link.php'); ?>
</head>

<body>
    <div id="book">
        <?php require_once 'router.php'; ?>

        <div class="container mt-5">

            <div v-if="isSuccess" class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                {{ successMsg }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="row mt-3 font-monospace">
                <div class="col-lg-6">
                    <h3 class="fw-bold">Book Inventory</h3>
                </div>
                <div class="col-lg-6">
                    <button class="btn btn-success float-end fw-bold" data-bs-toggle="modal"
                        data-bs-target="#addBooksModal" @click="clearFields()">Add Book</button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card border-dark border-4 shadow-lg">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">Book ID</th>
                                    <th scope="col">Name of the Book</th>
                                    <th scope="col">Book in Stock</th>
                                    <th scope="col">Book Issued</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Date</th>
                                    <th class="text-end" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr v-for="book in visibleBooks" v-bind:key="book.books_id">
                                    <td>{{ book.book_id }}</td>
                                    <td>{{ book.Name }}</td>
                                    <td v-if="book.Qty_stock == 0" class="text-danger"><b>{{ book.Qty_stock }}</b></td>
                                    <td v-else>{{ book.Qty_stock }}</td>
                                    <td>{{ book.Qty_issued }}</td>
                                    <td>{{ book.Total }}</td>
                                    <td>{{ book.r_date }}</td>
                                    <td class="text-end font-monospace">||
                                        <button v-if="book.Qty_issued != 0" class="btn btn-primary me-3"
                                            data-bs-toggle="modal" data-bs-target="#editBooksModal"
                                            @click="getBookDetails(book)">Edit</button>
                                        <button v-else class="btn btn-primary me-2 disabled">Edit</button>

                                        <button v-if="book.Qty_stock != 0" class="btn btn-success"
                                            data-bs-toggle="modal" data-bs-target="#reqBooksModal"
                                            @click="getRequestDetails(book, '<?= $requestor_name ?>', '<?= $role ?>')">Request</button>
                                        <button v-else class="btn btn-success disabled">Request</button>
                                    </td>
                                </tr>
                                <tr v-if="noData">
                                    <td colspan="8" style="text-align: center; border-collapse: collapse;">No Data Found
                                    </td>
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

        <!-- Add Book Modal -->
        <div class="modal fade" id="addBooksModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Book</h5>
                        <button id="closeAdd" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="First Name" name="Name"
                                v-model="bookModel.Name">
                            <label for="floatingInput">Book Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="First Name" name="Qty_stock"
                                v-model="bookModel.Qty_stock">
                            <label for="floatingInput">Stock</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" placeholder="First Name" name="r_date"
                                v-model="bookModel.r_date">
                            <label for="floatingInput">Date</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="submit" @click="saveBook()">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Book Modal -->
        <div class="modal fade" id="editBooksModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Book</h5>
                        <button id="closeUpdt" type="button" class="btn-close" data-bs-dismiss="modal"
                            @click="clearFields(); getBook()"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="First Name" name="Name"
                                v-model="bookModel.Name">
                            <label for="floatingInput">Book Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="First Name" name="Qty_stock"
                                v-model="bookModel.Qty_stock">
                            <label for="floatingInput">Book in Stock</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" placeholder="First Name" name="r_date"
                                v-model="bookModel.r_date">
                            <label for="floatingInput">Date</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="submit" @click="updateBook()">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="clearFields(); getbook()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Book Modal -->
        <div class="modal fade" id="reqBooksModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Request Book</h5>
                        <button id="closeReq" type="button" class="btn-close" data-bs-dismiss="modal"
                            @click="clearFields(); getBook()"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Book Name" name="Book_name"
                                v-model="requestModel.Name" disabled>
                            <label for="floatingInput">Book Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="student_id"
                                v-model="requestModel.Student_id">
                                <!-- <option selected value="">Choose student</option> -->
                                <option v-for="stud in students" :value="stud.Student_id" :v-bind:key="stud.Student_id">
                                    {{ `${stud.First_name} ${stud.Last_name}` }}</option>
                            </select>
                            <label for="floatingSelect">Requested For</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="Quantity" name="Qty_issued"
                                v-model="requestModel.Qty_requested">
                            <label for="floatingInput">Quantity</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="submit" @click="requestBook()">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="clearFields(); getBook()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Script -->
    <script src="../vue/inventory.js"></script>
</body>

</html>