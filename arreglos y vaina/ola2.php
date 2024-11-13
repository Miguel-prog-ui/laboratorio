<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Establece la fuente para todo el contenido */
            background-color: #f0f8ff; /* Color de fondo suave */
            margin: 0; /* Elimina el margen predeterminado del navegador */
            padding: 0; /* Elimina el padding predeterminado del navegador */
        }
        .a {
            max-width: 900px; /* Define el ancho máximo del contenedor */
            margin: auto; /* Centra el contenedor horizontalmente */
            background-color: #ffffff; /* Color de fondo blanco para el contenedor */
            padding: 20px; /* Añade padding interno al contenedor */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Añade una sombra alrededor del contenedor */
            border-radius: 10px; /* Redondea las esquinas del contenedor */
        }
        h1 {
            text-align: center; /* Centra el texto del encabezado */
            color: #000; /* Color negro para el texto */
            font-size: 2em; /* Tamaño de letra aumentado */
            margin-bottom: 20px; /* Espacio inferior después del encabezado */
        }
        h2 {
            color: #000; /* Color negro para el texto */
            font-size: 1.5em; /* Tamaño de letra aumentado */
            border-bottom: 2px solid #000; /* Línea negra debajo del encabezado */
            padding-bottom: 5px; /* Espacio inferior del encabezado */
            margin-top: 20px; /* Espacio superior antes del encabezado */
        }
        pre {
            background-color: #e9ecef; /* Color de fondo suave para el bloque de código */
            padding: 15px; /* Añade padding interno al bloque de código */
            border-radius: 5px; /* Redondea las esquinas del bloque de código */
            overflow-x: auto; /* Añade barra de desplazamiento horizontal si es necesario */
        }
        .code-block {
            border-left: 4px solid #000; /* Línea negra en el lado izquierdo del bloque de código */
            padding-left: 10px; /* Espacio a la izquierda dentro del bloque de código */
            margin: 10px 0; /* Espacio superior e inferior del bloque de código */
        }
        .highlight {
            background-color: #ffd700; /* Color de fondo dorado para resaltar */
            padding: 2px 4px; /* Añade padding interno al resaltado */
            border-radius: 4px; /* Redondea las esquinas del resaltado */
        }
    </style>

</head>
<body>
    <div class="a">
        <!-- Encabezado principal de la página -->
        <h1>Estructura de datos</h1>
        
        <!-- Sección de Arreglos -->
        <h2>Arreglos</h2>
        <form method="post">
            <!-- Campo de texto para ingresar frutas -->
            <label for="frutas">Ingrese las frutas (separadas por comas):</label><br>
            <input type="text" id="frutas" name="frutas" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['frutas'])) {
            $frutas = explode(",", $_POST['frutas']); // Convierte la cadena en un arreglo
            echo "<div class='code-block'><pre>";
            print_r($frutas); // Imprime el contenido del arreglo
            echo "</pre></div>";
        }
        ?>
        
        <!-- Sección de Pilas -->
        <h2>Pilas</h2>
        <form method="post">
            <!-- Campo de texto para ingresar elementos de la pila -->
            <label for="pila">Ingrese los elementos de la pila (separados por comas):</label><br>
            <input type="text" id="pila" name="pila" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pila'])) {
            $pila = explode(",", $_POST['pila']); // Convierte la cadena en un arreglo
            echo "<div class='code-block'><pre>";
            print("Antes de sacar el elemento<br>");
            print_r($pila); // Imprime el contenido de la pila antes de modificarla
            echo "<br>";
            $elemento = array_pop($pila); // Saca el último elemento de la pila
            print("Despues de sacar el elemento<br>");
            print_r($pila); // Imprime el contenido de la pila después de modificarla
            echo "<br>Ultimo elemento sacado de la pila: <span class='highlight'>" . $elemento . "</span>"; // Imprime el último elemento sacado
            echo "</pre></div>";
        }
        ?>
        
        <!-- Sección de Colas -->
        <h2>Colas</h2>
        <form method="post">
            <!-- Campo de texto para ingresar elementos de la cola -->
            <label for="cola">Ingrese los elementos de la cola (separados por comas):</label><br>
            <input type="text" id="cola" name="cola" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cola'])) {
            $cola = explode(",", $_POST['cola']); // Convierte la cadena en un arreglo
            echo "<div class='code-block'><pre>";
            print("Todos los clientes en la cola<br>");
            print_r($cola); // Imprime el contenido de la cola antes de modificarla
            echo "<br>";
            $cliente = array_shift($cola); // Saca el primer elemento de la cola
            print("Ya paso el primer cliente<br>");
            print_r($cola); // Imprime el contenido de la cola después de modificarla
            echo "<br>Primer cliente fuera de la cola es: <span class='highlight'>" . $cliente . "</span>"; // Imprime el primer cliente fuera de la cola
            echo "</pre></div>";
        }
        ?>
        
        <!-- Sección de Listas -->
        <h2>Listas</h2>
        <form method="post">
            <!-- Campo de texto para ingresar elementos de la lista -->
            <label for="lista">Ingrese los elementos de la lista (separados por comas):</label><br>
            <input type="text" id="lista" name="lista" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lista'])) {
            $lista = explode(",", $_POST['lista']); // Convierte la cadena en un arreglo
            echo "<div class='code-block'><pre>";
            print_r($lista); // Imprime el contenido de la lista
            echo "</pre></div>";
        }
        ?>

        <h2>Árboles</h2>
        <form method="post" class="form-container">
            <!-- Campo de texto para ingresar los valores del árbol -->
            <label for="arbol">Ingrese los valores del árbol (separados por comas):</label>
            <input type="text" id="arbol" name="arbol" required>
            <input type="submit" value="Crear Árbol">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['arbol'])) {
            $valores = explode(',', $_POST['arbol']); // Convierte la cadena de valores en un arreglo
            
            // Clase Nodo
            class Nodo2 {
                public $dato; // Valor almacenado en el nodo
                public $izquierda; // Referencia al hijo izquierdo
                public $derecha; // Referencia al hijo derecho
                public function __construct($dato) {
                    $this->dato = $dato; // Asigna el dato al nodo
                    $this->izquierda = null; // Inicializa la referencia izquierda como nula
                    $this->derecha = null; // Inicializa la referencia derecha como nula
                }
            }
            
            // Clase ArbolBinario
            class ArbolBinario {
                public $raiz; // Referencia a la raíz del árbol
                public function __construct() {
                    $this->raiz = null; // Inicializa la raíz como nula
                }
                
                // Método para insertar un nuevo dato en el árbol
                public function insertar($dato) {
                    $nuevoNodo = new Nodo2($dato); // Crea un nuevo nodo con el dato
                    if ($this->raiz === null) {
                        $this->raiz = $nuevoNodo; // Si el árbol está vacío, el nuevo nodo se convierte en la raíz
                    } else {
                        $this->insertarNodo($this->raiz, $nuevoNodo); // Si no, se inserta el nodo en la posición correcta
                    }
                }
                
                // Método auxiliar para insertar un nodo en la posición correcta
                private function insertarNodo($nodo, $nuevoNodo) {
                    if ($nuevoNodo->dato < $nodo->dato) {
                        if ($nodo->izquierda === null) {
                            $nodo->izquierda = $nuevoNodo; // Inserta el nuevo nodo como hijo izquierdo si está vacío
                        } else {
                            $this->insertarNodo($nodo->izquierda, $nuevoNodo); // Si no, se llama recursivamente
                        }
                    } else {
                        if ($nodo->derecha === null) {
                            $nodo->derecha = $nuevoNodo; // Inserta el nuevo nodo como hijo derecho si está vacío
                        } else {
                            $this->insertarNodo($nodo->derecha, $nuevoNodo); // Si no, se llama recursivamente
                        }
                    }
                }
                
                // Método para imprimir el árbol en orden (in-order traversal)
                public function imprimir($nodo) {
                    if ($nodo !== null) {
                        $this->imprimir($nodo->izquierda); // Imprime el subárbol izquierdo
                        echo $nodo->dato . " "; // Imprime el dato del nodo actual
                        $this->imprimir($nodo->derecha); // Imprime el subárbol derecho
                    }
                }
            }
            
            $arbol = new ArbolBinario(); // Crea una instancia del árbol binario
            foreach ($valores as $valor) {
                $arbol->insertar(trim($valor)); // Inserta cada valor en el árbol, eliminando espacios adicionales
            }
            echo "<div class='code-block'><pre>";
            $arbol->imprimir($arbol->raiz); // Imprime el árbol en orden
            echo "</pre></div>";
        }
        ?>

        <h2>Grafos</h2>
        <form method="post" class="form-container">
            <!-- Campo de texto para ingresar los vértices del grafo -->
            <label for="vertices">Ingrese los vértices (separados por comas):</label>
            <input type="text" id="vertices" name="vertices" required>
            <!-- Campo de texto para ingresar las aristas del grafo -->
            <label for="aristas">Ingrese las aristas (formato: vertice1-vertice2, separados por comas):</label>
            <input type="text" id="aristas" name="aristas" required>
            <input type="submit" value="Crear Grafo">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vertices']) && isset($_POST['aristas'])) {
            $vertices = explode(',', $_POST['vertices']); // Convierte la cadena de vértices en un arreglo
            $aristas = explode(',', $_POST['aristas']); // Convierte la cadena de aristas en un arreglo
            
            // Definición de la clase Grafo
            class Grafo {
                public $vertices; // Arreglo que almacenará los vértices
                public $aristas; // Arreglo asociativo que almacenará las aristas
                
                // Constructor de la clase
                public function __construct() {
                    $this->vertices = array(); // Inicializa el arreglo de vértices
                    $this->aristas = array(); // Inicializa el arreglo de aristas
                }
                
                // Método para agregar un vértice al grafo
                public function agregar_vertices($vertice) {
                    $this->vertices[] = $vertice; // Añade el vértice al arreglo de vértices
                    $this->aristas[$vertice] = array(); // Crea un arreglo vacío de aristas para el vértice
                }
                
                // Método para agregar una arista entre dos vértices
                public function agregar_aristas($vertice1, $vertice2) {
                    $this->aristas[$vertice1][] = $vertice2; // Añade el vértice2 al arreglo de aristas del vértice1
                    $this->aristas[$vertice2][] = $vertice1; // Añade el vértice1 al arreglo de aristas del vértice2
                }
                
                // Método para imprimir el grafo
                public function imprimir_grafo() {
                    foreach ($this->vertices as $vertice) { // Recorre todos los vértices
                        echo $vertice . "->"; // Imprime el vértice actual
                        foreach ($this->aristas[$vertice] as $item) { // Recorre las aristas del vértice actual
                            echo $item . " "; // Imprime cada arista
                        }
                        echo "<br>"; // Salto de línea después de cada vértice y sus aristas
                    }
                }
            }
            
            $migrafo = new Grafo(); // Crea una instancia del grafo
            foreach ($vertices as $vertice) {
                $migrafo->agregar_vertices(trim($vertice)); // Agrega cada vértice al grafo, eliminando espacios adicionales
            }
            foreach ($aristas as $arista) {
                list($v1, $v2) = explode('-', $arista); // Divide la arista en dos vértices
                $migrafo->agregar_aristas(trim($v1), trim($v2)); // Agrega la arista entre los vértices
            }
            echo "<div class='code-block'><pre>";
            $migrafo->imprimir_grafo(); // Imprime el grafo
            echo "</pre></div>";
        }
        ?>




    </div>
</body>
</html>

