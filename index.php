<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API NOTEBOOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">API NOTEBOOK</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#method">Доступные методы</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <p>Записная книжка NOTEBOOK</p>
            <p>Экономьте время. Организуйтесь. Работайте вместе.</p>
            <h2>Доступные методы</h2>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <ul>
                <li>
                    <span style="font-weight: bold">GET</span> /api/v1/notebook/
                    <br>
                    <a href="/v1/notebook">/api/v1/notebook/</a>
                <p>Получает список всех элементов из базы данных в формате json
                    <br>
                    1 элемент это :
                    <br>
                    1. ФИО (обязательное)
                    <br>
                    2. Компания
                    <br>
                    3. Телефон (обязательное)
                    <br>
                    4. Email (обязательное)
                    <br>
                    5. Дата рождения
                    <br>
                    6. Фото
                </p>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <span style="font-weight: bold">GET </span>/api/v1/notebook/pagen/1?page=4</span>
                    <a href="v1/notebook/pagen/2?page=1">/api/v1/notebook/pagen/2?page=1</a>
                    <p>Получает список всех элементов из базы данных по странично</p>
                    <p>
                        <span style="font-weight: bold">pagen/1</span>
                        <br>
                        pagen/1- колличество элементов на странице
                        <br>
                        <span style="font-weight: bold">?page=4</span>
                        <br>
                        ?page=4 номер страницы
                    </p>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul>
                 <li>
                     <span style="font-weight: bold">GET</span> /api/v1/notebook/ <span style="font-weight: bold">&lt;id&gt;</span>/
                    <br>
                    <a href="/v1/notebook/1">/v1/notebook/1</a>
                    <p>Методо для получение конкретной записи по ее ID </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <ul>
                <li>
                    <span style="font-weight: bold">POST</span> /api/v1/notebook/
                        <p>Метод добавления новой записи
                         <br>
                        1. ФИО (обязательное)
                        <br>
                         2. Компания
                        <br>
                        3. Телефон (обязательное)
                        <br>
                        4. Email (обязательное)
                        <br>
                        5. Дата рождения
                        <br>
                        6. Фото
                </p>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <span style="font-weight: bold">POST</span> /api/v1/notebook/ <span style="font-weight: bold">&lt;id&gt;</span>/
                    <p>Метод для редактирование существующий записи по ее ID</p>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <span style="font-weight: bold">DELETE</span> /api/v1/notebook/ <span style="font-weight: bold">&lt;id&gt;</span>/
                    <p>Метод удаление записи по ее ID</p>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
