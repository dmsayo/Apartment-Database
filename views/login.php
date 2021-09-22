<section class="form-signin-signup">
    <form action="controllers/formHandler.inc.php" method="post">
        <img class="ubc-logo" src="assets/images/ubc-logo.png" alt="Ubc alt image">
        <h1 class="h3 mb-3 fw-normal">Login Details</h1>
        <div class="form-floating">
            <input type="text" name="loginUsername" class="form-control" id="floatingInput" placeholder="Username" required>
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input type="password" name="loginPassword" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>
        <!-- <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div> -->
        <input type="hidden" id="loginSubmit" name="loginSubmit">
        <button class="signin-signup-btn w-100 btn btn-lg btn-primary" type="submit" name="loginSubmit">Sign in</button>
    </form>
    <div>
        <label class="register-lbl">Don't have an account?</label>
        <form action="./views/register.php">
            <button class="register-btn w-100 btn btn-lg btn-secondary" type="submit">Register</button>
        </form>
    </div>
</section>
