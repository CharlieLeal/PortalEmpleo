function verMasDescripcionOferta(element) {
  $(element).parents(".infoOferta").find(".masInformacion").slideToggle(500);
  $(element).parents(".infoOferta").find(".masInformacion").toggleClass("open");
  if (
    $(element).parents(".infoOferta").find(".masInformacion").hasClass("open")
  ) {
    $(element).text("Ver menos -");
  } else {
    $(element).text("Ver más +");
  }
}

function mostrarOpcionesLogin(element) {
  const opcionesLogin = $(element).parents(".enlaces").find(".verOpcionesLogin");

  if (opcionesLogin.hasClass("open")) {
    // Cierra el menú
    opcionesLogin.removeClass("open");
    $(element).attr("src", "../Img/menu.png");
  } else {
    // Abre el menú
    opcionesLogin.addClass("open");
    $(element).attr("src", "../Img/cerrar.png");
  }
}

