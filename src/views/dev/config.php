@presto

@layout(public)

@section(post-head)
<style type = "text/css">
    h2.title{
        color: white;
        background: lightseagreen;
        padding: .5em;
        margin-top: .5em;
    }
    .indent{
        padding-left: 1em;
        margin: 0;
        border-left: 2px dashed gray;
        cursor: pointer;
    }
    .li{
        line-height: 1.5em;
        margin: .25em;
    }
    .li:nth-child(odd){
        background-color: lightblue;
    }
</style>
@endsection

@section(content)
    {{Content}}
@endsection