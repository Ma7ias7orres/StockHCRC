<?php
    class UsuariosModel extends Query{
        private $usuario, $nombre, $clave;
        public function __construct()
        {
            parent::__construct();
        }
        public function getUsuario(string $usuario, string $clave)
        {
            $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND   clave= '$clave'";   
            $data = $this->select($sql);
            return $data;
        }
        public function getUsuarios()
        {
            $sql = "SELECT * FROM usuarios";   
            $data = $this->selectAll($sql);
            return $data;
        }
        public function registrarUsuario(string $usuario, string $nombre, string $clave){
            $this->usuario = $usuario;
            $this->nombre = $nombre;
            $this->clave = $clave;
            $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
            $existe = $this->select($verificar);
            if(empty($existe)){
                $sql = "INSERT INTO usuarios(usuario,nombre,clave) VALUES (?,?,?)";
                $datos = array($this->usuario,$this->nombre,$this->clave);
                $data = $this->save($sql, $datos);
                if($data == 1){
                    $res = "ok";
                }else{
                    $res = "error";
                }
            }else{
                $res = "existe";
            }


            
            return $res;
        }
        
    }

?>