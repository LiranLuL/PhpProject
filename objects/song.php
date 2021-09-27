<?php
class Song
{
    private $conn;

    private $id;
    private $song_name;
    private $singer;
    private $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // метод read() - получение товаров 
    function read()
    {

        // выбираем все записи 
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();

        return $stmt;
    }

    function create()
    {

        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // привязка значений 
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
