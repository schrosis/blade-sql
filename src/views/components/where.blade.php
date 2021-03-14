@trim(['prefix' => 'WHERE', 'prefixOverrides' => 'AND[\s\n]|OR[\s\n]'])
{!! $slot !!}
@endtrim
