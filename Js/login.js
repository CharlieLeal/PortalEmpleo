function mostrarPass(element) {
    $(element).parent().find("input").toggleClass("showPass");
    if ($(element).parent().find("input").hasClass("showPass")) {
      $(element).parent().find("input").attr("type", "text");
      $(element).find("img").attr("src", "../Img/ojoTachado.png");
    } else {
      $(element).parent().find("input").attr("type", "password");
      $(element).find("img").attr("src", "../Img/ojo.png");
    }
  }

  function mostrarPass2(element) {
    $(element).parent().find("#cambioPass").toggleClass("showPass");
    if ($(element).parent().find("#cambioPass").hasClass("showPass")) {
      $(element).parent().find("#cambioPass").attr("type", "text");
      $(element).find("img").attr("src", "../Img/ojoTachado.png");
    } else {
      $(element).parent().find("#cambioPass").attr("type", "password");
      $(element).find("img").attr("src", "../Img/ojo.png");
    }
  }