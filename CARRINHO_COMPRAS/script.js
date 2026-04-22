// ARRAY DE PRODUTOS
var produtos = [
    {
        id: 1,
        nome: "Booster Avulso - Equilíbrio Perfeito",
        preco: 19.90,
        imagem: "Imagens/booster-ep.jpg"
    },
    {
        id: 2,
        nome: "Combo de Pacotes - Equilíbrio Perfeito",
        preco: 249.90,
        imagem: "Imagens/combo-ep.jpg"
    },
    {
        id: 3,
        nome: "Coleção Treinador - Equilíbrio Perfeito",
        preco: 391.90,
        imagem: "Imagens/colecao-ep.jpg"
    },
    {
        id: 4,
        nome: "Booster Avulso - Heróis Excelsos",
        preco: 14.90,
        imagem: "Imagens/booster-he.jpg"
    },
    {
        id: 5,
        nome: "Combo de Pacotes - Heróis Excelsos",
        preco: 219.90,
        imagem: "Imagens/combo-he.jpg"
    },
    {
        id: 6,
        nome: "Coleção Treinador - Heróis Excelsos",
        preco: 349.90,
        imagem: "Imagens/colecao-he.jpg"
    },
    {
        id: 7,
        nome: "Action Figure Pikachu",
        preco: 159.90,
        imagem: "Imagens/pikachu-af.webp"
    },
    {
        id: 8,
        nome: "Action Figure Mewtwo",
        preco: 194.90,
        imagem: "Imagens/mewtwo-af.webp"
    },
    {
        id: 9,
        nome: "Action Figure Lucario",
        preco: 179.90,
        imagem: "Imagens/lucario-af.webp"
    }
];

// ARRAY DO CARRINHO
var carrinho = [];

// PEGANDO ELEMENTOS DO HTML
var listaProdutos = document.querySelector("#lista-produtos");
var listaCarrinho = document.querySelector("#lista-carrinho");
var total = document.querySelector("#total");
var filtro = document.querySelector("#filtro");
var botaoLimpar = document.querySelector("#limpar-carrinho");

// SALVA O CARRINHO NO LOCALSTORAGE
function salvarCarrinho() {
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
}

// CARREGA O CARRINHO SALVO
function carregarCarrinho() {
    var carrinhoSalvo = localStorage.getItem("carrinho");

    if (carrinhoSalvo) {
        carrinho = JSON.parse(carrinhoSalvo);
    } else {
        carrinho = [];
    }
}

// LISTA OS PRODUTOS NA TELA
function listarProdutos(lista) {
    listaProdutos.innerHTML = ""; // limpa antes de mostrar

    lista.forEach(function(produto) {

        var divProduto = document.createElement("div");
        divProduto.classList.add("produto");

        // imagem do produto
        var imagemProduto = document.createElement("img");
        imagemProduto.src = produto.imagem;
        imagemProduto.alt = produto.nome;

        // nome
        var nomeProduto = document.createElement("h3");
        nomeProduto.textContent = produto.nome;

        // preço
        var precoProduto = document.createElement("p");
        precoProduto.textContent = "Preço: R$ " + produto.preco.toFixed(2);

        // botão adicionar
        var botaoAdicionar = document.createElement("button");
        botaoAdicionar.textContent = "Adicionar ao carrinho";

        botaoAdicionar.addEventListener("click", function() {
            adicionarAoCarrinho(produto.id);
        });

        // adicionando tudo na div
        divProduto.appendChild(imagemProduto);
        divProduto.appendChild(nomeProduto);
        divProduto.appendChild(precoProduto);
        divProduto.appendChild(botaoAdicionar);

        listaProdutos.appendChild(divProduto);
    });
}

// ADICIONA PRODUTO AO CARRINHO
function adicionarAoCarrinho(id) {

    // procura produto
    var produtoEncontrado = produtos.find(function(produto) {
        return produto.id === id;
    });

    // verifica se já existe no carrinho
    var itemExistente = carrinho.find(function(item) {
        return item.id === id;
    });

    if (itemExistente) {
        // se já existe, aumenta quantidade
        itemExistente.quantidade = itemExistente.quantidade + 1;
    } else {
        // se não existe, adiciona novo item
        carrinho.push({
            id: produtoEncontrado.id,
            nome: produtoEncontrado.nome,
            preco: produtoEncontrado.preco,
            quantidade: 1
        });
    }

    salvarCarrinho();
    visualizarCarrinho();
    atualizarTotal();
}

// REMOVE PRODUTO DO CARRINHO
function removerDoCarrinho(id) {

    var posicao = carrinho.findIndex(function(item) {
        return item.id === id;
    });

    if (posicao !== -1) {

        if (carrinho[posicao].quantidade > 1) {
            // diminui quantidade
            carrinho[posicao].quantidade = carrinho[posicao].quantidade - 1;
        } else {
            // remove completamente
            carrinho.splice(posicao, 1);
        }
    }

    salvarCarrinho();
    visualizarCarrinho();
    atualizarTotal();
}

// MOSTRA O CARRINHO NA TELA
function visualizarCarrinho() {
    listaCarrinho.innerHTML = "";

    if (carrinho.length === 0) {
        var mensagem = document.createElement("p");
        mensagem.textContent = "Carrinho vazio.";
        listaCarrinho.appendChild(mensagem);
        return;
    }

    carrinho.forEach(function(item) {

        var divItem = document.createElement("div");
        divItem.classList.add("item-carrinho");

        var nomeItem = document.createElement("h3");
        nomeItem.textContent = item.nome;

        var quantidadeItem = document.createElement("p");
        quantidadeItem.textContent = "Quantidade: " + item.quantidade;

        var subtotalItem = document.createElement("p");
        subtotalItem.textContent =
            "Subtotal: R$ " + (item.quantidade * item.preco).toFixed(2);

        var botaoRemover = document.createElement("button");
        botaoRemover.textContent = "Remover";

        botaoRemover.addEventListener("click", function() {
            removerDoCarrinho(item.id);
        });

        divItem.appendChild(nomeItem);
        divItem.appendChild(quantidadeItem);
        divItem.appendChild(subtotalItem);
        divItem.appendChild(botaoRemover);

        listaCarrinho.appendChild(divItem);
    });
}

// ATUALIZA O TOTAL DA COMPRA
function atualizarTotal() {
    var soma = 0;

    carrinho.forEach(function(item) {
        soma = soma + (item.preco * item.quantidade);
    });

    total.textContent = "Total: R$ " + soma.toFixed(2);
}

// FILTRO DE PRODUTOS (USANDO SWITCH)
function filtrarProdutos() {
    var valorFiltro = filtro.value;
    var produtosFiltrados = [];

    switch (valorFiltro) {
        case "ate50":
            produtosFiltrados = produtos.filter(function(produto) {
                return produto.preco <= 50;
            });
            break;

        case "acima50":
            produtosFiltrados = produtos.filter(function(produto) {
                return produto.preco > 50;
            });
            break;

        default:
            produtosFiltrados = produtos;
            break;
    }

    listarProdutos(produtosFiltrados);
}

// LIMPA TODO O CARRINHO
function limparCarrinho() {
    carrinho = [];
    salvarCarrinho();
    visualizarCarrinho();
    atualizarTotal();
}

// EVENTOS
filtro.addEventListener("change", filtrarProdutos);
botaoLimpar.addEventListener("click", limparCarrinho);

// AO CARREGAR A PÁGINA
document.addEventListener("DOMContentLoaded", function() {
    carregarCarrinho();
    listarProdutos(produtos);
    visualizarCarrinho();
    atualizarTotal();
});