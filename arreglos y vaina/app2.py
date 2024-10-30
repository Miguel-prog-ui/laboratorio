from flask import Flask, render_template, request
import random

app = Flask(__name__)

@app.route('/')
def bienvenida():
    return render_template('bienvenida1.html')

@app.route('/financiamiento', methods=['POST'])
def financiamiento():
    decision = request.form['decision']
    if decision == 'si':
        return render_template('propuesta.html')
    else:
        mensaje = "Entiendo, si cambias de opinión, estamos aquí para ayudarte."
        return render_template('resultado1.html', mensaje=mensaje)

@app.route('/propuesta', methods=['POST'])
def propuesta():
    propuesta_decision = request.form['propuesta_decision']
    if propuesta_decision == 'credito_bancario':
        return render_template('credito_bancario.html')
    elif propuesta_decision == 'aumento_capital':
        return render_template('aumento_capital.html')
    else:
        mensaje = "Entiendo, estamos aquí si necesitas ayuda en el futuro."
        return render_template('resultado1.html', mensaje=mensaje)

@app.route('/credito_bancario', methods=['POST'])
def credito_bancario():
    adquirir_deuda = request.form['adquirir_deuda']
    if adquirir_deuda == 'si':
        monto = random.randint(1000, 10000)
        mensaje = f"Has solicitado un préstamo de ${monto}. Estamos esperando la respuesta del banco."
        return render_template('resultado1.html', mensaje=mensaje)
    else:
        return render_template('bienvenida1.html')

@app.route('/aumento_capital', methods=['POST'])
def aumento_capital():
    definir_porcentaje = request.form['definir_porcentaje']
    if definir_porcentaje == 'si':
        mensaje = "El porcentaje de capital definido es del 15%. Procediendo a obtener recursos."
        return render_template('resultado1.html', mensaje=mensaje)
    else:
        return render_template('bienvenida1.html')

if __name__ == "__main__":
    app.run(debug=True, port=5000)