CREATE DATABASE museu;

CREATE TABLE `tb_instituicao` (
  `id_instituicao` int(11) NOT NULL,
  `tx_nome` varchar(100) NOT NULL,
  `tx_descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_instituicao`
  ADD PRIMARY KEY (`id_instituicao`),
  MODIFY `id_instituicao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


CREATE TABLE `tb_acervo` (
  `id_acervo` int(11) NOT NULL,
  `cd_instituicao` int(11) NOT NULL,
  `tx_descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_acervo`
  ADD PRIMARY KEY (`id_acervo`),
  MODIFY `id_acervo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_acervo_instituicao` FOREIGN KEY ( `cd_instituicao` ) REFERENCES `tb_instituicao` ( `id_instituicao` );


CREATE TABLE `tb_espaco` (
  `id_espaco` int(11) NOT NULL,
  `tx_descricao` varchar(200) NOT NULL,
  `cd_acervo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_espaco`
  ADD PRIMARY KEY (`id_espaco`),
  MODIFY `id_espaco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_espaco_acervo` FOREIGN KEY ( `cd_acervo` ) REFERENCES `tb_acervo` ( `id_acervo` );


CREATE TABLE `tb_categoria` (
  `id_categoria` int(11) NOT NULL,
  `cd_instituicao` int(11) NOT NULL,
  `tx_nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id_categoria`),
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_categoria_instituicao` FOREIGN KEY ( `cd_instituicao` ) REFERENCES `tb_instituicao` ( `id_instituicao` );


CREATE TABLE `tb_objeto` (
  `id_objeto` int(11) NOT NULL,
  `tx_nome` varchar(64) NOT NULL,
  `tx_descricao` varchar(200) NOT NULL,
  `cd_status` int(11) NOT NULL,
  `dt_criacao` DATE,
  `cd_espaco` int(11) NOT NULL,
  `cd_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_objeto`
  ADD PRIMARY KEY (`id_objeto`),
  MODIFY `id_objeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_objeto_espaco` FOREIGN KEY ( `cd_espaco` ) REFERENCES `tb_espaco` ( `id_espaco` ),
  ADD CONSTRAINT `fk_objeto_categoria` FOREIGN KEY ( `cd_categoria` ) REFERENCES `tb_categoria` ( `id_categoria` );

CREATE TABLE `tb_anexo` (
  `id_anexo` int(11) NOT NULL,
  `tx_nome` varchar(64) NOT NULL,
  `cd_objeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_anexo`
  ADD PRIMARY KEY (`id_anexo`),
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_anexo_objeto` FOREIGN KEY ( `cd_objeto` ) REFERENCES `tb_objeto` ( `id_objeto` );


CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL,
  `tx_nome` varchar(100) NOT NULL,
  `tx_email` varchar(100) NOT NULL,
  `tx_senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


CREATE TABLE `tb_visita` (
  `id_visita` int(11) NOT NULL,
  `cd_acervo` int(11) NOT NULL,
  `tx_nome` varchar(100) NOT NULL,
  `nr_idade` int(11) NOT NULL,
  `dt_visita` TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tb_visita`
  ADD PRIMARY KEY (`id_visita`),
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD CONSTRAINT `fk_visita_acervo` FOREIGN KEY ( `cd_acervo` ) REFERENCES `tb_acervo` ( `id_acervo` );