window.extensionBlocks = [
    @foreach ($blocks as $block)
    [
        '{{ $block['id'] }}',
        {
            label: '{{ $block['label'] }}',
            
            @if(isset($block['media']))
            media: `{!! $block['media'] !!}`,
            @endif

            @if(isset($block['icon']))
            icon: `{!! $block['icon'] !!}`,
            @endif

            content: `{!! $block['content'] !!}`,
            category: '{{ $block['category'] }}',

            @if(isset($block['attributes']))
            attributes: JSON.parse(`{{ json_encode($block['attributes']) }}`),
            @endif
        }
    ],
    @endforeach
];