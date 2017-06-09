<?php

require_once 'core/init.php';
include 'includes/head.php';

if (Session::exists('isLoggedIn') && $_SESSION['isLoggedIn'] === 'true') {
    Redirect::to('index.php');
}

?>

<div class = "container">
	<div class="wrapper">
		<form action="" method="post" name="login_form" class="form-signin">
		    <h3 class="form-signin-heading">Norint matyti užduotis jums reikia prisijungti arba <a href="register.php">registruotis</a></h3>
            <p>Aministratoriaus prieiga: <mark>admin</mark> <mark>adminas</mark></p>
			<hr class="colorgraph"><br>
<?php

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true
            ),
            'password' => array(
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;

            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                Redirect::to('index.php');
            } else {
                echo '<p>Prisijungti nepavyko</p>';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo '<p class="text-danger">' . escape(translate($error)) . '</p>';
            }
        }
    }
}

if (Input::get('success') === 'true') {
    ?>
    <div class="alert alert-success" role="alert">
        <p>Jūs easate sėkmingai užregistruotas sistemoje. Dabar galite prisijungti</p>
    </div>
    <?php

}

?>
			<input type="text" class="form-control" name="username" placeholder="Vartotojo vardas" autofocus=""/>
			<input type="password" class="form-control" name="password" placeholder="Slaptažodis"/>
            <label><input type="checkbox" name="remember">Prisiminti mane</label>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<button class="btn btn-lg btn-primary btn-block"  name="submit" value="Prisijungti" type="submit">Prisijungti</button>
		</form>
	</div>
</div>

<?php
include 'includes/footer.php';
