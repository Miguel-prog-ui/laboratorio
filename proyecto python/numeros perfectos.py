def verificar_perfeccion(numero):
    suma_factores = sum([factor for factor in range(1, numero) if numero % factor == 0])
    return suma_factores == numero

def buscar_numeros_perfectos(desde, hasta):
    lista_perfectos = []
    for numero in range(desde, hasta + 1):
        if verificar_perfeccion(numero):
            lista_perfectos.append(numero)
    return lista_perfectos

print("Calculadora de Números Perfectos")
rango_inicio = int(input("Introduce el inicio del rango: "))
rango_fin = int(input("Introduce el fin del rango: "))
numeros_perfectos = buscar_numeros_perfectos(rango_inicio, rango_fin)
if numeros_perfectos:
    print(f"Números perfectos entre {rango_inicio} y {rango_fin}: {numeros_perfectos}")
else:
    print(f"No se encontraron números perfectos entre {rango_inicio} y {rango_fin}.")

