<?php
class Noticias {
    private $conn;
    private $db;
    private $table_name = "noticias";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    

    public function criar($idusu, $titulo, $noticia, $data)
    {
        return $this->registrar($idusu, $titulo, $noticia, $data);
    }

    public function ler($search = '', $order_by = '') {
        $query = "SELECT n.idnot, u.nome as usuario, n.titulo, n.noticia, n.data 
                  FROM usuarios AS u 
                  INNER JOIN noticias AS n ON u.id = n.idusu";
        $conditions = [];
        $params = [];

        if ($search) {
            $conditions[] = "(n.titulo LIKE :search OR n.noticia LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($order_by === 'titulo') {
            $query .= " ORDER BY n.titulo";
        } elseif ($order_by === 'data') {
            $query .= " ORDER BY n.data";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    public function lerPorId($idnot)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idnot = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idnot]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarNot($idnot, $titulo, $noticia)
    {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, noticia = ? WHERE idnot = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$titulo, $noticia, $idnot]);
        return $stmt;
    }

    public function deletarNot($idnot)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idnot = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idnot]);
        return $stmt;
    }
    
    public function registrar($idusu, $data, $titulo, $noticia )
    {
        $query = "INSERT INTO " . $this->table_name . " (idusu, data, titulo, noticia) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idusu,$data ,$titulo, $noticia]);
        return $stmt;
    }

}
?>