function seleccionar(labelSeleccionado) {
    labelSeleccionado.classList.add("opcionSeleccionada");
}

function responder(labelSeleccionado, idRespuesta) {
    const formulario = document.getElementById("formPregunta");

    if (formulario.dataset.enviando === "1") {
        return;
    }

    formulario.dataset.enviando = "1";

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

$(function() {
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
