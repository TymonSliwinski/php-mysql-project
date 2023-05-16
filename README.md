# PHP-MySQL project  

## Config

Create **.env** file like this in root directory (same as compose file)  
```
DB_USER=user
DB_PASSWORD=password
SQL_INIT_FILE=/path/to/init-file.sql
```

## Installation
1. Clone repo  
```bash
git clone https://github.com/TymonSliwinski/php-mysql-project.git
```  
2. Start docker  
```bash
docker-compose --env-file .env up -d
```