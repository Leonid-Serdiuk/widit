<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ($this->title) ? $this->title : 'Money Keeper'; ?></title>
    <link rel="stylesheet" type="text/css" href="/src/css/styles.css">
</head>
<body>
//= header.php
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-2 hidden-sm hidden-xs navigation-background">
        </div>
        <div class="col-md-2 hidden-sm hidden-xs navigation-wraper">

                <ul class="nav nav-pills nav-stacked">
                    <li <?php echo (Router::parseUrl()[0] == 'dashboard') ? 'class="active"' : ''; ?>><a href="<?php System::site_url('dashboard'); ?>"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                    <li <?php echo (Router::parseUrl()[0] == 'profit') ? 'class="active"' : ''; ?>><a href="<?php System::site_url('profit'); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Profit</a></li>
                    <li <?php echo (Router::parseUrl()[0] == 'expenses') ? 'class="active"' : ''; ?>><a href="<?php System::site_url('expenses'); ?>"><i class="fa fa-minus" aria-hidden="true"></i> Expenses</a></li>
                    <li <?php echo (Router::parseUrl()[0] == 'archive') ? 'class="active"' : ''; ?>><a href="<?php System::site_url('archive'); ?>"><i class="fa fa-archive" aria-hidden="true"></i> Archive</a></li>
                    <li <?php echo (Router::parseUrl()[0] == 'monthly_payments') ? 'class="active"' : ''; ?>><a href="<?php System::site_url('monthly_payments'); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> Monthly Payments</a></li>
                </ul>
        </div>
        <div class="col-md-10 main-content">
            <?php include $this->show_view; ?>
        </div>
    </div>
</section>
//= footer.php
<script src="/src/js/scripts.js"></script>
</body>
</html>