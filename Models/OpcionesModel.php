<?php
class OpcionesModel extends Mysql
{

    private $intIdPagina;
    private $intIdioma;
    private $intTema;
    private $intMoneda;


    public function __construct()
    {
        parent::__construct();
    }

    public function selectOpciones(int $idpersona)
    {
        $sql = "SELECT * FROM opciones
                WHERE personaid =" . $idpersona;
        $request = $this->select_all($sql);
        return $request;
    }

    public function updateOpciones(int $idpersona, int $intIdioma, int $intTema, int $intMoneda)
    {
        $this->intIdPagina = $idpersona;
        $this->intIdioma = $intIdioma;
        $this->intTema = $intTema;
        $this->intMoneda = $intMoneda;

        $sql = "UPDATE opciones 
            SET idioma = ?, tema = ?, formato_moneda = ?
            WHERE personaid = ?";

        $arrData = array($this->intIdioma, $this->intTema, $this->intMoneda, $this->intIdPagina);

        $request = $this->update($sql, $arrData);
        return $request;
    }

}
