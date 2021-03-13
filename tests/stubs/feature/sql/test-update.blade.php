UPDATE users
@set
    @isset($name)
        name = :name,
    @endisset
    @isset($email)
        email = :email,
    @endisset
@endset
WHERE
    id = :id
