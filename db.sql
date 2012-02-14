CREATE TABLE `perfil`(
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(30)
)ENGINE=InnoDB;
CREATE TABLE `usuario`(
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 login VARCHAR(30) NOT NULL UNIQUE,
 senha VARCHAR(60) NOT NULL,
 nome_completo VARCHAR(100) NOT NULL,
 perfil_id INT UNSIGNED NOT NULL,
 FOREIGN KEY(`perfil_id`) REFERENCES `perfil`(`id`)
 ON UPDATE CASCADE
 ON DELETE CASCADE
)ENGINE=InnoDB;
INSERT INTO `perfil`(nome) VALUES ('admin'), ('writer');
INSERT INTO `usuario`(login, senha, nome_completo, perfil_id) VALUES ('admin', SHA1('admin'), 'Administrador', 1), ('escritor', SHA1('escritor'), 'Escritor', 2);