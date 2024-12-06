from flask import Flask
from flask import render_template, redirect, request, Response, session
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
def loginn():
    return render_template('login si.html')

@app.route('/contacto')
def contacto():
    return render_template('/contacto.html')


# Función de login--------------------------------------------------------------------------------------------------------------------
@app.route('/acceso_login', methods=["GET", "POST"])
def login():
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
                session['usuario'] = account['usuario']
                return render_template('administrador.html')
        else:
            return render_template('login si.html', mensaje_malo="nombre de usuario o contraseña incorrectos")
    return render_template('login si.html')

#funcion para crear cuenta---------------------------------------------------------------------------------------------------------    
@app.route('/crear_cuenta', methods=["GET", "POST"])
def crear_cuenta():
    if request.method == 'POST' and 'txt_correo' in request.form and 'txt_password' in request.form and 'txt_usuario' in request.form:
        _correo = request.form['txt_correo']
        _password = request.form['txt_password']
        _usuario= request.form['txt_usuario']

        cur = mysql.connection.cursor()
        
        # Verificar si el correo ya existe
        cur.execute('SELECT * FROM usuarios WHERE correo = %s', (_correo,))
        email_exists = cur.fetchone()

        # Verificar si el nombre de usuario ya existe
        cur.execute('SELECT * FROM usuarios WHERE usuario = %s', (_usuario,))
        user_exists = cur.fetchone()

        if email_exists:
            return render_template('login si.html', mensaje_malo="El correo ya está registrado")
        elif user_exists:
            return render_template('login si.html', mensaje_malo="El nombre de usuario ya está en uso")
        else:
            cur.execute('INSERT INTO usuarios (correo, password, usuario, saldo) VALUES (%s, %s, %s, %s)', (_correo, _password, _usuario, 0))  # Asigna un saldo inicial, por ejemplo 0
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
        
        # Notificaciones (Ejemplo de notificaciones estáticas, puedes adaptar esto según tus necesidades)
        notificaciones = [
            {'mensaje': 'Pago de servicios programado para mañana.'},
            {'mensaje': 'Nuevo depósito disponible.'},
        ]
        
        return render_template('admin.html', usuario=usuario, saldo=saldo, transacciones=transacciones, notificaciones=notificaciones)
    else:
        return redirect('/login')



#funcion para el saldo---------------------------------------------------------------------------------------------------------    
@app.route('/saldo')
def saldo():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        
        # Obtener el saldo del usuario
        cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
        saldo = cur.fetchone()['saldo']
        
        # Obtener los movimientos del usuario
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



#funcion para crear deposito---------------------------------------------------------------------------------------------------------    
@app.route('/deposito', methods=["GET", "POST"])
def deposito():
    if request.method == "POST":
        if 'logueado' in session:
            usuario = session['usuario']
            monto_deposito = request.form['txt_deposito']  # Obtener el valor del formulario

            cur = mysql.connection.cursor()
            # Incluir la fecha y hora del depósito
            cur.execute('INSERT INTO depositos (usuario, deposito, fecha) VALUES (%s, %s, NOW())', (usuario, monto_deposito))
            mysql.connection.commit()
            return render_template('deposito.html', mensaje="Depósito realizado con éxito. Por favor espera a que un administrador acepte tu deposito", usuario=usuario)
        else:
            return redirect('/login')
    elif 'logueado' in session:
        usuario = session['usuario']
        return render_template('deposito.html', usuario=usuario)
    else:
        return redirect('/login')


#funcion para crear transferencia---------------------------------------------------------------------------------------------------------    
@app.route('/transferencia', methods=["GET", "POST"])
def transferencia():
    if request.method == 'POST':
        if 'logueado' in session:
            usuario_remitente = session['usuario']
            contraseña_remitente = request.form['txt_contraseña']
            destinatario = request.form['txt_destinatario']
            correo_destinatario = request.form['txt_correo']
            monto_transferir = request.form['txt_monto']
            concepto_transferencia = request.form['txt_concepto']

            cur = mysql.connection.cursor()

            # Verificar la contraseña del remitente
            cur.execute('SELECT * FROM usuarios WHERE usuario = %s AND password = %s', (usuario_remitente, contraseña_remitente))
            remitente = cur.fetchone()
            if remitente:
                saldo_remitente = remitente['saldo']

                # Verificar que el remitente tenga suficiente saldo
                if saldo_remitente >= float(monto_transferir):
                    # Verificar los datos del destinatario
                    cur.execute('SELECT * FROM usuarios WHERE usuario = %s AND correo = %s', (destinatario, correo_destinatario))
                    destinatario_data = cur.fetchone()
                    if destinatario_data:
                        # Realizar la transferencia
                        nuevo_saldo_remitente = saldo_remitente - float(monto_transferir)
                        nuevo_saldo_destinatario = destinatario_data['saldo'] + float(monto_transferir)

                        # Actualizar los saldos en la base de datos
                        cur.execute('UPDATE usuarios SET saldo = %s WHERE usuario = %s', (nuevo_saldo_remitente, usuario_remitente))
                        cur.execute('UPDATE usuarios SET saldo = %s WHERE usuario = %s', (nuevo_saldo_destinatario, destinatario))
                        mysql.connection.commit()

                        # Insertar los detalles de la transferencia en la base de datos
                        cur.execute('INSERT INTO transferencias (remitente, destinatario, monto, concepto, fecha) VALUES (%s, %s, %s, %s, NOW())', 
                                    (usuario_remitente, destinatario, monto_transferir,concepto_transferencia))
                        mysql.connection.commit()

                        # Actualización del saldo en la sesión
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
#ADMINISTRADOR/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#ADMINISTRADOR/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@app.route('/administrador')
def administrador():
    return render_template('administrador.html')

@app.route('/deposito_admin')
def deposito_admin():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM depositos')
        depositos = cur.fetchall()  # Obtener todas las filas
        return render_template('deposito_admin.html', depositos=depositos, usuario=usuario)
    else:
        return redirect('/login')

@app.route('/aceptar_deposito', methods=["POST"])
def aceptar_deposito():
    if 'logueado' in session:
        deposito_id = request.form['deposito_id']
        cur = mysql.connection.cursor()
        
        # Obtener el depósito
        cur.execute('SELECT * FROM depositos WHERE id = %s', (deposito_id,))
        deposito = cur.fetchone()
        
        if deposito:
            usuario = deposito['usuario']
            monto = deposito['deposito']
            fecha = deposito['fecha']  # Asumiendo que la columna fecha existe
            
            # Actualizar el saldo del usuario
            cur.execute('UPDATE usuarios SET saldo = saldo + %s WHERE usuario = %s', (monto, usuario))
            mysql.connection.commit()
            
            # Insertar el depósito en la tabla de depósitos aceptados
            cur.execute('INSERT INTO depositos_aceptados (usuario, deposito, fecha) VALUES (%s, %s, %s)', (usuario, monto, fecha))
            mysql.connection.commit()
            
            # Eliminar el depósito de la tabla de depósitos pendientes
            cur.execute('DELETE FROM depositos WHERE id = %s', (deposito_id,))
            mysql.connection.commit()
        
        return redirect('/deposito_admin')
    else:
        return redirect('/login')


@app.route('/rechazar_deposito', methods=["POST"])
def rechazar_deposito():
    if 'logueado' in session:
        deposito_id = request.form['deposito_id']
        cur = mysql.connection.cursor()
        
        # Eliminar el depósito de la tabla de depósitos pendientes
        cur.execute('DELETE FROM depositos WHERE id = %s', (deposito_id,))
        mysql.connection.commit()
        
        return redirect('/deposito_admin')
    else:
        return redirect('/login')

@app.route('/pagos_servicios')
def targeta_debito():
    return render_template('/tarjeta.html')

if __name__ == '__main__':
    app.secret_key = "miguel_hds"
    app.run(debug=True, host='0.0.0.0', port=5000, threaded=True)
