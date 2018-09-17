<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('X-Powered-By: Prod-domProjects.com');
header('X-XSS-Protection: 1');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Vary: Accept-Encoding');

?>
<!doctype html>
<html lang="<?php echo $lang; ?>">

<head prefix="og: http://ogp.me/ns#">
    <meta charset="<?php echo $charset; ?>">
    <title>KANK Store</title>
    <meta name="description" content="">
    <?php if ($mobile === FALSE): ?>
    <!--[if IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <?php else: ?>
    <meta name="HandheldFriendly" content="true">
    <?php endif; ?>
    <?php if ($mobile == TRUE && $mobile_ie == TRUE): ?>
    <meta http-equiv="cleartype" content="on">
    <?php endif; ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta property="og:title" content="HOME">
    <meta property="og:type" content="article">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="domProjects">
    <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
</head>

<body>


    <!-- InstaWidget -->

    <div class="container">
        <div class="row">
            <div class="logo"><b>K<span>A</span>N<span>K</span></b></div>
        </div>
        <div class="row insta">
            <a href="https://instawidget.net/v/user/kank_store" id="link-f75340e451702af303a9ba6f32d4e60af1bdb9807ccf7e39585a4893238d10ee">@kank_store</a>
            <script src="https://instawidget.net/js/instawidget.js?u=f75340e451702af303a9ba6f32d4e60af1bdb9807ccf7e39585a4893238d10ee&width=300px"></script>
        </div>
    </div>



    <footer>
        <?php if ($admin_link): ?>
        <p><a href="<?php echo site_url('admin'); ?>">Admin</a></p>
        <?php endif; ?>

        <?php if ($logout_link): ?>
        <p><a href="<?php echo site_url('auth/logout/public'); ?>">Logout</a></p>
        <?php else: ?>
        <p><a href="<?php echo site_url('auth/login'); ?>">Login</a></p>
        <?php endif; ?>

    </footer>
</body>

</html>