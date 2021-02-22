SELECT
    *
FROM users
@where
    @isset($email)
        AND email = :email
    @endisset
    @isset($name)
        @if (is_array($name) && count($name) > 0)
            AND name @IN(name)
        @else
            AND name @LIKE({name}%)
        @endif
    @endisset
@endwhere
