<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Color de fondo suave */
            margin: 0;
            padding: 0;
        }
        .a {
            max-width: 900px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #000; /* Color negro */
            font-size: 2em; /* Tamaño de letra aumentado */
            margin-bottom: 20px;
        }
        h2 {
            color: #000; /* Color negro */
            font-size: 1.5em; /* Tamaño de letra aumentado */
            border-bottom: 2px solid #000; /* Línea negra */
            padding-bottom: 5px;
            margin-top: 20px;
        }
        pre {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .code-block {
            border-left: 4px solid #000; /* Línea negra */
            padding-left: 10px;
            margin: 10px 0;
        }
        .highlight {
            background-color: #ffd700;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="a">
        <h1>Estructura de datos</h1>
        
        <h2>Arreglos</h2>
        <?php
        // Declaración de un arreglo de frutas
        $frutas = array("Mangos", "Banana", "Uva", "Mora");
        // Impresión del contenido del arreglo en formato legible
        echo "<div class='code-block'><pre>";
        print_r($frutas);
        echo "</pre></div>";
        ?>

        
        <h2>Pilas</h2>
        <?php
        // Implementación de una pila
        $pila = array();
        // Añadir elementos a la pila
        array_push($pila, "Elemento A");
        array_push($pila, "Elemento B");
        array_push($pila, "Elemento C");
        array_push($pila, "Elemento D");
        array_push($pila, "Elemento E");
        array_push($pila, "Elemento F");
        // Impresión de la pila antes de sacar un elemento
        echo "<div class='code-block'><pre>";
        print("Antes de sacar el elemento<br>");
        print_r($pila);
        echo "<br>";
        // Sacar el último elemento de la pila
        $elemento = array_pop($pila);
        // Impresión de la pila después de sacar un elemento
        print("Despues de sacar el elemento<br>");
        print_r($pila);
        echo "<br>Ultimo elemento sacado de la pila: <span class='highlight'>" . $elemento . "</span>";
        echo "</pre></div>";
        ?>
        
        <h2>Colas</h2>
        <?php
        // Implementación de una cola
        $cola = array();
        // Añadir elementos a la cola
        array_push($cola, "Persona 1");
        array_push($cola, "Persona 2");
        array_push($cola, "Persona 3");
        array_push($cola, "Persona 4");
        array_push($cola, "Persona 5");
        // Impresión de todos los elementos en la cola
        echo "<div class='code-block'><pre>";
        print("Todos los clientes en la cola<br>");
        print_r($cola);
        echo "<br>";
        // Sacar el primer elemento de la cola
        $cliente = array_shift($cola);
        // Impresión de la cola después de que el primer cliente haya pasado
        print("Ya paso el primer cliente<br>");
        print_r($cola);
        echo "<br>Primer cliente fuera de la cola es: <span class='highlight'>" . $cliente . "</span>";
        echo "</pre></div>";
        ?>
        
        <h2>Listas</h2>
        <?php
        // Declaración de una lista
        $lista = array("Lácteos", "Granos", "Carnes");
        // Impresión de la lista en formato legible
        echo "<div class='code-block'><pre>";
        print_r($lista);
        echo "</pre></div>";
        ?>

        
        <h2>Árboles</h2>
        <?php
        // Clase Nodo
        class Nodo2 {
          public $dato;       // Valor almacenado en el nodo
         public $izquierda;  // Referencia al hijo izquierdo
         public $derecha;    // Referencia al hijo derecho
         public function __construct($dato) {
             $this->dato = $dato;       // Asigna el dato al nodo
             $this->izquierda = null;   // Inicializa la referencia izquierda como nula
             $this->derecha = null;     // Inicializa la referencia derecha como nula
          }
        }

        // Clase ArbolBinario
        class ArbolBinario {
         public $raiz;  // Referencia a la raíz del árbol
          public function __construct() {
             $this->raiz = null;  // Inicializa la raíz como nula
         }
         // Método para insertar un nuevo dato en el árbol
         public function insertar($dato) {
             $nuevoNodo = new Nodo2($dato);  // Crea un nuevo nodo con el dato
             if ($this->raiz === null) {
                  $this->raiz = $nuevoNodo;  // Si el árbol está vacío, el nuevo nodo se convierte en la raíz
              } else {
                  $this->insertarNodo($this->raiz, $nuevoNodo);  // Si no, se inserta el nodo en la posición correcta
              }
         }
         // Método auxiliar para insertar un nodo en la posición correcta
         private function insertarNodo($nodo, $nuevoNodo) {
             if ($nuevoNodo->dato < $nodo->dato) {
                 if ($nodo->izquierda === null) {
                     $nodo->izquierda = $nuevoNodo;  // Inserta el nuevo nodo como hijo izquierdo si está vacío
                 } else {
                     $this->insertarNodo($nodo->izquierda, $nuevoNodo);  // Si no, se llama recursivamente
                 }
             } else {
                 if ($nodo->derecha === null) {
                     $nodo->derecha = $nuevoNodo;  // Inserta el nuevo nodo como hijo derecho si está vacío
                 } else {
                     $this->insertarNodo($nodo->derecha, $nuevoNodo);  // Si no, se llama recursivamente
                 }
             }
         }
         // Método para imprimir el árbol en orden (in-order traversal)
         public function imprimir($nodo) {
             if ($nodo !== null) {
                 $this->imprimir($nodo->izquierda);  // Imprime el subárbol izquierdo
                 echo $nodo->dato . " ";             // Imprime el dato del nodo actual
                 $this->imprimir($nodo->derecha);    // Imprime el subárbol derecho
             }
         }
        }   

        // Creación del árbol binario e inserción de nodos
        $arbol = new ArbolBinario();
        $arbol->insertar(20);
        $arbol->insertar(15);
        $arbol->insertar(25);
        $arbol->insertar(10);
        $arbol->insertar(18);
        $arbol->insertar(22);
        $arbol->insertar(30);

        // Impresión del árbol en orden
        echo "<div class='code-block'><pre>";
        $arbol->imprimir($arbol->raiz);
        echo "</pre></div>";
        ?>

        
        <h2>Grafos</h2>
        <?php
        // Definición de la clase Grafo
        class Grafo {
          // Propiedades de la clase Grafo
          public $vertices;  // Arreglo que almacenará los vértices
          public $aristas;   // Arreglo asociativo que almacenará las aristas

         // Constructor de la clase
         public function __construct() {
             $this->vertices = array();  // Inicializa el arreglo de vértices
              $this->aristas = array();   // Inicializa el arreglo de aristas
          }

         // Método para agregar un vértice al grafo
          public function agregar_vertices($vertice) {
             $this->vertices[] = $vertice;           // Añade el vértice al arreglo de vértices
             $this->aristas[$vertice] = array();     // Crea un arreglo vacío de aristas para el vértice
          }

         // Método para agregar una arista entre dos vértices
         public function aregar_aristas($vertice1, $vertice2) {
             $this->aristas[$vertice1][] = $vertice2;  // Añade el vértice2 al arreglo de aristas del vértice1
             $this->aristas[$vertice2][] = $vertice1;  // Añade el vértice1 al arreglo de aristas del vértice2
          }

         // Método para imprimir el grafo
         public function imprimir_grafo() {
             foreach ($this->vertices as $vertice) {  // Recorre todos los vértices
                  echo $vertice . "->";                 // Imprime el vértice actual
                 foreach ($this->aristas[$vertice] as $item) {  // Recorre las aristas del vértice actual
                        echo $item . " ";                  // Imprime cada arista
                   }
                  echo "<br>";  // Salto de línea después de cada vértice y sus aristas
              }
         }
        }

        // Creación de una instancia del grafo
        $migrafo = new Grafo();
        $migrafo->agregar_vertices("X");  // Agrega el vértice "X"
        $migrafo->agregar_vertices("Y");  // Agrega el vértice "Y"
        $migrafo->agregar_vertices("Z");  // Agrega el vértice "Z"
        $migrafo->agregar_vertices("W");  // Agrega el vértice "W"

        // Agrega las aristas entre los vértices
        $migrafo->aregar_aristas("X", "Y");
        $migrafo->aregar_aristas("Y", "Z");
        $migrafo->aregar_aristas("Z", "X");
        $migrafo->aregar_aristas("Y", "W");

        // Imprime el grafo resultante
        echo "<div class='code-block'><pre>";
        echo "Grafo resultante<br>";
        $migrafo->imprimir_grafo();
        echo "</pre></div>";
        ?>
    </div>
</body>
</html>
