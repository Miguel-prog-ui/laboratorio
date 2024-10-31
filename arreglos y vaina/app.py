from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)

# Inicializar las existencias y precios de cada comida
existencias = {
    "Pizza": 10,
    "Hamburguesa": 8,
    "Ensalada": 15,
    "Sushi": 5
}

precios = {
    "Pizza": 8.00,
    "Hamburguesa": 5.00,
    "Ensalada": 6.50,
    "Sushi": 7.50
}

pedido = []

@app.route('/')
def bienvenida():
    return render_template('bienvenida.html')

@app.route('/menu')
def menu():
    return render_template('menu.html', existencias=existencias)

@app.route('/seleccion', methods=['POST'])
def seleccion():
    opcion = request.form['opcion']
    # Verificar si hay existencias
    if existencias[opcion] > 0:
        existencias[opcion] -= 1
        mensaje = f"Ha seleccionado {opcion}. Quedan {existencias[opcion]} en inventario."
        pedido.append(opcion)
    else:
        mensaje = f"Lo siento, {opcion} está agotado. Por favor, elija otra opción."
    return render_template('resultado.html', mensaje=mensaje, existencias=existencias)

@app.route('/continuar', methods=['POST'])
def continuar():
    return render_template('menu.html', existencias=existencias)

@app.route('/factura')
def factura():
    detalles = [(item, precios[item]) for item in pedido]
    total = sum(precios[item] for item in pedido)
    factura_detalle = detalles.copy()
    pedido.clear()  # Reiniciar la lista de pedido después de generar la factura
    return render_template('factura.html', detalles=factura_detalle, total=total)

@app.route('/cancelar', methods=['POST'])
def cancelar():
    # Restablecer pedido y existencias
    global pedido
    for item in pedido:
        existencias[item] += 1
    pedido = []
    return redirect(url_for('bienvenida'))

if __name__ == "__main__":
    app.run(debug=True, port=5000)
