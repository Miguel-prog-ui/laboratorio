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
        saldo = session['saldo']
        return render_template('admin.html', usuario=usuario, saldo=saldo)
    else:
        return redirect('/')

@app.route('/saldo')
def saldo():
    if 'logueado' in session:
        saldo=session['saldo']
        return render_template('saldo.html',saldo=saldo)

if __name__ == '__main__':
    app.secret_key = "miguel_hds"
    app.run(debug=True, host='0.0.0.0', port=5000, threaded=True)
