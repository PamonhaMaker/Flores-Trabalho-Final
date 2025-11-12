<?php
// ==============================================
// MODEL: Nota
// ==============================================
// Este arquivo representa a estrutura e o comportamento
// da tabela "notas" no banco de dados.
// Ele contém todos os métodos de CRUD (Create, Read, Update, Delete)
// utilizados pelo controlador NotaController.
// ==============================================

class Nota {
    // -------------------------------
    // ATRIBUTOS (colunas da tabela)
    // -------------------------------
    private $conn;             // Conexão PDO com o banco de dados
    private $table_name = "notas"; // Nome da tabela no banco

    public $id;                // ID da nota (chave primária)
    public $titulo;            // Título da nota
    public $conteudo;          // Texto ou conteúdo da nota
    public $data_criacao;      // Data em que a nota foi criada
    public $produto_id;        // ID do produto (prato) associado

    // -------------------------------
    // CONSTRUTOR
    // -------------------------------
    // Recebe a conexão PDO ao criar o objeto
    // e armazena em $this->conn para uso nos métodos abaixo.
    public function __construct($db) {
        $this->conn = $db;
    }

    // -------------------------------
    // MÉTODO: readAll()
    // -------------------------------
    // Retorna todas as notas do banco de dados,
    // juntamente com o nome do produto (via JOIN).
    public function readAll() {
        // Consulta SQL com junção da tabela produtos
        $query = "SELECT n.*, p.nome AS produto_nome 
                  FROM {$this->table_name} n
                  LEFT JOIN produtos p ON n.produto_id = p.id
                  ORDER BY n.data_criacao DESC";
        
        // Prepara e executa a consulta
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Retorna o resultado (PDOStatement)
        return $stmt;
    }

    // -------------------------------
    // MÉTODO: readOne()
    // -------------------------------
    // Retorna apenas uma nota, com base no ID.
    public function readOne() {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Substitui o parâmetro :id pelo valor da propriedade $this->id
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        // Retorna a linha encontrada (pode ser usada com fetch(PDO::FETCH_ASSOC))
        return $stmt;
    }

    // -------------------------------
    // MÉTODO: create()
    // -------------------------------
    // Insere uma nova nota no banco de dados.
    public function create() {
        $query = "INSERT INTO {$this->table_name} (titulo, conteudo, produto_id)
                  VALUES (:titulo, :conteudo, :produto_id)";
        
        $stmt = $this->conn->prepare($query);

        // Faz o bind (substituição segura dos valores)
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":conteudo", $this->conteudo);
        $stmt->bindParam(":produto_id", $this->produto_id);

        // Executa a query e retorna true/false
        return $stmt->execute();
    }

    // -------------------------------
    // MÉTODO: update()
    // -------------------------------
    // Atualiza uma nota existente no banco de dados.
    public function update() {
        $query = "UPDATE {$this->table_name}
                  SET titulo = :titulo,
                      conteudo = :conteudo,
                      produto_id = :produto_id
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Substitui os valores pelos atributos do objeto
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":conteudo", $this->conteudo);
        $stmt->bindParam(":produto_id", $this->produto_id);
        $stmt->bindParam(":id", $this->id);

        // Executa e retorna sucesso (true/false)
        return $stmt->execute();
    }

    // -------------------------------
    // MÉTODO: delete()
    // -------------------------------
    // Exclui uma nota com base no ID.
    public function delete() {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Substitui o parâmetro :id pelo valor do atributo $id
        $stmt->bindParam(":id", $this->id);

        // Executa o comando DELETE
        return $stmt->execute();
    }
}
