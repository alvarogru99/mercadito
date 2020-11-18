function validarformulario(){
 
    //validar formulario y ver que no hay campos vacios, de ser asi retornamos false y no se manda.
    var nombre = document.getElementById("cliente").value;
    var password = document.getElementById("password").value;
    var direccion = document.getElementById("direccion").value;
    var email = document.getElementById("email").value;
    var tarjeta = document.getElementById("tarjeta").value;
    var cvv = document.getElementById("cvv").value;


    console.log(nombre);
    if(nombre === "" || password === "" || direccion === "" || email === "" || tarjeta === "" || cvv === ""){
      Swal.fire({
         icon: 'warning',
         type: 'info',
         title: 'Oops...',
         text: '¡Hay campos vacios!',
         timer: 2000,
         showConfirmButton: false
     });
       return false;
    }else {
    return true;
    }
       
               
    }

    