<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{!! Meta::get('title') !!}</title>
    {!! Meta::tag('description') !!}
    {!! Meta::tag('keywords') !!}
    <meta name="language" content="ru"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    @include('layouts._favicon')
    <base href="/">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="search" type="application/opensearchdescription+xml" title="SellerStore.ru" href="/open-search.xml">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic">
    <script type="text/javascript" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"
            async='async'></script>
    <script type="text/javascript">
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-9313071319944042",
            enable_page_level_ads: true
        });
    </script>
    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body>
<div class="background-image"></div>
<div class="mainWrapper">
    @include('layouts/_header')
    <section class="row">
        <div class="left-menu col s3 hide-on-med-and-down">
            @include('layouts/_sidebar')
        </div>
        <div class="content-zone col s12 m12 l9 white">
            @yield('breadcrumbs')
            @yield('content')
        </div>
    </section>
</div>
@include('layouts/_footer')
</body>
</html>
