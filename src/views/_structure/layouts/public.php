<!DOCTYPE html>
<html lang="en" class="h-100">
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