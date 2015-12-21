




<div class="header clearfix">
    <nav>
        <ul class="nav nav-pills pull-right">
            
            <?php 
                if($view == 'dashboard') {
                    echo '<!-- Dashboard menu -->';
                    echo '<li role="presentation">' . anchor('user', 'Edit Users') . '</li>';
                } elseif($view == 'users') {
                    echo '<!-- Users menu -->';
                    echo '<li role="presentation">' . anchor('dashboard', 'Dashboard') . '</li>';
                    echo '<li role="presentation">' . anchor('user/add', 'Add new user') . '</li>';
                }
                echo '<li role="presentation"><i class="fa fa-sign-out fa-fw"></i>' . anchor('login/logout', 'Logout') . '</li>'; ?>
        </ul>
    </nav>
    <h3 class="text-muted">Adapte-me!</h3>
</div>


<div class="jumbotron">
    <h1><?php echo $page_title; ?></h1>

