//Realizamos la compra del producto, con interaccion de MODEL.JQUERY
function comprarProducto(id) {


    fetch(URL_PATH + "/api/compra/" + id, {
        headers: {
            "Accept": "application/json"
        }
    })

        .then((res) => res.json())
        .then((res) => {
            console.log(res);

            var nombre = document.getElementById("nombre");
            var precio = document.getElementById("precio");
            var cantidad = document.getElementById("contadorCantidad");
            var img = document.getElementById("imagen");
            img.setAttribute('src',URL_PATH+"/assets/fotos/tablas/"+res.img); 
            var precioTotal = document.getElementById("totalprecio"); 
            console.log(res);
            
            precioTotal.innerHTML = res.totalArticulos+"€";
            nombre.innerHTML = res.nombre;
            precio.innerHTML = res.precio;
            cantidad.innerHTML = res.cantidad;

        })

}