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
    public function dataview_resultados($categoria,$grado)
    {
		$user = $_SESSION['user'];
		if($grado != "")
		{
			$filtro = "WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = '" .$grado. "'";
		}
		else
		{
			$filtro = "WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria;
		}



		$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
		mn.sueldomensual as sueldomensual,  
		ROUND((mn.sueldomensual) - (SELECT MIN(mn.sueldomensual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2)  as realvsminimo,
		
		ROUND((mn.sueldomensual) - (SELECT AVG(mn.sueldomensual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmedio,
		
		ROUND((mn.sueldomensual) - (SELECT MAX(mn.sueldomensual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmaximo,
		
		mn.paqueteanual as paqueteanual, 
		
		ROUND((mn.sueldomensual) - (SELECT MIN(mn.sueldomensual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsminimoanual,
		
		ROUND((mn.sueldomensual) - (SELECT AVG(mn.sueldomensual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmedioanual,
		
		ROUND((mn.sueldomensual) - (SELECT MAX(mn.sueldomensual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmaximoanual
		
		
		FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo ".
		$filtro ." 
		 GROUP BY c.grado ,mn.id, c.categoria
		order by c.puntaje";
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
    public function dataview_resultados2($categoria,$grado)
    {
		$user = $_SESSION['user'];

		
		$stmt2 = $this->conn->prepare("SELECT * FROM matriz_jerarquizacion WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow2 = $stmt2->fetch(PDO::FETCH_ASSOC);

		
		if ($stmt2->rowCount() == 1) {
			

			$stmt = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
			$stmt->execute(array(':id_empresa' => $user['id_empresa']));
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

			
		if ($stmt2->rowCount() == 1) {
			$ingreso_minimo = $userRow2['sueldomin'];
			$incremento_grados = $userRow2['porcentaje_grados'];
			$incremento_min_med_max = $userRow2['porcentaje_pasos'];

			$minimo = round($ingreso_minimo,2);
			$medio = round(($minimo + ($minimo * $incremento_min_med_max)),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$id_escala_administrativo = $userRow['id_escala_administrativo'];


			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'I'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				$data = array();
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						$data[] = $row;

					} 
				
			}

			if($id_escala_administrativo >= '2')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'II'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row2=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row2);

					} 
				
			}
				}

				if($id_escala_administrativo >= '3')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'III'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row3=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row3);

					} 
				
			}
				}


				if($id_escala_administrativo >= '4')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'IV'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row4=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row4);

					} 
				
			}
				}


				if($id_escala_administrativo >= '5')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'V'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row5=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row5);

					} 
				
			}
				}


				if($id_escala_administrativo >= '6')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'VI'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row6=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row6);

					} 
				
			}
				}


				if($id_escala_administrativo >= '7')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'VII'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row7=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row7);

					} 
				
			}
				}


				if($id_escala_administrativo >= '8')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'VIII'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row8=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row8);

					} 
				
			}
				}


				if($id_escala_administrativo >= '9')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'IX'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row9=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row9);

					} 
				
			}
				}


				if($id_escala_administrativo >= '10')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'X'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row10=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row10);

					} 
				
			}
				}


				if($id_escala_administrativo >= '11')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'XI'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row11=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row11);

					} 
				
			}
				}


				if($id_escala_administrativo >= '12')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'XII'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row12=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row12);

					} 
				
			}
				}


				if($id_escala_administrativo >= '13')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'XIII'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row13=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row13);

					} 
				
			}
				}


				if($id_escala_administrativo >= '14')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'XIV'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row14=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row14);

					} 
				
			}
				}


				if($id_escala_administrativo >= '15')
				{
					
			$minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
			$medio = round($minimo + ($minimo * $incremento_min_med_max),2);
			$maximo = round($medio + ($medio * $incremento_min_med_max),2);

			$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
			mn.sueldomensual as sueldomensual,  
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2)  as realvsminimo,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedio,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximo,
			
			mn.paqueteanual as paqueteanual, 
			
			ROUND(((mn.sueldomensual) - (" . $minimo . ")),2) as realvsminimoanual,
			
			ROUND(((mn.sueldomensual) - (" . $medio . ")),2) as realvsmedioanual,
			
			ROUND(((mn.sueldomensual) - (" . $maximo . ")),2) as realvsmaximoanual
			
			FROM matriz_nomina mn
			INNER JOIN cargos c ON c.id = mn.id_cargo 
			WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria." AND c.grado = 'XV'
			 GROUP BY c.grado ,mn.id, c.categoria
			order by c.puntaje";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				
				while($row15=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						array_push($data, $row15);

					} 
				
			}
				}





			
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

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS
    public function dataview_percentiles($categoria,$percentil)
    {
		$user = $_SESSION['user'];
		$percentilmayor = 0;
		$percentilmenor =0;
		$stmt2 = $this->conn->prepare("SELECT MAX(paqueteanual) as maxsueldo 
		FROM matriz_nomina mn 
		INNER JOIN cargos c ON c.id = mn.id_cargo
		WHERE mn.id_empresa=:id_empresa AND categoria=:categoria");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa'],':categoria' => $categoria));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);
		if ($stmt2->rowCount() == 1) {		
		
		$max_sueldo = $userRow['maxsueldo'];
	
		if($percentil == 1)
		{
			$percentilmayor = $max_sueldo;
			$percentilmenor = ($max_sueldo * 75 / 100);
			$filtro = " WHERE paqueteanual >= " . $percentilmenor . " AND paqueteanual <= " .$percentilmayor;
		}

		if($percentil == 2)
		{
			$percentilmayor = ($max_sueldo * 75 / 100);
			$percentilmenor = ($max_sueldo * 50 / 100);
			$filtro = " WHERE paqueteanual >= " . $percentilmenor . " AND paqueteanual < " .$percentilmayor;
		}
		
		
		if($percentil == 3)
		{
			$percentilmayor = ($max_sueldo * 50 / 100);
			$percentilmenor = ($max_sueldo * 25 / 100);
			$filtro = " WHERE paqueteanual >= " . $percentilmenor . " AND paqueteanual < " .$percentilmayor;
		}

		if($percentil == 4)
		{
			$percentilmayor = ($max_sueldo * 25 / 100);
			$filtro = " WHERE paqueteanual < " .$percentilmayor;
		}
		
		

		$query = "SELECT mn.id as id_nomina,
		c.grado as grado,
		c.nombre as nombrecargo,
		d.nombre as nombredepartamento,
		mn.nombre as nombretrabajador,
		mn.fecha_ingreso as fechaingreso,
		mn.sueldo_base as sueldobase,
		mn.sueldomensual as sueldo_mensual,
		mn.paqueteanual as paquete_anual,
		d.categoria as categoriadepartamento,
		mn.id_departamento as iddepartamento,
		mn.id_cargo as idcargo
		FROM matriz_nomina mn
		INNER JOIN cargos c ON mn.id_cargo = c.id
		INNER JOIN departamentos d ON mn.id_departamento = d.id " 
		. $filtro . " AND c.categoria = " . $categoria . " AND
		mn.id_empresa = ". $user['id_empresa'] . " 
		ORDER BY c.grado";
		
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

	//FUNCION PARA CREAR UN DEPARTAMENTO EN LA BD
	public function crear_nomina()
	{
		try
		{
			$user = $_SESSION['user'];
			$id_empresa = $user['id_empresa'];
			$id_departamento = (isset($_POST['id_departamento']))?$_POST['id_departamento']:""; 
			$id_cargo = (isset($_POST['id_cargo']))?$_POST['id_cargo']:""; 

			if ($_POST['cargocritico']!=null)
			{
				$cargocritico = 1;
			}
			else
			{
				$cargocritico = 0;
			}
			if ($_POST['cargosupervisor']!=null)
			{
 				$cargosupervisor = 1;
			}
			else
			{
				$cargosupervisor = 0;
			}
			$modelo_trabajo = (isset($_POST['modelo_trabajo']))?$_POST['modelo_trabajo']:"";
			$porcentaje_remoto = (isset($_POST['porcentaje_remoto']))?$_POST['porcentaje_remoto']:"";
			$porcentaje_presencial = (isset($_POST['porcentaje_presencial']))?$_POST['porcentaje_presencial']:"";
			$nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";  
			$documento = (isset($_POST['documento']))?$_POST['documento']:"";  
			$genero = (isset($_POST['genero']))?$_POST['genero']:"";
			$fecha_ingreso = (isset($_POST['fecha_ingreso']))?$_POST['fecha_ingreso']:"";  
			$sueldo_base = (isset($_POST['sueldo_base_mensual']))?$_POST['sueldo_base_mensual']:"";  
			$sueldomensual = (isset($_POST['total_ingreso_mensual']))?$_POST['total_ingreso_mensual']:""; 
			$paqueteanual =  (isset($_POST['total_paquete_anual']))?$_POST['total_paquete_anual']:""; 
			$factor = (isset($_POST['factor_meses']))?$_POST['factor_meses']:""; 

			if ($_POST['pagoDivisas']!=null)
			{
				$id_tipodivisa = (isset($_POST['id_tipodivisa']))?$_POST['id_tipodivisa']:""; 
				$montodivisa = (isset($_POST['montodivisa']))?$_POST['montodivisa']:""; 
			}
			else
			{
				$id_tipodivisa = 0; 
				$montodivisa = 0; 
			}			
			$status = "1";

            $created_at= date("Y-m-d H:i:s", strtotime('now'));
            $updated_at = date("Y-m-d H:i:s", strtotime('now'));  

			$stmt = $this->conn->prepare("INSERT INTO matriz_nomina(id_empresa,id_departamento,id_cargo,cargocritico,
			cargosupervisor,modelo_trabajo,porcentaje_remoto,porcentaje_presencial,nombre,documento,genero,fecha_ingreso,sueldo_base,sueldomensual,paqueteanual,
			factor,id_tipodivisa,montodivisa,status,creacion,modificado) 
				VALUES(:id_empresa,:id_departamento,:id_cargo,:cargocritico,:cargosupervisor,:modelo_trabajo,
				:porcentaje_remoto,:porcentaje_presencial,:nombre,:documento,:genero,:fecha_ingreso,:sueldo_base,
				:sueldomensual,:paqueteanual,:factor,:id_tipodivisa,:montodivisa,:status,:creacion,:modificado)");
			$stmt->bindparam(":id_empresa",$id_empresa);
			$stmt->bindparam(":id_departamento",$id_departamento);
			$stmt->bindparam(":id_cargo",$id_cargo);
			$stmt->bindparam(":cargocritico",$cargocritico);
			$stmt->bindparam(":cargosupervisor",$cargosupervisor);
			$stmt->bindparam(":modelo_trabajo",$modelo_trabajo);
			$stmt->bindparam(":porcentaje_remoto",$porcentaje_remoto);
			$stmt->bindparam(":porcentaje_presencial",$porcentaje_presencial);
			$stmt->bindparam(":nombre",$nombre);
			$stmt->bindparam(":documento",$documento);
			$stmt->bindparam(":genero",$genero);
			$stmt->bindparam(":fecha_ingreso",$fecha_ingreso);
			$stmt->bindparam(":sueldo_base",$sueldo_base);
			$stmt->bindparam(":sueldomensual",$sueldomensual);
			$stmt->bindparam(":paqueteanual",$paqueteanual);
			$stmt->bindparam(":factor",$factor);
			$stmt->bindparam(":id_tipodivisa",$id_tipodivisa);
			$stmt->bindparam(":montodivisa",$montodivisa);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":creacion",$created_at);
			$stmt->bindparam(":modificado",$updated_at);

			$stmt->execute();

			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	//FIN FUNCION PARA CREAR UN DEPARTAMENTOS EN LA BD

	//FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD
    public function editar_matriz_resultados()
	{
		try
		{

			$user = $_SESSION['user'];
			$id_empresa = $user['id_empresa'];
			
			$categoria = (isset($_POST['cboCategoria']))?$_POST['cboCategoria']:"";
			$presupuesto_ingreso_mensual = (isset($_POST['presupuesto_ingreso_mensual1']))?$_POST['presupuesto_ingreso_mensual1']:"";
			$presupuesto_paquete_anual = (isset($_POST['presupuesto_paquete_anual1']))?$_POST['presupuesto_paquete_anual1']:""; 
			$ventas_mensuales = (isset($_POST['ventas_mensuales1']))?$_POST['ventas_mensuales1']:""; 
			$ventas_anuales = (isset($_POST['ventas_anuales1']))?$_POST['ventas_anuales1']:"";  
            $updated_at = date("Y-m-d H:i:s", strtotime('now'));  
			
			$stmt=$this->conn->prepare("UPDATE matriz_resultados SET 
				categoria=:categoria,
				presupuesto_mensual=:presupuesto_mensual, 
				presupuesto_anual=:presupuesto_anual,  
				ventas_mensual=:ventas_mensual, 
				ventas_anual=:ventas_anual, 
				updated_at=:updated_at
				WHERE id_empresa=:id_empresa");
			$stmt->bindparam(":categoria",$categoria);
			$stmt->bindparam(":presupuesto_mensual",$presupuesto_ingreso_mensual);
			$stmt->bindparam(":presupuesto_anual",$presupuesto_paquete_anual);
			$stmt->bindparam(":ventas_mensual",$ventas_mensuales);
			$stmt->bindparam(":ventas_anual",$ventas_anuales);
			$stmt->bindparam(":updated_at",$updated_at);
			$stmt->bindparam(":id_empresa",$id_empresa);
			$stmt->execute();
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
    public function eliminar_nomina($id)
	{  
  	
            $stmt = $this->conn->prepare("DELETE FROM matriz_nomina WHERE id=:id");
			$stmt->bindparam(":id",$id);
			$stmt->execute();

			return true;
	}
	//FIN FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 


	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function get_indicadores($categoria)
    {
		
		$user = $_SESSION['user'];

		$query = "SELECT 

FORMAT((SELECT SUM(sueldomensual) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . "),2, 'de_DE') as totalingresomensual,

FORMAT((SELECT SUM(paqueteanual) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . "),2, 'de_DE') as totalpaqueteanual,

		FORMAT((SELECT ROUND(AVG(sueldomensual),2) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . "),2, 'de_DE') as promediomensual,

		FORMAT((SELECT  ROUND(AVG(paqueteanual),2) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . "),2, 'de_DE') as promedioanual,

		(SELECT count(*) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as totaltrabajadores,

		(SELECT ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())),2) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as promedioantiguedad,

		FORMAT((SELECT SUM(montodivisa) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . " AND id_tipodivisa = 233),2, 'de_DE') as totaldolares,

FORMAT((SELECT SUM(montodivisa) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . " AND id_tipodivisa = 68),2, 'de_DE') as totaleuros

		FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'];
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
		AND  mn.id_empresa = " . $user['id_empresa']);
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

	public function get_matriz_resultados($id_empresa)
	{
		$stmt = $this->conn->prepare("SELECT *
		FROM matriz_resultados
		WHERE id_empresa=:id_empresa");
		$stmt->execute(array(":id_empresa"=>$id_empresa));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

}
?>