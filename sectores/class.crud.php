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
	public function dataview_sector()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM tipo_sector";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		}
	}
	//FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  

	//FUNCION PARA CREAR UN DEPARTAMENTO EN LA BD
	public function crear_sector()
	{
		try {
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$created_at = date("Y-m-d H:i:s", strtotime('now'));
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));






			$stmt_check = $this->conn->prepare("SELECT COUNT(*) FROM tipo_sector WHERE  nombre = :nombre");

			$stmt_check->bindparam(":nombre", $nombre);
			$stmt_check->execute();
			$count = $stmt_check->fetchColumn();

			if ($count > 0) {
				// Ya existe un registro con el mismo término, retornar falso
				return 1;
			}









			$stmt = $this->conn->prepare("INSERT INTO tipo_sector(nombre,descripcion,status,creacion,modificado) 
            VALUES(:nombre,:descripcion,:status,:created_at,:updated_at)");
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":descripcion", $descripcion);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":created_at", $created_at);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->execute();

			return 2;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return 3;
		}
	}
	//FIN FUNCION PARA CREAR UN DEPARTAMENTOS EN LA BD

	//FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD
	public function editar_sector()
	{
		try {

			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));



			$nombre2 = strtolower($nombre);
			$stmt_check = $this->conn->prepare("SELECT COUNT(*) FROM tipo_sector WHERE  LOWER(nombre) = :nombre AND id != :id");

			$stmt_check->bindparam(":nombre", $nombre2);
			$stmt_check->bindparam(":id", $id);
			$stmt_check->execute();
			$count = $stmt_check->fetchColumn();

			if ($count > 0) {
				// Ya existe un registro con el mismo término y diferente ID, retornar falso
				return 1;
			}

			$stmt = $this->conn->prepare("UPDATE tipo_sector SET 
            nombre=:nombre, 
            descripcion=:descripcion,  
            status=:status, 
            modificado=:updated_at
            WHERE id=:id");
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":descripcion", $descripcion);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
	public function eliminar_sector($id)
	{

		$stmt = $this->conn->prepare("DELETE FROM tipo_sector WHERE id=:id");
		$stmt->bindparam(":id", $id);
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

		if ($stmt->rowCount() > 0) {
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		}
	}
	//FIN SELECT DE CATEGORIAS

}
