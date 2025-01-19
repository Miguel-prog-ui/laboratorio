#Codigo laboratorio de programacion parcial 3
#fecha: 12/12/2024
#programadores:Miguel Mijares, Livio Garcia, Jeam-pierre Hermosilla, Isaac Rengifo
#version: 1.0.0

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
    if request.method == 'POST' and 'txt_correo' in request.form and 'txt_password' in request.form:
        _correo = request.form['txt_correo']
        _password = request.form['txt_password']

        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM usuarios WHERE correo = %s AND password = %s', (_correo, _password,))
        account = cur.fetchone()

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
    if request.method == 'POST' and 'txt_correo' in request.form and 'txt_password' in request.form and 'txt_usuario' in request.form:
        _correo = request.form['txt_correo']
        _password = request.form['txt_password']
        _usuario = request.form['txt_usuario']

        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM usuarios WHERE correo = %s', (_correo,))
        email_exists = cur.fetchone()
        cur.execute('SELECT * FROM usuarios WHERE usuario = %s', (_usuario,))
        user_exists = cur.fetchone()

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
        
        return render_template('admin.html', usuario=usuario, saldo=saldo, transacciones=transacciones, ultimas_notificaciones=ultimas_notificaciones, todas_notificaciones=todas_notificaciones)
    else:
        return redirect('/login')

@app.route('/admin_dashboard')
def admin_dashboard():
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

            # Actualizar el estado del préstamo a aprobado
            cur.execute('UPDATE prestamos SET estatus = %s WHERE id = %s', ('aprobado', prestamo_id))
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
#
