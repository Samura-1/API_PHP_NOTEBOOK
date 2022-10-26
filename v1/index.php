<?php
header('Content-Type: application/json');
require_once __DIR__ . '/app/api.php';
$link = $_GET['q'];
$params = explode('/', $link);
$type = $params[0];
$id = $params[1];
$data = $_POST;
$method = $_SERVER['REQUEST_METHOD'];
$api = new api();
switch ($method) {
    case 'GET':
        if ($type === 'notebook') {
            if (isset($id)) {
                $api->getNotebookById($id);
            } else {
                $api->getNotebook();
            }
        }
        break;
    case 'POST' :
        if ($type === 'notebook') {
            if (isset($id)) {
                $api->updateNotebook($id, $data);
            } else {
                $api->addNotebook($data);
            }
        }
        break;
    case 'DELETE':
        if (isset($id)) {
            $api->deleteNotebook($id);
        }
        break;
}

