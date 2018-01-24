<?php
    if (isset($_GET["tipo"])) {
        $tipo = $_GET["tipo"];
        $modo = isset($_GET["modo"]) ? $_GET["modo"] : "";
        switch ($tipo) {
            case "login":
                require_once("usuario_controller.php");
                $usuarioController = new UsuarioController();
                $usuarioController->autenticar();
                break;
                
            case "curiosidade":
                require_once("curiosidade_controller.php");
                $curiosidadeController = new CuriosidadeController();
                switch ($modo) {
                    case "adicionar":
                        $curiosidadeController->getModal(false);
                        break;
                    case "gravar":
                        $curiosidadeController->gravarCuriosidade();
                        break;
                    case "ativar":
                        $curiosidadeController->ativarCuriosidade();
                        break;
                    case "editar":
                        $curiosidadeController->getModal(true);
                        break;
                    case "atualizar":
                        $curiosidadeController->atualizarCuriosidade();
                        break;
                    case "excluir":
                        $curiosidadeController->excluirCuriosidade();
                        break;
                }
                
                break;
                
            case "sobre_nos":
                require_once("sobre_nos_controller.php");
                $sobreNosController = new SobreNosController();
                switch ($modo) {
                    case "adicionar":
                        $sobreNosController->getModal(false);
                        break;
                    case "gravar":
                        $sobreNosController->gravarSobreNos();
                        break;
                    case "ativar":
                        $sobreNosController->ativarSobreNos();
                        break;
                    case "editar":
                        $sobreNosController->getModal(true);
                        break;
                    case "atualizar":
                        $sobreNosController->atualizarSobreNos();
                        break;
                    case "excluir":
                        $sobreNosController->excluirSobreNos();
                        break;
                }
                
                break;
                
            case "ambiente":
                require_once("ambiente_controller.php");
                $ambienteController = new AmbienteController();
                switch ($modo) {
                    case "adicionar":
                        $ambienteController->getModal(false);
                        break;
                    case "cidades":
                        $ambienteController->getCidades();
                        break;
                    case "gravar":
                        $ambienteController->gravarAmbiente();
                        break;
                    case "ativar":
                        $ambienteController->ativarAmbiente();
                        break;
                    case "editar":
                        $ambienteController->getModal(true);
                        break;
                    case "atualizar":
                        $ambienteController->atualizarAmbiente();
                        break;
                    case "excluir":
                        $ambienteController->excluirAmbiente();
                        break;
                }
                
                break;
                
            case "pizza_do_mes":
                require_once("pizza_do_mes_controller.php");
                $pizzaDoMesController = new PizzaDoMesController();
                switch ($modo) {
                    case "adicionar":
                        $pizzaDoMesController->getModal(false);
                        break;
                    case "gravar":
                        $pizzaDoMesController->gravarPizzaDoMes();
                        break;
                    case "ativar":
                        $pizzaDoMesController->ativarPizzaDoMes();
                        break;
                    case "editar":
                        $pizzaDoMesController->getModal(true);
                        break;
                    case "atualizar":
                        $pizzaDoMesController->atualizarPizzaDoMes();
                        break;
                    case "excluir":
                        $pizzaDoMesController->excluirPizzaDoMes();
                        break;
                }
                
                break;
                
            case "promocao":
                require_once("promocao_controller.php");
                $promocaoController = new PromocaoController();
                switch ($modo) {
                    case "adicionar":
                        $promocaoController->getModal(false);
                        break;
                    case "gravar":
                        $promocaoController->gravarPromocao();
                        break;
                    case "ativar":
                        $promocaoController->ativarPromocao();
                        break;
                    case "editar":
                        $promocaoController->getModal(true);
                        break;
                    case "atualizar":
                        $promocaoController->atualizarPromocao();
                        break;
                    case "excluir":
                        $promocaoController->excluirPromocao();
                        break;
                }
                
                break;
                
            case "slider":
                require_once("slider_controller.php");
                $sliderController = new SliderController();
                switch ($modo) {
                    case "adicionar":
                        $sliderController->getModal(false);
                        break;
                    case "gravar":
                        $sliderController->gravarImagem();
                        break;
                    case "ativar":
                        $sliderController->ativarImagem();
                        break;
                    case "editar":
                        $sliderController->getModal(true);
                        break;
                    case "atualizar":
                        $sliderController->atualizarImagem();
                        break;
                    case "excluir":
                        $sliderController->excluirImagem();
                        break;
                }
                
                break;
                
            case "fale_conosco":
                require_once("fale_conosco_controller.php");
                $faleConoscoController = new FaleConoscoController();
                switch ($modo) {
                    case "gravar":
                        $faleConoscoController->gravar();
                        break;
                    case "visualizar":
                        $faleConoscoController->getModal();
                        break;
                    case "excluir":
                        $faleConoscoController->excluir();
                        break;
                }
                
            case "usuario":
                require_once("usuario_controller.php");
                $usuarioController = new UsuarioController();
                switch ($modo) {
                    case "adicionar":
                        $usuarioController->getModal(false);
                        break;
                    case "gravar":
                        $usuarioController->gravarUsuario();
                        break;
                    case "ativar":
                        $usuarioController->ativarUsuario();
                        break;
                    case "editar":
                        $usuarioController->getModal(true);
                        break;
                    case "atualizar":
                        $usuarioController->atualizarUsuario();
                        break;
                    case "excluir":
                        $usuarioController->excluirUsuario();
                        break;
                }
                
                break;
                
            case "categoria":
                require_once("categoria_controller.php");
                $categoriaController = new CategoriaController();
                switch ($modo) {
                    case "html":
                        $categoriaController->getHtmlById();
                        break;
                    case "adicionar":
                        $categoriaController->montarForm(false);
                        break;
                    case "gravar":
                        $categoriaController->gravarCategoria();
                        break;
                    case "editar":
                        $categoriaController->montarForm(true);
                        break;
                    case "atualizar":
                        $categoriaController->atualizarCategoria();
                        break;
                    case "ativar":
                        $categoriaController->ativarCategoria();
                        break;
                    case "excluir":
                        $categoriaController->excluirCategoria();
                        break;
                }
                
                break;
                
            case "subcategoria":
                require_once("subcategoria_controller.php");
                $subcategoriaController = new SubcategoriaController();
                switch ($modo) {
                    case "selecionar":
                        $subcategoriaController->selecionarSubcategorias();
                        break;
                    case "html":
                        $subcategoriaController->getHtmlById();
                        break;
                    case "adicionar":
                        $subcategoriaController->montarForm(false);
                        break;
                    case "gravar":
                        $subcategoriaController->gravarSubcategoria();
                        break;
                    case "editar":
                        $subcategoriaController->montarForm(true);
                        break;
                    case "atualizar":
                        $subcategoriaController->atualizarSubcategoria();
                        break;
                    case "ativar":
                        $subcategoriaController->ativarSubcategoria();
                        break;
                    case "excluir":
                        $subcategoriaController->excluirSubcategoria();
                        break;
                }
                
                break;
                
            case "produto":
                require_once("produto_controller.php");
                $produtoController = new ProdutoController();
                switch ($modo) {
                    case "adicionar":
                        $produtoController->getModal(false);
                        break;
                    case "gravar":
                        $produtoController->gravarProduto();
                        break;
                    case "ativar":
                        $produtoController->ativarProduto();
                        break;
                    case "editar":
                        $produtoController->getModal(true);
                        break;
                    case "atualizar":
                        $produtoController->atualizarProduto();
                        break;
                    case "excluir":
                        $produtoController->excluirProduto();
                        break;
                    case "mostrar":
                        $produtoController->mostrarProdutos();
                        break;
                    case "detalhes":
                        $produtoController->modalDetalhes();
                        break;
                }
                
                break;
        }
    }
?>