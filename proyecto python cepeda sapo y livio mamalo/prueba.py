from flask import Flask, render_template, session, redirect
from flask_mysqldb import MySQL

app = Flask(__name__)
app.secret_key = 'tu_secreto'

# Configuración de MySQL
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'tu_usuario'
app.config['MYSQL_PASSWORD'] = 'tu_contraseña'
app.config['MYSQL_DB'] = 'tu_base_de_datos'

mysql = MySQL(app)

@app.route('/admin')
def admin():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        
        # Obtener el saldo del usuario
        cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
        saldo = cur.fetchone()['saldo']
        
        # Obtener las transacciones y movimientos
        cur.execute('''
            SELECT 'Deposito' as tipo, deposito as monto, fecha FROM depositos_aprobados WHERE usuario = %s
            UNION ALL
            SELECT 'Transferencia Recibida' as tipo, monto as monto, fecha FROM transferencias WHERE destinatario = %s
            UNION ALL
            SELECT 'Transferencia Enviada' as tipo, -monto as monto, fecha FROM transferencias WHERE remitente = %s
            ORDER BY fecha DESC
        ''', (usuario, usuario, usuario))
        transacciones = cur.fetchall()
        
        # Notificaciones (Ejemplo de notificaciones estáticas, puedes adaptar esto según tus necesidades)
        notificaciones = [
            {'mensaje': 'Pago de servicios programado para mañana.'},
            {'mensaje': 'Nuevo depósito disponible.'},
        ]
        
        return render_template('admin.html', usuario=usuario, saldo=saldo, transacciones=transacciones, notificaciones=notificaciones)
    else:
        return redirect('/')

@app.route('/login')
def login():
    # Renderiza tu página de inicio de sesión
    return render_template('login.html')

if __name__ == '__main__':
    app.run(debug=True)
