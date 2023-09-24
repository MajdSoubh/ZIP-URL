<div class="d-flex justify-content-center align-items-center ">

    <section class="shortener">

        <form method='post' action="<?= url('link') ?>" novalidate>
            <h2 class="text-center mb-5">URL Shortener</h2>
            <?php if (session()->hasFlash('messages')) : ?>
                <div class="alert alert-success w-100" role="alert">
                    <?php foreach (session()->getFlash('messages') as $message) : ?>

                        <div>
                            <?= $message ?>
                        </div>
                    <?php endforeach ?>

                </div>
            <?php endif ?>
            <div class="form-group mb-3">
                <input id="url" type="url" placeholder="Enter a url" name='url' value="<?= old('url') ?>" class=" form-control <?= errors('url') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= errors('url') ? errors('url.0') : '' ?>
                </div>
            </div>

            <div class="form-group mb-3">

                <input name="slug" type="slug" value="<?= old('slug') ?>" placeholder="Enter a slug" id="slug" class=" form-control <?= errors('slug') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= errors('slug') ? errors('slug.0') : '' ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block w-100 mt-3 ">Make it short</button>
        </form>
    </section>
</div>