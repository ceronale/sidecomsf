<?php
include_once( '../layouts/session.php' );

include_once 'class.crud.php';
$crud = new crud();

    $id_usuario = (isset($_POST['id']))?$_POST['id']:"";

        $value2 = "";
		$query = "SELECT DISTINCT COLUMN_NAME as columna
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE TABLE_NAME = 'permisos' and COLUMN_NAME not in ('id_seccion_permiso', 'usuario_permiso', 'id_permisos', 'id_usuario', 'created_at', 'updated_at',
		'permisos',
		'seccion_usuarios',
		'crear_cliente',
		'crear_empleado',
		'seccion_inventario',
		'inventario_global',
		'es_global',
		'productos_global',
		'almacenes',
		'manejar_cliente',
		'mensajeria_global',
		'vehiculos',
		'conductores',
		'gps',
		'envios',
		'es_cliente',
		'inventario_cliente',
		'productos_cliente',
		'mensajeria_cliente',
		'presupuestos',
		'clientes',
		'productos',
		'usuarios',
		'id_permiso',
		'p_setup',
		'notas_entregas',
		'seccion_productos',
		'tipos',
		'marcas')";
		$stmt = $crud->conn->prepare($query);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
		
			$html = "<div class='row'>";
			
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				foreach($row as $value){							
					
					$query2 = "SELECT $value FROM permisos WHERE id_usuario=". $id_usuario;
					$stmt2 = $crud->conn->prepare($query2);
					$stmt2->execute();	
					$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
					
									
	
		$html = $html .	"<div class='col-md-6' style='text-align: left !important'>";
        $html = $html .	"<div class='form-group'>
				<input class='form-check-input' type='hidden' id='$value' name='$value' value='$row2[$value]'>
					<input class='form-check-input' type='checkbox' id='$value' name='$value'";
					if ($row2[$value]==1) {
                        $html = $html .	"checked ";
                        } 
                    $html = $html .	">
					<label class='form-check-label' for='$value'>";
					if($value2 !==''){
                    $html = $html .	"$value2";
					$value2 ='';
					}
					else
					{ 
                        $texto = ucwords(strtolower(str_replace("_", " ", $value))); 
                        $texto = ltrim($texto, 'P');
                        $html = $html .	"$texto";
					} 
                    $html = $html .	"</label>
				</div>  
		</div>";
	
				
				} 
	
			
			}
            $html = $html . "</div>";
		
			}

    echo $html;