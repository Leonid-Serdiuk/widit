<?php if(!empty(System::alert_message(false))): ?>
    <div class="alert alert-<?php System::alert_type(); ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php System::alert_message(); ?>
    </div>
<?php endif; ?>