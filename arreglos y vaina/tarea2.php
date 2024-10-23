<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
</head>
<body>
    <h1>Estructura de datos</h1>
    <h2>Arreglos</h2>
    <?php
// Inicializar el arreglo
$frutas = isset($_POST['frutas']) ? explode(',', $_POST['frutas']) : array("Manzanas", "Cambur", "Fresa", "Cerezas");
// Agregar fruta
if (isset($_POST['nueva_fruta'])) {
    array_push($frutas, $_POST['nueva_fruta']);
}
// Eliminar fruta
if (isset($_POST['eliminar_fruta'])) {
    $key = array_search($_POST['eliminar_fruta'], $frutas);
    if ($key !== false) {
        unset($frutas[$key]);
    } else {
        print("<br>No se encuentra esa fruta<br>");
    }
}
// Mostrar arreglo
print("Contenido del arreglo:<br>");
print_r($frutas);
?>
<form method="post">
    <input type="text" name="nueva_fruta" placeholder="Nueva fruta">
    <button type="submit">Agregar Fruta</button>
    <input type="text" name="eliminar_fruta" placeholder="Eliminar fruta">
    <button type="submit">Eliminar Fruta</button>
    <input type="hidden" name="frutas" value="<?php echo implode(',', $frutas); ?>">
</form>
    <h2>Pilas</h2>
    <?php 
// Inicializar la pila
$pila = isset($_POST['pila']) ? explode(',', $_POST['pila']) : array("Elemento 1", "Elemento 2", "Elemento 3", "Elemento 4");
// Agregar elemento a la pila
if (isset($_POST['nuevo_elemento']) && !empty($_POST['nuevo_elemento'])) {
    array_push($pila, $_POST['nuevo_elemento']);
}
// Sacar elemento de la pila
if (isset($_POST['sacar_elemento'])) {
    if (!empty($pila)) {
        $elemento = array_pop($pila);
        echo "Último elemento sacado de la pila: " . $elemento . "<br>";
    } else {
        echo "La pila está vacía. No se puede sacar un elemento.<br>";
    }
}
// Mostrar pila
echo "Contenido de la pila:<br>";
print_r($pila);
?>
<form method="post">
    <input type="text" name="nuevo_elemento" placeholder="Nuevo elemento">
    <button type="submit">Agregar Elemento</button>
    <button type="submit" name="sacar_elemento">Sacar Elemento</button>
    <input type="hidden" name="pila" value="<?php echo implode(',', $pila); ?>">
</form>
    <h2>Colas</h2>
    <?php
    // Inicializar la cola
    $cola = isset($_POST['cola']) ? explode(',', $_POST['cola']) : array("Cliente 1","Cliente 2","Cliente 3");
    // Agregar cliente a la cola
    if (isset($_POST['nuevo_cliente'])) {
        array_push($cola, $_POST['nuevo_cliente']);
    }
    // Sacar cliente de la cola
    if (isset($_POST['sacar_cliente'])) {
        $cliente = array_shift($cola);
        echo "Cliente sacado de la cola: " . $cliente . "<br>";
    }
    // Mostrar cola
    print("Clientes en la cola:<br>");
    print_r($cola);
    ?>
    <form method="post">
        <input type="text" name="nuevo_cliente" placeholder="Nuevo cliente">
        <button type="submit">Agregar Cliente</button>
        <button type="submit" name="sacar_cliente" value="1">Sacar Cliente</button>
        <input type="hidden" name="cola" value="<?php echo implode(',', $cola); ?>">
    </form>

    <h2>Listas</h2>
    <?php
    // Inicializar lista asociativa
    $edades = isset($_POST['edades']) ? json_decode($_POST['edades'], true) : array(
        "Juan" => 25,
        "María" => 30,
        "Pedro" => 35,
        "Ana" => 40
    );

    // Agregar a la lista
    if (isset($_POST['nuevo_nombre']) && isset($_POST['nueva_edad'])) {
        $edades[$_POST['nuevo_nombre']] = $_POST['nueva_edad'];
    }
    // Eliminar de la lista
    if (isset($_POST['eliminar_nombre'])) {
        unset($edades[$_POST['eliminar_nombre']]);
    }
    // Mostrar lista
    foreach ($edades as $nombre => $edad) {
        echo "La edad de $nombre es $edad años.<br>";
    }
    ?>
    <form method="post">
        <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre">
        <input type="text" name="nueva_edad" placeholder="Nueva edad">
        <button type="submit">Agregar</button>
        <input type="text" name="eliminar_nombre" placeholder="Eliminar nombre">
        <button type="submit">Eliminar</button>
        <input type="hidden" name="edades" value='<?php echo json_encode($edades); ?>'>
    </form>
    <h2>Árboles</h2>
    <?php
class Nodo2 {
    public $dato;
    public $izquierda;
    public $derecha;

    public function __construct($dato) {
        $this->dato = $dato;
        $this->izquierda = null;
        $this->derecha = null;
    }
}
class ArbolBinario {
    public $raiz;
    public function __construct() {
        $this->raiz = null;
    }
    public function insertar($dato) {
        $nuevoNodo = new Nodo2($dato);
        if ($this->raiz === null) {
            $this->raiz = $nuevoNodo;
        } else {
            $this->insertarNodo($this->raiz, $nuevoNodo);
        }
    }
    private function insertarNodo($nodo, $nuevoNodo) {
        if ($nuevoNodo->dato < $nodo->dato) {
            if ($nodo->izquierda === null) {
                $nodo->izquierda = $nuevoNodo;
            } else {
                $this->insertarNodo($nodo->izquierda, $nuevoNodo);
            }
        } else {
            if ($nodo->derecha === null) {
                $nodo->derecha = $nuevoNodo;
            } else {
                $this->insertarNodo($nodo->derecha, $nuevoNodo);
            }
        }
    }
    public function imprimir($nodo) {
        if ($nodo !== null) {
            $this->imprimir($nodo->izquierda);
            echo $nodo->dato . " ";
            $this->imprimir($nodo->derecha);
        }
    }
}
$arbol = new ArbolBinario();
$arbol->insertar(10);
$arbol->insertar(5);
$arbol->insertar(15);
$arbol->insertar(3);
$arbol->insertar(7);
$arbol->insertar(12);
$arbol->insertar(18);
$arbol->imprimir($arbol->raiz);
?>
    <h2>Grafos</h2>
    <?php
    $grafo = isset($_POST['grafo']) ? json_decode($_POST['grafo'], true) : array(
        "A" => array("B", "C"),
        "B" => array("C"),
        "C" => array("A"),
        "D" => array("B")
    );
    // Agregar a la lista
    if (isset($_POST['nuevo_letra']) && isset($_POST['nueva_relacion'])) {
        $nueva_relacion = explode(',', $_POST['nueva_relacion']);
        $grafo[$_POST['nuevo_letra']] = array_map('trim', $nueva_relacion); 
    }
    // Eliminar de la lista
    if (isset($_POST['eliminar_letra'])) {
        unset($grafo[$_POST['eliminar_letra']]);
    }
    // Mostrar lista
    foreach ($grafo as $letra => $relaciones) {
        echo "$letra => " . implode(", ", $relaciones) . ".<br>";
    }
    ?>
    <form method="post">
        <input type="text" name="nuevo_letra" placeholder="Nueva letra">
        <input type="text" name="nueva_relacion" placeholder="Nueva relación (separar por comas)">
        <button type="submit">Agregar Relación</button>
        <input type="text" name="eliminar_letra" placeholder="Eliminar letra">
        <button type="submit">Eliminar Letra</button>
        <input type="hidden" name="grafo" value="<?php echo htmlspecialchars(json_encode($grafo)); ?>">
</body>
</html>