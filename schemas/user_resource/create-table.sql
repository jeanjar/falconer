create table users_resource (
    user_id bigint references users(id) on update cascade on delete cascade,
    resource_id bigint references resources(id) on update cascade on delete cascade,
    PRIMARY KEY (user_id, resource_id)
);