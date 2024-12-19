function mostrarAniadirPerfil(element) {
  $(element).parents(".misDatos").find(".datoModificar").toggleClass("open");
  $(element).parents(".misDatos").find(".boton-borrar").toggleClass("open");
  if ($(element).parents(".misDatos").find(".datoModificar").hasClass("open")) {
    $(element).text("Cancelar");
  } else {
    $(element).text("Editar");
  }
}

function mostrarAniadirPerfilBis(element) {
  $(element).parents(".misDatos").find(".datoModificar").toggleClass("open");
  $(element).parents(".misDatos").find(".boton-borrar").toggleClass("open");
  if ($(element).parents(".misDatos").find(".datoModificar").hasClass("open")) {
    $(element).text("Cancelar");
    $(element).parents(".misDatos").find(".dato.oficial").hide();
  } else {
    $(element).text("Editar");
    $(element).parents(".misDatos").find(".dato.oficial").show();
  }
}

function habilitarAniadir(element) {
  $(element).parents(".aniadir").find(".informacion").slideToggle(500); // 500ms para la animación suave
  $(element).parents(".aniadir").find(".informacion").toggleClass("open");

  if ($(element).parents(".aniadir").find(".informacion").hasClass("open")) {
    $(element).text("Cancelar");
  } else {
    $(element).text("Añadir");
  }
}

function mostrarEditarDatosPersonales(element) {
  $(element).parents(".datosPersonales").find(".separated").toggleClass("open");
  $(element)
    .parents(".datosPersonales")
    .find(".actualizarPerfil")
    .toggleClass("open");
  $(element).parents(".datosPersonales").find(".together").toggleClass("close");
  $(element).parents(".datosPersonales").find("input").removeAttr("disabled");

  if (
    $(element).parents(".datosPersonales").find(".separated").hasClass("open")
  ) {
    $(element).text("Cancelar");
  } else {
    $(element).text("Editar");
  }
}

function noMostrarFechaFin(element) {
  $(element)
    .parents(".aniadirExperiencia")
    .find(".fechaFin")
    .removeClass("open");
}

function mostrarFechaFin(element) {
  $(element).parents(".aniadirExperiencia").find(".fechaFin").addClass("open");
}

function noMostrarFechaFin2(element) {
  $(element)
    .parents(".editarExperiencia")
    .find(".fechaFin")
    .removeClass("open");
}

function mostrarAniadirReferencia(element) {
  $(element)
    .parents(".referenciasWrap")
    .find(".aniadirReferencias")
    .slideToggle(500);
  $(element)
    .parents(".referenciasWrap")
    .find(".aniadirReferencias")
    .toggleClass("open");

  if (
    $(element)
      .parents(".referenciasWrap")
      .find(".aniadirReferencias")
      .hasClass("open")
  ) {
    $(element).css({
      transform: "rotate(45deg)", // Rota la imagen 45 grados
      transition: "transform 0.5s ease", // Hace la rotación suave
    });
  } else {
    $(element).css({
      transform: "rotate(0deg)",
      transition: "transform 0.5s ease",
    });
  }
}

function mostrarFechaFin2(element) {
  $(element).parents(".editarExperiencia").find(".fechaFin").addClass("open");
}

function habilitarAniadirExperiencia(element){
  $(element)
    .parents(".misExperiencias")
    .find(".aniadirExperiencia")
    .toggleClass("open");
}

function mostrarAniadirExperiencia(element) {
  $(element)
    .parents(".misExperiencias")
    .find(".experiencia.oficial")
    .toggleClass("close");

  $(element)
    .parents(".misExperiencias")
    .find(".experienciaFormulario.editarExperiencia")
    .toggleClass("open");

  $(element)
    .parents(".misExperiencias")
    .find(".boton-borrar")
    .toggleClass("open");

    $(element)
    .parents(".misExperiencias")
    .find(".button-abrir.blue")
    .toggleClass("open");

    $(element)
    .parents(".misExperiencias")
    .find(".referencias>img")
    .toggleClass("open");

  if($(element)
    .parents(".misExperiencias")
    .find(".experiencia.oficial")
    .hasClass("close")){
      $(element).text("Cancelar");
  }
  else{
    $(element).text("Editar");
  }
}

function mostrarEditarExperiencia(element) {
  $(element)
    .parents(".form.borrarExperiencia")
    .find(".experienciaFormulario.editarExperiencia")
    .slideToggle(500);
  /* $(element).parents('.form.borrarExperiencia').find('.experienciaFormulario.editarExperiencia').addClass('open'); */

  if (
    $(element)
      .parents(".form.borrarExperiencia")
      .find(".experienciaFormulario.editarExperiencia")
      .hasClass("open")
  ) {
    $(element)
      .parents(".form.borrarExperiencia")
      .find(".experienciaFormulario.editarExperiencia")
      .removeClass("open");
  } else {
    $(element)
      .parents(".form.borrarExperiencia")
      .find(".experienciaFormulario.editarExperiencia")
      .addClass("open");
  }
}

function mostrarUrl(element) {

  $(element).parents(".misUrls").find(".aniadirUrl").toggleClass("open");
  $(element).parents(".misUrls").find(".boton-borrar").toggleClass("open");


  if ($(element).parents(".misUrls").find(".aniadirUrl").hasClass("open")) {
    $(element).text("Cancelar");
  } else {
    $(element).text("Editar");
  }
}
