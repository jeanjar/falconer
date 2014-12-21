create table success_logins (
    id bigserial primary key,
    user_id bigint references user(id) on update cascade on delete cascade,
    ip_address character varying,
    user_agent character varying
);
