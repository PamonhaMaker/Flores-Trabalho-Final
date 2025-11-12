<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Produto.php';

class NotaController {
    private $nota;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->nota = new Nota($db);
    }

    // =========================
    // LISTAR TODAS AS NOTAS
    // =========================
    public function index() {
        $stmt = $this->nota->readAll();
        include __DIR__ . '/../views/notas/index_nota.php';
    }

    // =========================
    // CRIAR NOVA NOTA
    // =========================
    public function create() {
        $database = new Database();
        $db = $database->getConnection();

        // Obter lista de produtos para o select
        $produtoModel = new Produto($db);

        // ✅ Usa read() (compatível com seu Produto.php)
        $produtos = $produtoModel->read();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->nota->titulo = $_POST['titulo'];
            $this->nota->conteudo = $_POST['conteudo'];
            $this->nota->produto_id = $_POST['produto_id'];

            if ($this->nota->create()) {
                header("Location: index.php?page=notas&action=index");
                exit;
            } else {
                echo "Erro ao criar nota!";
            }
        }

        include __DIR__ . '/../views/notas/create_nota.php';
    }

    // =========================
    // EDITAR NOTA EXISTENTE
    // =========================
    public function edit() {
        $database = new Database();
        $db = $database->getConnection();

        // Obter produtos
        $produtoModel = new Produto($db);
        $produtos = $produtoModel->read();

        // Obter dados da nota
        $this->nota->id = $_GET['id'];
        $notaData = $this->nota->readOne()->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->nota->titulo = $_POST['titulo'];
            $this->nota->conteudo = $_POST['conteudo'];
            $this->nota->produto_id = $_POST['produto_id'];
            $this->nota->id = $_GET['id'];

            if ($this->nota->update()) {
                header("Location: index.php?page=notas&action=index");
                exit;
            } else {
                echo "Erro ao atualizar nota!";
            }
        }

        include __DIR__ . '/../views/notas/edit_nota.php';
    }

    // =========================
    // EXCLUIR NOTA
    // =========================
    public function delete() {
        $this->nota->id = $_GET['id'];

        if ($this->nota->delete()) {
            header("Location: index.php?page=notas&action=index");
            exit;
        } else {
            echo "Erro ao excluir nota!";
        }
    }
}
