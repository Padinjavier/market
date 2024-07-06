<?php

class TicketModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function seleccionarDatos($cod_venta)
    {
        $sql = "SELECT v.codigo_venta AS venta_codigo,
                        v.idvendedor AS caja_numero,
                        p.nombres AS usuario_nombre, 
                        p.apellidos AS usuario_apellido,
                        p_cliente.idpersona AS cliente_id, 
                        v.dni_cliente AS cliente_numero_documento, 
                        p_cliente.nombres AS cliente_nombre, 
                        p_cliente.apellidos AS cliente_apellido, 
                        p_cliente.telefono AS cliente_telefono,
                        p_cliente.email_user AS cliente_email,
                        p_cliente.hotel AS cliente_hotel,
                        v.idtipopago, 
                        v.total AS venta_total, 
                        tp.tipopago,
                        dv.iddetalleventa, 
                        s.nombre AS nombre_servicio, 
                        dv.cantidad, 
                        dv.precio, 
                        dv.descuento,
                        DATE_FORMAT(v.datecreated, '%Y-%m-%d') AS venta_fecha,
                        DATE_FORMAT(v.datecreated, '%H:%i:%s') AS venta_hora
                    FROM 
                        venta v
                    LEFT JOIN 
                        persona p ON v.idvendedor = p.idpersona
                    LEFT JOIN 
                        persona p_cliente ON v.dni_cliente = p_cliente.identificacion
                    LEFT JOIN 
                        tipopago tp ON v.idtipopago = tp.idtipopago
                    LEFT JOIN 
                        detalle_venta dv ON v.codigo_venta = dv.codigo_venta
                    LEFT JOIN 
                        servicio s ON dv.idservicio = s.idservicio
                    WHERE 
                        v.codigo_venta = '$cod_venta'";
        
        $result = $this->select($sql);
        return $result;
    }
    public function seleccionarDetalleDatos($venta_codigo)
    {
        $sql = "SELECT dv.iddetalleventa AS venta_detalle_id,
                   s.nombre AS venta_detalle_descripcion,
                   dv.cantidad AS venta_detalle_cantidad,
                   dv.precio AS venta_detalle_precio_venta,
                   (dv.cantidad * dv.precio) AS venta_detalle_total
            FROM detalle_venta dv
            LEFT JOIN servicio s ON dv.idservicio = s.idservicio
            WHERE dv.codigo_venta = '$venta_codigo'";
        $result = $this->select_all($sql); // Utiliza select_all para obtener todos los resultados

        return $result;
    }

    
}
?>
