<?php

$saldo = 0;
$mysqli = mysqli_connect("localhost", "root", "", "siclo_atm");

if (!$mysqli) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


$jsonDataCuentas = array();
  //Consultar cuentas
if(isset($_POST['obtiene_cuentas']))
{
// Debito
if($_POST['tipoCuenta']==1)
{
$cuentas = $mysqli->query("SELECT * FROM cuentas_debito");
}
else if($_POST['tipoCuenta']==2)
{
$cuentas = $mysqli->query("SELECT * FROM cuentas_credito");
}

while ($row = mysqli_fetch_assoc($cuentas)) {
    $jsonDataCuentas[] = $row;
}
if (!empty($jsonDataCuentas)) 
{
    echo json_encode($jsonDataCuentas);
}
else
{
echo 'var es o bien 0, vacía, o no se encuentra definida en absoluto';
exit();
}
}
// Retirar
if(isset($_POST['check2']))
{
$num2 = $_POST['value2'];
// Cuenta de débito
if($_POST['tipoCuenta']==1)
{
if ($enlace = $mysqli->query("SELECT * FROM cuentas_debito WHERE id=".$_POST['cuenta'])) 
{
    while ($fila = $enlace->fetch_row()) 
    {
        $saldo = $fila[2];
    }
    $enlace->close();
}

if($num2 > $saldo)
{
echo"Transacción inválida. Fondos insuficientes.";
exit();
}
else
{ 
$saldo = $saldo - $num2;
// Actualizar la tabla
$sql = ' UPDATE cuentas_debito SET saldo='.$saldo.' WHERE id='.$_POST['cuenta'];
if (mysqli_query($mysqli, $sql)) 
{
    echo "Retiro con éxito. La cantidad en su cuenta actual es: $saldo";
} 
else 
{
    echo "Error updating record: " . mysqli_error($mysqli);
}
}
}
// Cuenta de crédito
else if($_POST['tipoCuenta']==2)
{
// Consultar saldo de la cuenta seleccionada
if ($enlace = $mysqli->query("SELECT * FROM cuentas_credito WHERE id=".$_POST['cuenta'])) 
{
    while ($fila = $enlace->fetch_row()) 
    {
        $saldo = $fila[2];
        $limite = $fila[3];
    }
    $enlace->close();
}

// Sumar la comisión a la cantidad a retirar
$num2 = $num2 * 1.10;

// Sumar la cantidad a retirar, ya con comisión, al saldo final y comparar con el límite de crédito, para saber si puede o no realizar la operación
$saldoTemporal = $num2 + $saldo;
if($saldoTemporal > $limite)
{
echo "La operación no se puede realizar porque excede el límite de crédito";
}
else
{
// Sumar el saldo con lo retirado
$saldo = $saldo + $num2;
// Actualizar la tabla
$sql = ' UPDATE cuentas_credito SET saldo='.$saldo.' WHERE id='.$_POST['cuenta'];
if (mysqli_query($mysqli, $sql)) 
{
    echo "La cantidad en su cuenta actual es: $saldo";
} 
else 
{
    echo "Error updating record: " . mysqli_error($mysqli);
}
exit();
} 
}
}
// Depositar
else if(isset($_POST['check'])) 
{
$num1 = $_POST['value1'];
// Cuenta debito
if($_POST['tipoCuenta']==1)
{ 
// Consultar saldo de la cuenta seleccionada
if ($enlace = $mysqli->query("SELECT * FROM cuentas_debito WHERE id=".$_POST['cuenta'])) 
{
    while ($fila = $enlace->fetch_row()) 
    {
        $saldo = $fila[2];
    }
    $enlace->close();
}
// Sumar el saldo mas lo depositado
$saldo = $saldo + $num1;
// Actualizar la tabla
$sql = ' UPDATE cuentas_debito SET saldo='.$saldo.' WHERE id='.$_POST['cuenta'];
if (mysqli_query($mysqli, $sql)) 
{
    echo "La cantidad en su cuenta actual es: $saldo";
} 
else 
{
    echo "Error updating record: " . mysqli_error($mysqli);
}
exit();
} 
// Cuenta credito
else if($_POST['tipoCuenta']==2)
{
// Consultar saldo de la cuenta seleccionada
if ($enlace = $mysqli->query("SELECT * FROM cuentas_credito WHERE id=".$_POST['cuenta'])) 
{
    while ($fila = $enlace->fetch_row()) 
    {
        $saldo = $fila[2];
    }
    $enlace->close();
}
// Sumar el saldo mas lo depositado
$saldo = $saldo - $num1;
// Actualizar la tabla
$sql = ' UPDATE cuentas_credito SET saldo='.$saldo.' WHERE id='.$_POST['cuenta'];
if (mysqli_query($mysqli, $sql)) 
{
    echo "La cantidad en su cuenta actual es: $saldo";
} 
else 
{
    echo "Error updating record: " . mysqli_error($mysqli);
}
exit();
}     
   }
