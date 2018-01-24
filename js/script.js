/* global $, document, window, setTimeout, console */
/* eslint-disable no-console */
$(document).ready(function() {
    $("#botao_login").mousedown(function(event) {
        event.preventDefault();
        $("#form_login").toggleClass("visivel");
    });
    
    $("#botao_menu").mousedown(function(event) {
        event.preventDefault();
        $("body").addClass("menu_visivel");
    });
    
    $("#botao_fechar_menu").mousedown(function(event) {
        event.preventDefault();
        $("body").removeClass("menu_visivel");
    });
    
    $("#botao_categorias").mousedown(function(event) {
        event.preventDefault();
        $("#botao_categorias").toggleClass("ativo");
        $("#lista_categorias").toggleClass("visivel");
    });
    
    $(window).resize(function() {
        $("#menu").addClass("sem_transition");
        setTimeout(function() {
            $("#menu").removeClass("sem_transition");
        }, 100);
    });
    
    if ($("#container_slider").length) {
        $("#container_slider").height(parseInt($("#container_slider").width()) / 3);
        $(window).resize(function() {
            $("#container_slider").height(parseInt($("#container_slider").width()) / 3);
        });
        
        $("#slider").responsiveSlides({
            nav: true,
            prevText: "<",
            nextText: ">"
        });
    }
    
    $(".galeria").each(function() {
        var image = $(this).find(".imagem");
        var thumbnail = $(this).find(".thumbnail a");
        var onTransition = false;
        
        thumbnail.click(function(event) {
            event.preventDefault();
            if (!onTransition) {
                onTransition = true;

                var src = $(this).find("img").attr("src");
                image.fadeOut(400, function() {
                    image.attr("src", src)
                }).fadeIn(400, function() {
                    onTransition = false;
                });

                thumbnail.removeClass("ativo");
                $(this).addClass("ativo");
            }
        });
    });
    
    $(document).on("click", ".modal .fechar", function(event) {
        event.preventDefault();
        $(".modal .body").animate({top: "-100%"}, {duration:300, complete:function() {
            $(".modal").remove();
        }});
    });
    
    function getModal(texto) {
        $.ajax({
            url: "util/modal.php",
            data: {texto: texto},
            success: function(data) {
                $(".modal").remove();
                $("body").append(data);
                $(".modal .body").animate({top: "15%"}, 300);
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    }
    
    $("#form_login").submit(function(event) {
        event.preventDefault();
        $("#form_login *").blur();
        $.ajax({
            type: "POST",
            url: "controller/router.php?tipo=login",
            data: $(this).serialize(),
            success: function(data) {
                if (data == "SUCCESS") {
                    window.location = "./cms/";
                } else {
                    getModal(data);
                }
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    if ($.fn.inputmask) {
        $("input[name=\"celular\"]").inputmask("(99) 99999-9999");
        $("input[name=\"telefone\"]").inputmask("(99) 9999-9999");
    }
    
    $("#form_fale_conosco").submit(function(event) {
        event.preventDefault();
        $("#form_fale_conosco *").blur();
        $.ajax({
            type: "POST",
            url: "controller/router.php?tipo=fale_conosco&modo=gravar",
            data: $(this).serialize(),
            success: function() {
                $("#form_fale_conosco")[0].reset();
                $("#form_fale_conosco #aviso").html("<p>Seu formulário foi enviado com sucesso.</p>");
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    function changePage(currentPage, totalPages) {
        $(".paginacao").attr("data-atual", currentPage);
        $(".paginacao a").removeClass("disabled selected");
        if (currentPage == 1) {
            $(".pagina_anterior").addClass("disabled");
        } else if (currentPage == totalPages) {
            $(".pagina_proxima").addClass("disabled");
        }
        
        $(".paginacao a[data-pagina=\"" + currentPage + "\"]").addClass("selected");
        $(".pagina").removeClass("visible");
        $("#pagina_" + currentPage).addClass("visible");
        $("html, body").animate({scrollTop: $("#area_principal").offset().top + 1}, 300);
    }
    
    $(document).on("click", ".paginacao a", function(event) {
        event.preventDefault();
        var currentPage = parseInt($(".paginacao").attr("data-atual"));
        var totalPages = parseInt($(".paginacao").attr("data-total"));
        
        if ($(this).hasClass("pagina_anterior")) {
            if (currentPage > 1) {
                changePage(currentPage - 1, totalPages);
            }
            
        } else if ($(this).hasClass("pagina_proxima")) {
            if (currentPage <= totalPages - 1) {
                changePage(currentPage + 1, totalPages);
            }
            
        } else {
            changePage(parseInt($(this).attr("data-pagina")), totalPages);
        }
    });
    
    $(".submenu_categorias a").click(function(event) {
        event.preventDefault();
        $("#titulo_pizzas").text($(this).text());
        $("#titulo_pizzas_mobile h1").text($(this).text());
        $("#botao_categorias").removeClass("ativo");
        $("#lista_categorias").removeClass("visivel");
        $.ajax({
            type: "POST",
            url: "controller/router.php?tipo=produto&modo=mostrar",
            data: {idSubcategoria: $(this).attr("data-id")},
            success: function(data) {
                $("#pizzas").html(data);
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $("#form_pesquisa").submit(function(event) {
        event.preventDefault();
        $("#form_pesquisa *").blur();
        $("#titulo_pizzas").text("Nossas Pizzas");
        $.ajax({
            type: "POST",
            url: "controller/router.php?tipo=produto&modo=mostrar",
            data: $(this).serialize(),
            success: function(data) {
                $("#pizzas").html(data);
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $(document).on("click", ".pizza .detalhes", function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "controller/router.php?tipo=produto&modo=detalhes",
            data: {id: $(this).attr("data-id")},
            success: function(data) {
                $(".modal").remove();
                $("body").append(data);
                $(".modal .body").animate({top: "50%"}, 300);
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
});