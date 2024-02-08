<form action="/forgot" method="POST">
    @csrf
    <input type="email" name="email" class='border' required>
    <br>
    <button class='border bg-cyan-200'>Enviar</button>
</form>