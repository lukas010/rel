<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Sveiki, <?php echo escape($user->data()->username); ?></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($user->hasPermission('admin')) {
                    ?><li><a href="addtask.php">Pridėti užduotį</a></li><?php

                }
                ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <!-- <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li> -->
                    <li><a href="logout.php">Atsijungti</a></li>
                  </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
    </nav>
</div>
