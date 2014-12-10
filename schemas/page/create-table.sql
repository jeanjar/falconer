create table page (
    id bigserial primary key,
    title character varying,
    content text,
    created_at timestamp without time zone default now(),
    user_id bigint references users(id) on update cascade on delete cascade,
    template character varying
);