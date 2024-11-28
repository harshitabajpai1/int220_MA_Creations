<?php
session_start();
$noNavbar = '';
$pageTitle = 'Login';
include './init.php';

// Redirect to the dashboard if the user is already logged in
if (isset($_SESSION['username'])) {
  header('location: dashboard.php');
  exit();
} else {
  $do = isset($_GET['do']) ? $_GET['do'] : 'view';

  if ($do == 'view') {
    // Check if "Remember Me" cookie exists and pre-fill the form
    if (isset($_COOKIE['login_credentials'])) {
      list($username, $password) = explode('|', $_COOKIE['login_credentials']);
      $username = htmlentities($username, ENT_QUOTES);
      $password = htmlentities($password, ENT_QUOTES);
      $rememberMeChecked = 'checked';
    } else {
      $username = '';
      $password = '';
      $rememberMeChecked = '';
    }

    // Display login form
    ?>
    <div class="login py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto">
            <form action="index.php?do=enter-true" method="POST" autocomplete="off">
              <h1>Login - MA Creations</h1>
              <?php
              if (isset($_SESSION['message'])) : ?>
                <div id="message">
                  <?php echo $_SESSION['message']; ?>
                </div>
              <?php unset($_SESSION['message']);
              endif;
              ?>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" required="required" value="<?php echo $username; ?>">
                <label for="floatingInput">Username</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required="required" value="<?php echo $password; ?>">
                <label for="floatingPassword">Password</label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe" <?php echo $rememberMeChecked; ?>>
                <label class="form-check-label" for="rememberMe">Remember Me</label>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" name="enter">Enter</button>
              </div>
              <div class="text-center mt-3">
                <a href="index.php?do=register">Don't have an account? Register here</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
  } elseif ($do == 'enter-true') {
    if (isset($_POST['enter'])) {
      $username = trim($_POST['username']); // Trim spaces
      $password = $_POST['password'];

      // Sanitize user inputs
      $username = filter_var($username, FILTER_SANITIZE_STRING);
      $password = filter_var($password, FILTER_SANITIZE_STRING);

      // Prepare the SQL query to check for the username
      $stmt = $con->prepare("SELECT `id`, `username`, `password` FROM `admin` WHERE `username` = ?");
      $stmt->execute(array($username));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();

      // Check if the user exists
      if ($count > 0) {
        // Verify the password using password_verify()
        if (password_verify($password, $row['password'])) {
          $_SESSION['username'] = $username; // Register Session Name
          $_SESSION['id'] = $row['id']; // Register Session ID

          // Handle "Remember Me"
          if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
            $token = bin2hex(random_bytes(16)); // Generate a secure random token
            setcookie('login_token', $token, time() + (86400 * 30), '/'); // Set a cookie for 30 days

            // Store the token securely in the database
            $stmt = $con->prepare("UPDATE `admin` SET `remember_token` = ? WHERE `id` = ?");
            $stmt->execute(array($token, $row['id']));
          }

          // Redirect to dashboard
          header('location: dashboard.php');
          exit();
        } else {
          show_message('Incorrect password. Please try again.', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
      } else {
        show_message('No user found with that username.', 'danger');
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit();
      }
    } else {
      header('location: index.php');
      exit();
    }
  } elseif ($do == 'register') {
    // Registration Form
    ?>
    <div class="login py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto">
            <form action="index.php?do=register-true" method="POST" autocomplete="off">
              <h1>Register - MA Creations</h1>
              <?php
              if (isset($_SESSION['message'])) : ?>
                <div id="message">
                  <?php echo $_SESSION['message']; ?>
                </div>
              <?php unset($_SESSION['message']);
              endif;
              ?>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingUsername" placeholder="Username" name="username" required="required">
                <label for="floatingUsername">Username</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required="required">
                <label for="floatingPassword">Password</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password" name="confirm_password" required="required">
                <label for="floatingConfirmPassword">Confirm Password</label>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" name="register">Register</button>
              </div>
              <div class="text-center mt-3">
                <a href="index.php">Already have an account? Login here</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
  } elseif ($do == 'register-true') {
    // Handle the registration logic
    if (isset($_POST['register'])) {
      $username = trim($_POST['username']);
      $password = $_POST['password'];
      $confirmPassword = $_POST['confirm_password'];

      // Sanitize inputs
      $username = filter_var($username, FILTER_SANITIZE_STRING);
      $password = filter_var($password, FILTER_SANITIZE_STRING);
      $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING);

      // Check if passwords match
      if ($password !== $confirmPassword) {
        show_message('Passwords do not match.', 'danger');
        header('location: index.php?do=register');
        exit();
      }

      // Check if username already exists
      $stmt = $con->prepare("SELECT `id` FROM `admin` WHERE `username` = ?");
      $stmt->execute(array($username));
      $count = $stmt->rowCount();
      
      if ($count > 0) {
        show_message('Username is already taken.', 'danger');
        header('location: index.php?do=register');
        exit();
      }

      // Hash the password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Insert the new user into the database
      $stmt = $con->prepare("INSERT INTO `admin` (`username`, `password`) VALUES (?, ?)");
      $stmt->execute(array($username, $hashedPassword));

      show_message('Registration successful. You can now log in.', 'success');
      header('location: index.php');
      exit();
    }
  }
}
include $tpl . 'footer.php';
?>
