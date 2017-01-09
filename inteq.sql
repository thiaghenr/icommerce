# phpMyAdmin MySQL-Dump
# version 2.2.3
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Servidor: localhost
# Tempo de Genera��o: Oct 25, 2011 at 03:06 PM
# Vers�o do Servidor: 5.01.40
# Vers�o do PHP: 5.3.1RC2
# Banco de Dados : `inteq`
# --------------------------------------------------------

#
# Estrutura da tabela `acerto_estoque`
#

CREATE TABLE acerto_estoque (
  idacerto_estoque int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_produto int(10) unsigned NOT NULL,
  qtd_anterior float(8,2) NOT NULL,
  qtd_informada float(8,2) NOT NULL,
  tipo_es varchar(45) NOT NULL,
  user_resp int(10) unsigned NOT NULL,
  qtd_final float(8,2) NOT NULL,
  data_acerto datetime NOT NULL,
  PRIMARY KEY (idacerto_estoque)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `acerto_estoque`
#

INSERT INTO acerto_estoque VALUES (1, 1, '57.00', '0.00', 'Saida', 2, '57.00', '2011-03-21 04:19:35');
INSERT INTO acerto_estoque VALUES (2, 1, '57.00', '0.00', 'Entrada', 2, '57.00', '2011-03-21 04:20:43');
INSERT INTO acerto_estoque VALUES (3, 1, '57.00', '1.00', 'Entrada', 2, '58.00', '2011-03-21 04:21:23');
INSERT INTO acerto_estoque VALUES (4, 1, '58.00', '1.00', 'Saida', 2, '57.00', '2011-03-21 04:22:00');
INSERT INTO acerto_estoque VALUES (5, 1, '57.00', '0.00', 'Entrada', 2, '57.00', '2011-03-21 04:24:04');
INSERT INTO acerto_estoque VALUES (6, 17, '0.00', '10.00', 'Entrada', 2, '10.00', '2011-03-21 04:43:24');
INSERT INTO acerto_estoque VALUES (7, 24, '0.00', '1.00', 'Entrada', 2, '1.00', '2011-03-21 04:52:59');
INSERT INTO acerto_estoque VALUES (8, 27, '10.00', '103.00', 'Entrada', 2, '113.00', '2011-03-28 06:42:27');
INSERT INTO acerto_estoque VALUES (9, 27, '113.00', '2.00', 'Saida', 2, '111.00', '2011-03-28 12:33:51');
INSERT INTO acerto_estoque VALUES (10, 27, '111.00', '2.00', 'Saida', 2, '109.00', '2011-03-28 12:34:35');
INSERT INTO acerto_estoque VALUES (11, 1, '57.00', '1.00', 'Entrada', 2, '58.00', '2011-03-28 12:35:21');
INSERT INTO acerto_estoque VALUES (12, 15, '10.00', '6.00', 'Saida', 2, '4.00', '2011-03-28 13:12:11');
INSERT INTO acerto_estoque VALUES (13, 16, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:12:31');
INSERT INTO acerto_estoque VALUES (14, 17, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:12:45');
INSERT INTO acerto_estoque VALUES (15, 18, '10.00', '1.00', 'Entrada', 2, '11.00', '2011-03-28 13:12:57');
INSERT INTO acerto_estoque VALUES (16, 19, '9.00', '6.00', 'Entrada', 2, '15.00', '2011-03-28 13:13:46');
INSERT INTO acerto_estoque VALUES (17, 20, '10.00', '5.00', 'Saida', 2, '5.00', '2011-03-28 13:14:00');
INSERT INTO acerto_estoque VALUES (18, 21, '10.00', '0.00', 'Saida', 2, '10.00', '2011-03-28 13:14:19');
INSERT INTO acerto_estoque VALUES (19, 22, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:14:42');
INSERT INTO acerto_estoque VALUES (20, 23, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:14:53');
INSERT INTO acerto_estoque VALUES (21, 24, '1.00', '1.00', 'Saida', 2, '0.00', '2011-03-28 13:15:01');
INSERT INTO acerto_estoque VALUES (22, 25, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:15:12');
INSERT INTO acerto_estoque VALUES (23, 26, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:15:19');
INSERT INTO acerto_estoque VALUES (24, 28, '10.00', '36.00', 'Entrada', 2, '46.00', '2011-03-28 13:15:58');
INSERT INTO acerto_estoque VALUES (25, 2, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:16:32');
INSERT INTO acerto_estoque VALUES (26, 3, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:16:39');
INSERT INTO acerto_estoque VALUES (27, 29, '10.00', '9.00', 'Saida', 2, '1.00', '2011-03-28 13:17:08');
INSERT INTO acerto_estoque VALUES (28, 4, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:17:41');
INSERT INTO acerto_estoque VALUES (29, 5, '10.00', '4.00', 'Entrada', 2, '14.00', '2011-03-28 13:17:53');
INSERT INTO acerto_estoque VALUES (30, 6, '10.00', '12.00', 'Entrada', 2, '22.00', '2011-03-28 13:21:10');
INSERT INTO acerto_estoque VALUES (31, 7, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:21:19');
INSERT INTO acerto_estoque VALUES (32, 8, '10.00', '6.00', 'Saida', 2, '4.00', '2011-03-28 13:21:27');
INSERT INTO acerto_estoque VALUES (33, 9, '10.00', '8.00', 'Saida', 2, '2.00', '2011-03-28 13:22:09');
INSERT INTO acerto_estoque VALUES (34, 10, '10.00', '8.00', 'Saida', 2, '2.00', '2011-03-28 13:22:26');
INSERT INTO acerto_estoque VALUES (35, 11, '10.00', '10.00', 'Saida', 2, '0.00', '2011-03-28 13:22:38');
INSERT INTO acerto_estoque VALUES (36, 12, '10.00', '6.00', 'Entrada', 2, '16.00', '2011-03-28 13:22:52');
INSERT INTO acerto_estoque VALUES (37, 30, '10.00', '9.00', 'Saida', 2, '1.00', '2011-03-28 13:23:36');
INSERT INTO acerto_estoque VALUES (38, 29, '1.00', '7.00', 'Saida', 2, '-6.00', '2011-03-28 13:24:34');
INSERT INTO acerto_estoque VALUES (39, 29, '-6.00', '8.00', 'Entrada', 2, '2.00', '2011-03-28 13:24:45');
INSERT INTO acerto_estoque VALUES (40, 29, '2.00', '0.00', 'Saida', 2, '2.00', '2011-03-28 13:24:56');
INSERT INTO acerto_estoque VALUES (41, 29, '2.00', '2.00', 'Entrada', 2, '4.00', '2011-03-28 13:25:08');
INSERT INTO acerto_estoque VALUES (42, 4, '0.00', '17.00', 'Entrada', 2, '17.00', '2011-10-20 10:28:33');
INSERT INTO acerto_estoque VALUES (43, 7, '0.00', '18.00', 'Entrada', 2, '18.00', '2011-10-20 15:06:07');
INSERT INTO acerto_estoque VALUES (44, 3, '0.00', '18.00', 'Entrada', 2, '18.00', '2011-10-20 18:09:59');
INSERT INTO acerto_estoque VALUES (45, 8, '4.00', '18.00', 'Entrada', 2, '22.00', '2011-10-20 18:10:29');
INSERT INTO acerto_estoque VALUES (46, 3, '5.00', '18.00', 'Entrada', 2, '23.00', '2011-10-21 16:57:18');
INSERT INTO acerto_estoque VALUES (47, 15, '-6.00', '10.00', 'Entrada', 2, '4.00', '2011-10-21 17:09:28');
INSERT INTO acerto_estoque VALUES (48, 4, '4.00', '3.00', 'Entrada', 2, '7.00', '2011-10-21 17:09:42');
INSERT INTO acerto_estoque VALUES (49, 5, '5.00', '3.00', 'Entrada', 2, '8.00', '2011-10-21 17:09:57');
INSERT INTO acerto_estoque VALUES (50, 31, '13.00', '2.00', 'Entrada', 2, '15.00', '2011-10-21 17:10:08');
INSERT INTO acerto_estoque VALUES (51, 7, '13.00', '5.00', 'Entrada', 2, '18.00', '2011-10-21 17:10:17');
INSERT INTO acerto_estoque VALUES (52, 8, '17.00', '5.00', 'Entrada', 2, '22.00', '2011-10-21 17:10:24');
INSERT INTO acerto_estoque VALUES (53, 18, '11.00', '1.00', 'Saida', 2, '10.00', '2011-10-22 10:03:35');
INSERT INTO acerto_estoque VALUES (54, 17, '0.00', '4.00', 'Entrada', 2, '4.00', '2011-10-22 10:05:02');
INSERT INTO acerto_estoque VALUES (55, 4, '4.00', '8.00', 'Entrada', 2, '12.00', '2011-10-22 10:06:55');
INSERT INTO acerto_estoque VALUES (56, 5, '5.00', '17.00', 'Entrada', 2, '22.00', '2011-10-22 10:07:14');
INSERT INTO acerto_estoque VALUES (57, 9, '2.00', '4.00', 'Entrada', 2, '6.00', '2011-10-22 10:07:39');
INSERT INTO acerto_estoque VALUES (58, 15, '4.00', '9.00', 'Entrada', 2, '13.00', '2011-10-22 10:08:17');
INSERT INTO acerto_estoque VALUES (59, 16, '0.00', '8.00', 'Entrada', 2, '8.00', '2011-10-22 10:08:40');
INSERT INTO acerto_estoque VALUES (60, 15, '12.00', '7.00', 'Entrada', 2, '19.00', '2011-04-03 09:53:47');
INSERT INTO acerto_estoque VALUES (61, 17, '4.00', '17.00', 'Entrada', 2, '21.00', '2011-04-03 09:56:03');
INSERT INTO acerto_estoque VALUES (62, 18, '10.00', '4.00', 'Saida', 2, '6.00', '2011-10-25 14:55:30');
INSERT INTO acerto_estoque VALUES (63, 20, '5.00', '4.00', 'Saida', 2, '1.00', '2011-10-25 14:59:21');
# --------------------------------------------------------

#
# Estrutura da tabela `banco`
#

CREATE TABLE banco (
  id_banco int(10) unsigned NOT NULL AUTO_INCREMENT,
  codigo_banco varchar(10) NOT NULL,
  nome_banco varchar(20) NOT NULL,
  PRIMARY KEY (id_banco)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `banco`
#

INSERT INTO banco VALUES (3, '1', 'BANCO INTEGRACION');
INSERT INTO banco VALUES (7, '2', 'BANCO ABM-AMRO');
INSERT INTO banco VALUES (8, '3', 'BANCO CONTINENTAL');
INSERT INTO banco VALUES (10, '5', 'BANCO CREDIT UNION');
# --------------------------------------------------------

#
# Estrutura da tabela `caixa`
#

CREATE TABLE caixa (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  usuario_id int(10) unsigned DEFAULT NULL,
  data_abertura datetime NOT NULL,
  data_fechamento datetime NOT NULL,
  `status` varchar(1) NOT NULL,
  valor_abertura double NOT NULL,
  valor_fechamento double NOT NULL,
  valor_mov_entrada double NOT NULL,
  valor_mov_saida double NOT NULL,
  valor_mov_cred_cli double NOT NULL,
  valor_mov_dev_cli double NOT NULL,
  valor_mov_dev_prov double NOT NULL,
  valor_transf_banco double NOT NULL,
  st_transferencia varchar(1) NOT NULL,
  vl_transferido_fin double NOT NULL,
  vl_fechamento double NOT NULL,
  vl_anterior double NOT NULL,
  usuario_fechamento int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `caixa`
#

INSERT INTO caixa VALUES (1, 1, '2011-06-24 12:26:55', '0000-00-00 00:00:00', 'A', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0);
# --------------------------------------------------------

#
# Estrutura da tabela `caixa01`
#

CREATE TABLE caixa01 (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(45) DEFAULT NULL,
  data_abertura datetime DEFAULT NULL,
  data_fecha datetime DEFAULT NULL,
  saldo_anterior float(8,2) DEFAULT NULL,
  saldo_fecha float(8,2) DEFAULT NULL,
  id_usuario int(10) unsigned DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  saldo_transferido double DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `caixa01`
#

# --------------------------------------------------------

#
# Estrutura da tabela `caixa_balcao`
#

CREATE TABLE caixa_balcao (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  dt_abertura datetime NOT NULL,
  dt_fechamento datetime NOT NULL,
  vl_abertura float(8,2) NOT NULL,
  vl_fechamento float(8,2) NOT NULL,
  usuario_id int(10) unsigned NOT NULL,
  st_caixa varchar(1) NOT NULL,
  st_transferencia varchar(1) NOT NULL,
  vl_mov_entrada float(8,2) NOT NULL,
  vl_mov_saida float(8,2) NOT NULL,
  vl_transferido_fin float(8,2) NOT NULL,
  vl_mov_cred_cliente float(8,2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `caixa_balcao`
#

INSERT INTO caixa_balcao VALUES (1, '2011-10-21 14:53:14', '0000-00-00 00:00:00', '0.00', '0.00', 2, 'A', '', '0.00', '0.00', '0.00', NULL);
# --------------------------------------------------------

#
# Estrutura da tabela `cambio_moeda`
#

CREATE TABLE cambio_moeda (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  moeda_id int(10) unsigned NOT NULL,
  vl_cambio float(8,2) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `cambio_moeda`
#

INSERT INTO cambio_moeda VALUES (24, 1, '4300.00', '2011-04-27 20:57:43');
INSERT INTO cambio_moeda VALUES (25, 3, '4300.00', '2011-04-27 20:57:53');
INSERT INTO cambio_moeda VALUES (26, 3, '4300.00', '2011-04-27 20:58:01');
INSERT INTO cambio_moeda VALUES (27, 3, '0.00', '2011-04-27 20:58:04');
INSERT INTO cambio_moeda VALUES (28, 3, '4300.00', '2011-04-27 20:58:09');
INSERT INTO cambio_moeda VALUES (29, 1, '4300.00', '2011-04-27 20:58:15');
INSERT INTO cambio_moeda VALUES (30, 1, '4500.00', '2011-04-27 20:58:21');
INSERT INTO cambio_moeda VALUES (31, 3, '4100.00', '2011-03-28 11:00:55');
INSERT INTO cambio_moeda VALUES (32, 3, '4100.00', '2011-03-28 11:03:50');
INSERT INTO cambio_moeda VALUES (33, 1, '4100.00', '2011-03-28 11:03:57');
INSERT INTO cambio_moeda VALUES (34, 3, '2000.00', '2011-03-28 11:04:04');
# --------------------------------------------------------

#
# Estrutura da tabela `cargos`
#

CREATE TABLE cargos (
  id_cargo int(11) NOT NULL AUTO_INCREMENT,
  cargo varchar(40) NOT NULL,
  PRIMARY KEY (id_cargo)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `cargos`
#

INSERT INTO cargos VALUES (1, 'VENDEDOR');
INSERT INTO cargos VALUES (2, 'GERENTE SETOR');
INSERT INTO cargos VALUES (3, 'GERENTE GERAL');
INSERT INTO cargos VALUES (4, 'AUXILIAR SERVICOS GERAIS');
INSERT INTO cargos VALUES (5, 'SECRETARIA');
INSERT INTO cargos VALUES (6, 'TELEFONISTA');
INSERT INTO cargos VALUES (7, 'MOTORISTA');
INSERT INTO cargos VALUES (8, 'SEGURANCA');
INSERT INTO cargos VALUES (9, 'CAIXA');
INSERT INTO cargos VALUES (10, 'AUXILIAR ADMINSTRATIVO');
INSERT INTO cargos VALUES (11, 'PRESIDENTE');
INSERT INTO cargos VALUES (12, 'DIRETOR');
# --------------------------------------------------------

#
# Estrutura da tabela `carrinho`
#

CREATE TABLE carrinho (
  id int(11) NOT NULL AUTO_INCREMENT,
  Codigo varchar(50) NOT NULL,
  descricao varchar(50) NOT NULL,
  prvenda float(8,2) NOT NULL,
  qtd_produto float(8,2) NOT NULL,
  controle int(11) NOT NULL,
  num_pedido int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `status` varchar(1) NOT NULL,
  num_cotacao int(11) NOT NULL,
  codigo_prod varchar(50) NOT NULL,
  user_id int(11) NOT NULL,
  sessao text NOT NULL,
  `host` varchar(15) NOT NULL,
  UNIQUE KEY id_2 (id),
  KEY id (id)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `carrinho`
#

# --------------------------------------------------------

#
# Estrutura da tabela `carrinho_compra`
#

CREATE TABLE carrinho_compra (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  descricao varchar(45) NOT NULL,
  prvenda float(8,2) NOT NULL,
  qtd_produto float(8,2) unsigned DEFAULT NULL,
  sessao text NOT NULL,
  fornecedor_codigo int(10) unsigned NOT NULL,
  `data` datetime NOT NULL,
  `status` varchar(1) NOT NULL,
  produto_codigo varchar(20) NOT NULL,
  compra_id int(11) NOT NULL,
  idprod int(10) unsigned NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `carrinho_compra`
#

# --------------------------------------------------------

#
# Estrutura da tabela `cheque`
#

CREATE TABLE cheque (
  id_cheque int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_banco int(10) unsigned NOT NULL,
  agencia varchar(10) NOT NULL,
  conta varchar(10) NOT NULL,
  num_cheque varchar(10) NOT NULL,
  valor float(8,2) NOT NULL,
  data_dia datetime NOT NULL,
  data_emissao datetime NOT NULL,
  data_validade date NOT NULL,
  emissor varchar(30) NOT NULL,
  ruc_emissor int(10) unsigned NOT NULL,
  dig_ruc int(10) unsigned NOT NULL,
  cliente_id int(10) unsigned NOT NULL,
  situacao varchar(1) NOT NULL,
  moeda varchar(7) NOT NULL,
  PRIMARY KEY (id_cheque)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `cheque`
#

# --------------------------------------------------------

#
# Estrutura da tabela `cidades`
#

CREATE TABLE cidades (
  idcidade int(10) unsigned NOT NULL AUTO_INCREMENT,
  nomecidade varchar(45) NOT NULL,
  estadoid int(10) unsigned NOT NULL DEFAULT '1',
  paisid int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (idcidade)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `cidades`
#

INSERT INTO cidades VALUES (1, 'CIUDAD DEL ESTE', 1, 1);
INSERT INTO cidades VALUES (2, 'SANTA RITA', 1, 1);
INSERT INTO cidades VALUES (3, 'NARANJAL', 1, 1);
INSERT INTO cidades VALUES (6, 'ASSUNCION', 1, 1);
INSERT INTO cidades VALUES (7, 'ENCARNACION', 1, 1);
INSERT INTO cidades VALUES (8, 'NUEVA ESPERANZA', 1, 1);
INSERT INTO cidades VALUES (9, 'KATUETE', 1, 1);
INSERT INTO cidades VALUES (10, 'SALTO DEL GUAIRA', 1, 1);
INSERT INTO cidades VALUES (11, 'SAN ALBERTO', 1, 1);
INSERT INTO cidades VALUES (12, 'CAMPO 9', 1, 1);
INSERT INTO cidades VALUES (13, 'MINGA GUAZU', 1, 1);
INSERT INTO cidades VALUES (14, 'NUEVA TOLEDO', 1, 1);
INSERT INTO cidades VALUES (15, 'PEDRO JUAN', 1, 1);
INSERT INTO cidades VALUES (16, 'CRUCE GUARANI', 1, 1);
# --------------------------------------------------------

#
# Estrutura da tabela `clientes`
#

CREATE TABLE clientes (
  controle int(10) unsigned NOT NULL AUTO_INCREMENT,
  nome varchar(50) NOT NULL,
  abrv varchar(12) DEFAULT NULL,
  razao_social varchar(50) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  dt_ult_compra datetime DEFAULT NULL,
  endereco varchar(50) DEFAULT NULL,
  vendedor varchar(15) DEFAULT NULL,
  telefonecom varchar(15) DEFAULT NULL,
  fax varchar(15) DEFAULT NULL,
  celular varchar(15) DEFAULT NULL,
  ruc varchar(15) DEFAULT NULL,
  cedula varchar(15) DEFAULT NULL,
  limite double DEFAULT NULL,
  limite_disp float(8,2) DEFAULT NULL,
  contato1 varchar(35) DEFAULT NULL,
  contato2 varchar(35) DEFAULT NULL,
  contato3 varchar(35) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  obs text,
  saldo_devedor float(8,2) DEFAULT NULL,
  ativo varchar(1) DEFAULT 'S',
  cidade varchar(55) DEFAULT NULL,
  descmax float(8,2) NOT NULL,
  PRIMARY KEY (controle)
) ENGINE=MyISAM AUTO_INCREMENT=260 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `clientes`
#

INSERT INTO clientes VALUES (228, 'SILVIA REGINA BORRI', '', '', '2011-03-21 12:30:35', '0000-00-00 00:00:00', 'CALLE LA AMISTAD', NULL, '', '(047) 1234224', '(098) 4844312', '6539391-5', '6539391', '1', NULL, '', '', '', 'ENG.SILVIA@TERRA.COM.BR', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (229, 'RANCES SERVIçOS', '', '', '2011-03-28 04:23:51', '0000-00-00 00:00:00', 'KATEUTE', NULL, '', '', '(098) 3490903', '123456-0', '', '250', NULL, 'CARLOS', '', '', '', '', NULL, 'S', 'Kateute', '0.00');
INSERT INTO clientes VALUES (230, 'MUNDIAL MOTOS', '', '', '2011-03-28 04:38:02', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(098) 2890783', '123456-2', '', '1', NULL, 'WALDEMAR', '', '', '', '<br>', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (231, 'RIVERO MOTOS', '', '', '2011-03-28 04:39:01', '0000-00-00 00:00:00', 'KATEUTE', NULL, '', '', '(098) 3320963', '123456-1', '', '0', NULL, 'OSMAR', '', '', '', '<BR>', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (232, 'LAVADOR SANTA LIBRADA', '', '', '2011-03-28 04:41:13', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(098) 3123183', '123456-3', '', '0', NULL, 'SEVERINO', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (233, 'FRANCISCO MARTINEZ - LAVADOR', '', '', '2011-03-28 04:42:59', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(097) 3734431', '123456-4', '', '0', NULL, 'FRANCISCO', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (234, 'LAVADOR BRASPAR', '', '', '2011-03-28 04:43:51', '0000-00-00 00:00:00', 'KATEUTE', NULL, '', '', '(098) 5945086', '123456-5', '', '1', NULL, 'GOMES', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (235, 'LAVANDERIA LUANA', '', '', '2011-03-28 05:57:07', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '2193805-9', '', '0', NULL, 'LUANE', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (236, 'SUPERMERCADO ELENINHA', '', '', '2011-03-28 06:00:24', '0000-00-00 00:00:00', 'CRUCE GUARANI', NULL, '', '', '(098) 3626332', '50030586-2', '', '0', NULL, 'ELENINHA', '', '', '', '', NULL, 'S', '16', '0.00');
INSERT INTO clientes VALUES (237, 'ELAINE SCHANAIDER DE BORTOLOSSI', '', 'FERRARI LAVA CAR', '2011-03-28 06:01:52', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(098) 3606449', '2351829-4', '', '0', NULL, 'NEGãO', 'ELIANE', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (238, 'ANDRINO RODRIGUES DOS SANTOS', '', '', '2011-03-28 06:03:10', '0000-00-00 00:00:00', 'NUEVA ESPERANZA', NULL, '', '', '', '', '6348904', '0', NULL, 'ANDRINO', '', '', '', '', NULL, 'S', '8', '0.00');
INSERT INTO clientes VALUES (239, 'LAVADERO VENUS', '', '', '2011-03-28 06:04:07', '0000-00-00 00:00:00', 'CRUCE GUARANI', NULL, '', '', '', '1531799-4', '', '0', NULL, '', '', '', '', '', NULL, 'S', '16', '0.00');
INSERT INTO clientes VALUES (240, 'REFRIGERACIóN CABRAL', '', '', '2011-03-28 06:17:45', '0000-00-00 00:00:00', 'CRUCE GAURANI', NULL, '', '', '(098) 3665595', '123456-6', '', '0', NULL, 'CABRAL', '', '', '', '', NULL, 'S', '16', '0.00');
INSERT INTO clientes VALUES (241, 'ALESSIA ROSA DE ANTUNES', '', '', '2011-03-28 06:18:23', '0000-00-00 00:00:00', 'KATEUTE', NULL, '', '', '', '5330980-4', '', '0', NULL, '', '', '', '', '', NULL, 'S', 'Kateu', '0.00');
INSERT INTO clientes VALUES (242, 'FOGAN ALEñO', '', '', '2011-03-28 06:19:27', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '6706512-0', '', '0', NULL, '', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (243, 'HOTEL RATINHO', '', '', '2011-03-28 06:23:15', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '6308190', '', '0', NULL, 'FLORI', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (244, 'RALLY MOTOS', '', '', '2011-03-28 06:24:13', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '5750779', '', '0', NULL, '', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (245, 'PAX PRIMAVERA', '', '', '2011-03-28 06:24:53', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '8003186-3', '', '0', NULL, '', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (246, 'SUPERMERCADO SCHIMIDT', '', '', '2011-03-28 06:25:29', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '4101848-6', '', '0', NULL, '', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (247, 'RUBEN SILVERO', '', '', '2011-03-28 06:26:12', '0000-00-00 00:00:00', 'KATEUTE', NULL, '', '', '', '1288059-0', '', '0', NULL, '', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (248, 'OSVALDO JOSE DAMASCENO', '', 'DAY COSMéTICOS', '2011-03-28 06:27:36', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(098) 3103040', '3511093-2', '', '0', NULL, 'DAIANE', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (249, 'JANETE SCHULLA', '', '', '2011-03-28 06:28:27', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '50030188-3', '', '0', NULL, 'JANETE', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (250, 'ULTRA FARMA', '', '', '2011-03-28 06:29:43', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(098) 3254160', '5004963-7', '', '0', NULL, 'JOSIANE', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (251, 'RESTAURANTE DORMITORIO DREHIER', '', '', '2011-03-28 06:31:07', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(098) 3481258', '6587567-2', '', '0', NULL, 'NEGA', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (252, 'IGLESIA EL PARAGUAI PARA CRISTO', '', '', '2011-03-28 06:32:24', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '80039270-1', '', '0', NULL, 'PASTOR LUIS', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (253, 'JOAVE ALVES LOPES', '', '', '2011-03-28 06:47:27', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '(098) 1709299', '6938199', '', '0', NULL, 'JOABE', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (254, 'KIT AMOSTRAS PARA CLIENTES', '', '', '2011-03-28 12:29:33', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '0984844312', '6538391-5', '', '0', NULL, 'SILVIA', 'JOABE', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (255, 'MANUTENCIÓN INTERNA', '', '', '2011-03-28 13:52:50', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '0984844312', '65383915', '', '0', NULL, 'SILVIA', 'JOABE', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (256, 'CANINDEYú ELETRO MOTORES', '', '', '2011-10-21 13:52:27', '0000-00-00 00:00:00', 'KATEUTE', NULL, '', '', '', '6740610-6', '', '0', NULL, 'GERSON', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (257, 'DOUGLAS DIEGO BRUN', '', '', '2011-10-21 16:58:34', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '0983246460', '123456-A', '', '0', NULL, 'DOUGLAS', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (258, 'ATZEL SA', '', '', '2011-10-21 17:26:46', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '', '80066671-2', '', '0', NULL, 'JULIANA', '', '', '', '', NULL, 'S', '9', '0.00');
INSERT INTO clientes VALUES (259, 'CLAUDETE LOPES', '', '', '2011-10-21 17:33:16', '0000-00-00 00:00:00', 'KATUETE', NULL, '', '', '0981372569', '123456-B', '', '0', NULL, 'DETE', '', '', '', '', NULL, 'S', '9', '0.00');
# --------------------------------------------------------

#
# Estrutura da tabela `compras`
#

CREATE TABLE compras (
  id_compra int(10) unsigned NOT NULL AUTO_INCREMENT,
  fornecedor_id int(10) unsigned NOT NULL,
  nm_fatura varchar(45) NOT NULL,
  dt_emissao_fatura datetime NOT NULL,
  vl_total_fatura float(8,2) NOT NULL,
  `status` varchar(1) NOT NULL,
  data_lancamento datetime NOT NULL,
  usuario_id int(10) unsigned NOT NULL,
  PRIMARY KEY (id_compra)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `compras`
#

# --------------------------------------------------------

#
# Estrutura da tabela `contas_pagar`
#

CREATE TABLE contas_pagar (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  num_fatura char(10) NOT NULL,
  fornecedor_id int(10) unsigned NOT NULL,
  dt_emissao_fatura datetime NOT NULL,
  vl_total_fatura float(8,2) NOT NULL,
  nm_total_parcela int(10) unsigned NOT NULL,
  nm_parcela varchar(10) NOT NULL,
  `status` varchar(1) NOT NULL,
  dt_pgto_parcela datetime NOT NULL,
  dt_vencimento_parcela datetime NOT NULL,
  descricao varchar(20) NOT NULL,
  vl_parcela float(8,2) NOT NULL,
  vl_pago float(8,2) NOT NULL,
  vl_juro float(8,2) NOT NULL,
  vl_multa float(8,2) NOT NULL,
  vl_desconto float(8,2) NOT NULL,
  compra_id int(10) unsigned NOT NULL,
  lanc_desp_id int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `contas_pagar`
#

INSERT INTO contas_pagar VALUES (1, '9999', 46, '2011-10-24 00:00:00', '5500.00', 0, '', 'P', '0000-00-00 00:00:00', '2011-10-24 09:59:03', '', '5500.00', '0.00', '0.00', '0.00', '0.00', 0, 8);
INSERT INTO contas_pagar VALUES (2, '99999', 46, '2011-10-24 00:00:00', '55555.55', 0, '', 'P', '0000-00-00 00:00:00', '2011-10-24 10:02:55', '', '55555.55', '0.00', '0.00', '0.00', '0.00', 0, 9);
INSERT INTO contas_pagar VALUES (3, '599999', 46, '2011-10-24 00:00:00', '555555.56', 0, '', 'P', '0000-00-00 00:00:00', '2011-10-24 10:06:13', '', '555555.56', '0.00', '0.00', '0.00', '0.00', 0, 10);
INSERT INTO contas_pagar VALUES (4, '2712', 91, '2011-10-24 00:00:00', '440000.00', 0, '', 'P', '0000-00-00 00:00:00', '2011-10-24 14:05:40', '', '440000.00', '0.00', '0.00', '0.00', '0.00', 0, 11);
INSERT INTO contas_pagar VALUES (5, '621', 37, '2011-10-25 00:00:00', '20000.00', 0, '', 'P', '0000-00-00 00:00:00', '2011-04-03 05:04:18', '', '20000.00', '0.00', '0.00', '0.00', '0.00', 0, 13);
# --------------------------------------------------------

#
# Estrutura da tabela `contas_pagarparcial`
#

CREATE TABLE contas_pagarparcial (
  idcontas_pagarParcial int(10) unsigned NOT NULL AUTO_INCREMENT,
  contas_pagar_id int(10) unsigned NOT NULL,
  valor_parcial float(8,2) NOT NULL DEFAULT '0.00',
  data_ct_parcial date NOT NULL,
  numero_recibo varchar(45) NOT NULL,
  user_id int(10) unsigned NOT NULL,
  compra_id int(10) unsigned NOT NULL,
  PRIMARY KEY (idcontas_pagarParcial)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `contas_pagarparcial`
#

# --------------------------------------------------------

#
# Estrutura da tabela `contas_receber`
#

CREATE TABLE contas_receber (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  descricao varchar(45) NOT NULL,
  vl_total float(12,2) DEFAULT NULL,
  vl_parcela float(12,2) DEFAULT NULL,
  nm_total_parcela int(10) unsigned NOT NULL,
  nm_parcela int(10) unsigned NOT NULL,
  clientes_id int(10) unsigned NOT NULL,
  venda_id int(10) unsigned NOT NULL,
  `status` varchar(1) NOT NULL,
  dt_lancamento datetime NOT NULL,
  dt_vencimento datetime NOT NULL,
  desconto float(12,2) DEFAULT NULL,
  juros float(12,2) DEFAULT NULL,
  vl_recebido float(12,2) DEFAULT NULL,
  vl_restante float(12,2) DEFAULT NULL,
  vl_multa float(12,2) DEFAULT '3.00',
  perc_juros float(12,2) DEFAULT '3.00',
  vl_ntcredito float(12,2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `contas_receber`
#

INSERT INTO contas_receber VALUES (2, '', '540000.00', '540000.00', 1, 1, 26, 2, 'A', '2011-10-21 00:00:00', '2011-11-20 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (3, '', '30000.00', '30000.00', 1, 1, 26, 3, 'A', '2011-10-21 00:00:00', '2011-11-20 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (4, '', '629000.00', '629000.00', 1, 1, 28, 5, 'A', '2011-10-21 00:00:00', '2011-11-20 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (5, '', '23000.00', '23000.00', 1, 1, 47, 7, 'A', '2011-10-21 00:00:00', '2011-11-20 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (6, '', '25000.00', '25000.00', 1, 1, 28, 11, 'A', '2011-10-24 00:00:00', '2011-11-23 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (7, '', '15000.00', '15000.00', 1, 1, 43, 12, 'A', '2011-10-24 00:00:00', '2011-11-23 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (8, '', '60000.00', '60000.00', 1, 1, 94, 14, 'A', '2011-10-25 00:00:00', '2011-11-24 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (9, '', '20000.00', '20000.00', 1, 1, 93, 15, 'A', '2011-10-25 00:00:00', '2011-11-24 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
INSERT INTO contas_receber VALUES (10, '', '70000.00', '70000.00', 1, 1, 95, 16, 'A', '2011-10-25 00:00:00', '2011-11-24 00:00:00', NULL, NULL, NULL, NULL, '3.00', '3.00', NULL);
# --------------------------------------------------------

#
# Estrutura da tabela `contas_recparcial`
#

CREATE TABLE contas_recparcial (
  contas_rec_id int(11) NOT NULL AUTO_INCREMENT,
  idctreceber int(10) unsigned NOT NULL,
  valorpg float(12,2) NOT NULL,
  datapg datetime NOT NULL,
  jurospg float(12,2) NOT NULL,
  multapg float(12,2) NOT NULL,
  usuarioid int(10) unsigned NOT NULL,
  PRIMARY KEY (contas_rec_id),
  KEY contas_rec_id (contas_rec_id)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `contas_recparcial`
#

INSERT INTO contas_recparcial VALUES (30, 4, '400000.00', '2011-10-22 10:10:07', '0.00', '0.00', 2);
INSERT INTO contas_recparcial VALUES (31, 4, '160000.00', '2011-10-22 10:32:12', '0.00', '0.00', 2);
INSERT INTO contas_recparcial VALUES (32, 1, '25000.00', '2011-10-24 07:58:29', '0.00', '0.00', 2);
# --------------------------------------------------------

#
# Estrutura da tabela `contatos`
#

CREATE TABLE contatos (
  idcontatos int(11) NOT NULL AUTO_INCREMENT,
  nomecontato varchar(50) NOT NULL,
  celcontato varchar(50) NOT NULL,
  emailcontato varchar(50) NOT NULL,
  ruccontato varchar(30) NOT NULL,
  cedulacontato varchar(30) NOT NULL,
  clienteid int(11) NOT NULL,
  dt_nasc_contato date NOT NULL,
  PRIMARY KEY (idcontatos)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `contatos`
#

# --------------------------------------------------------

#
# Estrutura da tabela `cotacao`
#

CREATE TABLE cotacao (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  controle_cli varchar(45) DEFAULT NULL,
  nome_cli varchar(45) DEFAULT NULL,
  data_car datetime DEFAULT NULL,
  total_nota float(8,2) DEFAULT NULL,
  sessao_car text,
  `status` varchar(1) DEFAULT NULL,
  situacao varchar(1) DEFAULT NULL,
  vendedor varchar(45) DEFAULT NULL,
  usuario_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `cotacao`
#

# --------------------------------------------------------

#
# Estrutura da tabela `despesa`
#

CREATE TABLE despesa (
  despesa_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  nome_despesa varchar(45) NOT NULL,
  cod_despesa varchar(10) NOT NULL,
  receita_id int(10) unsigned NOT NULL,
  PRIMARY KEY (despesa_id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `despesa`
#

INSERT INTO despesa VALUES (1, 'MATERIALES PARA ESCRITORIO', '', 2);
# --------------------------------------------------------

#
# Estrutura da tabela `entidades`
#

CREATE TABLE entidades (
  controle int(10) unsigned NOT NULL AUTO_INCREMENT,
  nome varchar(45) DEFAULT NULL,
  fantasia varchar(45) DEFAULT NULL,
  endereco varchar(45) DEFAULT NULL,
  cidade int(10) unsigned DEFAULT NULL,
  telefone1 varchar(45) DEFAULT NULL,
  telefone2 varchar(45) DEFAULT NULL,
  fax varchar(45) DEFAULT NULL,
  celular varchar(45) DEFAULT NULL,
  ruc varchar(15) DEFAULT NULL,
  cedula varchar(45) DEFAULT NULL,
  email varchar(45) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  lim_credito double DEFAULT NULL,
  desc_max float(3,2) NOT NULL,
  ativo varchar(1) NOT NULL DEFAULT 'S',
  fornecedor varchar(1) DEFAULT 'S',
  cliente varchar(1) DEFAULT 'S',
  usuario varchar(1) DEFAULT 'S',
  obs text NOT NULL,
  PRIMARY KEY (controle)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `entidades`
#

INSERT INTO entidades VALUES (16, 'SILVIA REGINA BORRI', 'SILVIA REGINA BORRI', 'CALLE LA AMISTAD', 9, '', NULL, '(047) 1234224', '(098) 4844312', '6539391-5', '6539391', 'ENG.SILVIA@TERRA.COM.BR', '2011-03-21', NULL, '1', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (17, 'RANCES SERVIçOS', 'RANCES SERVIçOS', 'KATEUTE', 0, '', NULL, '', '(098) 3490903', '123456-0', '', '', '2011-03-28', NULL, '250', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (18, 'MUNDIAL MOTOS', 'MUNDIAL MOTOS', 'KATUETE', 9, '', NULL, '', '(098) 2890783', '123456-2', '', '', '2011-03-28', NULL, '1', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (19, 'RIVERO MOTOS', 'RIVERO MOTOS', 'KATEUTE', 9, '', NULL, '', '(098) 3320963', '123456-1', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (20, 'LAVADOR SANTA LIBRADA', 'LAVADOR SANTA LIBRADA', 'KATUETE', 9, '', NULL, '', '(098) 3123183', '123456-3', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (21, 'FRANCISCO MARTINEZ - LAVADOR', 'FRANCISCO MARTINEZ - LAVADOR', 'KATUETE', 9, '', NULL, '', '(097) 3734431', '123456-4', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (22, 'LAVADOR BRASPAR', 'LAVADOR BRASPAR', 'KATEUTE', 9, '', NULL, '', '(098) 5945086', '123456-5', '', '', '2011-03-28', NULL, '1', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (23, 'LAVANDERIA LUANA', 'LAVANDERIA LUANA', 'KATUETE', 9, '', NULL, '', '', '2193805-9', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (24, 'SUPERMERCADO ELENINHA', 'SUPERMERCADO ELENINHA', 'CRUCE GUARANI', 16, '', NULL, '', '(098) 3626332', '50030586-2', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (25, 'ELAINE SCHANAIDER DE BORTOLOSSI', 'ELAINE SCHANAIDER DE BORTOLOSSI', 'KATUETE', 9, '', NULL, '', '(098) 3606449', '2351829-4', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (26, 'ANDRINO RODRIGUES DOS SANTOS', 'ANDRINO RODRIGUES DOS SANTOS', 'NUEVA ESPERANZA', 8, '', NULL, '', '', '', '6348904', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (27, 'LAVADERO VENUS', 'LAVADERO VENUS', 'CRUCE GUARANI', 16, '', NULL, '', '', '1531799-4', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (28, 'REFRIGERACI�N CABRAL', 'REFRIGERACIóN CABRAL', 'CRUCE GAURANI', 0, '(098) 3665595', NULL, '', '(098) 3665595', '123456-6', '', '', '2011-03-28', NULL, '0', '0.00', '', '', '', '', '');
INSERT INTO entidades VALUES (29, 'ALESSIA ROSA DE ANTUNES', 'ALESSIA ROSA DE ANTUNES', 'KATEUTE', 0, '', NULL, '', '', '5330980-4', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (30, 'FOGAN ALEñO', 'FOGAN ALEñO', 'KATUETE', 9, '', NULL, '', '', '6706512-0', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (31, 'HOTEL RATINHO', 'HOTEL RATINHO', 'KATUETE', 9, '', NULL, '', '', '6308190', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (32, 'RALLY MOTOS', 'RALLY MOTOS', 'KATUETE', 9, '', NULL, '', '', '5750779', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (33, 'PAX PRIMAVERA', 'PAX PRIMAVERA', 'KATUETE', 9, '', NULL, '', '', '8003186-3', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (34, 'SUPERMERCADO SCHIMIDT', 'SUPERMERCADO SCHIMIDT', 'KATUETE', 9, '', NULL, '', '', '4101848-6', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (35, 'RUBEN SILVERO', 'RUBEN SILVERO', 'KATEUTE', 9, '', NULL, '', '', '1288059-0', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (36, 'OSVALDO JOSE DAMASCENO', 'OSVALDO JOSE DAMASCENO', 'KATUETE', 9, '', NULL, '', '(098) 3103040', '3511093-2', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (37, 'JANETE SCHULLA', 'JANETE SCHULLA', 'KATUETE', 9, '', NULL, '', '', '50030188-3', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (38, 'ULTRA FARMA', 'ULTRA FARMA', 'KATUETE', 9, '', NULL, '', '(098) 3254160', '5004963-7', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (39, 'RESTAURANTE DORMITORIO DREHIER', 'RESTAURANTE DORMITORIO DREHIER', 'KATUETE', 9, '', NULL, '', '(098) 3481258', '6587567-2', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (40, 'IGLESIA EL PARAGUAI PARA CRISTO', 'IGLESIA EL PARAGUAI PARA CRISTO', 'KATUETE', 9, '', NULL, '', '', '80039270-1', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (41, 'JOAVE ALVES LOPES', 'JOAVE ALVES LOPES', 'KATUETE', 9, '', NULL, '', '(098) 1709299', '6938199', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (42, 'KIT AMOSTRAS PARA CLIENTES', 'KIT AMOSTRAS PARA CLIENTES', 'KATUETE', 9, '', NULL, '', '0984844312', '6538391-5', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (43, 'MANUTENCIÓN INTERNA', 'MANUTENCIÓN INTERNA', 'KATUETE', 9, '', NULL, '', '0984844312', '65383915', '', '', '2011-03-28', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (44, 'CANINDEYú ELETRO MOTORES', 'CANINDEYú ELETRO MOTORES', 'KATEUTE', 9, '', NULL, '', '', '6740610-6', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (45, 'DOUGLAS DIEGO BRUN', 'DOUGLAS DIEGO BRUN', 'KATUETE', 9, '', NULL, '', '0983246460', '123456-A', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (46, 'ATZEL SA', 'ATZEL SA', 'KATUETE', 9, '', NULL, '', '', '80066671-2', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (47, 'CLAUDETE LOPES', 'CLAUDETE LOPES', 'KATUETE', 9, '', NULL, '', '0981372569', '123456-B', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (48, 'Admin', 'Admin', '', 0, '', NULL, '', '', '', '', '', '2008-01-27', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidades VALUES (88, 'CONSUMIDOR FINAL', 'CONSUMIDOR FINAL', 'KATUETE', 9, '', NULL, '', '', '101010-1', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidades VALUES (89, 'SUPERMERCAO PLUMA', 'SUPERMERCAO PLUMA', 'KATUETE', 9, '', NULL, '', '0471234010', '2489759-0', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidades VALUES (90, 'PAPELARIA ARTPEL', 'PAPELARIA ARTPEL', 'KATUETE', 9, '(0983) 406 689', '', '', '(0983) 406 689', '50028546-2', '', '', '2011-10-24', '2', '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidades VALUES (91, 'CANTERA HERMES S.R.L', 'CANTERA HERMES S.R.L', 'KATUETE', 9, '', NULL, '', '(0983) 570 112', '123456-C', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidades VALUES (92, 'VENDAS EXTERNAS - JOABE ALVES LOPES', 'VENDAS EXTERNAS - JOABE ALVES LOPES', 'KATUETE', 9, '', NULL, '', '(0981) 709 299', '6538391-X', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidades VALUES (93, 'ANDR�IA FONSECA', 'ANDR�IA FONSECA', 'KATUETE', 9, '', NULL, '', '(0982) 153 085', '6077888', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidades VALUES (94, 'ADERBAL DE BORBA', 'ADERBAL DE BORBA', 'IBEL PARAGUAIA', 9, '', NULL, '', '(0983) 847 261', '123456-D', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidades VALUES (95, 'IVONE GON�ALVES DA ROCHA', 'IVONE GON�ALVES DA ROCHA', 'IBEL PARAGUAIA', 9, '', NULL, '', '', '123456-E', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
# --------------------------------------------------------

#
# Estrutura da tabela `entidadesb`
#

CREATE TABLE entidadesb (
  controle int(10) unsigned NOT NULL AUTO_INCREMENT,
  nome varchar(45) DEFAULT NULL,
  fantasia varchar(45) DEFAULT NULL,
  endereco varchar(45) DEFAULT NULL,
  cidade int(10) unsigned DEFAULT NULL,
  telefone1 varchar(45) DEFAULT NULL,
  telefone2 varchar(45) DEFAULT NULL,
  fax varchar(45) DEFAULT NULL,
  celular varchar(45) DEFAULT NULL,
  ruc varchar(15) DEFAULT NULL,
  cedula varchar(45) DEFAULT NULL,
  email varchar(45) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  lim_credito double DEFAULT NULL,
  desc_max float(3,2) NOT NULL,
  ativo varchar(1) NOT NULL DEFAULT 'S',
  fornecedor varchar(1) DEFAULT 'S',
  cliente varchar(1) DEFAULT 'S',
  usuario varchar(1) DEFAULT 'S',
  obs text NOT NULL,
  PRIMARY KEY (controle)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `entidadesb`
#

INSERT INTO entidadesb VALUES (16, 'SILVIA REGINA BORRI', 'SILVIA REGINA BORRI', 'CALLE LA AMISTAD', 9, '', NULL, '(047) 1234224', '(098) 4844312', '6539391-5', '6539391', 'ENG.SILVIA@TERRA.COM.BR', '2011-03-21', NULL, '1', '0.00', 'S', '', '', '', '');
INSERT INTO entidadesb VALUES (44, 'CANINDEYú ELETRO MOTORES', 'CANINDEYú ELETRO MOTORES', 'KATEUTE', 9, '', NULL, '', '', '6740610-6', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidadesb VALUES (45, 'DOUGLAS DIEGO BRUN', 'DOUGLAS DIEGO BRUN', 'KATUETE', 9, '', NULL, '', '0983246460', '123456-A', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidadesb VALUES (46, 'ATZEL SA', 'ATZEL SA', 'KATUETE', 9, '', NULL, '', '', '80066671-2', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidadesb VALUES (47, 'CLAUDETE LOPES', 'CLAUDETE LOPES', 'KATUETE', 9, '', NULL, '', '0981372569', '123456-B', '', '', '2011-10-21', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidadesb VALUES (48, 'Admin', 'Admin', '', 0, '', NULL, '', '', '', '', '', '2008-01-27', NULL, '0', '0.00', 'S', '', '', '', '');
INSERT INTO entidadesb VALUES (80, 'CANINDEYú ELETRO MOTORES', 'CANINDEYú ELETRO MOTORES', 'KATEUTE', 9, '', NULL, '', '', '6740610-6', '', '', '2011-10-21', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidadesb VALUES (81, 'DOUGLAS DIEGO BRUN', 'DOUGLAS DIEGO BRUN', 'KATUETE', 9, '', NULL, '', '0983246460', '123456-A', '', '', '2011-10-21', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidadesb VALUES (82, 'ATZEL SA', 'ATZEL SA', 'KATUETE', 9, '', NULL, '', '', '80066671-2', '', '', '2011-10-21', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidadesb VALUES (83, 'CLAUDETE LOPES', 'CLAUDETE LOPES', 'KATUETE', 9, '', NULL, '', '0981372569', '123456-B', '', '', '2011-10-21', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidadesb VALUES (88, 'CONSUMIDOR FINAL', 'CONSUMIDOR FINAL', 'KATUETE', 9, '', NULL, '', '', '101010-1', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidadesb VALUES (89, 'SUPERMERCAO PLUMA', 'SUPERMERCAO PLUMA', 'KATUETE', 9, '', NULL, '', '0471234010', '2489759-0', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
INSERT INTO entidadesb VALUES (90, 'TRIAGRIL S.R.L', 'TRIAGRIL S.R.L', 'KATUETE', 9, '', NULL, '(0471) 234 121', '(0471) 234 120', '80024399-4', '', '', '2011-10-24', NULL, '0', '0.00', 'S', 'S', 'S', 'S', '');
# --------------------------------------------------------

#
# Estrutura da tabela `forma_pagamento`
#

CREATE TABLE forma_pagamento (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  descricao varchar(45) NOT NULL,
  nm_total_parcela int(10) unsigned NOT NULL,
  nm_intervalo_parcela varchar(45) NOT NULL,
  ck_entrada varchar(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `forma_pagamento`
#

INSERT INTO forma_pagamento VALUES (1, 'A VISTA', 0, '0', '0');
INSERT INTO forma_pagamento VALUES (2, '30 DIAS', 1, '30', '0');
INSERT INTO forma_pagamento VALUES (3, '1+30', 1, '30', '1');
INSERT INTO forma_pagamento VALUES (4, '1+30+60', 2, '30', '1');
# --------------------------------------------------------

#
# Estrutura da tabela `fornecedor`
#

CREATE TABLE fornecedor (
  Codigo int(10) unsigned NOT NULL AUTO_INCREMENT,
  Nome varchar(50) NOT NULL,
  Fantasia varchar(50) NOT NULL,
  Endereco varchar(40) NOT NULL,
  Bairro varchar(30) NOT NULL,
  Cidade varchar(3) NOT NULL,
  Cep varchar(8) NOT NULL,
  DDD varchar(3) NOT NULL,
  Telefone varchar(15) NOT NULL,
  Fax varchar(15) NOT NULL,
  CGC varchar(14) NOT NULL,
  CPF varchar(11) NOT NULL,
  IE varchar(15) NOT NULL,
  RG varchar(15) NOT NULL,
  Contato varchar(40) NOT NULL,
  Estado varchar(2) NOT NULL,
  Data_Cadastro datetime NOT NULL,
  Fisica_Juridico varchar(1) NOT NULL,
  Complemento varchar(40) NOT NULL,
  Local_Trabalho varchar(40) NOT NULL,
  DDD_Comercial varchar(3) NOT NULL,
  Telefone_Comercial varchar(15) NOT NULL,
  Data_Nascimento datetime NOT NULL,
  Observacoes longtext NOT NULL,
  E_Mail varchar(60) NOT NULL,
  Site varchar(60) NOT NULL,
  PRIMARY KEY (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `fornecedor`
#

# --------------------------------------------------------

#
# Estrutura da tabela `grupos`
#

CREATE TABLE grupos (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  nom_grupo varchar(45) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `grupos`
#

INSERT INTO grupos VALUES (1, 'LINHA PROFESIONAL', '2011-03-21 04:07:09');
INSERT INTO grupos VALUES (2, 'LINHA CONSUMO', '2011-03-21 04:07:20');
INSERT INTO grupos VALUES (3, 'LINHA HOSPITALAR', '2011-03-21 04:07:33');
INSERT INTO grupos VALUES (4, 'LINHA TESTES', '2011-03-21 04:07:47');
INSERT INTO grupos VALUES (5, 'LINHA AUTOMOTIVA', '2011-03-21 04:07:59');
# --------------------------------------------------------

#
# Estrutura da tabela `imposto`
#

CREATE TABLE imposto (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  descricao varchar(45) NOT NULL,
  iva double NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `imposto`
#

# --------------------------------------------------------

#
# Estrutura da tabela `itens_compra`
#

CREATE TABLE itens_compra (
  compra_id int(10) unsigned NOT NULL,
  referencia_prod varchar(20) NOT NULL,
  descricao_prod varchar(45) NOT NULL,
  prcompra float(8,2) NOT NULL,
  qtd_produto float(8,2) unsigned DEFAULT NULL,
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `itens_compra`
#

# --------------------------------------------------------

#
# Estrutura da tabela `itens_cotacao`
#

CREATE TABLE itens_cotacao (
  id_cotacao int(10) unsigned DEFAULT NULL,
  referencia_prod varchar(45) NOT NULL,
  descricao_prod varchar(45) NOT NULL,
  prvenda float(8,2) NOT NULL,
  qtd_produto float(8,2) unsigned DEFAULT NULL,
  sessao text NOT NULL,
  id int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `itens_cotacao`
#

# --------------------------------------------------------

#
# Estrutura da tabela `itens_ntcredito`
#

CREATE TABLE itens_ntcredito (
  iditens_ntcredito int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_credito int(10) unsigned NOT NULL,
  idproduto int(10) unsigned NOT NULL,
  referenciaprod varchar(45) NOT NULL,
  descricaoprod varchar(45) NOT NULL,
  vliten float(8,2) NOT NULL,
  qtdproduto float(8,2) NOT NULL,
  PRIMARY KEY (iditens_ntcredito)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `itens_ntcredito`
#

# --------------------------------------------------------

#
# Estrutura da tabela `itens_ntcreditom`
#

CREATE TABLE itens_ntcreditom (
  iditens_ntcredito int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_credito int(10) unsigned NOT NULL,
  idproduto int(10) unsigned NOT NULL,
  referenciaprod varchar(45) NOT NULL,
  descricaoprod varchar(45) NOT NULL,
  vliten float(8,2) NOT NULL,
  qtdproduto float(8,2) NOT NULL,
  PRIMARY KEY (iditens_ntcredito)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `itens_ntcreditom`
#

# --------------------------------------------------------

#
# Estrutura da tabela `itens_pedido`
#

CREATE TABLE itens_pedido (
  id_pedido int(11) DEFAULT NULL,
  referencia_prod varchar(255) DEFAULT NULL,
  descricao_prod varchar(255) DEFAULT NULL,
  prvenda float(8,2) DEFAULT NULL,
  qtd_produto float(8,2) DEFAULT NULL,
  sessao varchar(255) DEFAULT NULL,
  id int(11) NOT NULL AUTO_INCREMENT,
  id_prod int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=49728 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `itens_pedido`
#

INSERT INTO itens_pedido VALUES (1, '200', 'SUAVIZANTE BABY', '14250.00', '1.00', NULL, 49674, 2);
INSERT INTO itens_pedido VALUES (5, '201', 'SUAVIZANTE SOFT', '14250.00', '1.00', NULL, 49675, 3);
INSERT INTO itens_pedido VALUES (6, '100', 'LAVANDINA', '14250.00', '1.00', NULL, 49676, 1);
INSERT INTO itens_pedido VALUES (7, '100', 'LAVANDINA', '14250.00', '2.00', NULL, 49677, 1);
INSERT INTO itens_pedido VALUES (8, '1', 'JABON EN PAN', '6000.00', '15.00', NULL, 49678, 27);
INSERT INTO itens_pedido VALUES (26, '400', 'DETERTEQ NEUTRO', '20000.00', '1.00', NULL, 49721, 6);
INSERT INTO itens_pedido VALUES (10, '100', 'LAVANDINA', '15000.00', '1.00', NULL, 49680, 1);
INSERT INTO itens_pedido VALUES (11, '1T', 'JABON EN PAN - TESTES', '6000.00', '10.00', NULL, 49681, 27);
INSERT INTO itens_pedido VALUES (11, '300', 'DESINFETANTE EUCALIPTO', '20000.00', '6.00', NULL, 49682, 4);
INSERT INTO itens_pedido VALUES (11, '301', 'DESINFETANTE FLORAL', '20000.00', '6.00', NULL, 49683, 5);
INSERT INTO itens_pedido VALUES (11, '201', 'SUAVIZANTE SOFT', '20000.00', '12.00', NULL, 49684, 3);
INSERT INTO itens_pedido VALUES (12, '1T', 'JABON EN PAN - TESTES', '6000.00', '10.00', NULL, 49685, 27);
INSERT INTO itens_pedido VALUES (12, '300', 'DESINFETANTE EUCALIPTO', '20000.00', '6.00', NULL, 49686, 4);
INSERT INTO itens_pedido VALUES (12, '301', 'DESINFETANTE FLORAL', '20000.00', '6.00', NULL, 49687, 5);
INSERT INTO itens_pedido VALUES (12, '201', 'SUAVIZANTE SOFT', '20000.00', '12.00', NULL, 49688, 3);
INSERT INTO itens_pedido VALUES (13, '2T', 'JABON SOBRANTE - TESTES', '6000.00', '5.00', NULL, 49689, 28);
INSERT INTO itens_pedido VALUES (14, '200', 'SUAVIZANTE BABY', '20000.00', '1.00', NULL, 49690, 2);
INSERT INTO itens_pedido VALUES (15, '1T', 'JABON EN PAN - TESTES', '6000.00', '2.00', NULL, 49691, 27);
INSERT INTO itens_pedido VALUES (15, '601', 'DETERTEQ 500', '25000.00', '1.00', NULL, 49692, 12);
INSERT INTO itens_pedido VALUES (15, '300', 'DESINFETANTE EUCALIPTO', '20000.00', '1.00', NULL, 49693, 4);
INSERT INTO itens_pedido VALUES (15, '201', 'SUAVIZANTE SOFT', '20000.00', '1.00', NULL, 49694, 3);
INSERT INTO itens_pedido VALUES (16, '1004', 'AUTOLOPS 5 LITROS', '25000.00', '1.00', NULL, 49695, 19);
INSERT INTO itens_pedido VALUES (16, '201', 'SUAVIZANTE SOFT', '20000.00', '1.00', NULL, 49696, 3);
INSERT INTO itens_pedido VALUES (17, '300', 'DESINFETANTE EUCALIPTO', '17000.00', '3.00', NULL, 49697, 4);
INSERT INTO itens_pedido VALUES (17, '302', 'DESINFETANTE LAVANDA', '17000.00', '3.00', NULL, 49698, 31);
INSERT INTO itens_pedido VALUES (17, '300', 'DESINFETANTE EUCALIPTO', '17000.00', '3.00', NULL, 49699, 4);
INSERT INTO itens_pedido VALUES (17, '301', 'DESINFETANTE FLORAL', '17000.00', '3.00', NULL, 49700, 5);
INSERT INTO itens_pedido VALUES (17, '401', 'DETERTEQ LIM�N', '17000.00', '5.00', NULL, 49701, 7);
INSERT INTO itens_pedido VALUES (17, '402', 'DETERTEQ NARANJA', '17000.00', '5.00', NULL, 49702, 8);
INSERT INTO itens_pedido VALUES (17, '1000', 'AUTOCAP 5 LITROS', '25500.00', '10.00', NULL, 49703, 15);
INSERT INTO itens_pedido VALUES (18, '402', 'DETERTEQ NARANJA', '19000.00', '1.00', NULL, 49704, 8);
INSERT INTO itens_pedido VALUES (18, '401', 'DETERTEQ LIM�N', '19000.00', '1.00', NULL, 49705, 7);
INSERT INTO itens_pedido VALUES (18, '400', 'DETERTEQ NEUTRO', '19000.00', '1.00', NULL, 49706, 6);
INSERT INTO itens_pedido VALUES (18, '302', 'DESINFETANTE LAVANDA', '19000.00', '3.00', NULL, 49707, 31);
INSERT INTO itens_pedido VALUES (18, '301', 'DESINFETANTE FLORAL', '19000.00', '3.00', NULL, 49708, 5);
INSERT INTO itens_pedido VALUES (18, '300', 'DESINFETANTE EUCALIPTO', '19000.00', '3.00', NULL, 49709, 4);
INSERT INTO itens_pedido VALUES (18, '100', 'LAVANDINA', '15000.00', '3.00', NULL, 49710, 1);
INSERT INTO itens_pedido VALUES (19, '201', 'SUAVIZANTE SOFT', '15000.00', '2.00', NULL, 49711, 3);
INSERT INTO itens_pedido VALUES (20, '3T', 'SUAVIZANTES - TESTES', '8000.00', '1.00', NULL, 49712, 29);
INSERT INTO itens_pedido VALUES (20, '100', 'LAVANDINA', '15000.00', '1.00', NULL, 49713, 1);
INSERT INTO itens_pedido VALUES (21, '1001', 'AUTOCAP 20 LITROS', '100000.00', '1.00', NULL, 49714, 16);
INSERT INTO itens_pedido VALUES (21, '1000', 'AUTOCAP 5 LITROS', '25000.00', '5.00', NULL, 49715, 15);
INSERT INTO itens_pedido VALUES (22, '1000', 'AUTOCAP 5 LITROS', '25000.00', '1.00', NULL, 49716, 15);
INSERT INTO itens_pedido VALUES (23, '1000', 'AUTOCAP 5 LITROS', '25000.00', '1.00', NULL, 49717, 15);
INSERT INTO itens_pedido VALUES (24, '1004', 'AUTOLOPS 5 LITROS', '25000.00', '1.00', NULL, 49718, 19);
INSERT INTO itens_pedido VALUES (25, '1000', 'AUTOCAP 5 LITROS', '25000.00', '1.00', NULL, 49719, 15);
INSERT INTO itens_pedido VALUES (25, '1004', 'AUTOLOPS 5 LITROS', '25000.00', '1.00', NULL, 49720, 19);
INSERT INTO itens_pedido VALUES (27, '302', 'DESINFETANTE LAVANDA', '20000.00', '1.00', NULL, 49722, 31);
INSERT INTO itens_pedido VALUES (28, '800', 'KIT DE LIMPEZA', '60000.00', '1.00', NULL, 49723, 32);
INSERT INTO itens_pedido VALUES (29, '302', 'DESINFETANTE LAVANDA', '20000.00', '1.00', NULL, 49724, 31);
INSERT INTO itens_pedido VALUES (30, '1T', 'JABON EN PAN - TESTES', '5000.00', '2.00', NULL, 49725, 27);
INSERT INTO itens_pedido VALUES (30, '800', 'KIT DE LIMPEZA', '60000.00', '1.00', NULL, 49726, 32);
INSERT INTO itens_pedido VALUES (31, '400', 'DETERTEQ NEUTRO', '20000.00', '1.00', NULL, 49727, 6);
# --------------------------------------------------------

#
# Estrutura da tabela `itens_pendencias`
#

CREATE TABLE itens_pendencias (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  pendencias_id int(10) unsigned NOT NULL,
  produtos_codigo int(10) unsigned NOT NULL,
  qtd float(8,2) unsigned DEFAULT NULL,
  vl_preco float(8,2) NOT NULL,
  st_item_pendencia varchar(1) NOT NULL,
  dt_item datetime NOT NULL,
  qtd_estoque float(8,2) unsigned DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `itens_pendencias`
#

# --------------------------------------------------------

#
# Estrutura da tabela `itens_venda`
#

CREATE TABLE itens_venda (
  id_venda int(11) NOT NULL,
  referencia_prod varchar(45) NOT NULL,
  descricao_prod varchar(45) NOT NULL,
  prvenda float(8,2) NOT NULL,
  qtd_produto float(8,2) unsigned DEFAULT NULL,
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  idproduto int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `itens_venda`
#

INSERT INTO itens_venda VALUES (2, '1T', 'JABON EN PAN - TESTES', '6000.00', '10.00', 2, 27);
INSERT INTO itens_venda VALUES (2, '300', 'DESINFETANTE EUCALIPTO', '20000.00', '6.00', 3, 4);
INSERT INTO itens_venda VALUES (2, '301', 'DESINFETANTE FLORAL', '20000.00', '6.00', 4, 5);
INSERT INTO itens_venda VALUES (2, '201', 'SUAVIZANTE SOFT', '20000.00', '12.00', 5, 3);
INSERT INTO itens_venda VALUES (3, '2T', 'JABON SOBRANTE - TESTES', '6000.00', '5.00', 6, 28);
INSERT INTO itens_venda VALUES (4, '1T', 'JABON EN PAN - TESTES', '6000.00', '2.00', 7, 27);
INSERT INTO itens_venda VALUES (4, '601', 'DETERTEQ 500', '25000.00', '1.00', 8, 12);
INSERT INTO itens_venda VALUES (4, '300', 'DESINFETANTE EUCALIPTO', '20000.00', '1.00', 9, 4);
INSERT INTO itens_venda VALUES (4, '201', 'SUAVIZANTE SOFT', '20000.00', '1.00', 10, 3);
INSERT INTO itens_venda VALUES (5, '300', 'DESINFETANTE EUCALIPTO', '17000.00', '3.00', 11, 4);
INSERT INTO itens_venda VALUES (5, '302', 'DESINFETANTE LAVANDA', '17000.00', '3.00', 12, 31);
INSERT INTO itens_venda VALUES (5, '300', 'DESINFETANTE EUCALIPTO', '17000.00', '3.00', 13, 4);
INSERT INTO itens_venda VALUES (5, '301', 'DESINFETANTE FLORAL', '17000.00', '3.00', 14, 5);
INSERT INTO itens_venda VALUES (5, '401', 'DETERTEQ LIM�N', '17000.00', '5.00', 15, 7);
INSERT INTO itens_venda VALUES (5, '402', 'DETERTEQ NARANJA', '17000.00', '5.00', 16, 8);
INSERT INTO itens_venda VALUES (5, '1000', 'AUTOCAP 5 LITROS', '25500.00', '10.00', 17, 15);
INSERT INTO itens_venda VALUES (6, '1004', 'AUTOLOPS 5 LITROS', '25000.00', '1.00', 18, 19);
INSERT INTO itens_venda VALUES (6, '201', 'SUAVIZANTE SOFT', '20000.00', '1.00', 19, 3);
INSERT INTO itens_venda VALUES (7, '3T', 'SUAVIZANTES - TESTES', '8000.00', '1.00', 20, 29);
INSERT INTO itens_venda VALUES (7, '100', 'LAVANDINA', '15000.00', '1.00', 21, 1);
INSERT INTO itens_venda VALUES (8, '201', 'SUAVIZANTE SOFT', '15000.00', '2.00', 22, 3);
INSERT INTO itens_venda VALUES (9, '402', 'DETERTEQ NARANJA', '19000.00', '1.00', 23, 8);
INSERT INTO itens_venda VALUES (9, '401', 'DETERTEQ LIM�N', '19000.00', '1.00', 24, 7);
INSERT INTO itens_venda VALUES (9, '400', 'DETERTEQ NEUTRO', '19000.00', '1.00', 25, 6);
INSERT INTO itens_venda VALUES (9, '302', 'DESINFETANTE LAVANDA', '19000.00', '3.00', 26, 31);
INSERT INTO itens_venda VALUES (9, '301', 'DESINFETANTE FLORAL', '19000.00', '3.00', 27, 5);
INSERT INTO itens_venda VALUES (9, '300', 'DESINFETANTE EUCALIPTO', '19000.00', '3.00', 28, 4);
INSERT INTO itens_venda VALUES (9, '100', 'LAVANDINA', '15000.00', '3.00', 29, 1);
INSERT INTO itens_venda VALUES (10, '1000', 'AUTOCAP 5 LITROS', '25000.00', '1.00', 30, 15);
INSERT INTO itens_venda VALUES (10, '1004', 'AUTOLOPS 5 LITROS', '25000.00', '1.00', 31, 19);
INSERT INTO itens_venda VALUES (11, '1004', 'AUTOLOPS 5 LITROS', '25000.00', '1.00', 32, 19);
INSERT INTO itens_venda VALUES (12, '100', 'LAVANDINA', '15000.00', '1.00', 33, 1);
INSERT INTO itens_venda VALUES (13, '400', 'DETERTEQ NEUTRO', '20000.00', '1.00', 34, 6);
INSERT INTO itens_venda VALUES (14, '800', 'KIT DE LIMPEZA', '60000.00', '1.00', 35, 32);
INSERT INTO itens_venda VALUES (15, '302', 'DESINFETANTE LAVANDA', '20000.00', '1.00', 36, 31);
INSERT INTO itens_venda VALUES (16, '1T', 'JABON EN PAN - TESTES', '5000.00', '2.00', 37, 27);
INSERT INTO itens_venda VALUES (16, '800', 'KIT DE LIMPEZA', '60000.00', '1.00', 38, 32);
# --------------------------------------------------------

#
# Estrutura da tabela `lanc_contas`
#

CREATE TABLE lanc_contas (
  id_lanc_despesa int(10) unsigned NOT NULL AUTO_INCREMENT,
  plano_id int(10) unsigned NOT NULL,
  plan_codigo varchar(20) NOT NULL,
  documento varchar(45) NOT NULL,
  dt_lanc_desp datetime NOT NULL,
  venc_desp datetime NOT NULL,
  desc_desp varchar(45) NOT NULL,
  valor float(12,2) DEFAULT NULL,
  usuario_id int(10) unsigned NOT NULL,
  receita_id int(10) unsigned NOT NULL,
  dt_fatura_desp datetime NOT NULL,
  nm_total_parcela int(11) NOT NULL,
  nm_parcela varchar(10) NOT NULL,
  entidade_id int(11) NOT NULL,
  valor_total float(12,2) DEFAULT NULL,
  caixaid int(10) unsigned NOT NULL,
  PRIMARY KEY (id_lanc_despesa)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `lanc_contas`
#

INSERT INTO lanc_contas VALUES (1, 24, '1.01.01.00.000.00', '', '2011-10-21 17:09:08', '0000-00-00 00:00:00', 'Venta Contado', '45000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 257, '45000.00', 1);
INSERT INTO lanc_contas VALUES (2, 24, '1.01.01.00.000.00', '', '2011-10-21 17:35:07', '0000-00-00 00:00:00', 'Venta Contado', '30000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 249, '30000.00', 2);
INSERT INTO lanc_contas VALUES (3, 24, '1.01.01.00.000.00', '', '2011-10-21 17:35:16', '0000-00-00 00:00:00', 'Venta Contado', '273000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 258, '273000.00', 3);
INSERT INTO lanc_contas VALUES (4, 25, '1.01.02.00.000.00', '', '2011-10-22 10:10:07', '0000-00-00 00:00:00', 'Recibimiento de Cuentas', '400000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 28, '400000.00', 4);
INSERT INTO lanc_contas VALUES (5, 25, '1.01.02.00.000.00', '', '2011-10-22 10:32:12', '0000-00-00 00:00:00', 'Recibimiento de Cuentas', '160000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 28, '160000.00', 5);
INSERT INTO lanc_contas VALUES (6, 25, '1.01.02.00.000.00', '', '2011-10-24 07:58:29', '0000-00-00 00:00:00', 'Recibimiento de Cuentas', '25000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 28, '25000.00', 6);
INSERT INTO lanc_contas VALUES (7, 24, '1.01.01.00.000.00', '', '2011-10-24 09:22:09', '0000-00-00 00:00:00', 'Venta Contado', '50000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 88, '50000.00', 7);
INSERT INTO lanc_contas VALUES (11, 149, '2.02.01.00.000.00', '2712', '2011-10-24 14:05:40', '2011-10-24 14:05:40', 'BRITA - FUNDOS DA INDUSTRIA', '440000.00', 2, 2, '2011-10-24 00:00:00', 1, '1', 91, '440000.00', 0);
INSERT INTO lanc_contas VALUES (12, 24, '1.01.01.00.000.00', '', '2011-04-03 04:54:56', '0000-00-00 00:00:00', 'Venta Contado', '20000.00', 2, 1, '0000-00-00 00:00:00', 0, '', 91, '20000.00', 8);
INSERT INTO lanc_contas VALUES (13, 52, '2.01.01.06.000.00', '621', '2011-04-03 05:04:18', '2011-04-03 05:04:18', 'CAF� DA MANH� EMPRESA', '20000.00', 2, 2, '2011-10-25 00:00:00', 1, '1', 37, '20000.00', 0);
# --------------------------------------------------------

#
# Estrutura da tabela `lanc_despesa`
#

CREATE TABLE lanc_despesa (
  id_lanc_despesa int(10) unsigned NOT NULL AUTO_INCREMENT,
  despesa_id int(10) unsigned NOT NULL,
  documento varchar(45) NOT NULL,
  dt_lanc_desp datetime NOT NULL,
  venc_desp datetime NOT NULL,
  desc_desp varchar(45) NOT NULL,
  valor float(8,2) NOT NULL,
  usuario_id int(10) unsigned NOT NULL,
  receita_id int(10) unsigned NOT NULL,
  dt_fatura_desp datetime NOT NULL,
  nm_total_parcela int(11) NOT NULL,
  nm_parcela varchar(10) NOT NULL,
  forn_id int(11) NOT NULL,
  valor_total float(8,2) NOT NULL,
  PRIMARY KEY (id_lanc_despesa)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `lanc_despesa`
#

# --------------------------------------------------------

#
# Estrutura da tabela `lancamento_caixa`
#

CREATE TABLE lancamento_caixa (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  receita_id int(10) unsigned NOT NULL,
  caixa_id int(10) unsigned NOT NULL,
  data_lancamento datetime NOT NULL,
  num_nota varchar(45) NOT NULL,
  despesa_cod int(11) NOT NULL,
  venda_id int(10) unsigned NOT NULL,
  conta_receber_id int(10) unsigned NOT NULL,
  contas_pagar_id int(10) unsigned NOT NULL,
  valor float(8,2) DEFAULT NULL,
  caixa_balcao_id int(10) DEFAULT NULL,
  fornecedor_id int(11) NOT NULL,
  lanc_despesa_id int(11) NOT NULL,
  historico varchar(20) NOT NULL,
  contaid int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `lancamento_caixa`
#

INSERT INTO lancamento_caixa VALUES (2, 2, 1, '2011-10-24 14:05:40', '2712', 202, 0, 0, 4, '440000.00', NULL, 91, 11, 'Brita - Fundos da In', 149);
INSERT INTO lancamento_caixa VALUES (3, 2, 1, '2011-04-03 05:04:18', '621', 201, 0, 0, 5, '20000.00', NULL, 37, 13, 'Caf� da Manh� Empres', 52);
# --------------------------------------------------------

#
# Estrutura da tabela `lancamento_caixa_balcao`
#

CREATE TABLE lancamento_caixa_balcao (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  receita_id int(10) unsigned NOT NULL,
  caixa_id int(10) unsigned NOT NULL,
  dt_lancamento datetime NOT NULL,
  descricao varchar(45) NOT NULL,
  vl_pago float(8,2) NOT NULL,
  venda_id int(10) unsigned NOT NULL,
  contas_receber_id int(11) NOT NULL,
  contas_pagar_id int(10) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `lancamento_caixa_balcao`
#

INSERT INTO lancamento_caixa_balcao VALUES (1, 1, 1, '2011-10-21 17:09:08', '', '45000.00', 6, 0, 0);
INSERT INTO lancamento_caixa_balcao VALUES (2, 1, 1, '2011-10-21 17:35:07', '', '30000.00', 8, 0, 0);
INSERT INTO lancamento_caixa_balcao VALUES (3, 1, 1, '2011-10-21 17:35:16', '', '273000.00', 9, 0, 0);
INSERT INTO lancamento_caixa_balcao VALUES (4, 1, 1, '2011-10-22 10:10:07', '', '400000.00', 5, 4, 0);
INSERT INTO lancamento_caixa_balcao VALUES (5, 1, 1, '2011-10-22 10:32:12', '', '160000.00', 5, 4, 0);
INSERT INTO lancamento_caixa_balcao VALUES (7, 1, 1, '2011-10-24 09:22:09', '', '50000.00', 10, 0, 0);
INSERT INTO lancamento_caixa_balcao VALUES (8, 1, 1, '2011-04-03 04:54:56', '', '20000.00', 13, 0, 0);
# --------------------------------------------------------

#
# Estrutura da tabela `marcas`
#

CREATE TABLE marcas (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  nom_marca varchar(45) NOT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `marcas`
#

INSERT INTO marcas VALUES (1, 'INTEQ', '2011-03-21 04:05:43');
INSERT INTO marcas VALUES (2, 'BOAL', '2011-03-21 04:05:59');
INSERT INTO marcas VALUES (3, 'ECOBELLE', '2011-03-21 04:06:08');
# --------------------------------------------------------

#
# Estrutura da tabela `moeda`
#

CREATE TABLE moeda (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  nm_moeda varchar(45) NOT NULL,
  sigla_moeda varchar(5) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `moeda`
#

INSERT INTO moeda VALUES (1, 'Dolar', 'u$');
INSERT INTO moeda VALUES (2, 'Reais', 'r$');
INSERT INTO moeda VALUES (3, 'Guarani', 'g$');
# --------------------------------------------------------

#
# Estrutura da tabela `nf_saidas`
#

CREATE TABLE nf_saidas (
  Sequencia int(11) DEFAULT NULL,
  Num_Nota varchar(10) DEFAULT NULL,
  CFOP varchar(3) DEFAULT NULL,
  Data_Emissao datetime DEFAULT NULL,
  Data_Saida datetime DEFAULT NULL,
  Hora_Saida datetime DEFAULT NULL,
  Codigo_Transportador varchar(5) DEFAULT NULL,
  Codigo_Cliente varchar(5) DEFAULT NULL,
  Nome_Cliente varchar(40) DEFAULT NULL,
  Valor_Produtos float DEFAULT NULL,
  Valor_Nota float DEFAULT NULL,
  Vendedor varchar(3) DEFAULT NULL,
  Nome_Vendedor varchar(40) DEFAULT NULL,
  Status_Nota varchar(1) DEFAULT NULL,
  Valor_Comissao float DEFAULT NULL,
  Peso_Bruto float DEFAULT NULL,
  Peso_Liquido float DEFAULT NULL,
  Conta_Frete varchar(1) DEFAULT NULL,
  Valor_Frete float DEFAULT NULL,
  Valor_Seguro float DEFAULT NULL,
  Valor_Outros float DEFAULT NULL,
  Valor_Base_ICMS float DEFAULT NULL,
  Valor_ICMS float DEFAULT NULL,
  Valor_Base_ICMS_Subst float DEFAULT NULL,
  Valor_ICMS_Subst float DEFAULT NULL,
  Valor_IPI float DEFAULT NULL,
  Placa_Veiculo varchar(7) DEFAULT NULL,
  Uf_Veiculo varchar(2) DEFAULT NULL,
  Quantidade int(11) DEFAULT NULL,
  Especie varchar(20) DEFAULT NULL,
  Marca varchar(15) DEFAULT NULL,
  Numero varchar(15) DEFAULT NULL,
  Obs longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `nf_saidas`
#

# --------------------------------------------------------

#
# Estrutura da tabela `nota_credito`
#

CREATE TABLE nota_credito (
  idnota_credito int(10) unsigned NOT NULL AUTO_INCREMENT,
  idcliente int(10) unsigned NOT NULL,
  idpedido int(10) unsigned NOT NULL,
  idvenda int(10) unsigned NOT NULL,
  idctreceber int(10) unsigned NOT NULL,
  idlctcaixa int(10) unsigned NOT NULL,
  iduser int(10) unsigned NOT NULL,
  dtlcto datetime NOT NULL,
  vlcredito float(8,2) NOT NULL,
  PRIMARY KEY (idnota_credito)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `nota_credito`
#

# --------------------------------------------------------

#
# Estrutura da tabela `of_produserv`
#

CREATE TABLE of_produserv (
  idof_produtos int(10) unsigned NOT NULL AUTO_INCREMENT,
  of_codigo varchar(15) NOT NULL,
  of_descricao varchar(45) NOT NULL,
  of_marca int(10) unsigned NOT NULL,
  of_grupo int(10) unsigned NOT NULL,
  of_codoriginal varchar(15) NOT NULL,
  of_custo float(8,2) NOT NULL,
  of_custoant float(8,2) NOT NULL,
  of_customedio float(8,2) NOT NULL,
  of_valor float(8,2) NOT NULL,
  of_dtcadastro datetime NOT NULL,
  of_dtultmodif datetime NOT NULL,
  of_modfuser int(10) unsigned NOT NULL,
  of_prmin float(8,2) NOT NULL,
  of_tipo varchar(1) NOT NULL,
  of_qtd float(8,2) NOT NULL,
  of_margen float(8,2) NOT NULL,
  of_obs text NOT NULL,
  of_tipoiten int(10) unsigned NOT NULL,
  PRIMARY KEY (idof_produtos)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `of_produserv`
#

# --------------------------------------------------------

#
# Estrutura da tabela `operacao`
#

CREATE TABLE operacao (
  id_operacao int(10) NOT NULL,
  codigo_operacao varchar(45) NOT NULL,
  descricao_operacao varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `operacao`
#

INSERT INTO operacao VALUES (1, '6.102', 'VENTA CONTADO');
INSERT INTO operacao VALUES (2, '6.102', 'VENTA CREDITO');
INSERT INTO operacao VALUES (3, '2.202', 'DEVOLUCION POR CLIENTE');
INSERT INTO operacao VALUES (4, '2.102', 'COMPRAS PARA COMERCIALIZACION');
# --------------------------------------------------------

#
# Estrutura da tabela `pedido`
#

CREATE TABLE pedido (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  controle_cli varchar(45) DEFAULT NULL,
  nome_cli varchar(45) DEFAULT NULL,
  data_car datetime DEFAULT NULL,
  total_nota float(8,2) DEFAULT NULL,
  sessao_car text,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  situacao varchar(1) DEFAULT NULL,
  usuario_id int(10) unsigned NOT NULL,
  forma_pagamento_id int(10) unsigned NOT NULL,
  cotacao_id int(10) unsigned NOT NULL,
  frete float(8,2) NOT NULL,
  desconto float(8,2) NOT NULL,
  vendedor_id int(11) NOT NULL,
  moeda char(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `pedido`
#

INSERT INTO pedido VALUES (1, '16', 'SILVIA REGINA BORRI', '2011-10-25 13:54:12', '14250.00', '', 'C', 'A', 1, 2, 0, '0.00', '0.00', 1, '');
INSERT INTO pedido VALUES (2, '16', 'SILVIA REGINA BORRI', '2011-10-25 14:11:13', '14250.00', '', 'A', 'A', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (3, '16', 'SILVIA REGINA BORRI', '2011-10-25 14:11:56', '14250.00', '', 'A', 'A', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (4, '16', 'SILVIA REGINA BORRI', '2011-10-25 14:12:20', '14250.00', '', 'A', 'A', 2, 2, 0, '0.00', '0.00', 1, '');
INSERT INTO pedido VALUES (5, '16', 'SILVIA REGINA BORRI', '2011-10-25 14:14:50', '14250.00', '', 'C', 'A', 1, 2, 0, '0.00', '0.00', 1, '');
INSERT INTO pedido VALUES (6, '16', 'SILVIA REGINA BORRI', '2011-10-25 14:22:39', '14250.00', '', 'C', 'A', 1, 1, 0, '0.00', '0.00', 1, '');
INSERT INTO pedido VALUES (7, '16', 'SILVIA REGINA BORRI', '2011-10-25 14:27:44', '28500.00', '', 'C', 'A', 1, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (8, '41', 'JOAVE ALVES LOPES', '2011-10-25 06:48:34', '90000.00', '', 'C', 'A', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (10, '43', 'MANUTENCIÓN INTERNA', '2011-03-28 13:54:34', '15000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (11, '', '', '2011-10-21 08:19:30', '540000.00', '', 'C', 'A', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (12, '26', 'ANDRINO RODRIGUES DOS SANTOS', '2011-10-21 08:22:45', '540000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (13, '26', 'ANDRINO RODRIGUES DOS SANTOS', '2011-10-21 08:27:20', '30000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (14, '', '', '2011-10-21 09:04:53', '20000.00', '', 'C', 'A', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (15, '44', 'CANINDEYú ELETRO MOTORES', '2011-10-21 14:43:20', '77000.00', '', 'A', 'F', 2, 1, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (16, '45', 'DOUGLAS DIEGO BRUN', '2011-10-21 16:59:20', '45000.00', '', 'A', 'F', 2, 1, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (17, '28', 'REFRIGERACIóN CABRAL', '2011-10-21 17:08:32', '629000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (18, '46', 'ATZEL SA', '2011-10-21 17:28:53', '273000.00', '', 'A', 'F', 2, 1, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (19, '37', 'JANETE SCHULLA', '2011-10-21 17:31:29', '30000.00', '', 'A', 'F', 2, 1, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (20, '47', 'CLAUDETE LOPES', '2011-10-21 17:34:16', '23000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (21, '28', '', '2011-10-22 10:29:01', '225000.00', '', 'C', 'A', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (22, '20', '', '2011-10-22 20:57:45', '25000.00', '', 'C', 'A', 1, 2, 0, '0.00', '0.00', 1, '');
INSERT INTO pedido VALUES (23, '60', 'SUPERMERCADO ELENINHA', '2011-10-22 22:54:46', '50000.00', '', 'C', 'A', 1, 2, 0, '0.00', '0.00', 1, '');
INSERT INTO pedido VALUES (24, '28', 'REFRIGERACI�N CABRAL', '2011-10-24 07:59:17', '25000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (25, '88', 'CONSUMIDOR FINAL', '2011-10-24 08:24:39', '50000.00', '', 'A', 'F', 2, 1, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (26, '91', 'PAPELARIA ARTPEL', '2011-10-24 09:35:11', '20000.00', '', 'A', 'F', 2, 1, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (27, '93', 'ANDR�IA FONSECA', '2011-10-24 15:52:40', '20000.00', '', 'C', 'A', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (28, '94', 'ADERBAL DE BORBA', '2011-10-24 16:03:19', '60000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (29, '93', 'ANDR�IA FONSECA', '2011-10-24 16:17:13', '20000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (30, '95', 'IVONE GON�ALVES DA ROCHA', '2011-10-25 04:56:10', '70000.00', '', 'A', 'F', 2, 2, 0, '0.00', '0.00', 2, '');
INSERT INTO pedido VALUES (31, '20', 'LAVADOR SANTA LIBRADA', '2011-04-03 09:52:18', '20000.00', '', 'A', 'A', 2, 1, 0, '0.00', '0.00', 2, '');
# --------------------------------------------------------

#
# Estrutura da tabela `pendencias`
#

CREATE TABLE pendencias (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  clientes_controle int(10) unsigned NOT NULL,
  usuario_id int(10) unsigned NOT NULL,
  `data` datetime NOT NULL,
  st_pendencia varchar(1) NOT NULL,
  cotacao_id int(10) unsigned NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `pendencias`
#

# --------------------------------------------------------

#
# Estrutura da tabela `planocontas`
#

CREATE TABLE planocontas (
  idplanocontas int(10) unsigned NOT NULL AUTO_INCREMENT,
  plancodigo char(20) NOT NULL,
  plancodigopai char(20) NOT NULL,
  plandescricao varchar(45) NOT NULL,
  plantipo char(1) NOT NULL,
  plandatacad datetime NOT NULL,
  plandataalt datetime NOT NULL,
  planreceita int(10) unsigned NOT NULL,
  planuseralt int(10) unsigned NOT NULL,
  planpadrao int(1) unsigned NOT NULL,
  PRIMARY KEY (idplanocontas)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `planocontas`
#

INSERT INTO planocontas VALUES (1, '1.00.00.00.000.00', '0', 'Entradas', 'S', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1);
INSERT INTO planocontas VALUES (2, '2.00.00.00.000.00', '0', 'Salidas', 'S', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 0, 1);
INSERT INTO planocontas VALUES (23, '1.01.00.00.000.00', '1.00.00.00.000.00', 'Operacionales', 'S', '2011-07-11 11:13:29', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (24, '1.01.01.00.000.00', '1.01.00.00.000.00', 'Ventas', 'A', '2011-07-11 11:14:01', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (25, '1.01.02.00.000.00', '1.01.00.00.000.00', 'Recibimiento de Cuentas', 'A', '2011-07-11 11:14:38', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (26, '1.01.03.00.000.00', '1.01.00.00.000.00', 'Transferencia Banco - Caja', 'A', '2011-07-11 11:15:07', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (27, '1.01.04.00.000.00', '1.01.00.00.000.00', 'Ventas Con Cheque - Plazo', 'A', '2011-07-11 11:15:41', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (28, '1.01.05.00.000.00', '1.01.00.00.000.00', 'Devolución al Cliente', '', '2011-07-11 11:16:09', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (29, '1.01.06.00.000.00', '1.01.00.00.000.00', 'Devolución al Proveedor', '', '2011-07-11 11:16:40', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (30, '1.02.00.00.000.00', '1.00.00.00.000.00', 'No Operacionales', 'S', '2011-07-11 11:17:26', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (32, '1.02.01.00.000.00', '1.02.00.00.000.00', 'Venta Inmobilizado', '', '2011-07-11 11:18:11', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (33, '1.02.02.00.000.00', '1.02.00.00.000.00', 'Otras Entradas no Operacionales', 'A', '2011-07-11 11:18:38', '0000-00-00 00:00:00', 1, 1, 0);
INSERT INTO planocontas VALUES (34, '1.03.00.00.000.00', '1.00.00.00.000.00', 'Otras Entradas', 'S', '2011-07-11 11:19:11', '0000-00-00 00:00:00', 1, 1, 0);
INSERT INTO planocontas VALUES (35, '1.03.01.00.000.00', '1.00.00.00.000.00', 'Saldo Anterior', 'A', '2011-07-11 11:21:53', '0000-00-00 00:00:00', 1, 1, 0);
INSERT INTO planocontas VALUES (36, '1.03.02.00.000.00', '1.00.00.00.000.00', 'Refuerzo Numerario', '', '2011-07-11 11:22:14', '0000-00-00 00:00:00', 1, 1, 0);
INSERT INTO planocontas VALUES (37, '1.03.03.00.000.00', '1.00.00.00.000.00', 'Transferencias de Cajas', 'A', '2011-07-11 11:22:43', '0000-00-00 00:00:00', 1, 1, 1);
INSERT INTO planocontas VALUES (38, '1.03.04.00.000.00', '1.00.00.00.000.00', 'Otras Entradas', 'A', '2011-07-11 11:23:00', '0000-00-00 00:00:00', 1, 1, 0);
INSERT INTO planocontas VALUES (39, '2.01.00.00.000.00', '2.00.00.00.000.00', 'Operacionales', 'S', '2011-07-11 11:23:34', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (41, '2.01.01.00.000.00', '2.01.00.00.000.00', 'Gastos Funcionales', '', '2011-07-11 11:24:21', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (42, '2.01.01.01.000.00', '2.01.01.00.000.00', 'Gastos con EPI (Equipo de Protección Individ', '', '2011-07-11 11:25:16', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (44, '2.01.01.02.000.00', '2.01.01.00.000.00', 'Material de Expediente', 'A', '2011-07-11 11:26:15', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (45, '2.01.01.03.000.00', '2.01.01.00.000.00', 'Pago de Interés', '', '2011-07-11 11:26:42', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (46, '2.01.01.04.000.00', '2.01.01.00.000.00', 'Agua y Luz', 'A', '2011-07-11 11:27:04', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (47, '2.01.01.05.000.00', '2.01.01.00.000.00', 'Telefono', 'S', '2011-07-11 11:27:28', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (48, '2.01.01.05.001.00', '2.01.01.05.000.00', 'Telefonia Baja/Fija', '', '2011-07-11 11:28:09', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (49, '2.01.01.05.002.00', '2.01.01.05.000.00', 'Telefonia Tigo', 'A', '2011-07-11 11:28:46', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (50, '2.01.01.05.003.00', '2.01.01.05.000.00', 'Telefonia Personal', 'A', '2011-07-11 11:29:02', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (52, '2.01.01.06.000.00', '2.01.01.00.000.00', 'Limpieza y Conservacion', 'A', '2011-07-11 11:29:57', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (53, '2.01.01.07.000.00', '2.01.01.00.000.00', 'Gastos con Vehiculos', 'S', '2011-07-11 11:30:36', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (56, '2.01.01.07.001.00', '2.01.01.07.000.00', 'Fiat Idea', 'S', '2011-07-11 13:44:52', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (58, '2.01.01.07.001.01', '2.01.01.07.001.00', 'Combustible', 'A', '2011-07-11 13:45:46', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (59, '2.01.01.08.000.00', '2.01.01.00.000.00', 'Gastos con Publicidad', '', '2011-07-11 13:47:04', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (60, '2.01.02.00.000.00', '2.01.00.00.000.00', 'Gastos Administrativos', '', '2011-07-11 13:47:56', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (61, '2.01.02.01.000.00', '2.01.02.00.000.00', 'Retirada Socios', 'S', '2011-07-11 13:48:56', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (62, '2.01.02.01.001.00', '2.01.02.01.000.00', 'Silvia Regina Borri', 'A', '2011-07-11 13:49:28', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (63, '2.01.03.00.000.00', '2.01.00.00.000.00', 'Gastos Financieros', '', '2011-07-11 13:55:18', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (64, '2.01.04.00.000.00', '2.01.00.00.000.00', 'Gastos Tributarios', '', '2011-07-11 13:55:38', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (65, '2.01.05.00.000.00', '2.01.00.00.000.00', 'Mercaderias', 'S', '2011-07-11 13:56:00', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (66, '2.02.00.00.000.00', '2.00.00.00.000.00', 'Imobilizado', 'S', '2011-07-11 13:57:05', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (67, '2.03.00.00.000.00', '2.00.00.00.000.00', 'Inversiones', '', '2011-07-11 13:57:29', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (68, '2.04.00.00.000.00', '2.00.00.00.000.00', 'No Operacionales', 'S', '2011-07-11 13:57:52', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (69, '2.01.06.00.000.00', '2.01.00.00.000.00', 'Baja Credito de Clientes', 'A', '2011-07-11 14:09:08', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (70, '2.01.07.00.000.00', '2.01.00.00.000.00', 'Descuentos concedidos', 'A', '2011-07-11 14:09:34', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (71, '2.01.08.00.000.00', '2.01.00.00.000.00', 'Acrescimos', 'A', '2011-07-11 14:09:53', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (72, '2.01.09.00.000.00', '2.01.00.00.000.00', 'Transferencias Caja - Banco', 'A', '2011-07-11 14:11:17', '0000-00-00 00:00:00', 2, 1, 1);
INSERT INTO planocontas VALUES (73, '2.01.10.00.000.00', '2.01.00.00.000.00', 'Gastos Funcionarios', '', '2011-07-11 14:11:54', '0000-00-00 00:00:00', 2, 1, 0);
INSERT INTO planocontas VALUES (80, '1.01.07.00.000.00', '1.01.00.00.000.00', 'Otras Entradas Operacionales', '', '2011-07-15 16:03:26', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (81, '1.01.08.00.000.00', '1.01.00.00.000.00', 'Descuentos Obtenidos', '', '2011-07-15 16:03:54', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (84, '1.01.09.00.000.00', '1.01.00.00.000.00', 'Interés Obtenidos', '', '2011-07-15 16:08:39', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (91, '2.01.01.07.001.02', '2.01.01.07.001.00', 'Mantenimiento y Reparos', 'A', '2011-07-15 16:18:02', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (104, '1.01.10.00.000.00', '1.01.00.00.000.00', 'Ventas', 'S', '2011-07-15 16:24:27', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (105, '1.01.10.01.000.00', '1.01.10.00.000.00', 'Ventas Al Contado', 'A', '2011-07-15 16:24:50', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (106, '1.01.10.02.000.00', '1.01.10.00.000.00', 'Ventas A Credito', 'A', '2011-07-15 16:25:11', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (108, '1.01.10.03.000.00', '1.01.10.00.000.00', 'Consignación', 'A', '2011-07-15 16:25:47', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (109, '2.01.01.05.004.00', '2.01.01.05.000.00', 'Telefonia Voip', 'A', '2011-07-15 16:27:42', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (110, '2.01.01.09.000.00', '2.01.01.00.000.00', 'Gastos con Obsequio', '', '2011-07-15 16:37:25', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (111, '2.01.01.10.000.00', '2.01.01.00.000.00', 'Gastos con Rifas y Donaciones', '', '2011-07-15 16:38:29', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (112, '2.01.01.11.000.00', '2.01.01.00.000.00', 'Otros Gastos', 'A', '2011-07-15 16:39:20', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (113, '2.01.01.12.000.00', '2.01.01.00.000.00', 'Gastos con Mantenimientos', '', '2011-07-15 16:40:56', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (116, '2.01.01.12.002.00', '2.01.01.12.000.00', 'Instalaciones', 'A', '2011-07-15 16:42:18', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (117, '2.01.01.12.001.00', '2.01.01.12.000.00', 'Herramientas y Máquinas', 'A', '2011-07-15 16:43:24', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (118, '2.01.02.01.002.00', '2.01.02.01.000.00', 'Joave Alves Lopez', 'A', '2011-07-15 16:48:00', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (120, '2.01.02.02.000.00', '2.01.02.00.000.00', 'Honorários Ingenieria', '', '2011-07-15 16:51:01', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (121, '2.01.02.03.000.00', '2.01.02.00.000.00', 'Honorários Contables', 'A', '2011-07-15 16:51:35', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (122, '2.01.02.04.000.00', '2.01.02.00.000.00', 'Gastos con Escribania', '', '2011-07-15 16:52:03', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (123, '2.01.02.05.000.00', '2.01.02.00.000.00', 'Gastos con Informática', 'S', '2011-07-15 16:52:33', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (125, '2.01.02.05.001.00', '2.01.02.05.000.00', 'Internet', 'A', '2011-07-15 16:53:01', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (126, '2.01.02.05.002.00', '2.01.02.05.000.00', 'Softwares - Programas', 'A', '2011-07-15 16:53:21', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (127, '2.01.02.05.003.00', '2.01.02.05.000.00', 'Hardware - Equipamiento', 'A', '2011-07-15 16:53:44', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (128, '2.01.03.01.000.00', '2.01.03.00.000.00', 'Interés pago al Banco', '', '2011-07-15 16:54:37', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (129, '2.01.03.02.000.00', '2.01.03.00.000.00', 'Tazas Bancárias', '', '2011-07-15 16:55:09', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (130, '2.01.03.03.000.00', '2.01.03.00.000.00', 'Gastos Bancários', 'A', '2011-07-15 16:55:48', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (131, '2.01.04.01.000.00', '2.01.04.00.000.00', 'IVA Debito', 'A', '2011-07-15 16:57:58', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (132, '2.01.04.02.000.00', '2.01.04.00.000.00', 'IVA Crédito', 'A', '2011-07-15 16:58:15', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (133, '2.01.04.03.000.00', '2.01.04.00.000.00', 'IVA a Pagar', 'A', '2011-07-15 16:59:13', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (134, '2.01.04.04.000.00', '2.01.04.00.000.00', 'Impuesto Imobiliários', 'A', '2011-07-15 16:59:44', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (135, '2.01.05.01.000.00', '2.01.05.00.000.00', 'Compra de Mercaderias al Contado', 'A', '2011-07-15 17:00:27', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (136, '2.01.05.02.000.00', '2.01.05.00.000.00', 'Pago de Proveedores', '', '2011-07-15 17:00:52', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (137, '2.01.05.03.000.00', '2.01.05.00.000.00', 'Pago de Interés a Proveedores', '', '2011-07-15 17:01:19', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (138, '2.01.05.04.000.00', '2.01.05.00.000.00', 'Donación de Mercaderias', '', '2011-07-15 17:01:44', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (139, '2.01.10.01.000.00', '2.01.10.00.000.00', 'Pagamento Sueldos', 'A', '2011-07-16 07:20:50', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (140, '2.01.10.02.000.00', '2.01.10.00.000.00', 'Antecipos de Sueldos', 'A', '2011-07-16 07:21:20', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (141, '2.01.10.03.000.00', '2.01.10.00.000.00', 'Pagos de Comissión', 'A', '2011-07-16 07:21:46', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (142, '2.01.10.04.000.00', '2.01.10.00.000.00', 'Otros Gastos Funcionários', 'A', '2011-07-16 07:22:13', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (143, '2.01.10.05.000.00', '2.01.10.00.000.00', 'Pagos 13 Sueldos', 'A', '2011-07-16 07:22:52', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (144, '2.01.10.06.000.00', '2.01.10.00.000.00', 'Pagos Férias', 'A', '2011-07-16 07:23:14', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (145, '2.01.10.07.000.00', '2.01.10.00.000.00', 'IPS', 'A', '2011-07-16 07:24:26', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (146, '2.01.10.08.000.00', '2.01.10.00.000.00', 'Tempo de Serviço', 'A', '2011-07-16 07:25:00', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (147, '2.01.10.09.000.00', '2.01.10.00.000.00', 'Rescisión', 'A', '2011-07-16 07:25:47', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (148, '2.01.10.10.000.00', '2.01.10.00.000.00', 'Gastos Médicos', 'A', '2011-07-16 07:30:34', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (149, '2.02.01.00.000.00', '2.02.00.00.000.00', 'Construciones', 'A', '2011-07-16 07:37:21', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (150, '2.02.02.00.000.00', '2.02.00.00.000.00', 'Muebles y Utensillos', '', '2011-07-16 07:37:41', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (151, '2.02.03.00.000.00', '2.02.00.00.000.00', 'Máquinas y Equipos', '', '2011-07-16 07:38:07', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (152, '2.03.01.00.000.00', '2.03.00.00.000.00', 'Máquinas y Equipos', '', '2011-07-16 07:45:54', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (154, '2.03.03.00.000.00', '2.03.00.00.000.00', 'Máquinas y Equipos', '', '2011-07-16 07:47:31', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (155, '2.03.02.00.000.00', '2.03.00.00.000.00', 'Muebles y Utensillos', '', '2011-07-16 07:47:51', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (156, '2.04.01.00.000.00', '2.04.00.00.000.00', 'Multas y Recargos', '', '2011-07-16 07:48:25', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (157, '2.04.02.00.000.00', '2.04.00.00.000.00', 'Reclamación del Trabajador', '', '2011-07-16 07:48:47', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (158, '2.04.03.00.000.00', '2.04.00.00.000.00', 'Perjuicios Eventuales', '', '2011-07-16 07:49:08', '0000-00-00 00:00:00', 1, 2, 0);
INSERT INTO planocontas VALUES (159, '2.04.04.00.000.00', '2.04.00.00.000.00', 'Otras Salidas No Operacionales', '', '2011-07-16 07:49:50', '0000-00-00 00:00:00', 1, 2, 0);
# --------------------------------------------------------

#
# Estrutura da tabela `produtos`
#

CREATE TABLE produtos (
  id int(255) NOT NULL AUTO_INCREMENT,
  Descricao varchar(255) NOT NULL,
  Estoque float(8,2) DEFAULT NULL,
  qtd_min int(10) unsigned NOT NULL,
  grupo int(10) unsigned NOT NULL,
  custo float(8,2) NOT NULL,
  margen_a float(8,4) DEFAULT NULL,
  margen_b float(8,4) DEFAULT NULL,
  margen_c float(8,4) DEFAULT NULL,
  valor_a float(8,2) NOT NULL,
  valor_b float(8,2) NOT NULL,
  valor_c float(8,2) NOT NULL,
  Preco_Venda float(8,2) NOT NULL,
  pr_min float(8,2) NOT NULL,
  embalagem varchar(255) NOT NULL,
  Codigo varchar(255) NOT NULL,
  Codigo_Fabricante varchar(255) NOT NULL,
  Codigo_Fabricante2 varchar(45) NOT NULL,
  Codigo_Fabricante3 varchar(45) NOT NULL,
  `local` varchar(255) NOT NULL,
  part_number varchar(255) NOT NULL,
  marca int(10) unsigned NOT NULL,
  `serial` varchar(255) NOT NULL,
  cod_original varchar(255) NOT NULL,
  qtd_bloq float(8,2) unsigned DEFAULT NULL,
  iva float(8,2) NOT NULL,
  `user` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  custo_anterior float(8,2) NOT NULL,
  custo_medio float(8,2) NOT NULL,
  cod_original2 varchar(45) NOT NULL,
  Descricaoes varchar(45) NOT NULL,
  imagem varchar(95) NOT NULL,
  obs text NOT NULL,
  custoagr float(8,2) NOT NULL,
  tipo_prod int(10) NOT NULL DEFAULT '1',
  tam int(10) unsigned NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `produtos`
#

INSERT INTO produtos VALUES (1, 'LAVANDINA', '53.00', 10, 1, '10000.00', '50.0000', '42.5000', '35.0000', '15000.00', '14250.00', '13500.00', '0.00', '13500.00', '5 LITROS', '100', '', '', '', '', '', 1, '', '100', '0.00', '0.00', '2', '2011-03-21 04:13:57', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (2, 'SUAVIZANTE BABY', '0.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '200', '', '', '', '', '', 1, '', '200', '0.00', '0.00', '', '2011-03-28 12:48:00', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (3, 'SUAVIZANTE SOFT', '20.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '201', '', '', '', '', '', 1, '', '201', '0.00', '0.00', '', '2011-03-28 12:48:52', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (4, 'DESINFETANTE EUCALIPTO', '12.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '300', '', '', '', '', '', 1, '', '300', '0.00', '0.00', '', '2011-03-28 12:49:56', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (5, 'DESINFETANTE FLORAL', '22.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '301', '', '', '', '', '', 1, '', '301', '0.00', '0.00', '', '2011-03-28 12:50:24', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (6, 'DETERTEQ NEUTRO', '19.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '400', '', '', '', '', '', 1, '', '400', '1.00', '0.00', '', '2011-03-28 12:51:18', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (7, 'DETERTEQ LIM�N', '17.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '401', '', '', '', '', '', 1, '', '401', '0.00', '0.00', '', '2011-03-28 12:51:49', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (8, 'DETERTEQ NARANJA', '21.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '402', '', '', '', '', '', 1, '', '402', '0.00', '0.00', '', '2011-03-28 12:52:16', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (9, 'SABONETE LIQUIDO AN�S', '6.00', 5, 1, '15000.00', '66.6667', '58.3333', '58.3333', '25000.00', '23750.00', '23750.00', '0.00', '23750.00', '5 LITROS', '500', '', '', '', '', '', 1, '', '500', '0.00', '0.00', '', '2011-03-28 12:53:57', '15000.00', '15000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (10, 'SABONETE LIQUIDO PITANGA', '2.00', 5, 1, '15000.00', '66.6667', '58.3333', '58.3333', '25000.00', '23750.00', '23750.00', '0.00', '23750.00', '5 LITROS', '501', '', '', '', '', '', 1, '', '501', '0.00', '0.00', '', '2011-03-28 12:54:27', '15000.00', '15000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (11, 'DETERTEQ 100', '0.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '18000.00', '5 LITROS', '600', '', '', '', '', '', 1, '', '600', '0.00', '0.00', '2', '2011-03-21 04:35:32', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (12, 'DETERTEQ 500', '15.00', 5, 1, '15000.00', '66.6667', '58.3333', '50.0000', '25000.00', '23750.00', '22500.00', '0.00', '22500.00', '5 LITROS', '601', '', '', '', '', '', 1, '', '601', '0.00', '0.00', '2', '2011-03-21 04:36:48', '15000.00', '15000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (13, 'DETERTEQ OBRA', '0.00', 5, 1, '15000.00', '66.6667', '58.3333', '50.0000', '25000.00', '23750.00', '22500.00', '0.00', '22500.00', '5 LITROS', '602', '', '', '', '', '', 1, '', '602', '0.00', '0.00', '', '2011-03-21 04:57:27', '15000.00', '15000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (14, 'DETERGENTE COCINA', '0.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '18000.00', '5 LITROS', '700', '', '', '', '', '', 1, '', '700', '0.00', '0.00', '2', '2011-03-21 04:38:53', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (15, 'AUTOCAP 5 LITROS', '19.00', 5, 5, '15000.00', '66.6667', '58.3333', '50.0000', '25000.00', '23750.00', '22500.00', '0.00', '22500.00', '5 LITROS', '1000', '', '', '', '', '', 1, '', '1000', '0.00', '0.00', '', '2011-03-21 04:41:37', '15000.00', '15000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (16, 'AUTOCAP 20 LITROS', '8.00', 5, 5, '60000.00', '66.6667', '58.3333', '50.0000', '100000.00', '95000.00', '90000.00', '0.00', '90000.00', '20 LITROS', '1001', '', '', '', '', '', 1, '', '1001', '0.00', '0.00', '2', '2011-03-21 04:41:13', '60000.00', '60000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (17, 'AUTOPAN 5 LITROS', '21.00', 5, 5, '15000.00', '66.6667', '58.3333', '50.0000', '25000.00', '23750.00', '22500.00', '0.00', '22500.00', '5 LITROS', '1002', '', '', '', '', '', 1, '', '1002', '0.00', '0.00', '2', '2011-03-21 04:42:46', '15000.00', '15000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (18, 'AUTOPAN 20 LITROS', '6.00', 5, 5, '60000.00', '66.6667', '58.3333', '50.0000', '100000.00', '95000.00', '90000.00', '0.00', '90000.00', '20 LITROS', '1003', '', '', '', '', '', 1, '', '1003', '0.00', '0.00', '', '2011-03-21 04:56:10', '60000.00', '60000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (19, 'AUTOLOPS 5 LITROS', '12.00', 5, 5, '15000.00', '66.6667', '58.3333', '50.0000', '25000.00', '23750.00', '22500.00', '0.00', '22500.00', '5 LITROS', '1004', '', '', '', '', '', 1, '', '1004', '0.00', '0.00', '', '2011-03-21 04:56:42', '15000.00', '15000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (20, 'AUTOLOPS 20 LITROS', '1.00', 5, 5, '60000.00', '66.6667', '58.3333', '50.0000', '100000.00', '95000.00', '90000.00', '0.00', '90000.00', '20 LITROS', '1005', '', '', '', '', '', 1, '', '1005', '0.00', '0.00', '2', '2011-03-21 04:46:39', '60000.00', '60000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (21, 'AUTOBOR 1 LITRO', '10.00', 5, 5, '5000.00', '60.0000', '60.0000', '60.0000', '8000.00', '8000.00', '8000.00', '0.00', '8000.00', '1 LITRO', '1006', '', '', '', '', '', 1, '', '1006', '0.00', '0.00', '', '2011-03-28 12:43:19', '5000.00', '5000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (22, 'AUTOBOR 5 LITROS', '0.00', 5, 5, '25000.00', '20.0000', '20.0000', '20.0000', '30000.00', '30000.00', '30000.00', '0.00', '30000.00', '5 LITROS', '1007', '', '', '', '', '', 1, '', '1007', '0.00', '0.00', '', '2011-03-28 12:44:11', '25000.00', '25000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (23, 'AUTO SILICGEL NEUTRO - 200 ML', '0.00', 5, 5, '10000.00', '50.0000', '30.0000', '20.0000', '15000.00', '13000.00', '12000.00', '0.00', '12000.00', '200 ML', '1008', '', '', '', '', '', 1, '', '1008', '0.00', '0.00', '', '2011-03-21 04:50:57', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (24, 'AUTO SILICGEL TUTTI FRUTTI - 200 ML', '0.00', 5, 5, '10000.00', '50.0000', '40.0000', '30.0000', '15000.00', '14000.00', '13000.00', '0.00', '13000.00', '200 ML', '1009', '', '', '', '', '', 1, '', '1009', '0.00', '0.00', '2', '2011-03-21 04:52:05', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (25, 'AUTO SILICGEL NEUTRO - 1 KILO', '0.00', 5, 5, '10000.00', '50.0000', '40.0000', '30.0000', '15000.00', '14000.00', '13000.00', '0.00', '13000.00', '1 KILO', '1010', '', '', '', '', '', 1, '', '1010', '0.00', '0.00', '2', '2011-03-21 04:54:22', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (26, 'AUTO SILICGEL TUTTI FRUTTI - 1 KILO', '0.00', 5, 5, '10000.00', '50.0000', '40.0000', '30.0000', '15000.00', '14000.00', '13000.00', '0.00', '13000.00', '1 KILO', '1011', '', '', '', '', '', 1, '', '1011', '0.00', '0.00', '2', '2011-03-21 04:55:17', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (27, 'JABON EN PAN - TESTES', '95.00', 0, 4, '3000.00', '100.0000', '90.0000', '80.0000', '6000.00', '5700.00', '5400.00', '0.00', '5400.00', '1 KILO', '1T', '', '', '', '', '', 1, '', '1', '0.00', '0.00', '', '2011-03-28 07:08:36', '3000.00', '3000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (28, 'JABON SOBRANTE - TESTES', '41.00', 0, 4, '3000.00', '100.0000', '90.0000', '80.0000', '6000.00', '5700.00', '5400.00', '0.00', '5400.00', '1 KILO', '2T', '', '', '', '', '', 1, '', '2', '0.00', '0.00', '', '2011-03-28 07:08:49', '3000.00', '3000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (29, 'SUAVIZANTES - TESTES', '3.00', 0, 4, '5000.00', '60.0000', '52.0000', '44.0000', '8000.00', '7600.00', '7200.00', '0.00', '7200.00', '5 LITROS', '3T', '', '', '', '', '', 1, '', '3', '0.00', '0.00', '', '2011-03-28 07:09:02', '5000.00', '5000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (30, 'ESPUMA DE AUTOPAN - TESTES', '1.00', 0, 4, '3000.00', '0.0000', '-5.0000', '-10.0000', '3000.00', '2850.00', '2700.00', '0.00', '2700.00', '5 LITROS', '4T', '', '', '', '', '', 1, '', '4', '0.00', '0.00', '', '2011-03-28 07:09:16', '3000.00', '3000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (31, 'DESINFETANTE LAVANDA', '11.00', 5, 1, '10000.00', '100.0000', '90.0000', '80.0000', '20000.00', '19000.00', '18000.00', '0.00', '15000.00', '5 LITROS', '302', '', '', '', '', '', 1, '', '302', '0.00', '0.00', '2', '2011-03-28 13:20:37', '10000.00', '10000.00', '', '', '', '', '0.00', 1, 0);
INSERT INTO produtos VALUES (32, 'KIT DE LIMPEZA', '-2.00', 5, 1, '45000.00', '33.3333', '33.3333', '33.3333', '60000.00', '60000.00', '60000.00', '0.00', '60000.00', '20 LITROS', '800', '', '', '', '', '', 1, '', '800', '0.00', '0.00', '2', '2011-10-24 09:21:17', '45000.00', '45000.00', '', '', '', '', '0.00', 1, 0);
# --------------------------------------------------------

#
# Estrutura da tabela `proveedor`
#

CREATE TABLE proveedor (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  nome varchar(45) NOT NULL,
  data_cad datetime NOT NULL,
  endereco varchar(45) NOT NULL,
  dt_ult_compra datetime NOT NULL,
  telefone varchar(15) NOT NULL,
  fax varchar(15) NOT NULL,
  celular varchar(15) NOT NULL,
  ruc varchar(15) NOT NULL,
  cedula varchar(15) NOT NULL,
  razao_social varchar(30) NOT NULL,
  cgc varchar(30) NOT NULL,
  pais varchar(18) NOT NULL,
  insc_est varchar(30) NOT NULL,
  tipo_prov varchar(1) NOT NULL,
  contato1 varchar(30) NOT NULL,
  contato2 varchar(30) NOT NULL,
  contato3 varchar(30) NOT NULL,
  email varchar(45) NOT NULL,
  obs varchar(200) NOT NULL,
  ddd varchar(3) NOT NULL,
  cidade int(10) unsigned NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `proveedor`
#

# --------------------------------------------------------

#
# Estrutura da tabela `telas`
#

CREATE TABLE telas (
  idtelas int(11) NOT NULL AUTO_INCREMENT,
  tela varchar(25) NOT NULL,
  perfil_tela int(11) NOT NULL,
  nome_menu varchar(30) NOT NULL,
  idgrupotela int(10) unsigned NOT NULL,
  PRIMARY KEY (idtelas)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `telas`
#

INSERT INTO telas VALUES (1, 'pesquisa_pedido', 4, 'pesquisa pedidos', 1);
INSERT INTO telas VALUES (2, 'cadastro_prod', 1, 'Cadastro de Produtos', 2);
INSERT INTO telas VALUES (3, 'alterar_prod', 1, 'Alterar Produto', 2);
INSERT INTO telas VALUES (4, 'alterar_prod_fim', 1, 'Alterar Produto', 2);
INSERT INTO telas VALUES (5, 'acerto_estoque', 1, 'Acerto Estoque', 2);
INSERT INTO telas VALUES (6, 'pesquisa_estoque', 1, 'Estatistica', 2);
INSERT INTO telas VALUES (7, 'lista_precos_estoque', 1, 'Posicao', 0);
INSERT INTO telas VALUES (8, 'lista_usu', 1, 'Alterar Usuario', 0);
INSERT INTO telas VALUES (9, 'lista_telas', 1, 'Controle Telas', 0);
INSERT INTO telas VALUES (10, 'cadastro_usu', 1, 'Cadastro Usuarios', 0);
INSERT INTO telas VALUES (11, 'alterar_usu', 1, 'Alterar Usuarios', 0);
INSERT INTO telas VALUES (12, 'caixa', 4, 'Caja', 0);
INSERT INTO telas VALUES (13, 'lancar_recebidos', 1, 'Creditar Recebimento', 0);
INSERT INTO telas VALUES (14, 'vendidos_periodo', 1, 'Vendidos no Periodo', 0);
INSERT INTO telas VALUES (15, 'definir_cambio', 1, 'Definir Cambio', 0);
INSERT INTO telas VALUES (16, 'vis_vendas', 4, 'Financeiro>Facturas>Pesquiza', 0);
INSERT INTO telas VALUES (17, 'relatorio_vendas', 1, 'Financeiro>Facturas>Relatorio ', 0);
INSERT INTO telas VALUES (18, 'situacao_fin', 4, 'Financeiro>Situacao Financeira', 0);
INSERT INTO telas VALUES (19, 'contas_receber', 4, 'Financeiro>Contas Receber', 0);
INSERT INTO telas VALUES (20, 'cont_rec_cli', 1, 'Financeiro>Contas Receber', 0);
INSERT INTO telas VALUES (21, 'emitir_pagare', 1, 'Financeiro>Emitir Pagare', 0);
INSERT INTO telas VALUES (22, 'cont_pagar', 1, 'Financeiro>Contas Pagar', 0);
INSERT INTO telas VALUES (23, 'cont_pag_forn', 1, 'Financeiro>Contas Pagar', 0);
INSERT INTO telas VALUES (24, 'comissoes', 1, 'Financeiro>Comissoes', 0);
INSERT INTO telas VALUES (25, 'comissoes_vend', 1, 'Financeiro>Comissoes', 0);
INSERT INTO telas VALUES (26, 'contas_pagar', 1, 'Compras>Entrada>Lancar Factura', 0);
INSERT INTO telas VALUES (27, 'vis_compra', 1, 'Compras>Entrada>Pesquiza>Visua', 0);
INSERT INTO telas VALUES (28, 'vis_compra_edit', 1, 'Compras>Entrada>Pesquiza>Edita', 0);
INSERT INTO telas VALUES (29, 'pesquisa_compras', 1, 'Compras>Entradas>Pesquiza', 0);
INSERT INTO telas VALUES (30, 'cadastro_cli', 1, 'Cadastro>Clientes>Cadastrar Cl', 0);
INSERT INTO telas VALUES (31, 'pesquiza_cli_alt', 1, 'Cadastro>Clientes>Alterar Cada', 0);
INSERT INTO telas VALUES (32, 'alt_cadastro_cli', 1, 'Cadastro>Clientes>Alterar Cada', 0);
INSERT INTO telas VALUES (33, 'cadastro_prov', 1, 'Cadastro>Proveedores>Cadastro ', 0);
INSERT INTO telas VALUES (34, 'alterar_prov', 1, 'Cadastro>Proveedores>Alterar C', 0);
INSERT INTO telas VALUES (35, 'formas_pago', 1, 'Diversos>Formas de Pago>Cadast', 0);
INSERT INTO telas VALUES (36, 'cadastro_cheque', 1, 'Bancos>Cadastro Cheque', 0);
INSERT INTO telas VALUES (37, 'cons_compral', 1, 'Funcao F8', 0);
INSERT INTO telas VALUES (38, 'vis_itens_venda', 1, 'Financeiro>Facturas>Pesquiza>V', 0);
INSERT INTO telas VALUES (39, 'inf_num_form', 1, 'Financeiro>Facturas>Pesquiza>I', 0);
INSERT INTO telas VALUES (40, 'CadPlanContas', 1, '', 8);
INSERT INTO telas VALUES (41, 'cadastro_clientes', 1, '', 5);
# --------------------------------------------------------

#
# Estrutura da tabela `telas_cadastro`
#

CREATE TABLE telas_cadastro (
  idtelas int(10) unsigned NOT NULL AUTO_INCREMENT,
  tela varchar(25) NOT NULL,
  idgrupotela int(10) unsigned NOT NULL,
  menu varchar(55) NOT NULL,
  PRIMARY KEY (idtelas)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `telas_cadastro`
#

INSERT INTO telas_cadastro VALUES (1, 'pesquisa_pedido', 1, 'Faturamento - Pedido - pesquisa');
INSERT INTO telas_cadastro VALUES (2, 'cadastro_clientes', 5, 'Cadastro - Clientes - cadastro');
INSERT INTO telas_cadastro VALUES (3, 'CadPlanContas', 8, 'Administrativo - cadastro plano contas');
INSERT INTO telas_cadastro VALUES (4, 'ControleAcesso', 8, 'Administrativo - controle acesso');
INSERT INTO telas_cadastro VALUES (5, 'AcertoEstoque', 2, 'Estoque - acerto estoque');
INSERT INTO telas_cadastro VALUES (6, 'CadGrupos', 2, 'Estoque - Cadastro - grupos');
INSERT INTO telas_cadastro VALUES (7, 'CadProdutos', 2, 'Estoque - Cadastro - produtos');
INSERT INTO telas_cadastro VALUES (8, 'CaixaGeral', 3, 'Financeiro - caixa geral');
INSERT INTO telas_cadastro VALUES (11, 'CadTelas', 8, 'Administrativo - controle acesso - cadastro telas');
INSERT INTO telas_cadastro VALUES (12, 'index', 5, 'Cadastro - Usuarios - cadastro usuarios');
INSERT INTO telas_cadastro VALUES (13, 'relatorio_mensal', 3, 'Financeiro - relatorio mensal');
INSERT INTO telas_cadastro VALUES (14, 'contas_pagar', 3, 'Financeiro - contas pagar');
INSERT INTO telas_cadastro VALUES (15, 'CadMarcas', 2, 'Estoque - Cadstro - cadastro marcas');
INSERT INTO telas_cadastro VALUES (16, 'Devolucao', 1, 'Faturamento - Devolucoes - devolucao itens');
INSERT INTO telas_cadastro VALUES (17, 'RelDespesa', 1, 'Faturamento - Despesas - pesquisa');
INSERT INTO telas_cadastro VALUES (18, 'lista_cli', 5, 'Cadastro - Clientes - edicao de cadastro');
# --------------------------------------------------------

#
# Estrutura da tabela `telas_controle`
#

CREATE TABLE telas_controle (
  idtelascontrole int(11) NOT NULL AUTO_INCREMENT,
  telaid int(11) NOT NULL,
  iduser int(11) NOT NULL,
  acessar int(1) NOT NULL DEFAULT '1',
  alterar int(1) NOT NULL DEFAULT '0',
  inserir int(1) NOT NULL DEFAULT '0',
  deletar int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (idtelascontrole)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Extraindo dados da tabela `telas_controle`
#

INSERT INTO telas_controle VALUES (1, 1, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (2, 2, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (3, 3, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (4, 4, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (5, 5, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (6, 6, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (7, 7, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (8, 8, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (9, 11, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (10, 12, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (11, 13, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (12, 14, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (13, 15, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (14, 16, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (15, 17, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (16, 18, 1, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (17, 1, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (18, 2, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (19, 3, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (20, 4, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (21, 5, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (22, 6, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (23, 7, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (24, 8, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (25, 11, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (26, 12, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (27, 13, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (28, 14, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (29, 15, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (30, 16, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (31, 17, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (32, 18, 2, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (33, 1, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (34, 2, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (35, 3, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (36, 4, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (37, 5, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (38, 6, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (39, 7, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (40, 8, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (41, 11, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (42, 12, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (43, 13, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (44, 14, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (45, 15, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (46, 16, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (47, 17, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (48, 18, 3, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (49, 1, 4, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (50, 2, 4, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (51, 3, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (52, 4, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (53, 5, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (54, 6, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (55, 7, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (56, 8, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (57, 11, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (58, 12, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (59, 13, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (60, 14, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (61, 15, 4, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (62, 16, 4, 1, 0, 0, 0);
INSERT INTO telas_controle VALUES (63, 17, 4, 0, 0, 0, 0);
INSERT INTO telas_controle VALUES (64, 18, 4, 1, 0, 0, 0);
# --------------------------------------------------------

#
# Estrutura da tabela `telas_grupo`
#

CREATE TABLE telas_grupo (
  idtelas_grupo int(10) unsigned NOT NULL AUTO_INCREMENT,
  nome_telagrupo varchar(20) NOT NULL,
  PRIMARY KEY (idtelas_grupo)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `telas_grupo`
#

INSERT INTO telas_grupo VALUES (1, 'FATURAMENTO');
INSERT INTO telas_grupo VALUES (2, 'ESTOQUE');
INSERT INTO telas_grupo VALUES (3, 'FINANCEIRO');
INSERT INTO telas_grupo VALUES (4, 'COMPRAS');
INSERT INTO telas_grupo VALUES (5, 'CADASTRO');
INSERT INTO telas_grupo VALUES (6, 'DIVERSOS');
INSERT INTO telas_grupo VALUES (7, 'BANCOS');
INSERT INTO telas_grupo VALUES (8, 'ADMINISTRATIVO');
# --------------------------------------------------------

#
# Estrutura da tabela `tipo_iten`
#

CREATE TABLE tipo_iten (
  idtipo_iten int(10) unsigned NOT NULL AUTO_INCREMENT,
  tipo varchar(1) NOT NULL,
  nome_tipo varchar(20) NOT NULL,
  PRIMARY KEY (idtipo_iten)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `tipo_iten`
#

INSERT INTO tipo_iten VALUES (1, 'P', 'PRODUTO');
INSERT INTO tipo_iten VALUES (2, 'S', 'SERVICO');
# --------------------------------------------------------

#
# Estrutura da tabela `usuario`
#

CREATE TABLE usuario (
  id_usuario int(10) unsigned NOT NULL AUTO_INCREMENT,
  entidadeid int(11) NOT NULL,
  usuario varchar(45) NOT NULL,
  senha varchar(45) NOT NULL,
  nome varchar(45) NOT NULL,
  `data` datetime NOT NULL,
  endereco varchar(45) NOT NULL,
  telefone varchar(45) NOT NULL,
  celular varchar(45) NOT NULL,
  ruc varchar(45) NOT NULL,
  cedula varchar(45) NOT NULL,
  email varchar(100) NOT NULL,
  obs text NOT NULL,
  nome_user varchar(45) NOT NULL,
  perfil_id int(10) unsigned NOT NULL,
  porcentagem float(8,2) NOT NULL,
  id_cargo int(11) NOT NULL,
  ativo varchar(1) NOT NULL DEFAULT '1',
  salario float(8,2) NOT NULL,
  data_nascimento datetime NOT NULL,
  id_thema int(11) NOT NULL,
  PRIMARY KEY (id_usuario)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Extraindo dados da tabela `usuario`
#

INSERT INTO usuario VALUES (1, 48, 'admin', '11ff2346b384b19190353d5d04521327b7486e6e', '', '2008-01-27 15:54:07', '', '', '', '', '', '', '', 'Admin', 1, '0.00', 0, '1', '0.00', '0000-00-00 00:00:00', 0);
INSERT INTO usuario VALUES (2, 16, 'SILVIA', 'e84507be442fe8b0139214bf23ad070c93af49d2', 'SILVIA REGINA BORRI', '0000-00-00 00:00:00', '', '', '', '', '6538391', 'eng.silvia@terra.com.br', '', 'SILVIA R. BORRI', 0, '0.00', 12, '1', '0.00', '1972-11-29 00:00:00', 0);
# --------------------------------------------------------

#
# Estrutura da tabela `venda`
#

CREATE TABLE venda (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  data_venda datetime DEFAULT NULL,
  pedido_id int(10) unsigned DEFAULT NULL,
  num_boleta varchar(45) DEFAULT NULL,
  valor_venda float(8,2) DEFAULT NULL,
  imposto_id int(10) unsigned DEFAULT NULL,
  controle_cli varchar(45) DEFAULT NULL,
  st_venda varchar(1) DEFAULT NULL,
  seq_a int(10) DEFAULT NULL,
  seq_b int(10) DEFAULT NULL,
  seq_c int(10) NOT NULL,
  imp varchar(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Extraindo dados da tabela `venda`
#

INSERT INTO venda VALUES (2, '2011-10-21 08:23:44', 12, '0', '540000.00', 10, '26', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (3, '2011-10-21 08:28:18', 13, '0', '30000.00', 10, '26', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (4, '2011-10-21 14:51:27', 15, '0', '77000.00', 10, '44', 'F', NULL, NULL, 0, '');
INSERT INTO venda VALUES (5, '2011-10-21 17:08:59', 17, '0', '629000.00', 10, '28', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (6, '2011-10-21 17:09:08', 16, '0', '45000.00', 10, '45', 'F', NULL, NULL, 0, '');
INSERT INTO venda VALUES (7, '2011-10-21 17:35:02', 20, '0', '23000.00', 10, '47', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (8, '2011-10-21 17:35:07', 19, '0', '30000.00', 10, '37', 'F', NULL, NULL, 0, '');
INSERT INTO venda VALUES (9, '2011-10-21 17:35:16', 18, '0', '273000.00', 10, '46', 'F', NULL, NULL, 0, '');
INSERT INTO venda VALUES (10, '2011-10-24 09:22:09', 25, '0', '50000.00', 10, '88', 'F', NULL, NULL, 0, '');
INSERT INTO venda VALUES (11, '2011-10-24 09:22:32', 24, '0', '25000.00', 10, '28', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (12, '2011-10-24 09:22:41', 10, '0', '15000.00', 10, '43', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (13, '2011-10-25 04:54:56', 26, '0', '20000.00', 10, '91', 'F', NULL, NULL, 0, '');
INSERT INTO venda VALUES (14, '2011-10-25 04:55:01', 28, '0', '60000.00', 10, '94', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (15, '2011-10-25 04:55:04', 29, '0', '20000.00', 10, '93', 'A', NULL, NULL, 0, '');
INSERT INTO venda VALUES (16, '2011-10-25 04:57:08', 30, '0', '70000.00', 10, '95', 'A', NULL, NULL, 0, '');

