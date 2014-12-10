create table users (
    id bigserial primary key,
    full_name character varying not null,
    group_id bigint references groups(id) on update cascade on delete cascade,
    username character varying not null unique,
    password character varying not null,
    password_change_key character varying,
    password_change_key_evalution timestamp without time zone,
    email character varying not null unique,
    gender character varying(1) not null,
    active boolean default true,
    created_at timestamp without time zone default now(),
    hybridauth_provider_name character varying,
    hybridauth_provider_uid character varying
);