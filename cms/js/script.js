/* global $, document, console, FileReader, FormData */
/* eslint-disable no-console */
$(document).ready(function() {
    $(document).on("click", ".modal_form .fechar", function(event) {
        event.preventDefault();
        $(".modal_form .body").animate({top: "-100%"}, {duration:300, complete:function() {
            $(".modal_form").remove();
        }});
    });
    
    $(document).on("click", ".modal .fechar", function(event) {
        event.preventDefault();
        $(".modal .body").animate({top: "-100%"}, {duration:300, complete:function() {
            $(".modal").remove();
        }});
    });
    
    function getModal(texto, titulo, tipo, acao) {
        $.ajax({
            url: "../util/modal.php",
            data: {texto: texto, titulo: titulo, tipo: tipo, acao: acao},
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
    
    $(document).on("click", ".modal .confirmar", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            success: function(data) {
                if (data.startsWith("ERRO:")) {
                    getModal(data.substr(5), "Erro");
                } else {
                    var mode = data.startsWith("CATEGORIA:") ? 1 : data.startsWith("SUBCATEGORIA:") ? 2 : 0;
                    var id = mode == 1 ? data.substr(10) : mode == 2 ? data.substr(13) : data;
                    var element = $(mode == 1 ? "#categorias" : mode == 2 ? "#subcategorias" : "#tabela_body").find(".linha[data-id=\"" + id + "\"]");
                    element.fadeOut("slow", function() {
                        element.remove();
                    });
                    
                    $(".modal .body").animate({top: "-100%"}, {duration:300, complete:function() {
                        $(".modal").remove();
                    }});
                    
                    if (mode == 1 && $("#subcategorias .header").attr("data-id") == id) {
                        resetSubcategory();
                    }
                }
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $(document).on("click", "#adicionar, #tabela .editar, #tabela .visualizar", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            success: function(data) {
                $(".modal_form").remove();
                $("body").append(data);
                $(".modal_form .body").animate({top: "50%"}, 300);
                addMask();
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $(document).on("click", "#tabela .excluir", function(event) {
        event.preventDefault();
        var titulo = $(this).is("[data-titulo]") ? ("<strong>" + $(this).attr("data-titulo") + "</strong>") : "este item";
        getModal("Deseja realmente excluir " + titulo + " ?", "Excluir", "confirmação", $(this).attr("href"));
    });
    
    $(document).on("click", "#tabela .ativar", function(event) {
        event.preventDefault();
        var botao = this;
        var ativo = $(this).children("img").attr("data-ativo");
        $.ajax({
            url: $(this).attr("href"),
            data: {ativo: ativo},
            success: function(data) {
                if (data.startsWith("ERRO:")) {
                    getModal(data.substr(5), "Erro");
                } else {
                    getModal(data);
                    if (ativo == "1") {
                        $(botao).html("<img src=\"imagens/icones/desabilitado.png\" alt=\"Desabilitado\" title=\"Desabilitado\" data-ativo=\"0\">")
                    } else {
                        $(botao).html("<img src=\"imagens/icones/habilitado.png\" alt=\"Habilitado\" title=\"Habilitado\" data-ativo=\"1\">")
                    }
                }
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $(document).on("change", ".upload_imagem input", function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            var parent = $(this).parent();
            reader.onload = function(event) {
                parent.children("img").attr("src", event.target.result);
                if (parent.children(".remover").length) {
                    parent.children(".remover").show();
                }
            }
            
            reader.readAsDataURL(this.files[0]);
          }
    });
    
    $(document).on("click", ".upload_imagem .remover", function(event) {
        event.preventDefault();
        $(this).parent().find("img").attr("src", "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D");
        $(this).parent().find("input").val("");
        $(this).parent().find("atual").attr("value", "");
        $(this).hide();
    });
    
    $(document).on("click", ".form_submit", function(event) {
        event.preventDefault();
        var form = $(this).attr("data-form");
        $(form).find("[type=\"submit\"]").trigger("click");
    });
    
    $(document).on("submit", ".modal_form form", function(event) {
        event.preventDefault();
        var form = this;
        $(form).find("*").blur();
        var formData = new FormData(form);
        $(form).find("input[data-original=\"1\"]").each(function() {
            formData.set($(this).attr("name"), $(this).val());
        });
        
        $.ajax({
            type: "POST",
            url: $(form).attr("action"),
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data.startsWith("ERRO:")) {
                    $(form).parent().parent().find(".erro").text(data.substr(5));
                } else {
                    $(".modal_form .body").animate({top: "-100%"}, {duration:300, complete:function() {
                        $(".modal_form").remove();
                    }});
                    
                    if ($(form).attr("id").startsWith("form_add_")) {
                        $("body, html").animate({scrollTop: $("#tabela_body").offset().top + $("#tabela_body")[0].scrollHeight - 100}, 500).promise().then(function() {
                            $(data).css("height", 0).appendTo("#tabela_body").animate({height: "140px"}, "normal");
                        });
                        
                    } else {
                        var id = $(form).find("input[name=\"id\"]").attr("value");
                        var element = $("#tabela_body").find(".linha[data-id=\"" + id + "\"]");
                        element.fadeOut("slow", function() {
                            element.replaceWith(function() {
                                return $(data).hide().fadeIn();
                            });
                        });
                    }
                }
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $(document).on("change", "select[name=\"estado\"]", function() {
        var id = $(this).find(":selected").attr("value");
        $("select[name=\"cidade\"]").attr("disabled", "disabled");
        $.ajax({
            url: "../controller/router.php",
            data: {tipo: "ambiente", modo: "cidades", id: id},
            success: function(data) {
                $("select[name=\"cidade\"]").html(data);
                $("select[name=\"cidade\"]").removeAttr("disabled");
            },
            
            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    function addMask() {
        if ($.fn.inputmask) {
            $("input[name=\"telefone\"]").inputmask({mask: ["(99) 9999-9999", "(99) 99999-9999"], keepStatic: true});
            $("input[name=\"cep\"]").inputmask("99999-999");
            $("input[name=\"numero\"]").inputmask("integer", {min: 1, max: 9999});
            $("input[name=\"preco_antigo\"], input[name=\"novo_preco\"], input[name=\"preco\"]").inputmask("currency", {"autoUnmask": true, radixPoint: ",", groupSeparator: ".", allowMinus: false, prefix: "R$ ", digits: 2, digitsOptional: false, rightAlign: true, unmaskAsNumber: true, max: 999, removeMaskOnSubmit: true});
        }
    }
    
    $(document).on("click", "#adicionar_categoria, #adicionar_subcategoria", function(event) {
        event.preventDefault();
        var parent = $(this.id == "adicionar_categoria" ? "#categorias .body" : "#subcategorias .body");
        if (!$(this).hasClass("disabled")) {
            $.ajax({
                url: $(this).attr("href"),
                success: function(data) {
                    $(data).css("height", 0).appendTo(parent).animate({height: "50px"}, 300);
                },

                error: function() {
                    console.log("Erro interno.");
                }
            });
        }
    });
    
    $(document).on("click", "#categorias .cancelar, #subcategorias .cancelar", function(event) {
        event.preventDefault();
        var parent = $(this).parents(".linha");
        if (parent.hasClass("atualizar")) {
            $.ajax({
                url: $(this).attr("href"),
                success: function(data) {
                    parent.fadeOut("default", function() {
                        parent.replaceWith(function() {
                            return $(data).hide().fadeIn();
                        });
                    });
                },

                error: function() {
                    console.log("Erro interno.");
                }
            });
            
        } else {
            parent.fadeOut("default", function() {
                parent.remove();
            });
        }
    });
    
    $(document).on("click", "#categorias .salvar, #subcategorias .salvar", function(event) {
        event.preventDefault();
        $(this).parents(".linha").find("input[type=\"submit\"]").trigger("click");
    });
    
    $(document).on("submit", "#categorias form, #subcategorias form", function(event) {
        event.preventDefault();
        var form = this;
        $(form).find("*").blur();
        $.ajax({
            type: "POST",
            url: $(form).attr("action"),
            data: $(form).serialize(),
            success: function(data) {
                var element = $(form).parents(".linha");
                element.fadeOut("default", function() {
                    element.replaceWith(function() {
                        return $(data).hide().fadeIn();
                    });
                });
            },

            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $(document).on("click", "#categorias .editar, #subcategorias .editar", function(event) {
        event.preventDefault();
        var parent = $(this).parents(".linha");
        $.ajax({
            url: $(this).attr("href"),
            success: function(data) {
                parent.fadeOut("default", function() {
                    parent.replaceWith(function() {
                        return $(data).hide().fadeIn();
                    });
                });
            },

            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    $(document).on("click", "#categorias .ativar, #subcategorias .ativar", function(event) {
        event.preventDefault();
        var parent = $(this).parents(".linha");
        var ativo = parent.find(".ativar img").attr("data-ativo");
        if (parent.hasClass("atualizar") || parent.hasClass("adicionar")) {
            if (ativo == "1") {
                parent.find(".ativar").html("<img src=\"imagens/icones/desabilitado.png\" alt=\"Desabilitado\" title=\"Desabilitado\" data-ativo=\"0\">")
                parent.find("input[name=\"ativo\"]")[0].value = "0";
            } else {
                parent.find(".ativar").html("<img src=\"imagens/icones/habilitado.png\" alt=\"Habilitado\" title=\"Habilitado\" data-ativo=\"1\">")
                parent.find("input[name=\"ativo\"]")[0].value = "1";
            }
            
        } else {
            $.ajax({
                url: $(this).attr("href"),
                data: {ativo: ativo},
                success: function(data) {
                    getModal(data);
                    if (ativo == "1") {
                        parent.find(".ativar").html("<img src=\"imagens/icones/desabilitado.png\" alt=\"Desabilitado\" title=\"Desabilitado\" data-ativo=\"0\">")
                    } else {
                        parent.find(".ativar").html("<img src=\"imagens/icones/habilitado.png\" alt=\"Habilitado\" title=\"Habilitado\" data-ativo=\"1\">")
                    }
                },

                error: function() {
                    console.log("Erro interno.");
                }
            });
        }
    });
    
    $(document).on("click", "#categorias .excluir", function(event) {
        event.preventDefault();
        getModal("Deseja realmente excluir " + "<strong>" + $(this).attr("data-titulo") + "</strong>" + " e todas suas subcategorias ?", "Excluir", "confirmação", $(this).attr("href"));
    });
    
    $(document).on("click", "#subcategorias .excluir", function(event) {
        event.preventDefault();
        getModal("Deseja realmente excluir " + "<strong>" + $(this).attr("data-titulo") + "</strong>" + " ?", "Excluir", "confirmação", $(this).attr("href"));
    });
    
    $(document).on("click", "#categorias .selecionar", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            success: function(data) {
                $("#subcategorias").fadeOut("fast", function() {
                    $("#subcategorias").html(data).fadeIn("fast");
                });
            },

            error: function() {
                console.log("Erro interno.");
            }
        });
    });
    
    function resetSubcategory() {
        $.ajax({
            url: "../controller/router.php?tipo=subcategoria&modo=selecionar",
            success: function(data) {
                $("#subcategorias").fadeOut("fast", function() {
                    $("#subcategorias").html(data).fadeIn("fast");
                });
            },

            error: function() {
                console.log("Erro interno.");
            }
        });
    }
});