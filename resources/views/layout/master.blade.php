<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
</head>

<body>

    <header>
        <h1>@yield('title')</h1>
        @include('components.nav')
    </header>
    <hr>

    <div class="content" style="margin-left:1em;">
        @yield('content')
    </div>
    <hr>

    <footer>
        <a class="btn btn-secondary" href="#">聯絡我們</a> | 
        <a class="set_language" data-language="zh-TW">中文</a> | 
        <a class="set_language" data-language="en">English</a> |
    </footer>

</body>
<script>
$(document).ready(function(){
    $(document).on('click', '.set_language', function(event){
        event.stopPropagation();
        event.preventDefault();

        var language = this.dataset.language;

        Cookies.set('language', language);

        location.reload();
    });
});
</script>
</html>