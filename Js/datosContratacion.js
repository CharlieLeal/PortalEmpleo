function mostrarEditarDatosContratacion(element) {
  $(element).parents(".formulario").find(".separated").toggleClass("open");
  $(element).parents(".formulario").find(".actualizarDatos").toggleClass("open");
  $(element).parents(".formulario").find(".together").toggleClass("close");
  $(element).parents(".formulario").find("input").removeAttr("disabled");

  if (
    $(element).parents(".formulario").find(".separated").hasClass("open")
  ) {
    $(element).text("Cancelar");
  } else {
    $(element).text("Editar");
  }
}
