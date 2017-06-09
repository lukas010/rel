<?php
require_once 'core/init.php';

// POST užduoties įvykdymo pateikimas
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        if ($task->markAsDoneTask(Input::get('user_id')[0], Input::get('task_id')[0])) {
            Session::flash('msg_mark', 'true');
            Redirect::to('index.php');
        }
    }
}

if (isset($task)) {
    if ($user->hasPermission('admin')) {
        ?><div class="container">
            <h1>Priskirtos užduotys</h1>
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Užduotis</th>
                    <th>Priskirta</th>
                    <th>Pridėta</th>
                    <th>Įvykdyta</th>
                    <th>Veiksmai</th>
                </tr><?php
        if ($tasks = $task->getTasks()) {
            $c = 1;
            foreach ($tasks as $t) {
                ?><tr class="<?php echo ($t['done'] != 0) ? escape('success') : '' ?>">
                    <td><?= $c ?></td>
                    <td><?= $t['task'] ?></td>
                    <td><?= $t['user'] ?></td>
                    <td><?= $t['assigned'] ?></td>
                    <td><?php echo ($t['done'] == 0) ? escape('-') : $t['done'] ?></td>
                    <td>
                        <div class="row">
                            <?php
                                if ($t['done'] == 0) {
                                    ?><a href="updatetask.php?uid=<?php echo $t['user_id']; ?>&tid=<?php echo $t['task_id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a><?php

                                } ?>
                            <a href="deletetask.php?tid=<?php echo $t['task_id']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                    </td>
                </tr><?php
                $c++;
            }
        } else {
            echo '<p>Priskirtų užduočių nėra</p>';
        } ?></table>
        </div><?php

    } else {
        ?><div class="container">
            <h1>Jūsų užduotys</h1>
            <?php
        if ($tasks = $task->getTasks($user->data()->id)) {
            $token = Token::generate();
            foreach ($tasks as $t) {
                if ($t['done'] == 0) {
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <p><?= $t['task'] ?></p>
                            </div>
                            <div class="col-md-4">
                                <form method="post">
                                    <input type="hidden" name="task_id[]" value="<?= $t['id'] ?>"/>
                        			<input type="hidden" name="user_id[]" value="<?= $user->data()->id ?>"/>
                                    <input type="hidden" name="token" value="<?php echo escape($token); ?>">
                        			<button class="btn-group btn-group-xs"  name="transfer" type="submit"><span class="glyphicon glyphicon-ok"></span></button>
                                </form>
                            </div>
                        </div>
                        <?php

                }
            }
        } else {
            echo '<p>Jums skirtų užduočių nėra.</p>';
        } ?>
        </div><?php

    }
} else {
    Redirect::to('index.php');
}
