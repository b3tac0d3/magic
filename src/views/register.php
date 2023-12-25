@presto

@layout(layouts.primary)

@section(content)
<div class = "text-center">
    <h2>Register</h2>
</div>
<div class = "d-flex justify-content-center px-3 py-5 my-6">
    <?php Forms::PrintForm("register")?>
</div>
@endsection