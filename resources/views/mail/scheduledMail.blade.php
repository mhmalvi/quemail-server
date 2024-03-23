<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    {{ $id }}
    <img src="{{ route('track_open',[$id]) }}" />
    {{-- <img src="https://emailmarketing.queleadscrm.com/track/user/".$id /> --}}
    {{-- <table background={{ 'https://emailmarketing.queleadscrm.com' . '/track/user/' . $id }}></table> --}}
    {!! $template !!}
</body>

</html>
