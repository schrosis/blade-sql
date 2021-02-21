@trim(['prefix' => 'invisible-prefix'])
@endtrim

@trim(['prefix' => 'visible-prefix'])
some string
@endtrim

@trim(['suffix' => 'invisible-suffix'])
@endtrim

@trim(['suffix' => 'visible-suffix'])
some string
@endtrim

@trim(['prefixOverrides' => 'remove-prefix-string'])
remove-prefix-string some string
@endtrim

@trim(['suffixOverrides' => 'remove-suffix-string'])
some string remove-suffix-string
@endtrim
