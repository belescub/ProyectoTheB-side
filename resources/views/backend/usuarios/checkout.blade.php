@extends('plantilla') 
@section('contenido')

<div class="container py-5">
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <h2 class="mb-4" style="font-family: 'Bebas Neue'; color: #77c040; letter-spacing: 2px;">Finalizar Compra</h2>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-box p-4" style="background-color: rgba(52, 53, 52, 0.404); backdrop-filter: blur(12px); border-radius: 20px; box-shadow: #0a0a0ac5 0px 0px 30px;">
                    
                    <h4 class="mb-4" style="color: #77c040; font-family: 'Bebas Neue'; letter-spacing: 1px;">Datos del Cliente</h4>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" style="color: #77c040; font-weight: 600;">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" style="border-radius: 10px;" value="{{ auth()->user()->nombre ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color: #77c040; font-weight: 600;">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" style="border-radius: 10px;" value="{{ auth()->user()->email ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color: #77c040; font-weight: 600;">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" style="border-radius: 10px;" placeholder="Ej: 11 1234 5678" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color: #77c040; font-weight: 600;">Dirección</label>
                            <input type="text" name="direccion" class="form-control" style="border-radius: 10px;" placeholder="Calle y número" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color: #77c040; font-weight: 600;">Provincia</label>
                            <select name="provincia" id="provincia" class="form-control" style="border-radius: 10px;" required>
                                <option value="">Seleccionar...</option>
                                <option value="Buenos Aires">Buenos Aires</option>
                                <option value="Catamarca">Catamarca</option>
                                <option value="Chaco">Chaco</option>
                                <option value="Chubut">Chubut</option>
                                <option value="Córdoba">Córdoba</option>
                                <option value="Corrientes">Corrientes</option>
                                <option value="Entre Ríos">Entre Ríos</option>
                                <option value="Formosa">Formosa</option>
                                <option value="Jujuy">Jujuy</option>
                                <option value="La Pampa">La Pampa</option>
                                <option value="La Rioja">La Rioja</option>
                                <option value="Mendoza">Mendoza</option>
                                <option value="Misiones">Misiones</option>
                                <option value="Neuquén">Neuquén</option>
                                <option value="Rio Negro">Rio Negro</option>
                                <option value="Salta">Salta</option>
                                <option value="San Juan">San Juan</option>
                                <option value="San Luis">San Luis</option>
                                <option value="Santa Cruz">Santa Cruz</option>
                                <option value="Santa Fe">Santa Fe</option>
                                <option value="Santiago del Estero">Santiago del Estero</option>
                                <option value="Tierra del Fuego">Tierra del Fuego</option>
                                <option value="Tucumán">Tucumán</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label" style="color: #77c040; font-weight: 600;">Localidad</label>
                            <input type="text" name="localidad" id="localidad" class="form-control" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="color: #77c040; font-weight: 600;">C.P.</label>
                            <input type="text" name="codigo_postal" class="form-control" style="border-radius: 10px;" required>
                        </div>
                    </div>

                    <hr style="border-color: #444; margin: 2rem 0;">

                    <h4 class="mb-3" style="color: #77c040; font-family: 'Bebas Neue'; letter-spacing: 1px;">Método de Entrega</h4>
                    <div class="mb-4">
                        <div class="form-check custom-radio mb-2">
                            <input class="form-check-input" type="radio" name="metodo_entrega" id="retiro" value="retiro" style="accent-color: #77c040;" checked>
                            <label class="form-check-label text-white" for="retiro">
                                Retiro en local (Gratis)
                            </label>
                        </div>
                        <div class="form-check custom-radio">
                            <input class="form-check-input" type="radio" name="metodo_entrega" id="envio" value="envio" style="accent-color: #77c040;">
                            <label class="form-check-label text-white" for="envio">
                                Envío a domicilio
                            </label>
                        </div>
                    </div>

                    <hr style="border-color: #444; margin: 2rem 0;">

                    <h4 class="mb-3" style="color: #77c040; font-family: 'Bebas Neue'; letter-spacing: 1px;">Método de Pago</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check custom-radio">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" style="accent-color: #77c040;" checked>
                                <label class="form-check-label text-white" for="tarjeta">
                                    <i class="fa-solid fa-credit-card me-2"></i> Tarjeta de Crédito/Débito
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check custom-radio">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="mercadopago" value="mercadopago" style="accent-color: #77c040;">
                                <label class="form-check-label text-white" for="mercadopago">
                                    <i class="fa-solid fa-handshake me-2"></i> Mercado Pago
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check custom-radio">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pagofacil" value="pagofacil" style="accent-color: #77c040;">
                                <label class="form-check-label text-white" for="pagofacil">
                                    <i class="fa-solid fa-money-bill me-2"></i> Pago Fácil
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check custom-radio">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="rapipago" value="rapipago" style="accent-color: #77c040;">
                                <label class="form-check-label text-white" for="rapipago">
                                    <i class="fa-solid fa-money-bill-wave me-2"></i> Rapipago
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-box p-4 sticky-top" style="top: 100px; background-color: rgba(52, 53, 52, 0.404); backdrop-filter: blur(12px); border-radius: 20px; box-shadow: #0a0a0ac5 0px 0px 30px;">
                    <h4 class="mb-4" style="color: #77c040; font-family: 'Bebas Neue'; letter-spacing: 1px;">Resumen del Pedido</h4>
                    
                    <div class="resumen-productos mb-4">
                        @forelse($items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2 text-white" style="font-size: 0.95rem;">
                                <span>{{ $item->producto->nombre }} <span style="color: #77c040;">x{{ $item->cantidad }}</span></span>
                                <span>${{ number_format($item->subtotal, 2, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-white">Tu carrito está vacío.</p>
                        @endforelse
                    </div>

                    <hr style="border-color: #444;">

                    <div class="d-flex justify-content-between align-items-center mb-2 text-white">
                        <span>Subtotal:</span>
                        <span>${{ number_format($carrito->total, 2, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 text-white">
                        <span>Envío:</span>
                        <span id="envio-texto">$ 0,00</span>
                    </div>

                    <hr style="border-color: #77c040; border-width: 2px; opacity: 1;">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span style="color: #77c040; font-family: 'Bebas Neue'; font-size: 1.5rem; letter-spacing: 1px;">TOTAL:</span>
                        <span id="total-texto" style="color: #77c040; font-size: 1.5rem; font-weight: bold;">${{ number_format($carrito->total, 2, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn w-100 py-3" style="background-color: #77c040 !important; color: #ffffff !important; border-radius: 30px; font-family: 'Bebas Neue'; letter-spacing: 1.5px; font-size: 1.3rem;">
                        FINALIZAR COMPRA
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const subtotal = {{ $carrito->total }};
    
    const radioRetiro = document.getElementById('retiro');
    const radioEnvio = document.getElementById('envio');
    const inputProvincia = document.getElementById('provincia');
    const inputLocalidad = document.getElementById('localidad');
    
    const envioTexto = document.getElementById('envio-texto');
    const totalTexto = document.getElementById('total-texto');

    function calcularEnvioEnVivo() {
        let costoEnvio = 0;

        if (radioEnvio && radioEnvio.checked) {
            const provincia = inputProvincia.value.trim().toLowerCase();
            const localidad = inputLocalidad.value.trim().toLowerCase();

            if (provincia === 'corrientes' && localidad === 'corrientes') {
                costoEnvio = 1000;
            } else if (provincia === 'corrientes') {
                costoEnvio = 3000;
            } else if (provincia !== '') {
                costoEnvio = 9000; 
            }
        }

        const formateador = new Intl.NumberFormat('es-AR', {
            style: 'currency',
            currency: 'ARS'
        });

        if (envioTexto) envioTexto.textContent = formateador.format(costoEnvio);
        if (totalTexto) totalTexto.textContent = formateador.format(subtotal + costoEnvio);
    }

    if (radioRetiro) radioRetiro.addEventListener('change', calcularEnvioEnVivo);
    if (radioEnvio) radioEnvio.addEventListener('change', calcularEnvioEnVivo);
    if (inputProvincia) inputProvincia.addEventListener('change', calcularEnvioEnVivo); // Cambiado a 'change' para que se dispare al seleccionar el <select>
    if (inputLocalidad) inputLocalidad.addEventListener('input', calcularEnvioEnVivo);
});
</script>

@endsection