create table reset_passwords (
    id bigserial primary key,
    user_id bigint references user(id) on update cascade on delete cascade,
    verification_code character varying,
    created_at timestamp without time zone default now(),
    modified_at timestamp without time zone default now(),
    reset character varying
);
