create table database_lock (
    id bigserial primary key,
    key character varying unique,
    file character varying unique,
    run_at timestamp without time zone default now()
);