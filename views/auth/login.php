<div class="d-flex vh-100 align-items-center justify-content-center">

    <div class="auth-form">

        <form class="signup-form " novalidate method='post'>
            <h2 class="text-center mb-3">Sign in</h2>

            <?php if (session()->hasFlash('messages')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach (session()->getFlash('messages') as $message) : ?>

                        <div>
                            <?= $message ?>
                        </div>
                    <?php endforeach ?>

                </div>
            <?php endif ?>
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
            <input type="hidden" name='_token' value=<?= csrf() ?>>

            <button type="submit" class="btn btn-primary btn-block w-100 mt-3 ">Login</button>
            <p class="text-center mt-2">Not a member ? <a href="<?= url('signup') ?>">Signup</a></p>
        </form>
    </div>

</div>