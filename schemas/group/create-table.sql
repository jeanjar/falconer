create table groups (
    id bigserial primary key,
    name character varying not null,
    active boolean default true
);