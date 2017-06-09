<?php
require_once 'core/init.php';
Session::put('update_task', 'true');
include_once 'index.php';

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
            if ($tasks = $task->editTask(Input::get('users_radio_list')[0], Input::get('task'), Input::get('tid'))) {
                Session::flash('msg_update', 'true');
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
        if ($_GET['uid'] && $_GET['tid']) {
            ?><div class="container" id="edit">
            <h2>Redaguoti užduotį</h2>
            <p>Pasirinkite kam skiriate užduotį:</p>
            <form method="post">
                <div class="form-group">
                    <?php
                    foreach ($user->getUsersByPermission('user') as $u) {
                        ?><label class="radio-inline"><input type="radio" name="users_radio_list[]" value="<?= $u->id ?>" <?php echo ($u->id === Input::get('uid')) ? 'checked' : ''; ?>><?= $u->name ?></label><?php

                    } ?>
                </div>
                <div class="form-group">
                    <label for="task">Užduotis: </label>
                    <textarea class="form-control" name="task" id="task" rows="3"><?php echo $task->getTask(Input::get('tid')); ?></textarea>
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <button type="submit" class="btn btn-primary">Pateikti užduotį</button>
            </form>
        </div><?php

        } else {
            Redirect::to('index.php');
        }
    } else {
        Redirect::to('index.php');
    }
}
