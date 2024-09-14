<ul class="nav nav-pills">
<?php
    require_once sm::Dir("UserPhp") . "nav.php";
    $Nav = new Navigation\Navigation;

    $PublicNav = 
        $Nav -> BuildNavLink("Home", "").
        $Nav -> BuildNavLink("Documentation", "docs").
        $Nav -> BuildNavLink("Login", "login") .
        $Nav -> BuildNavLink("Register", "register");

    $PrivateNav = 
        $Nav -> BuildNavLink("Home", "dashboard") .
        $Nav -> BuildNavLink("Documentation", "docs") .
        $Nav -> BuildNavLink("Todo", "todos") .
        $Nav -> BuildNavLink("Logout", "Logout", "spadeScript");

    // // $sess = new session\user_session();

    if(isset($_SESSION["UserSession"]["UserId"]))
        echo $PrivateNav;    
    else
        echo $PublicNav;
        
?>
</ul>