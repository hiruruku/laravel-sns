# laravel-sns Project

## laradock開発環境設定（laravelインストール）

### 環境
 - Windows 10 Pro:Docker For Windows/
 - コンテナworkspace php-fpm nginx postgres
   -note: postgreSQLの場合、Docker For Macではでないvolumeのエラーが発生するケースがある。.shファイルの改行コード変更、docker-compose.ymlも変更が必要(20-06-20）。

### 前提

- projects フォルダに複数プロジェクトがあり、project 毎に laradock がある

### PHP Project の作成

```sh
mkdir laravel-sns
cd laravel-sns
git init
```
### .gitignoreを置く
　- laradockを加える
### laradock を参照する

```sh
git submodule add https://github.com/Laradock/laradock.git
```

### .envファイルをコピーし、参照する
 
 - .env-exampleは、updateすると変わる場合がある。.envファイルは.gitignoreにdefaultで含まれる

```sh
cd laradock
cp env-example .env
```


## Dockerで開発環境起動
 - docker-composeによりdaemon立ち上げ。
 - 設定ファイルは、docker-compose.yml
 - .envファイルに各変数を設定する

###　DBにPostgreSQLを使用したい場合 laradock/docker-compose.ymlも調整
 - postgreSQL使用の場合、docker-compose.ymlを編集する必要があるので別ブランチを切る。
 - terminalで`docker create volume pg-vol`(確認：docker volume ls)
 - docker-compose.ymlを編集する
```yml
    volumes:
      pg-vol: 
        external: true
    ~~~~~~~~~~~~~~~~~~~~
    pg-vol: ****/data
```  
  - projectフォルダにもどり、`git add laradock`で参照先が変わる。
 
```bash
$ docker-compose up -d workspace php-fpm nginx postgres
```
```bash
Creating laravel-sns_docker-in-docker_1 ... done
Starting laravel-sns_mysql_1            ... done
Creating laravel-sns_workspace_1        ... done
Creating laravel-sns_php-fpm_1          ... done
Creating laravel-sns_nginx_1            ... done
```

### 起動確認

```bash
$docker-compose ps
             Name                           Command              State                                   Ports
----------------------------------------------------------------------------------------------------------------------------------------------
laravel-sns_docker-in-docker_1   dockerd-entrypoint.sh           Up      2375/tcp, 2376/tcp                                                   
laravel-sns_nginx_1                     /bin/bash /opt/startup.sh       Up      0.0.0.0:443->443/tcp, 0.0.0.0:80->80/tcp, 0.0.0.0:81->81/tcp         
laravel-sns_php-fpm_1          docker-php-entrypoint php-fpm   Up      9000/tcp                                                             
laravel-sns_postgres_1           docker-entrypoint.sh postgres    Up      0.0.0.0:5432->5432/tcp                                         
laravel-sns_workspace_1                   /sbin/my_init                   Up      0.0.0.0:2222->22/tcp, 0.0.0.0:3000->3000/tcp, 0.0.0.0:3001->3001/tcp,
laravel-sns_workspace_1          /sbin/my_init                    Up      0.0.0.0:2222->22/tcp, 0.0.0.0:3000->3000/tcp, 0.0.0.0:3001->3001/tcp, 0.0.0.0:4200->4200/tcp, 0.0.0.0:8001->8000/tcp,
```
### upにならない場合は、Logを確認し対処
```
docker-compose logs
```

### 全てupならブラウザで確認(404 Not Found)

` http://localhost/`

### network 確認

```bash
$docker network ls
$docker network inspect laravel-sns frontend
$docker network inspect laravel-sns backend
$docker network inspect laravel-sns default
```
### laravelをインストール
```sh
docker-compose exec workspace bash
```
```sh
composer create-project --prefer-dist laravel/laravel . "7.12.*"
```
### ブラウザで確認(初期画面)

` http://localhost/`


　



