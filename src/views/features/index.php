@presto

@layout(public)

@section(post-head)
  <link type = "text/css" rel = "stylesheet" href = "<?php echo sm::Url('Css')?>/sidebar.css">
@endsection

@section(content)
<div class = "col-md-3">
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
    <span class="fs-4">Sidebar</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="#" class="nav-link active" aria-current="page">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
        Home
      </a>
    </li>
    <li>
      <a href="#" class="nav-link text-white">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
        Dashboard
      </a>
    </li>
    <li>
      <a href="#" class="nav-link text-white">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
        Orders
      </a>
    </li>
    <li>
      <a href="#" class="nav-link text-white">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
        Products
      </a>
    </li>
    <li>
      <a href="#" class="nav-link text-white">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
        Customers
      </a>
    </li>
  </ul>
  <hr>
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
      <strong>mdo</strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
      <li><a class="dropdown-item" href="#">New project...</a></li>
      <li><a class="dropdown-item" href="#">Settings</a></li>
      <li><a class="dropdown-item" href="#">Profile</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="#">Sign out</a></li>
    </ul>
  </div>
</div>
</div>

<div class="container-fluid col-md-9 mt-1">
    
    <div class = "container-fluid col">
        <h3>Features</h3>
        <p class = "lead">This is the section where we'll discuss all features and how to use them.</p>

      <div class="row">
        <h4>Basic Setup</h4>
        <p>There are 3 distinct app modes. We'll dive deeper in to these later on. For now, they are as follows</p>
        <div class="code-block col-md-6 rounded">
            <code class = "language-html markup">
              Alpha | Beta | Live
            </code>
        </div>

        <h4 class = "mt-2">Setting App State</h4>
        <p>These can be set in the main index.php file as follows</p>
        <div class="col-md-6 rounded">
            <img src = "<?=sm::Url("Img")?>screenshots/basic-setup-app-state.png" style = "width: 100%">
        </div>

      </div>
    </div>

</div>
@endsection