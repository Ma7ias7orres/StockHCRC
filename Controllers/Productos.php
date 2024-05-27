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
                $data[$i]['imagen'] = '<img class="img-thumbnail" src="'.base_url. "Assets/img/". $data[$i]['foto'].'" width="100" >';
                if ($data[$i]['estado'] == 1 ){
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    $data[$i]['acciones'] =  '<div>
                <button class="btn btn-primary" type="button"onclick="btnEditarPro('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button"onclick="btnEliminarPro('.$data[$i]['id'].')"><i class="fas fa-trash-alt"></i></button>
                <div>';                
                }else {
                    $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                    $data[$i]['acciones'] =  '<div>
                    <button class="btn btn-success" type="button"onclick="btnReingresarPro('.$data[$i]['id'].')"><i class="fas fa-trash-restore"></i></button>
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
            $img = $_FILES['imagen'];
            $name = $img['name'];
            $tmpname = $img['tmp_name'];
            $destino = "Assets/img/".$name;
            if(empty($name)){
                $name = "default.jpg";
            }
            if(empty($nombre) || empty($serie) || empty($modelo) || empty($descripcion) || empty($sector)){
               $msg = "Todos los campos son obligatorios"; 
            }else{
                if($id == ""){
                        $data =  $this->model->registrarProducto($nombre, $serie, $modelo, $descripcion, $sector, $name);
                        if($data == "ok"){
                       $msg = "si";
                       move_uploaded_file($tmpname, $destino);
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
            $data = $this->model->accionPro(0, "$id");
            if($data == 1){
                $msg = "ok";
            }else{
                $msg = "Error al eliminar el Producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
         }       
         public function editar(int $id){        
            $data = $this->model->editarPro($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
         }    
         public function reingresar(int $id){            
            $data = $this->model->accionPro(1, "$id");
            if($data == 1){
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el Producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();

         }
         
     }  

?>