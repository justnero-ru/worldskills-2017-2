<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>ITTECH Surveys</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/semantic.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ittech.css') }}"/>
</head>
<body>
<div class="ui borderless main menu">
    <div class="ui container">
        <div href="#" class="header item"><img class="logo" src="{{ asset('assets/img/logo.jpg') }}"></div>
        <a href="#" class="item">Institutional</a>
        <a href="#" class="item">About</a>
    </div>
</div>

@yield('content')

<div class="ui inverted vertical footer segment">
    <div class="ui center aligned container">
        <div class="ui horizontal inverted small divided link list">
            <a class="item" href="#">Site Map</a>
            <a class="item" href="#">Contact Us</a>
            <a class="item" href="#">Terms and Conditions</a>
            <a class="item" href="#">Privacy Policy</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>
@yield('body_end')
</body>
</html>