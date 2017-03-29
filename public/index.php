<?php

use Phalcon\Logger\Adapter\File as LoggerFile;

ini_set('display_errors', true);
error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

$error = false;

try {
    if (is_file(APP_PATH . '/vendor/autoload.php')) {
        require_once APP_PATH . '/vendor/autoload.php';
    }

    require_once APP_PATH . '/app/config/bootstrap.php';

    $di = new Phalcon\Di\FactoryDefault();
    $app = new Bootstrap($di);
    echo $app->run([]);
} catch (\Exception $e) {
    $error = true;
} catch (\PDOException $e) {
    $error = true;
}

if ($error) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <link rel="icon" href="assets/favicon.ico">
            <title><?php echo $e->getMessage(); ?></title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link href="http://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
            <link href="http://getbootstrap.com/examples/cover/cover.css" rel="stylesheet">
            <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body style="background: url('/assets/img/background-login.jpg') center center">
            <div class="site-wrapper">
                <div class="site-wrapper-inner">
                    <div class="cover-container">
                        <div class="masthead clearfix">
                            <div class="inner">
                                <h3 class="masthead-brand">Intranet - Grupo MPE</h3>
                            </div>
                        </div>
                        <div class="inner cover">
                            <h1 class="cover-heading">Ocorreu um erro inesperado!</h1>
                            <p class="lead">Por favor copie o código abaixo e envie ao <a href="mailto:suporte@grupomep.com.br" class="btn btn-lg btn-link">suporte@grupompe.com.br</a> para solucionar o problema.</p>
                        </div>

                        <div>
                            <?php
                            echo '<pre>';
                            echo get_class($e), ': ', $e->getMessage(), '<br />';
                            echo 'Arquivo: ', $e->getFile(), ' - Linha: ', $e->getLine(), '<br />';
                            echo $e->getTraceAsString(), '<br />';
                            echo '</pre>';
                            ?>
                        </div>
                        <div class="mastfoot">
                            <div class="inner">
                                <p>Intranet - Grupo MPE</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
        </body>
    </html>

    <?php
    $logger = new LoggerFile(APP_PATH . '/logs/' . date('Y-m-d') . '.log');
    $logger->error($e->getMessage());
    Rollbar::report_exception($e);
}



