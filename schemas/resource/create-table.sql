create table resources (
    id bigserial primary key,
    resource character varying,
    group_id bigint references group(id) on update cascade on delete cascade,
    action character varying
);
