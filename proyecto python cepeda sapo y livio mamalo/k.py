
# Función para crear cuenta
@app.route('/registrar', methods=["GET", "POST"])
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
        cur.execute('SELECT * FROM usuarios WHERE nombre_usuario = %s', (_usuario,))
        user_exists = cur.fetchone()

        if email_exists:
            return render_template('login si.html', mensaje_malo="El correo ya está registrado")
        elif user_exists:
            return render_template('login si.html', mensaje_malo="El nombre de usuario ya está en uso")
        else:
            cur.execute('INSERT INTO usuarios (correo, password, usuario) VALUES (%s, %s, %s)', (_correo, _password, _usuario))
            mysql.connection.commit()
            return render_template('login si.html', mensaje="Cuenta creada con éxito")
    
    return render_template('login si.html')
