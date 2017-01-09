DROP SCHEMA IF EXISTS datagrid;
CREATE SCHEMA datagrid;
USE datagrid;

DROP TABLE IF EXISTS cargos;
CREATE TABLE cargos (
	id_cargo SMALLINT ( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	cargo VARCHAR ( 40 ) NOT NULL
) TYPE = innodb;

DROP TABLE IF EXISTS funcionarios;
CREATE TABLE funcionarios (
	id_funcionario SMALLINT ( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR ( 40 ) NOT NULL,
	email VARCHAR ( 64 ) NOT NULL,
	data_nascimento DATE NOT NULL,
	salario DECIMAL ( 10,2 ) NOT NULL,
	id_cargo SMALLINT ( 5 ) UNSIGNED NOT NULL,
	uf CHAR ( 2 ) NOT NULL,
	ativo ENUM ( '0','1' ) NOT NULL
) TYPE = innodb;