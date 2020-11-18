//Ver los productos que tenemos en la cesta.
function verCarrito() {

    // si no hay articulos sacamos una animacion de aviso.
        if (articulos == 0) {
            Swal.fire({
                icon: 'error',
                type: 'info',
                title: 'Oops...',
                text: 'El carrito está vacio...',
                timer: 2000,
                showConfirmButton: false
            });
    
        } else {
            fetch(URL_PATH + "/api/cesta")
                .then((res) => res.json())
                .then(res => {
                    //hacemos una creacion de etiquetas html para poder sacar todos los productos
                    var respuesta = document.getElementById("productosCesta");
                    respuesta.innerHTML ="";
    
                            for(var a = 0; a < res.length; a++){
                                var tr = document.createElement("tr");
                                var td = document.createElement("td");
                                var td1 = document.createElement("td");
                                var td2 = document.createElement("td");
                                var td3 = document.createElement("td");
                                var div = document.createElement("div");
                                var img = document.createElement("img");
                                var strong= document.createElement("strong");
                                var span = document.createElement("span");
                                var p1 = document.createElement("p");
                                var p2 = document.createElement("p");
                                var aa = document.createElement("a");
                                var i = document.createElement("i");
                                //creamos cada iteracion con su respectivo producto
                                respuesta.appendChild(tr);
                                tr.appendChild(td);
                                td.appendChild(div);
                                div.appendChild(img).setAttribute('src',URL_PATH+"/assets/fotos/tablas/"+res[a].img);
                                img.setAttribute('width',50);
                                img.setAttribute('height',70);
                                img.setAttribute('class',"pull-left");
    
                                tr.appendChild(td1);
                                td1.appendChild(strong);
    
                                strong.textContent="x";
                                strong.appendChild(span);
                                span.innerHTML=res[a].cantidad;
                                div.appendChild(p1);
                                p1.innerHTML=res[a].nombre;
                                //hacemos otro tr para que salga el precio en su sito.
                                tr.appendChild(td2);
                                td2.appendChild(p2);
                                p2.innerHTML =res[a].precio+"€";
                                 //hacemos otro tr para que salga el enlace en su sito.
                                tr.appendChild(td3);
                                td3.appendChild(aa);
                                aa.setAttribute('href',URL_PATH+"/eliminarProducto/"+res[a].clave);
                                aa.setAttribute('class',"trash");
                                aa.appendChild(i);
                                i.setAttribute('class', "fa fa-trash-o pull-left");
                        } 
                        });
            
            
                }
            
            
            
    }