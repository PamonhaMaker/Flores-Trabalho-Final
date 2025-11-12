<?php
class Nota {
    private $conn;
    private $table_name = "notas";

    public $id;
    public $titulo;
    public $conteudo;
    public $data_criacao;
    public $produto_id; // relação com produto

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT n.*, p.nome AS produto_nome 
                FROM {$this->table_name} n
                LEFT JOIN produtos p ON n.produto_id = p.id
                ORDER BY n.data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO {$this->table_name} (titulo, conteudo, produto_id)
            VALUES (:titulo, :conteudo, :produto_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":conteudo", $this->conteudo);
        $stmt->bindParam(":produto_id", $this->produto_id);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE {$this->table_name}
            SET titulo = :titulo, conteudo = :conteudo, produto_id = :produto_id
            WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":conteudo", $this->conteudo);
        $stmt->bindParam(":produto_id", $this->produto_id);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
