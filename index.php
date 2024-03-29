<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="./imgs/book.png">
  <title>Library Management: Log In</title>

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="./lib/bootstrap@5.3.2/css/bootstrap.min.css">
  <script src="./lib/bootstrap@5.3.2/js/bootstrap.bundle.min.js"></script>

  <!-- Vue.js -->
  <script src="./lib/vue@3.3.9/vue.global.js"></script>

  <style>
    body {
      background-color: #18365e;
    }

    .login-card {
      max-width: 600px;
      margin: auto;
      margin-top: 130px;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border: 5px solid #050d17;
    }

    .form-signin-title {
      text-align: center;
    }

    .center-text {
      text-align: center;
    }

    .form-floating input {
      border: 2px solid;
    }
  </style>

</head>

<body>
  <div id="login" class="login-card p-5">
    <div class="form-signin-title mb-3">
      <img class="mb-3 mt-5" src="./imgs/book.png" width="150" height="150">
      <h2 class="mb-5 font-monospace">Library Management</h2>
    </div>

    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="showErrMsg">
      {{ errMsg }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
        @click="showErrMsg = false; errMsg = ''; loginDetails.username = ''; loginDetails.password = '' "></button>
    </div>

    <div class="font-monospace">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInput" placeholder="Username"
          v-model="loginDetails.username" v-on:keyup="keymonitor">
        <label for="floatingInput">Username</label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
          v-model="loginDetails.password" v-on:keyup="keymonitor">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="center-text mt-5">
        <button v-if="showBtnLoading == false" type="button" class="btn btn-success btn-lg" @click="checkLogin">
          Log In
        </button>
      </div>
    </div>
  </div>

  <!-- Login Script -->
  <script src="vue/index.js"></script>
</body>

</html>