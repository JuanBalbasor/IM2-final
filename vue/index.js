const { createApp } = Vue

createApp({
    data() {
        return {
            loginDetails: {
                username: '',
                password: ''
            },
            showErrMsg: false,
            errMsg: "",
            showBtnLoading: false
        }
    },
    methods: {
        keymonitor(event) {
            if (event.key == "Enter") {
                this.checkLogin();
            }
        },
        checkLogin() {

            let loginForm = this.convertToFormData(this.loginDetails);

            fetch('./api/loginHandler.php',
                {
                    method: 'POST',
                    body: loginForm
                }
            ).then(response => {
                return response.text();
            }).then(data => {
                if (JSON.parse(data).error) {
                    this.showErrMsg = JSON.parse(data).error;
                    this.errMsg = JSON.parse(data).message;
                } else {

                    console.log('Logging in...');

                    setTimeout(function () {
                        this.showBtnLoading = false;
                        window.location.href = "view/student.php";
                    }, 2000)
                }
            });
        },
        convertToFormData(data) {
            let formData = new FormData();

            for (let value in data) {
                formData.append(value, data[value]);
            }

            return formData;
        },
    },
}).mount('#login')
