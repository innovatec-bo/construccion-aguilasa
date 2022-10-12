<?php
/**
 * @var GN_ComplementHandler
 */
 $gnComplementHandler;
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?=$tabTitle?></title>
    <link rel="shortcut icon" href="<?=assets_url("images/favicon.png")?>">
    <link rel="apple-touch-icon" href="<?=assets_url("images/favicon.png")?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=assets_url("images/favicon.png")?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=assets_url("images/favicon.png")?>">
    <?php
    $complementHandler->printViewCss();
    ?>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap Core CSS -->
<!--    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->

    <!-- MetisMenu CSS -->
<!--    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">-->

    <!-- Custom CSS -->
<!--    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->

    <!-- Custom Fonts -->
<!--    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var base_url = '<?=base_url()?>';
    </script>
</head>
