<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IDLC Online Service</title>

    <!-- Bootstrap -->
    <link href="<?php echo app_url('css/bootstrap.min1.css'); ?>" rel="stylesheet">
    <link href="<?php echo app_url('css/font-awesome.min.css'); ?>" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="<?php echo app_url('css/style.css'); ?>" rel="stylesheet">

</head>
<body>
<header class="page-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="logo">
                    <a href="index.php"><img src="<?php echo app_url('img/logo.jpg'); ?>" class="img-responsive" alt=""></a>
                </div>
            </div>
            <div class="col-md-7 col-xs-0 hidden-xs">

            </div>
        </div>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#main-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="http://idlc.com">Main Website</a></li>
                    </ul>
                </div>
            </div>
        </nav>    </div>
</header>

<section class="page-content login-content">
    <div class="row">
        <div class="col-sm-0 col-md-6 hidden-sm hidden-xs">
            <h1 class="action-title">
                <small>Welcome To</small>
                IDLC Online Services
            </h1>
        </div>

        <div class="col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-6">
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <form action="<?php echo app_url('login/postLogin'); ?>" method="POST">
                        <input type="hidden" name="CONTEXT" value="LOGIN_INITIATED">
                        <div class="panel login-panel">
                            <header class="panel-heading">
                                <h3 class="text-center">Login</h3>
                            </header>
                            <section class="panel-body">
                                <div class="form-group">
                                    <label for="cif" class="control-label">User ID (CIF Number)</label>
                                    <input type="text" class="form-control" id="cif" name="cif" placeholder="Please Enter Your CIF">
                                    <?php
                                    $error = get_flash('login_error')
                                    ?>
                                    <?php if (!empty($error)) : ?>
                                        <p class="text-danger" style="margin-top: 8px;">
                                            <?php echo get_flash('login_error'); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </section>
                            <footer class="panel-footer text-center">
                                <button class="btn btn-primary">Submit</button>

                                <p style="margin-top: 20px;">
                                    Don't Have a User ID? Please visit one of your nearest IDLC Branch or Dial 16409 for assistance.
                                </p>
                            </footer>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="page-footer">
    <section class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h4>Our Products</h4>
                            <ul class="list-unstyled">
                                <li><a href="http://idlc.com/consumer.php">Consumer</a></li>
                                <li><a href="http://idlc.com/sme.php">SME</a></li>
                                <li><a href="http://idlc.com/corporate.php">Corporate</a></li>
                            </ul>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h4>About Us</h4>
                            <ul class="list-unstyled">
                                <li><a href="http://idlc.com/our-story.php">OUR STORY</a></li>
                                <li><a href="http://idlc.com/capital-market.php">Our subsidiaries</a></li>
                                <li><a href="http://idlc.com/investor-relations.php">Investor Relations</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <h4>Connect with us</h4>
                    <ul class="list-unstyled social">
                        <li><a href="https://www.facebook.com/IDLC.FinancingHappiness/" target="_blank"><i
                                    class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/idlc-finance-limited" target="_blank"><i
                                    class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.youtube.com/user/idlcfinancelimited" target="_blank"><i
                                    class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        <br>
                        <li style="margin-top:10px;"><a class="feedback font=light"
                                                        style=" font-size: 12px; color: #a7a7a7; " href="feedback.php">Feedback</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
</footer>

    <script src="<?php echo app_url('js/jquery.min1.js'); ?>"></script>
    <script src="<?php echo app_url('js/bootstrap.min1.js'); ?>"></script>
    <script>
      $( document ).ready(function() {
        console.log( "ready!" );
        //alert('ok');
      });
    </script>

</body>
</html>
