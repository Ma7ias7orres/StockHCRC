<?php
    class Usuarios extends Controller{
        public function _construct(){
            session_start();
            parent::__construct();
        }
        public function index(){
            $this->views->getView($this, "index");
        }
        public function listar(){
            $data = $this->model->getUsuarios();
            for ($i=0; $i < count($data) ; $i++) {
                if ($data[$i]['estado'] == 1  ) {
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                }else {
                    $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                $data[$i]['acciones'] =  '<div>
                <button class="btn btn-primary" type="button">Editar</button>
                <button class="btn btn-danger" type="button">Eliminar</button>
                <div>';  
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function validar(){
            if( empty($_POST['usuario']) ||  empty($_POST['clave']) ){
                $msg = "Los campos estan vacios";

            }else {
                $usuario = $_POST['usuario'];
                $clave = $_POST['clave'];
                $data = $this->model->getUsuario($usuario, $clave);
                if($data){
                    $_SESSION['id_usuario'] = $data['id'];
                    $_SESSION['usuario'] = $data['usuario'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $msg = "ok";
                }else{
                    $msg = "Usuario o Contraseña Incorrecta";
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function registrar(){
            $usuario = $_POST['usuario'];
            $nombre = $_POST['nombre'];
            $clave = $_POST['clave'];
            $confirmar = $_POST['confirmar'];
            if(empty($usuario) || empty($nombre) ||empty($clave) ){
               $msg = "Todos los campos so obligatorios"; 
            }else if($clave != $confirmar){
                $msg = "Las contraseñas no coinciden";
            }else{
               $data =  $this->model->registrarUsuario($usuario, $nombre, $clave);
               if($data == "ok"){
                    $msg = "si";
               }else if($data == "existe"){
                    $msg = "El usuario ya existe";
               }else{
                    $msg = "Error al registrar el usuario";
               }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>

