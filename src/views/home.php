@presto

@layout(public)

@section(content)
  <div class = "container-fluid text-center mt-1">
    <h3><b class = "text-decoration-underline">M</b class = "text-decoration-underline">odern <b class = "text-decoration-underline">A</b>pproach to <b class = "text-decoration-underline">G</b>enerate <b class = "text-decoration-underline">I</b>nnovative <b class = "text-decoration-underline">C</b>ode</h3>
  </div>

  <div class = "container-md">
    <p class = "lead">
      Magic is a modern approach to simplifying web development projects and streamlining future releases and updates. Currently in it's alpha phase, 
      it's equipped to handle all MVC build outs with a modern PHP environment. The focus of building this project was on simplicity of use, speed and 
      ability maintain a simple code base with robust functionality. Built in, core dependencies include the following:
    </p>
  </div>

  <div class="container">

    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
          <img src = "<?=sm::Dep("Aces")?>img/icon.png" style = "width: 2em"/>
        </div>
        <h3 class="fs-2 text-body-emphasis">A.C.E.S.</h3>
        <h5 class="card-title fw-bold">Automated Concise Effortless SQL </h5>
        <p class="card-text">Build complex queries with and easy to use and understand PHP library dedicated to MySQL.</p>
        <a href="#" class="icon-link">
          More
        </a>
      </div>
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center fs-2 mb-3">
          <img src = "<?=sm::Dep("Folds")?>img/icon.png" style = "width: 2em"/>
        </div>
        <h3 class="fs-2 text-body-emphasis">F.O.L.D.S.</h3>
        <h5 class="card-title fw-bold">Form Object Library and Designer System</h5>
        <p class="card-text">Build forms easily with PHP that can be edited, updated and re-created in a simple fashion.</p>
        <a href="#" class="icon-link">
          More
        </a>
      </div>
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
          <img src = "<?=sm::Dep("Spades")?>img/icon.png" style = "width: 2em"/>
        </div>
        <h3 class="fs-2 text-body-emphasis">S.P.A.D.E.S.</h3>
        <h5 class="card-title fw-bold">Streamlined PHP AJAX Development Engine Software</h5>
        <p class="card-text">A PHP/Javascript library which provides simple and extremely robust, user-friendly AJAX experience.</p>
        <a href="#" class="icon-link">
          More
        </a>
      </div>
    </div>

  </div>
@endsection