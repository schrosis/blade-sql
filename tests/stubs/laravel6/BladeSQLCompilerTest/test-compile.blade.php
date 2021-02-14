SELECT
    id,
    name,
    email
FROM users
WHERE
    1 = 1
    @isset ($deleted_at)
        AND deleted_at = :deleted_at
    @else
        AND deleted_at IS NULL
    @endisset
    @if (count($user_id_list) > 0)
        ADN id @IN(user_id_list)
    @endif
