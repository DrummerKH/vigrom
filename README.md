# Wallet
### Deploy
Используется PHP 7.4, PostgreSQL 12. 
Для развертывания проекта требуется docker и docker-compose на хостовой машине. По умолчанию nginx слушает на `8111` порту, postgres слашуает на `5444` порту, при желании можно поменять порты в файле .env: `NGINX_PORT`, `PG_PORT`. Шаши по развертыванияю:
1. В корне проекта выполнить `docker-compose up --build -d `
2. Пакеты:
```shell script
docker exec vigrom-php composer install
```
3. Создание базы:
```shell script
docker exec vigrom-php ./bin/console d:d:c
```
4. Миграции:
```shell script
docker exec vigrom-php ./bin/console d:m:m -n
```
5. Фикстуры:
```shell script
docker exec vigrom-php ./bin/console d:f:l --append
```
6. Крон(котировки)
```shell script
docker exec vigrom-php ./bin/console cron:run
```
Или одной командой:
```shell script
docker exec vigrom-php composer install && \
docker exec vigrom-php ./bin/console d:d:c && \
docker exec vigrom-php ./bin/console d:m:m -n && \
docker exec vigrom-php ./bin/console d:m:m -n && \
docker exec vigrom-php ./bin/console d:f:l --append && \
docker exec vigrom-php ./bin/console cron:run
```

### Использование
* Документация доступна по адресу `http://localhost:8111/api`.
* Для тестирования нужно взять любой кошелек из ответа по запросу `GET /wallets`.
* Затем можно изменять баланс кошелька путем создания транзакций с помощью метода `POST /wallets/{walletId}/transaction`. Пример запросе:
```
POST /wallets/1/transactions
```
```json
{
  "type": "debit",
  "amount": 45.3,
  "currency": "USD",
  "reason": "refund"
}
```
* Получить баланс кошелька можно запросом `GET /wallets/{id}`, где `{id}` нужно заменить на айди нужного кошелька.
* Запрос для получения суммы по `refund` причине:
```sql
SELECT 
    SUM(COALESCE(t.amount, 0)) / 100::NUMERIC, 
    c.code FROM wallet AS w
JOIN 
    currency AS c ON w.currency_id = c.id
LEFT JOIN 
    transaction AS t ON (
        t.wallet_id = w.id AND 
        t.created_at >= now() - interval '1 week'
    )
LEFT JOIN 
    reason AS r ON (
        r.name = 'refund' AND 
        t.reason_id = r.id
    )
GROUP BY c.code;
```

### Пояснения
* Есть простенький сервис получеиня котировок, написал его исключительно для удобства, так как небыло указано нужно его писать или нет. Так же есть консольная команда для записи пачки котировок `currency:get-rates`. Эта же команда указана в крон бандле, поэтому для записи котировок можно использовтаь команду `cron:run`.