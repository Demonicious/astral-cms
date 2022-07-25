<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page->title }}</title>
    <link rel="stylesheet" href="{{ asset('/storage/styles/' . md5($page->created_at) . '.css') }}" />
    <script defer type="text/javascript" href="{{ asset('/storage/scripts/' . md5($page->created_at) . '.js') }}"></script>

    <script type="text/javascript">
        window.csrf = '{{ csrf_token() }}';
    </script>

</head>

{!! $page->html !!}

</html>