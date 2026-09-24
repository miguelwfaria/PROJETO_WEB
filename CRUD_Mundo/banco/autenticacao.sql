-- Para acrescentar a autenticação a um bd_mundo já importado.
use bd_mundo;

create table usuarios (
id_usuario int primary key auto_increment,
nome varchar(100) not null,
login varchar(100) not null unique,
senha varchar(255) not null,
tentativas_falhas int not null default 0,
bloqueado boolean not null default false,
trocar_senha boolean not null default true
);

create table logs (
id_log int primary key auto_increment,
id_usuario int not null,
login_informado varchar(100) not null,
acao varchar(30) not null,
data_hora datetime not null default current_timestamp,
foreign key (id_usuario) references usuarios(id_usuario)
);
