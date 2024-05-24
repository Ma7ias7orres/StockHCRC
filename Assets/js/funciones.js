let tblUsuarios, tblClientes;
document.addEventListener("DOMContentLoaded", function(){
    tblUsuarios = $('#tblUsuarios').DataTable( {
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: ''
        },
        columns: [
         {        
            'data' : 'id'
         },
         {
            'data' : 'usuario'
         },
         {
            'data' : 'nombre'
         },
         {
            'data' : 'estado'
         },         
         {
            'data' : 'acciones'
         }                    

        ]
    });
    //fin de la tabla usuarios
    tblClientes = $('#tblClientes').DataTable( {
        ajax: {
            url: base_url + "Clientes/listar",
            dataSrc: ''
        },
        columns: [
         {        
            'data' : 'id'
         },
         {
            'data' : 'dni'
         },
         {
            'data' : 'nombre'
         },
         {
            'data' : 'telefono'
         },         
         {
            'data' : 'direccion'
         },
         {
            'data' : 'estado'
         },
         {
            'data' : 'acciones'
         }                    

        ]
    });
})
function frmLogin(e){
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const clave = document.getElementById("clave");
    if(usuario.value == ""){
        clave.classList.remove("is-invalid");
        usuario.classList.add("is-invalid");
        usuario.focus();
    }else  if(clave.value == ""){
        usuario.classList.remove("is-invalid");
        clave.classList.add("is-invalid");
        clave.focus();
    }else {
        const url = base_url + "Usuarios/validar";
        const frm = document.getElementById("frmLogin");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);
                if(res == "ok"){
                    window.location = base_url + "Usuarios";
                }else{
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = res;
                }
            }
        }
    }
    

}
function frmUsuario(){    
    document.getElementById("title").innerHTML = "Nuevo Usuario";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("claves").classList.remove("d-none");  
    document.getElementById("frmUsuario").reset();
    $("#nuevo_usuario").modal("show");
    document.getElementById("id").value = "";
    
}
function registrarUser(e){
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const clave = document.getElementById("clave");
    const confirmar = document.getElementById("confirmar");
    if(usuario.value == "" || nombre.value == ""){
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 3000
          })
    } else {
        const url = base_url + "Usuarios/registrar";
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);                
                if(res == "si"){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Usuario registrado con exito',
                        showConfirmButton: false,
                        timer: 3000
                      })
                      frm.reset();                      
                      $("#nuevo_usuario").modal("hide");
                      tblUsuarios.ajax.reload();
                }else if(res == "modificado"){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Usuario modificado con exito',
                        showConfirmButton: false,
                        timer: 3000
                      })
                      $("#nuevo_usuario").modal("hide");
                      tblUsuarios.ajax.reload();
                }else{
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: res,
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            }  
        }     
          
    }
}
function btnEditarUser(id){
    document.getElementById("title").innerHTML = "Actualizar Usuario";
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Usuarios/editar/"+id;        
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                  JSON.parse(this.responseText);
                  const res = JSON.parse(this.responseText);
                  document.getElementById("id").value = res.id;
                  document.getElementById("usuario").value = res.usuario;
                  document.getElementById("nombre").value = res.nombre;
                  document.getElementById("claves").classList.add("d-none");                
                  $("#nuevo_usuario").modal("show");
            }
        }   
    
}
function btnEliminarUser(id){
    Swal.fire({
        title: "¿Esta seguro de eliminar?",
        text: "El usuario no se eliminara de forma permanente, solo cambiara el estado a inactivo!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si!",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {            
            const url = base_url + "Usuarios/eliminar/"+id;        
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText); 
                if( res == "ok"){
                    Swal.fire({
                        title: "Mensaje",
                        text: "Usuario eliminado con exito.",
                        icon: "success"
                      });
                      tblUsuarios.ajax.reload();
                }else{
                    Swal.fire({
                        title: "Mensaje",
                        text: res,
                        icon: "error"
                      });
                }
            }
        } 
          
        }
      });
}
function btnReingresarUser(id){
    Swal.fire({
        title: "¿Esta seguro de reingresar?",        
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si!",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {            
            const url = base_url + "Usuarios/reingresar/"+id;        
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText); 
                if( res == "ok"){
                    Swal.fire({
                        title: "Mensaje",
                        text: "Usuario reingresado con exito.",
                        icon: "success"
                      });
                      tblUsuarios.ajax.reload();
                }else{
                    Swal.fire({
                        title: "Mensaje",
                        text: res,
                        icon: "error"
                      });
                }
            }
        } 
          
        }
      });
}
//Fin Usuarios

function frmCliente(){    
    document.getElementById("title").innerHTML = "Nuevo Cliente";
    document.getElementById("btnAccion").innerHTML = "Registrar";      
    document.getElementById("frmCliente").reset();
    $("#nuevo_cliente").modal("show");
    document.getElementById("id").value = "";
    
}
function registrarCli(e){
    e.preventDefault();
    const dni = document.getElementById("dni");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const direccion = document.getElementById("direccion");
    if(dni.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == ""  ){
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 3000
          })
    } else {
        const url = base_url + "Clientes/registrar";
        const frm = document.getElementById("frmCliente");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);                
                if(res == "si"){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cliente registrado con exito',
                        showConfirmButton: false,
                        timer: 3000
                      })
                      frm.reset();                      
                      $("#nuevo_cliente").modal("hide");
                      tblClientes.ajax.reload();
                }else if(res == "modificado"){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cliente modificado con exito',
                        showConfirmButton: false,
                        timer: 3000
                      })
                      $("#nuevo_cliente").modal("hide");
                      tblClientes.ajax.reload();
                }else{
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: res,
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            }  
        }     
          
    }
}
function btnEditarCli(id){
    document.getElementById("title").innerHTML = "Actualizar Cliente";
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Clientes/editar/"+id;        
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                  JSON.parse(this.responseText);
                  const res = JSON.parse(this.responseText);
                  document.getElementById("id").value = res.id;
                  document.getElementById("dni").value = res.dni;
                  document.getElementById("nombre").value = res.nombre;
                  document.getElementById("telefono").value = res.telefono;
                  document.getElementById("direccion").value = res.direccion;
                  $("#nuevo_cliente").modal("show");
            }
        }   
    
}
function btnEliminarCli(id){
    Swal.fire({
        title: "¿Esta seguro de eliminar?",
        text: "El usuario no se eliminara de forma permanente, solo cambiara el estado a inactivo!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si!",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {            
            const url = base_url + "Clientes/eliminar/"+id;        
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText); 
                if( res == "ok"){
                    Swal.fire({
                        title: "Mensaje",
                        text: "Cliente eliminado con exito.",
                        icon: "success"
                      });
                      tblClientes.ajax.reload();
                }else{
                    Swal.fire({
                        title: "Mensaje",
                        text: res,
                        icon: "error"
                      });
                }
            }
        } 
          
        }
      });
}
function btnReingresarCli(id){
    Swal.fire({
        title: "¿Esta seguro de reingresar?",        
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si!",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {            
            const url = base_url + "Clientes/reingresar/"+id;        
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText); 
                if( res == "ok"){
                    Swal.fire({
                        title: "Mensaje",
                        text: "Cliente reingresado con exito.",
                        icon: "success"
                      });
                      tblClientes.ajax.reload();
                }else{
                    Swal.fire({
                        title: "Mensaje",
                        text: res,
                        icon: "error"
                      });
                }
            }
        } 
          
        }
      });
}