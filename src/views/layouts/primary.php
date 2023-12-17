<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        @yield(pre-head)
        <?php require_once "dom/head.php"?>
        @yield(post-head)
    </head>
    <body class="d-flex flex-column h-100">
        <header>
            @yield(pre-header)
            <?php require_once "dom/header.php"?>
            @yield(post-header)
        </header>
        @yield(pre-body)
        <!-- Begin page content -->
        <main class="flex-shrink-0">
            <div class="container">
                @yield(content)
            </div>
        </main>
        <footer class="footer mt-auto py-3">
            <div class="container">
                @yield(pre-footer)
                <?php require_once "dom/footer.php"?>
                @yield(post-footer)
            </div>
        </footer>
    </body>
    @yield(post-body)
    @yield(pre-foot)
    <?php require_once "dom/foot.php"?>
    @yield(post-foot)
</html>