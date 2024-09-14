<nav class="navbar navbar-expand-lg bg-body-secondary p-0">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="/magic">
        <span><img src = "<?=sm::Url("Img")?>framework/horus_green.png" style = "width: 3em;"></span>
        <!-- Magic -->
      </a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php 
          $Nav = new GlobalBuild();
          echo 
            $Nav -> BuildNavLink("Home", "/magic/home", ["home", ""]),
            $Nav -> BuildNavLink("Features", "/magic/features", "features"),
            $Nav -> BuildNavLink("About", "/magic/about", "about");
        ?>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class='nav-item'>
          <a href='#' class='nav-link'>
            <i class="bi bi-person h3"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>