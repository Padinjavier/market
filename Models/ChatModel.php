<?php

// chat_model.php

class ChatModel extends Mysql
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAvailableUsers(int $iduser)
    {
        $sql = "SELECT p.idpersona, 
                        p.identificacion, 
                        p.nombres, 
                        p.apellidos, 
                        p.telefono, 
                        p.rolid, 
                        p.conexion,
                        IFNULL(m.msg_id, null) AS msg_id, -- Si no hay msg_id, devuelve null
                        IFNULL(m.input_msg_id, null) AS input_msg_id, -- Si no hay input_msg_id, devuelve null
                        IFNULL(m.output_msg_id, null) AS output_msg_id, -- Si no hay output_msg_id, devuelve null
                        IFNULL(m.msg, '') AS msg, -- Si no hay mensaje, devuelve cadena vacía
                        IFNULL(t.unread_count, 0) AS unread_count -- Si no hay conteo de mensajes no leídos, devuelve 0
                    FROM persona p
                    LEFT JOIN (
                        -- Subconsulta 'm' para obtener los mensajes más recientes
                        SELECT m1.msg_id, m1.input_msg_id, m1.output_msg_id, m1.msg
                        FROM messages m1
                        JOIN (
                            -- Subconsulta para obtener el MAX(msg_id) por cada par de personas
                            SELECT MAX(msg_id) AS max_msg_id
                            FROM messages
                            WHERE input_msg_id ={$iduser} OR output_msg_id ={$iduser} -- Filtra por mensajes que involucren la persona con id{$iduser}
                            GROUP BY CASE 
                                    WHEN input_msg_id ={$iduser} THEN output_msg_id
                                    ELSE input_msg_id
                                END
                        ) AS max_msgs ON m1.msg_id = max_msgs.max_msg_id -- Une con el msg_id máximo obtenido
                    ) AS m ON p.idpersona = m.input_msg_id OR p.idpersona = m.output_msg_id -- Une con persona por input_msg_id u output_msg_id

                    LEFT JOIN (
                        -- Subconsulta 't' para obtener el conteo de mensajes no leídos
                        SELECT CASE 
                                WHEN input_msg_id ={$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END AS other_person_id,
                            COUNT(*) AS unread_count
                        FROM messages
                        WHERE view = 1 -- Filtra los mensajes vistos
                        AND (input_msg_id ={$iduser} OR output_msg_id ={$iduser}) -- Filtra por mensajes que involucren la persona con id{$iduser}
                        AND output_msg_id !={$iduser} -- Asegura que la persona con id{$iduser} no sea la emisora del mensaje
                        GROUP BY CASE 
                                WHEN input_msg_id ={$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END
                    ) AS t ON p.idpersona = t.other_person_id -- Une con persona por other_person_id obtenido

                    WHERE p.idpersona !={$iduser} -- Excluye la persona con id{$iduser} de los resultados
                    AND p.rolid > 0 -- Filtra por roles con id mayor que 0
                    AND p.rolid != 3 -- Excluye roles con id igual a 3
                    AND p.status != 0 -- Excluye personas con status igual a 0

                    ORDER BY IFNULL(m.msg_id, 0) DESC; -- Ordena los resultados por msg_id, con nulos tratados como 0
                    ";

        $request = $this->select_all($sql);

        return $request;
    }
    public function getMSQUsers(int $iduser, int $idpersona)
    {
        $sql = "SELECT p.nombres, 
                    p.apellidos, 
                    p.email_user, -- Suponiendo que la columna para el correo electrónico se llama 'email_user'
                    p.telefono, -- Suponiendo que la columna para el número de teléfono se llama 'telefono'
                    m.msg_id, 
                    m.input_msg_id, 
                    m.output_msg_id, 
                    m.msg
                FROM messages m 
                INNER JOIN persona p ON p.idpersona = {$idpersona}
                WHERE (m.input_msg_id = {$iduser} AND m.output_msg_id = {$idpersona}) 
                OR (m.input_msg_id = {$idpersona} AND m.output_msg_id = {$iduser})
                ORDER BY m.msg_id ASC;";

        $request = $this->select_all($sql);

        return $request;
    }

}
?>