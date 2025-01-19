from flask import Flask, jsonify, render_template
from flask_mysqldb import MySQL

app = Flask(__name__)

# Configuración de MySQL
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'login'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'

mysql = MySQL(app)

@app.route('/datos', methods=['GET'])
def get_datos():
    cursor = mysql.connection.cursor()
    cursor.execute("SELECT id, monto, cuotas FROM prestamos WHERE estatus = 'aprobado'")
    datos = cursor.fetchall()
    cursor.close()
    return jsonify(datos)

@app.route('/mostrar_datos', methods=['GET'])
def mostrar_datos():
    return render_template('datos.html')

if __name__ == '__main__':
    app.run(debug=True)
