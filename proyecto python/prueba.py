from flask import Flask, render_template, redirect, request, session, jsonify
from flask_mysqldb import MySQL, MySQLdb

app = Flask(__name__, template_folder='templates')

app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'login'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'
mysql = MySQL(app)
#xd
@app.route('/')
def home():
    return render_template('home.html')

@app.route('/login')
def loginn():
    return render_template('login si.html')

@app.route('/contacto')
def contacto():
    return render_template('/contacto.html')

# Ruta para validar la contraseña
@app.route('/validate_password', methods=['POST'])
def validate_password():
    data = request.get_json()
    password = data.get('password')
    usuario = session.get('usuario')  # Obtener el usuario de la sesión

    cur = mysql.connection.cursor()
    cur.execute('SELECT password FROM usuarios WHERE usuario = %s', (usuario,))
    stored_password = cur.fetchone()['password']

    if password == stored_password:
        return jsonify({"valid": True})
    else:
        return jsonify({"valid": False})

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

if __name__ == '__main__':
    app.run(debug=True)
