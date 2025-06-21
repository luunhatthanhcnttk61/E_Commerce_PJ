<!-- Mainly scripts -->

<script src="{{ asset('backends/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backends/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('backends/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('library/library.js') }}"></script>


<!-- jQuery UI -->
<script src="backends/js/plugins/jquery-ui/jquery-ui.min.js"></script>

@if(isset($config['js']) && is_array($config['js']))
    @foreach ($config['js'] as $key => $val )
        <script src="{{ asset($val) }}"></script>'
    @endforeach
@endif

