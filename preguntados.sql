-- Crea la base de datos
DROP DATABASE IF EXISTS preguntados;
CREATE DATABASE preguntados CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

-- Usa la base de datos
USE preguntados;

DROP TABLE IF EXISTS `temas`;

CREATE TABLE `temas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `temas` (`id`,`nombre`) VALUES
(1,'Goya Futura'),
(2,'Goya Historia'),
(3,'Goya Escuelas'),
(4,'Goya Ambiente'),
(8,'Educación');

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(100) NOT NULL,
  `password` VARCHAR(10) NOT NULL,
  `totalPreguntas` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `config` (`id`,`usuario`,`password`,`totalPreguntas`)
VALUES (1,'admin','admin',10);
DROP TABLE IF EXISTS `estadisticas`;

CREATE TABLE `estadisticas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `visitas` INT NOT NULL,
  `respondidas` INT NOT NULL,
  `completados` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `estadisticas` (`id`, `visitas`, `respondidas`, `completados`)
VALUES (1,0,0,0);


DROP TABLE IF EXISTS `preguntas`;

CREATE TABLE `preguntas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tema` INT NOT NULL,
  `pregunta` TEXT NOT NULL,
  `opcion_a` TEXT NOT NULL,
  `opcion_b` TEXT NOT NULL,
  `opcion_c` TEXT NOT NULL,
  `opcion_d` TEXT NOT NULL,
  `correcta` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `preguntas` (`tema`,`pregunta`,`opcion_a`,`opcion_b`,`opcion_c`,`opcion_d`,`correcta`) VALUES
(2,'¿Cuántos municipios existen en el departamento de Goya?','3','5','7','9','A'),
(2,'¿Cómo se llama el papa que fundó la diócesis de Goya?','Pío','Benedicto XV','Pablo VI','Juan XXIII','D'),
(2,'¿Quién fue el primer obispo de Goya?','Tomás Ella','Joaquín Piña','Alberto Devoto','Jorge Gottau','C'),
(2,'¿Cómo se llama el arquitecto que construyó la catedral de Goya?','Francisco Pinaroli','José Roldán','Manuel Belgrano','Domingo Sarmiento','A'),
(2,'¿En qué año se construyó la iglesia rotonda?','1912','1915','1976','1876','D'),
(2,'¿Cómo se llamaba la maestra que estaba encargada de la escuela normal al principio?','Isabel King','María Sáenz','Juana Manso','Rosa Carrillo','A'),
(2,'¿Quién construyó el teatro Solari de Goya?','Tomás Masanti','Francisco Pinaroli','José de San Martín','Manuel Belgrano','A'),
(2,'¿Qué fecha de inauguración tiene el teatro Solari?','1903','1893','1883','1873','D'),
(2,'¿Cómo se llamaba la plaza Mitre antes?','Plaza "Goya"','Plaza "Solari"','Plaza "Devoto"','Plaza "Libertad"','D'),
(2,'¿Cómo se llamaba el hospital de Goya cuando fue inaugurado?','Camilo Muniagurria','San Juan de Dios','Nuestra Señora de la Merced','San Martín de Porres','B'),
(2,'¿Cuál es la iglesia principal de Goya?','Catedral San Juan','Iglesia de Nuestra Señora de Itatí','Iglesia Catedral Nuestra Señora del Rosario','Catedral de Santa María','C'),
(2,'¿Qué río pasa por Goya?','Río Paraná','Río de la Plata','Río Uruguay','Río Paraguay','A'),
(2,'¿Cuándo se fundó Goya?','1707','1907','1807','1607','C'),
(2,'En 1864 en Goya se inauguró el alumbrado público en base a faroles de qué tipo:','Incandescentes','Velas','Kerosene','Gas de mercurio','C'),
(2,'¿Cuál fue el primer intendente?','Francisco Muniagurria','Ignacio Osella','Mariano Hormaechea','Juan Torres','A'),
(2,'¿Cómo se llama el primer monumento de Goya?','Monumento a la Libertad','Monumento a San Martín','Monumento a Belgrano','Monumento a la Independencia','A'),
(2,'¿Qué había donde se sitúa el club Benjamín Matienzo en la antigua Goya?','Un cementerio','Un banco','Una plaza','Un hospital','C'),
(2,'¿Cómo era conocida la plaza Italia antiguamente?','Plaza Puerto','Plaza Mitre','Plaza Goya','Plaza Inmigrantes','A'),
(2,'¿Qué edificación es más antigua?','El Hotel de Inmigrantes','Catedral Nuestra Señora del Rosario','Rotonda','Cine-teatro Solari','B'),
(2,'¿Cuántos municipios existen en el departamento de Goya?','3','5','7','9','A'),
(2,'¿Cómo se llama el papa que fundó la diócesis de Goya?','Pío','Benedicto XV','Pablo VI','Juan XXIII','D'),
(2,'¿Quién fue el primer obispo de Goya?','Tomás Ella','Joaquín Piña','Alberto Devoto','Jorge Gottau','C'),
(2,'¿Cómo se llama el arquitecto que construyó la catedral de Goya?','Francisco Pinaroli','José Roldán','Manuel Belgrano','Domingo Sarmiento','A'),
(2,'¿En qué año se construyó la iglesia rotonda?','1912','1915','1976','1876','D'),
(2,'¿Cómo se llamaba la maestra que estaba encargada de la escuela normal al principio?','Isabel King','María Sáenz','Juana Manso','Rosa Carrillo','A'),
(2,'¿Quién construyó el teatro Solari de Goya?','Tomás Masanti','Francisco Pinaroli','José de San Martín','Manuel Belgrano','A'),
(2,'¿Qué fecha de inauguración tiene el teatro Solari?','1903','1893','1883','1873','D'),
(2,'¿Cómo se llamaba la plaza Mitre antes?','Plaza "Goya"','Plaza "Solari"','Plaza "Devoto"','Plaza "Libertad"','D'),
(2,'¿Cómo se llamaba el hospital de Goya cuando fue inaugurado?','Camilo Muniagurria','San Juan de Dios','Nuestra Señora de la Merced','San Martín de Porres','B'),
(2,'¿Cuál es la iglesia principal de Goya?','Catedral San Juan','Iglesia de Nuestra Señora de Itatí','Iglesia Catedral Nuestra Señora del Rosario','Catedral de Santa María','C'),
(2,'¿Qué río pasa por Goya?','Río Paraná','Río de la Plata','Río Uruguay','Río Paraguay','A'),
(2,'¿Cuándo se fundó Goya?','1707','1907','1807','1607','C'),
(2,'En 1864 en Goya se inauguró el alumbrado público en base a faroles de qué tipo:','Incandescentes','Velas','Kerosene','Gas de mercurio','C'),
(2,'¿Cuál fue el primer intendente?','Francisco Muniagurria','Ignacio Osella','Mariano Hormaechea','Juan Torres','A'),
(2,'¿Cómo se llama el primer monumento de Goya?','Monumento a la Libertad','Monumento a San Martín','Monumento a Belgrano','Monumento a la Independencia','A'),
(2,'¿Qué había donde se sitúa el club Benjamín Matienzo en la antigua Goya?','Un cementerio','Un banco','Una plaza','Un hospital','C'),
(2,'¿Cómo era conocida la plaza Italia antiguamente?','Plaza Puerto','Plaza Mitre','Plaza Goya','Plaza Inmigrantes','A'),
(2,'¿Qué edificación es más antigua?','El Hotel de Inmigrantes','Catedral Nuestra Señora del Rosario','Rotonda','Cine-teatro Solari','B')
;