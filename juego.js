function seleccionar(labelSeleccionado) {
    labelSeleccionado.classList.add("opcionSeleccionada");
}

function responder(labelSeleccionado, idRespuesta) {
    const formulario = document.getElementById("formPregunta");

    if (formulario.dataset.enviando === "1") {
        return;
    }

    formulario.dataset.enviando = "1";
    detenerTemporizador();

    const respuestaCorrecta = formulario.dataset.respuestaCorrecta;
    const opcionSeleccionada = labelSeleccionado.dataset.opcion;

    seleccionar(labelSeleccionado);

    const input = document.getElementById(idRespuesta);
    input.checked = true;

    formulario.querySelectorAll(".opciones label").forEach((label) => {
        const opcion = label.dataset.opcion;

        if (opcion === respuestaCorrecta) {
            label.classList.add("respuesta-correcta");
        } else if (opcion === opcionSeleccionada) {
            label.classList.add("respuesta-incorrecta");
        } else {
            label.classList.add("respuesta-bloqueada");
        }
    });

    setTimeout(() => {
        formulario.submit();
    }, 150);
}

const DURACION_PREGUNTA = 10;
let intervaloTemporizador = null;

function detenerTemporizador() {
    if (intervaloTemporizador !== null) {
        clearInterval(intervaloTemporizador);
        intervaloTemporizador = null;
    }
}

function agotarTiempo() {
    const formulario = document.getElementById("formPregunta");

    if (!formulario || formulario.dataset.enviando === "1") {
        return;
    }

    formulario.dataset.enviando = "1";
    detenerTemporizador();

    formulario.querySelectorAll(".opciones label").forEach((label) => {
        if (label.dataset.opcion === formulario.dataset.respuestaCorrecta) {
            label.classList.add("respuesta-correcta");
        } else {
            label.classList.add("respuesta-bloqueada");
        }
    });

    const respuesta = document.createElement("input");
    respuesta.type = "hidden";
    respuesta.name = "respuesta";
    respuesta.value = "TIEMPO_AGOTADO";
    formulario.appendChild(respuesta);

    setTimeout(() => formulario.submit(), 500);
}

function iniciarTemporizador() {
    const formulario = document.getElementById("formPregunta");
    const segundos = document.getElementById("segundosRestantes");
    const progreso = document.getElementById("progresoTiempo");
    const contenedor = document.getElementById("temporizador");

    if (!formulario || !segundos || !progreso || !contenedor) {
        return;
    }

    const inicio = Date.now();
    const tiempoServidor = Number(formulario.dataset.tiempoRestante);
    const duracion = Number.isFinite(tiempoServidor)
        ? tiempoServidor
        : DURACION_PREGUNTA * 1000;

    if (duracion <= 0) {
        agotarTiempo();
        return;
    }

    intervaloTemporizador = setInterval(() => {
        const transcurrido = Date.now() - inicio;
        const restante = Math.max(0, duracion - transcurrido);

        segundos.textContent = Math.ceil(restante / 1000);
        progreso.style.width = `${(restante / duracion) * 100}%`;
        contenedor.classList.toggle("tiempo-urgente", restante <= 3000);

        if (restante === 0) {
            agotarTiempo();
        }
    }, 100);
}

document.addEventListener("DOMContentLoaded", iniciarTemporizador);

if (window.jQuery && jQuery.fn.easyPieChart) {
    jQuery(function($) {
        $('.chart').easyPieChart({
            size: 160,
            barColor: "#36e617",
            scaleLength: 0,
            lineWidth: 15,
            trackColor: "#525151",
            lineCap: "circle",
            animate: 2000,
        });
    });
}
