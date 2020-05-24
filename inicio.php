<!DOCTYPE html>
  <html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection,print"/>
        <link type="text/css" rel="stylesheet" href="css/padrao.css"  media="screen,projection,print"/>
        <title>DSI Strategy Canvas</title>
	    <link rel="shortcut icon" href="img/favicon.ico">
        <!--Let browser know website is optimized for mobile-->
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <form action="inicio.php" enctype="multipart/form-data" id="fileUploadForm" method="POST">
            <input type="file" id="data" name="data">
        </form>
        <div id="modal1" class="modal">
            <div class="modal-content">
                <div id="logar">
                <h4>Login</h4>
                    <form action="perfil" method="post" id="login">
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <input placeholder="Nome de usuário" id="user" name="user" type="text" class="validate" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <input placeholder="Senha" id="senha" name="senha" type="password" class="validate" required>
                            </div>
                        </div>
                        <div class="row">
                            <a onclick="mudar()" class="teal-text" href="#">Cadastre-se</a>
                            <button class="btn waves-effect waves-light right teal darken-2" type="submit" name="action">Entrar
                                <i class="material-icons right">arrow_forward</i>
                            </button>
                        </div>
                    </form>
                </div>
                <div id="cadastrar">
                <h4>Cadastrar</h4>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <input placeholder="Nome de usuário" id="newuser" name="newuser" type="text" class="validate" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <input placeholder="E-mail" id="newemail" name="newemail" type="email" class="validate" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <input placeholder="Digite sua senha" id="newsenha" name="newsenha" type="password" class="validate" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <input placeholder="Digite sua senha novamente" id="newsenha2" name="newsenha2" type="password" class="validate" required>
                            </div>
                        </div>
                        <div class="row">
                            <a onclick="mudar()" class="teal-text" href="#">Voltar ao login</a>
                            <button class="btn waves-effect waves-light right teal darken-2" type="button" onclick="cadastrar();" name="action">Cadastrar
                                <i class="material-icons right">arrow_forward</i>
                            </button>
                        </div>
                </div>
            </div>
        </div>
        <div class="fixed-action-btn vertical click-to-toggle">
            <a class="btn-floating btn-large red darken-2 floatingLogin">
            <i class="material-icons" id="icon-floating">menu</i>
            </a>
            <ul class="floatingLoginBtn right">
            <li><a class="btn-floating red" title="Imprimir" onclick="imprimir()"><i class="material-icons">print</i></a></li>
            <li><a class="btn-floating green darken-1" title="Importar" onclick="selecionar()"><i class="material-icons">file_upload</i></a></li>
            <li><a class="btn-floating blue" title="Exportar"><i class="material-icons" onclick="exportar()">file_download</i></a></li>
            <li><a class="btn-floating yellow darken-3" onclick="login();" title="Login"><i class="material-icons">exit_to_app</i></a></li>
            <div class="chip left" id="chipTitle"><input type="text" value="" id="titleproject"></div>
        </ul>
    </div>
        <div class="box">
            <div class="row linhas-content">
                <div class="col cyan darken-4 l4 m6 s12 linhas">
                    <i class="material-icons white-text center back-icon">people</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">people</i><h5 class="title-box white-text center">Ecossistemas de Inov. Social</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small cyan darken-4 right floating-button-content" onclick="adicionarElemento('eco');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="eco">
                    </div>
                </div>
                <div class="col lime darken-2 l4 m6 s12 colunas linhas">
                <i class="material-icons white-text center back-icon">trending_up</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">trending_up</i><h5 class="title-box white-text center">Escalabilidade/Crescimento</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small lime darken-2 right floating-button-content"  onclick="adicionarElemento('esc');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="esc">
                    </div>
                </div>
                <div class="col deep-orange darken-1 l4 m6 s12 colunas linhas">
                <i class="material-icons white-text center back-icon">group_add</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">group_add</i><h5 class="title-box white-text center">Valor Social</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small deep-orange darken-1 right floating-button-content" onclick="adicionarElemento('val');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="val">
                    </div>
                </div>
            
                <div class="col brown darken-2 l4 m6 s12 linhas">
                <i class="material-icons white-text center back-icon">description</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">description</i><h5 class="title-box white-text center">Mensuração/Avaliação</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small brown darken-2 right floating-button-content" onclick="adicionarElemento('men');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="men">
                    </div>
                </div>
                <div class="col green darken-4 l4 m6 s12 colunas linhas">
                <i class="material-icons white-text center back-icon">lightbulb_outline</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">lightbulb_outline</i><h5 class="title-box white-text center">Habilitadores</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small green darken-4 right floating-button-content" onclick="adicionarElemento('hab');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="hab">
                    </div>
                </div>
                <div class="col blue-grey darken-3 l4 m6 s12 colunas linhas">
                <i class="material-icons white-text center back-icon">insert_emoticon</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">insert_emoticon</i><h5 class="title-box white-text center">Engajamento/Mobilização</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small blue-grey darken-3 right floating-button-content" onclick="adicionarElemento('eng');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="eng">
                    </div>
                </div>
                <div class="col red darken-2 l4 m6 s12 linhas">
                <i class="material-icons white-text center back-icon">face</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">face</i><h5 class="title-box white-text center">Benefiaciários</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small red darken-2 right floating-button-content" onclick="adicionarElemento('ben');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="ben">
                    </div>
                </div>
                <div class="col cyan darken-4 l4 m6 s12 colunas linhas">
                <i class="material-icons white-text center back-icon">block</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">block</i><h5 class="title-box white-text center">Barreiras</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small cyan darken-4 right floating-button-content" onclick="adicionarElemento('bar');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="bar">
                    </div>
                </div>
                <div class="col purple darken-3 l4 m6 s12 colunas linhas">
                <i class="material-icons white-text center back-icon">attach_money</i>
                    <div class="title">
                        <i class="material-icons white-text center icon-box">attach_money</i><h5 class="title-box white-text center">Financiamento</h5>
                    </div>
                    <a class="btn-floating waves-effect waves-light btn-small purple darken-3 right floating-button-content" onclick="adicionarElemento('fin');">
                         <i class="large material-icons">add</i>
                    </a>
                    <div class="content" id="fin">
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var arquivo = document.getElementById("data");
                arquivo.addEventListener("change", function (event) {
                    if (arquivo.files.length == 0) {
                    Materialize.toast('Nenhum Arquivo Selecionado', 4000)
                    return;
                    }
                
                    upload();
                });
            });        
        </script>
    </body>
  </html>