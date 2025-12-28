Usuario
--------
id
email
password_hash
rol (ADMIN | PROFESIONAL | CLIENTE)

Cliente
--------
id (PK)
nombre
dni
email
telefono
created_at

Turno
------
id (PK)
profesional_id (FK)
cliente_id (FK)
fecha
hora_inicio
hora_fin
estado (RESERVADO | CANCELADO | COMPLETADO)
created_at

Profesional
------------
id (PK)
usuario_id (FK)
nombre
especialidad
telefono
activo
created_at