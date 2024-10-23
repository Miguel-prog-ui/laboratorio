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
    $frutas = array("Manzanas", "Cambur","Fresa","Cerezas");
    print_r($frutas)
    ?>
    <h2>Pilas</h2>
    <?php
    //Pilas es ultimo en entrar primero en salir
    //push (agregar elemento) y pop(eliminar elemento)
    $pila= array();
    // Poner elemento
    array_push($pila,"Elemento 1");
    array_push($pila,"Elemento 2");
    array_push($pila,"Elemento 3");
    array_push($pila,"Elemento 4");
    array_push($pila,"Elemento 5");
    array_push($pila,"Elemento 6");
    print("Antes de sacar el elemento<br>");
    print_r($pila);
    echo "<br>";
    //Sacar elemento
    $elemento = array_pop($pila);
    print("Despues de sacar el elemento<br>");
    print_r($pila);
    echo "<br>Ultimo elemento sacado de la pila: ".$elemento;
    ?>
    <h2>Colas</h2>
    <?php
    //primero en entrar primero en salir
    //enqueue (añadir un elemento) y dequeue (eliminar el primer elemento añadido)
    $cola=array();
    array_push($cola,"Cliente 1");
    array_push($cola,"Cliente 2");
    array_push($cola,"Cliente 3");
    array_push($cola,"Cliente 4");
    array_push($cola,"Cliente 5");
    print("Todos los clientes en la cola<br>");
    print_r($cola);
    echo "<br>";
    $cliente=array_shift($cola);
    print("Ya paso el primer cliente<br>");
    print_r($cola);
    echo "<br>Primer cliente fuera de la cola es: ".$cliente;
    ?>
    <h2>Listas</h2>
    <?php
    //estructura de datos flexibles que permite la insercion y eliminacion de elementos
    $lista = array ("Frutas","Huevos","Vegetales");
    print_r($lista);
    ?>
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
   //modelan relaciones entre entidades
class Grafo{
    public $vertices;
    public $aristas;
    public function __construct(){
        $this->vertices=array();
        $this->aristas=array();
    }
    public function agregar_vertices($vertice){
        $this->vertices[]=$vertice;
        $this->aristas[$vertice]=array();
    }
    public function aregar_aristas($vertice1,$vertice2){
        $this->aristas[$vertice1][]=$vertice2;
        $this->aristas[$vertice2][]=$vertice1;

    }
    public function imprimir_grafo(){
        foreach($this->vertices as $vertices){
            echo $vertices. "->";
        foreach($this->aristas[$vertices] as $item){
            echo $item." ";
        }
        echo "<br>";
        }
    }
}
    $migrafo= new Grafo();
    $migrafo->agregar_vertices("A");
    $migrafo->agregar_vertices("B");
    $migrafo->agregar_vertices("C");
    $migrafo->agregar_vertices("D");
    $migrafo->aregar_aristas("A","B");
    $migrafo->aregar_aristas("B","C");
    $migrafo->aregar_aristas("C","A");
    $migrafo->aregar_aristas("B","D");
    echo "Grafo resultante<br>";
    $migrafo->imprimir_grafo();
    ?>
</body>
</html>