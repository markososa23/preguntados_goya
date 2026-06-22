const ruleta = document.getElementById("ruleta");
const botonGirarRuleta = document.getElementById("botonGirarRuleta");
const resultadoRuleta = document.getElementById("resultadoRuleta");
const botonContinuarRuleta = document.getElementById("botonContinuarRuleta");

let gradosActuales = Number(localStorage.getItem("gradosRuleta")) || 0;
let categoriaSeleccionada = null;

// Restaurar posición anterior de la ruleta sin animación
ruleta.style.transition = "none";
ruleta.style.transform = `rotate(${gradosActuales}deg)`;

// Estado inicial del botón siguiente
botonContinuarRuleta.classList.add("oculto");
botonContinuarRuleta.disabled = true;

botonGirarRuleta.addEventListener("click", girarRuleta);

botonContinuarRuleta.addEventListener("click", () => {
    if (!categoriaSeleccionada) {
        return;
    }

    window.location.href = "index.php?idCategoria=" + categoriaSeleccionada.id;
});

function girarRuleta() {
    botonGirarRuleta.disabled = true;

    botonContinuarRuleta.classList.add("oculto");
    botonContinuarRuleta.disabled = true;

    resultadoRuleta.textContent = "Girando...";

    const cantidadCategorias = categoriasRuleta.length;

    if (cantidadCategorias === 0) {
        resultadoRuleta.textContent = "No hay categorías disponibles.";
        botonGirarRuleta.disabled = false;
        return;
    }

    const gradosPorCategoria = 360 / cantidadCategorias;

    const indiceGanador = Math.floor(Math.random() * cantidadCategorias);
    categoriaSeleccionada = categoriasRuleta[indiceGanador];

    const duracion = 3.5 + Math.random() * 1.5;
    const vueltas = 4 + Math.floor(Math.random() * 3);

    ruleta.style.transition = `transform ${duracion}s ease-out`;

    const desplazamientoDentroDelSegmento =
        (Math.random() - 0.5) * gradosPorCategoria;

    const anguloDentroDeLaCategoria =
        indiceGanador * gradosPorCategoria + desplazamientoDentroDelSegmento;

    const anguloObjetivo =
        (360 - anguloDentroDeLaCategoria) % 360;

    const anguloActual = gradosActuales % 360;

    const diferencia =
        (anguloObjetivo - anguloActual + 360) % 360;

    gradosActuales += vueltas * 360 + diferencia;

    ruleta.style.transform = `rotate(${gradosActuales}deg)`;

    setTimeout(() => {
        localStorage.setItem("gradosRuleta", gradosActuales);

        resultadoRuleta.textContent = "Categoría: " + categoriaSeleccionada.nombre;

        botonGirarRuleta.disabled = true;

        botonContinuarRuleta.disabled = false;
        botonContinuarRuleta.classList.remove("oculto");
    }, duracion * 1000);
}