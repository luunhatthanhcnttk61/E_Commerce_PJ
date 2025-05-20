<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>INSPINIA | Dashboard v.2</title>

<link href="{{ asset ('backends/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset ('backends/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset ('backends/css/animate.css') }}" rel="stylesheet">

@if(isset($config['css']) && is_array($config['css']))
    @foreach($config['css'] as $key => $val)
       {!! '<link href="'.$val.'" rel="stylesheet"></script>' !!} 
    @endforeach
@endif

<link href="{{ asset ('backends/css/style.css') }}" rel="stylesheet">
<link href="{{ asset ('backends/css/customize.css')}}" rel="stylesheet">
<script src="{{ asset('backends/js/jquery-2.1.1.js')}}"></script>