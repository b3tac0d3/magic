@presto

@layout(public)

@section(content)
<div class="container-fluid mt-1">

  <div class = "row">
    
    <?php // include sm::Dir("Views") . "features/sidenav.php" ?>
    <!-- @include(features/sidenav);
    <p>Stuff in between</p>
    @include(features/sidenav2);
    <p>Stuff in between</p>
    @include(features/sidenav3);
    <p>Stuff in between</p> -->

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

</div>
@endsection