<?php

require_once 'core/init.php';
include 'includes/head.php';

if (Session::exists('isLoggedIn') && $_SESSION['isLoggedIn'] === 'true') {
    Redirect::to('index.php');
} else {
}
?>

<div class = "container">
	<div class="wrapper">
		<form action="" method="post" name="register_form" class="form-signin">
		    <h3 class="form-signin-heading">Naujo vartotojo registracija</a></h3>
			<hr class="colorgraph"><br>

            <?php

            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {
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
                        $user = new User();

                        $salt = Hash::salt(32);

                        try {
                            $user->create(array(
                                'username' => Input::get('username'),
                                'password' => Hash::make(Input::get('password'), $salt),
                                'salt' => $salt,
                                'name' => Input::get('name'),
                                'joined' => date('Y-m-d H:i:s'),
                                'user_group' => 1
                            ));

                            Redirect::to('login.php?success=true');
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        foreach ($validation->errors() as $error) {
                            echo '<p class="text-danger">' . escape(translate($error)) . '</p>';
                        }
                    }
                }
            }

            ?>

			<input type="text" class="form-control" name="username" placeholder="Vartotojo vardas" value="<?php echo htmlspecialchars(Input::get('username')); ?>" autofocus=""/>
			<input type="password" class="form-control" name="password" placeholder="Slaptažodis"/>
            <input type="password" class="form-control" name="password_again" placeholder="Pakartokite slaptažodį"/>
            <input type="text" class="form-control" name="name" placeholder="Vardas ir pavardė" value="<?php echo htmlspecialchars(Input::get('name')); ?>" autofocus=""/>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<button class="btn btn-lg btn-primary btn-block"  name="submit" value="Registruotis" type="submit">Registruotis</button>
		</form>
	</div>
</div>
</body>

<?php
include 'includes/footer.php';
