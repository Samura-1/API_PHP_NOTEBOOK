<?php
class api
{
    protected $method;
    protected $connect;

    public function __construct()
    {
        $this->connect = new PDO('mysql:host=localhost;dbname=notebook', 'root', '');
    }

    public function getNotebook()
    {
        $res = $this->connect->prepare("SELECT * FROM `netebook`");
        $res->execute();
        $res = $res->FETCHALL(PDO::FETCH_ASSOC);
        if (!$res) {
            http_response_code(500);
            $res = [
                'status' => false,
                'messages' => 'fatal errors',
            ];
        }
        echo json_encode($res);
    }
    public function getNotebookById($id)
    {
        $res = $this->connect->prepare("SELECT * FROM `netebook` WHERE `id` = :id");
        $res->bindParam(':id',$id);
        $res->execute();
        $res = $res->FETCHALL(PDO::FETCH_ASSOC);
        if (count($res) === 0) {
            http_response_code(404);
            $res = [
                'status' => false,
                'messages' => 'this is not found',
            ];
        }
        echo json_encode($res);
    }
    private function issetId($id)
    {
        $res = $this->connect->prepare("SELECT * FROM `netebook` WHERE `id` = :id");
        $res->bindParam(':id',$id);
        $res->execute();
        $count = $res->rowCount();
        return $count;
    }
    public function addNotebook($data)
    {
        $errors = [];
        if (trim(empty($data['fio']))) {
            $errors[] = 'FIO пустой';
        }
        if (trim(empty($data['phone']))) {
            $errors[] = 'PHONE пустой';
        }
        if (trim(empty($data['email']))) {
            $errors[] = 'EMAIL пустой';
        }
        if (empty($errors)) {
            $uploaddir = '../v1/img/upload/';
            $uploadfile1 = $uploaddir.basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile1);
            $res = $this->connect->prepare("INSERT INTO `netebook`(`fio`, `company`, `phone`, `email`, `borndate`, `photo`) VALUES (:fio, :company, :phone, :email, :borndate, :photo)");
            $res->bindParam(':fio',$data['fio']);
            $res->bindParam(':company', $data['company']);
            $res->bindParam(':phone', $data['phone']);
            $res->bindParam(':email', $data['email']);
            $res->bindParam(':borndate', $data['borndate']);
            $res->bindParam(':photo', $uploadfile1);
            $res->execute();
            if ($res) {
                $lastId = $this->connect->lastInsertId();
                http_response_code(200);
                $res = [
                    'status' => true,
                    'messages' => 'added is id ' . $lastId,
                ];
            }
        } else {
            http_response_code(400);
            $res = [
                'status' => false,
                'messages' => array_shift($errors),
            ];
        }
        echo json_encode($res);

    }
    public  function updateNotebook($id, $data)
    {
        if ($this->issetId($id) === 0) {
            http_response_code(404);
            $res = [
                'status' => false,
                'messages' => 'this id is not found',
            ];
        } else {
            $uploaddir = '../v1/img/upload/';
            $uploadfile1 = $uploaddir.basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile1);
            $res = $this->connect->prepare("UPDATE `netebook` SET `fio`=:fio, `phone`=:phone, `email`=:email, `company`=:company, `borndate`=:borndate, `photo`=:photo WHERE `id` = :id");
            $res->bindParam(':id',$id);
            $res->bindParam(':fio',$data['fio']);
            $res->bindParam(':company', $data['company']);
            $res->bindParam(':phone', $data['phone']);
            $res->bindParam(':email', $data['email']);
            $res->bindParam(':borndate', $data['borndate']);
            $res->bindParam(':photo', $uploadfile1);
            $res->execute();
            http_response_code(200);
            $res = [
                'status' => true,
                'messages' => 'successful',
            ];
        }
        echo json_encode($res);
    }
    public function deleteNotebook($id)
    {
        if ($this->issetId($id) === 0) {
            http_response_code(404);
            $res = [
                'status' => false,
                'messages' => 'this id is not found',
            ];
        } else {
            $res = $this->connect->prepare("DELETE FROM `netebook` WHERE `id` = :id");
            $res->bindParam(':id',$id);
            $res->execute();
            $lastId = $this->connect->lastInsertId();
            http_response_code(410);
            $res = [
                'status' => true,
                'messages' => '$lastId',
            ];
        }
        echo json_encode($res);
    }
}