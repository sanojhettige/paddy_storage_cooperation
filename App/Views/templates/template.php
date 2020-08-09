<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Paddy Storage Cooperation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

     <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" />
    <link ref="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css" />
    <link ref="stylesheet" href="/assets/css/jquery.toast.min.css" />
    <!-- App style CSS -->
    <link href="/assets/css/style.css" rel="stylesheet" >

    <!-- Page Specific Style -->
    <?php if(isset($assets['css'])) { 
        foreach($assets['css'] as $css) {
            echo "<link rel='stylesheet' href='".$css."' />\r\n\t";
        }
    } ?>

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
                if(isset($success_message) || isset($_SESSION['success_message'])) {
                    $s_message = $success_message ? $success_message : $_SESSION['success_message'];
                    echo '<div class="alert alert-success" role="alert">'.$s_message.'</div>';
                }

                if(isset($error_message) || isset($_SESSION['error_message'])) {
                    $e_message = $error_message ? $error_message : $_SESSION['error_message'];
                    echo '<div class="alert alert-danger" role="alert">'.$e_message.'</div>';
                }
                ?>
                <div class="main-container">
                    <?php include VIEW_DIR.$content.".php"; ?>
                </div>
                
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/jquery.toast.min.js"></script>
    <!-- Page Specific Js -->
    <?php if(isset($assets['js'])) { 
        foreach($assets['js'] as $js) {
            echo "<script src='".$js."' ></script>\r\n\t";
        }
    } ?>

</body>
</html>
