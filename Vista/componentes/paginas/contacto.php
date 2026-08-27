<div class="bodyContact">
    <form class="formContact" action="?c=sesion&a=apiContacto" method="POST">
        <div class="formCon">
            <h1 class="h1Contact">Contáctanos</h1>
            <div class="grupo">
                <input class="inputCon" placeholder="Escriba su nombre" type="text" name="nombre" id="" required><span class="barra"></span>
                <label class="labelCon">Nombre</label>
            </div>
            <div class="grupo">
                <input class="inputCon" placeholder="Escriba su correo" type="email" name="correo" id="" required><span class="barra"></span>
                <label class="labelCon">Correo</label>
            </div>
            <div class="grupo">
                <input class="inputCon" placeholder="Escriba un asunto" type="text" name="asunto" id="" required><span class="barra"></span>
                <label class="labelCon">Asunto</label>
            </div>
            <div class="grupo">
                <textarea class="txtAreaCon"name="mensaje" id="" rows="3" placeholder="Escriba un mensaje" required></textarea><span class="barra"></span>
                <label class="labelCon">Mensaje</label>
            </div>
            <button class="buttonCon btn-hover" type="submit">Enviar</button>
        </div>
    </form>
</div>
