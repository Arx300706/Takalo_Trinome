psql -U noraa;

create database uploadimage;

exit;

psql -U noraa -d uploadimage;

create table image(
    id SERIAL primary key,
    path VARCHAR(255),
    description text
);

insert into image (path, description) values ('/upload/img1.jpeg', 'Un beau couche de soleil'); 