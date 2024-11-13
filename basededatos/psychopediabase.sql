-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2024 a las 22:17:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `psychopedi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `nombre`, `comentario`) VALUES
(1, 'Nacho', 'SON UNOS PUUTOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desarrolladores`
--

CREATE TABLE `desarrolladores` (
  `ndesarrollador` varchar(50) NOT NULL,
  `cdesarrollador` varchar(50) NOT NULL,
  `idesarrollador` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `desarrolladores`
--

INSERT INTO `desarrolladores` (`ndesarrollador`, `cdesarrollador`, `idesarrollador`) VALUES
('Luciano', '123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `nombre` varchar(255) NOT NULL,
  `relevancia` int(4) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `imagen_previsualizacion` varchar(255) NOT NULL,
  `archivo_pdf` varchar(255) NOT NULL,
  `id` int(100) NOT NULL,
  `restringido` tinyint(1) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `descripcion` varchar(800) NOT NULL,
  `autor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`nombre`, `relevancia`, `categoria`, `imagen_previsualizacion`, `archivo_pdf`, `id`, `restringido`, `fecha_creacion`, `descripcion`, `autor`) VALUES
('Pensar rápido, pensar despacio', 1, 'Psicología', 'Captura de pantalla 2024-11-08 123103.png', 'KAHNEMAN-Daniel.-Pensar-Rápido-Pensar-Despacio.-LIBRO.pdf', 13, 1, '2024-11-08 12:31:45', 'Este libro explora los dos sistemas de pensamiento humano: el sistema rápido, intuitivo y emocional, y el sistema lento, deliberado y lógico. Kahneman, ganador del Premio Nobel de Economía, explica cómo ambos sistemas influyen en nuestras decisiones diarias y cómo podemos mejorar la toma de decisiones y evitar errores comunes.', 'Daniel Kahneman'),
('El hombre en busca de sentido', 1, 'Psicología', 'elhombreenbuscadelsentido.jpg', 'elhombreenbuscadelsentido.pdf', 14, 0, '2024-11-08 12:33:23', 'Frankl, un psiquiatra y sobreviviente de campos de concentración, desarrolla en este libro su teoría de la logoterapia, que enfatiza la búsqueda del sentido como una fuerza fundamental para la vida humana. A través de su experiencia, explora cómo el sentido personal y los valores son esenciales para la salud mental.', 'Viktor Frankl'),
('Los hombres son de Marte, las mujeres de Venus', 1, 'Psicología', 'loshombresondemarte.jpg', 'toaz.info-los-hombres-son-de-marte-y-la-mujeres-de-venus-pr_ba3b890ea06c4f4de0c3c18531fdc562.pdf', 15, 1, '2024-11-08 12:57:26', 'Este libro examina las diferencias de género en la comunicación, las emociones y las necesidades afectivas. A través de ejemplos prácticos, Gray ofrece consejos para mejorar las relaciones personales al comprender mejor las diferencias inherentes entre hombres y mujeres.', 'John Gray'),
('Las trampas del deseo: Cómo controlar los impulsos irracionales que nos llevan al error', 1, 'Psicología', 'trampasdeldeseo.jpg', 'las-trampas-del-deseo_-como-con-daniel-ariely.pdf', 16, 0, '2024-11-08 13:10:38', ' Este libro explora cómo nuestras decisiones están influenciadas por impulsos irracionales y prejuicios cognitivos. A través de experimentos e investigaciones, Ariely explica cómo funcionan estos mecanismos y ofrece sugerencias para evitar caer en sus trampas.', ' Dan Ariely'),
('Inteligencia emocional', 1, 'Psicología', 'inteligenciaemocional.png', 'La-Inteligencia-Emocional-Daniel-Goleman-1.pdf', 17, 0, '2024-11-08 13:11:17', 'Goleman explora el concepto de inteligencia emocional y su importancia en el éxito personal y profesional. Argumenta que habilidades como la autoconciencia, la empatía y la gestión de emociones pueden ser tan importantes como el coeficiente intelectual para el éxito en la vida.', 'Daniel Goleman'),
('La psicología del amor', 1, 'Psicología', 'psicologiadelamor.jpg', 'Psicologadelamor.pdf', 18, 0, '2024-11-08 13:17:34', 'Psicología del amor es un libro que trata sobre los estudios científicos del amor, hace una aproximación sistémica a la relación de pareja, analiza la evolución de la pareja desde el enamoramiento hasta la emancipación durante el matrimonio. Analiza con profundidad los problemas más frecuentes en la relación amorosa: celos, infidelidad, violencia, ruptura. Termina el libro haciendo referencia a la psicopatología conyugal desde el concepto de colusión. Este tratado es la primera parte de una serie de tomos que el autor presentará en relación a las otras formas del amor.', 'Bismarck Pinto Tapia'),
('Incógnito: Las vidas secretas del cerebro', 1, 'Psicología', 'incognito.png', 'Dialnet-IncognitoLasVidasSecretasDelCerebroDavidEaglemanBa-7387687.pdf', 19, 0, '2024-11-08 13:21:14', 'Este libro aborda el funcionamiento del inconsciente en nuestras decisiones, pensamientos y acciones. Eagleman, neurocientífico, explica cómo gran parte de lo que pensamos y hacemos está impulsado por procesos cerebrales de los cuales no somos conscientes.', 'David Eagleman'),
('Los secretos de la mente millonaria', 1, 'Psicología Financiera', 'los secretos de la vida millonaria.jpg', 'los secretos de la vida millonaria.pdf', 21, 0, '2024-11-08 14:07:36', 'Aunque se enfoca en la psicología financiera, este libro profundiza en las creencias subconscientes sobre el dinero que afectan nuestra vida financiera. Eker propone identificar y reprogramar estas creencias para alcanzar el éxito económico y personal.', 'T. Harv Eker'),
('La trampa de la felicidad', 1, 'Salud Mental', 'La trampa de la Felicidad Russ Harris.jpg', 'La trampa de la Felicidad Russ Harris.pdf', 22, 0, '2024-11-08 14:29:25', 'Este libro explora la Terapia de Aceptación y Compromiso (ACT) y cómo evitar la búsqueda constante de felicidad, una expectativa que puede conducir a una mayor insatisfacción y ansiedad. Harris nos enseña a vivir en el presente y a aceptar nuestros pensamientos y emociones sin dejarnos dominar por ellos, ofreciendo técnicas prácticas para el autocontrol y la paz mental.', 'Russ Harris'),
('El poder del ahora', 1, 'Salud Mental', 'El poder del ahora.jpg', 'El poder del ahora - Eckhart Tolle.pdf', 23, 1, '2024-11-08 14:32:18', 'Tolle nos guía a vivir en el momento presente, dejando atrás la preocupación por el pasado y la ansiedad del futuro. Este enfoque basado en la conciencia plena ayuda a reducir el estrés y mejorar la conexión consigo mismo y con los demás, favoreciendo una vida con mayor sentido y tranquilidad.', 'Eckhart Tolle'),
('Hábitos atómicos', 1, 'Salud Mental', 'Habitos Atomicos.jpg', 'Habitos atomicos - James Clear.pdf', 24, 0, '2024-11-08 14:34:44', 'Clear explora cómo los pequeños hábitos tienen un impacto acumulativo sobre el bienestar mental y emocional. Ofrece un enfoque práctico y sistemático para establecer rutinas positivas que, con el tiempo, pueden ayudar a reducir el estrés y mejorar la satisfacción personal.', 'James Clear'),
('Aprenda a Meditar: Más de 20 ejercicios sencillos para tener paz y claridad mental', 1, 'Meditacion', 'Aprenda a Meditar.jpg', 'Aprenda a Meditar - Eric Harrison.pdf', 25, 0, '2024-11-08 14:49:26', 'Este libro es una guía práctica que presenta más de veinte ejercicios de meditación fáciles de seguir, pensados para cualquier nivel de experiencia. Está diseñado para ayudar a los lectores a cultivar la paz y claridad mental, reduciendo el estrés y mejorando la concentración en la vida diaria. Cada ejercicio es detallado y explica los beneficios y técnicas de forma accesible.', 'Eric Harrison'),
('Adiestrar la Mente', 1, 'Meditacion', 'Adiestrar la mente.jpg', 'Adiestrar la Mente - Dalái Lama.pdf', 26, 0, '2024-11-08 14:50:37', 'Este texto explora técnicas de meditación avanzadas orientadas a entrenar la mente para desarrollar mayor autocontrol, compasión y claridad. Inspirado en enseñanzas budistas, el libro profundiza en cómo dominar los pensamientos y emociones para reducir el sufrimiento y alcanzar un estado mental más equilibrado y pacífico.', 'Dalái Lama'),
(' ¿Qué es realmente la meditación?', 1, 'Meditacion', 'que es realmente la meditacion.jpg', 'Que es realmente la meditacion - Centro Budista de la Ciudad de México.pdf', 27, 1, '2024-11-08 14:53:28', 'Este documento ofrece una visión introductoria a la meditación desde una perspectiva budista, destacando su esencia como práctica de autoconocimiento y transformación interior. Explica en qué consiste la meditación, desmitificando ideas comunes y subrayando su propósito: cultivar una mente consciente y en paz. También aborda los beneficios de la práctica, como la reducción del estrés y el desarrollo de la compasión, y proporciona una base teórica para aquellos interesados en comenzar o profundizar en la meditación budista.', 'Centro Budista de la Ciudad de México'),
('Meditación su Práctica y Resultados', 1, 'Meditacion', 'Meditacion su practica y resultados.jpg', 'Meditacion Practica y Resultados - Clara M. Codd.pdf', 28, 0, '2024-11-08 14:59:37', 'Este libro de Clara M. Codd ofrece una guía profunda sobre la práctica de la meditación, abordando tanto los aspectos teóricos como prácticos. La autora explora cómo la meditación puede ser una herramienta para alcanzar la paz interior y mejorar el bienestar emocional y físico. A lo largo de la obra, Codd describe diversas técnicas de meditación, sus efectos y resultados a nivel psicológico y espiritual. El texto está diseñado tanto para principiantes como para meditadores experimentados, ofreciendo una comprensión clara de cómo integrar la meditación en la vida diaria y aprovechar sus beneficios a largo plazo.', 'Clara M. Codd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_guardados`
--

CREATE TABLE `documentos_guardados` (
  `id_usuario` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `merchandising`
--

CREATE TABLE `merchandising` (
  `id` int(11) NOT NULL,
  `nombrep` varchar(255) NOT NULL,
  `rutaimg` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `merchandising`
--

INSERT INTO `merchandising` (`id`, `nombrep`, `rutaimg`, `precio`, `descripcion`, `stock`, `categoria`) VALUES
(1, 'Camiseta Psychopedia', '../recursosmerch/camiseta_psychopedia.jpg', 19.99, 'Camiseta oficial con el logo de Psychopedia', 50, 'Ropa'),
(2, 'Gorra Psychopedia', '../recursosmerch/gorra_psychopedia.jpg', 14.99, 'Gorra ajustable con el logo de Psychopedia', 30, 'Accesorios'),
(4, 'Sudadera Psychopedia', '../recursosmerch/sudadera_psychopedia.jpg', 29.99, 'Sudadera con capucha y el logo de Psychopedia', 25, 'Ropa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `talla` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reacciones_documentos`
--

CREATE TABLE `reacciones_documentos` (
  `id` int(11) NOT NULL,
  `documento_id` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `reaccion` enum('me_gusta','no_me_gusta') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reacciones_documentos`
--

INSERT INTO `reacciones_documentos` (`id`, `documento_id`, `id_usuario`, `reaccion`) VALUES
(4, 0, 8, 'me_gusta'),
(5, 1, 8, 'me_gusta'),
(6, 4, 8, 'no_me_gusta'),
(7, 5, 8, 'me_gusta'),
(8, 1, 2, 'me_gusta'),
(9, 4, 2, 'no_me_gusta'),
(10, 7, 2, 'me_gusta'),
(11, 12, 2, 'no_me_gusta'),
(12, 11, 8, 'no_me_gusta'),
(13, 21, 8, 'no_me_gusta'),
(14, 13, 8, 'no_me_gusta'),
(15, 26, 8, 'me_gusta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reset_tokens`
--

CREATE TABLE `reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reset_tokens`
--

INSERT INTO `reset_tokens` (`email`, `token`, `expires_at`, `created_at`) VALUES
('nachoabasualdo@gmail.com', '53789ff677859355add8d586f479fbacaa81a30a4dd8371b77b78685e77b1204444cf9bbdc86b8e72decc138efa8096172cb', '2024-10-07 19:01:37', '2024-10-07 13:01:37'),
('nachoabasualdo@gmail.com', '28e1c18b2b834e12361d519dc76d9a8ec6c8085bfc488a7b4a530c44a819f6ee9993d77f40242bf83472c85ac1fa12091124', '2024-10-07 19:18:19', '2024-10-07 13:18:19'),
('nachoabasualdo@gmail.com', '1d3bb8dc71c45c90e0ecc7d78c71e09bbe1ac45462ac3a917d38accfb79f8b7e0e7fc9550f797fcb699bb84f17cb8bdf77c0', '2024-10-08 01:43:27', '2024-10-07 19:43:27'),
('nachoabasualdo@gmail.com', 'e1dff5ec48ae7bd813c95eed4a335901c3c5b601b0146a8ad8b65190b6bf6ec36839e80f024ee9eac3b2d7bfd0a66e32360a', '2024-10-08 01:43:28', '2024-10-07 19:43:28'),
('nachoabasualdo@gmail.com', '9e944ef819a4b5bd280d84d7e9012ce7d9e7ff48688dccc8f9048d30dd6123376b0b4887b882f781870583346e71443086d2', '2024-10-08 01:43:39', '2024-10-07 19:43:39'),
('nachoabasualdo@gmail.com', 'a01a940cb7a6a016bef476b1fb98cc63f1efef7a2cd46cd91c8bf056b563a2a205d41fc4f20bb48d6ddde9af58f5086b0077', '2024-10-08 02:01:03', '2024-10-07 20:01:03'),
('nachoabasualdo@gmail.com', 'b4f5d2fc181ee5dd25b543b1d361b6e7df609d56a0e9f5795f9c4f040a9e399f8dd7cbd63ea41f4da50f28f60919e97c8bf6', '2024-10-08 02:03:42', '2024-10-07 20:03:42'),
('nachoabasualdo@gmail.com', '2c301996ab171666de23fab3937032a34269be2b3154716c4aecc664cf80787d94e7cdd063c92d4f8936f78f13c6713229d9', '2024-10-08 02:07:04', '2024-10-07 20:07:04'),
('nachoabasualdo@gmail.com', '6c241a2f243ba3b852de5a71a26c44a3b1b07fbb4d6e89b7724cb3edd31812b1d1e247098b6b6e09c0452308e3ad00fe78b0', '2024-10-08 02:50:33', '2024-10-07 20:50:33'),
('nachoabasualdo@gmail.com', 'd75a62bd38446b47f243502ae5f4c93a756f157504787fc5b4bae9e92a2c616596e1ab6ff680fd7eb6b3d8284d5f4d2ef136', '2024-10-08 03:18:26', '2024-10-07 21:18:26'),
('nachoabasualdo@gmail.com', '0dbe6285f1d808cf6be4289c6891d8d145f182bfad70303d955123209a3f9f10fa5cbe57652f19c5116f7a7a14f1afd93c49', '2024-10-08 03:20:49', '2024-10-07 21:20:49'),
('nachoabasualdo@gmail.com', '662ae785008ffe55b1e9db460f247396bae3df5c2701b62a4292da1c7e0e2b62d7ab2dd6a678abdb15ec718b6ff3d9aa09fe', '2024-10-08 03:23:48', '2024-10-07 21:23:48'),
('nachoabasualdo@gmail.com', '9d26c12305b2bd1226d338ce6e2ff17a67ff3c52ff076f06ca2e5408e11d2a6bd16d5b29aa6ba985691e8814c6432e3f65f4', '2024-10-08 03:24:06', '2024-10-07 21:24:06'),
('nachoabasualdo@gmail.com', 'a5cd77137d3c031256de87442fb71075c7df3a228eb9cadc3c2be817c452227272389e65f7938bc55e0e4d972574cd38f5f1', '2024-10-08 03:25:30', '2024-10-07 21:25:30'),
('nachoabasualdo@gmail.com', '1437d7dada596c941cb0b981d56a06f34b3df76c25d8dd3a26fe318e7091d2f2d413633377693b88624874c8b6919f9c8b46', '2024-10-08 03:27:04', '2024-10-07 21:27:04'),
('valelipari@gmail.com', 'a66330f6a3b9bcef2e8e19ae2e13c411d247753108a08a441c4d5d9e4db02d3de8cba5db28b91b0aef77f0e9582446288fd2', '2024-10-08 03:30:21', '2024-10-07 21:30:21'),
('lucianoreartes999@gmail.com', '9d2990193e404454c6612f1f069518285bf891730792bb17a448fbed2521730d34c9891821bb4400a0ee86ab6a1f245c5202', '2024-10-09 16:59:07', '2024-10-09 10:59:07'),
('lucianoreartes999@gmail.com', 'a6d93ca41fd99237105ce1815d178ff07905ab314a7517f51934031a627ed878d917c2961f1ea0e9aeaf0ec88fb31bbe158c', '2024-10-09 17:00:27', '2024-10-09 11:00:27'),
('santiagoambrogi72@gmail.com', '0332fabfb024f618d719a8797797457b5ebadbddd40f4eaddcbb00a9586c1023eb6fc3d42025abe03821719336203707e510', '2024-10-09 17:43:53', '2024-10-09 11:43:53'),
('santiagoambrogi72@gmail.com', '7fb8fe039cf4ebd76a5b3b520cb8f59741b541373b5f4a5b50c7d9b8b6fc5b06a58e3e4998854693547a8d2260a4d21a1d70', '2024-10-09 17:44:08', '2024-10-09 11:44:08'),
('santiagoambrogi72@gmail.com', '72594211d49e4dbccc2a63be944d01b1c43dcdebe90e2b6d3dd79d7d407faf7490b567834564c2ae8210bac6d3b7c68e4c35', '2024-10-09 17:45:13', '2024-10-09 11:45:13'),
('santiagoambrogi72@gmail.com', '4397043452043546a228fe77ced7e3f8b821a69d9c42fd08ad496dfce1a8016c2541f70a1708c255d9e9b50248514ed681b2', '2024-10-09 17:47:31', '2024-10-09 11:47:31'),
('nachoabasualdo@gmail.com', '12f84555dd2e6b1203638cd633a7bb4b5817f47e882917690692ccc83f584884c9a40864b091ae8ba4049d082823b3d28edf', '2024-10-09 17:50:13', '2024-10-09 11:50:13'),
('nachoabasualdo@gmail.com', 'c4d4b7098c05e1780b4c10cf68c554817ba87886218ed6510f48d5feea71affaa56508d78ac423aafc3e739a7e0f13848198', '2024-10-09 18:42:03', '2024-10-09 12:42:03'),
('nachoabasualdo@gmail.com', 'dba2eceaf6cf611188911029db6d5ae0f90b5b59454193a87d62a1106cc3ce63a488f8a1211da05b15c8a38eb351e28c5168', '2024-10-14 07:57:36', '2024-10-14 01:57:36'),
('nachoabasualdo@gmail.com', '6345fe9fb81936fb32fe4e2e21326bbcac67b069cde31a32db53acbb67526910d6609a2d3150fb4e794aa02e883ffdf4cfcb', '2024-10-14 07:59:18', '2024-10-14 01:59:18'),
('nachoabasualdo@gmail.com', '4d85545a04596ca5106da6959288a079f58b07e7d29b49a1478d937494867e7313c0cdfd6a13f113885359c526b16dc4d5bd', '2024-10-14 08:19:00', '2024-10-14 02:19:00'),
('nachoabasualdo@gmail.com', '360aa34751f371e2b9c989b02ed63716493a118fb50eb99c86f42637203870a37b5d34693842c66e43aa1fa438c52ceb7dbc', '2024-11-02 20:07:46', '2024-11-02 15:07:46'),
('nachoabasualdo@gmail.com', 'c585e391aa6dedd6eb75c2ec545a2ea3230bf5a03671bed548bda4efdae2e8b00f5f50860539c8cb24506c381a678c1043d2', '2024-11-02 20:11:51', '2024-11-02 15:11:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `apellido` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `fnacimiento` date NOT NULL,
  `mail` varchar(200) NOT NULL,
  `contrase` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `foto_perfil` varchar(255) NOT NULL,
  `plan` enum('ninguno','basic','') NOT NULL DEFAULT 'ninguno',
  `fecha_suscripcion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`apellido`, `nombre`, `sexo`, `fnacimiento`, `mail`, `contrase`, `id`, `foto_perfil`, `plan`, `fecha_suscripcion`) VALUES
('Reartes', 'Luciano', 'Masculino', '2006-06-20', 'lucianoreartes575@gmail.com', 'T1M202lwa', 1, '', 'basic', NULL),
('basualdo', 'Nacho', 'Masculino', '2002-03-22', 'nachoabasualdo@gmail.com', 'pelotudo', 2, 'uploads/usuarios/fotosperfil/messi.jpg', 'basic', NULL),
('Basualdo', 'Diego', 'Masculino', '1975-03-22', 'crdbasualdo@gmail.com', 'pelotudo', 4, '', 'basic', NULL),
('Lipari', 'Vale', 'Femenino', '1981-08-15', 'valelipari@gmail.com', 'hola', 5, '../uploads/usuarios/fotosperfil/cristiano.jpg', 'ninguno', NULL),
('basualdo', 'marce', 'Masculino', '2002-04-22', 'marcedbasualdo@gmail.com', 'hola', 6, '', 'ninguno', NULL),
('BASUALDOD', 'marcelo', 'Masculino', '2002-04-22', 'marcedbasualdo@gmail.com', 'pelotudo', 7, '', 'ninguno', NULL),
('Ambrogi', 'Santiago', 'Masculino', '2002-12-12', 'santiagoambrogi72@gmail.com', 'fut', 8, '../uploads/usuarios/fotosperfil/logo.png', 'ninguno', NULL),
('Reartes', 'Luciano', 'Masculino', '2006-06-20', 'lucianoreartes999@gmail.com', 'cara', 9, '', 'ninguno', NULL),
('Martinez', 'Lolo', 'Masculino', '2001-12-23', 'lolomartinez@gmail.com', 'holita', 10, '', 'ninguno', NULL),
('Lipari', 'Vale', 'Femenino', '1988-11-02', 'mvalerialipari@gmail.com', 'hola', 11, '', 'ninguno', NULL),
('Basualdo', 'Ancho', 'Masculino', '2006-03-22', 'ignacioabasualdo22@gmail.com', 'hola', 12, '', 'ninguno', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `desarrolladores`
--
ALTER TABLE `desarrolladores`
  ADD PRIMARY KEY (`idesarrollador`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos_guardados`
--
ALTER TABLE `documentos_guardados`
  ADD PRIMARY KEY (`id_usuario`,`id_documento`),
  ADD KEY `id_documento` (`id_documento`);

--
-- Indices de la tabla `merchandising`
--
ALTER TABLE `merchandising`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reacciones_documentos`
--
ALTER TABLE `reacciones_documentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento_id` (`documento_id`,`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `desarrolladores`
--
ALTER TABLE `desarrolladores`
  MODIFY `idesarrollador` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `merchandising`
--
ALTER TABLE `merchandising`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reacciones_documentos`
--
ALTER TABLE `reacciones_documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documentos_guardados`
--
ALTER TABLE `documentos_guardados`
  ADD CONSTRAINT `documentos_guardados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documentos_guardados_ibfk_2` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
