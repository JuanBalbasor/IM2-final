<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imgs/cpc_icon.ico">
    <title>Book Requests</title>

    <?php include('C:\xampp\htdocs\Library\lib\link.php'); ?>
</head>

<body>
    <div id="request">
        <?php require_once 'router.php'; ?>

        <div class="container mt-5">

            <div v-if="isSuccess" class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                {{ successMsg }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="row mt-3 font-monospace">
                <div class="col-lg-6">
                    <h3 class="fw-bold">Book Requests</h3>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card border-dark border-4 shadow-lg">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">Request ID</th>
                                    <th scope="col">Book Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Requested For</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th class="text-end" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr v-for="req in visibileReqs" v-bind:key="req.Request_id">
                                    <td>{{ req.Request_id }}</td>
                                    <td>{{ req.Name }}</td>
                                    <td>{{ req.Qty_requested }}</td>
                                    <td>{{ req.RequestedBy }}</td>
                                    <td>{{ req.RequestedFor }}</td>
                                    <td>{{ req.Requeststatus }}</td>
                                    <td>{{ req.Requestdttm }}</td>
                                    <td class="text-end">
                                        <button v-if="req.Requeststatus == 'Pending For Approval'"
                                            class="btn btn-success me-2" data-bs-toggle="modal"
                                            data-bs-target="#requestApprovalModal"
                                            @click="getRequestDetails(req, 'approve', '<?= $requestor_name ?>', '<?= $role ?>')">Approve</button>
                                        <button v-else class="btn btn-secondary me-2 disabled">Approve</button>

                                        <button v-if="req.Requeststatus == 'Pending For Approval'"
                                            class="btn btn-danger me-2" data-bs-toggle="modal"
                                            data-bs-target="#requestApprovalModal"
                                            @click="getRequestDetails(req, 'decline', '<?= $requestor_name ?>', '<?= $role ?>')">Decline</button>
                                        <button v-else class="btn btn-secondary me-2 disabled">Decline</button>
                                    </td>
                                </tr>
                                <tr v-if="noData">
                                    <td colspan="7" style="text-align: center; border-collapse: collapse;">No Data Found
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

        <!-- Request Approve/Decline Modal -->
        <div class="modal fade" id="requestApprovalModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 v-if="forApproval" class="modal-title fs-5" id="exampleModalLabel">Approve Request</h1>
                        <h1 v-else class="modal-title fs-5" id="exampleModalLabel">Decline Request</h1>
                        <button id="closeApprv" type="button" class="btn-close" data-bs-dismiss="modal"
                            @click="clearFields(); getRequest()"></button>
                    </div>
                    <div class="modal-body">
                        <h6 v-if="forApproval" class="text-center">Approve this request ?</h6>
                        <h6 v-else class="text-center">Decline this request ?</h6>
                    </div>
                    <div class="modal-footer">
                        <button v-if="forApproval" type="button" class="btn btn-success"
                            @click="updateRequest()">Approve</button>
                        <button v-else type="button" class="btn btn-danger" @click="updateRequest()">Decline</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="clearFields(); getRequest()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Script -->
    <script src="../vue/request.js"></script>
</body>

</html>