<?php
/** @var $model LoginModel */
use AbuDayeh\Core\Template\Form\Form;
use AbuDayeh\Models\LoginModel;
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-6 text-center">
        <img class="my-4" src="<?php echo IMG.'login.png'; ?>" width="100" height="100" alt="">
        <div class="card shadow bg-body rounded mb-5">
            <div class="card-header fw-bold">
                Please sign in
            </div>
            <div class="card-body">
                <?php
                $Form = Form::begin('', "post");
                    echo $Form->field($model, 'Email')->emailField();
                    echo $Form->field($model, 'Password')->passwordField();
                    echo '<button type="submit" class="btn btn-primary">Login</button>';
                Form::end();
                ?>
            </div>
            <div class="card-footer text-muted">
                <a href="#" class="text-decoration-none">Forgot password?</a>
            </div>
        </div>
    </div>
</div>
