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


	public function doRegister($uname, $upass, $firstname, $lastname, $email)
	{
		try {
			// Verificar si el nombre de usuario ya existe
			$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email=:uname");
			$stmt->execute(array(':uname' => $uname));
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($stmt->rowCount() == 1) {
				// Nombre de usuario ya existe
				return 1;
			} else {
				// Insertar los datos en la tabla usuarios
				$stmt2 = $this->conn->prepare("INSERT INTO usuarios ( nombre, apellido, email, password ) VALUES ( :firstname, :lastname, :email, :upass)");

				$stmt2->bindParam(':firstname', $firstname);
				$stmt2->bindParam(':lastname', $lastname);
				$stmt2->bindParam(':email', $email);
				$stmt2->bindParam(':upass', $upass);
				$stmt2->execute();

				// Obtener el ID generado automáticamente
				$id = $this->conn->lastInsertId();

				// Actualizar el campo "idparent" con el ID generado
				$stmt3 = $this->conn->prepare("UPDATE usuarios SET id_parent = :id WHERE id = :id");
				$stmt3->bindParam(':id', $id);
				$stmt3->execute();

				// Actualizar el campo "idparent" con el ID generado
				$stmt3 = $this->conn->prepare("INSERT INTO permisos(id_usuario,p_usuarios,
				p_departamentos,
				p_departamentos_adm,
				p_departamentos_taller,
				p_cargos,
				p_cargos_adm,
				p_cargos_taller,
				p_descripcion,
				p_descripcion_adm,
				p_descripcion_taller,
				p_escalas,
				p_valoracion,
				p_valoracion_adm,
				p_valoracion_taller,
				p_matrices,
				p_nomina,
				p_jerarquizacion,
				p_resultados,
				p_beneficios,
				p_tablas,
				p_links,
				p_glosario,
				p_perfiles,
				p_perfil_organizacion,
				p_perfil_usuario,
				p_view_links,
				p_view_glosario) 
				VALUES('". $id . "','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1')");
				$stmt3->execute();



				return 2; // Registro exitoso
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return 0; // Error desconocido
		}
	}
}
