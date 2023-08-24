ALTER TABLE `descripcion_cargos_taller` ADD `proposito` VARCHAR(255) NULL AFTER `creacion`;

ALTER TABLE `descripcion_cargos_taller` ADD `funcion1` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion2` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion3` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion4` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion5` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion6` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion7` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion8` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion9` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `funcion10` VARCHAR(150);


ALTER TABLE `descripcion_cargos_taller` ADD `actividad1` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad2` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad3` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad4` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad5` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad6` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad7` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad8` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad9` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad10` VARCHAR(150);
ALTER TABLE `descripcion_cargos_taller` ADD `actividad11` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad12` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad13` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad14` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `actividad15` VARCHAR(150) ;



ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad1` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad2` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad3` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad4` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad5` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad6` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad7` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad8` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad9` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad10` VARCHAR(150);
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad11` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad12` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad13` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad14` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `selectactividad15` VARCHAR(150) ;


ALTER TABLE `descripcion_cargos_taller` ADD `destrezainstrumento` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `destrezaequipo` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `destrezasistema` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `destrezacomputacion` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `destrezaotro` VARCHAR(150) ;




ALTER TABLE `descripcion_cargos_taller` ADD `competencia1` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia2` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia3` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia4` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia5` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia6` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia7` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia8` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia9` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia10` VARCHAR(150);



ALTER TABLE `descripcion_cargos_taller` ADD `competencia1` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia2` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia3` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia4` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia5` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia6` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia7` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia8` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia9` VARCHAR(150) ;
ALTER TABLE `descripcion_cargos_taller` ADD `competencia10` VARCHAR(150);


CREATE TABLE `c1661871_sidecom`.`documento` (`id` INT NOT NULL AUTO_INCREMENT , `id_empresa` INT NOT NULL , `nombre` VARCHAR(150) NOT NULL , `creacion` TIMESTAMP NOT NULL , `modificado` TIMESTAMP NOT NULL , `titulo` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;