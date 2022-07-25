<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page Builder - Page {{ $page->id }} - {{ $page->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/grapesjs.css') }}" />

    <script type="text/javascript">
        window.csrf            = '{{ csrf_token() }}';
        window.astralPageId    = '{{ $page->id }}';
        window.astralAdminUrl  = "{{ url(config('astral-cms.admin-path')) }}";
        window.astralStoreUrl  = "{{ route('page-builder-store',  [ 'page' => $page ]) }}";
        window.astralUploadUrl = "{{ route('page-builder-upload', [ 'page' => $page ]) }}";
        window.assets          = `{!! $assets !!}`;
        
        @if($page && $page->data)
            window.astralPageData = `{!! $page->data !!}`;
        @endif
    </script>
</head>

<body>
    <div class="full-screen-loader">
        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>

    <main id="astral-cms-content"></main>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>

</html>