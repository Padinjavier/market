<?php

// chat_model.php

class ChatModel extends Mysql
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAvailableUsers()
    {
        $outgoing_id = 22; // Tu ID de usuario

        $sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono, p.rolid, 
                       m.msg, m.msg_id, m.input_msg_id, m.output_msg_id
                FROM persona p
                LEFT JOIN messages m ON p.idpersona = m.input_msg_id OR p.idpersona = m.output_msg_id
                INNER JOIN (
                    SELECT MAX(msg_id) AS max_msg_id, 
                           CASE 
                               WHEN input_msg_id = {$outgoing_id} THEN output_msg_id
                               ELSE input_msg_id
                           END AS other_person_id
                    FROM messages
                    WHERE input_msg_id = {$outgoing_id} OR output_msg_id = {$outgoing_id}
                    GROUP BY CASE 
                               WHEN input_msg_id = {$outgoing_id} THEN output_msg_id
                               ELSE input_msg_id
                           END
                ) AS max_msgs ON (m.msg_id = max_msgs.max_msg_id)
                WHERE p.idpersona != {$outgoing_id}
                  AND p.rolid > 0 
                  AND p.rolid != 3
                  AND p.status != 0
                ORDER BY m.msg_id DESC";

        $request = $this->select_all($sql);

        return $request;
    }

}
?>
