create table groups_resources (
    group_id bigint references groups(id) on update cascade on delete cascade,
    resource_id bigint references resources(id) on update cascade on delete cascade,
    PRIMARY KEY(group_id, resource_id)
);