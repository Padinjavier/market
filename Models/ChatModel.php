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
                        m.msg_id, 
                        m.input_msg_id, 
                        m.output_msg_id, 
                        m.msg,
                        IFNULL(t.unread_count, 0) AS unread_count
                    FROM persona p
                    LEFT JOIN messages m ON p.idpersona = m.input_msg_id OR p.idpersona = m.output_msg_id
                    INNER JOIN (
                        SELECT MAX(msg_id) AS max_msg_id, 
                            CASE 
                                WHEN input_msg_id = {$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END AS other_person_id
                        FROM messages
                        WHERE input_msg_id = {$iduser} OR output_msg_id = {$iduser}
                        GROUP BY CASE 
                                WHEN input_msg_id = {$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END
                    ) AS max_msgs ON (m.msg_id = max_msgs.max_msg_id)
                    LEFT JOIN (
                        SELECT 
                            CASE 
                                WHEN input_msg_id = {$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END AS other_person_id,
                            COUNT(*) AS unread_count
                        FROM messages
                        WHERE view = 1
                        AND (input_msg_id = {$iduser} OR output_msg_id = {$iduser})
                        AND output_msg_id != {$iduser}
                        GROUP BY CASE 
                                WHEN input_msg_id = {$iduser} THEN output_msg_id
                                ELSE input_msg_id
                            END
                    ) AS t ON p.idpersona = t.other_person_id
                    WHERE p.idpersona != {$iduser}
                    AND p.rolid > 0 
                    AND p.rolid != 3
                    AND p.status != 0
                    ORDER BY m.msg_id DESC;
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