create table remember_tokens (
    id bigserial primary key,
    user_id bigint references user(id) on update cacasde on delete cascade,
    token character varying,
    user_agent character varying,
    created_at timestamp without time zone default now()
);
