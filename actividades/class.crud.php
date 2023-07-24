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
	public function dataview_activdades()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_sector_empresa` ORDER BY nombre ASC");
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
	public function crear_actividad()
	{
		try {
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$created_at = date("Y-m-d H:i:s", strtotime('now'));
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("INSERT INTO tipo_sector_empresa(nombre,status,creacion,modificado) 
			VALUES(:nombre,:status,:created_at,:updated_at)");
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":created_at", $created_at);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	//FIN FUNCION PARA CREAR UN DEPARTAMENTOS EN LA BD

	//FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD
	public function editar_actividad()
	{
		try {
			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE tipo_sector_empresa SET 
			nombre=:nombre, 
			status=:status, 
			modificado=:updated_at
			WHERE id=:id");
			$stmt->bindparam(":nombre", $nombre);
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
	public function eliminar_actividad()
	{
		try {
			$id = (isset($_POST['id'])) ? $_POST['id'] : "";

			$stmt = $this->conn->prepare("DELETE FROM tipo_sector_empresa WHERE id=:id");
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
