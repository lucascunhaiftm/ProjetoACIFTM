# ProjetoAppAC
A base do projeto foi feita criando o projeto pelo instalaçao do laravel. 

    composer create-project --prefer-dist laravel/laravel:^7.0 nome_do_projeto

Foi clonado o reposítório do laradock para a pasta do projeto. Usei submodule porque o repositório já era versonado pelo git.

    git submodule add https://github.com/Laradock/laradock.git
 
Na pasta laradock temos um arquivo chamado **env.example** com as configurações padrões para rodar o ambiente. Faça uma cópia:

    cp .env.example .env

Neste arquivo temos diversas variáveis para configurar relativas aos diversos serviços que podem rodar no ambiente. Altere as que julgar necessário. No caso deste projeto foram alterados os seguintes valores:

    APP_CODE_PATH_HOST=../appac/ # para ajustar a pasta com o projeto laravel
    COMPOSE_PROJECT_NAME=appacproj # nome dado para o projeto
    WORKSPACE_INSTALL_GNUPG=true # ao fazer instalação era solicitado esse pacote
    WORKSPACE_INSTALL_XDEBUG=true #habilitar xdebug nos containers
    PHP_FPM_INSTALL_GNUPG=true # ao fazer instalação era solicitado esse pacote
    PHP_FPM_INSTALL_XDEBUG=true #habilitar xdebug nos containers `

No cado das variáveis relacionadas ao MySQL, um detalhe foi a troca da porta de **3306** para **3307**. Isso porque localmente já havia sgbd usando aporta. Com isso consigo acessar o container usando uma GUI, como DBeavear. 

Dentro da pasta do laradock, temos uma pasta do **nginx/sites/**. Existe uma confiugração de exemplo, ela foi renomeada e foi criada uma com o nome **appac.conf**:
  
    server_name appac.test; #Foi alterado para que acessemos no navegador esse endereço e carreguemos nosso projeto
    root /var/www/public;
    index index.php index.html index.htm;

Feito isso, precisamo adicionar na nossa máquina local o host para que direcione o nosso projeto acessando o endereço **appac.test**. Adicione ao arquivo **/etc/host** a seguinte linha:

    127.0.0.1       appac.test

Para rodar o projeto basta usar comando docker-compose up mysql e nginx. Ele fará o build e subirá os containers. 

## XDEBUG

Para habilitarmos o XDebug, uma vez que instalamos, basta modifica os arquivos **xdebug.ini** nas pastas **laradock/workspace** e **laradock/php-fpm**. Substitua o conteúdo dos arquivos por esse abaixo:

    xdebug.remote_host=host.docker.internal
    xdebug.remote_connect_back=1
    xdebug.remote_port=9000
    xdebug.idekey=VSCODE

    xdebug.remote_autostart=1
    xdebug.remote_enable=1
    xdebug.cli_color=1
    xdebug.profiler_enable=1
    xdebug.profiler_output_dir="~/xdebug/vscode/tmp/profiling"

    xdebug.remote_handler=dbgp
    xdebug.remote_mode=req

    xdebug.var_display_max_children=-1
    xdebug.var_display_max_data=-1
    xdebug.var_display_max_depth=-1
    
Para que tudo seja incorporado pelo container, basta fazer build novamente dos conatainers:

    docker-compose build --no-cache workspace php-fpm 
  
Vá no menu *Run -> Add Configuration*. Ser criado um arquivo **launch.json**. Substitua o conteúdo do mesmo por: 
     
     {
      // Use IntelliSense to learn about possible attributes.
      // Hover to view descriptions of existing attributes.
      // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
      "version": "0.2.0",
      "configurations": [
          {
              "name": "Listen for XDebug",
              "type": "php",
              "request": "launch",
              "port": 9000,
              "log": true,
              "externalConsole": false,
              "pathMappings": {
                  "/var/www": "${workspaceRoot}/appac",#lembrando que o no aqui está o nome *appac* que dei para o projeto, pasta com arquivos do laravel.
              },
              "ignore": [
                  "**/vendor/**/*.php"
              ]
          }
      ]
      }

Basta selecionar a opção no visual code para habilitar o debug e acessar a página pelo navegador. Se tudo estiver ok, será disparado o breakpoint marcado. 

