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
    public function dataview_resultados($categoria)
    {
		$user = $_SESSION['user'];
		$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
		mn.sueldo_base as sueldobase,  
		ROUND((mn.sueldo_base) - (SELECT MIN(mn.sueldo_base) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2)  as realvsminimo,
		
		ROUND((mn.sueldo_base) - (SELECT AVG(mn.sueldo_base) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmedio,
		
		ROUND((mn.sueldo_base) - (SELECT MAX(mn.sueldo_base) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmaximo,
		
		mn.paqueteanual as paqueteanual, 
		
		ROUND((mn.paqueteanual) - (SELECT MIN(mn.paqueteanual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsminimoanual,
		
		ROUND((mn.paqueteanual) - (SELECT AVG(mn.paqueteanual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmedioanual,
		
		ROUND((mn.paqueteanual) - (SELECT MAX(mn.paqueteanual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmaximoanual
		
		
		FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."
		GROUP BY c.grado ,mn.id, c.categoria
		order by c.grado";
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

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS
    public function dataview_escalas($categoria)
    {
		$user = $_SESSION['user'];
		$id_escala = "";
		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {

		
			if($categoria == 1)
			{
				$id_escala = $userRow['id_escala_administrativo'];
			}
			if($categoria == 2)
			{
				$id_escala = $userRow['id_escala_planta'];
			}

		$query = "SELECT grado, minimo, maximo FROM tipo_escala_empresarial 
		WHERE categoria = ". $categoria. "
		AND tipo_empresa = " . $id_escala;
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
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  
	
	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function dataview_departamentos($id_categoria)
    {
		$user = $_SESSION['user'];
		$query = "SELECT id, nombre FROM departamentos 
		WHERE categoria = ". $id_categoria. "
		AND id_empresa = " . $user['id_empresa'];
		
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
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function dataview_cargos($id_departamento)
    {
		$query = "SELECT id, nombre FROM cargos WHERE id_departamento = ". $id_departamento;
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
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT


	//BUSCAR CANTIDAD MAXIMA DE UN PRODUCTO EN UNA DISTRIBUCION
	public function get_datos_cargo($id_cargo)
	{
		$stmt = $this->conn->prepare("SELECT descripcion, 
		grado, 
		puntaje 
		FROM cargos 
		WHERE id =:id_cargo");
		$stmt->bindparam(":id_cargo",$id_cargo);
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR CANTIDAD MAXIMA DE UN PRODUCTO EN UNA DISTRIBUCION


	//FUNCION PARA MOSTRAR GRAFICO ADMIN
    public function dataview_admin()
    {

		$user = $_SESSION['user'];

		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala_administrativo = $userRow['id_escala_administrativo'];


			$query = "SELECT c.grado as grado, min_max.min as minimo, min_max.max as maximo,
			ROUND(AVG(c.puntaje),2) as promediopuntaje, 
			ROUND(AVG(mn.sueldo_base),2) as promediosueldobase, 
			ROUND(AVG(mn.sueldomensual),2) as promediosueldomensual, 
			ROUND(AVG(mn.paqueteanual),2) as promediopaqueteanual,
			ROUND(AVG(mn.factor),2) as promediofactor
			FROM matriz_nomina mn 
			INNER JOIN cargos c ON mn.id_cargo = c.id
			INNER JOIN empresas e ON c.id_empresa = e.id 
			INNER JOIN (
				SELECT tee.grado, tee.minimo as min, tee.maximo as max
				FROM tipo_escala_empresarial tee
				WHERE tipo_empresa = ". $id_escala_administrativo ."
				GROUP BY tee.grado
			) min_max ON c.grado COLLATE utf8_general_ci  = min_max.grado COLLATE utf8_general_ci
			where e.id = ". $user['id_empresa'] ."
			and c.categoria = 1
			GROUP BY c.grado, min_max.min, min_max.max
			order by c.grado asc";
			
			}

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
	//FIN FUNCION PARA MOSTRAR GRAFICO ADMIN

	//FUNCION PARA MOSTRAR GRAFICO TALLER
    public function dataview_taller()
    {

		$user = $_SESSION['user'];

		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala_planta = $userRow['id_escala_planta'];


			$query = "SELECT c.grado as grado, min_max.min as minimo, min_max.max as maximo,
			AVG(c.puntaje) as promediopuntaje, 
			AVG(mn.sueldo_base) as promediosueldobase, 
			AVG(mn.sueldomensual) as promediosueldomensual, 
			AVG(mn.paqueteanual) as promediopaqueteanual,
			AVG(mn.factor) as promediofactor
			FROM matriz_nomina mn 
			INNER JOIN cargos c ON mn.id_cargo = c.id
			INNER JOIN empresas e ON c.id_empresa = e.id 
			INNER JOIN (
				SELECT tee.grado, tee.minimo as min, tee.maximo as max
				FROM tipo_escala_empresarial tee
				WHERE tipo_empresa = ". $id_escala_planta ."
				GROUP BY tee.grado
			) min_max ON c.grado COLLATE utf8_general_ci  = min_max.grado COLLATE utf8_general_ci
			where e.id = ". $user['id_empresa'] ."
			and c.categoria = 2
			GROUP BY c.grado, min_max.min, min_max.max
			order by c.grado asc";
			
			}

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
	//FIN FUNCION PARA MOSTRAR GRAFICO TALLER

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function mostrar_grafico_adm($categoria, $asignacion)
    {

		$user = $_SESSION['user'];

		if($asignacion == 1)
		{
			$campo = "mn.sueldo_base";
		}
		if($asignacion == 2)
		{
			$campo = "mn.sueldomensual";
		}
		if($asignacion == 3)
		{
			$campo = "mn.paqueteanual";
		}

			

		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala_administrativo = $userRow['id_escala_administrativo'];


			$query = "SELECT (MIN(".$campo.") - (MIN(".$campo.") * 0.20)) as sueldominimo,
			MIN(".$campo.") as sminimo,
			e.id_escala_administrativo as tipoempresa"; 

			if($id_escala_administrativo >= 2)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 1) as promediosueldogradoII";
			}

			if($id_escala_administrativo >= 3)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 1) as promediosueldogradoIII";
			}

			if($id_escala_administrativo >= 4)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 1) as promediosueldogradoIV";
			}

			if($id_escala_administrativo >= 5)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 1) as promediosueldogradoV";
			}

			if($id_escala_administrativo >= 6)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 1) as promediosueldogradoVI";
			}

			if($id_escala_administrativo >= 7)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 1) as promediosueldogradoVII";
			}

			if($id_escala_administrativo >= 8)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VIII' AND c.categoria = 1) as promediosueldogradoVIII";
			}

			if($id_escala_administrativo >= 9)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IX' AND c.categoria = 1) as promediosueldogradoIX";
			}

			if($id_escala_administrativo >= 10)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'X' AND c.categoria = 1) as promediosueldogradoX";
			}

			if($id_escala_administrativo >= 11)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XI' AND c.categoria = 1) as promediosueldogradoXI";
			}

			if($id_escala_administrativo >= 12)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XII' AND c.categoria = 1) as promediosueldogradoXII";
			}

			if($id_escala_administrativo >= 13)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIII' AND c.categoria = 1) as promediosueldogradoXIII";
			}

			if($id_escala_administrativo >= 14)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIV' AND c.categoria = 1) as promediosueldogradoXIV";
			}

			if($id_escala_administrativo >= 15)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XV' AND c.categoria = 1) as promediosueldogradoXV";
			}


			$query = $query . " FROM matriz_nomina mn
			INNER JOIN cargos c ON mn.id_cargo = c.id
			INNER JOIN empresas e ON e.id = c.id_empresa
			WHERE c.categoria = ".$categoria."
			and c.id_empresa = ".$user['id_empresa'];
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
       
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function mostrar_grafico_taller($categoria, $asignacion)
    {

		$user = $_SESSION['user'];

		if($asignacion == 1)
		{
			$campo = "mn.sueldo_base";
		}
		if($asignacion == 2)
		{
			$campo = "mn.sueldomensual";
		}
		if($asignacion == 3)
		{
			$campo = "mn.paqueteanual";
		}

			
		
		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala_planta = $userRow['id_escala_planta'];


			$query = "SELECT (MIN(".$campo.") - (MIN(".$campo.") * 0.20)) as sueldominimo,
			MIN(".$campo.") as sminimo,
			e.id_escala_planta as tipoempresa";

			if($id_escala_planta >= 2)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 2) as promediosueldogradoII";
			}

			if($id_escala_planta >= 3)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 2) as promediosueldogradoIII";
			}

			if($id_escala_planta >= 4)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 2) as promediosueldogradoIV";
			}

			if($id_escala_planta >= 5)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 2) as promediosueldogradoV";
			}

			if($id_escala_planta >= 6)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 2) as promediosueldogradoVI";
			}

			if($id_escala_planta >= 7)
			{
				$query = $query . ",
				(SELECT AVG(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 2) as promediosueldogradoVII";
			}

			$query = $query . " FROM matriz_nomina mn
			INNER JOIN cargos c ON mn.id_cargo = c.id
			INNER JOIN empresas e ON e.id = c.id_empresa
			WHERE c.categoria = 2
			and c.id_empresa = ".$user['id_empresa'];
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

		

       
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT


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

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
    public function get_nombre_moneda()
	{
		$user = $_SESSION['user'];
		extract($this->get_datos_empresa($user['id_empresa']));	

		$stmt = $this->conn->prepare("SELECT * FROM paises WHERE id=:id_pais");
		$stmt->execute(array(":id_pais"=>$id_pais));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
    public function get_datos_empresa($id_empresa)
	{
		$stmt = $this->conn->prepare("SELECT *, nombre as nombre_empresa FROM empresas WHERE id=:id_empresa");
		$stmt->execute(array(":id_empresa"=>$id_empresa));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
    public function get_sum_empleados($categoria)
	{
		$user = $_SESSION['user'];
		$stmt = $this->conn->prepare("SELECT COUNT(*) as conteo
		FROM matriz_nomina mn 
		INNER JOIN cargos c ON c.id = mn.id_cargo
		WHERE categoria=:categoria
		AND mn.id_empresa = " . $user['id_empresa']);
		$stmt->execute(array(":categoria"=>$categoria));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	public function get_nivel_empresarial($nivel_empresarial)
	{
		$stmt = $this->conn->prepare("SELECT nombre as nombre_nivel, minimo as minimo_nivel, maximo as maximo_nivel
		FROM tipo_escala_trabajadores
		WHERE id=:nivel_empresarial");
		$stmt->execute(array(":nivel_empresarial"=>$nivel_empresarial));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	public function get_calculosminperpasos($id_empresa)
	{
		$stmt = $this->conn->prepare("SELECT *
		FROM matriz_jerarquizacion
		WHERE id_empresa=:id_empresa");
		$stmt->execute(array(":id_empresa"=>$id_empresa));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

}
?>