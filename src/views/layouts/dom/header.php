<?php 
    $BaseUrl = $_SESSION["Root"]["App"]["Urls"]["Base"];
    $Img = $_SESSION['Root']['App']['Urls']['Img'];
?>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="<?=$BaseUrl?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <img style = "height:4em; margin-right: .5em;" src = "<?=$Img?>framework/horus_logo.png"/>
        <span><h2 class = "m-0 p-0">Magic</h2></span>
    </a>
    <?php require_once sm::Dir("Views") . "layouts/dom/nav/main_nav.php"?>
    </header>
  </div>