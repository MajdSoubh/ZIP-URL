<style>
    .table {
        background-color: #111827;
    }
</style>
<div class="d-flex align-items-center flex-column ">

    <?php if (session()->hasFlash('messages')) : ?>
        <div class="alert alert-warning  w-100" role="alert">
            <?php foreach (session()->getFlash('messages') as $message) : ?>

                <div>
                    <?= $message ?>
                </div>
            <?php endforeach ?>

        </div>
    <?php endif ?>
    <?php if (!empty($links)) : ?>
        <table class="table table-responsive table-dark table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">URL</th>
                    <th scope="col">slug</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($links as $link) : ?>
                    <form action="<?= url('link/' . $link['id']) ?>" method="post">
                        <tr>
                            <th scope="row"><?= $link['id'] ?></th>
                            <td><?= $link['url'] ?></td>
                            <td><?= $link['slug'] ?></td>

                            <td><button onclick="return confirm(`Are you sure you want to remove this link`)" type='submit' class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button></td>
                        </tr>
                        <input type="hidden" name='_method' value='DELETE'>
                        <input type="hidden" name='_token' value=<?= csrf() ?>>
                    </form>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <h4>Sorry, no links exist.</h4>
    <?php endif ?>
</div>