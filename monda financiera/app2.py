from flask import Flask, render_template, request, redirect, url_for
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
        return render_template('monto_aumento_capital.html')
    else:
        mensaje = "Entiendo, estamos aquí si necesitas ayuda en el futuro."
        return render_template('resultado1.html', mensaje=mensaje)

# Rutas y funciones para Crédito Bancario
@app.route('/credito_bancario', methods=['POST'])
def credito_bancario():
    monto_deseado = request.form.get('monto_deseado')
    if monto_deseado:
        monto_deseado = int(monto_deseado)
        if monto_deseado > 5000:
            mensaje = "El monto deseado excede los $5000. ¿Desea ingresar otro monto o salir?"
            return render_template('excedido.html', mensaje=mensaje)
        else:
            mensaje = f"Has solicitado un préstamo de ${monto_deseado}. ¿Deseas adquirir la deuda?"
            return render_template('adquirir_deuda.html', monto=monto_deseado)
    else:
        return render_template('bienvenida1.html')

@app.route('/adquirir_deuda', methods=['POST'])
def adquirir_deuda():
    decision_deuda = request.form['decision_deuda']
    monto = int(request.form['monto'])
    if decision_deuda == 'si':
        mensaje = "Solicitando crédito al banco. Por favor, espera..."
        return render_template('espera_banco.html', mensaje=mensaje, monto=monto)
    else:
        mensaje = "¿Deseas volver al inicio para pedir otro tipo de financiamiento o salir?"
        return render_template('volver_inicio.html', mensaje=mensaje)

@app.route('/espera_banco', methods=['POST'])
def espera_banco():
    decision_espera = request.form['decision_espera']
    if decision_espera == 'esperar':
        aprobado = random.choice([True, False])
        if aprobado:
            mensaje = "El banco ha aprobado tu crédito. ¡Felicidades!"
        else:
            mensaje = "Lo sentimos, el banco no aprobó tu crédito."
        return render_template('resultado1.html', mensaje=mensaje)
    else:
        return render_template('bienvenida1.html')

# Rutas y funciones para Aumento de Capital
@app.route('/monto_aumento_capital', methods=['POST'])
def monto_aumento_capital():
    monto_deseado = request.form.get('monto_deseado')
    if monto_deseado:
        monto_deseado = int(monto_deseado)
        if monto_deseado > 5000:
            mensaje = "El monto deseado excede los $5000. ¿Desea ingresar otro monto o salir?"
            return render_template('excedido.html', mensaje=mensaje)
        else:
            return render_template('porcentaje_aumento_capital.html', monto=monto_deseado)
    else:
        return render_template('bienvenida1.html')

@app.route('/porcentaje_aumento_capital', methods=['POST'])
def porcentaje_aumento_capital():
    monto = int(request.form['monto'])
    porcentaje_deseado = request.form.get('porcentaje_deseado')
    if porcentaje_deseado:
        porcentaje_deseado = int(porcentaje_deseado)
        if 10 <= porcentaje_deseado <= 20:
            mensaje = f"El porcentaje de capital definido es del {porcentaje_deseado}%. Su propuesta está siendo revisada."
            return render_template('revisando_propuesta.html', mensaje=mensaje)
        else:
            mensaje = "El porcentaje deseado está fuera del rango aceptable (10% a 20%). ¿Desea ingresar otro porcentaje o salir?"
            return render_template('excedido_porcentaje.html', mensaje=mensaje, monto=monto)
    else:
        return render_template('bienvenida1.html')

@app.route('/resultado_propuesta', methods=['POST'])
def resultado_propuesta():
    decision_revisar = request.form['decision_revisar']
    if decision_revisar == 'esperar':
        aprobado = random.choice([True, False])
        if aprobado:
            mensaje = "¡Felicidades! Su propuesta ha sido aceptada."
        else:
            mensaje = "Lo siento, su propuesta no ha sido aceptada."
        return render_template('resultado1.html', mensaje=mensaje)
    else:
        return render_template('bienvenida1.html')

# Rutas comunes
@app.route('/excedido', methods=['POST'])
def excedido():
    decision_excedido = request.form['decision_excedido']
    if decision_excedido == 'ingresar_otro_monto':
        return render_template('monto_aumento_capital.html')
    else:
        return render_template('bienvenida1.html')

@app.route('/excedido_porcentaje', methods=['POST'])
def excedido_porcentaje():
    decision_excedido_porcentaje = request.form['decision_excedido_porcentaje']
    monto = int(request.form['monto'])
    if decision_excedido_porcentaje == 'ingresar_otro_porcentaje':
        return render_template('porcentaje_aumento_capital.html', monto=monto)
    else:
        return render_template('bienvenida1.html')

@app.route('/volver_inicio', methods=['POST'])
def volver_inicio():
    decision_volver = request.form['decision_volver']
    if decision_volver == 'volver_inicio':
        return render_template('bienvenida1.html')
    else:
        return redirect(url_for('index'))

if __name__ == "__main__":
    app.run(debug=True, port=5000)
