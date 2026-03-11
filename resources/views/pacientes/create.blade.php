<h2>Registrar Paciente</h2>

<form action="{{ route('pacientes.store') }}" method="POST">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre" required><br><br>
    <input type="text" name="apellido" placeholder="Apellido" required><br><br>
    <input type="text" name="ci" placeholder="CI" required><br><br>
    <input type="text" name="telefono" placeholder="Teléfono" required><br><br>
    <input type="date" name="fecha_nacimiento" required><br><br>
    <input type="text" name="direccion" placeholder="Dirección"><br><br>

    <button type="submit">Guardar</button>
</form>


