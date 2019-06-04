<!DOCTYPE html>
<html lang="{{ GROCY_CULTURE }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name="robots" content="noindex,nofollow">
	<meta name="format-detection" content="telephone=no">

	<meta name="author" content="Bernd Bestel (bernd@berrnd.de)">

	<link rel="apple-touch-icon" sizes="180x180" href="{{ $U('/img/appicons/apple-touch-icon.png?v=', true) }}{{ $version }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ $U('/img/appicons/favicon-32x32.png?v=', true) }}{{ $version }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ $U('/img/appicons/favicon-16x16.png?v=', true) }}{{ $version }}">
	<link rel="manifest" href="{{ $U('/img/appicons/site.webmanifest?v=', true) }}{{ $version }}">
	<link rel="mask-icon" href="{{ $U('/img/appicons/safari-pinned-tab.svg?v=', true) }}{{ $version }}" color="#0b024c">
	<link rel="shortcut icon" href="{{ $U('/img/appicons/favicon.ico?v=', true) }}{{ $version }}">
	<meta name="apple-mobile-web-app-title" content="grocy">
	<meta name="application-name" content="grocy">
	<meta name="msapplication-TileColor" content="#e5e5e5">
	<meta name="msapplication-config" content="{{ $U('/img/appicons/browserconfig.xml?v=', true) }}{{ $version }}">
	<meta name="theme-color" content="#ffffff">

	<title>@yield('title') | grocy</title>

	<link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
	<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<link href="/css/custom.css" rel="stylesheet">

	@stack('pageStyles')

	@if(file_exists(GROCY_DATAPATH . '/custom_css.html'))
	@php include GROCY_DATAPATH . '/custom_css.html' @endphp
	@endif

	<script>
		var Grocy = { };
		Grocy.Components = { };
		Grocy.Mode = '{{ GROCY_MODE }}';
		Grocy.BaseUrl = '{{ $U('/') }}';
		Grocy.CurrentUrlRelative = "/" + window.location.toString().replace(Grocy.BaseUrl, "");
		Grocy.ActiveNav = '@yield('activeNav', '')';
		Grocy.Culture = '{{ GROCY_CULTURE }}';
		Grocy.Currency = '{{ GROCY_CURRENCY }}';
		Grocy.GettextPo = {!! $GettextPo !!};
		Grocy.UserSettings = {!! json_encode($userSettings) !!};
		Grocy.FeatureFlags = {!! json_encode($featureFlags) !!};
	</script>

</head>

<body>
	<aside class="mdc-drawer mdc-drawer--dismissible" data-mdc-auto-init="MDCDrawer">
		<div class="mdc-drawer__header">
			<h3 class="mdc-drawer__title">{{ GROCY_USER_USERNAME }}</h3>
		</div>
		<div class="mdc-drawer__content">
			<nav class="mdc-list">
				@if(GROCY_FEATURE_FLAG_STOCK)
				<a class="mdc-list-item" href="{{ $U('/stockoverview') }}" title="{{ $__t('Stock overview') }}" data-nav-for-page="stockoverview">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">home</i>
					<span class="nav-link-text">{{ $__t('Stock overview') }}</span>
				</a>
				@endif
				@if(GROCY_FEATURE_FLAG_SHOPPINGLIST)
				<a class="mdc-list-item" href="{{ $U('/shoppinglist') }}">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">shopping_cart</i>
					<span class="nav-link-text">{{ $__t('Shopping list') }}</span>
				</a>
				@endif
				@if(GROCY_FEATURE_FLAG_RECIPES)
				<a class="mdc-list-item" href="{{ $U('/recipes') }}">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">shopping_cart</i>
					<span class="nav-link-text">{{ $__t('Recipes') }}</span>
				</a>
				@endif
			</nav>
		</div>
	</aside>


	<div class="mdc-drawer-app-content">

		<header class="mdc-top-app-bar app-bar" id="app-bar" data-mdc-auto-init="MDCTopAppBar">
			<div class="mdc-top-app-bar__row">
				<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
					<a href="#" class="demo-menu material-icons mdc-top-app-bar__navigation-icon">menu</a>
					<span class="mdc-top-app-bar__title">@yield('title')</span>
				</section>
			</div>
		</header>


		<main class="main-content mdc-top-app-bar--fixed-adjust" id="main-content">
			@yield('content')
		</main>
	</div>
	
	<script type="text/javascript">
		window.mdc.autoInit();

		const drawer = document.querySelector('.mdc-drawer').MDCDrawer

		const topAppBar = document.querySelector('.mdc-top-app-bar').MDCTopAppBar;
		topAppBar.listen('MDCTopAppBar:nav', () => {
			drawer.open = !drawer.open;
		});
	</script>



	<script src="{{ $U('/node_modules/jquery/dist/jquery.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/jquery-serializejson/jquery.serializejson.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/moment/min/moment.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/timeago/jquery.timeago.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/toastr/build/toastr.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net/js/jquery.dataTables.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net-responsive/js/dataTables.responsive.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net-colreorder/js/dataTables.colReorder.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net-colreorder-bs4/js/colReorder.bootstrap4.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net-select/js/dataTables.select.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/sprintf-js/dist/sprintf.min.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/node_modules/gettext-translator/src/translator.js?v=', true) }}{{ $version }}"></script>

	<script src="{{ $U('/js/extensions.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/js/grocy.js?v=', true) }}{{ $version }}"></script>
	<script src="{{ $U('/js/grocy_dbchangedhandling.js?v=', true) }}{{ $version }}"></script>

	@stack('pageScripts')
	@stack('componentScripts')

	@hasSection('viewJsName')<script src="{{ $U('/viewjs', true) }}/@yield('viewJsName').js?v={{ $version }}"></script>@endif
</body>

</html>