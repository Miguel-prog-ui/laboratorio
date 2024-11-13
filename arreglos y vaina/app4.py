from flask import Flask, render_template, request

app = Flask(__name__)

class NodoMunicipio:
    def __init__(self, nombre):
        self.nombre = nombre
        self.siguiente = None

class NodoEstado:
    def __init__(self, nombre):
        self.nombre = nombre
        self.municipios = None
        self.siguiente = None

class ListaEnlazada:
    def __init__(self):
        self.cabeza = None

    def agregar_estado(self, nombre_estado, municipios):
        nuevo_estado = NodoEstado(nombre_estado)
        nuevo_estado.municipios = self.crear_lista_municipios(municipios)
        if self.cabeza is None:
            self.cabeza = nuevo_estado
        else:
            ultimo = self.cabeza
            while ultimo.siguiente:
                ultimo = ultimo.siguiente
            ultimo.siguiente = nuevo_estado

    def crear_lista_municipios(self, municipios):
        cabeza_municipios = None
        for nombre_municipio in municipios:
            nuevo_municipio = NodoMunicipio(nombre_municipio)
            if cabeza_municipios is None:
                cabeza_municipios = nuevo_municipio
            else:
                ultimo = cabeza_municipios
                while ultimo.siguiente:
                    ultimo = ultimo.siguiente
                ultimo.siguiente = nuevo_municipio
        return cabeza_municipios

    def obtener_datos(self):
        estados = []
        estado_actual = self.cabeza
        while estado_actual:
            municipios = []
            municipio_actual = estado_actual.municipios
            while municipio_actual:
                municipios.append(municipio_actual.nombre)
                municipio_actual = municipio_actual.siguiente
            estados.append({'nombre': estado_actual.nombre, 'municipios': municipios})
            estado_actual = estado_actual.siguiente
        return estados

@app.route('/')
def index():
    estados_y_municipios = ListaEnlazada()

    # Agregar estados y municipios aquí
    estados_y_municipios.agregar_estado('Amazonas', ['Alto Orinoco', 'Atabapo', 'Atures', 'Autana', 'Manapiare', 'Maroa', 'Río Negro'])
    estados_y_municipios.agregar_estado('Anzoátegui', ['Anaco', 'Aragua', 'Diego Bautista Urbaneja', 'Fernando de Peñalver', 'Francisco de Miranda', 'Francisco del Carmen Carvajal', 'Guanta', 'Independencia', 'José Gregorio Monagas', 'Juan Antonio Sotillo', 'Juan Manuel Cajigal', 'Libertad', 'Manuel Ezequiel Bruzual', 'Pedro María Freites', 'Píritu', 'San José de Guanipa', 'San Juan de Capistrano', 'Santa Ana', 'Simón Bolívar', 'Simón Rodríguez'])
    estados_y_municipios.agregar_estado('Apure', ['Achaguas', 'Biruaca', 'Muñoz', 'Páez', 'Pedro Camejo', 'Rómulo Gallegos', 'San Fernando'])
    estados_y_municipios.agregar_estado('Aragua', ['Bolívar', 'Camatagua', 'Francisco Linares Alcántara', 'Girardot', 'José Ángel Lamas', 'José Félix Ribas', 'José Rafael Revenga', 'Libertador', 'Mario Briceño Iragorry', 'Ocumare de la Costa de Oro', 'San Casimiro', 'San Sebastián', 'Santiago Mariño', 'Santos Michelena', 'Sucre', 'Tovar', 'Urdaneta', 'Zamora'])
    estados_y_municipios.agregar_estado('Barinas', ['Alberto Arvelo Torrealba', 'Andrés Eloy Blanco', 'Antonio José de Sucre', 'Arismendi', 'Barinas', 'Bolívar', 'Cruz Paredes', 'Ezequiel Zamora', 'Obispos', 'Pedraza', 'Rojas', 'Sosa'])
    estados_y_municipios.agregar_estado('Bolívar', ['Angostura (Ciudad Bolívar)', 'Caroní', 'Cedeño', 'El Callao', 'Gran Sabana', 'Heres', 'Padre Pedro Chien', 'Piar', 'Roscio', 'Sifontes', 'Sucre'])
    estados_y_municipios.agregar_estado('Carabobo', ['Bejuma', 'Carlos Arvelo', 'Diego Ibarra', 'Guacara', 'Juan José Mora', 'Libertador', 'Los Guayos', 'Miranda', 'Montalbán', 'Naguanagua', 'Puerto Cabello', 'San Diego', 'San Joaquín', 'Valencia'])
    estados_y_municipios.agregar_estado('Cojedes', ['Anzoátegui', 'Falcón', 'Girardot', 'Lima Blanco', 'Pao de San Juan Bautista', 'Ricaurte', 'Rómulo Gallegos', 'San Carlos', 'Tinaco'])
    estados_y_municipios.agregar_estado('Delta Amacuro', ['Antonio Díaz', 'Casacoima', 'Pedernales', 'Tucupita'])
    estados_y_municipios.agregar_estado('Distrito Capital', ['Libertador'])
    estados_y_municipios.agregar_estado('Falcón', ['Acosta', 'Bolívar', 'Buchivacoa', 'Cacique Manaure', 'Carirubana', 'Colina', 'Dabajuro', 'Democracia', 'Federación', 'Jacura', 'Los Taques', 'Mauroa', 'Miranda', 'Monseñor Iturriza', 'Palmasola', 'Petit', 'Píritu', 'San Francisco', 'Silva', 'Sucre', 'Tocópero', 'Unión', 'Urumaco', 'Zamora'])
    estados_y_municipios.agregar_estado('Guárico', ['Camaguán', 'Chaguaramas', 'El Socorro', 'Francisco de Miranda', 'José Félix Ribas', 'José Tadeo Monagas', 'Juan Germán Roscio', 'Julián Mellado', 'Las Mercedes', 'Leonardo Infante', 'Pedro Zaraza', 'San Gerónimo de Guayabal', 'San José de Guaribe', 'Santa María de Ipire'])
    estados_y_municipios.agregar_estado('Lara', ['Andrés Eloy Blanco', 'Crespo', 'Iribarren', 'Jiménez', 'Morán', 'Palavecino', 'Simón Planas', 'Torres', 'Urdaneta'])
    estados_y_municipios.agregar_estado('Mérida', ['Alberto Adriani', 'Andrés Bello', 'Antonio Pinto Salinas', 'Aricagua', 'Arzobispo Chacón', 'Campo Elías', 'Caracciolo Parra Olmedo', 'Cardenal Quintero', 'Guaraque', 'Julio César Salas', 'Justo Briceño', 'Libertador', 'Miranda', 'Obispo Ramos de Lora', 'Padre Noguera', 'Pueblo Llano', 'Rangel', 'Rivas Dávila', 'Santos Marquina', 'Sucre', 'Tovar', 'Tulio Febres Cordero', 'Zea'])
    estados_y_municipios.agregar_estado('Miranda', ['Acevedo', 'Andrés Bello', 'Baruta', 'Brión', 'Buroz', 'Carrizal', 'Chacao', 'Cristóbal Rojas', 'El Hatillo', 'Guaicaipuro', 'Independencia', 'Lander', 'Los Salias', 'Páez', 'Paz Castillo', 'Plaza', 'Simón Bolívar', 'Sucre', 'Urdaneta', 'Zamora'])
    estados_y_municipios.agregar_estado('Monagas', ['Acosta', 'Aguasay', 'Bolívar', 'Caripe', 'Cedeño', 'Ezequiel Zamora', 'Libertador', 'Maturín', 'Piar', 'Punceres', 'Santa Bárbara', 'Sotillo', 'Uracoa'])
    estados_y_municipios.agregar_estado('Nueva Esparta', ['Antolín del Campo', 'Arismendi', 'Díaz', 'García', 'Gómez', 'Maneiro', 'Marcano', 'Mariño', 'Península de Macanao', 'Tubores', 'Villalba'])
    estados_y_municipios.agregar_estado('Portuguesa', ['Agua Blanca', 'Araure', 'Esteller', 'Guanare', 'Guanarito', 'Monseñor José Vicente de Unda', 'Ospino', 'Páez', 'Papelón', 'San Genaro de Boconoito', 'San Rafael de Onoto', 'Santa Rosalía', 'Sucre', 'Turén'])
    estados_y_municipios.agregar_estado('Sucre', ['Andrés Eloy Blanco', 'Andrés Mata', 'Arismendi', 'Benítez', 'Bermúdez', 'Bolívar', 'Cajigal', 'Cruz Salmerón Acosta', 'Libertador', 'Mariño', 'Mejía', 'Montes', 'Ribero', 'Sucre', 'Valdez'])
    estados_y_municipios.agregar_estado('Táchira', ['Andrés Bello', 'Antonio Rómulo Costa', 'Ayacucho', 'Bolívar', 'Cárdenas', 'Córdoba', 'Fernández Feo', 'Francisco de Miranda', 'García de Hevia', 'Guásimos', 'Independencia', 'Jáuregui', 'José María Vargas', 'Junín', 'Libertad', 'Libertador', 'Lobatera', 'Michelena', 'Panamericano', 'Pedro María Ureña', 'Rafael Urdaneta', 'Samuel Darío Maldonado', 'San Cristóbal', 'Seboruco', 'Simón Rodríguez', 'Sucre', 'Torbes', 'Uribante'])
    estados_y_municipios.agregar_estado('Trujillo', ['Andrés Bello', 'Boconó', 'Bolívar', 'Candelaria', 'Carache', 'Escuque', 'José Felipe Márquez Cañizales', 'Juan Vicente Campos Elías', 'La Ceiba', 'Miranda', 'Monte Carmelo', 'Motatán', 'Pampán', 'Pampanito', 'Rafael Rangel', 'San Rafael de Carvajal', 'Sucre', 'Trujillo', 'Urdaneta', 'Valera'])
    estados_y_municipios.agregar_estado('Vargas', ['Vargas'])
    estados_y_municipios.agregar_estado('Yaracuy', ['Arístides Bastidas', 'Bolívar', 'Bruzual', 'Cocorote', 'Independencia', 'José Antonio Páez', 'La Trinidad', 'Manuel Monge', 'Nirgua', 'Peña', 'San Felipe', 'Sucre', 'Urachiche', 'Veroes'])
    estados_y_municipios.agregar_estado('Zulia', ['Almirante Padilla', 'Baralt', 'Cabimas', 'Catatumbo', 'Colón', 'Francisco Javier Pulgar', 'Guajira', 'Jesús Enrique Lossada', 'Jesús María Semprún', 'La Cañada de Urdaneta', 'Lagunillas', 'Machiques de Perijá', 'Mara', 'Maracaibo', 'Miranda', 'Páez', 'Rosario de Perijá', 'San Francisco', 'Santa Rita', 'Simón Bolívar', 'Sucre', 'Valmore Rodríguez'])
    datos = estados_y_municipios.obtener_datos()
    return render_template('index2.html', estados=datos)

@app.route('/estado', methods=['GET'])
def estado():
    nombre_estado = request.args.get('estado')
    estados_y_municipios = ListaEnlazada()

    # Agregar estados y municipios nuevamente aquí
    estados_y_municipios.agregar_estado('Amazonas', ['Alto Orinoco', 'Atabapo', 'Atures', 'Autana', 'Manapiare', 'Maroa', 'Río Negro'])
    estados_y_municipios.agregar_estado('Anzoátegui', ['Anaco', 'Aragua', 'Diego Bautista Urbaneja', 'Fernando de Peñalver', 'Francisco de Miranda', 'Francisco del Carmen Carvajal', 'Guanta', 'Independencia', 'José Gregorio Monagas', 'Juan Antonio Sotillo', 'Juan Manuel Cajigal', 'Libertad', 'Manuel Ezequiel Bruzual', 'Pedro María Freites', 'Píritu', 'San José de Guanipa', 'San Juan de Capistrano', 'Santa Ana', 'Simón Bolívar', 'Simón Rodríguez'])
    estados_y_municipios.agregar_estado('Apure', ['Achaguas', 'Biruaca', 'Muñoz', 'Páez', 'Pedro Camejo', 'Rómulo Gallegos', 'San Fernando'])
    estados_y_municipios.agregar_estado('Aragua', ['Bolívar', 'Camatagua', 'Francisco Linares Alcántara', 'Girardot', 'José Ángel Lamas', 'José Félix Ribas', 'José Rafael Revenga', 'Libertador', 'Mario Briceño Iragorry', 'Ocumare de la Costa de Oro', 'San Casimiro', 'San Sebastián', 'Santiago Mariño', 'Santos Michelena', 'Sucre', 'Tovar', 'Urdaneta', 'Zamora'])
    estados_y_municipios.agregar_estado('Barinas', ['Alberto Arvelo Torrealba', 'Andrés Eloy Blanco', 'Antonio José de Sucre', 'Arismendi', 'Barinas', 'Bolívar', 'Cruz Paredes', 'Ezequiel Zamora', 'Obispos', 'Pedraza', 'Rojas', 'Sosa'])
    estados_y_municipios.agregar_estado('Bolívar', ['Angostura (Ciudad Bolívar)', 'Caroní', 'Cedeño', 'El Callao', 'Gran Sabana', 'Heres', 'Padre Pedro Chien', 'Piar', 'Roscio', 'Sifontes', 'Sucre'])
    estados_y_municipios.agregar_estado('Carabobo', ['Bejuma', 'Carlos Arvelo', 'Diego Ibarra', 'Guacara', 'Juan José Mora', 'Libertador', 'Los Guayos', 'Miranda', 'Montalbán', 'Naguanagua', 'Puerto Cabello', 'San Diego', 'San Joaquín', 'Valencia'])
    estados_y_municipios.agregar_estado('Cojedes', ['Anzoátegui', 'Falcón', 'Girardot', 'Lima Blanco', 'Pao de San Juan Bautista', 'Ricaurte', 'Rómulo Gallegos', 'San Carlos', 'Tinaco'])
    estados_y_municipios.agregar_estado('Delta Amacuro', ['Antonio Díaz', 'Casacoima', 'Pedernales', 'Tucupita'])
    estados_y_municipios.agregar_estado('Distrito Capital', ['Libertador'])
    estados_y_municipios.agregar_estado('Falcón', ['Acosta', 'Bolívar', 'Buchivacoa', 'Cacique Manaure', 'Carirubana', 'Colina', 'Dabajuro', 'Democracia', 'Federación', 'Jacura', 'Los Taques', 'Mauroa', 'Miranda', 'Monseñor Iturriza', 'Palmasola', 'Petit', 'Píritu', 'San Francisco', 'Silva', 'Sucre', 'Tocópero', 'Unión', 'Urumaco', 'Zamora'])
    estados_y_municipios.agregar_estado('Guárico', ['Camaguán', 'Chaguaramas', 'El Socorro', 'Francisco de Miranda', 'José Félix Ribas', 'José Tadeo Monagas', 'Juan Germán Roscio', 'Julián Mellado', 'Las Mercedes', 'Leonardo Infante', 'Pedro Zaraza', 'San Gerónimo de Guayabal', 'San José de Guaribe', 'Santa María de Ipire'])
    estados_y_municipios.agregar_estado('Lara', ['Andrés Eloy Blanco', 'Crespo', 'Iribarren', 'Jiménez', 'Morán', 'Palavecino', 'Simón Planas', 'Torres', 'Urdaneta'])
    estados_y_municipios.agregar_estado('Mérida', ['Alberto Adriani', 'Andrés Bello', 'Antonio Pinto Salinas', 'Aricagua', 'Arzobispo Chacón', 'Campo Elías', 'Caracciolo Parra Olmedo', 'Cardenal Quintero', 'Guaraque', 'Julio César Salas', 'Justo Briceño', 'Libertador', 'Miranda', 'Obispo Ramos de Lora', 'Padre Noguera', 'Pueblo Llano', 'Rangel', 'Rivas Dávila', 'Santos Marquina', 'Sucre', 'Tovar', 'Tulio Febres Cordero', 'Zea'])
    estados_y_municipios.agregar_estado('Miranda', ['Acevedo', 'Andrés Bello', 'Baruta', 'Brión', 'Buroz', 'Carrizal', 'Chacao', 'Cristóbal Rojas', 'El Hatillo', 'Guaicaipuro', 'Independencia', 'Lander', 'Los Salias', 'Páez', 'Paz Castillo', 'Plaza', 'Simón Bolívar', 'Sucre', 'Urdaneta', 'Zamora'])
    estados_y_municipios.agregar_estado('Monagas', ['Acosta', 'Aguasay', 'Bolívar', 'Caripe', 'Cedeño', 'Ezequiel Zamora', 'Libertador', 'Maturín', 'Piar', 'Punceres', 'Santa Bárbara', 'Sotillo', 'Uracoa'])
    estados_y_municipios.agregar_estado('Nueva Esparta', ['Antolín del Campo', 'Arismendi', 'Díaz', 'García', 'Gómez', 'Maneiro', 'Marcano', 'Mariño', 'Península de Macanao', 'Tubores', 'Villalba'])
    estados_y_municipios.agregar_estado('Portuguesa', ['Agua Blanca', 'Araure', 'Esteller', 'Guanare', 'Guanarito', 'Monseñor José Vicente de Unda', 'Ospino', 'Páez', 'Papelón', 'San Genaro de Boconoito', 'San Rafael de Onoto', 'Santa Rosalía', 'Sucre', 'Turén'])
    estados_y_municipios.agregar_estado('Sucre', ['Andrés Eloy Blanco', 'Andrés Mata', 'Arismendi', 'Benítez', 'Bermúdez', 'Bolívar', 'Cajigal', 'Cruz Salmerón Acosta', 'Libertador', 'Mariño', 'Mejía', 'Montes', 'Ribero', 'Sucre', 'Valdez'])
    estados_y_municipios.agregar_estado('Táchira', ['Andrés Bello', 'Antonio Rómulo Costa', 'Ayacucho', 'Bolívar', 'Cárdenas', 'Córdoba', 'Fernández Feo', 'Francisco de Miranda', 'García de Hevia', 'Guásimos', 'Independencia', 'Jáuregui', 'José María Vargas', 'Junín', 'Libertad', 'Libertador', 'Lobatera', 'Michelena', 'Panamericano', 'Pedro María Ureña', 'Rafael Urdaneta', 'Samuel Darío Maldonado', 'San Cristóbal', 'Seboruco', 'Simón Rodríguez', 'Sucre', 'Torbes', 'Uribante'])
    estados_y_municipios.agregar_estado('Trujillo', ['Andrés Bello', 'Boconó', 'Bolívar', 'Candelaria', 'Carache', 'Escuque', 'José Felipe Márquez Cañizales', 'Juan Vicente Campos Elías', 'La Ceiba', 'Miranda', 'Monte Carmelo', 'Motatán', 'Pampán', 'Pampanito', 'Rafael Rangel', 'San Rafael de Carvajal', 'Sucre', 'Trujillo', 'Urdaneta', 'Valera'])
    estados_y_municipios.agregar_estado('Vargas', ['Vargas'])
    estados_y_municipios.agregar_estado('Yaracuy', ['Arístides Bastidas', 'Bolívar', 'Bruzual', 'Cocorote', 'Independencia', 'José Antonio Páez', 'La Trinidad', 'Manuel Monge', 'Nirgua', 'Peña', 'San Felipe', 'Sucre', 'Urachiche', 'Veroes'])
    estados_y_municipios.agregar_estado('Zulia', ['Almirante Padilla', 'Baralt', 'Cabimas', 'Catatumbo', 'Colón', 'Francisco Javier Pulgar', 'Guajira', 'Jesús Enrique Lossada', 'Jesús María Semprún', 'La Cañada de Urdaneta', 'Lagunillas', 'Machiques de Perijá', 'Mara', 'Maracaibo', 'Miranda', 'Páez', 'Rosario de Perijá', 'San Francisco', 'Santa Rita', 'Simón Bolívar', 'Sucre', 'Valmore Rodríguez'])

    estado_actual = estados_y_municipios.cabeza
    while estado_actual:
        if estado_actual.nombre == nombre_estado:
            municipios = []
            municipio_actual = estado_actual.municipios
            while municipio_actual:
                municipios.append(municipio_actual.nombre)
                municipio_actual = municipio_actual.siguiente
            return render_template('estado.html', estado_nombre=nombre_estado, municipios=municipios)
        estado_actual = estado_actual.siguiente

    return render_template('index2.html', estados=estados_y_municipios.obtener_datos())

if __name__ == "__main__":
    app.run(debug=True, port=5000)
