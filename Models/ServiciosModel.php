<?php 

	class ServiciosModel extends Mysql
	{
		public $intIdservicio;
		public $strServicio;
		public $strDescripcion;
		public $strPrecio;
		public $intStatus;
		public $strPortada;
		public $strRuta;

		public function __construct()
		{
			parent::__construct();
		}

		public function inserServicio(string $nombre, string $descripcion, string $precio , string $portada, string $ruta, int $status){

			$return = 0;
			$this->strServicio = $nombre;
			$this->strDescripcion = $descripcion;
			$this->strPrecio = $precio;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * FROM servicio WHERE nombre = '{$this->strServicio}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO servicio(nombre,descripcion,precio,portada,ruta,status) VALUES(?,?,?,?,?,?)";
	        	$arrData = array($this->strServicio, 
								 $this->strDescripcion, 
								 $this->strPrecio, 
								 $this->strPortada,
								 $this->strRuta, 
								 $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function selectServicios()
		{
			$sql = "SELECT * FROM servicio 
					WHERE status != 0 ";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectServicio(int $idservicio){
			$this->intIdservicio = $idservicio;
			$sql = "SELECT idservicio, nombre, descripcion, precio, portada, DATE_FORMAT(datecreated, '%d-%m-%Y | %h:%i:%s %p') as datecreated, ruta, status 
					FROM servicio
					WHERE idservicio = $this->intIdservicio";
			$request = $this->select($sql);
			return $request;
		}		

		public function updateServicio(int $idservicio, string $nombre, string $descripcion, string $precio, string $portada, string $ruta, int $status){
			$this->intIdservicio = $idservicio;
			$this->strServicio = $nombre;
			$this->strDescripcion = $descripcion;
			$this->strPrecio = $precio;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * FROM servicio WHERE nombre = '{$this->strServicio}' AND idservicio != $this->intIdservicio";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE servicio SET nombre = ?, descripcion = ?, precio = ?, portada = ?, ruta = ?, status = ? WHERE idservicio = $this->intIdservicio ";
				$arrData = array($this->strServicio, 
								 $this->strDescripcion, 
								 $this->strPrecio, 
								 $this->strPortada,
								 $this->strRuta, 
								 $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteServicio(int $idservicio)
		{
			$this->intIdservicio = $idservicio;
			
				$sql = "UPDATE servicio SET status = ? WHERE idservicio = $this->intIdservicio";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			
			return $request;
		}	

		public function getCategoriasFooter(){
			$sql = "SELECT idservicio, nombre, descripcion, portada, ruta
					FROM servicio WHERE  status = 1 AND idservicio IN (".CAT_FOOTER.")";
			$request = $this->select_all($sql);
			if(count($request) > 0){
				for ($c=0; $c < count($request) ; $c++) { 
					$request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada'];		
				}
			}
			return $request;
		}


	}
 ?>