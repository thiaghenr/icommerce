
mysql -u root -p // a senha eh bancodedados

create database dbteste;

use dbteste;

CREATE TABLE tbcliente (
	id int(4) NOT NULL AUTO_INCREMENT,
	nome varchar(50),
	telefone varchar(10),
	email varchar(50),
	categoria_id int(4),
	PRIMARY KEY (id),
	CONSTRAINT fk_categoria FOREIGN KEY (categoria_id)
	REFERENCES tbcategoria(id_categoria)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);


CREATE TABLE tbcategoria (
	id_categoria int(4) NOT NULL AUTO_INCREMENT,
	nome varchar(50) NOT NULL,
	PRIMARY KEY (id_categoria)
);

show tables;

desc tbcliente;

select * from tbcliente;
