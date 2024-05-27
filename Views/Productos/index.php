<?php	include "Views/Templates/header.php" ;?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Productos</li>
</ol>
<button class="btn btn-primary mb-2"  type="button" onclick ="frmProducto();" ><i class="fas fa-plus"></i>  </button>
<table class="table table-light" id="tblProductos">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Serie</th>
            <th>Modelo</th>
            <th>Descripcion</th>
            <th>Sector</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<div id="nuevo_producto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Producto</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmProducto">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="hidden" id="id" name="id">
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del Producto">
                    </div>
                    <div class="form-group">
                        <label for="serie">Serie</label>
                        <input id="serie" class="form-control" type="text" name="serie" placeholder="Serie del Producto">
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input id="modelo" class="form-control" type="text" name="modelo" placeholder="Modelo del Producto">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input id="descripcion" class="form-control" type="text" name="descripcion" placeholder="Descripcion del Producto">
                    </div>
                    <div class="form-group">
                        <label for="sector">Sector</label>
                        <input id="sector" class="form-control" type="text" name="sector" placeholder="Sector del Producto">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Foto</label>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image" ></i> </label>
                                    <span id="icon-cerrar"></span>
                                    <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
                                    <img class="img-thumbnail" id="img-preview">
                                </div>
                            </div>
                        </div>
                    </div>                
                    <button class="btn btn-primary" type="button" onclick ="registrarPro(event);" id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>               
            </div>
        </div>
    </div>
</div>
<?php	include "Views/Templates/footer.php" ;?>  