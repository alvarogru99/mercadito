//Incrementar las cantidades en la zona de realizar compra
function incrementar(id,precio){
    
    fetch(URL_PATH + "/api/incrementar/" + id, {
        headers: {
            "Accept": "application/json"
        }
    })
    .then((res)=>res.json())
    .then(res=>{

        console.log(res.totalArticulos);
        var cantidad = document.getElementById(id);
        var precioTotal = document.getElementById(id+""+id);
        cantidad.innerHTML = res.incrementar;
        precioTotal.innerHTML = (precio * res.incrementar).toFixed(2);
        var sumaRealizarCompra = document.getElementsByClassName("precioTotalincrement");
        for(let a of sumaRealizarCompra){
            a.innerHTML = res.totalArticulos;
        }

    })

}
//Decrementar las cantidades en la zona de realizar compra hasta la cantidad de 1 articulo, ya que ponerlo a 0 es como si lo eliminasemos y para eso tenemos una papelera.
function decrementar(id,precio,total){

    fetch(URL_PATH + "/api/decrementar/" + id, {
        headers: {
            "Accept": "application/json"
        }
    })
    .then((res)=>res.json())
    .then(res=>{
        if(res.decrementar < 1){
            Swal.fire({
                icon: 'warning',
                type: 'info',
                title: 'Oops...',
                text: 'Ya tienes 1 articulo',
                timer: 2000,
                showConfirmButton: false
            });
        }else{
            var cantidad = document.getElementById(id);
            var precioTotal = document.getElementById(id+""+id);

            cantidad.innerHTML = res.decrementar;
            precioTotal.innerHTML = (precio * res.decrementar).toFixed(2);
            var sumaRealizarCompra = document.getElementsByClassName("precioTotalincrement");
            for(let a of sumaRealizarCompra){
                a.innerHTML = res.totalArticulos;
            }
        

        }
    })
}