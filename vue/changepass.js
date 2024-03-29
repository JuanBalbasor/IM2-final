const { createApp } = Vue

createApp({
    data() {
        return {
            changePassModel: {
                oldPassowrd: "",
                newPassowrd: "",
                confirmPass: ""
            },
            isSuccess: false,
            successMsg: "",
        }
    }, methods: {
        updatePassword(user_id, requestor) {
            console.log('changePassModel', user_id, requestor);

            let password = this.changePassModel;
            if (password.oldPassowrd != "" && (password.newPassowrd == password.confirmPass)) {
                let resetUserForm = this.convertToFormData(password);
                fetch('../api/userHandler.php?action=changeUserPassword',
                    {
                        method: 'POST',
                        body: resetUserForm
                    }
                ).then(response => {
                    return response.text();
                }).then(data => {
                    let newData = JSON.parse(data);
                    if (!newData.error) {
                        this.isSuccess = !newData.error;
                        this.successMsg = newData.message;

                        setTimeout(function () {
                            this.showBtnLoading = false;
                            window.location.href = "student.php";
                        }, 5000)
                    }
                });
            }
        },
        convertToFormData(data) {
            let formData = new FormData();
    
            for (let value in data) {
                formData.append(value, data[value]);
            }
    
            return formData;
        }
    }
    
}).mount('#changePass')