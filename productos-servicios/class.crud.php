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
	public function dataview_producto()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `productos_servicios` ORDER BY nombre ASC");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	//FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  

	//FUNCION PARA CREAR UN DEPARTAMENTO EN LA BD
	public function crear_producto()
	{
		try {
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";


			$stmt = $this->conn->prepare("INSERT INTO productos_servicios(nombre,status) 
			VALUES(:nombre,:status)");
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":status", $status);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	//FIN FUNCION PARA CREAR UN DEPARTAMENTOS EN LA BD

	//FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD
	public function editar_producto()
	{
		try {
			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";


			$stmt = $this->conn->prepare("UPDATE productos_servicios SET nombre=:nombre, status=:status WHERE id=:id");
			$stmt->bindParam(":nombre", $nombre);
			$stmt->bindParam(":status", $status);
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			throw $e;
			echo $e->getMessage();
			return false;
		}
	}
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
	public function eliminar_producto($id)
	{
		try {
			$stmt = $this->conn->prepare("DELETE FROM productos_servicios WHERE id=:id");
			$stmt->bindparam(":id", $id);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
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
