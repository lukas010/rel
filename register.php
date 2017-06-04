<?php

require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        echo "jau buvo";

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 32,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 64
            )
        ));

        if ($validation->passed()) {
            echo "Patvirtinta";
        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="username">Vartotojo vardas</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars(Input::get('username')); ?>" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Slaptažodis</label>
        <input type="password" name="password" id="password" value="">
    </div>

    <div class="field">
        <label for="password_again">Pakartokite slaptažodį</label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Vardas ir pavardė</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars(Input::get('name')); ?>" id="name">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Registruotis">
</form>
