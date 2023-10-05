<div class="d-flex vh-100 align-items-center justify-content-center">
    <form class="auth-form" novalidate method='post'>
        <h2 class="text-center  mb-3">Sign up</h2>
        <div class="form-group mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" name='name' value="<?= old('name') ?>" class=" form-control <?= errors('name') ? 'is-invalid' : '' ?>" id="name">
            <div class="invalid-feedback">
                <?= errors('name') ? errors('name.0') : '' ?>
            </div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="email">Email address</label>
            <input id="email" type="email" name='email' value="<?= old('email') ?>" class=" form-control <?= errors('email') ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback">
                <?= errors('email') ? errors('email.0') : '' ?>
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="password">Password</label>
            <input name="password" type="password" id="password" class=" form-control <?= errors('password') ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback">
                <?= errors('password') ? errors('password.0') : '' ?>
            </div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="confirmPassword">Confirm Password</label>
            <input name="password_confirmation" type="password" class=" form-control <?= errors('password_confirmation') ? 'is-invalid' : '' ?>" id="confirmPassword">
            <div class="invalid-feedback">
                <?= errors('password_confirmation') ? errors('password_confirmation.0') : '' ?>
            </div>
        </div>
        <input type="hidden" name='_token' value=<?= csrf() ?>>
        <button type="submit" class="btn btn-primary btn-block w-100 mt-3  ">Sign Up</button>
        <p class="text-center mt-2">Already have an account? <a href="<?= url('login') ?>">Log In</a></p>
    </form>
</div>