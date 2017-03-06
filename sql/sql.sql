create database notasdatabase default character set utf8 collate utf8_unicode_ci;

create user usernotas@localhost identified by 'usernotas';

grant all on notasdatabase.* to usernotas@localhost;

flush privileges;

use notasdatabase;

create table notas (
    idNotas int auto_increment primary key,
    titulo varchar(75) null,
    contenido varchar(300) not null,
    idUsuario varchar(100) not null,
    favorito tinyint
) engine=innodb  default charset=utf8 collate=utf8_unicode_ci;

create table usuario (
    idUsuario int auto_increment primary key,
    email varchar(100) unique,
    password varchar(256) not null,
    falta date not null,
    pais varchar (30),
    tipo enum('basico', 'premium', 'administrador') not null default 'basico',
    activa tinyint not null
) engine=innodb  default charset=utf8 collate=utf8_unicode_ci;

create table media (
    idMedia int auto_increment primary key,
    idNotas int not null,
    tipo enum('foto','video','audio'),
    ruta varchar(100)
) engine=innodb  default charset=utf8 collate=utf8_unicode_ci;


create table edicion(
    idEdicion int auto_increment primary key,
    idNotas int not null,
    titulo varchar(75) null,
    contenido varchar(300) not null,
    fechaEdicion date,
    idUsuario int not null
)engine=innodb  default charset=utf8 collate=utf8_unicode_ci;