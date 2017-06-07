<?php
require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
} else {
    include_once 'index.php';
    if ($user->hasPermission('admin')) {
        ?>

<div class="container">
    <h2>Pridėti užduotį</h2>
    <p>Pasirinkite kam skiriate užduotį:</p>
    <form method="post">
        <div class="form-group">
            <?php
            foreach ($user->getUsersByPermission('user') as $u) {
                echo '<label class="checkbox-inline"><input type="checkbox"
                    name="users_check_list[] "value="',
                    $u->id, '">', $u->name, '</label>';
            } ?>
        </div>
        <div class="form-group">
            <label for="task">Užduotis: </label>
            <textarea class="form-control" id="task" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php

    } else {
        echo 'Užduotys';
    }
}
