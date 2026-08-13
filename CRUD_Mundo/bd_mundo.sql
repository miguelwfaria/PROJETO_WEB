create database bd_mundo;
use bd_mundo;

create table continente (
id_continente int primary key auto_increment,
nome varchar(100) not null,
populacao bigint not null,
area decimal(15,2) not null,
total_paises int not null
);

create table governante (
id_governante int primary key auto_increment,
nome varchar(100) not null,
partido_politico varchar(100) not null,
data_nascimento date not null,
idade int not null,
data_inicio_mandato date not null,
data_fim_mandato date
);

create table pais (
id_pais int primary key auto_increment,
nome varchar(100) not null,
id_continente int not null,
populacao bigint not null,
area decimal(15,2) not null,
idioma varchar(100) not null,
id_governante int not null,
clima varchar(100) not null,
regime_politico varchar(100) not null,
moeda varchar(100) not null,
foreign key (id_continente) references continente(id_continente),
foreign key (id_governante) references governante(id_governante)
);

create table cidade (
id_cidade int primary key auto_increment,
nome varchar(100) not null,
id_pais int not null,
populacao bigint not null,
area decimal(15,2) not null,
clima varchar(100) not null,
id_governante int not null,
data_fundacao date not null,
foreign key (id_pais) references pais(id_pais),
foreign key (id_governante) references governante(id_governante)
);

show tables;