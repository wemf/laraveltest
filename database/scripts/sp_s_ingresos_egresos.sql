CREATE DEFINER=`bd_nutibara`@`%` PROCEDURE `sp_s_ingresos_egresos`(
IN in_id_cierre INTEGER, 
IN in_id_tienda_cierre INTEGER
)
BEGIN

	DROP table IF EXISTS arqueo;
	CREATE TEMPORARY TABLE arqueo (nombre VARCHAR(20), tipo INT(11));
    
    INSERT INTO arqueo 
	SELECT "ingresos",CASE WHEN ROUND(SUM(dmc.valor),2) IS NULL THEN 0 ELSE ROUND(SUM(dmc.valor),2) END AS ingresos
	FROM tbl_tes_movimientos_cierre_caja mc
	INNER JOIN tbl_tes_detalle_movimientos_cierre_caja  dmc ON  dmc.id_movimiento = mc.id_movimiento AND dmc.id_tienda_movimiento = mc.id_tienda_movimiento
	INNER JOIN tbl_tes_subclases_cierre_caja sub ON sub.id_subclases = mc.id_subclase
	INNER JOIN tbl_tes_clases_cierre_caja cla ON cla.id_clases = sub.id_clases 
	WHERE id_cierre = in_id_cierre AND id_tienda_cierre = in_id_tienda_cierre AND cla.id_clases IN (1,2,3,4,5,6,7,8);
    
	INSERT INTO arqueo 
    SELECT "egresos",CASE WHEN ROUND(SUM(dmc.valor),2) IS NULL THEN 0 ELSE ROUND(SUM(dmc.valor),2) END AS egresos
	FROM tbl_tes_movimientos_cierre_caja mc
	INNER JOIN tbl_tes_detalle_movimientos_cierre_caja  dmc ON  dmc.id_movimiento = mc.id_movimiento AND dmc.id_tienda_movimiento = mc.id_tienda_movimiento
	INNER JOIN tbl_tes_subclases_cierre_caja sub ON sub.id_subclases = mc.id_subclase
	INNER JOIN tbl_tes_clases_cierre_caja cla ON cla.id_clases = sub.id_clases 
	WHERE id_cierre = in_id_cierre AND id_tienda_cierre = in_id_tienda_cierre AND cla.id_clases IN (9,10,11,12,13,14,15,16);
    
SELECT 
    nombre,
    FORMAT(tipo,(SELECT decimales FROM tbl_parametro_general LIMIT 1), 'de_DE') AS tipo
FROM
    arqueo;
END