<?php
// ===============================
// CONTROLADOR DE NOTAS (NotaController)
// ===============================
// Responsável por gerenciar as operações de CRUD (Criar, Ler, Atualizar, Deletar)
// da entidade "Nota" e associá-las aos "Produtos" (Pratos).
// Este controller segue o padrão MVC utilizado no seu projeto.

// Importa os arquivos necessários
require_once __DIR__ . '/../config/database.php'; // Conexão com o banco
require_once __DIR__ . '/../models/Nota.php';     // Modelo da tabela notas
require_once __DIR__ . '/../models/Produto.php';  // Modelo da tabela produtos

class NotaController {
    // Atributo que representa o objeto Nota (modelo)
    private $nota;

    // -------------------------------
    // CONSTRUTOR
    // -------------------------------
    public function __construct() {
        // Cria uma instância da classe Database (para obter conexão PDO)
        $database = new Database();
        $db = $database->getConnection();

        // Cria o objeto Nota e armazena na propriedade da classe
        $this->nota = new Nota($db);
    }

    // -------------------------------
    // MÉTODO INDEX (LISTAR TODAS AS NOTAS)
    // -------------------------------
    public function index() {
        // Chama o método do modelo Nota para obter todas as notas do banco
        $stmt = $this->nota->readAll();

        // Inclui a view que exibe a tabela/listagem de notas
        include __DIR__ . '/../views/notas/index_nota.php';
    }

    // -------------------------------
    // MÉTODO CREATE (CRIAR NOVA NOTA)
    // -------------------------------
    public function create() {
        // Cria nova conexão com o banco
        $database = new Database();
        $db = $database->getConnection();

        // Instancia o modelo de Produto para listar os pratos disponíveis
        $produtoModel = new Produto($db);

        // Obtém a lista de produtos (para preencher o <select> na view)
        // Aqui usamos read() pois seu modelo Produto já tem este método
        $produtos = $produtoModel->read();

        // Se o formulário foi enviado via POST:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Coleta os dados do formulário e define no objeto Nota
            $this->nota->titulo = $_POST['titulo'];
            $this->nota->conteudo = $_POST['conteudo'];
            $this->nota->produto_id = $_POST['produto_id'];

            // Chama o método create() do modelo Nota para inserir no banco
            if ($this->nota->create()) {
                // Redireciona para a página principal de notas (listagem)
                header("Location: index.php?page=notas&action=index");
                exit;
            } else {
                // Caso algo dê errado, exibe uma mensagem
                echo "Erro ao criar nota!";
            }
        }

        // Inclui o formulário de criação (create_nota.php)
        include __DIR__ . '/../views/notas/create_nota.php';
    }

    // -------------------------------
    // MÉTODO EDIT (EDITAR NOTA EXISTENTE)
    // -------------------------------
    public function edit() {
        // Cria nova conexão com o banco
        $database = new Database();
        $db = $database->getConnection();

        // Instancia o modelo Produto para listar os pratos disponíveis
        $produtoModel = new Produto($db);
        $produtos = $produtoModel->read();

        // Obtém o ID da nota a ser editada (passado via GET)
        $this->nota->id = $_GET['id'];

        // Busca os dados da nota específica no banco
        $notaData = $this->nota->readOne()->fetch(PDO::FETCH_ASSOC);

        // Se o formulário foi enviado via POST:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Atualiza os dados do objeto Nota com os valores do formulário
            $this->nota->titulo = $_POST['titulo'];
            $this->nota->conteudo = $_POST['conteudo'];
            $this->nota->produto_id = $_POST['produto_id'];
            $this->nota->id = $_GET['id'];

            // Executa o update() para salvar as alterações no banco
            if ($this->nota->update()) {
                // Redireciona de volta à listagem de notas
                header("Location: index.php?page=notas&action=index");
                exit;
            } else {
                echo "Erro ao atualizar nota!";
            }
        }

        // Inclui o formulário de edição (edit_nota.php)
        include __DIR__ . '/../views/notas/edit_nota.php';
    }

    // -------------------------------
    // MÉTODO DELETE (EXCLUIR NOTA)
    // -------------------------------
    public function delete() {
        // Obtém o ID da nota a ser excluída (via GET)
        $this->nota->id = $_GET['id'];

        // Chama o método delete() do modelo Nota
        if ($this->nota->delete()) {
            // Redireciona para a listagem após excluir
            header("Location: index.php?page=notas&action=index");
            exit;
        } else {
            // Se algo der errado, mostra mensagem de erro
            echo "Erro ao excluir nota!";
        }
    }
}
