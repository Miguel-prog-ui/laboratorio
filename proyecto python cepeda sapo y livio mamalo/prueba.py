from flask import Flask, render_template, redirect, request, session
from flask_mysqldb import MySQL

app = Flask(__name__, template_folder='templates')

app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'login'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'
mysql = MySQL(app)

@app.route('/')
def home():
    return render_template('login.html')

@app.route('/admin')
def admin():
    return render_template('admin.html')

# Función de login
@app.route('/acceso_login', methods=["GET", "POST"])
def login():
    if request.method == 'POST' and 'txt_correo' in request.form and 'txt_password' in request.form:
        _correo = request.form['txt_correo']
        _password = request.form['txt_password']

        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM usuarios WHERE correo = %s AND password = %s', (_correo, _password,))
        account = cur.fetchone()

        if account:
            session['logueado'] = True
            session['id'] = account['id']
            return render_template('admin.html')
        else:
            return render_template('login.html', mensaje="Correo o contraseña incorrectos")

# Función para crear cuenta
@app.route('/crear_cuenta', methods=["GET", "POST"])
def crear_cuenta():
    if request.method == 'POST' and 'txt_correo' in request.form and 'txt_password' in request.form:
        _correo = request.form['txt_correo']
        _password = request.form['txt_password']

        cur = mysql.connection.cursor()
        cur.execute('INSERT INTO usuarios (correo, password) VALUES (%s, %s)', (_correo, _password,))
        mysql.connection.commit()
        return render_template('login.html', mensaje="Cuenta creada con éxito")

if __name__ == '__main__':
    app.secret_key = "miguel_hds"
    app.run(debug=True, host='0.0.0.0', port=5001, threaded=True)
