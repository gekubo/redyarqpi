-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-12-2015 a las 13:39:36
-- Versión del servidor: 5.6.27
-- Versión de PHP: 5.5.30

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gekubo_orient`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `approved` int(1) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `address` varchar(200) NOT NULL,
  `uri` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `owner_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `places`
--

INSERT INTO `places` (`id`, `approved`, `title`, `type`, `lat`, `lng`, `address`, `uri`, `description`, `sector`, `owner_name`, `owner_email`) VALUES
(5, 1, 'Cancho Roano', 'colon', 38.6759, -5.66185, '38.675459, -5.664611', 'http://www.canchoroano.iam.csic.es/flash/index.html', '¿Santuario o palacio tartesio? Este yacimiento ha sido objeto de profundos estudios y acalorados debates. Lo mejor es acercarse para forjar una opinión propia. Su buen estado de conservación invita a imaginar y reconstruir que función pudo desempeñar.', '', 'gekubo', 'gekubo@gmail.com'),
(6, 1, 'Tarraco', 'roma', 41.1145, 1.25878, '41.11456, 1.258804', 'https://es.wikipedia.org/wiki/Tarraco', 'Se trata de un enclave urbano vivo por lo que encontramos "mini" yacimientos por toda la ciudad de Tarragona. Pese al elevado coste de la entrada merece la pena porque se encuentra totalmente museizado. El teatro es uno de los mejores conservados de toda la Península. El listado de las áreas visitables de este conjunto se encuentran en el enlace de arriba.', '', 'gekubo', 'gekubo@gmail.com'),
(2, 1, 'Castillo de Doña Blanca', 'colon', 36.6283, -6.16048, '36.627389, -6.159961', 'http://www.ceeibahia.com/yacimiento/', 'Puerto fenicio del inicio de su llegada al Mediterráneo occidental.  Es clave para entender y estudiar ese período pero se encuentra escasamente excavado. Visita altamente recomendable debido a su excepcionalidad y su fácil acceso. Destacar el corte estratigráfico y su barrio aterrazado.', '', 'gekubo', 'gekubo@gmail.com'),
(3, 1, 'Las Cogotas', 'pre', 40.7232, -4.67406, '40.727808, -4.701161', 'http://www.castrosyverracosdeavila.com/cyv/index.php?ver=castros,3', 'Yacimiento guía con el que se denomina a la cultura cerámica que ocupaba la Meseta Central durante la Edad del Bronce. Posteriormente fue un castro celta del pueblo de los vettones que es lo que realmente podemos visitar actualmente. Presenta una organización aterrazada y potentes murallas.', '', 'gekubo', 'gekubo@gmail.com'),
(4, 1, 'La Bastida de Totana', 'calco', 37.7658, -1.56307, '37.762323, -1.561775', 'http://www.la-bastida.com/inicio/index.html', 'Asentamiento de la cultura argárica que se corresponde con su fase expansiva-colonizadora al interior (ca. 1300 ANE.). Aún en fase de investigación, su muralla ha sorprendido a todos por su grado de excepcionalidad y conservación. Ha sido el primero en excavarse de un gran proyecto que pretende desentrañar los misterios de esta cultura.', '', 'gekubo', 'gekubo@gmail.com'),
(7, 1, 'Asturica Augusta', 'roma', 42.4534, -6.05174, '42.453386, -6.051745', 'http://www.asturica.com/laruta.html', 'Surgió como un campamento romano para proteger las minas del noroeste peninsular pero fue creciendo en poder y población hasta convertirse en la actual Astorga. Este municipio alberga, además, otros lugares dignos de visitar como la catedral y el Palacio Episcopal.', '', 'gekubo', 'gekubo@gmail.com'),
(8, 1, 'Recópolis', 'media', 40.3317, -2.88913, '40.320594, -2.893696', 'http://www.zoritadeloscanes.com/recopolis.htm', 'El origen de su fundación es incierto pero se trata de un enclave excepcional dado que es la única ciudad visigoda de nueva planta conocida en Europa. No fue reocupada tras su abandono en el siglo IX por lo que no ha sufrido alteración. Su grado de conservación no es muy bueno pero permite hacerse una idea de como sería un asentamiento visigodo. El acceso presenta una pendiente considerable.', '', 'gekubo', 'gekubo@gmail.com'),
(9, 1, 'Los Millares', 'calco', 36.9619, -2.52531, '36.966061, -2.519442', 'http://www.culturandalucia.com/LA_CULTURA_DE_LOS_MILLARES_Índice.htm', 'Se trata del yacimiento que da nombre a la cultura más significativa del calcolítico peninsular (ca. 3000 ANE.). Destacar el amurallamiento. La visita se hace larga si queremos profundizarla con los enterramientos tipo tholo, dado que se encuentran dispersos por el entorno. El centro de interpretación algo anticuado pero siempre hay un guarda dispuesto a ayudar.', '', 'gekubo', 'gekubo@gmail.com'),
(10, 1, 'Ocuri', 'roma', 36.69, -5.44951, '36.687521, -5.447212', 'http://www.ciudadromanadeocuri.es', 'La ciudad romana de Ocvri se encuentra en la cima del Salto de la Mora de Ubrique. Se conservan bien un hipogeo, las murallas y los depósitos para recoger el agua de lluvia. El acceso es muy escarpado por lo que se recomienda la visita si la climatología lo permite (es una zona muy calurosa). Único inconveniente puesto que en los últimos años se han realizado trabajos de conservación y puesta en valor que facilitan la subida.', '', 'gekubo', 'gekubo@gmail.com'),
(11, 1, 'Valeria', 'roma', 39.809, -2.15024, '39.80903, -2.15024', 'http://www.turismocastillalamancha.com/arte-cultura/monumentos/valeria-las-valeras/yacimiento-arqueologico-de-valeria/', 'El pésimo cartelamiento del yacimiento, del que mejor no fiarse, no debe distraernos de lo que puede ser el mejor ejemplo de obra hidráulica romana de la Península Ibérica, con licencia del acueducto de Segovia. Se trataba de una especie de balneario de la antigüedad que se ha conservado bastante bien. Destacar el ninfeo y las estructuras colgantes al acantilado.', '', 'gekubo', 'gekubo@gmail.com'),
(12, 1, 'La Mesa de Miranda', 'pre', 40.699, -4.95152, '40.720508, -4.946109', 'http://www.castrosyverracosdeavila.com/cyv/index.php?ver=castros,4', 'Algo difícil de localizar pero es posible acceder con cualquier tipo de vehículo. Nada más cruzar el vallado nos encontramos con la necrópolis de La Osera, separada de la ciudad por las murallas. Destacar el peculiar y avanzado sistema defensivo, perfectamente explicado en los carteles. El centro de interpretación se encuentra en la vecina localidad de Chamartín.', '', 'gekubo', 'gekubo@gmail.com'),
(13, 1, 'Ulaca', 'pre', 40.5329, -4.89684, '40.52967, -4.885435', 'http://www.navarredondadegredos.net/ulaca.html', 'Se trata de un castro en las estribaciones de la Sierra de Gredos por lo que el ascenso es largo y complicado. Su puesta en valor no ha sido mantenida por lo que los carteles están borrados por la luz solar y el recorrido se torna aleatorio a gusto del visitante. El altar y la sauna de iniciación bien merecen la subida pero sólo para personas en buena condición física. Si la climatología lo permite, es recomendable llevarse la comida. Las vistas bien lo merecen.', '', 'gekubo', 'gekubo@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
