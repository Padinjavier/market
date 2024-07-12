<?php 
class LogoutModel extends Mysql {
    public function __construct() {
        parent::__construct();
    }

    public function cerrarconeccionuser(int $iduser) {
        $sql = "UPDATE persona SET conexion = 0 WHERE idpersona = ?";
        $arrValues = array($iduser); // Array de valores para el marcador de posición
    
        $update = $this->update($sql, $arrValues);
    
        return $update; // Puedes retornar el resultado de la actualización si es necesario
    }
}
?>
