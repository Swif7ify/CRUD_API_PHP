<?php

interface IExample {
    public function getAll();
    public function insertData($data);
    public function getSingle($data);
    public function updateData($data);
    public function deleteData($data);
}

class CRUD_models implements IExample {

    protected $pdo;
    protected $glb;
    protected $table_name = "users";

    public function __construct(\PDO $pdo, GlobalMethods $glb) {
        $this->pdo = $pdo;
        $this->glb = $glb;
    }

    public function hello() {
        $data = [
            "sample" => "Hello"
        ];
        return $data;
    }

    public function getAll() {
        $sql = "SELECT * FROM " . $this->table_name;
        // $sql = "CALL getAllItem();";
        try {
            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute()) {
                $data = $stmt->fetchAll();
                if($stmt->rowCount() >= 1) {
                    return $this->glb->responsePayload($data, "success" , "Pulled Data", 200);
                } else {
                    return $this->glb->responsePayload(null, "failed" , "No data pulled", 404);
                }
            }
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getSingle($data) {
        $sql = "SELECT * FROM " . $this->table_name  . " WHERE id = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->id])){
                $data =  $stmt->fetchAll();
                if ($stmt->rowCount() >= 1){
                    return $this->glb->responsePayload($data, "success" , "Pulled Single User", 200);
                }else{
                    return $this->glb->responsePayload(null, "failed" , "No data pulled", 404);
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
      
        
    }

    public function insertData($data) {
        $sql = "INSERT INTO " . $this->table_name . " (firstname, lastname, is_Admin) VALUES (?, ?, ?);";
        try {
            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->firstname, $data->lastname, $data->is_admin])) {
                return $this->glb->responsePayload(null, "success" , "Inserted Data", 200);
            } else {
                return $this->glb->responsePayload(null, "failed" , "Failed to Insert Data", 404);
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateData($data) {
        $sql = "UPDATE " . $this->table_name . " SET firstname = ?, lastname = ?, is_admin = ? WHERE id = ?;";
        try {
            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->firstname, $data->lastname, $data->is_admin, $data->id])) {
                return $this->glb->responsePayload(null, "success" , "Succesfully Change User", 200);
            } else {
                return $this->glb->responsePayload(null, "failed" , "Failed to Change Data", 404);
            }

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteData($data) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id = ?;";
        try {
            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->id])) {
                return $this->glb->responsePayload(null, "success" , "Deleted Data", 200);
            } else {
                return $this->glb->responsePayload(null, "failed" , "Failed to Delete Data", 404);
            }

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
