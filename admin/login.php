<?php 
include('header.php');
include('../server/connection.php');

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header('location: index.php');
    exit;
}

// Check for form submission
if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins";
    $result = mysqli_query($conn, $sql);

    // Initialize a flag for successful login
    $login_success = false;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($password == $row['admin_password'] && $email == $row['admin_email']) {
                // Successful login
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_email'] = $row['admin_email'];
                $_SESSION['admin_name'] = $row['admin_name'];
                header('location: index.php');
                exit;
            }
        }
    }

    // If login fails, set error flag
    $error = "Invalid email or password.";
}
?>


<section class="my-3 py-3">
    <div class="container text-center mt-3 pt-0">
        <h2 class="form-weight-bold">Login</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto">
        <form id="login-form" method="POST" action="login.php">
            <!-- Display error message -->
            <?php if (isset($error)): ?>
                <p id="error" style="color: red;" class="text-center"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" id="login-email" placeholder="Email" required />
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" id="login-password" placeholder="Password" required />
            </div>

            <div class="form-group">
                <input type="submit" class="btn" name="login_btn" id="login-btn" value="Login" />
            </div>
        </form>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

