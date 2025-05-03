<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $server = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "login"; // Replace with your database name

  // Retrieve form data
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $username = $_POST['username'] ?? '';

  // Database connection
  $conn = new mysqli($server, $dbUsername, $dbPassword, $dbName);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if the user is logging in
  if (!empty($email) && !empty($password) && empty($username)) {
    $sql = "SELECT * FROM `login` WHERE `Email` = '$email' AND `Password` = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Redirect to tourism.html if credentials are valid
      header("Location: tourism.html");
      exit();
    } else {
      echo "<span style='color: red;'>Enter correct username and password.</span>";
    }
  }

  // Check if the user is signing up
  if (!empty($email) && !empty($password) && !empty($username)) {
    $sql = "INSERT INTO `login` (`User Name`, `Email`, `Password`, `Date`) VALUES ('$username', '$email', '$password', current_timestamp())";

    if ($conn->query($sql) === TRUE) {
      echo "<span style='color: green;'>Signup details saved successfully!</span>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  // Close connection
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login / Sign-Up</title>
  <style>
    /* From Uiverse.io by shadyeljokers */
    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #212121;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      position: relative;
      width: 410px;
      height: 410px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      overflow: hidden;
    }

    .container span {
      position: absolute;
      left: 0;
      width: 32px;
      height: 6px;
      background: #2c4766;
      border-radius: 80px;
      transform-origin: 200px;
      transform: rotate(calc(var(--i) * (360deg / 50)));
      animation: blink 3s linear infinite;
      animation-delay: calc(var(--i) * (3s / 50));
    }

    @keyframes blink {
      0% {
        background: #0ef;
      }

      25% {
        background: #2c4766;
      }
    }

    .login-box {
      position: absolute;
      width: 80%;
      max-width: 300px;
      z-index: 1;
      padding: 20px;
      border-radius: 20px;
    }

    form {
      width: 100%;
      padding: 0 10px;
    }

    h2 {
      font-size: 1.8em;
      color: #0ef;
      text-align: center;
      margin-bottom: 10px;
    }

    .input-box {
      position: relative;
      margin: 15px 0;
    }

    input {
      width: 100%;
      height: 45px;
      background: transparent;
      border: 2px solid #2c4766;
      outline: none;
      border-radius: 40px;
      font-size: 1em;
      color: #fff;
      padding: 0 15px;
      transition: 0.5s ease;
    }

    input:focus {
      border-color: #0ef;
    }

    input[value]:not([value=""])~label,
    input:focus~label {
      top: -10px;
      font-size: 0.8em;
      background: #1f293a;
      padding: 0 6px;
      color: #0ef;
    }

    label {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      font-size: 1em;
      pointer-events: none;
      transition: 0.5s ease;
      color: #fff;
    }

    .forgot-pass {
      margin: -10px 0 10px;
      text-align: center;
    }

    .forgot-pass a {
      font-size: 0.85em;
      color: #fff;
      text-decoration: none;
    }

    .btn {
      width: 100%;
      height: 45px;
      background: #0ef;
      border: none;
      outline: none;
      border-radius: 40px;
      cursor: pointer;
      font-size: 1em;
      color: #1f293a;
      font-weight: 600;
    }

    .signup-link {
      margin: 10px 0;
      text-align: center;
    }

    .signup-link a {
      font-size: 1em;
      color: #0ef;
      text-decoration: none;
      font-weight: 600;
    }

    .hidden {
      display: none;
    }

    @media (max-width: 768px) {
      .container {
        width: 100%;
        height: auto;
        border-radius: 0;
        padding: 20px;
      }

      .login-box {
        width: 100%;
        max-width: 100%;
        padding: 15px;
      }

      h2 {
        font-size: 1.5em;
      }

      input {
        height: 40px;
        font-size: 0.9em;
      }

      .btn {
        height: 40px;
        font-size: 0.9em;
      }

      .signup-link a,
      .forgot-pass a {
        font-size: 0.8em;
      }
    }

    @media (max-width: 480px) {
      h2 {
        font-size: 1.2em;
      }

      input {
        height: 35px;
        font-size: 0.8em;
      }

      .btn {
        height: 35px;
        font-size: 0.8em;
      }

      .signup-link a,
      .forgot-pass a {
        font-size: 0.7em;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="login-box" id="login-box">
      <h2>Login</h2>
      <form action="login.php" method="POST">
        <div class="input-box">
          <input type="email" name="email" placeholder="Email" required />
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <div class="forgot-pass">
          <a href="#">Forgot your password?</a>
        </div>
        <button class="btn" type="submit">Login</button>
        <div class="signup-link">
          <a href="#" id="show-signup">Sign Up</a>
        </div>
      </form>
    </div>

    <div class="login-box hidden" id="signup-box">
      <h2>Sign Up</h2>
      <form action="login.php" method="POST">
        <div class="input-box">
          <input type="text" name="username" placeholder="Username" required />
        </div>
        <div class="input-box">
          <input name="email" type="email" placeholder="Email" required />
        </div>
        <div class="input-box">
          <input name="password" type="password" placeholder="Password" required />
        </div>
        <button class="btn" type="submit">Sign Up</button>
        <div class="signup-link">
          <a href="#" id="show-login">Login</a>
        </div>
      </form>
    </div>

    <span style="--i: 0"></span>
    <span style="--i: 1"></span>
    <span style="--i: 2"></span>
    <span style="--i: 3"></span>
    <span style="--i: 4"></span>
    <span style="--i: 5"></span>
    <span style="--i: 6"></span>
    <span style="--i: 7"></span>
    <span style="--i: 8"></span>
    <span style="--i: 9"></span>
    <span style="--i: 10"></span>
    <span style="--i: 11"></span>
    <span style="--i: 12"></span>
    <span style="--i: 13"></span>
    <span style="--i: 14"></span>
    <span style="--i: 15"></span>
    <span style="--i: 16"></span>
    <span style="--i: 17"></span>
    <span style="--i: 18"></span>
    <span style="--i: 19"></span>
    <span style="--i: 20"></span>
    <span style="--i: 21"></span>
    <span style="--i: 22"></span>
    <span style="--i: 23"></span>
    <span style="--i: 24"></span>
    <span style="--i: 25"></span>
    <span style="--i: 26"></span>
    <span style="--i: 27"></span>
    <span style="--i: 28"></span>
    <span style="--i: 29"></span>
    <span style="--i: 30"></span>
    <span style="--i: 31"></span>
    <span style="--i: 32"></span>
    <span style="--i: 33"></span>
    <span style="--i: 34"></span>
    <span style="--i: 35"></span>
    <span style="--i: 36"></span>
    <span style="--i: 37"></span>
    <span style="--i: 38"></span>
    <span style="--i: 39"></span>
    <span style="--i: 40"></span>
    <span style="--i: 41"></span>
    <span style="--i: 42"></span>
    <span style="--i: 43"></span>
    <span style="--i: 44"></span>
    <span style="--i: 45"></span>
    <span style="--i: 46"></span>
    <span style="--i: 47"></span>
    <span style="--i: 48"></span>
    <span style="--i: 49"></span>
  </div>
  <script>
    const loginBox = document.getElementById('login-box');
    const signupBox = document.getElementById('signup-box');
    const showSignup = document.getElementById('show-signup');
    const showLogin = document.getElementById('show-login');

    showSignup.addEventListener('click', (e) => {
      e.preventDefault();
      loginBox.classList.add('hidden');
      signupBox.classList.remove('hidden');
    });

    showLogin.addEventListener('click', (e) => {
      e.preventDefault();
      signupBox.classList.add('hidden');
      loginBox.classList.remove('hidden');
    });
  </script>
</body>

</html>