<?php
    class Productos extends Controller{
        public function _construct(){
            session_start();
            if (empty ($_SESSION['activo'] )){
                header("location: ".base_url);
            }
            parent::__construct();
        }
        public function index(){
            $this->views->getView($this, "index");
        }
        public function listar(){
            $data = $this->model->getProductos();
            for ($i=0; $i < count($data) ; $i++) {
                if ($data[$i]['estado'] == 1  ) {
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    $data[$i]['acciones'] =  '<div>
                <button class="btn btn-primary" type="button"onclick="btnEditarUser('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button"onclick="btnEliminarUser('.$data[$i]['id'].')"><i class="fas fa-trash-alt"></i></button>
                <div>';                
                }else {
                    $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                    $data[$i]['acciones'] =  '<div>
                    <button class="btn btn-success" type="button"onclick="btnReingresarUser('.$data[$i]['id'].')"><i class="fas fa-trash-restore"></i></button>
                <div>';
                }
                  
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function registrar()
        {
                       
            $nombre = $_POST['nombre'];
            $serie = $_POST['serie'];
            $modelo = $_POST['modelo'];            
            $descripcion = $_POST['descripcion'];
            $sector = $_POST['sector'];
            $id = $_POST['id'];
            if(empty($nombre) || empty($serie) || empty($modelo) || empty($descripcion) || empty($sector)){
               $msg = "Todos los campos son obligatorios"; 
            }else{
                if($id == ""){
                        $data =  $this->model->registrarProducto($nombre, $serie, $modelo, $descripcion, $sector);
                        if($data == "ok"){
                       $msg = "si";
                        }else if($data == "existe"){
                            $msg = "El Producto ya existe";
                       }else{
                            $msg = "Error al registrar el Producto";
                        }     
                                       
                } else {
                    $data =  $this->model->modificarProducto($nombre, $serie, $modelo, $descripcion, $sector, $id);
                        if($data == "modificado"){
                       $msg = "modificado";
                        }else{
                       $msg = "Error al modificar el Producto";
                        }
                }                    
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die(); 
        }  
        public function eliminar(int $id){
            $data = $this->model->accionUser(0, "$id");
            if($data == 1){
                $msg = "ok";
            }else{
                $msg = "Error al eliminar el Producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
         }       
         public function editar(int $id){        
            $data = $this->model->editarUser($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
         }    
         public function reingresar(int $id){            
            $data = $this->model->accionUser(1, "$id");
            if($data == 1){
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el Producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();

         } 
         public function salir(){
            
            session_destroy();
            header("location: ".base_url);
         }
         
     }  

?>