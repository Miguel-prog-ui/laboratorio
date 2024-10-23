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
        <form method="post">
            <label for="frutas">Ingrese las frutas (separadas por comas):</label><br>
            <input type="text" id="frutas" name="frutas" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['frutas'])) {
            $frutas = explode(",", $_POST['frutas']);
            echo "<div class='code-block'><pre>";
            print_r($frutas);
            echo "</pre></div>";
        }
        ?>

        <h2>Pilas</h2>
        <form method="post">
            <label for="pila">Ingrese los elementos de la pila (separados por comas):</label><br>
            <input type="text" id="pila" name="pila" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pila'])) {
            $pila = explode(",", $_POST['pila']);
            echo "<div class='code-block'><pre>";
            print("Antes de sacar el elemento<br>");
            print_r($pila);
            echo "<br>";
            $elemento = array_pop($pila);
            print("Despues de sacar el elemento<br>");
            print_r($pila);
            echo "<br>Ultimo elemento sacado de la pila: <span class='highlight'>" . $elemento . "</span>";
            echo "</pre></div>";
        }
        ?>

        <h2>Colas</h2>
        <form method="post">
            <label for="cola">Ingrese los elementos de la cola (separados por comas):</label><br>
            <input type="text" id="cola" name="cola" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cola'])) {
            $cola = explode(",", $_POST['cola']);
            echo "<div class='code-block'><pre>";
            print("Todos los clientes en la cola<br>");
            print_r($cola);
            echo "<br>";
            $cliente = array_shift($cola);
            print("Ya paso el primer cliente<br>");
            print_r($cola);
            echo "<br>Primer cliente fuera de la cola es: <span class='highlight'>" . $cliente . "</span>";
            echo "</pre></div>";
        }
        ?>

        <h2>Listas</h2>
        <form method="post">
            <label for="lista">Ingrese los elementos de la lista (separados por comas):</label><br>
            <input type="text" id="lista" name="lista" required><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lista'])) {
            $lista = explode(",", $_POST['lista']);
            echo "<div class='code-block'><pre>";
            print_r($lista);
            echo "</pre></div>";
        }
        ?>

        
        <h2>Árboles</h2>
        <form method="post" class="form-container">
            <label for="arbol">Ingrese los valores del árbol (separados por comas):</label>
            <input type="text" id="arbol" name="arbol" required>
         <input type="submit" value="Crear Árbol">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['arbol'])) {
            $valores = explode(',', $_POST['arbol']);
          // Clase Nodo
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
            // Clase ArbolBinario
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
            foreach ($valores as $valor) {
                $arbol->insertar(trim($valor));
            }
            echo "<div class='code-block'><pre>";
            $arbol->imprimir($arbol->raiz);
            echo "</pre></div>";
        }
        ?>
        <h2>Grafos</h2>
        <form method="post" class="form-container">
            <label for="vertices">Ingrese los vértices (separados por comas):</label>
            <input type="text" id="vertices" name="vertices" required>
            <label for="aristas">Ingrese las aristas (formato: vertice1-vertice2, separados por comas):</label>
            <input type="text" id="aristas" name="aristas" required>
            <input type="submit" value="Crear Grafo">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vertices']) && isset($_POST['aristas'])) {
            $vertices = explode(',', $_POST['vertices']);
            $aristas = explode(',', $_POST['aristas']);
            // Definición de la clase Grafo
            class Grafo {
                public $vertices;
                public $aristas;
                public function __construct() {
                    $this->vertices = array();
                    $this->aristas = array();
                }
                public function agregar_vertices($vertice) {
                    $this->vertices[] = $vertice;
                    $this->aristas[$vertice] = array();
                }
                public function agregar_aristas($vertice1, $vertice2) {
                    $this->aristas[$vertice1][] = $vertice2;
                    $this->aristas[$vertice2][] = $vertice1;
                }
                public function imprimir_grafo() {
                    foreach ($this->vertices as $vertice) {
                        echo $vertice . "->";
                        foreach ($this->aristas[$vertice] as $item) {
                            echo $item . " ";
                        }
                        echo "<br>";
                    }
                }
            }
            $migrafo = new Grafo();
            foreach ($vertices as $vertice) {
                $migrafo->agregar_vertices(trim($vertice));
            }
            foreach ($aristas as $arista) {
                list($v1, $v2) = explode('-', $arista);
                $migrafo->agregar_aristas(trim($v1), trim($v2));
            }
            echo "<div class='code-block'><pre>";
            $migrafo->imprimir_grafo();
            echo "</pre></div>";
        }
        ?>



    </div>
</body>
</html>

