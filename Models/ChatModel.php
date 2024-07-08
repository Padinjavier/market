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
        $sql = "SELECT idpersona, identificacion, nombres, apellidos, telefono, rolid
                    FROM persona
                    WHERE idpersona != '22' 
                        AND rolid > 0 
                        AND rolid != 3
                        AND STATUS != '0'
                    ORDER BY idpersona DESC;";
        $request = $this->select_all($sql);

        return $request;
    }

}
?>