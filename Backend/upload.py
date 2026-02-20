import sys

ruta_archivo = sys.argv[1]

with open(ruta_archivo, "r", encoding="utf-8") as f:
    contenido = f.read()

print("Archivo recibido:")
print(contenido)
