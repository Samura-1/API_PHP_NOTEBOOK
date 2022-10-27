<?php
class api
{
    protected PDO $connect;
    protected $pager;

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
    public function getNotebookPagen($limit)
    {
        $this->pager = new ArrayPaginator('http://api/v1/notebook');
        $this->pager->limit = $limit;
        $res = $this->connect->prepare("SELECT * FROM `netebook`");
        $res->execute();
        $res = $res->FETCHALL(PDO::FETCH_ASSOC);
        $res = $this->pager->getItems($res);
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
                'messages' => 'deleted id ' . $lastId,
            ];
        }
        echo json_encode($res);
    }
}
class ArrayPaginator
{
    public  $page    = 1;   /* Текущая страница */
    public  $amt     = 0;   /* Кол-во страниц */
    public  $limit   = 2;  /* Кол-во элементов на странице */
    public  $total   = 0;   /* Общее кол-во элементов */
    public  $display = '';	/* HTML-код навигации */

    private $url     = '';
    private $carrier = 'page';

    /**
     * Конструктор.
     */
    public function __construct($url, $limit = 0)
    {
        $this->url = $url;

        if (!empty($limit)) {
            $this->limit = $limit;
        }

        $page = intval(@$_GET['page']);
        if (!empty($page)) {
            $this->page = $page;
        }

        $query = parse_url($this->url, PHP_URL_QUERY);
        if (empty($query)) {
            $this->carrier = '?' . $this->carrier . '=';
        } else {
            $this->carrier = '&' . $this->carrier . '=';
        }
    }

    /**
     * Срез массива и формирование HTML-кода навигации в переменную display.
     */
    public function getItems($array)
    {
        $this->total = count($array);
        $this->amt = ceil($this->total / $this->limit);
        if ($this->page > $this->amt) {
            $this->page = $this->amt;
        }

        if ($this->amt > 1) {
            $adj = 2;
            $this->display = '<nav class="pagination-row"><ul class="pagination justify-content-center">';

            /* Назад */
            if ($this->page == 1) {
                $this->addSpan('«', 'prev disabled');
            } elseif ($this->page == 2) {
                $this->addLink('«', '', 'prev');
            } else {
                $this->addLink('«', $this->carrier . ($this->page - 1), 'prev');
            }

            if ($this->amt < 7 + ($adj * 2)) {
                for ($i = 1; $i <= $this->amt; $i++){
                    $this->addLink($i, $this->carrier . $i);
                }
            } elseif ($this->amt > 5 + ($adj * 2)) {
                $lpm = $this->amt - 1;
                if ($this->page < 1 + ($adj * 2)){
                    for ($i = 1; $i < 4 + ($adj * 2); $i++){
                        $this->addLink($i, $this->carrier . $i);
                    }
                    $this->addSpan('...', 'separator');
                    $this->addLink($lpm, $this->carrier . $lpm);
                    $this->addLink($this->amt, $this->carrier . $this->amt);
                } elseif ($this->amt - ($adj * 2) > $this->page && $this->page > ($adj * 2)) {
                    $this->addLink(1);
                    $this->addLink(2, $this->carrier . '2');
                    $this->addSpan('...', 'separator');
                    for ($i = $this->page - $adj; $i <= $this->page + $adj; $i++) {
                        $this->addLink($i, $this->carrier . $i);
                    }
                    $this->addSpan('...', 'separator');
                    $this->addLink($lpm, $this->carrier . $lpm);
                    $this->addLink($this->amt, $this->carrier . $this->amt);
                } else {
                    $this->addLink(1, '');
                    $this->addLink(2, $this->carrier . '2');
                    $this->addSpan('...', 'separator');
                    for ($i = $this->amt - (2 + ($adj * 2)); $i <= $this->amt; $i++) {
                        $this->addLink($i, $this->carrier . $i);
                    }
                }
            }

            /* Далее */
            if ($this->page == $this->amt) {
                $this->addSpan('»', 'next disabled');
            } else {
                $this->addLink('»', $this->carrier . ($this->page + 1));
            }

            $this->display .= '</ul></nav>';
        }

        $start = ($this->page != 1) ? $this->page * $this->limit - $this->limit : 0;
        return array_slice($array, $start, $this->limit);
    }

    private function addSpan($text, $class = '')
    {
        $class = 'page-item ' . $class;
        $this->display .= '<li class="' . trim($class) . '"><span class="page-link">' . $text . '</span></li>';
    }

    private function addLink($text, $url = '', $class = '')
    {
        if ($text == 1) {
            $url = '';
        }

        $class = 'page-item ' . $class . ' ';
        if ($text == $this->page) {
            $class .= 'active';
        }
        $this->display .= '<li class="' . trim($class) . '"><a class="page-link" href="' . $this->url . $url . '">' . $text . '</a></li>';
    }
}