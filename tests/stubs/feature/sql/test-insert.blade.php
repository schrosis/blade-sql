INSERT INTO users (name, email, password, created_at, updated_at)
values(:name, :email, :password, DATETIME(), DATETIME())
