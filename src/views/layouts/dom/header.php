<?php
    // $fw = new nav\nav();
?>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <?php $img = $_SESSION['Root']['App']['Urls']['Img'];?><img style = "height:4em; margin-right: .5em;" src = "<?=$img?>framework/horus_logo.png"/>
        <span><h2 class = "m-0 p-0">Magic</h2></span>
      </a>
    
      <ul class="nav nav-pills">
        <?php
            
            // $public_nav = 
            //     $fw -> build_nav_link("Home", "") .
            //     $fw -> build_nav_link("Documentation", "docs") .
            //     $fw -> build_nav_link("Login", "login") .
            //     $fw -> build_nav_link("Register", "register") .
            //     $fw -> build_nav_link("Todo", "todos");

            // $private_nav = 
            //     $fw -> build_nav_link("Home", "dashboard") .
            //     $fw -> build_nav_link("Documentation", "docs") .
            //     $fw -> build_nav_link("Todo", "todos") .
            //     $fw -> build_nav_link("Logout", "logout", "spadeScript");

            // // $sess = new session\user_session();

            // if($sess -> validate_user_session() === 1)
            //     echo $private_nav;    
            // else
            //     echo $public_nav;
                
        ?>
      </ul>
    </header>
  </div>