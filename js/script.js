$(document).ready(function() {
    $(".cancelar").fadeOut(0);
    $('.modal').modal();
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {dados : true},
        success: function (data) {
            switch(data){
                case "":
                    break;
                default:{
                    usuario = $.parseJSON(data);
                    padraoLogin(usuario);
                    $("#fotoperfil").empty().css("background", "url('"+usuario.img+"') center no-repeat");
                    $("#fotoperfil").css("background-size", "100%");
                    $("#namePerfil").empty().append(usuario.nome);
                }
                
            }
        },
        error: function (e) {

            Materialize.toast('Houve um erro! Tente novamente.', 4000);

        }
    });
    carregarProjeto();
    $(".box").click(function(){
        $('.fixed-action-btn').closeFAB();
    });
    $("#cadastrar").fadeOut(0);
});
var verificadorLgn = false;
function mudar(){
    if(verificadorLgn==false){
        $("#cadastrar").fadeIn(500);
        $("#logar").slideUp("slow");
        verificadorLgn = true;
    }else{
        $("#cadastrar").fadeOut(500);
        $("#logar").slideDown("slow");
        verificadorLgn = false;
    }
}
async function carregarProjeto(){
    var id = await $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {projectid : true},
        success: function (data) {
            return data;
        }
    });
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {project : id},
        success: function (data) {
            if(data!="" || data!=null){
                var projeto = $.parseJSON(data);
                project.id = projeto.id;
                project.nome = projeto.nome;
                project.json = projeto.json;
                project.user = projeto.user;
                $("#titleproject").val(project.nome);
                listar(project.json);
            }
        }
    });
}
var valor = 0;
var verificador = true;
var valores = [];
var div = "";
var usuario = {status:false};
var project = {id: null, nome: "Projeto sem título", json: "[]", user: ""};
function adicionarElemento(divEsc){
    if(verificador==true){
        valor++;
        verificador = false;
        $(".addInput").remove();
        div = divEsc;
        $("#"+divEsc).append("<div class='addInput'><div class='row'><input placeholder='Adicionar um valor' id='val' type='text' class='valores col l10 m10 s10 val'><a class='waves-effect waves-light btn col l2 m2 s2 transparent z-depth-0 doneVal' onclick='saveVal("+valor+","+divEsc+")'><i class='material-icons center'>done</i></a></div></div>");
        $(".val").focus();
    }else{
        $(".addInput").remove();
        $("#"+divEsc).append("<div class='addInput'><div class='row'><input placeholder='Adicionar um valor' id='val' type='text' class='valores col l10 m10 s10 val'><a class='waves-effect waves-light btn col l2 m2 s2 transparent z-depth-0 doneVal' onclick='saveVal("+valor+","+divEsc+")'><i class='material-icons center'>done</i></a></div></div>");
        $(".val").focus();
        verificador = true;
    }
}
function saveVal(val, divEsc){
    var conteudo = $(".val").val();
    if(conteudo!=""){
        $(".addInput").remove();
        $(divEsc).append("<div id='chip"+val+"' class='itens'>"+conteudo+"<i class='close material-icons right' onclick='remover("+val+")'>close</i></div>");
        verificador = 0;
        var valor = new Object();
        valor.id = val;
        valor.conteudo = conteudo;
        valor.div = div;
        valores.push(valor);
    }else{
        Materialize.toast('Informe um valor!', 4000);
    }
}
function login(){
    if(usuario.status){
        $(location).attr('href', 'perfil');
    }else{
        $('#modal1').modal("open");
        $('#login').each (function(){
        this.reset();
        });
        $("#user").focus();
    }
}
function remover(val){
    let index = $.map( valores, function(i) {
        if(i.id==val){
            return i.id;
        }
      });
      valores.splice(index,1);
    $("#chip"+val).remove();
}
function imprimir(){
    window.print();
}
function selecionar(){
    $("#data").click();
}
function upload(){
    $("#eco").empty();
    $("#esc").empty();
    $("#val").empty();
    $("#men").empty();
    $("#hab").empty();
    $("#eng").empty();
    $("#ben").empty();
    $("#bar").empty();
    $("#fin").empty();

    // Get form
    var form = $('#fileUploadForm')[0];

    // Create an FormData object 
    var data = new FormData(form);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "data/json.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            listar(data);
        },
        error: function (e) {

            Materialize.toast('Houve um erro! Tente novamente.', 4000);

        }
    });
}
function listar(data){
    if(data!="" || data != null){
        var valoresMap = $.parseJSON(data);
        valores = valoresMap;
        $.map( valoresMap, function(i) {
            $("#"+i.div).append("<div id='chip"+i.id+"' class='itens'>"+i.conteudo+"<i class='close material-icons right' onclick='remover("+i.id+")'>close</i></div>")
        });
    }
}
function exportar(){
    data = "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(valores));
    var a = document.createElement("a");
    document.body.appendChild(a);
    a.style = "display: none";
    a.href = 'data:' + data ;
    a.download = $("#titleproject").val()+".gabi";
    a.click();
}
function padraoLogin(usuario){
    $(".floatingLoginBtn").append('<li><a class="btn-floating purple darken-3" onclick="save();" title="Salvar"><i class="material-icons">save</i></a></li>');
}
function criar(){
    var nameP = $("#newProject").val();
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {newProject : nameP},
        success: function (data) {
            switch(data){
                case "false":
                    Materialize.toast('Houve um erro! Tente novamente.', 4000);
                    break;
                case "true":
                    Materialize.toast('Já existe um projeto com esse nome!', 4000);
                    break;
                default:{
                    project.nome = data;
                    $(location).attr('href', 'inicio.php');
                }
                
            }
        },
        error: function (e) {

            Materialize.toast('Houve um erro! Tente novamente.', 4000);

        }
    });
}
function abrirProjeto(id){
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {project : id},
        success: function (data) {
            $(location).attr('href', 'inicio.php');
        },
        error: function (e) {

            Materialize.toast('Houve um erro! Tente novamente.', 4000);

        }
    });
}
function save(){
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {salvar: project.id, nome: $("#titleproject").val(), json: JSON.stringify(valores), user: usuario.user},
        success: function (data) {
            switch (data){
                case "false":
                    Materialize.toast('Houve um erro! Tente novamente.', 4000);
                    break;
                case "true":
                    Materialize.toast('Já existe um projeto com esse nome!', 4000);
                    break;
                case "ok":
                    Materialize.toast('Salvo com sucesso.', 4000);
                    break;
                default:
                    Materialize.toast('Houve um erro! Tente novamente.', 4000);
            }
        },
        error: function (e) {

            Materialize.toast('Houve um erro! Tente novamente.', 4000);

        }
    });
}
function cadastrar(){
    var user = $("#newuser").val();
    var senha = $("#newsenha").val();
    var senha2 = $("#newsenha2").val();
    var email = $("#newemail").val();
    if(user=="" || senha =="" || senha2=="" || email == ""){
        Materialize.toast('Preencha todos os dados!', 4000);
    }else if(senha!=senha2){
        Materialize.toast('As senhas não são iguais!', 4000);
    }else if(senha.length<8){
        Materialize.toast('Senhas acima de 8 caracteres!', 4000);
    }else if(!isEmail(email)){
        Materialize.toast('Informe um e-mail válido!', 4000);
    }else{
        $.ajax({
            type: 'POST',
            url: 'data/data.php',
            data: {usercad : user, senhacad: senha, email: email},
            success: function (data) {
                switch (data){
                    case "email":
                        Materialize.toast('E-mail já cadastrado!', 4000);
                        break;
                    case "user":
                        Materialize.toast('Nome de usuário indisponível!', 4000);
                        break;
                    case "true":{
                        Materialize.toast('Cadastrado com sucesso!', 4000);
                        logar(user, senha);
                    }
                        break;
                    case "false":
                        Materialize.toast('Houve um erro! Tente novamente.', 4000);
                        break;
                }
            },
            error: function (e) {
    
                Materialize.toast('Houve um erro! Tente novamente.', 4000);
    
            }
        });
    }
        
}
function logar(user, senha){
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {user : user, senha: senha},
        success: function (data) {
            if(data=="true"){
                $(location).attr('href', 'perfil');
            }else{
                Materialize.toast('Houve um erro! Tente novamente.', 4000);
            }
        },
        error: function (e) {
            Materialize.toast('Houve um erro! Tente novamente.', 4000);
        }
    });
}
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function excluir(){
    $(".cancelar").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {boxAll: true},
        success: function (data) {
            $("#boxAll").empty().append(data);
        },
        error: function (e) {
            Materialize.toast('Houve um erro! Tente novamente.', 4000);
        }
    });
  }
  var idEx = 0;
  function exluirProjeto(id){
      idEx = id;
      $('#modal2').modal('open');
  }
  function remover(){
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {excluir: idEx},
        success: function (data) {
            switch(data){
                case "true":{
                    Materialize.toast('Exclusão realizada com sucesso!', 4000);
                    listarProjetos();
                    $('#modal2').modal('close');
                    break;
                }
                case "false":
                    Materialize.toast('Houve um erro! Tente novamente.', 4000);
                    break;
                default:
                    Materialize.toast('Houve um erro! Tente novamente.', 4000);
            }
        },
        error: function (e) {
            Materialize.toast('Houve um erro! Tente novamente.', 4000);
        }
    });
  }
  function fechar(){
    $('#modal2').modal('close');
  }
  function listarProjetos(){
    $(".cancelar").fadeOut(500);
    $.ajax({
        type: 'POST',
        url: 'data/data.php',
        data: {boxAll2: true},
        success: function (data) {
            $("#boxAll").empty().append(data);
        },
        error: function (e) {
            Materialize.toast('Houve um erro! Tente novamente.', 4000);
        }
    });
  }