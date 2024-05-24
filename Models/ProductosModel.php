<?php
    class ProductosModel extends Query{
        private  $nombre, $serie, $modelo, $descripcion, $sector, $id, $estado;
        public function __construct()
        {
            parent::__construct();
        }
        public function getProducto(string $Producto, string $clave)
        {
            $sql = "SELECT * FROM Productos WHERE Producto = '$Producto' AND   clave= '$clave'";   
            $data = $this->select($sql);
            return $data;
        }
        public function getProductos()
        {
            $sql = "SELECT * FROM productos WHERE estado = 1";   
            $data = $this->selectAll($sql);
            return $data;
        }
        public function registrarProducto(string $nombre, string $serie, string $modelo, $descripcion, $sector){
            
            $this->nombre = $nombre;
            $this->serie = $serie;
            $this->modelo = $modelo;
            $this->descripcion = $descripcion;
            $this->sector = $sector;
            $verificar = "SELECT * FROM productos WHERE serie = '$this->serie'";
            $existe = $this->select($verificar);
            if(empty($existe)){
                $sql = "INSERT INTO productos(nombre,serie,modelo,descripcion,sector) VALUES (?,?,?,?,?)";
                $datos = array($this->nombre,$this->serie,$this->modelo,$this->descripcion,$this->sector);
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
        public function modificarProducto(string $nombre, string $serie, string $modelo, $descripcion, $sector, int $id){            
            $this->nombre = $nombre;
            $this->serie = $serie;
            $this->modelo = $modelo;
            $this->descripcion = $descripcion;
            $this->sector = $sector;
            $this->id = $id;            
            $sql = "UPDATE productos SET nombre = ?, serie = ?, modelo = ?, descripcion = ?, sector = ?  WHERE id = ?";
            $datos = array($this->nombre,$this->serie,$this->modelo,$this->descripcion,$this->sector,$this->id);
            $data = $this->save($sql, $datos);
                if($data == 1){
                    $res = "modificado";
                }else{
                    $res = "error";                
                 }            
            return $res;
        }
        public function editarUser(int $id){
            $sql = "SELECT * FROM Productos WHERE id = $id ";
            $data = $this->select($sql);
            return $data;
        }
        public function accionUser(int $estado, int $id){
            $this->id = $id;
            $this->estado = $estado;
            $sql = "UPDATE Productos SET estado = ?  WHERE id = ?";
            $datos = array($this->estado, $this->id);
            $data =  $this->save($sql, $datos);
            return $data;
        }
        
    }

?>