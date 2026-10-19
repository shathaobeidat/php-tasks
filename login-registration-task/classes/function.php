
<?php

class DB_con
{
    private $dbh;
    public function __construct()
    {
        $host = 'localhost';
        $db   = 'users';
        $user = 'root';
        $pass = '';

        try {
            $this->dbh = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8mb4",
                $user,
                $pass
            );

            $this->dbh->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {
            die("Database connection failed.");
        }
    }
    public function insert($name,$email,$password){
        $inst=$this->dbh->prepare("INSERT INTO person (name, email, password) VALUES (?, ?, ?)");
    return $inst->execute([$name,$email,$password]);
    }
    
     public function read_user(){
        $read=$this->dbh->query("SELECT id, name, email FROM PERSON");
   return $read->fetchAll();
    }

   public function delete_u($id){
        $del=$this->dbh->prepare("DELETE FROM person where ID=?");
       return $del->execute([$id]);

    }
    public function insert_pro($p_name,$p_desc,$p_price,$p_qty,$p_cat){
        $inst=$this->dbh->prepare("INSERT INTO products (product_name,description, price,quantity,category_id) VALUES (?, ?, ? ,?, ?)");
    return $inst->execute([$p_name,$p_desc,$p_price,$p_qty,$p_cat]);
    }

      public function pro_read(){
        $read=$this->dbh->query("
        SELECT p.id, p.product_name, p.description, p.price, p.quantity, p.created_date, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id");
   return $read->fetchAll();
    }

    public function delete_p($id){
        $del=$this->dbh->prepare("DELETE FROM products where ID=?");
       return $del->execute([$id]);
    }
     public function update_pro($p_name,$p_desc,$p_price,$p_qty,$p_cat,$ID){
        $del=$this->dbh->prepare("UPDATE PRODUCTS SET product_name = ?, description = ?, price = ?, quantity = ?, category_id = ? WHERE id = ? ");
       return $del->execute([$p_name,$p_desc,$p_price,$p_qty,$p_cat,$ID]);
    }

     public function cat_insert($name){
        $inst=$this->dbh->prepare("INSERT INTO categories (category_name) VALUES (?)");
    return $inst->execute([$name]);
    }

       public function cat_read(){
        $read=$this->dbh->query("SELECT id,category_name FROM CATEGORIES");
   return $read->fetchAll();
    }

    public function cat_delete($id){
        $del=$this->dbh->prepare("DELETE FROM CATEGORIES where ID=?");
       return $del->execute([$id]);
    }

     
}

