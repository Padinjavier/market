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
                        p.time_conexion,
                        COALESCE(m.msg_id, NULL) AS msg_id, 
                        COALESCE(m.input_msg_id, NULL) AS input_msg_id, 
                        COALESCE(m.output_msg_id, NULL) AS output_msg_id, 
                        COALESCE(m.msg, '') AS msg, 
                        COALESCE(t.unread_count, 0) AS unread_count
                    FROM persona p
                    LEFT JOIN (
                        -- Subconsulta para obtener los mensajes más recientes por cada par de personas
                        SELECT m1.msg_id, m1.input_msg_id, m1.output_msg_id, m1.msg
                        FROM messages m1
                        INNER JOIN (
                            SELECT MAX(msg_id) AS max_msg_id
                            FROM messages
                            WHERE input_msg_id = {$iduser} OR output_msg_id = {$iduser}
                            GROUP BY CASE 
                                    WHEN input_msg_id = {$iduser} THEN output_msg_id
                                    ELSE input_msg_id
                                END
                        ) AS max_msgs ON m1.msg_id = max_msgs.max_msg_id
                    ) AS m ON p.idpersona = m.input_msg_id OR p.idpersona = m.output_msg_id
                    LEFT JOIN (
                        -- Subconsulta para contar los mensajes no vistos enviados a la persona con id {$iduser}
                        SELECT 
                            CASE 
                                WHEN input_msg_id = {$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END AS other_person_id,
                            COUNT(*) AS unread_count
                        FROM messages
                        WHERE view = 0 -- Mensajes no leídos
                        AND output_msg_id = {$iduser} -- Solo cuenta los mensajes enviados a la persona con id {$iduser}
                        GROUP BY CASE 
                                WHEN input_msg_id = {$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END
                    ) AS t ON p.idpersona = t.other_person_id
                    WHERE p.idpersona != {$iduser} -- Excluye la persona con id {$iduser}
                    AND p.rolid > 0 -- Filtra por roles con id mayor que 0
                    AND p.rolid != 3 -- Excluye roles con id igual a 3
                    AND p.status != 0 -- Excluye personas con status igual a 0
                    ORDER BY COALESCE(m.msg_id, 0) DESC;
                    ";

        $request = $this->select_all($sql);

        return $request;
    }
    public function getMSQUsers(int $iduser, int $idpersona)
    {
        $sql = "SELECT p.nombres, 
                        p.apellidos, 
                        p.email_user, 
                        p.telefono, 
                        m.msg_id, 
                        m.input_msg_id, 
                        m.output_msg_id, 
                        m.msg
                    FROM persona p
                    LEFT JOIN messages m ON (m.input_msg_id = {$idpersona} AND m.output_msg_id = {$iduser})
                                        OR (m.input_msg_id = {$iduser} AND m.output_msg_id = {$idpersona})
                    WHERE p.idpersona = {$idpersona} ORDER BY m.msg_id ASC;";

        $request = $this->select_all($sql);

        return $request;
    }

}
?>