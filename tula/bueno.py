#Codigo laboratorio de programacion parcial 3
#fecha: 12/12/2024
#programadores:Miguel Mijares, Livio Garcia, Jeam-pierre Hermosilla, Isaac Rengifo
#version: 1.0.0

from decimal import Decimal
from flask import Flask
from flask import render_template, redirect, request, Response, session,jsonify
from flask_mysqldb import MySQL, MySQLdb

app = Flask(__name__, template_folder='templates')

app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'login'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'
mysql = MySQL(app)

@app.route('/')
def home():
    return render_template('home.html')

    
@app.route('/login')
def login():
    return render_template('login si.html')

@app.route('/contacto')
def contacto():
    return render_template('/contacto.html')

@app.route('/acceso_login', methods=['GET', 'POST'])
def acceso_login():


        #Le pide al usuario los datos correspondientes para entrar a la banca online
    if request.method == 'POST' and 'txt_correo' in request.form and 'txt_password' in request.form:
        _correo = request.form['txt_correo']
        _password = request.form['txt_password']

        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM usuarios WHERE correo = %s AND password = %s', (_correo, _password,))
        account = cur.fetchone()

        #Define la cuenta administrador en la banca online y lo separa de los usuarios comunes
        if account:
            if account['codigo'] == 0:
                session['logueado'] = True
                session['id'] = account['id']
                session['usuario'] = account['usuario']
                session['saldo'] = account['saldo']
                return redirect('/admin')
            elif account['codigo'] == 1:
                session['logueado'] = True
                session['usuario'] = 'admin'
                return redirect('/administrador')
        else:
            return render_template('login si.html', mensaje_malo="Nombre de usuario o contraseña incorrectos")
    return render_template('login si.html')

@app.route('/crear_cuenta', methods=['GET', 'POST'])
def crear_cuenta():

        #Le pide al usuario una variedad de datos para la creacion de la cuenta
    if request.method == 'POST' and 'txt_correo' in request.form and 'txt_password' in request.form and 'txt_usuario' in request.form:
        _correo = request.form['txt_correo']
        _password = request.form['txt_password']
        _usuario = request.form['txt_usuario']

        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM usuarios WHERE correo = %s', (_correo,))
        email_exists = cur.fetchone()
        cur.execute('SELECT * FROM usuarios WHERE usuario = %s', (_usuario,))
        user_exists = cur.fetchone()

        #Verifica si los datos ingresados por el usuario no estan en uso por otros usuarios
        if email_exists:
            return render_template('login si.html', mensaje_malo="El correo ya está registrado")
        elif user_exists:
            return render_template('login si.html', mensaje_malo="El nombre de usuario ya está en uso")
        else:
            cur.execute('INSERT INTO usuarios (correo, password, usuario, saldo) VALUES (%s, %s, %s, %s)', (_correo, _password, _usuario, 0))
            mysql.connection.commit()
            return render_template('login si.html', mensaje="Cuenta creada con éxito")
    return render_template('login si.html')

@app.route('/admin')
def admin():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        
        # Obtener el saldo del usuario
        cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
        saldo = cur.fetchone()['saldo']
        
        #  Obtener el saldo en dólares
        cur.execute('SELECT saldo_dolares FROM usuarios WHERE usuario = %s', (usuario,))
        saldo_dolares = Decimal(cur.fetchone()['saldo_dolares'])  # Convertir a Decimal

        # Obtener las transacciones y movimientos con detalle
        cur.execute('''
            SELECT 'Deposito' as tipo, deposito as monto, fecha, usuario as descripcion 
            FROM depositos_aceptados WHERE usuario = %s
            UNION ALL
            SELECT 'Transferencia Recibida de ' as tipo, monto as monto, fecha, 
                   CONCAT(remitente, ' (', concepto, ')') as descripcion 
            FROM transferencias WHERE destinatario = %s
            UNION ALL
            SELECT 'Transferencia Enviada a ' as tipo, -monto as monto, fecha, 
                   CONCAT(destinatario, ' (', concepto, ')') as descripcion 
            FROM transferencias WHERE remitente = %s
            ORDER BY fecha DESC
            LIMIT 5
        ''', (usuario, usuario, usuario))
        transacciones = cur.fetchall()
        
        # Obtener las últimas tres notificaciones
        cur.execute('''
            SELECT usuario, tipo, notificacion, fecha
            FROM notificaciones
            WHERE usuario = %s
            ORDER BY fecha DESC
            LIMIT 4
        ''', (usuario,))
        ultimas_notificaciones = cur.fetchall()
        
        # Obtener todas las notificaciones
        cur.execute('''
            SELECT usuario, tipo, notificacion, fecha
            FROM notificaciones
            WHERE usuario = %s
            ORDER BY fecha DESC
        ''', (usuario,))
        todas_notificaciones = cur.fetchall()
        
        return render_template('admin.html', usuario=usuario, saldo=saldo, saldo_dolares=saldo_dolares, transacciones=transacciones, ultimas_notificaciones=ultimas_notificaciones, todas_notificaciones=todas_notificaciones)
    else:
        return redirect('/login')

@app.route('/admin_dashboard')
def admin_dashboard():

    #Permite que el administrador de la banca pueda ver, aceptar o rechazar los prestamos pendientes de los usuarios
    if 'logueado' in session and session.get('usuario') == 'admin':
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM prestamos WHERE estatus = %s', ('pendiente',))
        prestamos = cur.fetchall()
        return render_template('admin_dashboard.html', prestamos=prestamos, usuario=usuario)
    else:
        return redirect('/login')


@app.route('/aceptar_prestamo', methods=['POST'])
def aceptar_prestamo():

    if 'logueado' in session and session.get('usuario') == 'admin':
        prestamo_id = request.form['prestamo_id']
        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM prestamos WHERE id = %s', (prestamo_id,))
        prestamo = cur.fetchone()

        if prestamo:
            usuario = prestamo['usuario']
            monto = prestamo['monto']
            cuotas = prestamo['cuotas']

            # Calcular el monto de cada cuota
            monto_cuota = monto / cuotas

            # Actualizar el estado del préstamo a aprobado y establecer cuotas_restantes y monto_restante
            cur.execute('UPDATE prestamos SET estatus = %s, cuotas_restantes = %s, monto_restante = %s WHERE id = %s', 
                        ('aprobado', cuotas, monto, prestamo_id))
            mysql.connection.commit()

            # Actualizar el saldo del usuario
            cur.execute('UPDATE usuarios SET saldo = saldo + %s WHERE usuario = %s', (monto, usuario))
            mysql.connection.commit()

            # Eliminar la notificación de solicitud pendiente
            cur.execute('DELETE FROM notificaciones WHERE usuario = %s AND tipo = %s AND notificacion = %s', 
                        (usuario, 'prestamo', 'pendiente'))
            mysql.connection.commit()

            cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())', 
                        (usuario, 'prestamo', 'aprobado'))
            mysql.connection.commit()

        return redirect('/admin_dashboard')
    else:
        return redirect('/login')



@app.route('/rechazar_prestamo', methods=['POST'])
def rechazar_prestamo():
    if 'logueado' in session and session.get('usuario') == 'admin':
        prestamo_id = request.form['prestamo_id']
        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM prestamos WHERE id = %s', (prestamo_id,))
        prestamo = cur.fetchone()

        if prestamo:
            usuario = prestamo['usuario']

            # Actualizar el estado del préstamo a rechazado
            cur.execute('UPDATE prestamos SET estatus = %s WHERE id = %s', ('rechazado', prestamo_id))
            mysql.connection.commit()

            # Eliminar la notificación de solicitud pendiente
            cur.execute('DELETE FROM notificaciones WHERE usuario = %s AND tipo = %s AND notificacion = %s', 
                        (usuario, 'prestamo', 'pendiente'))
            mysql.connection.commit()

            cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())', 
                        (usuario, 'prestamo', 'rechazado'))
            mysql.connection.commit()

        return redirect('/admin_dashboard')
    else:
        return redirect('/login')

@app.route('/deposito', methods=['GET', 'POST'])
def deposito():
    if request.method == 'POST':
        if 'logueado' in session:
            usuario = session['usuario']
            monto_deposito = request.form['txt_deposito']

            cur = mysql.connection.cursor()
            cur.execute('UPDATE usuarios SET saldo = saldo + %s WHERE usuario = %s', (monto_deposito, usuario))
            mysql.connection.commit()
            
            cur.execute('INSERT INTO depositos_aceptados (usuario, deposito, fecha) VALUES (%s, %s, NOW())', (usuario, monto_deposito))
            mysql.connection.commit()
            
            cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())',
                        (usuario, 'deposito', 'aceptado'))
            mysql.connection.commit()

            return render_template('deposito.html', mensaje="Depósito realizado con éxito", usuario=usuario)
        else:
            return redirect('/login')
    elif 'logueado' in session:
        usuario = session['usuario']
        return render_template('deposito.html', usuario=usuario)
    else:
        return redirect('/login')

@app.route('/solicitar_prestamo', methods=['GET', 'POST'])
def solicitar_prestamo():
    if request.method == 'POST':
        if 'logueado' in session:
            usuario = session['usuario']
            monto = request.form['monto']
            cuotas = request.form['cuotas']

            cur = mysql.connection.cursor()
            cur.execute('INSERT INTO prestamos (usuario, monto, cuotas, fecha, estatus) VALUES (%s, %s, %s, NOW(), %s)', 
                        (usuario, monto, cuotas, 'pendiente'))
            mysql.connection.commit()

            cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())', 
                        ('admin', 'prestamo', f'Solicitud de préstamo de {usuario}'))
            mysql.connection.commit()

            return render_template('prestamo.html', mensaje="Solicitud de préstamo enviada con éxito", usuario=usuario)
        else:
            return redirect('/login')
    elif 'logueado' in session:
        usuario = session['usuario']
        return render_template('prestamo.html', usuario=usuario)
    else:
        return redirect('/login')

@app.route('/saldo')
def saldo():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
        result = cur.fetchone()
        
        if result:
            saldo = result['saldo']
        else:
            saldo = 0  # Manejar el caso donde el usuario no tiene saldo registrado
        
        cur.execute('''
            SELECT 'Deposito' as tipo, deposito as monto, fecha FROM depositos_aceptados WHERE usuario = %s
            UNION ALL
            SELECT CONCAT('Transferencia Recibida de ', remitente) as tipo, monto as monto, fecha FROM transferencias WHERE destinatario = %s
            UNION ALL
            SELECT CONCAT('Transferencia Enviada a ', destinatario) as tipo, -monto as monto, fecha FROM transferencias WHERE remitente = %s
            ORDER BY fecha DESC
        ''', (usuario, usuario, usuario))
        movimientos = cur.fetchall()
        
        return render_template('saldo.html', saldo=saldo, usuario=usuario, movimientos=movimientos)
    else:
        return redirect('/login')


@app.route('/transferencia', methods=['GET', 'POST'])
def transferencia():
    if request.method == 'POST':
        if 'logueado' in session:
            
            usuario_remitente = session['usuario']
            contrasena_remitente = request.form['txt_contrasena']
            destinatario = request.form['txt_destinatario']
            correo_destinatario = request.form['txt_correo']
            monto_transferir = request.form['txt_monto']
            concepto_transferencia = request.form['txt_concepto']

            cur = mysql.connection.cursor()
            cur.execute('SELECT * FROM usuarios WHERE usuario = %s AND password = %s', (usuario_remitente, contrasena_remitente))
            remitente = cur.fetchone()
            if remitente:
                saldo_remitente = remitente['saldo']

                if saldo_remitente >= float(monto_transferir):
                    cur.execute('SELECT * FROM usuarios WHERE usuario = %s AND correo = %s', (destinatario, correo_destinatario))
                    destinatario_data = cur.fetchone()
                    if destinatario_data:
                        nuevo_saldo_remitente = saldo_remitente - float(monto_transferir)
                        nuevo_saldo_destinatario = destinatario_data['saldo'] + float(monto_transferir)
                        
                        cur.execute('UPDATE usuarios SET saldo = %s WHERE usuario = %s', (nuevo_saldo_remitente, usuario_remitente))
                        cur.execute('UPDATE usuarios SET saldo = %s WHERE usuario = %s', (nuevo_saldo_destinatario, destinatario))
                        mysql.connection.commit()
                        
                        cur.execute('INSERT INTO transferencias (remitente, destinatario, monto, concepto, fecha) VALUES (%s, %s, %s, %s, NOW())',
                                    (usuario_remitente, destinatario, monto_transferir, concepto_transferencia))
                        mysql.connection.commit()

                        session['saldo'] = nuevo_saldo_remitente

                        return render_template('transferencia.html', mensaje="Transferencia realizada con éxito", usuario=usuario_remitente)
                    else:
                        return render_template('transferencia.html', mensaje="Destinatario no encontrado", usuario=usuario_remitente)
                else:
                    return render_template('transferencia.html', mensaje="Saldo insuficiente", usuario=usuario_remitente)
            else:
                return render_template('transferencia.html', mensaje="Contraseña incorrecta", usuario=usuario_remitente)
    elif 'logueado' in session:
        usuario_remitente = session['usuario']
        return render_template('transferencia.html', usuario=usuario_remitente)
    else:
        return redirect('/login')

@app.route('/pago_cuotas', methods=['GET', 'POST'])
def pago_cuotas():
    mensaje = ""
    usuario = session['usuario'] if 'logueado' in session else None
    if request.method == 'POST' and usuario:
        prestamo_id = request.form['prestamo_id']
        num_cuotas = int(request.form['num_cuotas'])
        monto_pago = Decimal(request.form['monto_pago'])

        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM prestamos WHERE id = %s AND usuario = %s AND estatus = %s', (prestamo_id, usuario, 'aprobado'))
        prestamo = cur.fetchone()

        if prestamo:
            cuotas_restantes = prestamo['cuotas_restantes']
            monto_restante = Decimal(prestamo['monto_restante'])

            try:
                # Aplicar interés simple del 10% al monto restante
                interes = monto_restante * Decimal('0.10')
                monto_restante_con_interes = monto_restante + interes

                # Restringir el pago para la última cuota
                if cuotas_restantes == 1 and (num_cuotas != 1 or monto_pago < monto_restante_con_interes):
                    mensaje = f"Solo queda una cuota, debes pagar el monto total restante con interés de {monto_restante_con_interes:.2f}."
                    prestamos = [{'id': prestamo_id, 'monto_restante': prestamo['monto_restante'], 'cuotas_restantes': cuotas_restantes, 'fecha': prestamo['fecha'], 'estatus': prestamo['estatus'], 'monto_con_interes': round(monto_restante_con_interes, 2)}]
                    return render_template('pago_cuotas.html', mensaje=mensaje, usuario=usuario, prestamos=prestamos)

                monto_cuota = monto_restante_con_interes / cuotas_restantes
                if monto_pago < (monto_cuota * num_cuotas):
                    mensaje = f"El monto a pagar debe ser al menos {monto_cuota * num_cuotas:.2f} para {num_cuotas} cuotas."
                    prestamos = [{'id': prestamo_id, 'monto_restante': prestamo['monto_restante'], 'cuotas_restantes': cuotas_restantes, 'fecha': prestamo['fecha'], 'estatus': prestamo['estatus'], 'monto_con_interes': round(monto_restante_con_interes, 2)}]
                    return render_template('pago_cuotas.html', mensaje=mensaje, usuario=usuario, prestamos=prestamos)

                nuevo_monto_restante = monto_restante_con_interes - monto_pago
                nuevas_cuotas_restantes = max(cuotas_restantes - num_cuotas, 0)
                nuevo_estatus = 'pagado' if nuevo_monto_restante <= 0 else 'aprobado'

                if nuevo_monto_restante < 0:
                    monto_pago += nuevo_monto_restante
                    nuevo_monto_restante = 0

                cur.execute('UPDATE prestamos SET monto_restante = %s, cuotas_restantes = %s, estatus = %s WHERE id = %s AND usuario = %s', 
                            (nuevo_monto_restante, nuevas_cuotas_restantes, nuevo_estatus, prestamo_id, usuario))
                mysql.connection.commit()

                cur.execute('UPDATE usuarios SET saldo = saldo - %s WHERE usuario = %s', (monto_pago, usuario))
                mysql.connection.commit()

                cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())',
                            (usuario, 'prestamo', 'Pago de cuota realizado con éxito'))
                mysql.connection.commit()

            except Exception as e:
                mensaje = f"Ocurrió un error durante el cálculo: {str(e)}"
                prestamos = [{'id': prestamo_id, 'monto_restante': prestamo['monto_restante'], 'cuotas_restantes': cuotas_restantes, 'fecha': prestamo['fecha'], 'estatus': prestamo['estatus'], 'monto_con_interes': round(monto_restante_con_interes, 2) if 'monto_restante_con_interes' in locals() else None}]
                return render_template('pago_cuotas.html', mensaje=mensaje, usuario=usuario, prestamos=prestamos)
        else:
            mensaje = "Préstamo no encontrado o no aprobado"
            prestamos = []

    # Recargar la lista de préstamos aprobados para el usuario y mostrar el mensaje de éxito
    cur = mysql.connection.cursor()
    cur.execute('SELECT * FROM prestamos WHERE usuario = %s AND estatus = %s', (usuario, 'aprobado'))
    prestamos = cur.fetchall()

    prestamos_actualizados = []
    for prestamo in prestamos:
        monto_restante = Decimal(prestamo['monto_restante'])
        interes = monto_restante * Decimal('0.10')
        monto_con_interes = monto_restante + interes
        prestamo['monto_con_interes'] = round(monto_con_interes, 2)
        prestamos_actualizados.append(prestamo)

    return render_template('pago_cuotas.html', mensaje=mensaje, usuario=usuario, prestamos=prestamos_actualizados)

@app.route('/ver_prestamos')
def ver_prestamos():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM prestamos WHERE usuario = %s AND estatus = %s', (usuario, 'aprobado'))
        prestamos = cur.fetchall()
        return render_template('ver_prestamos.html', prestamos=prestamos, usuario=usuario)
    else:
        return redirect('/login')

@app.route('/compra_venta_dolares', methods=['GET', 'POST'])
def compra_venta_dolares():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        mensaje = ""  # Asegurarse de que mensaje siempre esté definido

        if request.method == 'POST':
            tipo_operacion = request.form['tipo_operacion']
            monto = Decimal(request.form['monto'])  # Convertir a Decimal
            tasa_cambio = Decimal(61.0)  # Supongamos una tasa de cambio fija de 61 Bs. por dólar

            if tipo_operacion == 'compra':
                # Realizar compra de dólares
                cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
                saldo_bs = Decimal(cur.fetchone()['saldo'])  # Convertir a Decimal
                costo_compra = monto * tasa_cambio
                if saldo_bs >= costo_compra:
                    nuevo_saldo_bs = saldo_bs - costo_compra
                    cur.execute('UPDATE usuarios SET saldo = %s WHERE usuario = %s', (nuevo_saldo_bs, usuario))
                    cur.execute('UPDATE usuarios SET saldo_dolares = saldo_dolares + %s WHERE usuario = %s', (monto, usuario))
                    mysql.connection.commit()
                    mensaje = f"Compra de {monto} dólares realizada con éxito"
                    
                    # Insertar notificación de compra
                    cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())',
                                (usuario, 'compra', f"realizada: {monto} dólares"))
                    mysql.connection.commit()
                else:
                    mensaje = "Saldo insuficiente para la compra"

            elif tipo_operacion == 'venta':
                # Realizar venta de dólares
                cur.execute('SELECT saldo_dolares FROM usuarios WHERE usuario = %s', (usuario,))
                saldo_dolares = Decimal(cur.fetchone()['saldo_dolares'])  # Convertir a Decimal
                if saldo_dolares >= monto:
                    nuevo_saldo_dolares = saldo_dolares - monto
                    cur.execute('UPDATE usuarios SET saldo_dolares = %s WHERE usuario = %s', (nuevo_saldo_dolares, usuario))
                    nuevo_saldo_bs = monto * tasa_cambio  # Calcular el saldo a agregar
                    cur.execute('UPDATE usuarios SET saldo = saldo + %s WHERE usuario = %s', (nuevo_saldo_bs, usuario))
                    mysql.connection.commit()
                    mensaje = f"Venta de {monto} dólares realizada con éxito"
                    
                    # Insertar notificación de venta
                    cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())',
                                (usuario, 'venta', f"realizada: {monto} dólares"))
                    mysql.connection.commit()
                else:
                    mensaje = "Saldo en dólares insuficiente para la venta"

            cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
            saldo_bs = Decimal(cur.fetchone()['saldo'])  # Obtener el saldo actualizado
            cur.execute('SELECT saldo_dolares FROM usuarios WHERE usuario = %s', (usuario,))
            saldo_dolares = Decimal(cur.fetchone()['saldo_dolares'])  # Obtener el saldo en dólares actualizado

            return render_template('compra_venta_dolares.html', mensaje=mensaje, usuario=usuario, saldo_bs=saldo_bs, saldo_dolares=saldo_dolares)
        else:
            cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
            saldo_bs = Decimal(cur.fetchone()['saldo'])  # Obtener el saldo en bolívares
            cur.execute('SELECT saldo_dolares FROM usuarios WHERE usuario = %s', (usuario,))
            saldo_dolares = Decimal(cur.fetchone()['saldo_dolares'])  # Obtener el saldo en dólares

            return render_template('compra_venta_dolares.html', usuario=usuario, saldo_bs=saldo_bs, saldo_dolares=saldo_dolares, mensaje=mensaje)
    else:
        return redirect('/login')



@app.route('/administrador')
def administrador():
    return render_template('administrador.html')

@app.route('/deposito_admin')
def deposito_admin():
    if 'logueado' in session and session.get('usuario') == 'admin':
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM depositos')
        depositos = cur.fetchall()
        return render_template('deposito_admin.html', depositos=depositos, usuario=usuario)
    else:
        return redirect('/login')

@app.route('/validate_password', methods=['POST'])
def validate_password():
    data = request.get_json()
    password = data.get('password')
    usuario = session.get('usuario')
    cur = mysql.connection.cursor()
    cur.execute('SELECT password FROM usuarios WHERE usuario = %s', (usuario,))
    stored_password = cur.fetchone()['password']

    if password == stored_password:
        return jsonify({"valid": True})
    else:
        return jsonify({"valid": False})

if __name__ == '__main__':
    app.secret_key = 'miguel_hds'
    app.run(debug=True, host='0.0.0.0', port=5000)


