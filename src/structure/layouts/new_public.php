<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Testing</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href = "<?=sm::Url("User")?>/css/user.css" rel = "stylesheet">
</head>
<body>
    
    <?php include_once(sm::Dir("Nav")."main_nav.php")?>

    <div class="container">
        @yield(hi)
    </div>

    

</body>

    <head>
        @yield(top-head)
        <!-- Head -->
        <?php require_once sm::Dir("Dom") . "head.php"?>
        @yield(low-head)
    </head>
    @yield(pre-body)
    <body class="d-flex flex-column h-100">
        <header>
            @yield(top-header)
            <!-- Header -->
            <?php require_once sm::Dir("Dom") . "header.php"?>
            @yield(low-header)
        </header>
        @yield(pre-main)
        <main>
            @yield(content)
        </main>
        @yield(post-main)
        <footer class="footer mt-auto py-3">
                @yield(top-footer)
                <!-- Footer -->
                <?php require_once sm::Dir("Dom") . "footer.php"?>
                @yield(low-footer)
        </footer>
    </body>
    @yield(post-body)
    @yield(pre-foot)
    <!-- Foot (Scripts etc) -->
    <?php require_once sm::Dir("Dom") . "foot.php"?>
    @yield(post-foot)
</html>