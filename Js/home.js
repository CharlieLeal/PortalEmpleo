function subir() {
  window.scrollTo({
    top: 0,
    behavior: "smooth", // Hace el scroll suave
  });
}

function mostrarMenuBurger() {
  const menuBurger = document.querySelector(".menuBurger");

  if (!menuBurger.classList.contains("open")) {
    // Abrir el menú
    menuBurger.style.height = "0"; // Reinicia altura
    menuBurger.style.padding = "0 1rem"; // Reinicia padding (vertical cerrado)
    menuBurger.classList.add("open");

    // Calcula la altura total necesaria
    const fullHeight = menuBurger.scrollHeight;

    // Usa un timeout para activar la transición
    setTimeout(() => {
      menuBurger.style.height = `${fullHeight}px`; // Ajusta altura
      menuBurger.style.padding = "2rem 1rem"; // Ajusta padding abierto
    }, 10);
  } else {
    // Cerrar el menú
    const currentHeight = menuBurger.scrollHeight; // Altura actual
    menuBurger.style.height = `${currentHeight}px`; // Fija altura para transición
    menuBurger.style.padding = "0 1rem"; // Ajusta padding cerrado

    // Usa un timeout para contraer la altura
    setTimeout(() => {
      menuBurger.style.height = "0"; // Cierra altura
    }, 10);

    // Remueve la clase al terminar la transición
    menuBurger.addEventListener(
      "transitionend",
      () => menuBurger.classList.remove("open"),
      { once: true } // Evita múltiples llamadas
    );
  }
}

function mostrarMenuHorizontal() {
  const menuBarraHorizontal = document.querySelector(".menuBarraHorizontal");
  const etiqueta = document.querySelector(".cabeceraNoHome .etiqueta"); // Selección de la flecha

  if (!menuBarraHorizontal.classList.contains("open")) {
    // Abrir el menú
    menuBarraHorizontal.classList.add("open");

    if (etiqueta) {
      etiqueta.setAttribute("src", "../Img/cerrarColor.png");
    }
  } else {
    // Cerrar el menú
    menuBarraHorizontal.classList.remove("open");

    if (etiqueta) {
      etiqueta.setAttribute("src", "../Img/menuColor.png");
    }
  }
}

function mostrarMenuSombra(element) {
  if ($(window).scrollTop() > 0) {
    $(".menuHorizontal").addClass("sombra");
  } else {
    $(".menuHorizontal").removeClass("sombra");
  }
}


document.addEventListener("DOMContentLoaded", function () {
  const itemsPerPage = 10; // Número de ofertas por página
  const paginador = document.getElementById("paginador");
  let currentPage = 1;

  // Función para filtrar ofertas
  function filtrarOfertas() {
    const puesto = document.getElementById("buscadorPuesto").value.toLowerCase().trim();
    const municipio = document.getElementById("buscadorMunicipio").value.toLowerCase().trim();
    const provincia = document.getElementById("provincias").value.toLowerCase();
    const technology = document.getElementById("technology").checked;

    const ofertas = document.querySelectorAll(".listadoOfertas .oferta");
    let ofertasFiltradas = []; // Array para almacenar ofertas visibles

    ofertas.forEach(oferta => {
      const tituloOferta = oferta.getAttribute("data-titulo").toLowerCase();
      const descripcionOferta = oferta.getAttribute("data-descripcion").toLowerCase();
      const poblacionOferta = oferta.getAttribute("data-poblacion").toLowerCase();
      const ubicacionOferta = oferta.getAttribute("data-ubicacion").toLowerCase();
      const ofertaTechnology = oferta.getAttribute("data-technology") === "true";

      const coincidePuesto = !puesto || tituloOferta.includes(puesto) || descripcionOferta.includes(puesto);
      const coincideMunicipio = !municipio || poblacionOferta.includes(municipio);
      const coincideProvincia = !provincia || ubicacionOferta === provincia;
      const coincideTechnology = !technology || ofertaTechnology;

      if (coincidePuesto && coincideMunicipio && coincideProvincia && coincideTechnology) {
        oferta.style.display = "flex";
        ofertasFiltradas.push(oferta); // Añadir oferta visible
      } else {
        oferta.style.display = "none";
      }
    });

    // Reiniciar la paginación con las ofertas filtradas
    currentPage = 1;
    crearPaginador(ofertasFiltradas);
    mostrarPagina(currentPage, ofertasFiltradas);
  }

  // Función para mostrar una página específica
  function mostrarPagina(page, ofertas) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    ofertas.forEach((oferta, index) => {
      if (index >= start && index < end) {
        oferta.style.display = "flex";
      } else {
        oferta.style.display = "none";
      }
    });
  }

  // Función para crear el paginador
  function crearPaginador(ofertasFiltradas) {
    paginador.innerHTML = ""; // Limpia el paginador
    const totalPages = Math.ceil(ofertasFiltradas.length / itemsPerPage);

    for (let i = 1; i <= totalPages; i++) {
      const boton = document.createElement("button");
      boton.innerText = i;
      boton.className = "btn-paginador";
      boton.addEventListener("click", () => {
        currentPage = i;
        mostrarPagina(currentPage, ofertasFiltradas);
        resaltarBoton();
      });
      paginador.appendChild(boton);
    }
    resaltarBoton();
  }

  // Resalta el botón de la página actual
  function resaltarBoton() {
    const botones = document.querySelectorAll(".btn-paginador");
    botones.forEach((btn, index) => {
      if (index + 1 === currentPage) {
        btn.style.backgroundColor = "#00667f";
        btn.style.color = "#fff";
      } else {
        btn.style.backgroundColor = "";
        btn.style.color = "";
      }
    });
  }

  // Inicializar eventos de filtros
  document.getElementById("buscadorPuesto").addEventListener("keyup", filtrarOfertas);
  document.getElementById("buscadorMunicipio").addEventListener("keyup", filtrarOfertas);
  document.getElementById("provincias").addEventListener("change", filtrarOfertas);
  document.getElementById("technology").addEventListener("change", filtrarOfertas);

  // Inicializa con todas las ofertas visibles
  const ofertasIniciales = Array.from(document.querySelectorAll(".listadoOfertas .oferta"));
  crearPaginador(ofertasIniciales);
  mostrarPagina(currentPage, ofertasIniciales);
});