-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2022 a las 05:08:38
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inserge`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `prueba_temporal` (IN `v_idM` CHAR(10), IN `v_idP` CHAR(10), IN `cantidad` INT, IN `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

INSERT INTO `tabla_proyecto_material`
(
    tabla_proyecto_material.codigo_proyecto,
    tabla_proyecto_material.codigo_material,
    tabla_proyecto_material.cantidad
)
VALUES (v_idP, v_idM, cantidad);

IF((SELECT productos.stock - productos.stockmin from productos WHERE productos.codigo_producto = v_idM) >= cantidad) THEN 

UPDATE productos SET productos.stock = productos.stock - cantidad WHERE productos.codigo_producto = v_idM;

set v_res = true;
ELSE 
ROLLBACK;
set v_res=false;
END IF;

commit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_acceso_usuario` (IN `v_id` INT, OUT `v_res` INT)   BEGIN 
	declare exit handler for SQLEXCEPTION begin rollback;
	set v_res=false;
end; 

start transaction;

update usuarios
set
    ultimo_acceso = now(),
    accesos = accesos + 1,
    sesion = sesion + 1
WHERE id_usuario = v_id;

commit;

set v_res=true;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_acceso_validar` (IN `v_usuario` VARCHAR(50))   BEGIN

SELECT u.id_usuario v1, initcap(pers.nombre) v2, u.usuario v3, u.contrasenia v4, u.ultimo_acceso v5, u.status v6,c.id_cargo v7 ,initcap(c.nombre) v8, teme v9 FROM usuarios u INNER JOIN permisos p ON u.id_cargo = p.id_cargo INNER JOIN rol r ON r.id_rol = p.id_rol INNER JOIN cargo c ON c.id_cargo = u.id_cargo INNER JOIN personas pers ON pers.id_persona = u.id_persona WHERE u.usuario = v_usuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_material` (IN `v_idM` CHAR(10))   BEGIN

SELECT
productos.id_producto v1,
productos.codigo_producto v2,
CASE productos.estado WHEN 0 THEN 'INACTIVO' WHEN 1 THEN 'ACTIVO' END v3,
productos.descripcion v4,
productos.unidad_medida v5,
unidadmedida.UndMedida v6,
productos.stock v7,
productos.stockmin v8,
productos.id_proveedor v9,
proveedores.razon_social v10,
productos.id_usuario v11,
usuarios.usuario v12
FROM
((productos
 INNER JOIN unidadmedida on productos.unidad_medida = unidadmedida.idMedida)
 INNER JOIN proveedores on productos.id_proveedor = proveedores.id_proveedores)
 INNER JOIN usuarios on productos.id_usuario = usuarios.id_usuario

 WHERE productos.codigo_producto = v_idM;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_proyecto` (IN `vid_P` CHAR(10))   BEGIN 

SELECT
proyecto.id_proyecto v1,
proyecto.cod_proyecto v2,
CASE proyecto.estado WHEN 'E' THEN 'ELEGIBLE' WHEN 'N' THEN 'NO ELEGIBLE' 
WHEN 'D' THEN 'DESEMBOLSADO' WHEN 'C' THEN 'CON OTRA ET'END v3,
proyecto.id_modulo v4,
modulos.Modulo v5,
proyecto.x v6,
proyecto.y v7,
proyecto.id_distrito v8,
distritos.nombre v9,
proyecto.direccion_proyecto v10,
proyecto.idPerson  v11,
CONCAT(personas.apellidoPAT,' ',personas.apellidoMAT,', ',personas.nombre) v12
FROM
((proyecto
INNER JOIN modulos ON modulos.id_modulo = proyecto.id_modulo)
INNER JOIN distritos ON distritos.id = proyecto.id_distrito)
INNER JOIN personas ON personas.id_persona = proyecto.idPerson

WHERE proyecto.cod_proyecto = vid_P;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_category_combo` ()   BEGIN
SELECT categoria.idCategoria v1, 
categoria.nombre v2
FROM categoria WHERE categoria.status='1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_category_insert` (IN `v1` VARCHAR(50), IN `v2` VARCHAR(100), IN `v3` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;
start transaction;
INSERT INTO `categoria`( `Nombre`, `Descripcion`, `fecha_registro`, `id_usuario`) VALUES 
(upper(v1),v2,current_timestamp(),v3);
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_category_list` ()   BEGIN
SELECT categoria.idCategoria v1, 
categoria.Nombre v2,
categoria.Descripcion v3,
categoria.fecha_registro v4,
categoria.id_usuario v5,
usuarios.usuario v6,
categoria.status v7,
case categoria.status when  0 then 'Inactivo' when  1 then 'Activo' end v8
FROM categoria inner join usuarios on categoria.id_usuario = usuarios.id_usuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_category_resume` ()   BEGIN

SELECT COUNT(*) as Total,

round((select count(*) from categoria where categoria.status = '0')*100/(select count(*) from categoria), 2) as 'Inactivo %' ,

round((select count(*) from categoria where categoria.status = '1')*100/(select count(*) from categoria), 2) as 'Activo %'

from categoria where categoria.status = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_category_update` (IN `v1` VARCHAR(50), IN `v2` VARCHAR(100), IN `v3` INT(11), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

UPDATE `categoria` SET 
`Nombre`= v1,
`Descripcion`= v2,
`status`= v3 WHERE `idCategoria`= vID;

commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cerrar_usuario` (IN `v_id` INT, OUT `v_res` INT)   BEGIN 
	declare exit handler for SQLEXCEPTION begin rollback;
	set v_res=false;
end; 

start transaction;

update usuarios set sesion = if(sesion=1,0,1) WHERE id_usuario = v_id;

commit;

set v_res=true;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_conceder_permisos` (IN `v_idCargo` INT)   BEGIN
SELECT p.id_rol v1, initcap(TRIM(r.titulo)) v2, P.status v3 FROM permisos p INNER JOIN rol r ON r.id_rol = p.id_rol WHERE p.id_cargo = v_idCargo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_convocatoria_combo` ()   BEGIN
SELECT convocatorias.idConvocatoria v1, 
convocatorias.nombre v2
FROM convocatorias WHERE convocatorias.status='1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_convocatoria_insert` (IN `v1` VARCHAR(6), IN `v2` VARCHAR(50), IN `v3` DATE, IN `v4` DATE, IN `v5` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;
start transaction;

INSERT INTO `convocatorias`(`nombre`, `descripcion`, `inicio`, `fin`, `fecha_registro`, `id_usuario`) VALUES (v1,v2,v3,v4,current_timestamp(),v5);
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_convocatoria_list` ()   BEGIN
SELECT convocatorias.idConvocatoria v1, 
convocatorias.nombre v2,
convocatorias.descripcion v3,
convocatorias.inicio v4,
convocatorias.fin v5,
convocatorias.fecha_registro v6,
convocatorias.id_usuario v7,
usuarios.usuario v8,
convocatorias.status v9,
case convocatorias.status when  0 then 'Inactivo' when  1 then 'Activo' end v10
FROM convocatorias inner join usuarios on convocatorias.id_usuario = usuarios.id_usuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_convocatoria_resume` ()   BEGIN

SELECT COUNT(*) as Total,

round((select count(*) from convocatorias where convocatorias.status = '0')*100/(select count(*) from convocatorias),2) as 'Inactivo %' ,

round((select count(*) from convocatorias where convocatorias.status = '1')*100/(select count(*) from convocatorias),2) as 'Activo %',

(SELECT convocatorias.nombre FROM convocatorias where convocatorias.status = '1' and (TIMESTAMPDIFF(DAY, convocatorias.fin, CURDATE()) <= '0'
or convocatorias.fin is null 
or convocatorias.fin = '0000-00-00'
or convocatorias.fin = '') ORDER BY convocatorias.inicio DESC limit 1) as 'last',

round((SELECT COUNT(*) FROM convocatorias where convocatorias.status = '1' and TIMESTAMPDIFF(DAY, convocatorias.fin, CURDATE()) > '0')*100/(select count(*) from convocatorias where convocatorias.status = '1'),2) as 'Caducada %',

round((SELECT COUNT(*) FROM convocatorias where convocatorias.status = '1' and (TIMESTAMPDIFF(DAY, convocatorias.fin, CURDATE()) <= '0'
or convocatorias.fin is null 
or convocatorias.fin = '0000-00-00'
or convocatorias.fin = ''))*100/(select count(*) from convocatorias where convocatorias.status = '1'),2) as 'Vigente %'

from convocatorias where convocatorias.status = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_convocatoria_update` (IN `v1` VARCHAR(6), IN `v2` VARCHAR(50), IN `v3` DATE, IN `v4` DATE, IN `v5` INT(11), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

UPDATE `convocatorias` SET 
`nombre`= v1,
`descripcion`= v2,
`inicio`=v3,
`fin`= v4,
`status`= v5 WHERE `idConvocatoria`= vID;

commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_departamento_list` ()   BEGIN
SELECT departamentos.id v1 , departamentos.nombre v2 from departamentos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_detalle_producto_drop_list` ()   BEGIN
SELECT detalle_producto.id_producto v1,
productos.descripcion v2,
detalle_producto.observacion v3,
detalle_producto.motivo v4,
case detalle_producto.motivo when  1 then 'Venta' when  2 then 'Perdida' when  3 then 'Descomposición' end v5,
if(detalle_producto.cantidad=1,concat(detalle_producto.cantidad,' ',unidadmedida.UndMedida),concat(detalle_producto.cantidad,' ',unidadmedida.PlrMedida)) v6,
detalle_producto.fecha v7,
detalle_producto.hora v8,
detalle_producto.id_proveedor v9,
proveedores.razon_social v10,
detalle_producto.fecha_registro v11,
detalle_producto.id_usuario v12,
usuarios.usuario v13
FROM (((detalle_producto inner join usuarios on detalle_producto.id_usuario = usuarios.id_usuario) 
INNER JOIN proveedores on proveedores.id_proveedores = detalle_producto.id_proveedor) INNER JOIN productos on productos.id_producto = detalle_producto.id_producto) INNER JOIN unidadmedida on unidadmedida.idMedida = productos.unidad_medida WHERE detalle_producto.motivo= '1' OR detalle_producto.motivo= '2' or detalle_producto.motivo= '3' Order by (detalle_producto.fecha_registro) DESC LIMIT 10;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_detalle_producto_inst_list` ()   BEGIN
SELECT detalle_producto.id_producto v1,
productos.descripcion v2,
detalle_producto.observacion v3,
detalle_producto.motivo v4,
case detalle_producto.motivo when  4 then 'Compra' when  5 then 'Donación' end v5,
if(detalle_producto.cantidad=1,concat(detalle_producto.cantidad,' ',unidadmedida.UndMedida),concat(detalle_producto.cantidad,' ',unidadmedida.PlrMedida)) v6,
detalle_producto.fecha v7,
detalle_producto.hora v8,
detalle_producto.id_proveedor v9,
proveedores.razon_social v10,
detalle_producto.fecha_registro v11,
detalle_producto.id_usuario v12,
usuarios.usuario v13
FROM (((detalle_producto inner join usuarios on detalle_producto.id_usuario = usuarios.id_usuario) 
INNER JOIN proveedores on proveedores.id_proveedores = detalle_producto.id_proveedor) INNER JOIN productos on productos.id_producto = detalle_producto.id_producto) INNER JOIN unidadmedida on unidadmedida.idMedida = productos.unidad_medida WHERE detalle_producto.motivo= '4' OR detalle_producto.motivo= '5' Order by (detalle_producto.fecha_registro) DESC LIMIT 10;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_distrito_list` (IN `v1` CHAR(4))   BEGIN

SELECT distritos.id v1, distritos.nombre v2 from distritos WHERE distritos.id_provincia = `v1` ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_editar_usuario` (IN `v_idCargo` INT, IN `v_idStatus` INT, IN `v_id` INT, OUT `v_res` INT)   BEGIN 
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;
start transaction;
update usuarios set usuarios.id_cargo = v_idCargo, usuarios.status = v_idStatus WHERE usuarios.id_usuario = v_id;
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_foto_drop` (IN `v1` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;
DELETE FROM fotos WHERE fotos.id_foto = v1;

commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_foto_insert` (IN `v1` VARCHAR(50), IN `v2` VARCHAR(200), IN `v3` INT(11), IN `v4` DATE, IN `v5` INT(11), IN `v6` INT(11), IN `v7` INT(11), IN `v8` INT(11), IN `v9` INT(11), IN `v10` INT(11), IN `v11` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

INSERT INTO `fotos`
(`descripcion`,
 `ruta_foto`,
 `tipo`,
 `fecha`,
 `id_modulo`,
 `idPerson`,
 `idProyect`,
 `idConv`,
 `idProc`,
 `idProv`,
 `fecha_registro`,
 `id_usuario`) VALUES 
 (v1,
  v2,
  v3,
  v4,
  v5,
  v6,
  v7,
  v8,
  v9,
  v10,
  current_timestamp(),
  v11);
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_foto_list` ()   BEGIN

SELECT fotos.id_foto v1, 
fotos.ruta_foto v2,
fotos.descripcion v3,
fotos.fecha v4,
fotos.fecha_registro v5,
fotos.id_modulo v6,
modulos.Modulo v7,
fotos.idPerson v8,
concat(personas.apellidoPAT,' ',personas.apellidoMAT,', ',personas.nombre) v9,
fotos.idProyect v10,
proyecto.cod_proyecto v11,
fotos.idConv v12,
convocatorias.nombre v13,
fotos.idProc v14,
productos.descripcion v15,
fotos.idProv v16,
proveedores.razon_social v17,
fotos.id_usuario v18,
usuarios.usuario v19,
fotos.tipo v20
FROM 
((((((fotos LEFT JOIN personas on personas.id_persona = fotos.idPerson) 
 LEFT join modulos on modulos.id_modulo=fotos.id_modulo)
 LEFT join proyecto on proyecto.id_proyecto= fotos.idProyect) 
 LEFT JOIN productos on productos.id_producto=fotos.idProc) 
 LEFT JOIN proveedores on proveedores.id_proveedores=fotos.idProv) 
 LEFT JOIN convocatorias on convocatorias.idConvocatoria=fotos.idConv)
 INNER JOIN usuarios on usuarios.id_usuario=fotos.id_usuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_foto_resume` ()   BEGIN

SELECT COUNT(*) as Total,

round((select count(*) from fotos where fotos.tipo = '0')*100/(select count(*) from fotos),2) as 'Otro',

round((select count(*) from fotos where fotos.tipo = '1')*100/(select count(*) from fotos),2) as 'Archivo',

round((select count(*) from fotos where fotos.tipo = '2')*100/(select count(*) from fotos),2) as 'Fotografia',

round((select count(*) from fotos where fotos.tipo = '3')*100/(select count(*) from fotos),2) as 'Render',

round((select count(*) from fotos where fotos.tipo = '4')*100/(select count(*) from fotos),2) as 'Documentación',

round((select count(*) from fotos where fotos.tipo = '5')*100/(select count(*) from fotos),2) as 'Perfil'

from fotos;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_permisos` ()   BEGIN

SELECT id_rol v1, titulo v2 FROM rol;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_PM` ()   BEGIN 

SELECT
tabla_proyecto_material.codigo_proyecto v1,
tabla_proyecto_material.codigo_material v2,
productos.descripcion v3,
tabla_proyecto_material.cantidad v4,
tabla_proyecto_material.fecha_registro v5

FROM (tabla_proyecto_material
INNER JOIN proyecto ON proyecto.cod_proyecto = tabla_proyecto_material.codigo_proyecto)
INNER JOIN productos ON productos.codigo_producto = tabla_proyecto_material.codigo_material;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_roles` ()   BEGIN

SELECT id_cargo v1, initcap(nombre) v2 FROM cargo;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_usuarios` ()   BEGIN

SELECT p.Identificacion v1, initcap(CONCAT(p.nombre , " " , p.apellidoPAT , " " ,p.apellidoMAT)) v2, u.usuario v3, u.ultimo_acceso v4, initcap(c.nombre) v5, u.status v6, u.id_usuario v7 FROM usuarios u INNER JOIN personas p ON u.id_persona = p.id_persona INNER JOIN cargo c ON u.id_cargo = c.id_cargo;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listtheme` (IN `vID` INT)   BEGIN

SELECT  usuarios.teme from usuarios where usuarios.id_usuario = vID;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modulo_combo` ()   BEGIN
SELECT modulos.id_modulo v1, 
modulos.Modulo v2
FROM modulos WHERE modulos.status = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modulo_insert` (IN `v1` VARCHAR(6), IN `v2` VARCHAR(50), IN `v3` VARCHAR(6), IN `v4` VARCHAR(6), IN `v5` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;
start transaction;

INSERT INTO `modulos`(`Modulo`, `descripcion`, `ATechada`, `AConstruida`, `fecha_registro`, `id_usuario`) VALUES (v1,v2,v3,v4,current_timestamp(),v5);
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modulo_list` ()   BEGIN
SELECT modulos.id_modulo v1, 
modulos.Modulo v2, 
modulos.descripcion v3, 
modulos.ATechada v4, 
modulos.AConstruida v5,
modulos.fecha_registro v6, 
modulos.id_usuario v7, 
usuarios.usuario v8,
modulos.status v9,
case modulos.status when  0 then 'Inactivo' when  1 then 'Activo' end v10
FROM modulos inner join usuarios on modulos.id_usuario = usuarios.id_usuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modulo_resume` ()   BEGIN

SELECT COUNT(*) as Total,

round((select count(*) from modulos where modulos.status = '0')*100/(select count(*) from modulos),2) as 'Inactivo %' ,

round((select count(*) from modulos where modulos.status = '1')*100/(select count(*) from modulos),2) as 'Activo %'

from modulos where modulos.status = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modulo_update` (IN `v1` VARCHAR(6), IN `v2` VARCHAR(50), IN `v3` VARCHAR(6), IN `v4` VARCHAR(6), IN `v5` INT(11), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

UPDATE `modulos` SET 
`Modulo`= v1,
`descripcion`= v2,
`ATechada`= v3,
`AConstruida`= v4,
`status`= v5
WHERE modulos.id_modulo = vID;

commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_person_combo` ()   BEGIN
SELECT personas.id_persona v1 , 
initcap(CONCAT(personas.apellidoPAT,' ',personas.apellidoMAT,', ',personas.nombre))  v2
FROM `personas` WHERE personas.status = '1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_person_delete` (IN `v1` INT(11))   BEGIN

UPDATE `personas` SET `status`= 0 WHERE `id_persona`= v1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_person_insert` (IN `v1` VARCHAR(11), IN `v2` VARCHAR(50), IN `v3` VARCHAR(50), IN `v4` VARCHAR(50), IN `v5` CHAR(1), IN `v6` VARCHAR(50), IN `v7` CHAR(6), IN `v8` CHAR(1), IN `v9` VARCHAR(9), IN `v10` VARCHAR(50), IN `v11` VARCHAR(50), IN `v12` DATE, IN `v13` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;
INSERT INTO `personas`( `identificacion`, `nombre`, `apellidoPAT`, `apellidoMAT`, `sexo`, `direccion`,iddistrito, `estado_civil`, `telefono`, `email`, `profesion`,nacimiento, `fecha_registro`, `id_usuario`) 
VALUES (v1,upper(v2),upper(v3),upper(v4),v5,upper(v6),v7,v8,v9,upper(v10),upper(v11),v12,current_timestamp(),v13);
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_person_list` ()   BEGIN
SELECT personas.id_persona v1 , 
personas.Identificacion v2 ,
initcap(personas.nombre) v3 , 
initcap(personas.apellidoPAT) v4 ,
initcap(personas.apellidoMAT) v5 ,
personas.sexo v6,
case personas.sexo when 'M' then 'Masculino' when 'F' then 'Femenino' when 'N' then 'No especifica' end v7,
personas.direccion v8,
personas.estado_civil v9,
case personas.estado_civil when  0 then 'Soltero' when  1 then 'Casado' when  2 then 'Divorciado' when  3 then 'Viudo' end v10,
personas.telefono v11,
personas.email v12 ,
personas.profesion v13 ,
personas.fecha_registro v14,
personas.id_usuario v15,
personas.iddistrito v16,
distritos.nombre v17,
distritos.id_provincia v18,
provincias.nombre v19,
provincias.id_departamento v20,
departamentos.nombre v21,
personas.id_usuario v22,
usuarios.usuario v23 ,personas.status v24 ,
case personas.status when  0 then 'Inactivo' when  1 then 'Activo' end v25, nacimiento v26
FROM (((`personas`
inner join distritos on personas.iddistrito = distritos.id)
inner join usuarios on personas.id_usuario = usuarios.id_usuario)
inner join departamentos on distritos.id_departamento = departamentos.id) 
inner join provincias on distritos.id_provincia = provincias.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_person_resume` ()   BEGIN

SELECT COUNT(*) as Total,

round((select count(*) from personas where personas.status = '1' AND TIMESTAMPDIFF(DAY, personas.fecha_registro, CURDATE()) = '0'),2) as 'Registrados Hoy',

round((select count(*) from personas where personas.status = '0')*100/(select count(*) from personas),2) as 'Inactivo %' ,

round((select count(*) from personas where personas.status = '1')*100/(select count(*) from personas),2) as 'Activo %',

(SELECT concat(personas.apellidoPAT,' ',personas.apellidoMAT,', ',personas.nombre) FROM personas where personas.status = '1' ORDER BY personas.id_persona DESC limit 1) as 'last',

(SELECT ROUND(AVG(TIMESTAMPDIFF(YEAR, personas.nacimiento, CURDATE())),0)
FROM personas WHERE personas.nacimiento is not null and personas.nacimiento <> '0000-00-00'
HAVING TIMESTAMPDIFF(YEAR, personas.nacimiento, CURDATE()) > 0) as Edad_Promedio,

round((select count(*) from personas 
 where personas.direccion is not null 
 and personas.direccion <> ''
 and personas.telefono is not null 
 and personas.telefono <> ''
 and personas.email is not null 
 and personas.email <> ''
 and personas.profesion is not null 
 and personas.profesion <> ''
 and personas.nacimiento is not null 
 and personas.nacimiento <> ''
 and personas.nacimiento <> '0000-00-00'
 and personas.status = '1')
 *100/(select count(*) from personas where personas.status = '1'),2)
 as 'Completo %' ,

round((select count(*) from personas 
 where (personas.direccion is null 
 or personas.direccion = ''
 or personas.telefono is null 
 or personas.telefono = ''
 or personas.email is null 
 or personas.email = ''
 or personas.profesion is null 
 or personas.profesion = ''
 or personas.nacimiento is null
 or personas.nacimiento = ''
 or personas.nacimiento = '0000-00-00') 
 AND personas.status = '1')
 *100/(select count(*) from personas where personas.status = '1'),2)
  as 'Incompleto %',
 
 
round((select count(*) from personas where personas.status = '1' and personas.sexo ='M')*100/(select count(*) from personas where personas.status = '1'),2) as 'Masculino %' ,

round((select count(*) from personas where personas.status = '1' and personas.sexo ='F')*100/(select count(*) from personas where personas.status = '1'),2) as 'Femenino %',

round((select count(*) from personas where personas.status = '1' and personas.sexo ='N')*100/(select count(*) from personas where personas.status = '1'),2) as 'No especifica %'

from personas where personas.status = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_person_update` (IN `v1` VARCHAR(11), IN `v2` VARCHAR(50), IN `v3` VARCHAR(50), IN `v4` VARCHAR(50), IN `v5` CHAR(1), IN `v6` VARCHAR(50), IN `v7` CHAR(6), IN `v8` CHAR(1), IN `v9` VARCHAR(9), IN `v10` VARCHAR(50), IN `v11` VARCHAR(50), IN `v12` DATE, IN `v13` INT(11), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

UPDATE `personas` 
SET `identificacion`=v1,
`nombre`=upper(v2),
`apellidoPAT`=upper(v3),
`apellidoMAT`=upper(v4),
`sexo`=v5,
`direccion`=upper(v6),
`iddistrito`=v7,
`estado_civil`=v8,
`telefono`=v9,
`email`=upper(v10),
`profesion`=upper(v11),
`nacimiento`=v12,
`status`=v13 WHERE id_persona = vID;

commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_producto_combo` ()   BEGIN
SELECT productos.id_producto v1, productos.descripcion v2, productos.codigo_producto v3, productos.stock v4, productos.id_proveedor v5
FROM productos WHERE productos.estado='1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_producto_delete` (IN `v1` INT(11))   BEGIN

UPDATE `productos` SET `estado`= 0 WHERE `id_producto`= v1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_producto_detalle_drop` (IN `v1` VARCHAR(50), IN `v2` TINYINT(1), IN `v3` INT(11), IN `v4` DATE, IN `v5` TIME, IN `v6` INT(11), IN `v7` INT(11), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

INSERT INTO detalle_producto(`id_producto`, `observacion`, `motivo`, `cantidad`, `fecha`, `hora`, `id_proveedor`, `fecha_registro`, `id_usuario`)
VALUES (vID,v1,v2,v3,v4,v5,v6,current_timestamp(),v7);

IF ((Select productos.stock - productos.stockmin from productos WHERE productos.id_producto = vID) >= v3) THEN
        UPDATE productos SET productos.stock = productos.stock - v3 WHERE productos.id_producto = vID;
        
set v_res=true;
ELSE 
ROLLBACK;
set v_res=false;
END IF;

commit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_producto_detalle_insert` (IN `v1` VARCHAR(50), IN `v2` TINYINT(1), IN `v3` INT(11), IN `v4` DATE, IN `v5` TIME, IN `v6` INT(11), IN `v7` INT(11), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

INSERT INTO detalle_producto(`id_producto`, `observacion`, `motivo`, `cantidad`, `fecha`, `hora`, `id_proveedor`, `fecha_registro`, `id_usuario`)
VALUES (vID,v1,v2,v3,v4,v5,v6,current_timestamp(),v7);
IF (v2 > 0) THEN
UPDATE productos SET productos.stock = productos.stock + v3 WHERE productos.id_producto = vID;
set v_res=true;
ELSE 
ROLLBACK;
set v_res=false;
END IF;
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_producto_insert` (IN `v1` CHAR(10), IN `v2` VARCHAR(50), IN `v3` INT(11), IN `v4` INT(11), IN `v5` INT(11), IN `v6` DATE, IN `v7` TIME, IN `v8` INT(11), IN `v9` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;
INSERT INTO `productos`(`codigo_producto`,`descripcion`, `unidad_medida`, `stock`,`stockmin`,`fecha`,`hora`, `id_proveedor`, `fecha_registro`, `id_usuario`) 
VALUES (v1,upper(v2),v3,v4,v5,v6,v7,v8,current_timestamp(),v9);

commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_producto_list` ()   BEGIN
SELECT productos.id_producto vid,productos.codigo_producto v1, productos.descripcion v2, productos.unidad_medida v3, unidadmedida.UndMedida v4,
case productos.estado when  0 then 'Inactivo' when  1 then 'Activo' when  2 then 'Sin stock' end v5, productos.stock v6, productos.stockmin v7, productos.fecha v8, productos.hora v9, productos.id_proveedor v10 ,proveedores.razon_social v11, productos.fecha_registro v12, productos.id_usuario v13, usuarios.usuario v14 FROM ((productos inner join usuarios on productos.id_usuario = usuarios.id_usuario) INNER JOIN proveedores on productos.id_proveedor = proveedores.id_proveedores) INNER JOIN unidadmedida on productos.unidad_medida = unidadmedida.idMedida;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proveedor_combo` ()   BEGIN
SELECT proveedores.id_proveedores v1, proveedores.razon_social v2
FROM `proveedores` WHERE proveedores.estado = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proveedor_insert` (IN `v1` VARCHAR(11), IN `v2` VARCHAR(50), IN `v3` VARCHAR(50), IN `v4` VARCHAR(15), IN `v5` VARCHAR(50), IN `v6` CHAR(50), IN `v7` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;
INSERT INTO `proveedores`(`RUC`, `razon_social`, `email`, `telefono`, `direccion`, `id_distrito`, `fecha_registro`, `id_usuario`) 
VALUES (v1,upper(v2),v3,v4,upper(v5),v6,current_timestamp(),v7);
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proveedor_list` ()   BEGIN
SELECT proveedores.id_proveedores v1, proveedores.RUC v2, proveedores.razon_social v3, proveedores.email v4, proveedores.telefono v5,
proveedores.direccion v6, proveedores.id_distrito v7, distritos.nombre v8, distritos.id_provincia v9, provincias.nombre v10, provincias.id_departamento v11, departamentos.nombre v12,
proveedores.fecha_registro v13, proveedores.id_usuario v14, usuarios.usuario v15, proveedores.estado v16, 
case proveedores.estado when  0 then 'Inactivo' when  1 then 'Activo' end v17
FROM (((`proveedores`
inner join distritos on proveedores.id_distrito = distritos.id)
inner join usuarios on proveedores.id_usuario = usuarios.id_usuario)
inner join departamentos on distritos.id_departamento = departamentos.id) inner join provincias on distritos.id_provincia = provincias.id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proveedor_resume` ()   BEGIN

SELECT COUNT(*) as Total,

round((select count(*) from proveedores where proveedores.estado = '0')*100/(select count(*) from proveedores),2) as 'Inactivo %',

round((select count(*) from proveedores where proveedores.estado = '1')*100/(select count(*) from proveedores),2) as 'Activo %',

(SELECT proveedores.razon_social FROM proveedores where proveedores.estado = '1' ORDER BY proveedores.id_proveedores DESC limit 1) as 'last',

(SELECT proveedores.razon_social FROM productos inner join proveedores on proveedores.id_proveedores=productos.id_proveedor GROUP BY productos.id_proveedor HAVING COUNT(*) = ( SELECT MAX(contador) max_contador FROM ( SELECT productos.id_proveedor, COUNT(*) contador FROM productos GROUP BY productos.id_proveedor) T) ORDER BY proveedores.id_proveedores DESC limit 1) as 'pepe'

from proveedores where proveedores.estado = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proveedor_update` (IN `v1` VARCHAR(11), IN `v2` VARCHAR(50), IN `v3` VARCHAR(50), IN `v4` VARCHAR(15), IN `v5` VARCHAR(50), IN `v6` CHAR(50), IN `v7` INT(1), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;
UPDATE `proveedores` 
SET 
`RUC`=v1,
`razon_social`=upper(v2),
`email`=v3,
`telefono`=v4,
`direccion`=upper(v5),
`id_distrito`=v6
WHERE `id_proveedores`=vID;

UPDATE `proveedores` SET `estado`= v7 WHERE `id_proveedores` = vID;


commit;
set v_res=true;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_provincia_list` (IN `vPRO` CHAR(4))   BEGIN

SELECT provincias.id v1, provincias.nombre v2 from provincias WHERE provincias.id_departamento = vPRO ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proyect_insert` (IN `v1` VARCHAR(10), IN `v2` VARCHAR(10), IN `v3` INT(11), IN `v4` INT(11), IN `v5` CHAR(1), IN `v6` INT(11), IN `v7` VARCHAR(50), IN `v8` VARCHAR(50), IN `v9` VARCHAR(50), IN `v10` VARCHAR(10), IN `v11` VARCHAR(10), IN `v12` VARCHAR(50), IN `v13` FLOAT, IN `v14` VARCHAR(50), IN `v15` FLOAT, IN `v16` VARCHAR(50), IN `v17` FLOAT, IN `v18` VARCHAR(50), IN `v19` FLOAT, IN `v20` FLOAT, IN `v21` FLOAT, IN `v22` FLOAT, IN `v23` FLOAT, IN `v24` FLOAT, IN `v25` FLOAT, IN `v26` CHAR(50), IN `v27` DATE, IN `v28` TINYINT, IN `v29` TINYINT, IN `v30` TINYINT, IN `v31` TINYINT, IN `v32` VARCHAR(30), IN `v33` INT(11), OUT `v_res` INT)   BEGIN
    DECLARE EXIT
HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK
        ;
    SET
        v_res = FALSE ;
END ;
START TRANSACTION
    ;

INSERT INTO `proyecto`(
    `cod_proyecto`,
    `NContrato`,
    `idConv`,
    `idPerson`,
    `estado`,
    `id_modulo`,
    `sector`,
    `tipoUrb`,
    `direccion_proyecto`,
    `Mz`,
    `Lote`,
    `Frente`,
    `FrenteM`,
    `Derecha`,
    `DerechaM`,
    `Izquierda`,
    `IzquierdaM`,
    `Fondo`,
    `FondoM`,
    `Area`,
    `Arancel`,
    `CVU`,
    `VObra`,
    `x`,
    `y`,
    `id_distrito`,
    `Fecha`,
    `Luz`,
    `agua`,
    `desague`,
    `Pseptico`,
    `directorio`,
    `fecha_registro`,
    `id_usuario`
)
VALUES(v1,v2,v3,v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18,v19,v20,v21,v22,v23,v24,v25,v26
    ,v27,v28,v29,v30,v31,v32,CURRENT_TIMESTAMP(),v33);
COMMIT
    ;
SET
    v_res = TRUE ; END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proyect_list` ()   BEGIN
SELECT 
proyecto.cod_proyecto v1,
proyecto.NContrato v2,
convocatorias.nombre v3,
initcap(concat(personas.apellidoPAT,' ',personas.apellidoMAT, ', ', personas.nombre)) v4,
personas.Identificacion v5,
proyecto.estado v6,
modulos.Modulo v7,
modulos.ATechada v8,
modulos.AConstruida v9,
proyecto.sector v10,
concat(case proyecto.tipoUrb 
when  1 then 'Urb. Urbanización: ' 
when  2 then 'P.J. Pueblo Joven: ' 
when  3 then 'U.V. Unidad Vecinal: '
when  4 then 'C.H. Conjunto Habitacional: '
when  5 then 'A.H. Asentamiento Humano: '
when  6 then 'Coo. Cooperativa: '
when  7 then 'Res. Residencial: '
when  8 then 'Z.I. Zona Industrial: '
when  9 then 'Gru. Grupo: '
when  10 then 'Cas. Caserio: '
when  11 then 'Fnd. Fundo: '
when  12 then ' '
when  -1 then ' ' end,
proyecto.direccion_proyecto) v11,
proyecto.Mz v12,
proyecto.Lote v13,
proyecto.Frente v14,
proyecto.FrenteM v15,
proyecto.Derecha v16,
proyecto.DerechaM v17,
proyecto.Izquierda v18,
proyecto.IzquierdaM v19,
proyecto.Fondo v20,
proyecto.FondoM v21,
proyecto.Area v22, 
proyecto.Arancel v23,
proyecto.CVU v24,
proyecto.VObra v25,
proyecto.x v27,
proyecto.y v28,
distritos.nombre v29,
provincias.nombre v30,
departamentos.nombre v31,
proyecto.Alcalde v32,
proyecto.fecha_registro v33,
proyecto.Luz v34,
proyecto.agua v35,
proyecto.desague v36,
proyecto.Pseptico v37,
proyecto.directorio v38,
proyecto.fecha_registro v39,
usuarios.usuario v40
FROM ((((((proyecto 
         inner join convocatorias on convocatorias.idConvocatoria = proyecto.idConv) 
      INNER JOIN personas on personas.id_persona = proyecto.idPerson) 
      inner join modulos on modulos.id_modulo = proyecto.id_modulo)
      inner join usuarios on usuarios.id_usuario = proyecto.id_usuario)
      inner join distritos on distritos.id =proyecto.id_distrito)
      inner join provincias on provincias.id = distritos.id_provincia)
      inner JOIN departamentos on departamentos.id = distritos.id_departamento;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proyect_resume` ()   BEGIN

SELECT COUNT(*) as Total,

round((select count(*) from proyecto where TIMESTAMPDIFF(DAY, proyecto.fecha_registro, CURDATE()) = '0'),2) as 'Registrados Hoy',

(SELECT convocatorias.nombre FROM convocatorias where convocatorias.status = '1' and (TIMESTAMPDIFF(DAY, convocatorias.fin, CURDATE()) <= '0'
or convocatorias.fin is null 
or convocatorias.fin = '0000-00-00'
or convocatorias.fin = '') ORDER BY convocatorias.inicio DESC limit 1) as 'lastConv',

round((select count(*) from proyecto where proyecto.estado = 'E')*100/(select count(*) from proyecto),2) as 'EL %' ,

round((select count(*) from proyecto where proyecto.estado = 'N')*100/(select count(*) from proyecto),2) as 'NE %',

round((select count(*) from proyecto where proyecto.estado = 'D')*100/(select count(*) from proyecto),2) as 'DE %',

round((select count(*) from proyecto where proyecto.estado = 'C')*100/(select count(*) from proyecto),2) as 'CN %',

(SELECT initcap(concat(personas.apellidoPAT,' ',personas.apellidoMAT,', ',personas.nombre)) FROM proyecto INNER JOIN personas on personas.id_persona = proyecto.idPerson ORDER BY proyecto.id_proyecto DESC limit 1) as 'last'

from proyecto ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proyect_search` (IN `v1` INT(11), IN `v2` VARCHAR(50))   BEGIN
SELECT 
proyecto.cod_proyecto v1,
proyecto.NContrato v2,
convocatorias.nombre v3,
initcap(concat(personas.apellidoPAT,' ',personas.apellidoMAT, ', ', personas.nombre)) v4,
personas.Identificacion v5,
proyecto.estado v6,
proyecto.id_modulo v7,
proyecto.sector v8,
proyecto.tipoUrb v9,
proyecto.direccion_proyecto v11,
proyecto.Mz v12,
proyecto.Lote v13,
proyecto.Frente v14,
proyecto.FrenteM v15,
proyecto.Derecha v16,
proyecto.DerechaM v17,
proyecto.Izquierda v18,
proyecto.IzquierdaM v19,
proyecto.Fondo v20,
proyecto.FondoM v21,
proyecto.Area v22, 
proyecto.Arancel v23,
proyecto.CVU v24,
proyecto.VObra v25,
proyecto.x v27,
proyecto.y v28,
distritos.nombre v29,
provincias.nombre v30,
departamentos.nombre v31,
proyecto.Alcalde v32,
proyecto.Fecha v33,
proyecto.Luz v34,
proyecto.agua v35,
proyecto.desague v36,
proyecto.Pseptico v37,
proyecto.directorio v38,
proyecto.id_proyecto v39
FROM (((((proyecto 
         inner join convocatorias on convocatorias.idConvocatoria = proyecto.idConv) 
      INNER JOIN personas on personas.id_persona = proyecto.idPerson) 
      inner join modulos on modulos.id_modulo = proyecto.id_modulo)
      inner join distritos on distritos.id =proyecto.id_distrito)
      inner join provincias on provincias.id = distritos.id_provincia)
      inner JOIN departamentos on departamentos.id = distritos.id_departamento where 
      case
	when v1 = 1 then (proyecto.cod_proyecto =v2)
	when v1 = 2 then (proyecto.NContrato =v2)
    when v1 = 3 then (personas.Identificacion = v2)
    end;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proyect_update` (IN `v1` VARCHAR(10), IN `v2` VARCHAR(10), IN `v3` CHAR(1), IN `v4` INT(11), IN `v5` VARCHAR(50), IN `v6` VARCHAR(50), IN `v7` VARCHAR(50), IN `v8` VARCHAR(10), IN `v9` VARCHAR(10), IN `v10` VARCHAR(50), IN `v11` FLOAT, IN `v12` VARCHAR(50), IN `v13` FLOAT, IN `v14` VARCHAR(50), IN `v15` FLOAT, IN `v16` VARCHAR(50), IN `v17` FLOAT, IN `v18` FLOAT, IN `v19` FLOAT, IN `v20` FLOAT, IN `v21` FLOAT, IN `v22` FLOAT, IN `v23` FLOAT, IN `v24` DATE, IN `v25` TINYINT, IN `v26` TINYINT, IN `v27` TINYINT, IN `v28` TINYINT, IN `vID` INT(11), OUT `v_res` INT)   BEGIN
    DECLARE EXIT
HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK
        ;
    SET
        v_res = FALSE ;
END ;
START TRANSACTION
    ;
UPDATE
    `proyecto`
SET
    `cod_proyecto` = v1,
    `NContrato` = v2,
    `estado` = v3,
    `id_modulo` = v4,
    `sector` = v5,
    `tipoUrb` = v6,
    `direccion_proyecto` = v7,
    `Mz` = v8,
    `Lote` = v9,
    `Frente` = v10,
    `FrenteM` = v11,
    `Derecha` = v12,
    `DerechaM` = v13,
    `Izquierda` = v14,
    `IzquierdaM` = v15,
    `Fondo` = v16,
    `FondoM` = v17,
    `Area` = v18,
    `Arancel` = v19,
    `CVU` = v20,
    `VObra` = v21,
    `x` = v22,
    `y` = v23,
    `Fecha` = v24,
    `Luz` = v25,
    `agua` = v26,
    `desague` = v27,
    `Pseptico` = v28
    WHERE proyecto.id_proyecto = vID;
COMMIT
    ;
SET
    v_res = TRUE ; END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_PM` (IN `v_idP` CHAR(10), IN `v_idM` CHAR(10), IN `cantidad` INT, OUT `v_res` INT)   BEGIN

declare exit handler
for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;
start transaction;


INSERT INTO `tabla_proyecto_material`
(
    tabla_proyecto_material.codigo_proyecto,
    tabla_proyecto_material.codigo_material,
    tabla_proyecto_material.cantidad
)
VALUES (v_idP, v_idM, cantidad);
UPDATE `productos` SET `stock` = `stock` - cantidad
WHERE productos.codigo_producto = v_idM AND productos.stock > cantidad;

commit;
set v_res = true;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_usuario` (IN `v_IdPersona` INT, IN `v_usuario` VARCHAR(20), IN `v_contrasenia` VARCHAR(200), IN `v_cargo` INT, IN `v_registrado` INT, OUT `v_res` INT)   BEGIN 
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;
insert into usuarios (id_persona,usuario,contrasenia,id_cargo,fecha_registro,status,registrado_por) values (v_IdPersona,v_usuario,v_contrasenia,v_cargo,now(),1, v_registrado);
commit;

set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_resumen_movimientos` ()   BEGIN

SELECT SUM(productos.stock) AS 'TotalStock',

(select count(*) from tabla_proyecto_material where TIMESTAMPDIFF(DAY, tabla_proyecto_material.fecha_registro, CURDATE()) = '0') as 'MovimientosHoy',

(select count(*) from productos where productos.estado = '0')*100/(select count(*) from productos) as '%Agotados',

(select count(*) from productos where productos.estado = '1')*100/(select count(*) from productos) as '%Disponibles',

(SELECT MAX(tabla_proyecto_material.fecha_registro) FROM tabla_proyecto_material) AS 'FechaUltimoM'

FROM productos 	WHERE productos.estado = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_resumen_usuarios` ()   SELECT COUNT(*) AS 'Usuarios_Totales',
(SELECT COUNT(*) FROM usuarios where usuarios.status = '1') AS 'ACTIVOS',
(SELECT COUNT(*) FROM usuarios where usuarios.status = '0') AS 'INACTIVOS'
FROM usuarios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_search_empleado` (IN `v_identificacion` INT)   BEGIN 

SELECT id_persona v1, Identificacion v2, case personas.sexo when 'M' then 'Masculino' when 'F' then 'Femenino' when 'N' then 'No especifica' end v3, initcap(nombre) v4, CONCAT(initcap(apellidoPAT)," ",initcap(apellidoMAT)) v5, telefono v6, initcap(profesion) v7, LOWER(email) v8  FROM personas WHERE Identificacion = v_identificacion AND status = 1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_search_usuario` (IN `v_idUsuario` INT)   BEGIN

SELECT id_cargo v1, status v2 FROM usuarios WHERE id_usuario = v_idUsuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unidmedida_combo` ()   BEGIN
SELECT unidadmedida.idMedida v1, 
unidadmedida.UndMedida v2
FROM unidadmedida WHERE unidadmedida.status='1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unidmedida_insert` (IN `v1` VARCHAR(30), IN `v2` VARCHAR(30), IN `v3` VARCHAR(20), IN `v4` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;
start transaction;

INSERT INTO `unidadmedida`( `UndMedida`,`PlrMedida`, `Simbolo`, `fecha_registro`, `id_usuario`) VALUES 
(v1,v2,v3,current_timestamp(),v4);
commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unidmedida_list` ()   BEGIN
SELECT unidadmedida.idMedida v1, 
unidadmedida.UndMedida v2,
unidadmedida.PlrMedida v3,
unidadmedida.Simbolo v4,
unidadmedida.fecha_registro v5,
unidadmedida.id_usuario v6,
usuarios.usuario v7,
unidadmedida.status v8,
case unidadmedida.status when  0 then 'Inactivo' when  1 then 'Activo' end v9
FROM unidadmedida inner join usuarios on usuarios.id_usuario = unidadmedida.id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unidmedida_update` (IN `v1` VARCHAR(30), IN `v2` VARCHAR(30), IN `v3` VARCHAR(20), IN `v4` INT(11), IN `vID` INT(11), OUT `v_res` INT)   BEGIN
declare exit handler
  for SQLEXCEPTION
begin
rollback;
set v_res=false;
end;

start transaction;

UPDATE `unidadmedida` SET 
`UndMedida`= v1,
`PlrMedida`= v2,
`Simbolo`= v3,
`status`= v4 WHERE `idMedida`= vID;

commit;
set v_res=true;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updatetheme` (IN `vID` INT)   BEGIN

UPDATE usuarios SET teme = if(usuarios.teme = 1,0,1) where usuarios.id_usuario = vID;

SELECT  usuarios.teme from usuarios where usuarios.id_usuario = vID;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_password` (IN `v_id` INT, IN `v_pass` TEXT, OUT `v_res` INT)   BEGIN
    DECLARE EXIT
HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK
        ;
    SET
        v_res = FALSE ;
END ;
START TRANSACTION
    ;
	update usuarios
	set contrasenia = v_pass
	WHERE id_usuario = v_id;

COMMIT
    ;
SET
    v_res = TRUE ; END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_resume` ()   BEGIN

SELECT COUNT(*) as Total,

(select count(*) from usuarios where usuarios.status = '0') as 'Inactivo %' ,

(select count(*) from usuarios where usuarios.status = '1') as 'Activo %'

from usuarios where usuarios.status = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_validar_empleado` (IN `v_id_empleado` INT)   BEGIN

SELECT usuario v1 FROM usuarios WHERE id_persona = v_id_empleado;

END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `initcap` (`cadena` VARCHAR(100)) RETURNS VARCHAR(100) CHARSET utf8mb4  BEGIN 
DECLARE pos INT DEFAULT 0; 
DECLARE tmp VARCHAR(100) 
DEFAULT ''; 
DECLARE result VARCHAR(100) DEFAULT ''; 
REPEAT SET pos = LOCATE(' ', cadena); 
 IF pos = 0 THEN SET pos = CHAR_LENGTH(cadena); 
 END IF; 
 SET tmp = LEFT(cadena,pos); 
 IF CHAR_LENGTH(tmp) < 4 THEN SET result =CONCAT(result, LOWER(tmp)); 
 ELSE SET result = CONCAT(result, UPPER(LEFT(tmp,1)),LOWER(SUBSTR(tmp,2))); 
 END IF; 
 SET cadena = RIGHT(cadena,CHAR_LENGTH(cadena)-pos); 
UNTIL CHAR_LENGTH(cadena) = 0 END REPEAT; 
RETURN result; 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `status_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nombre`, `descripcion`, `status_rol`) VALUES
(1, 'GERENTE GENERAL', 'GERENTE GENERAL DE INSERGE', 1),
(2, 'LOGISTICA', 'AREA DE LOGISTICA DE INSERGE', 1),
(3, 'ADMINISTRADOR', 'ADMINISTRADOR DE INSERGE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `Nombre`, `Descripcion`, `fecha_registro`, `id_usuario`, `status`) VALUES
(1, 'MATERIALES PÉTREOS', 'Los más usados en la construcción son la roca caliza, el mármol, el granito, la pizarra y los áridos', '2022-06-11 09:12:48', 1, b'1'),
(2, 'CERÁMICOS Y VIDRIOS', 'Baldosas y azulejos, ladrillos refractarios, loza, vidrio, lana de vidrio, bovedillas, tejas, etc.', '2022-06-11 09:13:37', 1, b'1'),
(3, 'MATERIALES METÁLICOS', 'Hay dos tipos los ferrosos procedentes del hierro y no ferrosos.', '2022-06-11 09:14:16', 1, b'1'),
(4, 'MATERIALES PLÁSTICOS', 'Entre ellos tenemos el PVC, el poliestireno, melamina, poliuretano, etc.', '2022-06-11 09:14:38', 1, b'1'),
(5, 'MATERIALES AGLUTINANTES', 'Al mezclarse con agua sufren transformaciones químicas. El yeso y el cemento son los más utilizados.', '2022-06-11 09:15:04', 1, b'1'),
(6, 'MATERIALES COMPUESTOS', 'Formados por la mezcla de diferentes materiales con diferentes propiedades.', '2022-06-11 09:15:50', 1, b'1'),
(7, 'MUEBLERIA', 'Sofa, Cama, cuadros, etc.', '2022-06-11 09:11:14', 1, b'1'),
(32, 'ARREGLOS', 'Flores, Plantas, Semillas, etc.', '2022-06-11 09:18:37', 1, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatorias`
--

CREATE TABLE `convocatorias` (
  `idConvocatoria` int(11) NOT NULL,
  `nombre` varchar(6) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` bit(1) NOT NULL DEFAULT b'1',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `convocatorias`
--

INSERT INTO `convocatorias` (`idConvocatoria`, `nombre`, `descripcion`, `inicio`, `fin`, `fecha_registro`, `status`, `id_usuario`) VALUES
(1, '1N-22', 'Primera convocatoria de 2022', '2022-02-16', '2022-06-15', '2022-06-06 07:35:05', b'1', 1),
(2, '2N-21', 'Tercera convocatoria del 2021', '2021-10-25', '0000-00-00', '2022-06-06 07:40:31', b'0', 1),
(3, '3N-20', 'Tercera convocatoria del 2020', '2021-06-07', '0000-00-00', '2022-06-06 19:15:06', b'0', 1),
(4, '1-21', 'Primera convocatoria de 2021', '2021-01-23', '2022-06-08', '2022-06-06 19:20:24', b'1', 1),
(5, '1N-21', 'Segunda convocatoria de 2021', '2021-01-18', '0000-00-00', '2022-06-18 10:44:40', b'1', 1),
(6, '2N-20', 'Segunda convocatoria de 2020', '2020-08-10', '0000-00-00', '2022-06-18 10:47:43', b'1', 1),
(7, '1N-20', 'Primera convocatoria de 2020', '2020-02-03', '0000-00-00', '2022-06-18 10:48:30', b'1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` varchar(2) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`) VALUES
('01', 'Amazonas'),
('02', 'Áncash'),
('03', 'Apurímac'),
('04', 'Arequipa'),
('05', 'Ayacucho'),
('06', 'Cajamarca'),
('07', 'Callao'),
('08', 'Cusco'),
('09', 'Huancavelica'),
('10', 'Huánuco'),
('11', 'Ica'),
('12', 'Junín'),
('13', 'La Libertad'),
('14', 'Lambayeque'),
('15', 'Lima'),
('16', 'Loreto'),
('17', 'Madre de Dios'),
('18', 'Moquegua'),
('19', 'Pasco'),
('20', 'Piura'),
('21', 'Puno'),
('22', 'San Martín'),
('23', 'Tacna'),
('24', 'Tumbes'),
('25', 'Ucayali');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto`
--

CREATE TABLE `detalle_producto` (
  `id_producto` int(11) NOT NULL,
  `observacion` varchar(50) NOT NULL,
  `motivo` tinyint(1) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_producto`
--

INSERT INTO `detalle_producto` (`id_producto`, `observacion`, `motivo`, `cantidad`, `fecha`, `hora`, `id_proveedor`, `fecha_registro`, `id_usuario`) VALUES
(1, 'COMIDA', 1, 20, '2022-05-05', '04:10:00', 5, '2022-06-13 16:50:48', 1),
(1, 'ALAMBRE', 1, 41, '2022-05-05', '04:10:00', 5, '2022-06-13 16:50:48', 1),
(1, 'ALAMBRE', 1, 41, '2022-05-05', '04:10:00', 5, '2022-06-13 16:50:48', 1),
(1, 'dadwa', 1, 41, '2022-05-05', '04:10:00', 5, '2022-06-13 16:50:48', 1),
(1, 'ALAMBRE', 1, 41, '2022-05-05', '04:10:00', 5, '2022-06-13 16:50:48', 1),
(1, '20215528791', 1, 100, '2022-05-05', '04:10:00', 5, '2022-06-13 16:50:48', 1),
(2, '', 1, 4, '2022-06-13', '03:51:00', 2, '2022-06-13 16:50:48', 1),
(2, '', 1, 4, '2022-06-13', '03:51:00', 2, '2022-06-13 16:50:48', 1),
(4, '', 1, 1, '2022-06-13', '03:51:00', 7, '2022-06-13 16:50:48', 1),
(2, '', 1, 3, '2022-06-13', '03:54:00', 2, '2022-06-13 16:50:48', 1),
(2, '', 1, 1, '2022-06-13', '03:54:00', 2, '2022-06-13 16:50:48', 1),
(2, '', 1, 4, '2022-06-13', '03:54:00', 2, '2022-06-13 16:50:48', 1),
(4, '', 1, 5, '2022-06-13', '03:54:00', 7, '2022-06-13 16:50:48', 1),
(2, '', 1, 5, '2022-06-13', '03:54:00', 2, '2022-06-13 16:50:48', 1),
(2, 'po', 1, 6, '2022-06-13', '03:54:00', 5, '2022-06-13 16:50:48', 1),
(4, '', 1, 6, '2022-06-13', '03:54:00', 7, '2022-06-13 16:50:48', 1),
(1, 'SE agrega', 1, 35, '2022-06-13', '10:42:00', 5, '2022-06-13 16:50:48', 1),
(2, '', 1, 4, '2022-06-13', '11:06:00', 2, '2022-06-13 16:50:48', 1),
(4, '', 1, 16, '2022-06-13', '11:06:00', 7, '2022-06-13 16:50:48', 1),
(2, '', 2, 54, '2022-06-13', '12:00:00', 2, '2022-06-13 17:01:06', 1),
(2, 'ASDASFASF', 5, 5, '2022-06-13', '12:07:00', 2, '2022-06-13 17:08:27', 1),
(2, '', 1, 6, '2022-06-13', '12:16:00', 2, '2022-06-13 17:19:27', 1),
(1, '', 4, 3, '2022-06-13', '12:16:00', 5, '2022-06-13 17:19:43', 1),
(1, '', 2, 3, '2022-06-13', '12:16:00', 5, '2022-06-13 17:19:55', 1),
(5, 'se COMPRO POR NECESITDAD', 4, 10, '2022-06-02', '12:16:00', 6, '2022-06-13 17:21:47', 1),
(5, '', 2, 10, '2022-06-13', '12:16:00', 2, '2022-06-13 17:22:14', 1),
(5, 'se COMPRO POR NECESITDAD', 2, 1, '2022-06-13', '14:05:00', 6, '2022-06-13 19:13:09', 1),
(6, '', 4, 1, '2022-06-13', '14:16:00', 2, '2022-06-13 19:17:35', 1),
(6, '', 3, 1, '2022-06-13', '14:16:00', 4, '2022-06-13 19:18:00', 1),
(6, 'no encuentro', 2, 10, '2022-06-13', '14:27:00', 8, '2022-06-13 19:34:05', 1),
(6, 'no encuentro', 3, 26, '2022-06-13', '14:27:00', 8, '2022-06-13 19:34:38', 1),
(2, 'faltaba en proyecto', 4, 5, '2022-06-13', '15:32:00', 2, '2022-06-13 20:33:43', 1),
(4, '', 4, 1, '2022-06-13', '15:32:00', 2, '2022-06-13 20:37:13', 1),
(12, '', 4, 6, '2022-06-14', '19:29:00', 6, '2022-06-15 00:31:23', 1),
(12, 'aaa', 2, 2, '2022-06-14', '19:29:00', 6, '2022-06-15 00:31:37', 1),
(4, '', 5, 5, '2022-06-18', '21:09:00', 7, '2022-06-19 02:10:08', 1),
(10, 'SE agrega', 2, 1, '2022-06-06', '21:09:00', 6, '2022-06-19 02:10:58', 1),
(2, '', 5, 10, '2022-06-18', '02:10:00', 28, '2022-06-19 04:16:47', 1),
(13, 'Llegó tarde', 4, 10, '2022-06-01', '21:58:00', 12, '2022-06-30 02:05:20', 1),
(13, '', 2, 1009, '2022-06-29', '21:06:00', 12, '2022-06-30 02:09:43', 1),
(13, '', 4, 2, '2022-06-29', '21:20:00', 12, '2022-06-30 02:21:17', 1),
(13, '', 4, 3, '2022-06-29', '21:20:00', 12, '2022-06-30 02:21:34', 1),
(13, '', 1, 2, '2022-06-29', '21:21:00', 12, '2022-06-30 02:22:25', 1),
(1, 'Se compro de emergencia en la tienda de la esquina', 4, 12, '2022-06-29', '21:30:00', 29, '2022-06-30 02:37:26', 1),
(1, 'Se perdio en entrega de materiales', 2, 100, '2022-06-29', '21:30:00', 2, '2022-06-30 02:44:44', 1),
(2, '', 4, 100, '2022-07-04', '21:02:00', 2, '2022-07-05 02:02:39', 1),
(14, '', 2, 1, '2022-07-04', '11:10:00', 12, '2022-07-05 02:19:10', 1),
(5, 'Se compro por emergencia', 4, 12, '2022-07-11', '01:10:00', 6, '2022-07-11 06:11:18', 1),
(1, 'dawdaw', 4, 12, '2022-07-11', '01:12:00', 5, '2022-07-11 06:13:46', 22),
(5, 'se COMPRO POR NECESITDAD', 5, 8, '2022-07-05', '03:17:00', 6, '2022-07-11 06:15:02', 22),
(5, 'se COMPRO POR NECESITDAD', 3, 68, '2022-06-29', '04:18:00', 6, '2022-07-11 06:16:29', 22),
(6, 'vcb', 4, 12, '2022-07-11', '02:37:00', 8, '2022-07-11 07:37:21', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distritos`
--

CREATE TABLE `distritos` (
  `id` varchar(6) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `id_provincia` varchar(4) DEFAULT NULL,
  `id_departamento` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `distritos`
--

INSERT INTO `distritos` (`id`, `nombre`, `id_provincia`, `id_departamento`) VALUES
('010101', 'Chachapoyas', '0101', '01'),
('010102', 'Asunción', '0101', '01'),
('010103', 'Balsas', '0101', '01'),
('010104', 'Cheto', '0101', '01'),
('010105', 'Chiliquin', '0101', '01'),
('010106', 'Chuquibamba', '0101', '01'),
('010107', 'Granada', '0101', '01'),
('010108', 'Huancas', '0101', '01'),
('010109', 'La Jalca', '0101', '01'),
('010110', 'Leimebamba', '0101', '01'),
('010111', 'Levanto', '0101', '01'),
('010112', 'Magdalena', '0101', '01'),
('010113', 'Mariscal Castilla', '0101', '01'),
('010114', 'Molinopampa', '0101', '01'),
('010115', 'Montevideo', '0101', '01'),
('010116', 'Olleros', '0101', '01'),
('010117', 'Quinjalca', '0101', '01'),
('010118', 'San Francisco de Daguas', '0101', '01'),
('010119', 'San Isidro de Maino', '0101', '01'),
('010120', 'Soloco', '0101', '01'),
('010121', 'Sonche', '0101', '01'),
('010201', 'Bagua', '0102', '01'),
('010202', 'Aramango', '0102', '01'),
('010203', 'Copallin', '0102', '01'),
('010204', 'El Parco', '0102', '01'),
('010205', 'Imaza', '0102', '01'),
('010206', 'La Peca', '0102', '01'),
('010301', 'Jumbilla', '0103', '01'),
('010302', 'Chisquilla', '0103', '01'),
('010303', 'Churuja', '0103', '01'),
('010304', 'Corosha', '0103', '01'),
('010305', 'Cuispes', '0103', '01'),
('010306', 'Florida', '0103', '01'),
('010307', 'Jazan', '0103', '01'),
('010308', 'Recta', '0103', '01'),
('010309', 'San Carlos', '0103', '01'),
('010310', 'Shipasbamba', '0103', '01'),
('010311', 'Valera', '0103', '01'),
('010312', 'Yambrasbamba', '0103', '01'),
('010401', 'Nieva', '0104', '01'),
('010402', 'El Cenepa', '0104', '01'),
('010403', 'Río Santiago', '0104', '01'),
('010501', 'Lamud', '0105', '01'),
('010502', 'Camporredondo', '0105', '01'),
('010503', 'Cocabamba', '0105', '01'),
('010504', 'Colcamar', '0105', '01'),
('010505', 'Conila', '0105', '01'),
('010506', 'Inguilpata', '0105', '01'),
('010507', 'Longuita', '0105', '01'),
('010508', 'Lonya Chico', '0105', '01'),
('010509', 'Luya', '0105', '01'),
('010510', 'Luya Viejo', '0105', '01'),
('010511', 'María', '0105', '01'),
('010512', 'Ocalli', '0105', '01'),
('010513', 'Ocumal', '0105', '01'),
('010514', 'Pisuquia', '0105', '01'),
('010515', 'Providencia', '0105', '01'),
('010516', 'San Cristóbal', '0105', '01'),
('010517', 'San Francisco de Yeso', '0105', '01'),
('010518', 'San Jerónimo', '0105', '01'),
('010519', 'San Juan de Lopecancha', '0105', '01'),
('010520', 'Santa Catalina', '0105', '01'),
('010521', 'Santo Tomas', '0105', '01'),
('010522', 'Tingo', '0105', '01'),
('010523', 'Trita', '0105', '01'),
('010601', 'San Nicolás', '0106', '01'),
('010602', 'Chirimoto', '0106', '01'),
('010603', 'Cochamal', '0106', '01'),
('010604', 'Huambo', '0106', '01'),
('010605', 'Limabamba', '0106', '01'),
('010606', 'Longar', '0106', '01'),
('010607', 'Mariscal Benavides', '0106', '01'),
('010608', 'Milpuc', '0106', '01'),
('010609', 'Omia', '0106', '01'),
('010610', 'Santa Rosa', '0106', '01'),
('010611', 'Totora', '0106', '01'),
('010612', 'Vista Alegre', '0106', '01'),
('010701', 'Bagua Grande', '0107', '01'),
('010702', 'Cajaruro', '0107', '01'),
('010703', 'Cumba', '0107', '01'),
('010704', 'El Milagro', '0107', '01'),
('010705', 'Jamalca', '0107', '01'),
('010706', 'Lonya Grande', '0107', '01'),
('010707', 'Yamon', '0107', '01'),
('020101', 'Huaraz', '0201', '02'),
('020102', 'Cochabamba', '0201', '02'),
('020103', 'Colcabamba', '0201', '02'),
('020104', 'Huanchay', '0201', '02'),
('020105', 'Independencia', '0201', '02'),
('020106', 'Jangas', '0201', '02'),
('020107', 'La Libertad', '0201', '02'),
('020108', 'Olleros', '0201', '02'),
('020109', 'Pampas Grande', '0201', '02'),
('020110', 'Pariacoto', '0201', '02'),
('020111', 'Pira', '0201', '02'),
('020112', 'Tarica', '0201', '02'),
('020201', 'Aija', '0202', '02'),
('020202', 'Coris', '0202', '02'),
('020203', 'Huacllan', '0202', '02'),
('020204', 'La Merced', '0202', '02'),
('020205', 'Succha', '0202', '02'),
('020301', 'Llamellin', '0203', '02'),
('020302', 'Aczo', '0203', '02'),
('020303', 'Chaccho', '0203', '02'),
('020304', 'Chingas', '0203', '02'),
('020305', 'Mirgas', '0203', '02'),
('020306', 'San Juan de Rontoy', '0203', '02'),
('020401', 'Chacas', '0204', '02'),
('020402', 'Acochaca', '0204', '02'),
('020501', 'Chiquian', '0205', '02'),
('020502', 'Abelardo Pardo Lezameta', '0205', '02'),
('020503', 'Antonio Raymondi', '0205', '02'),
('020504', 'Aquia', '0205', '02'),
('020505', 'Cajacay', '0205', '02'),
('020506', 'Canis', '0205', '02'),
('020507', 'Colquioc', '0205', '02'),
('020508', 'Huallanca', '0205', '02'),
('020509', 'Huasta', '0205', '02'),
('020510', 'Huayllacayan', '0205', '02'),
('020511', 'La Primavera', '0205', '02'),
('020512', 'Mangas', '0205', '02'),
('020513', 'Pacllon', '0205', '02'),
('020514', 'San Miguel de Corpanqui', '0205', '02'),
('020515', 'Ticllos', '0205', '02'),
('020601', 'Carhuaz', '0206', '02'),
('020602', 'Acopampa', '0206', '02'),
('020603', 'Amashca', '0206', '02'),
('020604', 'Anta', '0206', '02'),
('020605', 'Ataquero', '0206', '02'),
('020606', 'Marcara', '0206', '02'),
('020607', 'Pariahuanca', '0206', '02'),
('020608', 'San Miguel de Aco', '0206', '02'),
('020609', 'Shilla', '0206', '02'),
('020610', 'Tinco', '0206', '02'),
('020611', 'Yungar', '0206', '02'),
('020701', 'San Luis', '0207', '02'),
('020702', 'San Nicolás', '0207', '02'),
('020703', 'Yauya', '0207', '02'),
('020801', 'Casma', '0208', '02'),
('020802', 'Buena Vista Alta', '0208', '02'),
('020803', 'Comandante Noel', '0208', '02'),
('020804', 'Yautan', '0208', '02'),
('020901', 'Corongo', '0209', '02'),
('020902', 'Aco', '0209', '02'),
('020903', 'Bambas', '0209', '02'),
('020904', 'Cusca', '0209', '02'),
('020905', 'La Pampa', '0209', '02'),
('020906', 'Yanac', '0209', '02'),
('020907', 'Yupan', '0209', '02'),
('021001', 'Huari', '0210', '02'),
('021002', 'Anra', '0210', '02'),
('021003', 'Cajay', '0210', '02'),
('021004', 'Chavin de Huantar', '0210', '02'),
('021005', 'Huacachi', '0210', '02'),
('021006', 'Huacchis', '0210', '02'),
('021007', 'Huachis', '0210', '02'),
('021008', 'Huantar', '0210', '02'),
('021009', 'Masin', '0210', '02'),
('021010', 'Paucas', '0210', '02'),
('021011', 'Ponto', '0210', '02'),
('021012', 'Rahuapampa', '0210', '02'),
('021013', 'Rapayan', '0210', '02'),
('021014', 'San Marcos', '0210', '02'),
('021015', 'San Pedro de Chana', '0210', '02'),
('021016', 'Uco', '0210', '02'),
('021101', 'Huarmey', '0211', '02'),
('021102', 'Cochapeti', '0211', '02'),
('021103', 'Culebras', '0211', '02'),
('021104', 'Huayan', '0211', '02'),
('021105', 'Malvas', '0211', '02'),
('021201', 'Caraz', '0212', '02'),
('021202', 'Huallanca', '0212', '02'),
('021203', 'Huata', '0212', '02'),
('021204', 'Huaylas', '0212', '02'),
('021205', 'Mato', '0212', '02'),
('021206', 'Pamparomas', '0212', '02'),
('021207', 'Pueblo Libre', '0212', '02'),
('021208', 'Santa Cruz', '0212', '02'),
('021209', 'Santo Toribio', '0212', '02'),
('021210', 'Yuracmarca', '0212', '02'),
('021301', 'Piscobamba', '0213', '02'),
('021302', 'Casca', '0213', '02'),
('021303', 'Eleazar Guzmán Barron', '0213', '02'),
('021304', 'Fidel Olivas Escudero', '0213', '02'),
('021305', 'Llama', '0213', '02'),
('021306', 'Llumpa', '0213', '02'),
('021307', 'Lucma', '0213', '02'),
('021308', 'Musga', '0213', '02'),
('021401', 'Ocros', '0214', '02'),
('021402', 'Acas', '0214', '02'),
('021403', 'Cajamarquilla', '0214', '02'),
('021404', 'Carhuapampa', '0214', '02'),
('021405', 'Cochas', '0214', '02'),
('021406', 'Congas', '0214', '02'),
('021407', 'Llipa', '0214', '02'),
('021408', 'San Cristóbal de Rajan', '0214', '02'),
('021409', 'San Pedro', '0214', '02'),
('021410', 'Santiago de Chilcas', '0214', '02'),
('021501', 'Cabana', '0215', '02'),
('021502', 'Bolognesi', '0215', '02'),
('021503', 'Conchucos', '0215', '02'),
('021504', 'Huacaschuque', '0215', '02'),
('021505', 'Huandoval', '0215', '02'),
('021506', 'Lacabamba', '0215', '02'),
('021507', 'Llapo', '0215', '02'),
('021508', 'Pallasca', '0215', '02'),
('021509', 'Pampas', '0215', '02'),
('021510', 'Santa Rosa', '0215', '02'),
('021511', 'Tauca', '0215', '02'),
('021601', 'Pomabamba', '0216', '02'),
('021602', 'Huayllan', '0216', '02'),
('021603', 'Parobamba', '0216', '02'),
('021604', 'Quinuabamba', '0216', '02'),
('021701', 'Recuay', '0217', '02'),
('021702', 'Catac', '0217', '02'),
('021703', 'Cotaparaco', '0217', '02'),
('021704', 'Huayllapampa', '0217', '02'),
('021705', 'Llacllin', '0217', '02'),
('021706', 'Marca', '0217', '02'),
('021707', 'Pampas Chico', '0217', '02'),
('021708', 'Pararin', '0217', '02'),
('021709', 'Tapacocha', '0217', '02'),
('021710', 'Ticapampa', '0217', '02'),
('021801', 'Chimbote', '0218', '02'),
('021802', 'Cáceres del Perú', '0218', '02'),
('021803', 'Coishco', '0218', '02'),
('021804', 'Macate', '0218', '02'),
('021805', 'Moro', '0218', '02'),
('021806', 'Nepeña', '0218', '02'),
('021807', 'Samanco', '0218', '02'),
('021808', 'Santa', '0218', '02'),
('021809', 'Nuevo Chimbote', '0218', '02'),
('021901', 'Sihuas', '0219', '02'),
('021902', 'Acobamba', '0219', '02'),
('021903', 'Alfonso Ugarte', '0219', '02'),
('021904', 'Cashapampa', '0219', '02'),
('021905', 'Chingalpo', '0219', '02'),
('021906', 'Huayllabamba', '0219', '02'),
('021907', 'Quiches', '0219', '02'),
('021908', 'Ragash', '0219', '02'),
('021909', 'San Juan', '0219', '02'),
('021910', 'Sicsibamba', '0219', '02'),
('022001', 'Yungay', '0220', '02'),
('022002', 'Cascapara', '0220', '02'),
('022003', 'Mancos', '0220', '02'),
('022004', 'Matacoto', '0220', '02'),
('022005', 'Quillo', '0220', '02'),
('022006', 'Ranrahirca', '0220', '02'),
('022007', 'Shupluy', '0220', '02'),
('022008', 'Yanama', '0220', '02'),
('030101', 'Abancay', '0301', '03'),
('030102', 'Chacoche', '0301', '03'),
('030103', 'Circa', '0301', '03'),
('030104', 'Curahuasi', '0301', '03'),
('030105', 'Huanipaca', '0301', '03'),
('030106', 'Lambrama', '0301', '03'),
('030107', 'Pichirhua', '0301', '03'),
('030108', 'San Pedro de Cachora', '0301', '03'),
('030109', 'Tamburco', '0301', '03'),
('030201', 'Andahuaylas', '0302', '03'),
('030202', 'Andarapa', '0302', '03'),
('030203', 'Chiara', '0302', '03'),
('030204', 'Huancarama', '0302', '03'),
('030205', 'Huancaray', '0302', '03'),
('030206', 'Huayana', '0302', '03'),
('030207', 'Kishuara', '0302', '03'),
('030208', 'Pacobamba', '0302', '03'),
('030209', 'Pacucha', '0302', '03'),
('030210', 'Pampachiri', '0302', '03'),
('030211', 'Pomacocha', '0302', '03'),
('030212', 'San Antonio de Cachi', '0302', '03'),
('030213', 'San Jerónimo', '0302', '03'),
('030214', 'San Miguel de Chaccrampa', '0302', '03'),
('030215', 'Santa María de Chicmo', '0302', '03'),
('030216', 'Talavera', '0302', '03'),
('030217', 'Tumay Huaraca', '0302', '03'),
('030218', 'Turpo', '0302', '03'),
('030219', 'Kaquiabamba', '0302', '03'),
('030220', 'José María Arguedas', '0302', '03'),
('030301', 'Antabamba', '0303', '03'),
('030302', 'El Oro', '0303', '03'),
('030303', 'Huaquirca', '0303', '03'),
('030304', 'Juan Espinoza Medrano', '0303', '03'),
('030305', 'Oropesa', '0303', '03'),
('030306', 'Pachaconas', '0303', '03'),
('030307', 'Sabaino', '0303', '03'),
('030401', 'Chalhuanca', '0304', '03'),
('030402', 'Capaya', '0304', '03'),
('030403', 'Caraybamba', '0304', '03'),
('030404', 'Chapimarca', '0304', '03'),
('030405', 'Colcabamba', '0304', '03'),
('030406', 'Cotaruse', '0304', '03'),
('030407', 'Ihuayllo', '0304', '03'),
('030408', 'Justo Apu Sahuaraura', '0304', '03'),
('030409', 'Lucre', '0304', '03'),
('030410', 'Pocohuanca', '0304', '03'),
('030411', 'San Juan de Chacña', '0304', '03'),
('030412', 'Sañayca', '0304', '03'),
('030413', 'Soraya', '0304', '03'),
('030414', 'Tapairihua', '0304', '03'),
('030415', 'Tintay', '0304', '03'),
('030416', 'Toraya', '0304', '03'),
('030417', 'Yanaca', '0304', '03'),
('030501', 'Tambobamba', '0305', '03'),
('030502', 'Cotabambas', '0305', '03'),
('030503', 'Coyllurqui', '0305', '03'),
('030504', 'Haquira', '0305', '03'),
('030505', 'Mara', '0305', '03'),
('030506', 'Challhuahuacho', '0305', '03'),
('030601', 'Chincheros', '0306', '03'),
('030602', 'Anco_Huallo', '0306', '03'),
('030603', 'Cocharcas', '0306', '03'),
('030604', 'Huaccana', '0306', '03'),
('030605', 'Ocobamba', '0306', '03'),
('030606', 'Ongoy', '0306', '03'),
('030607', 'Uranmarca', '0306', '03'),
('030608', 'Ranracancha', '0306', '03'),
('030609', 'Rocchacc', '0306', '03'),
('030610', 'El Porvenir', '0306', '03'),
('030611', 'Los Chankas', '0306', '03'),
('030701', 'Chuquibambilla', '0307', '03'),
('030702', 'Curpahuasi', '0307', '03'),
('030703', 'Gamarra', '0307', '03'),
('030704', 'Huayllati', '0307', '03'),
('030705', 'Mamara', '0307', '03'),
('030706', 'Micaela Bastidas', '0307', '03'),
('030707', 'Pataypampa', '0307', '03'),
('030708', 'Progreso', '0307', '03'),
('030709', 'San Antonio', '0307', '03'),
('030710', 'Santa Rosa', '0307', '03'),
('030711', 'Turpay', '0307', '03'),
('030712', 'Vilcabamba', '0307', '03'),
('030713', 'Virundo', '0307', '03'),
('030714', 'Curasco', '0307', '03'),
('040101', 'Arequipa', '0401', '04'),
('040102', 'Alto Selva Alegre', '0401', '04'),
('040103', 'Cayma', '0401', '04'),
('040104', 'Cerro Colorado', '0401', '04'),
('040105', 'Characato', '0401', '04'),
('040106', 'Chiguata', '0401', '04'),
('040107', 'Jacobo Hunter', '0401', '04'),
('040108', 'La Joya', '0401', '04'),
('040109', 'Mariano Melgar', '0401', '04'),
('040110', 'Miraflores', '0401', '04'),
('040111', 'Mollebaya', '0401', '04'),
('040112', 'Paucarpata', '0401', '04'),
('040113', 'Pocsi', '0401', '04'),
('040114', 'Polobaya', '0401', '04'),
('040115', 'Quequeña', '0401', '04'),
('040116', 'Sabandia', '0401', '04'),
('040117', 'Sachaca', '0401', '04'),
('040118', 'San Juan de Siguas', '0401', '04'),
('040119', 'San Juan de Tarucani', '0401', '04'),
('040120', 'Santa Isabel de Siguas', '0401', '04'),
('040121', 'Santa Rita de Siguas', '0401', '04'),
('040122', 'Socabaya', '0401', '04'),
('040123', 'Tiabaya', '0401', '04'),
('040124', 'Uchumayo', '0401', '04'),
('040125', 'Vitor', '0401', '04'),
('040126', 'Yanahuara', '0401', '04'),
('040127', 'Yarabamba', '0401', '04'),
('040128', 'Yura', '0401', '04'),
('040129', 'José Luis Bustamante Y Rivero', '0401', '04'),
('040201', 'Camaná', '0402', '04'),
('040202', 'José María Quimper', '0402', '04'),
('040203', 'Mariano Nicolás Valcárcel', '0402', '04'),
('040204', 'Mariscal Cáceres', '0402', '04'),
('040205', 'Nicolás de Pierola', '0402', '04'),
('040206', 'Ocoña', '0402', '04'),
('040207', 'Quilca', '0402', '04'),
('040208', 'Samuel Pastor', '0402', '04'),
('040301', 'Caravelí', '0403', '04'),
('040302', 'Acarí', '0403', '04'),
('040303', 'Atico', '0403', '04'),
('040304', 'Atiquipa', '0403', '04'),
('040305', 'Bella Unión', '0403', '04'),
('040306', 'Cahuacho', '0403', '04'),
('040307', 'Chala', '0403', '04'),
('040308', 'Chaparra', '0403', '04'),
('040309', 'Huanuhuanu', '0403', '04'),
('040310', 'Jaqui', '0403', '04'),
('040311', 'Lomas', '0403', '04'),
('040312', 'Quicacha', '0403', '04'),
('040313', 'Yauca', '0403', '04'),
('040401', 'Aplao', '0404', '04'),
('040402', 'Andagua', '0404', '04'),
('040403', 'Ayo', '0404', '04'),
('040404', 'Chachas', '0404', '04'),
('040405', 'Chilcaymarca', '0404', '04'),
('040406', 'Choco', '0404', '04'),
('040407', 'Huancarqui', '0404', '04'),
('040408', 'Machaguay', '0404', '04'),
('040409', 'Orcopampa', '0404', '04'),
('040410', 'Pampacolca', '0404', '04'),
('040411', 'Tipan', '0404', '04'),
('040412', 'Uñon', '0404', '04'),
('040413', 'Uraca', '0404', '04'),
('040414', 'Viraco', '0404', '04'),
('040501', 'Chivay', '0405', '04'),
('040502', 'Achoma', '0405', '04'),
('040503', 'Cabanaconde', '0405', '04'),
('040504', 'Callalli', '0405', '04'),
('040505', 'Caylloma', '0405', '04'),
('040506', 'Coporaque', '0405', '04'),
('040507', 'Huambo', '0405', '04'),
('040508', 'Huanca', '0405', '04'),
('040509', 'Ichupampa', '0405', '04'),
('040510', 'Lari', '0405', '04'),
('040511', 'Lluta', '0405', '04'),
('040512', 'Maca', '0405', '04'),
('040513', 'Madrigal', '0405', '04'),
('040514', 'San Antonio de Chuca', '0405', '04'),
('040515', 'Sibayo', '0405', '04'),
('040516', 'Tapay', '0405', '04'),
('040517', 'Tisco', '0405', '04'),
('040518', 'Tuti', '0405', '04'),
('040519', 'Yanque', '0405', '04'),
('040520', 'Majes', '0405', '04'),
('040601', 'Chuquibamba', '0406', '04'),
('040602', 'Andaray', '0406', '04'),
('040603', 'Cayarani', '0406', '04'),
('040604', 'Chichas', '0406', '04'),
('040605', 'Iray', '0406', '04'),
('040606', 'Río Grande', '0406', '04'),
('040607', 'Salamanca', '0406', '04'),
('040608', 'Yanaquihua', '0406', '04'),
('040701', 'Mollendo', '0407', '04'),
('040702', 'Cocachacra', '0407', '04'),
('040703', 'Dean Valdivia', '0407', '04'),
('040704', 'Islay', '0407', '04'),
('040705', 'Mejia', '0407', '04'),
('040706', 'Punta de Bombón', '0407', '04'),
('040801', 'Cotahuasi', '0408', '04'),
('040802', 'Alca', '0408', '04'),
('040803', 'Charcana', '0408', '04'),
('040804', 'Huaynacotas', '0408', '04'),
('040805', 'Pampamarca', '0408', '04'),
('040806', 'Puyca', '0408', '04'),
('040807', 'Quechualla', '0408', '04'),
('040808', 'Sayla', '0408', '04'),
('040809', 'Tauria', '0408', '04'),
('040810', 'Tomepampa', '0408', '04'),
('040811', 'Toro', '0408', '04'),
('050101', 'Ayacucho', '0501', '05'),
('050102', 'Acocro', '0501', '05'),
('050103', 'Acos Vinchos', '0501', '05'),
('050104', 'Carmen Alto', '0501', '05'),
('050105', 'Chiara', '0501', '05'),
('050106', 'Ocros', '0501', '05'),
('050107', 'Pacaycasa', '0501', '05'),
('050108', 'Quinua', '0501', '05'),
('050109', 'San José de Ticllas', '0501', '05'),
('050110', 'San Juan Bautista', '0501', '05'),
('050111', 'Santiago de Pischa', '0501', '05'),
('050112', 'Socos', '0501', '05'),
('050113', 'Tambillo', '0501', '05'),
('050114', 'Vinchos', '0501', '05'),
('050115', 'Jesús Nazareno', '0501', '05'),
('050116', 'Andrés Avelino Cáceres Dorregaray', '0501', '05'),
('050201', 'Cangallo', '0502', '05'),
('050202', 'Chuschi', '0502', '05'),
('050203', 'Los Morochucos', '0502', '05'),
('050204', 'María Parado de Bellido', '0502', '05'),
('050205', 'Paras', '0502', '05'),
('050206', 'Totos', '0502', '05'),
('050301', 'Sancos', '0503', '05'),
('050302', 'Carapo', '0503', '05'),
('050303', 'Sacsamarca', '0503', '05'),
('050304', 'Santiago de Lucanamarca', '0503', '05'),
('050401', 'Huanta', '0504', '05'),
('050402', 'Ayahuanco', '0504', '05'),
('050403', 'Huamanguilla', '0504', '05'),
('050404', 'Iguain', '0504', '05'),
('050405', 'Luricocha', '0504', '05'),
('050406', 'Santillana', '0504', '05'),
('050407', 'Sivia', '0504', '05'),
('050408', 'Llochegua', '0504', '05'),
('050409', 'Canayre', '0504', '05'),
('050410', 'Uchuraccay', '0504', '05'),
('050411', 'Pucacolpa', '0504', '05'),
('050412', 'Chaca', '0504', '05'),
('050501', 'San Miguel', '0505', '05'),
('050502', 'Anco', '0505', '05'),
('050503', 'Ayna', '0505', '05'),
('050504', 'Chilcas', '0505', '05'),
('050505', 'Chungui', '0505', '05'),
('050506', 'Luis Carranza', '0505', '05'),
('050507', 'Santa Rosa', '0505', '05'),
('050508', 'Tambo', '0505', '05'),
('050509', 'Samugari', '0505', '05'),
('050510', 'Anchihuay', '0505', '05'),
('050511', 'Oronccoy', '0505', '05'),
('050601', 'Puquio', '0506', '05'),
('050602', 'Aucara', '0506', '05'),
('050603', 'Cabana', '0506', '05'),
('050604', 'Carmen Salcedo', '0506', '05'),
('050605', 'Chaviña', '0506', '05'),
('050606', 'Chipao', '0506', '05'),
('050607', 'Huac-Huas', '0506', '05'),
('050608', 'Laramate', '0506', '05'),
('050609', 'Leoncio Prado', '0506', '05'),
('050610', 'Llauta', '0506', '05'),
('050611', 'Lucanas', '0506', '05'),
('050612', 'Ocaña', '0506', '05'),
('050613', 'Otoca', '0506', '05'),
('050614', 'Saisa', '0506', '05'),
('050615', 'San Cristóbal', '0506', '05'),
('050616', 'San Juan', '0506', '05'),
('050617', 'San Pedro', '0506', '05'),
('050618', 'San Pedro de Palco', '0506', '05'),
('050619', 'Sancos', '0506', '05'),
('050620', 'Santa Ana de Huaycahuacho', '0506', '05'),
('050621', 'Santa Lucia', '0506', '05'),
('050701', 'Coracora', '0507', '05'),
('050702', 'Chumpi', '0507', '05'),
('050703', 'Coronel Castañeda', '0507', '05'),
('050704', 'Pacapausa', '0507', '05'),
('050705', 'Pullo', '0507', '05'),
('050706', 'Puyusca', '0507', '05'),
('050707', 'San Francisco de Ravacayco', '0507', '05'),
('050708', 'Upahuacho', '0507', '05'),
('050801', 'Pausa', '0508', '05'),
('050802', 'Colta', '0508', '05'),
('050803', 'Corculla', '0508', '05'),
('050804', 'Lampa', '0508', '05'),
('050805', 'Marcabamba', '0508', '05'),
('050806', 'Oyolo', '0508', '05'),
('050807', 'Pararca', '0508', '05'),
('050808', 'San Javier de Alpabamba', '0508', '05'),
('050809', 'San José de Ushua', '0508', '05'),
('050810', 'Sara Sara', '0508', '05'),
('050901', 'Querobamba', '0509', '05'),
('050902', 'Belén', '0509', '05'),
('050903', 'Chalcos', '0509', '05'),
('050904', 'Chilcayoc', '0509', '05'),
('050905', 'Huacaña', '0509', '05'),
('050906', 'Morcolla', '0509', '05'),
('050907', 'Paico', '0509', '05'),
('050908', 'San Pedro de Larcay', '0509', '05'),
('050909', 'San Salvador de Quije', '0509', '05'),
('050910', 'Santiago de Paucaray', '0509', '05'),
('050911', 'Soras', '0509', '05'),
('051001', 'Huancapi', '0510', '05'),
('051002', 'Alcamenca', '0510', '05'),
('051003', 'Apongo', '0510', '05'),
('051004', 'Asquipata', '0510', '05'),
('051005', 'Canaria', '0510', '05'),
('051006', 'Cayara', '0510', '05'),
('051007', 'Colca', '0510', '05'),
('051008', 'Huamanquiquia', '0510', '05'),
('051009', 'Huancaraylla', '0510', '05'),
('051010', 'Hualla', '0510', '05'),
('051011', 'Sarhua', '0510', '05'),
('051012', 'Vilcanchos', '0510', '05'),
('051101', 'Vilcas Huaman', '0511', '05'),
('051102', 'Accomarca', '0511', '05'),
('051103', 'Carhuanca', '0511', '05'),
('051104', 'Concepción', '0511', '05'),
('051105', 'Huambalpa', '0511', '05'),
('051106', 'Independencia', '0511', '05'),
('051107', 'Saurama', '0511', '05'),
('051108', 'Vischongo', '0511', '05'),
('060101', 'Cajamarca', '0601', '06'),
('060102', 'Asunción', '0601', '06'),
('060103', 'Chetilla', '0601', '06'),
('060104', 'Cospan', '0601', '06'),
('060105', 'Encañada', '0601', '06'),
('060106', 'Jesús', '0601', '06'),
('060107', 'Llacanora', '0601', '06'),
('060108', 'Los Baños del Inca', '0601', '06'),
('060109', 'Magdalena', '0601', '06'),
('060110', 'Matara', '0601', '06'),
('060111', 'Namora', '0601', '06'),
('060112', 'San Juan', '0601', '06'),
('060201', 'Cajabamba', '0602', '06'),
('060202', 'Cachachi', '0602', '06'),
('060203', 'Condebamba', '0602', '06'),
('060204', 'Sitacocha', '0602', '06'),
('060301', 'Celendín', '0603', '06'),
('060302', 'Chumuch', '0603', '06'),
('060303', 'Cortegana', '0603', '06'),
('060304', 'Huasmin', '0603', '06'),
('060305', 'Jorge Chávez', '0603', '06'),
('060306', 'José Gálvez', '0603', '06'),
('060307', 'Miguel Iglesias', '0603', '06'),
('060308', 'Oxamarca', '0603', '06'),
('060309', 'Sorochuco', '0603', '06'),
('060310', 'Sucre', '0603', '06'),
('060311', 'Utco', '0603', '06'),
('060312', 'La Libertad de Pallan', '0603', '06'),
('060401', 'Chota', '0604', '06'),
('060402', 'Anguia', '0604', '06'),
('060403', 'Chadin', '0604', '06'),
('060404', 'Chiguirip', '0604', '06'),
('060405', 'Chimban', '0604', '06'),
('060406', 'Choropampa', '0604', '06'),
('060407', 'Cochabamba', '0604', '06'),
('060408', 'Conchan', '0604', '06'),
('060409', 'Huambos', '0604', '06'),
('060410', 'Lajas', '0604', '06'),
('060411', 'Llama', '0604', '06'),
('060412', 'Miracosta', '0604', '06'),
('060413', 'Paccha', '0604', '06'),
('060414', 'Pion', '0604', '06'),
('060415', 'Querocoto', '0604', '06'),
('060416', 'San Juan de Licupis', '0604', '06'),
('060417', 'Tacabamba', '0604', '06'),
('060418', 'Tocmoche', '0604', '06'),
('060419', 'Chalamarca', '0604', '06'),
('060501', 'Contumaza', '0605', '06'),
('060502', 'Chilete', '0605', '06'),
('060503', 'Cupisnique', '0605', '06'),
('060504', 'Guzmango', '0605', '06'),
('060505', 'San Benito', '0605', '06'),
('060506', 'Santa Cruz de Toledo', '0605', '06'),
('060507', 'Tantarica', '0605', '06'),
('060508', 'Yonan', '0605', '06'),
('060601', 'Cutervo', '0606', '06'),
('060602', 'Callayuc', '0606', '06'),
('060603', 'Choros', '0606', '06'),
('060604', 'Cujillo', '0606', '06'),
('060605', 'La Ramada', '0606', '06'),
('060606', 'Pimpingos', '0606', '06'),
('060607', 'Querocotillo', '0606', '06'),
('060608', 'San Andrés de Cutervo', '0606', '06'),
('060609', 'San Juan de Cutervo', '0606', '06'),
('060610', 'San Luis de Lucma', '0606', '06'),
('060611', 'Santa Cruz', '0606', '06'),
('060612', 'Santo Domingo de la Capilla', '0606', '06'),
('060613', 'Santo Tomas', '0606', '06'),
('060614', 'Socota', '0606', '06'),
('060615', 'Toribio Casanova', '0606', '06'),
('060701', 'Bambamarca', '0607', '06'),
('060702', 'Chugur', '0607', '06'),
('060703', 'Hualgayoc', '0607', '06'),
('060801', 'Jaén', '0608', '06'),
('060802', 'Bellavista', '0608', '06'),
('060803', 'Chontali', '0608', '06'),
('060804', 'Colasay', '0608', '06'),
('060805', 'Huabal', '0608', '06'),
('060806', 'Las Pirias', '0608', '06'),
('060807', 'Pomahuaca', '0608', '06'),
('060808', 'Pucara', '0608', '06'),
('060809', 'Sallique', '0608', '06'),
('060810', 'San Felipe', '0608', '06'),
('060811', 'San José del Alto', '0608', '06'),
('060812', 'Santa Rosa', '0608', '06'),
('060901', 'San Ignacio', '0609', '06'),
('060902', 'Chirinos', '0609', '06'),
('060903', 'Huarango', '0609', '06'),
('060904', 'La Coipa', '0609', '06'),
('060905', 'Namballe', '0609', '06'),
('060906', 'San José de Lourdes', '0609', '06'),
('060907', 'Tabaconas', '0609', '06'),
('061001', 'Pedro Gálvez', '0610', '06'),
('061002', 'Chancay', '0610', '06'),
('061003', 'Eduardo Villanueva', '0610', '06'),
('061004', 'Gregorio Pita', '0610', '06'),
('061005', 'Ichocan', '0610', '06'),
('061006', 'José Manuel Quiroz', '0610', '06'),
('061007', 'José Sabogal', '0610', '06'),
('061101', 'San Miguel', '0611', '06'),
('061102', 'Bolívar', '0611', '06'),
('061103', 'Calquis', '0611', '06'),
('061104', 'Catilluc', '0611', '06'),
('061105', 'El Prado', '0611', '06'),
('061106', 'La Florida', '0611', '06'),
('061107', 'Llapa', '0611', '06'),
('061108', 'Nanchoc', '0611', '06'),
('061109', 'Niepos', '0611', '06'),
('061110', 'San Gregorio', '0611', '06'),
('061111', 'San Silvestre de Cochan', '0611', '06'),
('061112', 'Tongod', '0611', '06'),
('061113', 'Unión Agua Blanca', '0611', '06'),
('061201', 'San Pablo', '0612', '06'),
('061202', 'San Bernardino', '0612', '06'),
('061203', 'San Luis', '0612', '06'),
('061204', 'Tumbaden', '0612', '06'),
('061301', 'Santa Cruz', '0613', '06'),
('061302', 'Andabamba', '0613', '06'),
('061303', 'Catache', '0613', '06'),
('061304', 'Chancaybaños', '0613', '06'),
('061305', 'La Esperanza', '0613', '06'),
('061306', 'Ninabamba', '0613', '06'),
('061307', 'Pulan', '0613', '06'),
('061308', 'Saucepampa', '0613', '06'),
('061309', 'Sexi', '0613', '06'),
('061310', 'Uticyacu', '0613', '06'),
('061311', 'Yauyucan', '0613', '06'),
('070101', 'Callao', '0701', '07'),
('070102', 'Bellavista', '0701', '07'),
('070103', 'Carmen de la Legua Reynoso', '0701', '07'),
('070104', 'La Perla', '0701', '07'),
('070105', 'La Punta', '0701', '07'),
('070106', 'Ventanilla', '0701', '07'),
('070107', 'Mi Perú', '0701', '07'),
('080101', 'Cusco', '0801', '08'),
('080102', 'Ccorca', '0801', '08'),
('080103', 'Poroy', '0801', '08'),
('080104', 'San Jerónimo', '0801', '08'),
('080105', 'San Sebastian', '0801', '08'),
('080106', 'Santiago', '0801', '08'),
('080107', 'Saylla', '0801', '08'),
('080108', 'Wanchaq', '0801', '08'),
('080201', 'Acomayo', '0802', '08'),
('080202', 'Acopia', '0802', '08'),
('080203', 'Acos', '0802', '08'),
('080204', 'Mosoc Llacta', '0802', '08'),
('080205', 'Pomacanchi', '0802', '08'),
('080206', 'Rondocan', '0802', '08'),
('080207', 'Sangarara', '0802', '08'),
('080301', 'Anta', '0803', '08'),
('080302', 'Ancahuasi', '0803', '08'),
('080303', 'Cachimayo', '0803', '08'),
('080304', 'Chinchaypujio', '0803', '08'),
('080305', 'Huarocondo', '0803', '08'),
('080306', 'Limatambo', '0803', '08'),
('080307', 'Mollepata', '0803', '08'),
('080308', 'Pucyura', '0803', '08'),
('080309', 'Zurite', '0803', '08'),
('080401', 'Calca', '0804', '08'),
('080402', 'Coya', '0804', '08'),
('080403', 'Lamay', '0804', '08'),
('080404', 'Lares', '0804', '08'),
('080405', 'Pisac', '0804', '08'),
('080406', 'San Salvador', '0804', '08'),
('080407', 'Taray', '0804', '08'),
('080408', 'Yanatile', '0804', '08'),
('080501', 'Yanaoca', '0805', '08'),
('080502', 'Checca', '0805', '08'),
('080503', 'Kunturkanki', '0805', '08'),
('080504', 'Langui', '0805', '08'),
('080505', 'Layo', '0805', '08'),
('080506', 'Pampamarca', '0805', '08'),
('080507', 'Quehue', '0805', '08'),
('080508', 'Tupac Amaru', '0805', '08'),
('080601', 'Sicuani', '0806', '08'),
('080602', 'Checacupe', '0806', '08'),
('080603', 'Combapata', '0806', '08'),
('080604', 'Marangani', '0806', '08'),
('080605', 'Pitumarca', '0806', '08'),
('080606', 'San Pablo', '0806', '08'),
('080607', 'San Pedro', '0806', '08'),
('080608', 'Tinta', '0806', '08'),
('080701', 'Santo Tomas', '0807', '08'),
('080702', 'Capacmarca', '0807', '08'),
('080703', 'Chamaca', '0807', '08'),
('080704', 'Colquemarca', '0807', '08'),
('080705', 'Livitaca', '0807', '08'),
('080706', 'Llusco', '0807', '08'),
('080707', 'Quiñota', '0807', '08'),
('080708', 'Velille', '0807', '08'),
('080801', 'Espinar', '0808', '08'),
('080802', 'Condoroma', '0808', '08'),
('080803', 'Coporaque', '0808', '08'),
('080804', 'Ocoruro', '0808', '08'),
('080805', 'Pallpata', '0808', '08'),
('080806', 'Pichigua', '0808', '08'),
('080807', 'Suyckutambo', '0808', '08'),
('080808', 'Alto Pichigua', '0808', '08'),
('080901', 'Santa Ana', '0809', '08'),
('080902', 'Echarate', '0809', '08'),
('080903', 'Huayopata', '0809', '08'),
('080904', 'Maranura', '0809', '08'),
('080905', 'Ocobamba', '0809', '08'),
('080906', 'Quellouno', '0809', '08'),
('080907', 'Kimbiri', '0809', '08'),
('080908', 'Santa Teresa', '0809', '08'),
('080909', 'Vilcabamba', '0809', '08'),
('080910', 'Pichari', '0809', '08'),
('080911', 'Inkawasi', '0809', '08'),
('080912', 'Villa Virgen', '0809', '08'),
('080913', 'Villa Kintiarina', '0809', '08'),
('080914', 'Megantoni', '0809', '08'),
('081001', 'Paruro', '0810', '08'),
('081002', 'Accha', '0810', '08'),
('081003', 'Ccapi', '0810', '08'),
('081004', 'Colcha', '0810', '08'),
('081005', 'Huanoquite', '0810', '08'),
('081006', 'Omachaç', '0810', '08'),
('081007', 'Paccaritambo', '0810', '08'),
('081008', 'Pillpinto', '0810', '08'),
('081009', 'Yaurisque', '0810', '08'),
('081101', 'Paucartambo', '0811', '08'),
('081102', 'Caicay', '0811', '08'),
('081103', 'Challabamba', '0811', '08'),
('081104', 'Colquepata', '0811', '08'),
('081105', 'Huancarani', '0811', '08'),
('081106', 'Kosñipata', '0811', '08'),
('081201', 'Urcos', '0812', '08'),
('081202', 'Andahuaylillas', '0812', '08'),
('081203', 'Camanti', '0812', '08'),
('081204', 'Ccarhuayo', '0812', '08'),
('081205', 'Ccatca', '0812', '08'),
('081206', 'Cusipata', '0812', '08'),
('081207', 'Huaro', '0812', '08'),
('081208', 'Lucre', '0812', '08'),
('081209', 'Marcapata', '0812', '08'),
('081210', 'Ocongate', '0812', '08'),
('081211', 'Oropesa', '0812', '08'),
('081212', 'Quiquijana', '0812', '08'),
('081301', 'Urubamba', '0813', '08'),
('081302', 'Chinchero', '0813', '08'),
('081303', 'Huayllabamba', '0813', '08'),
('081304', 'Machupicchu', '0813', '08'),
('081305', 'Maras', '0813', '08'),
('081306', 'Ollantaytambo', '0813', '08'),
('081307', 'Yucay', '0813', '08'),
('090101', 'Huancavelica', '0901', '09'),
('090102', 'Acobambilla', '0901', '09'),
('090103', 'Acoria', '0901', '09'),
('090104', 'Conayca', '0901', '09'),
('090105', 'Cuenca', '0901', '09'),
('090106', 'Huachocolpa', '0901', '09'),
('090107', 'Huayllahuara', '0901', '09'),
('090108', 'Izcuchaca', '0901', '09'),
('090109', 'Laria', '0901', '09'),
('090110', 'Manta', '0901', '09'),
('090111', 'Mariscal Cáceres', '0901', '09'),
('090112', 'Moya', '0901', '09'),
('090113', 'Nuevo Occoro', '0901', '09'),
('090114', 'Palca', '0901', '09'),
('090115', 'Pilchaca', '0901', '09'),
('090116', 'Vilca', '0901', '09'),
('090117', 'Yauli', '0901', '09'),
('090118', 'Ascensión', '0901', '09'),
('090119', 'Huando', '0901', '09'),
('090201', 'Acobamba', '0902', '09'),
('090202', 'Andabamba', '0902', '09'),
('090203', 'Anta', '0902', '09'),
('090204', 'Caja', '0902', '09'),
('090205', 'Marcas', '0902', '09'),
('090206', 'Paucara', '0902', '09'),
('090207', 'Pomacocha', '0902', '09'),
('090208', 'Rosario', '0902', '09'),
('090301', 'Lircay', '0903', '09'),
('090302', 'Anchonga', '0903', '09'),
('090303', 'Callanmarca', '0903', '09'),
('090304', 'Ccochaccasa', '0903', '09'),
('090305', 'Chincho', '0903', '09'),
('090306', 'Congalla', '0903', '09'),
('090307', 'Huanca-Huanca', '0903', '09'),
('090308', 'Huayllay Grande', '0903', '09'),
('090309', 'Julcamarca', '0903', '09'),
('090310', 'San Antonio de Antaparco', '0903', '09'),
('090311', 'Santo Tomas de Pata', '0903', '09'),
('090312', 'Secclla', '0903', '09'),
('090401', 'Castrovirreyna', '0904', '09'),
('090402', 'Arma', '0904', '09'),
('090403', 'Aurahua', '0904', '09'),
('090404', 'Capillas', '0904', '09'),
('090405', 'Chupamarca', '0904', '09'),
('090406', 'Cocas', '0904', '09'),
('090407', 'Huachos', '0904', '09'),
('090408', 'Huamatambo', '0904', '09'),
('090409', 'Mollepampa', '0904', '09'),
('090410', 'San Juan', '0904', '09'),
('090411', 'Santa Ana', '0904', '09'),
('090412', 'Tantara', '0904', '09'),
('090413', 'Ticrapo', '0904', '09'),
('090501', 'Churcampa', '0905', '09'),
('090502', 'Anco', '0905', '09'),
('090503', 'Chinchihuasi', '0905', '09'),
('090504', 'El Carmen', '0905', '09'),
('090505', 'La Merced', '0905', '09'),
('090506', 'Locroja', '0905', '09'),
('090507', 'Paucarbamba', '0905', '09'),
('090508', 'San Miguel de Mayocc', '0905', '09'),
('090509', 'San Pedro de Coris', '0905', '09'),
('090510', 'Pachamarca', '0905', '09'),
('090511', 'Cosme', '0905', '09'),
('090601', 'Huaytara', '0906', '09'),
('090602', 'Ayavi', '0906', '09'),
('090603', 'Córdova', '0906', '09'),
('090604', 'Huayacundo Arma', '0906', '09'),
('090605', 'Laramarca', '0906', '09'),
('090606', 'Ocoyo', '0906', '09'),
('090607', 'Pilpichaca', '0906', '09'),
('090608', 'Querco', '0906', '09'),
('090609', 'Quito-Arma', '0906', '09'),
('090610', 'San Antonio de Cusicancha', '0906', '09'),
('090611', 'San Francisco de Sangayaico', '0906', '09'),
('090612', 'San Isidro', '0906', '09'),
('090613', 'Santiago de Chocorvos', '0906', '09'),
('090614', 'Santiago de Quirahuara', '0906', '09'),
('090615', 'Santo Domingo de Capillas', '0906', '09'),
('090616', 'Tambo', '0906', '09'),
('090701', 'Pampas', '0907', '09'),
('090702', 'Acostambo', '0907', '09'),
('090703', 'Acraquia', '0907', '09'),
('090704', 'Ahuaycha', '0907', '09'),
('090705', 'Colcabamba', '0907', '09'),
('090706', 'Daniel Hernández', '0907', '09'),
('090707', 'Huachocolpa', '0907', '09'),
('090709', 'Huaribamba', '0907', '09'),
('090710', 'Ñahuimpuquio', '0907', '09'),
('090711', 'Pazos', '0907', '09'),
('090713', 'Quishuar', '0907', '09'),
('090714', 'Salcabamba', '0907', '09'),
('090715', 'Salcahuasi', '0907', '09'),
('090716', 'San Marcos de Rocchac', '0907', '09'),
('090717', 'Surcubamba', '0907', '09'),
('090718', 'Tintay Puncu', '0907', '09'),
('090719', 'Quichuas', '0907', '09'),
('090720', 'Andaymarca', '0907', '09'),
('090721', 'Roble', '0907', '09'),
('090722', 'Pichos', '0907', '09'),
('090723', 'Santiago de Tucuma', '0907', '09'),
('100101', 'Huanuco', '1001', '10'),
('100102', 'Amarilis', '1001', '10'),
('100103', 'Chinchao', '1001', '10'),
('100104', 'Churubamba', '1001', '10'),
('100105', 'Margos', '1001', '10'),
('100106', 'Quisqui (Kichki)', '1001', '10'),
('100107', 'San Francisco de Cayran', '1001', '10'),
('100108', 'San Pedro de Chaulan', '1001', '10'),
('100109', 'Santa María del Valle', '1001', '10'),
('100110', 'Yarumayo', '1001', '10'),
('100111', 'Pillco Marca', '1001', '10'),
('100112', 'Yacus', '1001', '10'),
('100113', 'San Pablo de Pillao', '1001', '10'),
('100201', 'Ambo', '1002', '10'),
('100202', 'Cayna', '1002', '10'),
('100203', 'Colpas', '1002', '10'),
('100204', 'Conchamarca', '1002', '10'),
('100205', 'Huacar', '1002', '10'),
('100206', 'San Francisco', '1002', '10'),
('100207', 'San Rafael', '1002', '10'),
('100208', 'Tomay Kichwa', '1002', '10'),
('100301', 'La Unión', '1003', '10'),
('100307', 'Chuquis', '1003', '10'),
('100311', 'Marías', '1003', '10'),
('100313', 'Pachas', '1003', '10'),
('100316', 'Quivilla', '1003', '10'),
('100317', 'Ripan', '1003', '10'),
('100321', 'Shunqui', '1003', '10'),
('100322', 'Sillapata', '1003', '10'),
('100323', 'Yanas', '1003', '10'),
('100401', 'Huacaybamba', '1004', '10'),
('100402', 'Canchabamba', '1004', '10'),
('100403', 'Cochabamba', '1004', '10'),
('100404', 'Pinra', '1004', '10'),
('100501', 'Llata', '1005', '10'),
('100502', 'Arancay', '1005', '10'),
('100503', 'Chavín de Pariarca', '1005', '10'),
('100504', 'Jacas Grande', '1005', '10'),
('100505', 'Jircan', '1005', '10'),
('100506', 'Miraflores', '1005', '10'),
('100507', 'Monzón', '1005', '10'),
('100508', 'Punchao', '1005', '10'),
('100509', 'Puños', '1005', '10'),
('100510', 'Singa', '1005', '10'),
('100511', 'Tantamayo', '1005', '10'),
('100601', 'Rupa-Rupa', '1006', '10'),
('100602', 'Daniel Alomía Robles', '1006', '10'),
('100603', 'Hermílio Valdizan', '1006', '10'),
('100604', 'José Crespo y Castillo', '1006', '10'),
('100605', 'Luyando', '1006', '10'),
('100606', 'Mariano Damaso Beraun', '1006', '10'),
('100607', 'Pucayacu', '1006', '10'),
('100608', 'Castillo Grande', '1006', '10'),
('100609', 'Pueblo Nuevo', '1006', '10'),
('100610', 'Santo Domingo de Anda', '1006', '10'),
('100701', 'Huacrachuco', '1007', '10'),
('100702', 'Cholon', '1007', '10'),
('100703', 'San Buenaventura', '1007', '10'),
('100704', 'La Morada', '1007', '10'),
('100705', 'Santa Rosa de Alto Yanajanca', '1007', '10'),
('100801', 'Panao', '1008', '10'),
('100802', 'Chaglla', '1008', '10'),
('100803', 'Molino', '1008', '10'),
('100804', 'Umari', '1008', '10'),
('100901', 'Puerto Inca', '1009', '10'),
('100902', 'Codo del Pozuzo', '1009', '10'),
('100903', 'Honoria', '1009', '10'),
('100904', 'Tournavista', '1009', '10'),
('100905', 'Yuyapichis', '1009', '10'),
('101001', 'Jesús', '1010', '10'),
('101002', 'Baños', '1010', '10'),
('101003', 'Jivia', '1010', '10'),
('101004', 'Queropalca', '1010', '10'),
('101005', 'Rondos', '1010', '10'),
('101006', 'San Francisco de Asís', '1010', '10'),
('101007', 'San Miguel de Cauri', '1010', '10'),
('101101', 'Chavinillo', '1011', '10'),
('101102', 'Cahuac', '1011', '10'),
('101103', 'Chacabamba', '1011', '10'),
('101104', 'Aparicio Pomares', '1011', '10'),
('101105', 'Jacas Chico', '1011', '10'),
('101106', 'Obas', '1011', '10'),
('101107', 'Pampamarca', '1011', '10'),
('101108', 'Choras', '1011', '10'),
('110101', 'Ica', '1101', '11'),
('110102', 'La Tinguiña', '1101', '11'),
('110103', 'Los Aquijes', '1101', '11'),
('110104', 'Ocucaje', '1101', '11'),
('110105', 'Pachacutec', '1101', '11'),
('110106', 'Parcona', '1101', '11'),
('110107', 'Pueblo Nuevo', '1101', '11'),
('110108', 'Salas', '1101', '11'),
('110109', 'San José de Los Molinos', '1101', '11'),
('110110', 'San Juan Bautista', '1101', '11'),
('110111', 'Santiago', '1101', '11'),
('110112', 'Subtanjalla', '1101', '11'),
('110113', 'Tate', '1101', '11'),
('110114', 'Yauca del Rosario', '1101', '11'),
('110201', 'Chincha Alta', '1102', '11'),
('110202', 'Alto Laran', '1102', '11'),
('110203', 'Chavin', '1102', '11'),
('110204', 'Chincha Baja', '1102', '11'),
('110205', 'El Carmen', '1102', '11'),
('110206', 'Grocio Prado', '1102', '11'),
('110207', 'Pueblo Nuevo', '1102', '11'),
('110208', 'San Juan de Yanac', '1102', '11'),
('110209', 'San Pedro de Huacarpana', '1102', '11'),
('110210', 'Sunampe', '1102', '11'),
('110211', 'Tambo de Mora', '1102', '11'),
('110301', 'Nasca', '1103', '11'),
('110302', 'Changuillo', '1103', '11'),
('110303', 'El Ingenio', '1103', '11'),
('110304', 'Marcona', '1103', '11'),
('110305', 'Vista Alegre', '1103', '11'),
('110401', 'Palpa', '1104', '11'),
('110402', 'Llipata', '1104', '11'),
('110403', 'Río Grande', '1104', '11'),
('110404', 'Santa Cruz', '1104', '11'),
('110405', 'Tibillo', '1104', '11'),
('110501', 'Pisco', '1105', '11'),
('110502', 'Huancano', '1105', '11'),
('110503', 'Humay', '1105', '11'),
('110504', 'Independencia', '1105', '11'),
('110505', 'Paracas', '1105', '11'),
('110506', 'San Andrés', '1105', '11'),
('110507', 'San Clemente', '1105', '11'),
('110508', 'Tupac Amaru Inca', '1105', '11'),
('120101', 'Huancayo', '1201', '12'),
('120104', 'Carhuacallanga', '1201', '12'),
('120105', 'Chacapampa', '1201', '12'),
('120106', 'Chicche', '1201', '12'),
('120107', 'Chilca', '1201', '12'),
('120108', 'Chongos Alto', '1201', '12'),
('120111', 'Chupuro', '1201', '12'),
('120112', 'Colca', '1201', '12'),
('120113', 'Cullhuas', '1201', '12'),
('120114', 'El Tambo', '1201', '12'),
('120116', 'Huacrapuquio', '1201', '12'),
('120117', 'Hualhuas', '1201', '12'),
('120119', 'Huancan', '1201', '12'),
('120120', 'Huasicancha', '1201', '12'),
('120121', 'Huayucachi', '1201', '12'),
('120122', 'Ingenio', '1201', '12'),
('120124', 'Pariahuanca', '1201', '12'),
('120125', 'Pilcomayo', '1201', '12'),
('120126', 'Pucara', '1201', '12'),
('120127', 'Quichuay', '1201', '12'),
('120128', 'Quilcas', '1201', '12'),
('120129', 'San Agustín', '1201', '12'),
('120130', 'San Jerónimo de Tunan', '1201', '12'),
('120132', 'Saño', '1201', '12'),
('120133', 'Sapallanga', '1201', '12'),
('120134', 'Sicaya', '1201', '12'),
('120135', 'Santo Domingo de Acobamba', '1201', '12'),
('120136', 'Viques', '1201', '12'),
('120201', 'Concepción', '1202', '12'),
('120202', 'Aco', '1202', '12'),
('120203', 'Andamarca', '1202', '12'),
('120204', 'Chambara', '1202', '12'),
('120205', 'Cochas', '1202', '12'),
('120206', 'Comas', '1202', '12'),
('120207', 'Heroínas Toledo', '1202', '12'),
('120208', 'Manzanares', '1202', '12'),
('120209', 'Mariscal Castilla', '1202', '12'),
('120210', 'Matahuasi', '1202', '12'),
('120211', 'Mito', '1202', '12'),
('120212', 'Nueve de Julio', '1202', '12'),
('120213', 'Orcotuna', '1202', '12'),
('120214', 'San José de Quero', '1202', '12'),
('120215', 'Santa Rosa de Ocopa', '1202', '12'),
('120301', 'Chanchamayo', '1203', '12'),
('120302', 'Perene', '1203', '12'),
('120303', 'Pichanaqui', '1203', '12'),
('120304', 'San Luis de Shuaro', '1203', '12'),
('120305', 'San Ramón', '1203', '12'),
('120306', 'Vitoc', '1203', '12'),
('120401', 'Jauja', '1204', '12'),
('120402', 'Acolla', '1204', '12'),
('120403', 'Apata', '1204', '12'),
('120404', 'Ataura', '1204', '12'),
('120405', 'Canchayllo', '1204', '12'),
('120406', 'Curicaca', '1204', '12'),
('120407', 'El Mantaro', '1204', '12'),
('120408', 'Huamali', '1204', '12'),
('120409', 'Huaripampa', '1204', '12'),
('120410', 'Huertas', '1204', '12'),
('120411', 'Janjaillo', '1204', '12'),
('120412', 'Julcán', '1204', '12'),
('120413', 'Leonor Ordóñez', '1204', '12'),
('120414', 'Llocllapampa', '1204', '12'),
('120415', 'Marco', '1204', '12'),
('120416', 'Masma', '1204', '12'),
('120417', 'Masma Chicche', '1204', '12'),
('120418', 'Molinos', '1204', '12'),
('120419', 'Monobamba', '1204', '12'),
('120420', 'Muqui', '1204', '12'),
('120421', 'Muquiyauyo', '1204', '12'),
('120422', 'Paca', '1204', '12'),
('120423', 'Paccha', '1204', '12'),
('120424', 'Pancan', '1204', '12'),
('120425', 'Parco', '1204', '12'),
('120426', 'Pomacancha', '1204', '12'),
('120427', 'Ricran', '1204', '12'),
('120428', 'San Lorenzo', '1204', '12'),
('120429', 'San Pedro de Chunan', '1204', '12'),
('120430', 'Sausa', '1204', '12'),
('120431', 'Sincos', '1204', '12'),
('120432', 'Tunan Marca', '1204', '12'),
('120433', 'Yauli', '1204', '12'),
('120434', 'Yauyos', '1204', '12'),
('120501', 'Junin', '1205', '12'),
('120502', 'Carhuamayo', '1205', '12'),
('120503', 'Ondores', '1205', '12'),
('120504', 'Ulcumayo', '1205', '12'),
('120601', 'Satipo', '1206', '12'),
('120602', 'Coviriali', '1206', '12'),
('120603', 'Llaylla', '1206', '12'),
('120604', 'Mazamari', '1206', '12'),
('120605', 'Pampa Hermosa', '1206', '12'),
('120606', 'Pangoa', '1206', '12'),
('120607', 'Río Negro', '1206', '12'),
('120608', 'Río Tambo', '1206', '12'),
('120609', 'Vizcatan del Ene', '1206', '12'),
('120701', 'Tarma', '1207', '12'),
('120702', 'Acobamba', '1207', '12'),
('120703', 'Huaricolca', '1207', '12'),
('120704', 'Huasahuasi', '1207', '12'),
('120705', 'La Unión', '1207', '12'),
('120706', 'Palca', '1207', '12'),
('120707', 'Palcamayo', '1207', '12'),
('120708', 'San Pedro de Cajas', '1207', '12'),
('120709', 'Tapo', '1207', '12'),
('120801', 'La Oroya', '1208', '12'),
('120802', 'Chacapalpa', '1208', '12'),
('120803', 'Huay-Huay', '1208', '12'),
('120804', 'Marcapomacocha', '1208', '12'),
('120805', 'Morococha', '1208', '12'),
('120806', 'Paccha', '1208', '12'),
('120807', 'Santa Bárbara de Carhuacayan', '1208', '12'),
('120808', 'Santa Rosa de Sacco', '1208', '12'),
('120809', 'Suitucancha', '1208', '12'),
('120810', 'Yauli', '1208', '12'),
('120901', 'Chupaca', '1209', '12'),
('120902', 'Ahuac', '1209', '12'),
('120903', 'Chongos Bajo', '1209', '12'),
('120904', 'Huachac', '1209', '12'),
('120905', 'Huamancaca Chico', '1209', '12'),
('120906', 'San Juan de Iscos', '1209', '12'),
('120907', 'San Juan de Jarpa', '1209', '12'),
('120908', 'Tres de Diciembre', '1209', '12'),
('120909', 'Yanacancha', '1209', '12'),
('130101', 'Trujillo', '1301', '13'),
('130102', 'El Porvenir', '1301', '13'),
('130103', 'Florencia de Mora', '1301', '13'),
('130104', 'Huanchaco', '1301', '13'),
('130105', 'La Esperanza', '1301', '13'),
('130106', 'Laredo', '1301', '13'),
('130107', 'Moche', '1301', '13'),
('130108', 'Poroto', '1301', '13'),
('130109', 'Salaverry', '1301', '13'),
('130110', 'Simbal', '1301', '13'),
('130111', 'Victor Larco Herrera', '1301', '13'),
('130201', 'Ascope', '1302', '13'),
('130202', 'Chicama', '1302', '13'),
('130203', 'Chocope', '1302', '13'),
('130204', 'Magdalena de Cao', '1302', '13'),
('130205', 'Paijan', '1302', '13'),
('130206', 'Rázuri', '1302', '13'),
('130207', 'Santiago de Cao', '1302', '13'),
('130208', 'Casa Grande', '1302', '13'),
('130301', 'Bolívar', '1303', '13'),
('130302', 'Bambamarca', '1303', '13'),
('130303', 'Condormarca', '1303', '13'),
('130304', 'Longotea', '1303', '13'),
('130305', 'Uchumarca', '1303', '13'),
('130306', 'Ucuncha', '1303', '13'),
('130401', 'Chepen', '1304', '13'),
('130402', 'Pacanga', '1304', '13'),
('130403', 'Pueblo Nuevo', '1304', '13'),
('130501', 'Julcan', '1305', '13'),
('130502', 'Calamarca', '1305', '13'),
('130503', 'Carabamba', '1305', '13'),
('130504', 'Huaso', '1305', '13'),
('130601', 'Otuzco', '1306', '13'),
('130602', 'Agallpampa', '1306', '13'),
('130604', 'Charat', '1306', '13'),
('130605', 'Huaranchal', '1306', '13'),
('130606', 'La Cuesta', '1306', '13'),
('130608', 'Mache', '1306', '13'),
('130610', 'Paranday', '1306', '13'),
('130611', 'Salpo', '1306', '13'),
('130613', 'Sinsicap', '1306', '13'),
('130614', 'Usquil', '1306', '13'),
('130701', 'San Pedro de Lloc', '1307', '13'),
('130702', 'Guadalupe', '1307', '13'),
('130703', 'Jequetepeque', '1307', '13'),
('130704', 'Pacasmayo', '1307', '13'),
('130705', 'San José', '1307', '13'),
('130801', 'Tayabamba', '1308', '13'),
('130802', 'Buldibuyo', '1308', '13'),
('130803', 'Chillia', '1308', '13'),
('130804', 'Huancaspata', '1308', '13'),
('130805', 'Huaylillas', '1308', '13'),
('130806', 'Huayo', '1308', '13'),
('130807', 'Ongon', '1308', '13'),
('130808', 'Parcoy', '1308', '13'),
('130809', 'Pataz', '1308', '13'),
('130810', 'Pias', '1308', '13'),
('130811', 'Santiago de Challas', '1308', '13'),
('130812', 'Taurija', '1308', '13'),
('130813', 'Urpay', '1308', '13'),
('130901', 'Huamachuco', '1309', '13'),
('130902', 'Chugay', '1309', '13'),
('130903', 'Cochorco', '1309', '13'),
('130904', 'Curgos', '1309', '13'),
('130905', 'Marcabal', '1309', '13'),
('130906', 'Sanagoran', '1309', '13'),
('130907', 'Sarin', '1309', '13'),
('130908', 'Sartimbamba', '1309', '13'),
('131001', 'Santiago de Chuco', '1310', '13'),
('131002', 'Angasmarca', '1310', '13'),
('131003', 'Cachicadan', '1310', '13'),
('131004', 'Mollebamba', '1310', '13'),
('131005', 'Mollepata', '1310', '13'),
('131006', 'Quiruvilca', '1310', '13'),
('131007', 'Santa Cruz de Chuca', '1310', '13'),
('131008', 'Sitabamba', '1310', '13'),
('131101', 'Cascas', '1311', '13'),
('131102', 'Lucma', '1311', '13'),
('131103', 'Marmot', '1311', '13'),
('131104', 'Sayapullo', '1311', '13'),
('131201', 'Viru', '1312', '13'),
('131202', 'Chao', '1312', '13'),
('131203', 'Guadalupito', '1312', '13'),
('140101', 'Chiclayo', '1401', '14'),
('140102', 'Chongoyape', '1401', '14'),
('140103', 'Eten', '1401', '14'),
('140104', 'Eten Puerto', '1401', '14'),
('140105', 'José Leonardo Ortiz', '1401', '14'),
('140106', 'La Victoria', '1401', '14'),
('140107', 'Lagunas', '1401', '14'),
('140108', 'Monsefu', '1401', '14'),
('140109', 'Nueva Arica', '1401', '14'),
('140110', 'Oyotun', '1401', '14'),
('140111', 'Picsi', '1401', '14'),
('140112', 'Pimentel', '1401', '14'),
('140113', 'Reque', '1401', '14'),
('140114', 'Santa Rosa', '1401', '14'),
('140115', 'Saña', '1401', '14'),
('140116', 'Cayalti', '1401', '14'),
('140117', 'Patapo', '1401', '14'),
('140118', 'Pomalca', '1401', '14'),
('140119', 'Pucala', '1401', '14'),
('140120', 'Tuman', '1401', '14'),
('140201', 'Ferreñafe', '1402', '14'),
('140202', 'Cañaris', '1402', '14'),
('140203', 'Incahuasi', '1402', '14'),
('140204', 'Manuel Antonio Mesones Muro', '1402', '14'),
('140205', 'Pitipo', '1402', '14'),
('140206', 'Pueblo Nuevo', '1402', '14'),
('140301', 'Lambayeque', '1403', '14'),
('140302', 'Chochope', '1403', '14'),
('140303', 'Illimo', '1403', '14'),
('140304', 'Jayanca', '1403', '14'),
('140305', 'Mochumi', '1403', '14'),
('140306', 'Morrope', '1403', '14'),
('140307', 'Motupe', '1403', '14'),
('140308', 'Olmos', '1403', '14'),
('140309', 'Pacora', '1403', '14'),
('140310', 'Salas', '1403', '14'),
('140311', 'San José', '1403', '14'),
('140312', 'Tucume', '1403', '14'),
('150101', 'Lima', '1501', '15'),
('150102', 'Ancón', '1501', '15'),
('150103', 'Ate', '1501', '15'),
('150104', 'Barranco', '1501', '15'),
('150105', 'Breña', '1501', '15'),
('150106', 'Carabayllo', '1501', '15'),
('150107', 'Chaclacayo', '1501', '15'),
('150108', 'Chorrillos', '1501', '15'),
('150109', 'Cieneguilla', '1501', '15'),
('150110', 'Comas', '1501', '15'),
('150111', 'El Agustino', '1501', '15'),
('150112', 'Independencia', '1501', '15'),
('150113', 'Jesús María', '1501', '15'),
('150114', 'La Molina', '1501', '15'),
('150115', 'La Victoria', '1501', '15'),
('150116', 'Lince', '1501', '15'),
('150117', 'Los Olivos', '1501', '15'),
('150118', 'Lurigancho', '1501', '15'),
('150119', 'Lurin', '1501', '15'),
('150120', 'Magdalena del Mar', '1501', '15'),
('150121', 'Pueblo Libre', '1501', '15'),
('150122', 'Miraflores', '1501', '15'),
('150123', 'Pachacamac', '1501', '15'),
('150124', 'Pucusana', '1501', '15'),
('150125', 'Puente Piedra', '1501', '15'),
('150126', 'Punta Hermosa', '1501', '15'),
('150127', 'Punta Negra', '1501', '15'),
('150128', 'Rímac', '1501', '15'),
('150129', 'San Bartolo', '1501', '15'),
('150130', 'San Borja', '1501', '15'),
('150131', 'San Isidro', '1501', '15'),
('150132', 'San Juan de Lurigancho', '1501', '15'),
('150133', 'San Juan de Miraflores', '1501', '15'),
('150134', 'San Luis', '1501', '15'),
('150135', 'San Martín de Porres', '1501', '15'),
('150136', 'San Miguel', '1501', '15'),
('150137', 'Santa Anita', '1501', '15'),
('150138', 'Santa María del Mar', '1501', '15'),
('150139', 'Santa Rosa', '1501', '15'),
('150140', 'Santiago de Surco', '1501', '15'),
('150141', 'Surquillo', '1501', '15'),
('150142', 'Villa El Salvador', '1501', '15'),
('150143', 'Villa María del Triunfo', '1501', '15'),
('150201', 'Barranca', '1502', '15'),
('150202', 'Paramonga', '1502', '15'),
('150203', 'Pativilca', '1502', '15'),
('150204', 'Supe', '1502', '15'),
('150205', 'Supe Puerto', '1502', '15'),
('150301', 'Cajatambo', '1503', '15'),
('150302', 'Copa', '1503', '15'),
('150303', 'Gorgor', '1503', '15'),
('150304', 'Huancapon', '1503', '15'),
('150305', 'Manas', '1503', '15'),
('150401', 'Canta', '1504', '15'),
('150402', 'Arahuay', '1504', '15'),
('150403', 'Huamantanga', '1504', '15'),
('150404', 'Huaros', '1504', '15'),
('150405', 'Lachaqui', '1504', '15'),
('150406', 'San Buenaventura', '1504', '15'),
('150407', 'Santa Rosa de Quives', '1504', '15');
INSERT INTO `distritos` (`id`, `nombre`, `id_provincia`, `id_departamento`) VALUES
('150501', 'San Vicente de Cañete', '1505', '15'),
('150502', 'Asia', '1505', '15'),
('150503', 'Calango', '1505', '15'),
('150504', 'Cerro Azul', '1505', '15'),
('150505', 'Chilca', '1505', '15'),
('150506', 'Coayllo', '1505', '15'),
('150507', 'Imperial', '1505', '15'),
('150508', 'Lunahuana', '1505', '15'),
('150509', 'Mala', '1505', '15'),
('150510', 'Nuevo Imperial', '1505', '15'),
('150511', 'Pacaran', '1505', '15'),
('150512', 'Quilmana', '1505', '15'),
('150513', 'San Antonio', '1505', '15'),
('150514', 'San Luis', '1505', '15'),
('150515', 'Santa Cruz de Flores', '1505', '15'),
('150516', 'Zúñiga', '1505', '15'),
('150601', 'Huaral', '1506', '15'),
('150602', 'Atavillos Alto', '1506', '15'),
('150603', 'Atavillos Bajo', '1506', '15'),
('150604', 'Aucallama', '1506', '15'),
('150605', 'Chancay', '1506', '15'),
('150606', 'Ihuari', '1506', '15'),
('150607', 'Lampian', '1506', '15'),
('150608', 'Pacaraos', '1506', '15'),
('150609', 'San Miguel de Acos', '1506', '15'),
('150610', 'Santa Cruz de Andamarca', '1506', '15'),
('150611', 'Sumbilca', '1506', '15'),
('150612', 'Veintisiete de Noviembre', '1506', '15'),
('150701', 'Matucana', '1507', '15'),
('150702', 'Antioquia', '1507', '15'),
('150703', 'Callahuanca', '1507', '15'),
('150704', 'Carampoma', '1507', '15'),
('150705', 'Chicla', '1507', '15'),
('150706', 'Cuenca', '1507', '15'),
('150707', 'Huachupampa', '1507', '15'),
('150708', 'Huanza', '1507', '15'),
('150709', 'Huarochiri', '1507', '15'),
('150710', 'Lahuaytambo', '1507', '15'),
('150711', 'Langa', '1507', '15'),
('150712', 'Laraos', '1507', '15'),
('150713', 'Mariatana', '1507', '15'),
('150714', 'Ricardo Palma', '1507', '15'),
('150715', 'San Andrés de Tupicocha', '1507', '15'),
('150716', 'San Antonio', '1507', '15'),
('150717', 'San Bartolomé', '1507', '15'),
('150718', 'San Damian', '1507', '15'),
('150719', 'San Juan de Iris', '1507', '15'),
('150720', 'San Juan de Tantaranche', '1507', '15'),
('150721', 'San Lorenzo de Quinti', '1507', '15'),
('150722', 'San Mateo', '1507', '15'),
('150723', 'San Mateo de Otao', '1507', '15'),
('150724', 'San Pedro de Casta', '1507', '15'),
('150725', 'San Pedro de Huancayre', '1507', '15'),
('150726', 'Sangallaya', '1507', '15'),
('150727', 'Santa Cruz de Cocachacra', '1507', '15'),
('150728', 'Santa Eulalia', '1507', '15'),
('150729', 'Santiago de Anchucaya', '1507', '15'),
('150730', 'Santiago de Tuna', '1507', '15'),
('150731', 'Santo Domingo de Los Olleros', '1507', '15'),
('150732', 'Surco', '1507', '15'),
('150801', 'Huacho', '1508', '15'),
('150802', 'Ambar', '1508', '15'),
('150803', 'Caleta de Carquin', '1508', '15'),
('150804', 'Checras', '1508', '15'),
('150805', 'Hualmay', '1508', '15'),
('150806', 'Huaura', '1508', '15'),
('150807', 'Leoncio Prado', '1508', '15'),
('150808', 'Paccho', '1508', '15'),
('150809', 'Santa Leonor', '1508', '15'),
('150810', 'Santa María', '1508', '15'),
('150811', 'Sayan', '1508', '15'),
('150812', 'Vegueta', '1508', '15'),
('150901', 'Oyon', '1509', '15'),
('150902', 'Andajes', '1509', '15'),
('150903', 'Caujul', '1509', '15'),
('150904', 'Cochamarca', '1509', '15'),
('150905', 'Navan', '1509', '15'),
('150906', 'Pachangara', '1509', '15'),
('151001', 'Yauyos', '1510', '15'),
('151002', 'Alis', '1510', '15'),
('151003', 'Allauca', '1510', '15'),
('151004', 'Ayaviri', '1510', '15'),
('151005', 'Azángaro', '1510', '15'),
('151006', 'Cacra', '1510', '15'),
('151007', 'Carania', '1510', '15'),
('151008', 'Catahuasi', '1510', '15'),
('151009', 'Chocos', '1510', '15'),
('151010', 'Cochas', '1510', '15'),
('151011', 'Colonia', '1510', '15'),
('151012', 'Hongos', '1510', '15'),
('151013', 'Huampara', '1510', '15'),
('151014', 'Huancaya', '1510', '15'),
('151015', 'Huangascar', '1510', '15'),
('151016', 'Huantan', '1510', '15'),
('151017', 'Huañec', '1510', '15'),
('151018', 'Laraos', '1510', '15'),
('151019', 'Lincha', '1510', '15'),
('151020', 'Madean', '1510', '15'),
('151021', 'Miraflores', '1510', '15'),
('151022', 'Omas', '1510', '15'),
('151023', 'Putinza', '1510', '15'),
('151024', 'Quinches', '1510', '15'),
('151025', 'Quinocay', '1510', '15'),
('151026', 'San Joaquín', '1510', '15'),
('151027', 'San Pedro de Pilas', '1510', '15'),
('151028', 'Tanta', '1510', '15'),
('151029', 'Tauripampa', '1510', '15'),
('151030', 'Tomas', '1510', '15'),
('151031', 'Tupe', '1510', '15'),
('151032', 'Viñac', '1510', '15'),
('151033', 'Vitis', '1510', '15'),
('160101', 'Iquitos', '1601', '16'),
('160102', 'Alto Nanay', '1601', '16'),
('160103', 'Fernando Lores', '1601', '16'),
('160104', 'Indiana', '1601', '16'),
('160105', 'Las Amazonas', '1601', '16'),
('160106', 'Mazan', '1601', '16'),
('160107', 'Napo', '1601', '16'),
('160108', 'Punchana', '1601', '16'),
('160110', 'Torres Causana', '1601', '16'),
('160112', 'Belén', '1601', '16'),
('160113', 'San Juan Bautista', '1601', '16'),
('160201', 'Yurimaguas', '1602', '16'),
('160202', 'Balsapuerto', '1602', '16'),
('160205', 'Jeberos', '1602', '16'),
('160206', 'Lagunas', '1602', '16'),
('160210', 'Santa Cruz', '1602', '16'),
('160211', 'Teniente Cesar López Rojas', '1602', '16'),
('160301', 'Nauta', '1603', '16'),
('160302', 'Parinari', '1603', '16'),
('160303', 'Tigre', '1603', '16'),
('160304', 'Trompeteros', '1603', '16'),
('160305', 'Urarinas', '1603', '16'),
('160401', 'Ramón Castilla', '1604', '16'),
('160402', 'Pebas', '1604', '16'),
('160403', 'Yavari', '1604', '16'),
('160404', 'San Pablo', '1604', '16'),
('160501', 'Requena', '1605', '16'),
('160502', 'Alto Tapiche', '1605', '16'),
('160503', 'Capelo', '1605', '16'),
('160504', 'Emilio San Martín', '1605', '16'),
('160505', 'Maquia', '1605', '16'),
('160506', 'Puinahua', '1605', '16'),
('160507', 'Saquena', '1605', '16'),
('160508', 'Soplin', '1605', '16'),
('160509', 'Tapiche', '1605', '16'),
('160510', 'Jenaro Herrera', '1605', '16'),
('160511', 'Yaquerana', '1605', '16'),
('160601', 'Contamana', '1606', '16'),
('160602', 'Inahuaya', '1606', '16'),
('160603', 'Padre Márquez', '1606', '16'),
('160604', 'Pampa Hermosa', '1606', '16'),
('160605', 'Sarayacu', '1606', '16'),
('160606', 'Vargas Guerra', '1606', '16'),
('160701', 'Barranca', '1607', '16'),
('160702', 'Cahuapanas', '1607', '16'),
('160703', 'Manseriche', '1607', '16'),
('160704', 'Morona', '1607', '16'),
('160705', 'Pastaza', '1607', '16'),
('160706', 'Andoas', '1607', '16'),
('160801', 'Putumayo', '1608', '16'),
('160802', 'Rosa Panduro', '1608', '16'),
('160803', 'Teniente Manuel Clavero', '1608', '16'),
('160804', 'Yaguas', '1608', '16'),
('170101', 'Tambopata', '1701', '17'),
('170102', 'Inambari', '1701', '17'),
('170103', 'Las Piedras', '1701', '17'),
('170104', 'Laberinto', '1701', '17'),
('170201', 'Manu', '1702', '17'),
('170202', 'Fitzcarrald', '1702', '17'),
('170203', 'Madre de Dios', '1702', '17'),
('170204', 'Huepetuhe', '1702', '17'),
('170301', 'Iñapari', '1703', '17'),
('170302', 'Iberia', '1703', '17'),
('170303', 'Tahuamanu', '1703', '17'),
('180101', 'Moquegua', '1801', '18'),
('180102', 'Carumas', '1801', '18'),
('180103', 'Cuchumbaya', '1801', '18'),
('180104', 'Samegua', '1801', '18'),
('180105', 'San Cristóbal', '1801', '18'),
('180106', 'Torata', '1801', '18'),
('180201', 'Omate', '1802', '18'),
('180202', 'Chojata', '1802', '18'),
('180203', 'Coalaque', '1802', '18'),
('180204', 'Ichuña', '1802', '18'),
('180205', 'La Capilla', '1802', '18'),
('180206', 'Lloque', '1802', '18'),
('180207', 'Matalaque', '1802', '18'),
('180208', 'Puquina', '1802', '18'),
('180209', 'Quinistaquillas', '1802', '18'),
('180210', 'Ubinas', '1802', '18'),
('180211', 'Yunga', '1802', '18'),
('180301', 'Ilo', '1803', '18'),
('180302', 'El Algarrobal', '1803', '18'),
('180303', 'Pacocha', '1803', '18'),
('190101', 'Chaupimarca', '1901', '19'),
('190102', 'Huachon', '1901', '19'),
('190103', 'Huariaca', '1901', '19'),
('190104', 'Huayllay', '1901', '19'),
('190105', 'Ninacaca', '1901', '19'),
('190106', 'Pallanchacra', '1901', '19'),
('190107', 'Paucartambo', '1901', '19'),
('190108', 'San Francisco de Asís de Yarusyacan', '1901', '19'),
('190109', 'Simon Bolívar', '1901', '19'),
('190110', 'Ticlacayan', '1901', '19'),
('190111', 'Tinyahuarco', '1901', '19'),
('190112', 'Vicco', '1901', '19'),
('190113', 'Yanacancha', '1901', '19'),
('190201', 'Yanahuanca', '1902', '19'),
('190202', 'Chacayan', '1902', '19'),
('190203', 'Goyllarisquizga', '1902', '19'),
('190204', 'Paucar', '1902', '19'),
('190205', 'San Pedro de Pillao', '1902', '19'),
('190206', 'Santa Ana de Tusi', '1902', '19'),
('190207', 'Tapuc', '1902', '19'),
('190208', 'Vilcabamba', '1902', '19'),
('190301', 'Oxapampa', '1903', '19'),
('190302', 'Chontabamba', '1903', '19'),
('190303', 'Huancabamba', '1903', '19'),
('190304', 'Palcazu', '1903', '19'),
('190305', 'Pozuzo', '1903', '19'),
('190306', 'Puerto Bermúdez', '1903', '19'),
('190307', 'Villa Rica', '1903', '19'),
('190308', 'Constitución', '1903', '19'),
('200101', 'Piura', '2001', '20'),
('200104', 'Castilla', '2001', '20'),
('200105', 'Catacaos', '2001', '20'),
('200107', 'Cura Mori', '2001', '20'),
('200108', 'El Tallan', '2001', '20'),
('200109', 'La Arena', '2001', '20'),
('200110', 'La Unión', '2001', '20'),
('200111', 'Las Lomas', '2001', '20'),
('200114', 'Tambo Grande', '2001', '20'),
('200115', 'Veintiseis de Octubre', '2001', '20'),
('200201', 'Ayabaca', '2002', '20'),
('200202', 'Frias', '2002', '20'),
('200203', 'Jilili', '2002', '20'),
('200204', 'Lagunas', '2002', '20'),
('200205', 'Montero', '2002', '20'),
('200206', 'Pacaipampa', '2002', '20'),
('200207', 'Paimas', '2002', '20'),
('200208', 'Sapillica', '2002', '20'),
('200209', 'Sicchez', '2002', '20'),
('200210', 'Suyo', '2002', '20'),
('200301', 'Huancabamba', '2003', '20'),
('200302', 'Canchaque', '2003', '20'),
('200303', 'El Carmen de la Frontera', '2003', '20'),
('200304', 'Huarmaca', '2003', '20'),
('200305', 'Lalaquiz', '2003', '20'),
('200306', 'San Miguel de El Faique', '2003', '20'),
('200307', 'Sondor', '2003', '20'),
('200308', 'Sondorillo', '2003', '20'),
('200401', 'Chulucanas', '2004', '20'),
('200402', 'Buenos Aires', '2004', '20'),
('200403', 'Chalaco', '2004', '20'),
('200404', 'La Matanza', '2004', '20'),
('200405', 'Morropon', '2004', '20'),
('200406', 'Salitral', '2004', '20'),
('200407', 'San Juan de Bigote', '2004', '20'),
('200408', 'Santa Catalina de Mossa', '2004', '20'),
('200409', 'Santo Domingo', '2004', '20'),
('200410', 'Yamango', '2004', '20'),
('200501', 'Paita', '2005', '20'),
('200502', 'Amotape', '2005', '20'),
('200503', 'Arenal', '2005', '20'),
('200504', 'Colan', '2005', '20'),
('200505', 'La Huaca', '2005', '20'),
('200506', 'Tamarindo', '2005', '20'),
('200507', 'Vichayal', '2005', '20'),
('200601', 'Sullana', '2006', '20'),
('200602', 'Bellavista', '2006', '20'),
('200603', 'Ignacio Escudero', '2006', '20'),
('200604', 'Lancones', '2006', '20'),
('200605', 'Marcavelica', '2006', '20'),
('200606', 'Miguel Checa', '2006', '20'),
('200607', 'Querecotillo', '2006', '20'),
('200608', 'Salitral', '2006', '20'),
('200701', 'Pariñas', '2007', '20'),
('200702', 'El Alto', '2007', '20'),
('200703', 'La Brea', '2007', '20'),
('200704', 'Lobitos', '2007', '20'),
('200705', 'Los Organos', '2007', '20'),
('200706', 'Mancora', '2007', '20'),
('200801', 'Sechura', '2008', '20'),
('200802', 'Bellavista de la Unión', '2008', '20'),
('200803', 'Bernal', '2008', '20'),
('200804', 'Cristo Nos Valga', '2008', '20'),
('200805', 'Vice', '2008', '20'),
('200806', 'Rinconada Llicuar', '2008', '20'),
('210101', 'Puno', '2101', '21'),
('210102', 'Acora', '2101', '21'),
('210103', 'Amantani', '2101', '21'),
('210104', 'Atuncolla', '2101', '21'),
('210105', 'Capachica', '2101', '21'),
('210106', 'Chucuito', '2101', '21'),
('210107', 'Coata', '2101', '21'),
('210108', 'Huata', '2101', '21'),
('210109', 'Mañazo', '2101', '21'),
('210110', 'Paucarcolla', '2101', '21'),
('210111', 'Pichacani', '2101', '21'),
('210112', 'Plateria', '2101', '21'),
('210113', 'San Antonio', '2101', '21'),
('210114', 'Tiquillaca', '2101', '21'),
('210115', 'Vilque', '2101', '21'),
('210201', 'Azángaro', '2102', '21'),
('210202', 'Achaya', '2102', '21'),
('210203', 'Arapa', '2102', '21'),
('210204', 'Asillo', '2102', '21'),
('210205', 'Caminaca', '2102', '21'),
('210206', 'Chupa', '2102', '21'),
('210207', 'José Domingo Choquehuanca', '2102', '21'),
('210208', 'Muñani', '2102', '21'),
('210209', 'Potoni', '2102', '21'),
('210210', 'Saman', '2102', '21'),
('210211', 'San Anton', '2102', '21'),
('210212', 'San José', '2102', '21'),
('210213', 'San Juan de Salinas', '2102', '21'),
('210214', 'Santiago de Pupuja', '2102', '21'),
('210215', 'Tirapata', '2102', '21'),
('210301', 'Macusani', '2103', '21'),
('210302', 'Ajoyani', '2103', '21'),
('210303', 'Ayapata', '2103', '21'),
('210304', 'Coasa', '2103', '21'),
('210305', 'Corani', '2103', '21'),
('210306', 'Crucero', '2103', '21'),
('210307', 'Ituata', '2103', '21'),
('210308', 'Ollachea', '2103', '21'),
('210309', 'San Gaban', '2103', '21'),
('210310', 'Usicayos', '2103', '21'),
('210401', 'Juli', '2104', '21'),
('210402', 'Desaguadero', '2104', '21'),
('210403', 'Huacullani', '2104', '21'),
('210404', 'Kelluyo', '2104', '21'),
('210405', 'Pisacoma', '2104', '21'),
('210406', 'Pomata', '2104', '21'),
('210407', 'Zepita', '2104', '21'),
('210501', 'Ilave', '2105', '21'),
('210502', 'Capazo', '2105', '21'),
('210503', 'Pilcuyo', '2105', '21'),
('210504', 'Santa Rosa', '2105', '21'),
('210505', 'Conduriri', '2105', '21'),
('210601', 'Huancane', '2106', '21'),
('210602', 'Cojata', '2106', '21'),
('210603', 'Huatasani', '2106', '21'),
('210604', 'Inchupalla', '2106', '21'),
('210605', 'Pusi', '2106', '21'),
('210606', 'Rosaspata', '2106', '21'),
('210607', 'Taraco', '2106', '21'),
('210608', 'Vilque Chico', '2106', '21'),
('210701', 'Lampa', '2107', '21'),
('210702', 'Cabanilla', '2107', '21'),
('210703', 'Calapuja', '2107', '21'),
('210704', 'Nicasio', '2107', '21'),
('210705', 'Ocuviri', '2107', '21'),
('210706', 'Palca', '2107', '21'),
('210707', 'Paratia', '2107', '21'),
('210708', 'Pucara', '2107', '21'),
('210709', 'Santa Lucia', '2107', '21'),
('210710', 'Vilavila', '2107', '21'),
('210801', 'Ayaviri', '2108', '21'),
('210802', 'Antauta', '2108', '21'),
('210803', 'Cupi', '2108', '21'),
('210804', 'Llalli', '2108', '21'),
('210805', 'Macari', '2108', '21'),
('210806', 'Nuñoa', '2108', '21'),
('210807', 'Orurillo', '2108', '21'),
('210808', 'Santa Rosa', '2108', '21'),
('210809', 'Umachiri', '2108', '21'),
('210901', 'Moho', '2109', '21'),
('210902', 'Conima', '2109', '21'),
('210903', 'Huayrapata', '2109', '21'),
('210904', 'Tilali', '2109', '21'),
('211001', 'Putina', '2110', '21'),
('211002', 'Ananea', '2110', '21'),
('211003', 'Pedro Vilca Apaza', '2110', '21'),
('211004', 'Quilcapuncu', '2110', '21'),
('211005', 'Sina', '2110', '21'),
('211101', 'Juliaca', '2111', '21'),
('211102', 'Cabana', '2111', '21'),
('211103', 'Cabanillas', '2111', '21'),
('211104', 'Caracoto', '2111', '21'),
('211105', 'San Miguel', '2111', '21'),
('211201', 'Sandia', '2112', '21'),
('211202', 'Cuyocuyo', '2112', '21'),
('211203', 'Limbani', '2112', '21'),
('211204', 'Patambuco', '2112', '21'),
('211205', 'Phara', '2112', '21'),
('211206', 'Quiaca', '2112', '21'),
('211207', 'San Juan del Oro', '2112', '21'),
('211208', 'Yanahuaya', '2112', '21'),
('211209', 'Alto Inambari', '2112', '21'),
('211210', 'San Pedro de Putina Punco', '2112', '21'),
('211301', 'Yunguyo', '2113', '21'),
('211302', 'Anapia', '2113', '21'),
('211303', 'Copani', '2113', '21'),
('211304', 'Cuturapi', '2113', '21'),
('211305', 'Ollaraya', '2113', '21'),
('211306', 'Tinicachi', '2113', '21'),
('211307', 'Unicachi', '2113', '21'),
('220101', 'Moyobamba', '2201', '22'),
('220102', 'Calzada', '2201', '22'),
('220103', 'Habana', '2201', '22'),
('220104', 'Jepelacio', '2201', '22'),
('220105', 'Soritor', '2201', '22'),
('220106', 'Yantalo', '2201', '22'),
('220201', 'Bellavista', '2202', '22'),
('220202', 'Alto Biavo', '2202', '22'),
('220203', 'Bajo Biavo', '2202', '22'),
('220204', 'Huallaga', '2202', '22'),
('220205', 'San Pablo', '2202', '22'),
('220206', 'San Rafael', '2202', '22'),
('220301', 'San José de Sisa', '2203', '22'),
('220302', 'Agua Blanca', '2203', '22'),
('220303', 'San Martín', '2203', '22'),
('220304', 'Santa Rosa', '2203', '22'),
('220305', 'Shatoja', '2203', '22'),
('220401', 'Saposoa', '2204', '22'),
('220402', 'Alto Saposoa', '2204', '22'),
('220403', 'El Eslabón', '2204', '22'),
('220404', 'Piscoyacu', '2204', '22'),
('220405', 'Sacanche', '2204', '22'),
('220406', 'Tingo de Saposoa', '2204', '22'),
('220501', 'Lamas', '2205', '22'),
('220502', 'Alonso de Alvarado', '2205', '22'),
('220503', 'Barranquita', '2205', '22'),
('220504', 'Caynarachi', '2205', '22'),
('220505', 'Cuñumbuqui', '2205', '22'),
('220506', 'Pinto Recodo', '2205', '22'),
('220507', 'Rumisapa', '2205', '22'),
('220508', 'San Roque de Cumbaza', '2205', '22'),
('220509', 'Shanao', '2205', '22'),
('220510', 'Tabalosos', '2205', '22'),
('220511', 'Zapatero', '2205', '22'),
('220601', 'Juanjuí', '2206', '22'),
('220602', 'Campanilla', '2206', '22'),
('220603', 'Huicungo', '2206', '22'),
('220604', 'Pachiza', '2206', '22'),
('220605', 'Pajarillo', '2206', '22'),
('220701', 'Picota', '2207', '22'),
('220702', 'Buenos Aires', '2207', '22'),
('220703', 'Caspisapa', '2207', '22'),
('220704', 'Pilluana', '2207', '22'),
('220705', 'Pucacaca', '2207', '22'),
('220706', 'San Cristóbal', '2207', '22'),
('220707', 'San Hilarión', '2207', '22'),
('220708', 'Shamboyacu', '2207', '22'),
('220709', 'Tingo de Ponasa', '2207', '22'),
('220710', 'Tres Unidos', '2207', '22'),
('220801', 'Rioja', '2208', '22'),
('220802', 'Awajun', '2208', '22'),
('220803', 'Elías Soplin Vargas', '2208', '22'),
('220804', 'Nueva Cajamarca', '2208', '22'),
('220805', 'Pardo Miguel', '2208', '22'),
('220806', 'Posic', '2208', '22'),
('220807', 'San Fernando', '2208', '22'),
('220808', 'Yorongos', '2208', '22'),
('220809', 'Yuracyacu', '2208', '22'),
('220901', 'Tarapoto', '2209', '22'),
('220902', 'Alberto Leveau', '2209', '22'),
('220903', 'Cacatachi', '2209', '22'),
('220904', 'Chazuta', '2209', '22'),
('220905', 'Chipurana', '2209', '22'),
('220906', 'El Porvenir', '2209', '22'),
('220907', 'Huimbayoc', '2209', '22'),
('220908', 'Juan Guerra', '2209', '22'),
('220909', 'La Banda de Shilcayo', '2209', '22'),
('220910', 'Morales', '2209', '22'),
('220911', 'Papaplaya', '2209', '22'),
('220912', 'San Antonio', '2209', '22'),
('220913', 'Sauce', '2209', '22'),
('220914', 'Shapaja', '2209', '22'),
('221001', 'Tocache', '2210', '22'),
('221002', 'Nuevo Progreso', '2210', '22'),
('221003', 'Polvora', '2210', '22'),
('221004', 'Shunte', '2210', '22'),
('221005', 'Uchiza', '2210', '22'),
('230101', 'Tacna', '2301', '23'),
('230102', 'Alto de la Alianza', '2301', '23'),
('230103', 'Calana', '2301', '23'),
('230104', 'Ciudad Nueva', '2301', '23'),
('230105', 'Inclan', '2301', '23'),
('230106', 'Pachia', '2301', '23'),
('230107', 'Palca', '2301', '23'),
('230108', 'Pocollay', '2301', '23'),
('230109', 'Sama', '2301', '23'),
('230110', 'Coronel Gregorio Albarracín Lanchipa', '2301', '23'),
('230111', 'La Yarada los Palos', '2301', '23'),
('230201', 'Candarave', '2302', '23'),
('230202', 'Cairani', '2302', '23'),
('230203', 'Camilaca', '2302', '23'),
('230204', 'Curibaya', '2302', '23'),
('230205', 'Huanuara', '2302', '23'),
('230206', 'Quilahuani', '2302', '23'),
('230301', 'Locumba', '2303', '23'),
('230302', 'Ilabaya', '2303', '23'),
('230303', 'Ite', '2303', '23'),
('230401', 'Tarata', '2304', '23'),
('230402', 'Héroes Albarracín', '2304', '23'),
('230403', 'Estique', '2304', '23'),
('230404', 'Estique-Pampa', '2304', '23'),
('230405', 'Sitajara', '2304', '23'),
('230406', 'Susapaya', '2304', '23'),
('230407', 'Tarucachi', '2304', '23'),
('230408', 'Ticaco', '2304', '23'),
('240101', 'Tumbes', '2401', '24'),
('240102', 'Corrales', '2401', '24'),
('240103', 'La Cruz', '2401', '24'),
('240104', 'Pampas de Hospital', '2401', '24'),
('240105', 'San Jacinto', '2401', '24'),
('240106', 'San Juan de la Virgen', '2401', '24'),
('240201', 'Zorritos', '2402', '24'),
('240202', 'Casitas', '2402', '24'),
('240203', 'Canoas de Punta Sal', '2402', '24'),
('240301', 'Zarumilla', '2403', '24'),
('240302', 'Aguas Verdes', '2403', '24'),
('240303', 'Matapalo', '2403', '24'),
('240304', 'Papayal', '2403', '24'),
('250101', 'Calleria', '2501', '25'),
('250102', 'Campoverde', '2501', '25'),
('250103', 'Iparia', '2501', '25'),
('250104', 'Masisea', '2501', '25'),
('250105', 'Yarinacocha', '2501', '25'),
('250106', 'Nueva Requena', '2501', '25'),
('250107', 'Manantay', '2501', '25'),
('250201', 'Raymondi', '2502', '25'),
('250202', 'Sepahua', '2502', '25'),
('250203', 'Tahuania', '2502', '25'),
('250204', 'Yurua', '2502', '25'),
('250301', 'Padre Abad', '2503', '25'),
('250302', 'Irazola', '2503', '25'),
('250303', 'Curimana', '2503', '25'),
('250304', 'Neshuya', '2503', '25'),
('250305', 'Alexander Von Humboldt', '2503', '25'),
('250401', 'Purus', '2504', '25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `identificacion` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_paterno` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_materno` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `celular` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `profesion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `status_empleado` int(11) NOT NULL,
  `registrado_por` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `id_foto` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `ruta_foto` varchar(200) NOT NULL,
  `tipo` tinyint(3) NOT NULL,
  `fecha` date DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `idPerson` int(11) DEFAULT NULL,
  `idProyect` int(11) DEFAULT NULL,
  `idConv` int(11) DEFAULT NULL,
  `idProc` int(11) DEFAULT NULL,
  `idProv` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`id_foto`, `descripcion`, `ruta_foto`, `tipo`, `fecha`, `id_modulo`, `idPerson`, `idProyect`, `idConv`, `idProc`, `idProv`, `fecha_registro`, `id_usuario`) VALUES
(10, 'Organigrama de INSERGE', '1656987234_2e57db10de318501c9b7.png', 1, '2022-07-04', NULL, NULL, NULL, 1, NULL, NULL, '2022-07-05 02:13:54', 1),
(11, 'Diagrama de Cola de Pescado', '1656987343_e68fa6c348cc4afb3c48.png', 2, '2022-07-04', NULL, 1, NULL, NULL, NULL, NULL, '2022-07-05 02:15:43', 1),
(12, 'Universidad Cesar Vallejo', '1656987387_7fa360038f27851d4c49.png', 1, '2022-07-04', 3, 2, NULL, 1, NULL, 5, '2022-07-05 02:16:27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `Modulo` varchar(6) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `ATechada` varchar(6) NOT NULL,
  `AConstruida` varchar(6) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `Modulo`, `descripcion`, `ATechada`, `AConstruida`, `fecha_registro`, `id_usuario`, `status`) VALUES
(1, '3', 'Modulo de frente de 3 metros', '36.00', '38.40', '2022-06-06 06:03:10', 1, b'0'),
(2, '3.5', 'Modulo de frente de 3.5 metros', '35.28', '38.43', '2022-06-06 06:14:11', 1, b'1'),
(3, '4', 'Modulo de frente de 4 metros', '35', '37', '2022-06-06 06:16:06', 1, b'1'),
(4, '5', 'Modulo de frente de 5 metros', '35', '37.5', '2022-06-06 06:16:26', 1, b'1'),
(5, '6', 'Modulo de frente de 6 metros', '35.04', '38.04', '2022-06-06 06:16:50', 1, b'1'),
(6, '7', 'Modulo de frente de 7 metros', '35.04', '38.04', '2022-06-06 06:17:22', 1, b'1'),
(8, '23', 'adwafgawgwa', '12.3', '12.2', '2022-06-28 01:56:50', 1, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `id_rol`, `id_cargo`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 1, 1),
(8, 8, 1, 1),
(9, 9, 1, 1),
(10, 10, 1, 1),
(11, 11, 1, 1),
(12, 12, 1, 1),
(13, 13, 1, 1),
(14, 14, 1, 1),
(15, 15, 1, 1),
(16, 16, 1, 1),
(17, 1, 2, 1),
(18, 2, 2, 1),
(19, 3, 2, 1),
(20, 4, 2, 1),
(21, 5, 2, 0),
(22, 6, 2, 0),
(23, 7, 2, 0),
(24, 8, 2, 0),
(25, 9, 2, 0),
(26, 10, 2, 0),
(27, 11, 2, 0),
(28, 12, 2, 0),
(29, 13, 2, 0),
(30, 14, 2, 0),
(31, 15, 2, 0),
(32, 16, 2, 0),
(33, 1, 3, 0),
(34, 2, 3, 0),
(35, 3, 3, 0),
(36, 4, 3, 0),
(37, 5, 3, 1),
(38, 6, 3, 1),
(39, 7, 3, 1),
(40, 8, 3, 1),
(41, 9, 3, 1),
(42, 10, 3, 1),
(43, 11, 3, 1),
(44, 12, 3, 1),
(45, 13, 3, 1),
(46, 14, 3, 0),
(47, 15, 3, 0),
(48, 16, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `Identificacion` char(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidoPAT` varchar(50) NOT NULL,
  `apellidoMAT` varchar(50) NOT NULL,
  `sexo` char(1) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `iddistrito` char(6) NOT NULL,
  `estado_civil` char(1) NOT NULL DEFAULT '',
  `telefono` varchar(9) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `profesion` varchar(50) DEFAULT NULL,
  `nacimiento` date DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `Identificacion`, `nombre`, `apellidoPAT`, `apellidoMAT`, `sexo`, `direccion`, `iddistrito`, `estado_civil`, `telefono`, `email`, `profesion`, `nacimiento`, `fecha_registro`, `id_usuario`, `status`) VALUES
(1, '75954109', 'DIEGO ARTURO', 'YANGUA', 'MERINO', 'M', 'VILLA JARDIN MZ H LOTE 8', '200101', '1', '992058519', 'DACYGAMING@GMAIL.COM', 'INGENIERO DE SISTEMAS', '2002-02-12', '2022-06-06 02:26:45', 1, b'1'),
(2, '72880110', 'OLGA ISABEL', 'ZAPATA', 'CULQUICONDOR', 'F', '', '200601', '0', '946977006', '', '', '0000-00-00', '2022-06-06 18:48:17', 1, b'1'),
(3, '45150881', 'WILDER', 'QUISPE', 'GUEVARA', 'N', 'ASENTAMIENTO HUMANO: SAN MIGUEL BAJO MZ E  LOTE 4', '200101', '0', '', '', '', '1991-07-15', '2022-06-18 03:32:26', 1, b'1'),
(4, '02884959', 'PALERMO', 'CASTILLO', 'CORDOVA', 'M', 'ASENTAMIENTO HUMANO: TUPAC AMARU MZ J LOTE 1', '200101', '0', '', '', '', '1979-06-05', '2022-06-18 07:49:33', 1, b'1'),
(5, '46601379', 'PEPITO', 'RUIZ', 'CASTILLO', 'M', 'ASENTAMIENTO HUMANO: SAN MIGUEL BAJO MZ M  LOTE 11', '200101', '0', '', '', '', '0000-00-00', '2022-06-18 08:39:46', 1, b'0'),
(6, '72621246', 'RANDOLPH', 'RAMIREZ', 'PALACIOS', 'M', 'SANTA MARTA N 120', '200101', '0', '945529033', 'RRAMIREZ@UCVVIRTUAL.EDU.PE', 'INGENIERO DE SISTEMAS', '1955-06-07', '2022-06-18 13:33:56', 2, b'1'),
(8, '77074644', 'CARLOS ADRIAN', 'MENDOZA', 'VALDIVIEZO', 'M', 'CA. SANTA CATALINA NRO. 821 AA.HH SANCHEZ CERRO', '200601', '0', '980226034', 'CMENDOZAVALDIVIEZO@OUTLOOK.ES', 'INGENIERO DE SISTEMAS', '2000-06-28', '2022-07-05 01:38:34', 1, b'1'),
(9, '74247163', 'EDGAR LIZARDO', ' FUENTES', ' ALVARADO', 'M', '', '200401', '3', '950890944', 'EFUENTESAL@UCVVIRTUAL.EDU.PE', '', '2001-06-30', '2022-07-11 03:29:37', 2, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` char(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `unidad_medida` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `stockmin` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_producto`, `descripcion`, `unidad_medida`, `stock`, `stockmin`, `fecha`, `hora`, `id_proveedor`, `estado`, `fecha_registro`, `id_usuario`) VALUES
(1, 'MAT-000001', 'LADRILLO', 48, 1, 0, '2022-06-09', '00:00:00', 5, 1, '2022-07-12 00:26:02', 1),
(2, 'MAT-000002', 'ALAMBRE', 2, 100, 20, '2022-06-13', '01:23:00', 2, 1, '2022-07-11 22:41:22', 1),
(4, 'MAT-000003', 'SOGA', 1, 100, 20, '2022-06-13', '01:24:00', 7, 1, '2022-07-11 22:41:31', 1),
(5, 'MAT-000005', 'CEMENTO', 2, 100, 2, '2022-06-13', '12:16:00', 6, 1, '2022-07-11 22:41:34', 1),
(6, 'MAT-000009', 'ALICATE', 1, 100, 2, '2022-04-27', '07:16:00', 8, 1, '2022-07-11 22:41:37', 1),
(9, 'MAT-000010', 'JABON', 8, 100, 0, '2022-06-14', '11:56:00', 5, 1, '2022-07-11 22:41:40', 1),
(10, 'MAT-000011', 'CHAMPU', 2, 101, 1, '2022-06-14', '11:56:00', 1, 1, '2022-06-30 02:15:19', 1),
(11, 'MAT-000012', 'PALANAS', 1, 89, 0, '2022-06-14', '11:56:00', 5, 1, '2022-07-05 02:08:55', 1),
(12, 'MAT-000013', 'ARENA', 6, 69, 0, '2022-06-14', '19:29:00', 6, 1, '2022-07-05 02:08:26', 1),
(13, 'MAT-000007', 'TROMPO', 1, 100, 0, '2022-06-29', '20:58:00', 12, 1, '2022-07-11 22:41:48', 1),
(14, 'MAT-000006', 'OBSIDIANA', 2, 100, 5, '2022-07-04', '10:10:00', 12, 1, '2022-07-11 22:41:51', 1),
(16, 'MAT-000021', 'BUGGIES', 37, 200, 0, '2022-07-11', '00:59:00', 8, 1, '2022-07-11 06:02:39', 1),
(18, 'MAT-000004', 'MARTILLO', 1, 23, 0, '2022-07-11', '12:30:00', 6, 1, '2022-07-12 00:20:25', 22),
(19, 'MAT-000015', '20009', 2, 4, 1, '2022-07-11', '21:39:00', 6, 1, '2022-07-12 00:38:19', 22),
(20, 'MAT-000008', 'MAMI RICA', 2, 20, 0, '2022-07-11', '00:45:00', 5, 1, '2022-07-12 00:41:32', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedores` int(11) NOT NULL,
  `RUC` char(11) NOT NULL,
  `razon_social` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `telefono` varchar(15) NOT NULL DEFAULT '',
  `direccion` varchar(50) DEFAULT NULL,
  `id_distrito` char(50) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedores`, `RUC`, `razon_social`, `email`, `telefono`, `direccion`, `id_distrito`, `fecha_registro`, `id_usuario`, `estado`) VALUES
(1, '20215528791', 'INVERSIONES CYS S.A.', 'incoresasa@incorlima.pe', '6197373', 'CAL. SANTA BERNARDITA NRO. 024', '150101', '2022-06-28 01:55:47', 1, b'1'),
(2, '20100686815', 'OLVA COURIER S.A.C', 'principalolva@olvacourier.com', '7140909', 'AV. GRAL.ALVAREZ DE ARENALES NRO. 1775 (C.C.ARENAL', '150101', '2022-06-18 05:44:27', 1, b'1'),
(3, '20502454545', 'SERVICIOS LOGISTICOS DE COURIER DEL PERU S.A.C.', 'oficinaslgtc@olvacourier.com', '6150900', 'AV. LAS CAMELIAS NRO. 877 DPTO. A INT. 302', '150101', '2022-06-05 21:29:45', 1, b'1'),
(4, '20536557858', 'HOMECENTERS PERUANOS S.A.', 'oficina@promart.com.pe', '7001500', 'AV. AVIACION NRO. 2405 (PISO 5)', '010101', '2022-06-18 05:44:50', 1, b'0'),
(5, '20103365628', 'DISTRIBUCIONES OLANO S.A.C.', 'olanooficinas@olanoperu.com', '222988', 'CAL. LEONCIO PRADO NRO. 549', '140101', '2022-06-13 05:59:40', 1, b'1'),
(6, '20481681325', 'CONSTRUCTORA A & A S.A.C', 'oficinAs@PrimeraA.com.pe', '206184', ' CAL. JUAN JULIO GANOZA NRO. 187 INT. 2', '130101', '2022-06-06 18:28:50', 1, b'1'),
(7, '20103365684', 'SHOMECENTERS PERUANOS S.A.', 'oficina@promart.com.pe', '7001500', 'AV. AVIACION NRO. 2405 (PISO 5)', '020101', '2022-06-06 18:28:47', 1, b'1'),
(8, '20389230724', 'SODIMAC PERU S.A', 'sodimac-m@sdcoficinas.com', '2216465', 'AV. ANGAMOS ESTE NRO. 1805 INT. 2 (OFICINA 2)', '200101', '2022-07-05 02:24:01', 1, b'1'),
(9, '20601029791', 'IMPORTACIONES CASA LU SOCIEDAD ANONIMA CERRADA - I', 'oficinascasalu@casalu.com', '51313', 'KM. 1308 MZA. F LOTE. 19 COMPLEJO ZOFRATACNA CAR', '230101', '2022-06-14 18:04:17', 1, b'0'),
(10, '20518596188', 'CONSORCIO NEX PERU S.A.C.', 'dazi@nexcourier.com', '7199785', 'PRL HUANUCO NRO. 2544', '150101', '2022-06-14 18:01:55', 1, b'0'),
(11, '20100152275', 'JOCKEY CLUB DEL PERU', 'jockeycluboficce@jcp.org.pe', '6103000', 'AV. EL DERBY NRO. SN INT. PTA3', '150101', '2022-06-28 01:55:39', 1, b'1'),
(12, '20521119943', 'CONSTRUCTORA GALILEA S.A.C.', 'Oficina@galilea.com.pe', '3441726', 'AV. PRIMAVERA NRO. 1796 INT. 601', '150101', '2022-06-18 05:44:39', 1, b'1'),
(28, '20411252095', 'MATERIALES S.A.C.', 'materialesofi@gmail.com', '431031', ' AV. MARISCAL CASTILLA NRO. 1357 SEC. PUEBLO LIBRE', '060101', '2022-07-12 01:21:09', 1, b'0'),
(29, '20136836545', 'ARDILES IMPORT S.A.C.', 'ofis@ardilesimport.com', '3190660', 'AV. SANTA MARIA NRO. 230', '150103', '2022-06-15 00:24:02', 1, b'1'),
(31, '20100152273', 'SDVÑKMSFVBL', 'SFADVads@dfafw.com', '123123', 'FCSA', '130401', '2022-07-11 07:11:59', 22, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id` varchar(4) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `id_departamento` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `nombre`, `id_departamento`) VALUES
('0101', 'Chachapoyas', '01'),
('0102', 'Bagua', '01'),
('0103', 'Bongará', '01'),
('0104', 'Condorcanqui', '01'),
('0105', 'Luya', '01'),
('0106', 'Rodríguez de Mendoza', '01'),
('0107', 'Utcubamba', '01'),
('0201', 'Huaraz', '02'),
('0202', 'Aija', '02'),
('0203', 'Antonio Raymondi', '02'),
('0204', 'Asunción', '02'),
('0205', 'Bolognesi', '02'),
('0206', 'Carhuaz', '02'),
('0207', 'Carlos Fermín Fitzcarrald', '02'),
('0208', 'Casma', '02'),
('0209', 'Corongo', '02'),
('0210', 'Huari', '02'),
('0211', 'Huarmey', '02'),
('0212', 'Huaylas', '02'),
('0213', 'Mariscal Luzuriaga', '02'),
('0214', 'Ocros', '02'),
('0215', 'Pallasca', '02'),
('0216', 'Pomabamba', '02'),
('0217', 'Recuay', '02'),
('0218', 'Santa', '02'),
('0219', 'Sihuas', '02'),
('0220', 'Yungay', '02'),
('0301', 'Abancay', '03'),
('0302', 'Andahuaylas', '03'),
('0303', 'Antabamba', '03'),
('0304', 'Aymaraes', '03'),
('0305', 'Cotabambas', '03'),
('0306', 'Chincheros', '03'),
('0307', 'Grau', '03'),
('0401', 'Arequipa', '04'),
('0402', 'Camaná', '04'),
('0403', 'Caravelí', '04'),
('0404', 'Castilla', '04'),
('0405', 'Caylloma', '04'),
('0406', 'Condesuyos', '04'),
('0407', 'Islay', '04'),
('0408', 'La Uniòn', '04'),
('0501', 'Huamanga', '05'),
('0502', 'Cangallo', '05'),
('0503', 'Huanca Sancos', '05'),
('0504', 'Huanta', '05'),
('0505', 'La Mar', '05'),
('0506', 'Lucanas', '05'),
('0507', 'Parinacochas', '05'),
('0508', 'Pàucar del Sara Sara', '05'),
('0509', 'Sucre', '05'),
('0510', 'Víctor Fajardo', '05'),
('0511', 'Vilcas Huamán', '05'),
('0601', 'Cajamarca', '06'),
('0602', 'Cajabamba', '06'),
('0603', 'Celendín', '06'),
('0604', 'Chota', '06'),
('0605', 'Contumazá', '06'),
('0606', 'Cutervo', '06'),
('0607', 'Hualgayoc', '06'),
('0608', 'Jaén', '06'),
('0609', 'San Ignacio', '06'),
('0610', 'San Marcos', '06'),
('0611', 'San Miguel', '06'),
('0612', 'San Pablo', '06'),
('0613', 'Santa Cruz', '06'),
('0701', 'Prov. Const. del Callao', '07'),
('0801', 'Cusco', '08'),
('0802', 'Acomayo', '08'),
('0803', 'Anta', '08'),
('0804', 'Calca', '08'),
('0805', 'Canas', '08'),
('0806', 'Canchis', '08'),
('0807', 'Chumbivilcas', '08'),
('0808', 'Espinar', '08'),
('0809', 'La Convención', '08'),
('0810', 'Paruro', '08'),
('0811', 'Paucartambo', '08'),
('0812', 'Quispicanchi', '08'),
('0813', 'Urubamba', '08'),
('0901', 'Huancavelica', '09'),
('0902', 'Acobamba', '09'),
('0903', 'Angaraes', '09'),
('0904', 'Castrovirreyna', '09'),
('0905', 'Churcampa', '09'),
('0906', 'Huaytará', '09'),
('0907', 'Tayacaja', '09'),
('1001', 'Huánuco', '10'),
('1002', 'Ambo', '10'),
('1003', 'Dos de Mayo', '10'),
('1004', 'Huacaybamba', '10'),
('1005', 'Huamalíes', '10'),
('1006', 'Leoncio Prado', '10'),
('1007', 'Marañón', '10'),
('1008', 'Pachitea', '10'),
('1009', 'Puerto Inca', '10'),
('1010', 'Lauricocha ', '10'),
('1011', 'Yarowilca ', '10'),
('1101', 'Ica ', '11'),
('1102', 'Chincha ', '11'),
('1103', 'Nasca ', '11'),
('1104', 'Palpa ', '11'),
('1105', 'Pisco ', '11'),
('1201', 'Huancayo ', '12'),
('1202', 'Concepción ', '12'),
('1203', 'Chanchamayo ', '12'),
('1204', 'Jauja ', '12'),
('1205', 'Junín ', '12'),
('1206', 'Satipo ', '12'),
('1207', 'Tarma ', '12'),
('1208', 'Yauli ', '12'),
('1209', 'Chupaca ', '12'),
('1301', 'Trujillo ', '13'),
('1302', 'Ascope ', '13'),
('1303', 'Bolívar ', '13'),
('1304', 'Chepén ', '13'),
('1305', 'Julcán ', '13'),
('1306', 'Otuzco ', '13'),
('1307', 'Pacasmayo ', '13'),
('1308', 'Pataz ', '13'),
('1309', 'Sánchez Carrión ', '13'),
('1310', 'Santiago de Chuco ', '13'),
('1311', 'Gran Chimú ', '13'),
('1312', 'Virú ', '13'),
('1401', 'Chiclayo ', '14'),
('1402', 'Ferreñafe ', '14'),
('1403', 'Lambayeque ', '14'),
('1501', 'Lima ', '15'),
('1502', 'Barranca ', '15'),
('1503', 'Cajatambo ', '15'),
('1504', 'Canta ', '15'),
('1505', 'Cañete ', '15'),
('1506', 'Huaral ', '15'),
('1507', 'Huarochirí ', '15'),
('1508', 'Huaura ', '15'),
('1509', 'Oyón ', '15'),
('1510', 'Yauyos ', '15'),
('1601', 'Maynas ', '16'),
('1602', 'Alto Amazonas ', '16'),
('1603', 'Loreto ', '16'),
('1604', 'Mariscal Ramón Castilla ', '16'),
('1605', 'Requena ', '16'),
('1606', 'Ucayali ', '16'),
('1607', 'Datem del Marañón ', '16'),
('1608', 'Putumayo', '16'),
('1701', 'Tambopata ', '17'),
('1702', 'Manu ', '17'),
('1703', 'Tahuamanu ', '17'),
('1801', 'Mariscal Nieto ', '18'),
('1802', 'General Sánchez Cerro ', '18'),
('1803', 'Ilo ', '18'),
('1901', 'Pasco ', '19'),
('1902', 'Daniel Alcides Carrión ', '19'),
('1903', 'Oxapampa ', '19'),
('2001', 'Piura ', '20'),
('2002', 'Ayabaca ', '20'),
('2003', 'Huancabamba ', '20'),
('2004', 'Morropón ', '20'),
('2005', 'Paita ', '20'),
('2006', 'Sullana ', '20'),
('2007', 'Talara ', '20'),
('2008', 'Sechura ', '20'),
('2101', 'Puno ', '21'),
('2102', 'Azángaro ', '21'),
('2103', 'Carabaya ', '21'),
('2104', 'Chucuito ', '21'),
('2105', 'El Collao ', '21'),
('2106', 'Huancané ', '21'),
('2107', 'Lampa ', '21'),
('2108', 'Melgar ', '21'),
('2109', 'Moho ', '21'),
('2110', 'San Antonio de Putina ', '21'),
('2111', 'San Román ', '21'),
('2112', 'Sandia ', '21'),
('2113', 'Yunguyo ', '21'),
('2201', 'Moyobamba ', '22'),
('2202', 'Bellavista ', '22'),
('2203', 'El Dorado ', '22'),
('2204', 'Huallaga ', '22'),
('2205', 'Lamas ', '22'),
('2206', 'Mariscal Cáceres ', '22'),
('2207', 'Picota ', '22'),
('2208', 'Rioja ', '22'),
('2209', 'San Martín ', '22'),
('2210', 'Tocache ', '22'),
('2301', 'Tacna ', '23'),
('2302', 'Candarave ', '23'),
('2303', 'Jorge Basadre ', '23'),
('2304', 'Tarata ', '23'),
('2401', 'Tumbes ', '24'),
('2402', 'Contralmirante Villar ', '24'),
('2403', 'Zarumilla ', '24'),
('2501', 'Coronel Portillo ', '25'),
('2502', 'Atalaya ', '25'),
('2503', 'Padre Abad ', '25'),
('2504', 'Purús', '25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `id_proyecto` int(11) NOT NULL,
  `cod_proyecto` char(10) NOT NULL,
  `NContrato` varchar(10) NOT NULL,
  `idConv` int(11) NOT NULL,
  `idPerson` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `tipoUrb` varchar(50) NOT NULL,
  `direccion_proyecto` varchar(50) NOT NULL,
  `Mz` varchar(10) NOT NULL,
  `Lote` varchar(10) NOT NULL,
  `Frente` varchar(50) NOT NULL,
  `FrenteM` float NOT NULL,
  `Derecha` varchar(50) NOT NULL,
  `DerechaM` float NOT NULL,
  `Izquierda` varchar(50) NOT NULL,
  `IzquierdaM` float NOT NULL,
  `Fondo` varchar(50) NOT NULL,
  `FondoM` float NOT NULL,
  `Area` float NOT NULL,
  `Arancel` float NOT NULL,
  `CVU` float NOT NULL,
  `VObra` float NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `id_distrito` char(50) NOT NULL,
  `Alcalde` varchar(100) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Luz` tinyint(1) NOT NULL,
  `agua` tinyint(1) NOT NULL,
  `desague` tinyint(1) NOT NULL,
  `Pseptico` tinyint(1) NOT NULL,
  `directorio` varchar(30) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`id_proyecto`, `cod_proyecto`, `NContrato`, `idConv`, `idPerson`, `estado`, `id_modulo`, `sector`, `tipoUrb`, `direccion_proyecto`, `Mz`, `Lote`, `Frente`, `FrenteM`, `Derecha`, `DerechaM`, `Izquierda`, `IzquierdaM`, `Fondo`, `FondoM`, `Area`, `Arancel`, `CVU`, `VObra`, `x`, `y`, `id_distrito`, `Alcalde`, `Fecha`, `Luz`, `agua`, `desague`, `Pseptico`, `directorio`, `fecha_registro`, `id_usuario`) VALUES
(12, 'ISG-002-21', 'ISG-002-21', 4, 2, 'C', 4, '', '8', 'Sullana Otro Trago', 'F', '2', 'Down', 12.23, 'Left', 23.2, 'Right', 123, 'Up', 21, 1221, 43, 23, 26400, -12312, -213, '050103', NULL, '2022-06-27', 1, 1, 0, 1, 'J6R8McszkTAsvLsViuLSp7PyBhxXTB', '2022-06-28 01:52:43', 1),
(14, 'ISG-022-21', 'ISG-022-21', 6, 4, 'D', 4, 'ALAYA', '10', 'EL MARCINTO', 'H', '12', 'AV. GRAU', 6, 'LOTE 13', 20, 'LOTE 11', 20, 'LOTE 6B', 6, 120, 64, 512, 26400, -18.3913, -5.12312, '200114', NULL, '2022-06-29', 1, 1, 1, 0, 'pPwUskRZFDwUMAYpuJkV1tmSH4GFIF', '2022-06-30 02:55:32', 1),
(16, 'ISG-022-22', 'ISG-022-22', 1, 6, 'E', 6, 'Zona 0', '1', 'Santa Martha', 'F', '7', 'AV. G', 7, 'AV. O', 7, 'AV. D', 7, 'Terreno Asfaltado', 7, 10, 70, 513, 26372, -10, 10, '200101', NULL, '2022-07-04', 1, 1, 1, 0, 'eysB2SMr0ThZTydzhoS4giojrBLYwf', '2022-07-05 02:01:57', 1),
(20, 'ISG-001-21', 'ISG-001-21', 4, 1, 'N', 3, 'daw', '4', 'awdaw', 'awd', 'awd', 'daw', 213, 'aw', 213, 'awd', 123, 'aw', 132, 213, 312, 32, 26400, -23, -7, '070101', NULL, '2022-07-11', 0, 0, 0, 0, 'XjVzZzhlxu5qsa833Pl0tTcvijiJX8', '2022-07-11 06:50:26', 22),
(23, 'ISG-012-21', 'ISG-002-21', 5, 3, 'E', 5, 'cxb', '-1', 'fn', 'dsa', 'das', 'a121', 31, '213', 13, '312', 23, '312', 2, 32, 23, 23, 26400, 32, 32, '050101', NULL, '2022-07-11', 0, 0, 0, 0, 'WbKkOYohiieT56autrNMhOs63DZbQ2', '2022-07-11 06:55:04', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `titulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcioin` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `titulo`, `descripcioin`, `url`, `estado`) VALUES
(1, 'inicio', 'principal', '/dashboard', 1),
(2, 'inventario', 'inventario ', NULL, 1),
(3, 'proyectos', 'proyectos ', '/proyectos ', 1),
(4, 'movimientos', 'movimientos ', '/movimientos ', 1),
(5, 'administracion', 'administracion general ', NULL, 1),
(6, 'gerencia', 'gerencia general ', NULL, 1),
(7, 'proveedores', 'proveedores generales ', '/proveedores ', 1),
(8, 'talento', 'personas ', '/talento ', 1),
(9, 'modulos', 'modulos ', '/modulos ', 1),
(10, 'convocatoria', 'convocatoria ', '/convocatoria ', 1),
(11, 'categorias', 'categorias ', '/categoria ', 1),
(12, 'medidas', 'unidades de medidas ', '/medidas', 1),
(13, 'Evidencia', 'Evidencia ', '/documentacion ', 1),
(14, 'ConfiguracionDelSistema ', 'configuracion del sistema ', NULL, 1),
(15, 'Usuarios', 'usuarios del sistema ', NULL, 1),
(16, 'Resumen', 'resumen de usuarios ', '/resumen-usuarios ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_proyecto_material`
--

CREATE TABLE `tabla_proyecto_material` (
  `id_PM` int(11) NOT NULL,
  `codigo_proyecto` char(10) NOT NULL,
  `codigo_material` char(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tabla_proyecto_material`
--

INSERT INTO `tabla_proyecto_material` (`id_PM`, `codigo_proyecto`, `codigo_material`, `cantidad`, `fecha_registro`) VALUES
(1, 'ISG-022-22', 'MAT-000013', 9, '2022-07-05 02:08:26'),
(2, 'ISG-022-21', 'MAT-000012', 6, '2022-07-05 02:08:55'),
(3, 'ISG-002-21', 'MAT-000002', 111, '2022-07-11 07:05:52'),
(4, 'ISG-022-22', 'MAT-000003', 3, '2022-07-11 21:34:40'),
(5, 'ISG-022-22', 'MAT-000002', 1, '2022-07-11 22:06:28'),
(6, 'ISG-022-22', 'MAT-000001', 10, '2022-07-11 22:54:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadmedida`
--

CREATE TABLE `unidadmedida` (
  `idMedida` int(11) NOT NULL,
  `UndMedida` varchar(30) NOT NULL,
  `PlrMedida` varchar(30) NOT NULL,
  `Simbolo` varchar(20) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `unidadmedida`
--

INSERT INTO `unidadmedida` (`idMedida`, `UndMedida`, `PlrMedida`, `Simbolo`, `fecha_registro`, `id_usuario`, `status`) VALUES
(1, 'Unidad', 'Unidades', 'und', '2022-06-11 08:11:32', 1, b'1'),
(2, 'Kilogramo', 'Kilogramos', 'Kg', '2022-06-11 08:14:47', 1, b'1'),
(3, 'Caja', 'Cajas', '', '2022-06-11 08:24:21', 1, b'1'),
(4, 'Paquete', 'Paquetes', 'Pack', '2022-06-11 08:25:21', 1, b'1'),
(5, 'Tonelada', 'Toneladas', 't', '2022-06-11 08:25:46', 1, b'1'),
(6, 'Balde', 'Baldes', '', '2022-06-11 08:25:56', 1, b'1'),
(7, 'Barril', 'Barriles', '', '2022-06-11 08:26:03', 1, b'1'),
(8, 'Bobina', 'Bobinas', '', '2022-06-11 08:42:35', 1, b'1'),
(9, 'Bolsa', 'Bolsas', '', '2022-06-11 08:42:41', 1, b'1'),
(10, 'Botella', 'Botellas', '', '2022-06-11 08:42:47', 1, b'1'),
(11, 'Carton', 'Cartones', '', '2022-06-11 08:43:08', 1, b'1'),
(12, 'Cilindro', 'Cilindros', '', '2022-06-11 08:43:39', 1, b'1'),
(13, 'Docena', 'Docenas', '', '2022-06-11 08:43:55', 1, b'1'),
(14, 'Cono', 'Conos', '', '2022-06-11 08:44:07', 1, b'1'),
(15, 'Gramo', 'Gramos', 'g', '2022-06-11 08:44:27', 1, b'1'),
(16, 'Fardo', 'Fardos', '', '2022-06-11 08:45:29', 1, b'1'),
(17, 'Juego', 'Juegos', '', '2022-06-11 08:45:39', 1, b'1'),
(18, 'Kilometro', 'Kilometros', 'km', '2022-06-11 08:45:55', 1, b'1'),
(19, 'Kit', 'Kits', '', '2022-06-11 08:46:06', 1, b'1'),
(20, 'Lata', 'Latas', '', '2022-06-11 08:46:18', 1, b'1'),
(21, 'Libra', 'Libras', '£', '2022-06-11 08:46:42', 1, b'1'),
(22, 'Litro', 'Litros', 'l', '2022-06-11 08:47:26', 1, b'1'),
(23, 'Megawatt', 'Megawatts', 'MW', '2022-06-11 08:47:57', 1, b'1'),
(24, 'Metro', 'Metros', 'm', '2022-06-11 08:48:47', 1, b'1'),
(25, 'Metro cuadrado', 'Metros Cuadrados', 'm²', '2022-06-11 08:49:27', 1, b'1'),
(26, 'Metro cubico', 'Metros Cubicos', 'm³', '2022-06-11 08:50:06', 1, b'1'),
(27, 'Miligramo', 'Miligramos', 'mg', '2022-06-11 08:50:24', 1, b'1'),
(28, 'Mililitro', 'Mililitros', 'ml', '2022-06-11 08:50:34', 1, b'1'),
(29, 'Millar', 'Millares', '', '2022-06-11 08:51:03', 1, b'1'),
(30, 'Onza', 'Onzas', 'oz', '2022-06-11 08:51:29', 1, b'1'),
(31, 'Galón', 'Galones', 'gl', '2022-06-11 08:52:00', 1, b'1'),
(32, 'Par', 'Pares', '', '2022-06-11 08:52:36', 1, b'1'),
(33, 'Pie', 'Pies', 'ft', '2022-06-11 08:52:52', 1, b'1'),
(34, 'Pie cuadrado', 'Pies cuadrados', 'ft²', '2022-06-11 08:53:01', 1, b'1'),
(35, 'Pie cubico', 'Pies cubicos', 'ft³', '2022-06-11 08:53:34', 1, b'1'),
(36, 'Pieza', 'Piezas', '', '2022-06-11 08:53:50', 1, b'1'),
(37, 'Tubo', 'Tubos', '', '2022-06-11 08:54:05', 1, b'1'),
(38, 'Placa', 'Placas', '', '2022-06-11 08:54:19', 1, b'1'),
(39, 'Pliego', 'Pliegos', '', '2022-06-11 08:54:24', 1, b'1'),
(40, 'Pulgada', 'Pulgadas', '', '2022-06-11 08:54:39', 1, b'1'),
(41, 'Yarda', 'Yardas', 'yd', '2022-06-11 08:54:51', 1, b'1'),
(42, 'Yarda cuadrada', 'Yardas cuadradas', 'yd²', '2022-06-11 08:55:06', 1, b'1'),
(43, 'Resma', 'Resmas', '', '2022-06-11 08:55:48', 1, b'1'),
(44, 'Kilovatio', 'Kilovatios', 'kW', '2022-06-11 08:56:13', 1, b'1'),
(45, 'Milla', 'Millas', 'mi', '2022-06-11 08:59:07', 1, b'1'),
(46, 'Hectarea', 'Hectareas', 'ha', '2022-06-11 09:01:15', 1, b'1'),
(47, 'Centimetro', 'Centimetros', 'cm', '2022-06-11 09:01:25', 1, b'1'),
(48, 'Centena', 'Centenares', '', '2022-06-12 03:43:49', 1, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasenia` text NOT NULL,
  `ultimo_acceso` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto_perfil` varchar(200) DEFAULT NULL,
  `id_cargo` int(11) NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `registrado_por` int(11) NOT NULL,
  `accesos` int(11) NOT NULL,
  `teme` int(11) NOT NULL,
  `sesion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `usuario`, `contrasenia`, `ultimo_acceso`, `foto_perfil`, `id_cargo`, `fecha_registro`, `status`, `registrado_por`, `accesos`, `teme`, `sesion`) VALUES
(1, 1, 'diego_yangua', '$2y$10$lC/IhZb.9WGqYlMR6h312uCH9ZMvUn4yporNCccDUpDpN/V6DnY/G', '2022-12-02 20:42:53', NULL, 3, '2022-06-21 05:08:19', 1, 1, 39, 0, 1),
(2, 8, 'carlos_mendoza', '$2y$10$ay/hMftC7YqzfX4CrvrotuBtjZty6cobu.w8UidfY29FR.Or68/Wa', '2022-12-02 20:14:03', NULL, 2, '2022-06-22 06:26:49', 1, 1, 35, 0, 2),
(20, 6, 'randolph_ramirez', '$2y$10$R/51t/V6gt9h/U1fp04G3.WrcIHDtxeQNkWqSEZzzRJmmNYGi1Jyq', '2022-12-02 20:13:36', NULL, 2, '2022-07-05 01:39:49', 1, 2, 8, 0, 0),
(21, 2, 'Olga_72880110', '$2y$10$oZOrYRdcz9bXYE4SAhJLkehRDnKnodknxv4vzHYDXThDuwXlsLNlO', '2022-07-11 04:34:25', NULL, 2, '2022-07-05 01:51:34', 0, 2, 9, 1, 0),
(22, 9, 'edgar_fuentes', '$2y$10$7TmBdtxxqxghRyrKM/nwjOMj71dUNCxqFNiWTnPpez2G0Iz6bU.Wa', '2022-12-02 20:13:47', NULL, 3, '2022-07-11 03:30:21', 1, 2, 16, 0, 1),
(23, 4, 'Palermo_02884959', '$2y$10$oa4QlOHj1IQB0SjML4znBespgkj8HvHJT7IgXdH4PJLU50TEP0DvW', '2022-07-11 19:58:08', NULL, 2, '2022-07-11 07:34:32', 0, 22, 6, 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  ADD PRIMARY KEY (`idConvocatoria`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD KEY `FK_detallep_producto` (`id_producto`),
  ADD KEY `FK_detallep_proveedor` (`id_proveedor`),
  ADD KEY `FK_detallep_usuario` (`id_usuario`);

--
-- Indices de la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_distritos_departamento` (`id_departamento`),
  ADD KEY `FK_distritos_provinica` (`id_provincia`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `FK_fotos_modulo` (`id_modulo`),
  ADD KEY `FK_fotos_usuario` (`id_usuario`),
  ADD KEY `FK_fotos_person` (`idPerson`),
  ADD KEY `FK_fotos_proyct` (`idProyect`),
  ADD KEY `FK_fotos_convocatoria` (`idConv`),
  ADD KEY `FK_fotos_producto` (`idProc`),
  ADD KEY `FK_fotos_proveedor` (`idProv`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `DNI` (`Identificacion`),
  ADD KEY `FK_persona_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `MIAU` (`codigo_producto`),
  ADD KEY `FK_productos_proveedor` (`id_proveedor`),
  ADD KEY `FK_productos_usuario` (`id_usuario`),
  ADD KEY `FK_productos_medida` (`unidad_medida`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedores`),
  ADD UNIQUE KEY `FK_ruc` (`RUC`),
  ADD KEY `FK_proveedores_usuarios` (`id_usuario`),
  ADD KEY `FK_proveedores_distritos` (`id_distrito`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_provincias_departamentos` (`id_departamento`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`id_proyecto`) USING BTREE,
  ADD UNIQUE KEY `adwawd` (`idPerson`) USING BTREE,
  ADD UNIQUE KEY `adw` (`cod_proyecto`),
  ADD KEY `FK_proyectos_distritios` (`id_distrito`),
  ADD KEY `FK_proyectos_modulos` (`id_modulo`),
  ADD KEY `FK_proyectos_usuarios` (`id_usuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tabla_proyecto_material`
--
ALTER TABLE `tabla_proyecto_material`
  ADD PRIMARY KEY (`id_PM`);

--
-- Indices de la tabla `unidadmedida`
--
ALTER TABLE `unidadmedida`
  ADD PRIMARY KEY (`idMedida`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  MODIFY `idConvocatoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tabla_proyecto_material`
--
ALTER TABLE `tabla_proyecto_material`
  MODIFY `id_PM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `unidadmedida`
--
ALTER TABLE `unidadmedida`
  MODIFY `idMedida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `FK_detallep_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_detallep_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_detallep_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD CONSTRAINT `FK_distritos_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_distritos_provinica` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `FK_fotos_convocatoria` FOREIGN KEY (`idConv`) REFERENCES `convocatorias` (`idConvocatoria`),
  ADD CONSTRAINT `FK_fotos_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_fotos_person` FOREIGN KEY (`idPerson`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `FK_fotos_producto` FOREIGN KEY (`idProc`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `FK_fotos_proveedor` FOREIGN KEY (`idProv`) REFERENCES `proveedores` (`id_proveedores`),
  ADD CONSTRAINT `FK_fotos_proyct` FOREIGN KEY (`idProyect`) REFERENCES `proyecto` (`id_proyecto`),
  ADD CONSTRAINT `FK_fotos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `FK_persona_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_productos_medida` FOREIGN KEY (`unidad_medida`) REFERENCES `unidadmedida` (`idMedida`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_productos_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_productos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `FK_proveedores_distritos` FOREIGN KEY (`id_distrito`) REFERENCES `distritos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_proveedores_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD CONSTRAINT `FK_provincias_departamentos` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `FK_proyect_personas` FOREIGN KEY (`idPerson`) REFERENCES `personas` (`id_persona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_proyectos_distritios` FOREIGN KEY (`id_distrito`) REFERENCES `distritos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_proyectos_modulos` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_proyectos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
