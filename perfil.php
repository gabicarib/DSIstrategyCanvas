<?php
    session_start();
    if(isset($_POST['user']) && isset($_POST['senha'])){
        $user = md5($_POST['user']);
        $senha = md5($_POST['senha']);
        include('include/conexao.php');
        $sql = "SELECT urlFoto, nome FROM usuarios WHERE user = '$user' AND pass = '$senha'";
        $query = mysqli_query($con, $sql);
        $rows = mysqli_num_rows($query);
        if($rows>0){
            $usuario = new stdClass();
            $usuario->status = true;
            $usuario->user = $user;
            while($res = mysqli_fetch_array($query)){
                $usuario->img = $res[0];
                $usuario->nome = $res[1];
            }
            $_SESSION["login"] = serialize($usuario);
        }else{
            unset($_SESSION["login"]);

            Header("Location: inicio.php");
        }
    }else{
        if(!(isset($_SESSION["login"]) || $_SESSION["login"].status == true)){
            Header("Location: inicio.php");
        }
    }
?>
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
        <a class="btn-floating red cancelar" title="Cancelar" onclick="listarProjetos()"><i class="material-icons white-text">close</i></a>
        <a class="waves-effect waves-light btn-flat" href="inicio"><i class="material-icons left">arrow_back</i>Voltar</a>
        <a class="dropdown-button waves-effect waves-light" id="conf" href="#!" data-activates="dropdown1"><i class="material-icons right black-text">settings</i></a>
        <ul id="dropdown1" class="dropdown-content">
            <div id="fotoperfil"></div>
            <label for="fotoperfil" id="namePerfil">Carlos</label>
            <li><a href="#" class="grey-text" onclick="excluir();">Excluir projetos <i class="material-icons grey-text right">delete</i></a></li>
            <li class="divider"></li>
            <li><a href="logout" class="grey-text">Sair <i class="material-icons grey-text right">power_settings_new</i></a></li>
        </ul>
        <div id="modal1" class="modal">
            <div class="modal-content">
            <h4>Novo projeto</h4>
                <div class="row">
                    <div class="input-field col l12 m12 s12">
                        <input placeholder="Nome do projeto" id="newProject" name="newProject" type="text" class="validate" required>
                    </div>
                </div>
                <div class="row">
                    <button class="btn waves-effect waves-light right teal darken-2" type="button" name="action" onclick="criar();">Criar
                        <i class="material-icons right">arrow_forward</i>
                    </button>
                </div>
            </div>
        </div>
        <div id="modal2" class="modal">
            <div class="modal-content">
            <h5>Realmente deseja excluir esse projeto ?</h5>
            <br>
            <br>
                <div class="row">
                    <button class="btn waves-effect waves-light right teal col l4 s4 m4 lighten-1 right" type="button" name="action" onclick="remover();">Sim
                        <i class="material-icons right">done</i>
                    </button>
                    <button class="btn waves-effect waves-light right red col l4 s4 m4 pull-m4 pull-s4 pull-l4 lighten-2 left" type="button" name="action" onclick="fechar();">Não
                        <i class="material-icons left">close</i>
                    </button>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <div class="container">
            <div class="row" id="boxAll">
                <div class="boxP">
                    <a class="btn-flat waves-effect waves-darken white lighten-1 boxProject modal-trigger" id="addP" href="#modal1" title="Criar novo projeto"><i class="material-icons black-text icon-project">add</i></a>
                    <br>
                    <label for="addP" class="labelP">Novo projeto</label>
                </div>
                <?php
                    if(isset($_SESSION["login"])){
                        $usuario = unserialize($_SESSION["login"]);
                    
                        include('include/conexao.php');
                        $sql = "SELECT nome, id FROM projetos WHERE user = '$usuario->user'";
                        $query = mysqli_query($con, $sql);
                        $rows = mysqli_num_rows($query);
                        $cores = ["green", "red","yellow", "blue"];
                        if($rows>0){
                            while($res = mysqli_fetch_array($query)){
                                $cor = rand (0 , count($cores)-1 );
                                echo '<div class="boxP" onclick="abrirProjeto('.$res[1].')">
                                <a class="btn-flat waves-effect waves-light '.$cores[$cor].' lighten-4 boxProject2" title="'.$res[0].'"><i class="material-icons '.$cores[$cor].'-text icon-project2">apps</i></a>
                                <br>
                                <label class="labelP">'.$res[0].'</label>
                            </div>';
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <img src="img/background.png" alt="" class="back">
    </body>
  </html>