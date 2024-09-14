<!DOCTYPE html>
<html lang="en" class="h-100">
    
<head>
        @yield(pre-head)
        <!-- Head -->
        <?php require_once sm::Dir("Dom") . "head.php"?>
        @yield(post-head)
    </head>

    <body class="d-flex flex-column h-100">
        
        <header>
            @yield(pre-header)
            <!-- Header -->
            <?php require_once sm::Dir("Dom") . "header.php"?>
            @yield(post-header)
        </header>
        
        @yield(pre-body)
        
        <main>
            <div class="container-fluid">
                @yield(content)
            </div>
        </main>
        
        <footer class="footer mt-auto py-3">
            <div class="container-fluid">
                @yield(pre-footer)
                <!-- Footer -->
                <?php require_once sm::Dir("Dom") . "footer.php"?>
                @yield(post-footer)
            </div>
        </footer>

    </body>

    @yield(post-body)
    @yield(pre-foot)
    
    <!-- Foot (Scripts etc) -->
    <?php require_once sm::Dir("Dom") . "foot.php"?>
    
    @yield(post-foot)
</html>