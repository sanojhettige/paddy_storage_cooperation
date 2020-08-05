<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Paddy Storage Cooperation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

     <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">

    <!-- Datatables styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/datatables.min.css"/>

    <!-- App style CSS -->
    <link href="/assets/css/style.css" rel="stylesheet" >

</head>
<body>
    <?php include VIEW_DIR."partials/header.php"; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include VIEW_DIR."partials/sidebar.php"; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

                <h1 class="h2 header-title"><?php echo isset($title) ? $title: "Dashboard"; ?></h1>

                <!-- Flush Message Section -->
                <?php
                if(isset($success_message)) {
                    echo '<div class="alert alert-success" role="alert">'.$success_message.'</div>';
                }

                if(isset($error_message)) {
                    echo '<div class="alert alert-danger" role="alert">'.$error_message.'</div>';
                }
                ?>
                <div class="main-container">
                    <?php include VIEW_DIR.$content.".php"; ?>
                </div>
                
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/datatables.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/datatables.js"></script>
</body>
</html>
