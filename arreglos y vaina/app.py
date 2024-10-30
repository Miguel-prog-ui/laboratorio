from flask import Flask, render_template, request

app = Flask(__name__)

# Inicializar las existencias de cada comida
existencias = {
    "Pizza": 10,
    "Hamburguesa": 8,
    "Ensalada": 15,
    "Sushi": 5
}

@app.route('/')
def bienvenida():
    return render_template('bienvenida.html')

@app.route('/menu')
def menu():
    return render_template('menu.html')

@app.route('/seleccion', methods=['POST'])
def seleccion():
    opcion = request.form['opcion']
    
    # Verificar si hay existencias
    if existencias[opcion] > 0:
        existencias[opcion] -= 1
        mensaje = f"Ha seleccionado {opcion}. Quedan {existencias[opcion]} en inventario."
    else:
        mensaje = f"Lo siento, {opcion} está agotado. Por favor, elija otra opción."

    # Guardar la opción seleccionada en un archivo
    with open("opcion_seleccionada.txt", "a") as archivo:
        archivo.write(f"{opcion}\n")

    return render_template('resultado.html', mensaje=mensaje, existencias=existencias)

@app.route('/continuar', methods=['POST'])
def continuar():
    return render_template('menu.html')

if __name__ == "__main__":
    app.run(debug=True, port=5000)