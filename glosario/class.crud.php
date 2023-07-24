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
	public function dataview_glosario()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM glosario 
          WHERE id_empresa = " . $user['id_empresa'];
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
	public function crear_glosario()
	{
		try {
			$user = $_SESSION['user'];
			$termino = (isset($_POST['termino'])) ? $_POST['termino'] : "";
			$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$created_at = date("Y-m-d H:i:s", strtotime('now'));
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));
			$stmt = $this->conn->prepare("INSERT INTO glosario(id_empresa,termino,descripcion,status,creacion,modificado) 
        VALUES(:id_empresa,:termino,:descripcion,:status,:created_at,:updated_at)");
			$stmt->bindparam(":id_empresa", $user['id_empresa']);
			$stmt->bindparam(":termino", $termino);
			$stmt->bindparam(":descripcion", $descripcion);
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

	public function editar_glosario()
	{
		try {

			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$termino = (isset($_POST['termino'])) ? $_POST['termino'] : "";
			$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE glosario SET 
        termino=:termino, 
        descripcion=:descripcion,  
        status=:status, 
        modificado=:updated_at
        WHERE id=:id");
			$stmt->bindparam(":termino", $termino);
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

	public function eliminar_glosario($id)
	{
		$stmt = $this->conn->prepare("DELETE FROM glosario WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();

		return true;
	}

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
