<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div class="container">
    <div class="form-box box">

      <header>Sign Up</header>
      <hr>

      <form action="#" method="POST">

        <div class="form-box">

          <?php
          session_start();
          include "connection.php";

          if (isset($_POST['register'])) {

            $name = $_POST['username'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $cpass = $_POST['cpass'];

            $check = "select * from users where email='".mysqli_real_escape_string($conn, $email)."'";
            $res = mysqli_query($conn, $check);

            $passwd = password_hash($pass, PASSWORD_DEFAULT);
            $key = bin2hex(random_bytes(12));

            if (mysqli_num_rows($res) > 0) {
              echo "<div class='message'>
                      <p>This email is used, Try another One Please!</p>
                    </div><br>";
              // FIX: Added type='button' and onclick event
              echo "<button type='button' class='btn' onclick='javascript:self.history.back()'>Go Back</button>";

            } else {

              if ($pass === $cpass) {

                // Insert with default role = student
                $sql = "INSERT INTO users(username, email, password, role) 
                        VALUES('$name', '$email', '$passwd', 'student')";

                $result = mysqli_query($conn, $sql);

                if ($result) {

                  // Get the new user's ID
                  $new_user_id = mysqli_insert_id($conn);

                  // Unlock Level 1 for the new user
                  mysqli_query($conn, "INSERT INTO quiz_progress (user_id, level_id, status) VALUES ($new_user_id, 1, 'unlocked')");

                  echo "<div class='message'>
                          <p>You are register successfully!</p>
                        </div><br>";

                  // FIX: Added type='button' and onclick to redirect to login.php
                  echo "<button type='button' class='btn' onclick=\"window.location.href='login.php'\">Login Now</button>";

                } else {
                  echo "<div class='message'>
                          <p>Error Occurred!</p>
                        </div><br>";
                  // FIX: Added type='button'
                  echo "<button type='button' class='btn' onclick='javascript:self.history.back()'>Go Back</button>";
                }

              } else {
                echo "<div class='message'>
                        <p>Password does not match.</p>
                      </div><br>";
                // FIX: Added type='button'
                echo "<button type='button' class='btn' onclick=\"window.location.href='signup.php'\">Go Back</button>";
              }
            }
          } else {
          ?>

            <div class="input-container">
              <i class="fa fa-user icon"></i>
              <input class="input-field" type="text" placeholder="Username" name="username" required>
            </div>

            <div class="input-container">
              <i class="fa fa-envelope icon"></i>
              <input class="input-field" type="email" placeholder="Email Address" name="email" required>
            </div>

            <div class="input-container">
              <i class="fa fa-lock icon"></i>
              <input class="input-field password" type="password" placeholder="Password" name="password" required>
              <i class="fa fa-eye icon toggle"></i>
            </div>

            <div class="input-container">
              <i class="fa fa-lock icon"></i>
              <input class="input-field password" type="password" placeholder="Confirm Password" name="cpass" required>
              <i class="fa fa-eye icon toggle"></i>
            </div>

        </div>

        <center><input type="submit" name="register" id="submit" value="Signup" class="btn"></center>

        <div class="links">
          Already have an account? <a href="login.php">Login Now</a>
        </div>

      </form>
    </div>
    <?php
          }
    ?>
  </div>

  <script>
    const toggle = document.querySelector(".toggle"),
      input = document.querySelectorAll(".password"); // Changed to selectAll to handle both password fields if needed
      
    toggle.addEventListener("click", () => {
      // Fix: Loop through both password fields to toggle visibility
      input.forEach(field => {
        if (field.type === "password") {
          field.type = "text";
        } else {
          field.type = "password";
        }
      });
      
      if (toggle.classList.contains("fa-eye")) {
        toggle.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        toggle.classList.replace("fa-eye-slash", "fa-eye");
      }
    })
  </script>
</body>

</html>