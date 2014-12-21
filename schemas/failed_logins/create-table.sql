create table failed_logins (
    id bigserial primary key,
    user_id bigint references user(id) on update cascade on delete cascade,
    ip_address character varying,
    attempted bigint default 0
);
