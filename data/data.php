<?php
    session_start();
    if(isset($_POST['dados']) && isset($_SESSION["login"])){
        $usuario = unserialize($_SESSION["login"]);
        echo json_encode($usuario);
    }
    if(isset($_POST['newProject'])){
        include('../include/conexao.php');
        $nomeP = $_POST['newProject'];
        $usuario = unserialize($_SESSION["login"]);
        $json = json_encode($usuario);
        $obj = json_decode($json);
        $nUser = $obj->user;
        $jsonArr = [];
        $jsonbd = json_encode($jsonArr);
        $sql2 = "SELECT * FROM projetos WHERE nome = '$nomeP' AND user = '$nUser'";
        $rows2 = mysqli_num_rows(mysqli_query($con, $sql2));
        if($rows2>0){
            echo "true";
        }else{
            $sql = "INSERT INTO projetos VALUES (null, '$nomeP', '$jsonbd', '$nUser')";
            if(mysqli_query($con, $sql)){
                $_SESSION["project"] = mysqli_insert_id($con);
            }else{
                echo "false";
            }
        }
    }
    if(isset($_POST['project'])){
        $id = $_POST['project'];
        $_SESSION["project"] = $id;
        if($_POST['project']==null){
            $projeto = new stdClass();
            $projeto->id = null;
            $projeto->nome = "Projeto sem título";
            $projeto->json = "[]";
            $projeto->user = null;
            $_SESSION["project"] = null;
            echo json_encode($projeto);
        }else{
            if(isset($_SESSION["project"]) && isset($_SESSION["login"])){
                include("../include/conexao.php");
                $sql3 = "SELECT id, nome, jsonProject, user FROM projetos WHERE id = '$id' LIMIT 1";
                $query3 = mysqli_query($con, $sql3);
                $rows3 = mysqli_num_rows($query3);
                if($rows3>0){
                    $projeto = new stdClass();
                    while($res = mysqli_fetch_array($query3)){
                        $projeto->id = $res[0];
                        $projeto->nome = $res[1];
                        $projeto->json = $res[2];
                        $projeto->user = $res[3];
                    }
                    $_SESSION["project"] = $id;
                    echo json_encode($projeto);
                }
            }else{
                $projeto = new stdClass();
            $projeto->id = null;
            $projeto->nome = "Projeto sem título";
            $projeto->json = "[]";
            $projeto->user = null;
            $_SESSION["project"] = null;
            echo json_encode($projeto);
            }
        }
    }if(isset($_POST['projectid'])){
        if(isset($_SESSION["project"])){
            echo $_SESSION["project"];
        }else{
            echo null;
        }
    }
    if(isset($_POST['salvar'])){
        include("../include/conexao.php");
        $id = $_POST['salvar'];
        $nome = $_POST['nome'];
        $json = $_POST['json'];
        $user = $_POST['user'];
        if($id=="" || $id == null){
            $sql = "SELECT * FROM projetos WHERE nome = '$nome'";
            $rows = mysqli_num_rows(mysqli_query($con,$sql));
            if($rows>0){
                echo "true";
            }else{
                $sql2 = "INSERT INTO projetos VALUES (null, '$nome', '$json','$user')";
                if(mysqli_query($con,$sql2)){
                    echo "ok";
                }else{
                    echo "false";
                }
            }
        }else{
            $idProject = $_SESSION["project"];
            $sql = "SELECT * FROM projetos WHERE nome = '$nome' AND id != '$idProject'";
            $rows = mysqli_num_rows(mysqli_query($con,$sql));
            if($rows>0){
                echo "true";
            }else{
                $sql2 = "UPDATE projetos SET nome = '$nome', jsonProject = '$json' WHERE id = '$id'";
                if(mysqli_query($con,$sql2)){
                    echo "ok";
                }else{
                    echo "false";
                }
            }
        }
    }
    if(isset($_POST['user']) && isset($_POST['senha'])){
        $user = md5($_POST['user']);
        $senha = md5($_POST['senha']);
        include('../include/conexao.php');
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
            echo "true";
        }
    }
    if(isset($_POST['usercad'])){
        include("../include/conexao.php");
        $nome = $_POST['usercad'];
        $user = md5($_POST['usercad']);
        $senha = md5($_POST['senhacad']);
        $email = $_POST['email'];
        $sql = "SELECT * FROM usuarios WHERE user = '$user'";
        $sql2 = "SELECT * FROM usuarios WHERE email = '$email'";
        $rows  = mysqli_num_rows(mysqli_query($con, $sql));
        $rows2  = mysqli_num_rows(mysqli_query($con, $sql2));
        if($rows>0){
            echo "user";
        }else if($rows2>0){
            echo "email";
        }else{
            $sql3 = "INSERT INTO usuarios VALUES (null, '$user', '$senha', '$nome', '$email', 'img/perfil.png')";
            if(mysqli_query($con,$sql3)){
                echo "true";
            }else{
                echo "false";
            }
        }
    }
    if(isset($_POST['boxAll'])){
        $usuario = unserialize($_SESSION["login"]);
                    
        include('../include/conexao.php');
        $sql = "SELECT nome, id FROM projetos WHERE user = '$usuario->user'";
        $query = mysqli_query($con, $sql);
        $rows = mysqli_num_rows($query);
        echo '<div class="boxP">
            <a class="btn-flat waves-effect waves-darken white lighten-1 boxProject modal-trigger" id="addP" href="#modal1" title="Criar novo projeto"><i class="material-icons black-text icon-project">add</i></a>
            <br>
            <label for="addP" class="labelP">Novo projeto</label>
        </div>';
        if($rows>0){
            
            while($res = mysqli_fetch_array($query)){
                echo '<div class="boxP" onclick="exluirProjeto('.$res[1].')">
                <a class="btn-flat waves-effect waves-light red lighten-4 boxProject2" title="'.$res[0].'"><i class="material-icons red-text icon-project2">delete</i></a>
                <br>
                <label class="labelP">'.$res[0].'</label>
            </div>';
            }
        }
    }
    if(isset($_POST['boxAll2'])){
        $usuario = unserialize($_SESSION["login"]);
                    
        include('../include/conexao.php');
        $sql = "SELECT nome, id FROM projetos WHERE user = '$usuario->user'";
        $query = mysqli_query($con, $sql);
        $rows = mysqli_num_rows($query);
        $cores = ["green", "red","yellow", "blue"];
        echo '<div class="boxP">
            <a class="btn-flat waves-effect waves-darken white lighten-1 boxProject modal-trigger" id="addP" href="#modal1" title="Criar novo projeto"><i class="material-icons black-text icon-project">add</i></a>
            <br>
            <label for="addP" class="labelP">Novo projeto</label>
        </div>';
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
    if(isset($_POST['excluir'])){
        include("../include/conexao.php");
        $idEx = $_POST['excluir'];
        $sql5 = "DELETE FROM projetos WHERE id='$idEx'";
        $_SESSION["project"] = null;
        if(mysqli_query($con, $sql5)){
            echo "true";
        }else{
            echo "false";
        }
    }
?>