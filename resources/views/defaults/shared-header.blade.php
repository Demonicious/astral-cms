<title>{{ $page->title }}</title>
<link rel="stylesheet" href="{{ asset('/storage/styles/' . md5($page->created_at) . '.css') }}" />
<script defer type="text/javascript" href="{{ asset('/storage/scripts/' . md5($page->created_at) . '.js') }}"></script>

<script type="text/javascript">
    window.csrf = '{{ csrf_token() }}';
</script>