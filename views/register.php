<?php include('../views/templates/header.php'); ?>

<section class="form-signin-signup">
    <form action="../controllers/formHandler.inc.php" method="post">
        <img class="ubc-logo" src="../assets/images/ubc-logo.png" alt="Ubc alt image">
        <h1 class="h3 mb-3 fw-normal">Registration Details</h1>
        <div class="form-floating">
            <input type="text" name="name" placeholder="Full Name" class="form-control" id="floatingName" required>
            <label for="floatingName">Full Name</label>
        </div>
        <div class="form-floating">
            <input type="text" name="username" placeholder="Username" class="form-control" id="floatingUsername" required>
            <label for="floatingUsername">Username</label>
        </div>
        <div class="form-floating">
            <input type="text" name="email" placeholder="Email" class="form-control" id="floatingEmail" required>
            <label for="floatingEmail">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" placeholder="Password" class="form-control" id="floatingPassword" required>
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
            <input type="password" name="passwordrpt" placeholder="Repeat Password" class="form-control" id="floatingPasswordrpt" required>
            <label for="floatingPasswordrpt">Repeat Password</label>
        </div>
        <input type="hidden" id="registerSubmit" name="registerSubmit">
        <button class="signin-signup-btn w-100 btn btn-lg btn-success" type="submit" name="registerSubmit">Register</button>
    </form>
    <div>
        <label class="register-lbl">Already have an account?</label>
        <form action="../">
            <button class="register-btn w-100 btn btn-lg btn-secondary" type="submit">Sign in</button>
        </form>
    </div>
</section>

<link href="../css/loginRegister.css" rel="stylesheet">
<?php include('../views/templates/footer.php'); ?>
