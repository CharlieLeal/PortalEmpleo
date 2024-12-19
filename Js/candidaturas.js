function filtrarOfertasPorEstado() {
    // Obtener el estado seleccionado del grupo de radio buttons
    const estadoSeleccionado = document.querySelector('input[name="estadoCandidatura"]:checked').value;

    // Obtener todas las ofertas
    const ofertas = document.querySelectorAll(".ofertasCandidato .ofertaResumen");

    // Iterar sobre cada oferta
    ofertas.forEach(oferta => {
        // Obtener el estado de la oferta desde el atributo data-estado
        const estadoOferta = oferta.getAttribute("data-estado");

        // Mostrar u ocultar la oferta según el estado seleccionado
        if (!estadoSeleccionado || estadoOferta === estadoSeleccionado) {
            oferta.style.display = "flex";
        } else {
            oferta.style.display = "none";
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const itemsPorPagina = 10; // Número de ofertas a mostrar por página
    const ofertas = document.querySelectorAll(".ofertasCandidato a"); // Selecciona todas las ofertas
    const paginador = document.getElementById("paginador");
    let paginaActual = 1;

    // Función para mostrar una página específica
    function mostrarPagina(pagina) {
        const inicio = (pagina - 1) * itemsPorPagina;
        const fin = inicio + itemsPorPagina;

        // Oculta todas las ofertas y muestra solo las correspondientes
        ofertas.forEach((oferta, indice) => {
            if (indice >= inicio && indice < fin) {
                oferta.style.display = "block";
            } else {
                oferta.style.display = "none";
            }
        });
    }

    // Función para crear botones de paginación
    function crearPaginador() {
        const totalPaginas = Math.ceil(ofertas.length / itemsPorPagina);
        paginador.innerHTML = ""; // Limpia el paginador

        for (let i = 1; i <= totalPaginas; i++) {
            const boton = document.createElement("button");
            boton.innerText = i;
            boton.className = "boton-paginador";
            boton.addEventListener("click", () => {
                paginaActual = i;
                mostrarPagina(paginaActual);
                resaltarBoton();
            });
            paginador.appendChild(boton);
        }
        resaltarBoton();
    }

    // Función para resaltar el botón activo
    function resaltarBoton() {
        const botones = document.querySelectorAll(".boton-paginador");
        botones.forEach((btn, indice) => {
            if (indice + 1 === paginaActual) {
                btn.style.backgroundColor = "#00667f";
                btn.style.color = "#fff";
            } else {
                btn.style.backgroundColor = "";
                btn.style.color = "#000";
            }
        });
    }

    // Inicialización
    mostrarPagina(paginaActual);
    crearPaginador();
});

