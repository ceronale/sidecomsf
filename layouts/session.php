<?php
ini_set("session.cookie_lifetime",7200);
ini_set("session.gc_maxlifetime",7200); 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//ini_set("session.save_path","/tmp");
//session_cache_expire(7200);
session_start();
//session_regenerate_id(true);
if(!isset($_SESSION['user_session'])){ 
  header("Location: ../login/"); 
 }
 $permisos = $_SESSION['permisos'];
if ($seccion <> '' && $seccion <> 'dashboard' ){
if ($permisos[$seccion] <> 1){
  header("Location: ../dashboard");
}
$seccion = '';
};


 /*
 switch(true)
 {
  case ($permiso == 'p_usuarios' and $p_usuarios == 0):
    header('Location: ../dashboard/');
    break;
  case ($permiso == 'p_departamentos_adm' and $p_departamentos_adm == 0):
    header('Location: ../dashboard/');
    break;
  case ($permiso == 'p_departamentos_taller' and $p_departamentos_taller == 0):
    header('Location: ../dashboard/');
    break;    
  case ($permiso == 'p_cargos_adm' and $p_cargos_adm == 0):
    header('Location: ../dashboard/');
    break;
  case ($permiso == 'p_cargos_taller' and $p_cargos_taller == 0):
    header('Location: ../dashboard/');
    break;
  case ($permiso == 'p_descripcion_adm' and $p_descripcion_adm == 0):
    header('Location: ../dashboard/');
    break;
  case ($permiso == 'p_descripcion_taller' and $p_descripcion_taller == 0):
    header('Location: ../dashboard/');
    break;      
  case ($permiso == 'p_escalas' and $p_escalas == 0):
    header('Location: ../dashboard/');
    break;        
  case ($permiso == 'p_valoracion_adm' and $p_valoracion_adm == 0):
    header('Location: ../dashboard/');
    break;      
  case ($permiso == 'p_valoracion_taller' and $p_valoracion_taller == 0):
    header('Location: ../dashboard/');
    break; 
  case ($permiso == 'p_nomina' and $p_nomina == 0):
    header('Location: ../dashboard/');
    break; 
  case ($permiso == 'p_jerarquizacion' and $p_jerarquizacion == 0):
    header('Location: ../dashboard/');
    break;
  case ($permiso == 'p_resultados' and $p_resultados == 0):
    header('Location: ../dashboard/');
    break;
  case ($permiso == 'p_beneficios' and $p_beneficios == 0):
    header('Location: ../dashboard/');
    break;         
  case ($permiso == 'p_links' and $p_links == 0):
    header('Location: ../dashboard/');
    break; 
  case ($permiso == 'p_glosario' and $p_glosario == 0):
    header('Location: ../dashboard/');
    break; 
  case ($permiso == 'p_perfil_organizacion' and $p_perfil_organizacion == 0):
    header('Location: ../dashboard/');
    break; 
  case ($permiso == 'p_perfil_usuario' and $p_perfil_usuario == 0):
    header('Location: ../dashboard/');
    break; 
  case ($permiso == 'p_view_links' and $p_view_links == 0):
    header('Location: ../dashboard/');
    break; 
  case ($permiso == 'p_view_glosario' and $p_view_glosario == 0):
    header('Location: ../dashboard/');
    break; 

 }
*/
