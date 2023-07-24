<?php

require_once('../layouts/dbconexion_pdo.php');
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', 'SideComs*');
define('SECRET_IV', '202020');

class crud
{

	private $conn;

	public static function encryption($string)
	{
		$output = FALSE;
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}

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

	//FUNCION PARA MOSTRAR LISTADO DE USUARIOS
	public function dataview_usuarios()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM usuarios
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
	//FIN FUNCION PARA MOSTRAR LISTADO DE USUARIOS  

	//FUNCION PARA CREAR UN USUARIO EN LA BD
	public function crear_usuario()
	{
		try {
			$email = isset($_POST['email']) ? $_POST['email'] : "";

			// Verificar si el nombre de usuario ya existe
			$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email=:email");
			$stmt->execute(array(':email' => $email));
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($stmt->rowCount() == 1) {
				// Nombre de usuario ya existe
				return 1;
			} else {
				$user = $_SESSION['user'];
				$id = isset($_POST['id']) ? $_POST['id'] : "";
				$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
				$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
				$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : "";
				$status = isset($_POST['status']) ? $_POST['status'] : "";

				$password = isset($_POST['password']) ? $_POST['password'] : "";
				$password = self::encryption($password);
				$created_at = date("Y-m-d H:i:s", strtotime('now'));
				$updated_at = date("Y-m-d H:i:s", strtotime('now'));
				$id_parent = 2;
				
				$stmt = $this->conn->prepare("INSERT INTO usuarios 
				(id_empresa,nombre, apellido, idcargo, email, status, creacion, modificado, password, id_parent)
				VALUES
				(:id_empresa,:nombre, :apellido, :idcargo, :email, :status, :created_at, :updated_at, :password, :id_parent)");
				
				$stmt->bindParam(":id_empresa", $user['id_empresa']);
				$stmt->bindParam(":nombre", $nombre);
				$stmt->bindParam(":apellido", $apellido);
				$stmt->bindParam(":idcargo", $cargo);
				$stmt->bindParam(":email", $email);
				$stmt->bindParam(":status", $status);
				$stmt->bindParam(":created_at", $created_at);
				$stmt->bindParam(":updated_at", $updated_at);
				$stmt->bindParam(":password", $password);
				$stmt->bindParam(":id_parent", $id_parent);
				$stmt->execute();

				return 2;
			}
		} catch (PDOException $e) {
			throw new Exception('Error al crear el usuario: ' . $e->getMessage());
			return 0;
		}
	}

	//FIN FUNCION PARA CREAR UN USUARIOS EN LA BD

	//FUNCION PARA EDITAR UN USUARIO EN LA BD
	public function editar_usuario()
	{
		try {

			$lastemail = isset($_POST['lastemail']) ? $_POST['lastemail'] : "";
			$email = isset($_POST['email']) ? $_POST['email'] : "";

			if ($lastemail != $email) {
				// Verificar si el nombre de usuario ya existe
				$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email=:email");
				$stmt->execute(array(':email' => $email));
				if ($stmt->rowCount() == 1) {
					// Nombre de usuario ya existe
					return 1;
				}
			}

			$id = isset($_POST['id']) ? $_POST['id'] : "";
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
			$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
			$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : "";
			$status = isset($_POST['status']) ? $_POST['status'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE usuarios SET 
				nombre=:nombre,
				apellido=:apellido,
				idcargo=:idcargo,
				email=:email,
				status=:status,
				modificado=:updated_at
				WHERE id=:id");


			$stmt->bindParam(":nombre", $nombre);
			$stmt->bindParam(":apellido", $apellido);
			$stmt->bindParam(":idcargo", $cargo);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":status", $status);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return 2;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return 0;
		}
	}

	//FIN FUNCION PARA EDITAR UN USUARIO EN LA BD

	//FUNCION PARA ELIMINAR UN USUARIO DE LA BD 
	public function eliminar_usuario($id)
	{

		$stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();

		return true;
	}
	//FIN FUNCION PARA ELIMINAR UN USUARIO DE LA BD 
	public function get_cargos()
	{
		try {
			$user = $_SESSION['user'];
			$stmt = $this->conn->prepare("SELECT * FROM cargos WHERE id_empresa = ". $user['id_empresa']);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
}
