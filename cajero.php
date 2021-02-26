<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="style.css" rel="stylesheet" id="bootstrap-css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>

<head>
<title>Bienvenido al ATM Síclo</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<!--Coded with love by Mutiullah Samim-->
<body>
<div class="container h-100">
<div class="d-flex justify-content-center h-100">
<div class="user_card">
<div class="d-flex justify-content-center">
<div class="brand_logo_container">
<img src="images/siclo-logo-negative.svg" class="brand_logo" alt="Logo">
</div>
</div>
<div class="justify-content-center form_container">
<h2 class="content-center">ATM by Síclo</h2>
<h6 class="content-center regresaInicio" onclick="location.reload();">Regresar al inicio</h6>
<div id="panelTipoCuenta" class="panelTipoCuenta" >
<div class="input-group mb-3">
<h5>Seleccione un tipo de cuenta</h5>
<select class="form-control" name="selectTipoCuenta" id="selectTipoCuenta" onchange="seleccionaTarjeta()">
<option class="form-control" disabled="disabled" selected="selected">Seleccione una opción</option>
<option class="form-control" value="1">Débito</option>
<option class="form-control" value="2">Crédito</option>
</select>
</div>
</div>

<div id="panelSeleccionaCuenta" class="panelSeleccionaCuenta" style="display: none;">
<div class="input-group mb-3">
<h5>Seleccione una cuenta</h5>
<select class="form-control" name="selectCuenta" id="selectCuenta" onchange="seleccionaCuenta()">
<option class="form-control" disabled="disabled" selected="selected">Seleccione una opción</option>
</select>
</div>
</div>

<div id="panelDeCuenta" class="panelDeCuenta" style="display: none;">
<h4 class="content-center margin-bot">Seleccione la operación a realizar</h4>
<h6 class="content-center margin-bot">Para cancelar, quite la selección de la casilla</h6>
<div class="input-group mb-3">
<div class="input-group-append">
<span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
</div>
<h5>Depósito</h5>
<input class="form-control" type="checkbox" name="check" id="check" value="1" onchange="showContent(1)" />
</div> 

<div id="content" style="display: none;">
    Ingresa el Depósito a Realizar<input type="text" name="valor1" id="valor1" class="form-control">
<br>
<input class="btn login_btn" onclick="depositar()" name="cmdgrabar" value="Enviar">
<br><br><br>
</div>

<div class="input-group mb-3">
<div class="input-group-append">
<span class="input-group-text"><i class="fas fa-coins"></i></span>
</div>
<h5>Retiro</h5>
<input class="form-control"  type="checkbox" name="check2" id="check2" value="1" onchange="showContent(2)" />
</div> 

<div id="conten" style="display: none;">
    Ingresa el retiro a Realizar<br>
    <b id="mensajeRetiroCredito" style="display: none;" >Recuerda que el retirar de tu cuenta de crédito genera una comisión del 10%.</b>
    <input type="text" name="valor2" id="valor2" class="form-control">
 
    <br>
<input class="btn login_btn"  name="cmdgabar2"  value="Retirar" onclick="retirar()">


<br><br><br>
</div>

<div class="d-flex justify-content-center mt-3 login_container"></div>
</div>

</div>
</div>
</div>
</div>
</body>
</html>


<script type="text/javascript">
function showContent(tipo) 
{
if(tipo==1)
{
element = document.getElementById("content");
check = document.getElementById("check");
if (check.checked) 
{
element.style.display='block';
}
else 
{
element.style.display='none';
}   
}
else if(tipo==2)
{
element = document.getElementById("conten");
check2 = document.getElementById("check2");
if (check2.checked) 
{
element.style.display='block';
if($('#selectTipoCuenta').val()==2)
{
$('#mensajeRetiroCredito').css('display','block');
}
}
else 
{
element.style.display='none';
}
}
}
 

function seleccionaTarjeta()
{
$('#panelTipoCuenta').css('visibility','hidden');
$('#panelSeleccionaCuenta').css('display','block');
var tipoCuentaSelect = $('#selectTipoCuenta').val();

$.ajax({
  url: 'backend.php',
  type: 'post',
  data: {obtiene_cuentas:'true',tipoCuenta: tipoCuentaSelect},
  success: function(response){
  console.log(response);
try 
  {
        var obj = JSON.parse(response);
        for (const val of obj) {
            $('#selectCuenta').append($(document.createElement('option')).prop({
              value: val.id,
              text: val.id
            }))
        }   
    } 
    catch (e) {
        alert('No tiene aún cuentas de este tipo');
    }
    return true;  
  }
});
}

function seleccionaCuenta()
{
$('#panelSeleccionaCuenta').css('visibility','hidden');
$('#panelDeCuenta').css('display','block');
}

function depositar()
{
var cantidadDepositada = $('#valor1').val();
var cuentaSeleccionada = $('#selectCuenta').val();
var tipoCuentaSeleccionada = $('#selectTipoCuenta').val();

$.ajax({
  url: 'backend.php',
  type: 'post',
  data: {check:'true',value1: cantidadDepositada,cuenta: cuentaSeleccionada,tipoCuenta: tipoCuentaSeleccionada},
  success: function(response){
  alert(response);
  location.reload();
  }
});
}

function retirar()
{
var cantidadRetirada = $('#valor2').val();
var cuentaSeleccionada = $('#selectCuenta').val();
var tipoCuentaSeleccionada = $('#selectTipoCuenta').val();

$.ajax({
  url: 'backend.php',
  type: 'post',
  data: {check2:'true',value2: cantidadRetirada,cuenta: cuentaSeleccionada,tipoCuenta: tipoCuentaSeleccionada},
  success: function(response){
  alert(response);
  location.reload();
  }
});
}
</script>


