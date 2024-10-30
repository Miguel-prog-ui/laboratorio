from flask import Flask, render_template

app = Flask(__name__)

@app.route('/')
def index():
    # Crear un array que contenga subarrays para lista, pila, cola, lista y árbol
    estructura_compuesta = []

    # Arreglos
    frutas = ["Mangos", "Banana", "Uva", "Mora"]
    estructura_compuesta.append({"tipo": "Arreglos", "datos": frutas})

    # Pilas
    pila = ["Elemento A", "Elemento B", "Elemento C", "Elemento D", "Elemento E", "Elemento F"]
    elemento_pila = pila.pop()
    estructura_compuesta.append({"tipo": "Pilas", "datos": pila, "ultimo": elemento_pila})

    # Colas
    cola = ["Persona 1", "Persona 2", "Persona 3", "Persona 4", "Persona 5"]
    cliente_cola = cola.pop(0)
    estructura_compuesta.append({"tipo": "Colas", "datos": cola, "primero": cliente_cola})

    # Listas
    lista = ["Lácteos", "Granos", "Carnes"]
    estructura_compuesta.append({"tipo": "Listas", "datos": lista})

    # Árbol Binario
    class Nodo:
        def __init__(self, dato):
            self.dato = dato
            self.izquierda = None
            self.derecha = None

    class ArbolBinario:
        def __init__(self):
            self.raiz = None

        def insertar(self, dato):
            if self.raiz is None:
                self.raiz = Nodo(dato)
            else:
                self._insertar(dato, self.raiz)

        def _insertar(self, dato, nodo_actual):
            if dato < nodo_actual.dato:
                if nodo_actual.izquierda is None:
                    nodo_actual.izquierda = Nodo(dato)
                else:
                    self._insertar(dato, nodo_actual.izquierda)
            else:
                if nodo_actual.derecha is None:
                    nodo_actual.derecha = Nodo(dato)
                else:
                    self._insertar(dato, nodo_actual.derecha)

        def imprimir(self, nodo, resultado):
            if nodo is not None:
                self.imprimir(nodo.izquierda, resultado)
                resultado.append(nodo.dato)
                self.imprimir(nodo.derecha, resultado)

    arbol = ArbolBinario()
    for valor in [20, 15, 25, 10, 18, 22, 30]:
        arbol.insertar(valor)
    resultado_arbol = []
    arbol.imprimir(arbol.raiz, resultado_arbol)
    estructura_compuesta.append({"tipo": "Árboles", "datos": resultado_arbol})

    return render_template('index.html', estructura_compuesta=estructura_compuesta)

if __name__ == "__main__":
    app.run(debug=True, port=5000)
