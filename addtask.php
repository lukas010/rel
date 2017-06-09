<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navbar.php';


//POST užduoties pateikimas
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, array(
                    'users_radio_list' => array(
                        'required' => true
                    ),
                    'task' => array(
                        'required' => true
                    )
                ));

        if ($validation->passed()) {
            if ($tasks = $task->addTask(Input::get('users_radio_list')[0], Input::get('task'))) {
                Session::flash('msg_add', 'true');
                Redirect::to('index.php');
            }
        } else {
            ?><div class="container"><?php
                    foreach ($validation->errors() as $error) {
                        echo '<p class="text-danger">' . escape(translate($error)) . '</p>';
                    } ?></div><?php

        }
    }
}

if (isset($task)) {
    if ($user->hasPermission('admin')) {
        ?><div class="container" id="add">
            <h2>Pridėti užduotį</h2>
            <p>Pasirinkite kam skiriate užduotį:</p>
            <form method="post">
                <div class="form-group">
                    <?php
                    foreach ($user->getUsersByPermission('user') as $u) {
                        ?>
                        <label class="radio-inline"><input type="radio" name="users_radio_list[]" value="<?= $u->id ?>"><?= $u->name ?></label>
                        <?php

                    } ?>
                </div>
                <div class="form-group">
                    <label for="task">Užduotis: </label>
                    <textarea class="form-control" name="task" id="task" rows="3"></textarea>
                </div>
                <input type="hidden" name="token" value="<?= Token::generate() ?>">
                <button type="submit" class="btn btn-primary">Pateikti užduotį</button>
            </form>
        </div><?php

    }
} else {
    Redirect::to('index.php');
}

include 'includes/footer.php';
