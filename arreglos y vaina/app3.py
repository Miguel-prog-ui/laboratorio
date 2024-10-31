from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)

# Crear un arreglo principal que contenga subarreglos para lista, pila, árbol y cola
estructura_compuesta = []

# Lista
mi_lista = [1, 2, 3, 4, 5]
estructura_compuesta.append({"tipo": "Lista", "datos": mi_lista})

# Pila
pila = []
pila.append('A')
pila.append('B')
pila.append('C')
estructura_compuesta.append({"tipo": "Pila", "datos": pila})

# Árbol Binario
class Nodo:
    def __init__(self, valor):
        self.valor = valor
        self.izquierda = None
        self.derecha = None

def insertar_arbol(raiz, valor):
    if raiz is None:
        return Nodo(valor)
    else:
        if valor < raiz.valor:
            raiz.izquierda = insertar_arbol(raiz.izquierda, valor)
        else:
            raiz.derecha = insertar_arbol(raiz.derecha, valor)
    return raiz

def preorden(nodo):
    resultado = []
    if nodo:
        resultado.append(nodo.valor)
        resultado.extend(preorden(nodo.izquierda))
        resultado.extend(preorden(nodo.derecha))
    return resultado

arbol = None
valores_arbol = [20, 10, 30, 5, 15, 25, 35]
for valor in valores_arbol:
    arbol = insertar_arbol(arbol, valor)
estructura_compuesta.append({"tipo": "Árbol", "datos": preorden(arbol)})

# Cola
cola = []
cola.append('Persona 1')
cola.append('Persona 2')
cola.append('Persona 3')
estructura_compuesta.append({"tipo": "Cola", "datos": cola})

@app.route('/')
def index():
    return render_template('index.html', estructura_compuesta=estructura_compuesta)

@app.route('/agregar_lista', methods=['POST'])
def agregar_lista():
    item = request.form['item']
    estructura_compuesta[0]["datos"].append(item)
    return redirect(url_for('index'))

@app.route('/agregar_pila', methods=['POST'])
def agregar_pila():
    item = request.form['item']
    estructura_compuesta[1]["datos"].append(item)
    return redirect(url_for('index'))

@app.route('/eliminar_pila', methods=['POST'])
def eliminar_pila():
    if estructura_compuesta[1]["datos"]:
        estructura_compuesta[1]["datos"].pop()
    return redirect(url_for('index'))

@app.route('/agregar_cola', methods=['POST'])
def agregar_cola():
    item = request.form['item']
    estructura_compuesta[3]["datos"].append(item)
    return redirect(url_for('index'))

@app.route('/eliminar_cola', methods=['POST'])
def eliminar_cola():
    if estructura_compuesta[3]["datos"]:
        estructura_compuesta[3]["datos"].pop(0)
    return redirect(url_for('index'))

if __name__ == "__main__":
    app.run(debug=True, port=5000)
