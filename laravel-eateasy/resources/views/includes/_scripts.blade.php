<!-- JQuery -->
<script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
{{-- ULTIMA VERSIONE, NON FUNZIONA DATEPICKER <script src="{{asset('js/jquery-2.2.2.min.js')}}"></script> --}}
<!-- Materialize Javascript -->
<script src="{{asset('js/materialize.min.js')}}"></script>
<!-- Per i grafici -->
<script src="{{asset('js/Chart.min.js')}}"></script>
<!-- Custom Javascript -->
<script src="{{asset('js/init.js')}}"></script>
<!-- GAMPbar -->
<script src="{{asset('js/GAMPbar.js')}}"></script>

@if (isset($chart))
	<!-- myChart per inizializzare i grafici -->
	<script src="{{asset('js/myChart.js')}}"></script>
@endif
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}