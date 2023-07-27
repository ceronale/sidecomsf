<?php

require_once('../layouts/dbconexion_pdo.php');

class crud
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS
    public function dataview_departamentos($categoria)
    {
		$user = $_SESSION['user'];
		$query = "SELECT d.*, tc.categoria as nombre_categoria, d.categoria as id_categoria FROM departamentos d
		INNER JOIN tipo_categoria tc
		ON d.categoria = tc.id
		WHERE id_empresa = ". $user['id_empresa'] ."
		AND d.categoria = " . $categoria;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
		if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  

	//FUNCION PARA CREAR UN DEPARTAMENTO EN LA BD
	public function crear_departamento()
	{
		try
		{
			$user = $_SESSION['user'];
			$nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";  
			$categoria = (isset($_POST['categoria']))?$_POST['categoria']:"";  

			$nombre2 =  strtolower($nombre); 
			$stmt2 = $this->conn->prepare("SELECT * FROM departamentos WHERE LOWER(nombre)=:nombre AND id_empresa =:id_empresa AND categoria= :categoria");
			$stmt2->execute(array(':nombre' => $nombre2,':categoria' => $categoria,':id_empresa' => $user['id_empresa']));
			$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

			if ($stmt2->rowCount() == 0) {
			
	
			
			$status = "1";
            $created_at= date("Y-m-d H:i:s", strtotime('now'));
            $updated_at = date("Y-m-d H:i:s", strtotime('now'));     
			$stmt = $this->conn->prepare("INSERT INTO departamentos(id_empresa,nombre,categoria,status,creacion,modificado) 
				VALUES(:id_empresa,:nombre,:categoria,:status,:created_at,:updated_at)");
			$stmt->bindparam(":id_empresa",$user['id_empresa']);
			$stmt->bindparam(":nombre",$nombre);
			$stmt->bindparam(":categoria",$categoria);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":created_at",$created_at);
			$stmt->bindparam(":updated_at",$updated_at);
			$stmt->execute();

			return 2;
			}
			else
			{
				return 1;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	//FIN FUNCION PARA CREAR UN DEPARTAMENTOS EN LA BD

	//FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD
    public function editar_departamento()
	{
		try
		{
			$user = $_SESSION['user'];
			$nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";  

			$nombreold = (isset($_POST['nombreold']))?$_POST['nombreold']:"";  

			if(strtolower($nombre) != strtolower($nombreold))
			{
				$nombre2 =  strtolower($nombre); 
				$stmt2 = $this->conn->prepare("SELECT * FROM departamentos WHERE LOWER(nombre)=:nombre AND id_empresa =:id_empresa AND categoria= :categoria");
				$stmt2->execute(array(':nombre' => $nombre2,':categoria' => $categoria,':id_empresa' => $user['id_empresa']));
				$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);
	
				if ($stmt2->rowCount() == 0) {
					$id = (isset($_POST['id']))?$_POST['id']:""; 
 
					$status = (isset($_POST['status']))?$_POST['status']:"";    
					$updated_at = date("Y-m-d H:i:s", strtotime('now'));
		
					$stmt=$this->conn->prepare("UPDATE departamentos SET 
						nombre=:nombre, 
						status=:status, 
						modificado=:updated_at
						WHERE id=:id");
					$stmt->bindparam(":nombre",$nombre);
					$stmt->bindparam(":status",$status);
					$stmt->bindparam(":updated_at",$updated_at);
					$stmt->bindparam(":id",$id);
					$stmt->execute();
		
					return 2;
				}
				else
				{
					return 1;
				}
			}
			else
			{
					$id = (isset($_POST['id']))?$_POST['id']:""; 
					$status = (isset($_POST['status']))?$_POST['status']:"";    
					$updated_at = date("Y-m-d H:i:s", strtotime('now'));
		
					$stmt=$this->conn->prepare("UPDATE departamentos SET 
						nombre=:nombre, 
						status=:status, 
						modificado=:updated_at
						WHERE id=:id");
					$stmt->bindparam(":nombre",$nombre);
					$stmt->bindparam(":status",$status);
					$stmt->bindparam(":updated_at",$updated_at);
					$stmt->bindparam(":id",$id);
					$stmt->execute();
		
					return true;
			}
		
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
    public function eliminar_departamento($id)
	{  
  	
            $stmt = $this->conn->prepare("DELETE FROM departamentos WHERE id=:id");
			$stmt->bindparam(":id",$id);
			$stmt->execute();

			return true;
	}
	//FIN FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 

	//SELECT DE CATEGORIAS 
	public function getcategorias()
	{
		$query = "SELECT * FROM tipo_categoria";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
		
	}
	//FIN SELECT DE CATEGORIAS

}
?>