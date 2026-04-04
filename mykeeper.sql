drop database mykeeper;
create database mykeeper;
use mykeeper;
 
 -- Nessa tabela, por favor complemente, entendo que o login vai ser por e-mail e senha
 -- ajuste para ficar completo (pelo menos o cep para puxar os dados da api do VIACEP)
create table usuario (
	id int not null auto_increment primary key,
	email varchar(150) not null unique,
	nome varchar(150) not null,
	senha varchar(250) not null,
	cep char(9) not null,
	conta_ativa boolean not null default true
);
 
create table suporte (
	id int not null auto_increment primary key,
	nome varchar(250) not null,
	email varchar(150) not null unique,
	senha varchar(255) not null
);
 
create table notificacao (
	id int not null auto_increment primary key,
	id_usuario int not null,
	tipo enum('estoque_baixo', 
			'produto_vencendo',
			'produto_vencido',
			'receita_gerada',
			'lista_compartilhada') not null, -- ENUM 
	mensagem text not null,
	status_notificacao enum('lida','nao_lida') not null,
	data_notificacao datetime not null default now(),
	foreign key (id_usuario) references usuario(id) on delete cascade
);
 
create table lista_compras (
	id int not null auto_increment primary key,
	id_usuario int not null,
	titulo varchar(150) not null,
	link_compart varchar(255),
	status_compra enum('aberta','concluida','arquivada') not null,
	data_criacao datetime not null default now(),
	foreign key (id_usuario) references usuario(id) on delete cascade 
);
 
 create table categoria (
	id int not null auto_increment primary key,
	nome varchar(100) not null,
	icone varchar(255),
	descricao text not null
 );
 
create table produto (
	id int not null auto_increment primary key,
	id_categoria int,
	nome varchar(150) not null,
	und_medida varchar(50),
	imagem varchar(255),
	foreign key (id_categoria) references categoria(id)
);

-- Será que cabe MARCA? Validade?
-- Não era o objetivo? 
create table item_lista_compra (
	id_lista_compra int not null,
	id_produto int not null,
	quantidade int not null,
	primary key (id_lista_compra, id_produto),
	foreign key (id_lista_compra) references lista_compras(id) on delete cascade,
	foreign key (id_produto) references produto(id) on delete restrict
);
 
create table receita (
	id int not null auto_increment primary key,
	id_usuario int not null,
	titulo varchar(150) not null,
	descricao text,
	gerada_por_ia boolean not null,
	data_geracao datetime not null default now(),
	foreign key (id_usuario) references usuario(id) on delete cascade 
);
 
create table item_ingrediente (
	id_receita int not null,
	id_produto int not null,
	qtd int not null,
	und_medida varchar(50) not null,
	primary key (id_receita, id_produto),
	foreign key (id_receita) references receita(id) on delete cascade,
	foreign key (id_produto) references produto(id) on delete restrict
);
 
 -- Pelo menos data/hora de geração do inventário
create table estoque (
	id int not null auto_increment primary key,
	id_usuario int not null,
	data_criacao datetime not null default now(),
	foreign key (id_usuario) references usuario(id) on delete cascade
);
 
create table item_estoque (
	id int not null auto_increment primary key,
	id_estoque int not null,
	id_produto int not null,
	data_validade date,
	quantidade float,
	marca varchar(120),
	foreign key (id_estoque) references estoque(id) on delete cascade,
	foreign key (id_produto) references produto(id) on delete restrict,
	unique (id_estoque, id_produto) 
);
 
create table log_estoque (
    id int not null auto_increment primary key,
    id_item_estoque int,
    id_usuario int, 
    qtde_anterior int,
    qtde_nova int,
    operacao enum('insert', 'update', 'delete') not null,
    data_log_estoque datetime not null default now(),
    foreign key (id_item_estoque) references item_estoque(id) on delete set null,
    foreign key (id_usuario) references usuario(id) on delete set null
);

create table log_geral (
    id int not null auto_increment primary key,
    id_usuario int, 
    tabela varchar(100) not null,
    id_registro int not null,
    operacao enum('insert', 'update', 'delete') not null,
    dados_anteriores json,
    dados_novos json,
    data_operacao datetime not null default now(),
    foreign key (id_usuario) references usuario(id) on delete set null
);

create table ticket_suporte (
    id int not null auto_increment primary key,
    id_usuario int, 
    id_suporte int null,
    titulo varchar(150) not null,
    descricao text not null,
    status_ticket enum('ticket_aberto', 'ticket_respondido', 'ticket_atualizado', 'ticket_encerrado') not null default 'ticket_aberto',
    data_ticket datetime not null default now(),
    resposta_ticket text,
    foreign key (id_usuario) references usuario(id) on delete restrict,
    foreign key (id_suporte) references suporte(id) on delete set null
);
