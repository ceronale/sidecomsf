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

	public function get_countries()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM paises ORDER BY nombre ASC");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_empresa($id)
	{
		try {
			$stmt = $this->conn->prepare("SELECT empresas.*, paises.moneda AS moneda_pais, paises.codigotelefonico AS codigo_telefonico
				FROM empresas
				INNER JOIN paises ON empresas.id_pais = paises.id
				WHERE empresas.id = :id_empresa");
			$stmt->bindParam(':id_empresa', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($result) {
				return $result;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_nivel()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM tipo_escala_trabajadores_copy ");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_acitvity()
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

	public function get_products()
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
	public function get_sector()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_sector`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_tipo_empresa()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_empresa`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_tipo_sector_empresa()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_sector_empresa`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}


	public function get_tipo_frecuencia_salarial()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_frecuencia_salarial`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_escala_administrativo()
	{
		try {
			$stmt = $this->conn->prepare("SELECT tipo_empresa, GROUP_CONCAT(CONCAT(grado, '  (', minimo, ' - ', maximo,')') SEPARATOR ',') AS descripcion 
					FROM tipo_escala_empresarial 
					WHERE categoria = 1 
					GROUP BY tipo_empresa 
					ORDER BY CAST(tipo_empresa AS UNSIGNED) ASC;
					");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_escala_planta()
	{
		try {
			$stmt = $this->conn->prepare("SELECT tipo_empresa, GROUP_CONCAT(CONCAT(grado, '  (', minimo, ' - ', maximo,')') ORDER BY grado ASC SEPARATOR ',') AS descripcion 
FROM tipo_escala_empresarial 
WHERE categoria = 2 
GROUP BY tipo_empresa 
ORDER BY tipo_empresa ASC;");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function changeEscala(
		$escala_administrativo,
		$escala_planta
	) {

		try {
			$user = $_SESSION['user'];
			$id_empresa = $user['id_empresa'];


			$stmt = $this->conn->prepare(
				"UPDATE empresas SET
					id_escala_administrativo = :id_escala_administrativo,
					id_escala_planta = :id_escala_planta
            WHERE id = :id_empresa"
			);

			$stmt->bindParam(':id_escala_administrativo', $escala_administrativo);
			$stmt->bindParam(':id_escala_planta', $escala_planta);
			$stmt->bindParam(':id_empresa', $id_empresa);
			$stmt->execute();


			$stmt2 = $this->conn->prepare("
			UPDATE cargos
			JOIN empresas ON cargos.id_empresa = empresas.id
			JOIN tipo_escala_empresarial ON empresas.id_escala_administrativo = tipo_escala_empresarial.tipo_empresa
			SET cargos.grado = tipo_escala_empresarial.grado
			WHERE cargos.id_empresa = :id_empresa AND cargos.puntaje BETWEEN tipo_escala_empresarial.minimo AND tipo_escala_empresarial.maximo AND cargos.categoria = 1;
			");
			$stmt2->bindParam(':id_empresa', $id_empresa);
			$stmt2->execute();

			$stmt3 = $this->conn->prepare("
			UPDATE cargos
			JOIN empresas ON cargos.id_empresa = empresas.id
			JOIN tipo_escala_empresarial ON empresas.id_escala_planta = tipo_escala_empresarial.tipo_empresa
			SET cargos.grado = tipo_escala_empresarial.grado
			WHERE cargos.id_empresa = :id_empresa AND cargos.puntaje BETWEEN tipo_escala_empresarial.minimo AND tipo_escala_empresarial.maximo AND cargos.categoria = 2;
			");
			$stmt3->bindParam(':id_empresa', $id_empresa);
			$stmt3->execute();

			return 2; // Registro exitoso

		} catch (PDOException $e) {
			throw new Exception('Error al crear el cargo: ' . $e->getMessage());

			return 0; // Error desconocido
		}
	}
}
