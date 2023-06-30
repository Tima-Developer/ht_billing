<h1>Установка проекта</h1>
<ol>
    <li>Нужно склонировать репозиторий локально</li>
    <li>Нужно установить все зависимости запустив команду <h4>composer install</h4> если у вас конфликт зависимостей то тогда нужно запустить команду <h4>composeeer install  --ignore-platform-reqs</h4></li>
    <li>Добавить .env файл в корневой директории проекта . В файл скопировать содерживоме .env.example.</li>
    
<li>
    Указать данные бд в .env файле.
    <ul>
        <li>
            DB_DATABASE={название бд}
        </li>
        <li>
            DB_USERNAME={username пользователя  mysql}
        </li>
        <li>
            DB_PASSWORD={пароль}
        </li>
    </ul>
</li>
    <li>Если вы разварачиваете проект локально нужно запустить команду <b>php artisan serve</b> для запуска проекта локально</li>
</ol>


<p>
    Ссылка на постмен коллекцию https://api.postman.com/collections/12060563-88c85b1e-f64f-4914-8a6f-a36aa38608f8?access_key=PMAT-01H46607K4SSC3TM2VB4E10F6Z
</p>

<h1>Как работает сервис</h1>
<ol>
    <li><b>Пополнение счета полльзователя: </b> в постмен коллекции есть запрос по пути "Транзакции->Пополнение и снятие со счета". Id целевого пользователя указывается в урле запроса. В теле запроса есть такие ппппараметры как type - который может содержать либо debit(Снятие) либо replenishment(пополнение), amount - сумма, description - оописание транзакции(не обязательный парамер) </li>
    <li><b>Перевод со счета на счет: </b> в постмене запрос по пути "Транзакции->Перевод со счета на счет". Тело запроса: source_user_id - id пользователся с которго нужно снять деньги, destination_user_id - id пользователя которому нужно зачислить деньги, amount - сумма, description - описание запроса (не обязательный парамтр)</li>
    <li><b>Проверка баланса: </b> в постмене запрос находится по пути "Баланс->Проверить баланс". Id пользователя указывается в урле запроса</li>
</ol>
