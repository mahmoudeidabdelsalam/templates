<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/favicon-16x16.png">
  <link rel="manifest" href="{{ get_theme_file_uri().'/resources/assets/images/favicons' }}/manifest.json">
  <meta name="msapplication-TileColor" content="#1E6CFC">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#1E6CFC">
  <meta name="robots" content="index, follow" />

  @php wp_head() @endphp
 
  <!-- Head Scripts -->
  @if(get_field('header_scripts', 'option'))
    {{ the_field('header_scripts', 'option') }}
  @else
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-103603396-1"></script>
    <!-- Hotjar Tracking Code for http://premast.com/ -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1386544,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '1309056782583515');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=1309056782583515&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-103603396-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-103603396-1', { 'optimize_id': 'GTM-PSBHXMP'});
    </script>
    <!-- Matomo -->
    <script type="text/javascript">
      var _paq = window._paq || [];
      /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="https://premast.matomo.cloud/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src='//cdn.matomo.cloud/premast.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
      })();
    </script>
    <!-- End Matomo Code -->
    <!-- mailchaimp -->
    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/022c13d7ed1b3a7bffe94a937/79c0d2d42087e7c1fd89249af.js");</script>
    <!-- Begin Inspectlet Asynchronous Code -->
    <script type="text/javascript">
    (function() {
    window.__insp = window.__insp || [];
    __insp.push(['wid', 839776136]);
    var ldinsp = function(){
    if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js?wid=839776136&r=' + Math.floor(new Date().getTime()/3600000); var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
    setTimeout(ldinsp, 0);
    })();
    </script>
    <!-- End Inspectlet Asynchronous Code -->
  @endif

</head>
