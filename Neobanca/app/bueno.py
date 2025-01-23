#Codigo laboratorio de programacion parcial 3
#fecha: 12/12/2024
#programadores:Miguel Mijares, Livio Garcia, Jeam-pierre Hermosilla, Isaac Rengifo
#version: 1.0.0

from flask import Flask
from flask import render_template, redirect, request, Response, session,jsonify
from flask_mysqldb import MySQL, MySQLdb
from decimal import Decimal

import ssl
import smtplib
from email.message import EmailMessage
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
    return render_template('home.html')

@app.route('/login')
def login():
    return render_template('login si.html')

@app.route('/contacto', methods=['GET', 'POST'])
def contacto():
    mensaje = ''
    if request.method == 'POST' and 'nombre_comentario' in request.form and 'email_comentario' in request.form and 'comentario_comentario' in request.form:
        _nombre_comentario = request.form['nombre_comentario']
        _email_comentario = request.form['email_comentario']
        _comentario_comentario = request.form['comentario_comentario']

        cur = mysql.connection.cursor()
        try:
            cur.execute('INSERT INTO comentarios(nombre, correo, comentario) VALUES (%s, %s, %s)',
                        (_nombre_comentario, _email_comentario, _comentario_comentario))
            mysql.connection.commit()
            mensaje = "Comentario enviado con éxito"
        except Exception as e:
            print(f"Error: {e}")
            mensaje = "Hubo un error al enviar tu comentario"
        finally:
            cur.close()

    return render_template('contacto.html', mensaje=mensaje)

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

@app.route('/compra_venta_dolares', methods=['POST'])
def compra_venta_dolares():
    if 'logueado' in session:
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        mensaje = ""

        tipo_operacion = request.json['tipo_operacion']
        monto = Decimal(request.json['monto'])
        tasa_cambio = Decimal(61.0)

        if tipo_operacion == 'compra':
            cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
            saldo_bs = Decimal(cur.fetchone()['saldo'])
            costo_compra = monto * tasa_cambio
            if saldo_bs >= costo_compra:
                nuevo_saldo_bs = saldo_bs - costo_compra
                cur.execute('UPDATE usuarios SET saldo = %s WHERE usuario = %s', (nuevo_saldo_bs, usuario))
                cur.execute('UPDATE usuarios SET saldo_dolares = saldo_dolares + %s WHERE usuario = %s', (monto, usuario))
                mysql.connection.commit()
                mensaje = f"Compra de {monto}$ realizada con éxito"
                
                # Insertar notificación de compra
                cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())',
                            (usuario, 'compra de divisas', f" realizada: {monto} $"))
                mysql.connection.commit()
            else:
                mensaje = "Saldo insuficiente para la compra"

        elif tipo_operacion == 'venta':
            cur.execute('SELECT saldo_dolares FROM usuarios WHERE usuario = %s', (usuario,))
            saldo_dolares = Decimal(cur.fetchone()['saldo_dolares'])
            if saldo_dolares >= monto:
                nuevo_saldo_dolares = saldo_dolares - monto
                cur.execute('UPDATE usuarios SET saldo_dolares = %s WHERE usuario = %s', (nuevo_saldo_dolares, usuario))
                nuevo_saldo_bs = monto * tasa_cambio
                cur.execute('UPDATE usuarios SET saldo = saldo + %s WHERE usuario = %s', (nuevo_saldo_bs, usuario))
                mysql.connection.commit()
                mensaje = f"Venta de {monto} dólares realizada con éxito"
                
                # Insertar notificación de venta
                cur.execute('INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) VALUES (%s, %s, %s, NOW())',
                            (usuario, 'venta de divisas', f" realizada: {monto} dólares"))
                mysql.connection.commit()
            else:
                mensaje = "Saldo en dólares insuficiente para la venta"

        cur.execute('SELECT saldo FROM usuarios WHERE usuario = %s', (usuario,))
        saldo_bs = Decimal(cur.fetchone()['saldo'])
        cur.execute('SELECT saldo_dolares FROM usuarios WHERE usuario = %s', (usuario,))
        saldo_dolares = Decimal(cur.fetchone()['saldo_dolares'])

        # Obtener las últimas notificaciones actualizadas
        cur.execute('''
            SELECT usuario, tipo, notificacion, fecha
            FROM notificaciones
            WHERE usuario = %s
            ORDER BY fecha DESC
            LIMIT 4
        ''', (usuario,))
        ultimas_notificaciones = cur.fetchall()

        # Formatear las notificaciones para enviarlas como JSON
        notificaciones = []
        for notificacion in ultimas_notificaciones:
            notificaciones.append({
                'tipo': notificacion['tipo'],
                'notificacion': notificacion['notificacion'],
                'fecha': notificacion['fecha'].strftime('%Y-%m-%d %H:%M:%S')
            })

        return jsonify(mensaje=mensaje, saldo=str(saldo_bs), saldo_dolares=str(saldo_dolares), notificaciones=notificaciones)
    else:
        return jsonify(mensaje="No logueado")



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
            monto = float(request.form['monto'])
            cuotas = int(request.form['cuotas'])
            cuotas_restantes = cuotas
            monto_restante = monto
            costo_cuotas = monto / cuotas

            cursor = mysql.connection.cursor()
            cursor.execute('''
                INSERT INTO prestamos (usuario, monto, cuotas, cuotas_restantes, monto_restante, costo_cuotas, fecha, estatus) 
                VALUES (%s, %s, %s, %s, %s, %s, NOW(), %s)
            ''', (usuario, monto, cuotas, cuotas_restantes, monto_restante, costo_cuotas, 'pendiente'))
            mysql.connection.commit()

            cursor.execute('''
                INSERT INTO notificaciones (usuario, tipo, notificacion, fecha) 
                VALUES (%s, %s, %s, NOW())
            ''', ('admin', 'prestamo', f'Solicitud de préstamo de {usuario}'))
            mysql.connection.commit()

            cursor.close()
            return jsonify({'mensaje': 'Solicitud de préstamo enviada con éxito'})
        else:
            return jsonify({'mensaje': 'Usuario no logueado'})
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
        cur.execute('SELECT saldo, saldo_dolares FROM usuarios WHERE usuario = %s', (usuario,))
        result = cur.fetchone()
        
        if result:
            saldo = result['saldo']
            saldo_dolares = result['saldo_dolares']
        else:
            saldo = 0  # Manejar el caso donde el usuario no tiene saldo registrado
            saldo_dolares = 0  # Manejar el caso donde el usuario no tiene saldo_dolares registrado
        
        cur.execute('''
            SELECT 'Deposito' as tipo, deposito as monto, fecha FROM depositos_aceptados WHERE usuario = %s
            UNION ALL
            SELECT CONCAT('Transferencia Recibida de ', remitente) as tipo, monto as monto, fecha FROM transferencias WHERE destinatario = %s
            UNION ALL
            SELECT CONCAT('Transferencia Enviada a ', destinatario) as tipo, -monto as monto, fecha FROM transferencias WHERE remitente = %s
            UNION ALL
            SELECT CONCAT('Transferencia Enviada a ', destinatario, ' al banco ', banco_destinatario) as tipo, -monto as monto, fecha FROM transferencias_otro_banco WHERE remitente = %s
            ORDER BY fecha DESC
        ''', (usuario, usuario, usuario, usuario))
        movimientos = cur.fetchall()
        
        return render_template('saldo.html', saldo=saldo, saldo_dolares=saldo_dolares, usuario=usuario, movimientos=movimientos)
    else:
        return redirect('/login')


@app.route('/transferencia', methods=['GET', 'POST'])
def transferencia():
    if request.method == 'POST':
        if 'logueado' in session:
            usuario_remitente = session['usuario']
            contrasena_remitente = request.form.get('txt_contrasena', '')
            destinatario = request.form.get('txt_destinatario', '')
            correo_destinatario = request.form.get('txt_correo', '')
            monto_transferir = float(request.form.get('txt_monto', 0))
            concepto_transferencia = request.form.get('txt_concepto', '')

            if 'txt_cuenta_externa' in request.form:
                # Transferencia a otro banco
                cuenta_externa = request.form.get('txt_cuenta_externa', '')
                banco_destinatario = request.form.get('txt_banco', '')
                nombre_destinatario = request.form.get('txt_nombre', '')

                cur = mysql.connection.cursor()
                cur.execute('SELECT * FROM usuarios WHERE usuario = %s AND password = %s', (usuario_remitente, contrasena_remitente))
                remitente = cur.fetchone()
                if remitente:
                    saldo_remitente = float(remitente['saldo'])

                    if saldo_remitente >= monto_transferir:
                        nuevo_saldo_remitente = saldo_remitente - monto_transferir

                        cur.execute('UPDATE usuarios SET saldo = %s WHERE usuario = %s', (nuevo_saldo_remitente, usuario_remitente))
                        mysql.connection.commit()
                        
                        # Guardar en la tabla transferencias
                        cur.execute('INSERT INTO transferencias (remitente, destinatario, monto, concepto, fecha) VALUES (%s, %s, %s, %s, NOW())',
                                    (usuario_remitente, nombre_destinatario, monto_transferir, concepto_transferencia))
                        mysql.connection.commit()

                        # Guardar en la tabla transferencias_otro_banco
                        cur.execute('INSERT INTO transferencias_otro_banco (remitente, destinatario, monto, concepto, fecha, banco_destinatario, cuenta_externa) VALUES (%s, %s, %s, %s, NOW(), %s, %s)',
                                    (usuario_remitente, nombre_destinatario, monto_transferir, concepto_transferencia, banco_destinatario, cuenta_externa))
                        mysql.connection.commit()

                        session['saldo'] = nuevo_saldo_remitente

                        return render_template('transferencia.html', mensaje="Transferencia a otro banco realizada con éxito", usuario=usuario_remitente)
                    else:
                        return render_template('transferencia.html', mensaje="Saldo insuficiente", usuario=usuario_remitente)
            else:
                # Transferencia interna
                cur = mysql.connection.cursor()
                cur.execute('SELECT * FROM usuarios WHERE usuario = %s AND password = %s', (usuario_remitente, contrasena_remitente))
                remitente = cur.fetchone()
                if remitente:
                    saldo_remitente = float(remitente['saldo'])

                    if saldo_remitente >= monto_transferir:
                        cur.execute('SELECT * FROM usuarios WHERE usuario = %s AND correo = %s', (destinatario, correo_destinatario))
                        destinatario_data = cur.fetchone()
                        if destinatario_data:
                            nuevo_saldo_remitente = saldo_remitente - monto_transferir
                            nuevo_saldo_destinatario = float(destinatario_data['saldo']) + monto_transferir
                            
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

@app.route('/prestamo_aprobado')
def prestamo_aprobado():
    if 'logueado' in session and session.get('usuario') == 'admin':
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        cur.execute('SELECT * FROM prestamos WHERE estatus = %s', ('aprobado',))
        prestamos = cur.fetchall()
        return render_template('prestamo.html', prestamos=prestamos, usuario=usuario)
    else:
        return redirect('/login')


#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

@app.route('/administrador')
def administrador():
    if 'logueado' in session and session.get('usuario') == 'admin':
        usuario = session['usuario']
    return render_template('administrador.html',usuario=usuario)

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
    
@app.route('/comentarios_admin', methods=['GET', 'POST'])
def comentarios_admin():
    if 'logueado' in session and session.get('usuario') == 'admin':
        usuario = session['usuario']
        cur = mysql.connection.cursor()
        cur.execute('SELECT id, nombre, correo, comentario, fecha FROM comentarios')
        comentarios = cur.fetchall()
        cur.close()
        return render_template('comentarios_admin.html', comentarios=comentarios, usuario=usuario)
    else:
        return redirect('/login')

@app.route('/eliminar_comentario', methods=['POST'])
def eliminar_comentario():
    if 'logueado' in session and session.get('usuario') == 'admin':
        comentario_id = request.form['comentario_id']
        cur = mysql.connection.cursor()
        cur.execute('DELETE FROM comentarios WHERE id = %s', [comentario_id])
        mysql.connection.commit()
        cur.close()
        return redirect('/comentarios_admin')
    else:
        return redirect('/login')

@app.route('/responder_comentario', methods=['POST'])
def responder_comentario():
    if 'logueado' in session and session.get('usuario') == 'admin':
        comentario_id = request.form['comentario_id']
        respuesta = request.form['respuesta']
        
        # Obtener el correo del usuario que hizo el comentario
        cur = mysql.connection.cursor()
        cur.execute('SELECT correo FROM comentarios WHERE id = %s', [comentario_id])
        comentario = cur.fetchone()
        cur.close()
        
        if comentario and 'correo' in comentario:
            destinatario = comentario['correo']
            enviar_correo(destinatario, 'Respuesta a tu comentario', respuesta)
        
        return redirect('/comentarios_admin')
    else:
        return redirect('/login')

def enviar_correo(destinatario, asunto, cuerpo):
    remitente = 'neobancausm@gmail.com'
    contraseña = 'ghye ausc euli spma'

    em = EmailMessage()
    em['From'] = remitente
    em['To'] = destinatario
    em['Subject'] = asunto
    em.set_content(cuerpo)
    em.add_alternative(render_template('email_template.html', asunto=asunto, cuerpo=cuerpo), subtype='html')

    context = ssl.create_default_context()

    with smtplib.SMTP_SSL('smtp.gmail.com', 465, context=context) as smtp:
        smtp.login(remitente, contraseña)
        smtp.sendmail(remitente, destinatario, em.as_string())

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
    
@app.route('/datos', methods=['GET'])
def get_datos():
    if 'logueado' in session:
        usuario = session['usuario']
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT id, monto, cuotas, cuotas_restantes, monto_restante, costo_cuotas FROM prestamos WHERE estatus = 'aprobado' AND usuario = %s", (usuario,))
        datos = cursor.fetchall()
        cursor.close()
        return jsonify(datos)
    else:
        return jsonify({'mensaje': 'Usuario no logueado'})

@app.route('/insertar', methods=['POST'])
def insertar_datos():
    if 'logueado' in session:
        usuario = session['usuario']
        datos = request.get_json()
        monto = float(datos['monto'])
        cuotas = int(datos['cuotas'])
        cuotas_restantes = cuotas
        monto_restante = monto
        costo_cuotas = monto / cuotas
        
        cursor = mysql.connection.cursor()
        cursor.execute(
            "INSERT INTO prestamos (monto, cuotas, cuotas_restantes, monto_restante, costo_cuotas, estatus, usuario) VALUES (%s, %s, %s, %s, %s, 'aprobado', %s)",
            (monto, cuotas, cuotas_restantes, monto_restante, costo_cuotas, usuario)
        )
        mysql.connection.commit()
        cursor.close()
        return jsonify({'mensaje': 'Datos insertados exitosamente'})
    else:
        return jsonify({'mensaje': 'Usuario no logueado'})

@app.route('/pagar/<int:id>', methods=['POST'])
def pagar_cuota(id):
    if 'logueado' in session:
        usuario = session['usuario']
        cursor = mysql.connection.cursor()

        # Obtener el préstamo del usuario
        cursor.execute("SELECT cuotas_restantes, monto_restante, costo_cuotas FROM prestamos WHERE id = %s AND usuario = %s", (id, usuario))
        prestamo = cursor.fetchone()

        if prestamo and prestamo['cuotas_restantes'] > 0:
            # Calcular nuevas cuotas restantes y nuevo monto restante
            nuevas_cuotas_restantes = prestamo['cuotas_restantes'] - 1
            nuevo_monto_restante = prestamo['monto_restante'] - prestamo['costo_cuotas']

            # Obtener el saldo actual del usuario
            cursor.execute("SELECT saldo FROM usuarios WHERE usuario = %s", (usuario,))
            usuario_data = cursor.fetchone()
            saldo_actual = usuario_data['saldo']

            # Verificar si el usuario tiene suficiente saldo para pagar la cuota
            if saldo_actual >= prestamo['costo_cuotas']:
                nuevo_saldo = saldo_actual - prestamo['costo_cuotas']

                # Actualizar el saldo del usuario en la base de datos
                cursor.execute("UPDATE usuarios SET saldo = %s WHERE usuario = %s", (nuevo_saldo, usuario))

                # Actualizar o eliminar el préstamo según las cuotas restantes y monto restante
                if nuevas_cuotas_restantes == 0 and nuevo_monto_restante <= 0:
                    cursor.execute("DELETE FROM prestamos WHERE id = %s AND usuario = %s", (id, usuario))
                else:
                    cursor.execute(
                        "UPDATE prestamos SET cuotas_restantes = %s, monto_restante = %s WHERE id = %s AND usuario = %s",
                        (nuevas_cuotas_restantes, nuevo_monto_restante, id, usuario)
                    )
                mysql.connection.commit()
                mensaje = 'Pago de cuota exitoso'
            else:
                mensaje = 'Saldo insuficiente para pagar la cuota'
        else:
            mensaje = 'No se pudo procesar el pago de cuota'

        cursor.close()
        return jsonify({'mensaje': mensaje})
    else:
        return jsonify({'mensaje': 'Usuario no logueado'})


@app.route('/prestamo', methods=['GET'])
def prestamo():
    return render_template('prestamo.html')


if __name__ == '__main__':
    app.secret_key = 'miguel_hds'
    app.run(debug=True, host='0.0.0.0', port=5000)

#ghye ausc euli spma