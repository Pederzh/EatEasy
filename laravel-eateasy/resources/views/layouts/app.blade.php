<!DOCTYPE html>
<html lang="it">

	<head>
		@include('includes._head')
	</head>


	<body id="app-layout">
		<header>
			@include('includes._header')
		</header>

		<main>
			<!-- ELEMENTI DA METTERE IN FULLWIDTH A INIZIO PAGINA -->
			@yield('fullwidth')

			<!-- CONTENT -->
			<div class="container">
				@yield('content')
			</div>
			<!-- CONTENT END -->
		</main>
		@include('includes._footer')

		@include('includes._scripts')
	</body>

</html>