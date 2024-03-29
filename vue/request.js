const { createApp } = Vue

createApp({
    data() {
        return {
            request: [],
            requestModel: {},
            forApproval: false,
            noData: false,
            successMsg: "",
            isSuccess: false,
            currentPage: 1,
            itemsPerPage: 10,
        }
    },
    computed: {
        visibileReqs() {
            const startPage = (this.currentPage - 1) * this.itemsPerPage;
            const endPage = startPage + this.itemsPerPage;
            return this.request.slice(startPage, endPage);
        },
        totalPages() {
            return Math.ceil(this.request.length / this.itemsPerPage)
        },
        visiblePageNumbers() {
            let pageNumbers = [];
            if (this.totalPages <= 7) {
                for (let i = 1; i <= this.totalPages; i++) {
                    pageNumbers.push(i)
                }
            } else {
                if (this.currentPage <= 4) {
                    pageNumbers = [1, 2, 3, 4, 5, "...", this.totalPages];
                } else if (this.currentPage >= this.totalPages - 3) {
                    pageNumbers = [1, "...", this.totalPages - 4, this.totalPages - 3, this.totalPages - 2, this.totalPages - 1, this.totalPages]
                } else {
                    pageNumbers = [1, "...", this.currentPage - 1, this.currentPage, this.currentPage + 1, "...", this.totalPages];
                }
            }
            return pageNumbers;
        }

    },
    methods: {
        getRequest() {
            fetch('../api/BookHandler.php?action=getAllRequest',
                {
                    method: 'GET'
                }
            ).then(response => {
                return response.text();
            }).then(data => {
                let newData = JSON.parse(data);
                if (newData.error) {
                    this.noData = newData.error;
                } else {
                    this.noData = newData.error;
                    this.request = JSON.parse(data).request;
                }
            })
        },
        getRequestDetails(request, action, requestor, role) {
            // this.requestModel = request;
            this.requestModel = {
                Request_id: request.Request_id,
                Student_id: request.Student_id,
                book_id: request.book_id,
                Name: request.Name,
                Qty_stock: request.Qty_stock,
                Qty_issued: request.Qty_issued,
                Qty_requested: request.Qty_requested,
                Total: request.Total,
                Exp_date: request.Exp_date,
                RequestedBy: requestor,
                Role: role,
                RequestedFor: `${request.First_name} ${request.Last_name}`,
                Requeststatus: request.Requeststatus
            }
            
            console.log('requestModel:', this.requestModel);
            if (action == 'approve') {
                this.forApproval = true;
            } else if (action == 'decline') {
                this.forApproval = false;
            }
        },
        updateRequest() {
            let request = this.requestModel;

            let requestApprovalForm = this.convertToFormData(request);
            for (var pair of requestApprovalForm.entries()) {
                console.log(pair[0] + ' = ' + pair[1]);
            }
            fetch('../api/BookHandler.php?action=updateRequestStatus',
                {
                    method: 'POST',
                    body: requestApprovalForm
                }
            ).then(response => {
                return response.text();
            }).then(data => {
                let newData = JSON.parse(data);
                console.log('newData: ', newData)
                if (!newData.error) {
                    document.getElementById('closeApprv').click();
                    this.getRequest();
                    this.isSuccess = !newData.error;
                    this.successMsg = newData.message;
                }
            });
        },
        onPageChange(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        convertToFormData(data) {
            let formData = new FormData();

            for (let value in data) {
                formData.append(value, data[value]);
            }

            return formData;
        },
        clearFields() {
            this.bookModel = {};
        }
    },
    mounted() {
        this.getRequest();
    }
}).mount('#request')