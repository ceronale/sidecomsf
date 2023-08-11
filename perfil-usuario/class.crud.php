<?php

require_once('../layouts/dbconexion_pdo.php');
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', 'SideComs*');
define('SECRET_IV', '202020');

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

	public static function encryption($string)
	{
		$output = FALSE;
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}

	public static function decryption($string)
	{
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
		return $output;
	}


	public function updateUser(
		$email,
		$nombre,
		$apellido,
		$passwordx,
		$id_usuario
	) {
		try {
			$stmt = $this->conn->prepare(
				"UPDATE usuarios SET
						nombre = :nombre,
						email = :email,
						apellido = :apellido,
						password = :passwordx
            	  		WHERE id = :id_usuario"
			);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':apellido', $apellido);
			$stmt->bindParam(':passwordx', $passwordx);
			$stmt->bindParam(':id_usuario', $id_usuario);
			$stmt->execute();
			return 2; // Registro exitoso

		} catch (PDOException $e) {
			throw new Exception('Error al crear el cargo: ' . $e->getMessage());

			return 0; // Error desconocido
		}
	}
	public function doLogin($uname, $upass)
	{
		try {
			$stmt2 = $this->conn->prepare("SELECT * FROM usuarios WHERE email=:uname");
			$stmt2->execute(array(':uname' => $uname));
			$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

			if ($stmt2->rowCount() == 1) {

				$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email=:uname and password=:upass");
				$stmt->execute(array(':uname' => $uname, ':upass' => $upass));
				//$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($stmt->rowCount() == 1) {
					$_SESSION['user_session'] = $userRow['id'];
					$_SESSION['user'] = $userRow;


					// Usuario y contraseña válidossss
					return 1;
				} else {

					// Contraseña incorrecta
					return 2;
				}

				// if ($stmt->rowCount() == 1) {
				// 	$_SESSION['user_session'] = $userRow['id_usuario'];
				// 	$_SESSION['user_type'] = $userRow['id_tipo_usuario'];
				// 	$operador = $_SESSION['user_session'];
				// 	extract($this->getID($operador));
				// 	$operacion = "Inicio de sesión del usuario: " . $operador;
				// 	$ip = $_SERVER['REMOTE_ADDR'];
				// 	$this->log_operaciones($operador, $operacion, $usuario, $ip);

				// 	return $_SESSION['user_type'];
				// } else {
				// 	return 0;
				// }


			} else {
				// Nombre de usuario no encontrado
				return 3;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return 0;
		}
	}
}
