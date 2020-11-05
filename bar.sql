
CREATE DATABASE bar;

CREATE TABLE `tb_pedido` (
  `id_pedido` int(11) NOT NULL,
  `cd_pessoa` int(11) NOT NULL,
  `dt_fechamento` DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tb_pedidoitem` (
  `id_pedidoitem` int(11) NOT NULL,
  `cd_produto` int(11) NOT NULL,
  `cd_pedido` int(11) NOT NULL,
  `nr_quantidade` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tb_pessoa` (
  `id_pessoa` int(11) NOT NULL,
  `tx_nome` varchar(64) NOT NULL,
  `nr_telefone` varchar(64) NOT NULL,
  `tx_endereco` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tb_produto` (
  `id_produto` int(11) NOT NULL,
  `tx_descricao` varchar(64) NOT NULL,
  `vl_valor` int(11) NOT NULL,
  `bl_imagem` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `tb_pessoa`
  ADD PRIMARY KEY (`id_pessoa`),
  MODIFY `id_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id_produto`),
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_pedido`
  ADD PRIMARY KEY (`id_pedido`),
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_pedido_pessoa` FOREIGN KEY ( `cd_pessoa` ) REFERENCES `tb_pessoa` ( `id_pessoa` );

ALTER TABLE `tb_pedidoitem`
  ADD PRIMARY KEY (`id_pedidoitem`),
  MODIFY `id_pedidoitem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_pedidoitem_pedido` FOREIGN KEY ( `cd_pedido` ) REFERENCES `tb_pedido` ( `id_pedido` ),
  ADD CONSTRAINT `fk_pedidoitem_produto` FOREIGN KEY ( `cd_produto` ) REFERENCES `tb_produto` ( `id_produto` );


  

  