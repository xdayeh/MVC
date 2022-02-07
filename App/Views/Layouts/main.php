<?php
use AbuDayeh\Core\Application;

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm border-bottom p-0">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URL_XP; ?>">MVC</a>
        <button class="navbar-toggler px-1 py-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                if (Application::isGuest()){
                    echo '<a href="'.URL_XP.'login'.'" class="text-decoration-none btn btn-link btn-sm" role="button">Sing in</a>
                              <a href="#" class="btn btn-outline-success btn-sm" role="button">Sing up</a>';
                }else{
                    echo '<a href="'.URL_XP.'logout'.'" class="text-decoration-none btn btn-link btn-sm" role="button">Logout</a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    {{content}}
</div>