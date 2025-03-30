// Configuración de las instrucciones
const instructions = {
    1: `1. Insertar el import -> import javax.swing.JOptionPane;<br>
        2. Crear una clase que se llame Fibonacci<br>
        3. Generar una función publica estática de tipo double llamada Fibo que reciba un parámetro de tipo entero llamado n<br>
        4. Ejecutar la sentencia if de acuerdo con la secuencia de Fibonacci si el valor es 1 regresa 1 y si es 2 regresa 1:<br>
        <code>if (n == 1 || n == 2) { return 1; }</code><br>
        5. Ejecutar el otro caso y regresar la suma del número anterior al valor dado y su antecesor:<br>
        <code>else { return Fibo(n - 1) + Fibo(n - 2); }</code><br>
        6. Declarar el método principal<br>
        7. Declarar un entero i -> int i;<br>
        8. Poner las siguientes líneas de código:<br>
        <code>n = Integer.parseInt(JOptionPane.showInputDialog(null, "Ingresa el número para calcular la sucesión de Fibonacci", "Solicitando Datos", 3));</code><br>
        <code>JOptionPane.showMessageDialog(null, "Fibonacci de " + n + " = " + Fibo(n));</code>`
    ,
    2: `1. Declarar la clase Potencia<br>
        2. Declarar la biblioteca -> import javax.swing.JOptionPane;<br>
        3. Declarar la función estática pública llamada Pot que reciba dos parámetros enteros x y n:<br>
        <code>public static double Pot(int x, int n)</code><br>
        4. Condicional: si n < 1, retornar 1, de lo contrario retornar x * Pot(x, n - 1):<br>
        <code>if (n < 1) { return 1; } else { return x * Pot(x, n - 1); }</code><br>
        5. Generar el método principal con dos variables enteras x y n -> int x, n;<br>
        6. Asignar a x el valor del número para calcular la potencia<br>
        7. Asignar a n el valor de la potencia<br>
        <code>x = Integer.parseInt(JOptionPane.showInputDialog(null, "Ingresa el número para calcular su potencia", "Solicitando Datos", 3));</code><br>
        <code>n = Integer.parseInt(JOptionPane.showInputDialog(null, "Ingresa la potencia a la quieres elevar el número " + x, "Solicitando Datos", 3));</code><br>
        <code>JOptionPane.showMessageDialog(null, "Potencia de " + x + "^" + n + "= " + Pot(x, n));</code>`
};

// Mostrar instrucciones iniciales
document.getElementById('instructions').innerHTML = instructions[1];

document.getElementById('codeSelection').addEventListener('change', (e) => {
    const selectedCode = e.target.value;
    document.getElementById('instructions').innerHTML = instructions[selectedCode];
});

// Temporizador
let timeLeft = 400;
const timerElement = document.getElementById('timer');
let timerInterval = null;

function updateTimer() {
    if (!timerInterval) {
        timerInterval = setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                timerElement.textContent = timeLeft;
            } else {
                alert('Tiempo finalizado. Por favor, envía tu examen.');
                clearInterval(timerInterval);
            }
        }, 1000);
    }
}

// Manejo del formulario
document.getElementById('studentForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const matricula = document.getElementById('matricula').value;
    const code1 = document.getElementById('editor1').value;
    const code2 = document.getElementById('editor2').value;

    if (!name || !matricula) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, completa todos los campos',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    try {
        // Guardar en Firebase
        const firebasePromise = new Promise((resolve, reject) => {
            const datos = {
                nombre: name,
                matricula: matricula,
                codigo1: code1,
                codigo2: code2,
                fechaEnvio: new Date().toISOString(),
                tiempoUtilizado: 400 - timeLeft
            };

            database.ref('respuestas/' + matricula).set(datos)
                .then(resolve)
                .catch(reject);
        });

        // Guardar en MySQL (InfinityFree)
        const mysqlPromise = fetch('./guardar_respuestas.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                nombre: name,
                matricula: matricula,
                code1: code1, // Asegúrate de que coincida con lo que espera PHP
                code2: code2
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === "error") {
                    throw new Error(data.message);
                }
                return data;
            });

        // Ejecutar ambos guardados en paralelo
        const [firebaseResult, mysqlResult] = await Promise.allSettled([firebasePromise, mysqlPromise]);

        // Verificar resultados
        const firebaseSuccess = firebaseResult.status === 'fulfilled';
        const mysqlSuccess = mysqlResult.status === 'fulfilled';

        if (firebaseSuccess && mysqlSuccess) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Respuestas guardadas en ambas bases de datos',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        } else {
            let errorMessage = 'Respuestas guardadas parcialmente: ';
            if (!firebaseSuccess) errorMessage += 'Error en Firebase: ' + firebaseResult.reason + '. ';
            if (!mysqlSuccess) errorMessage += 'Error en MySQL: ' + mysqlResult.reason + '. ';

            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: errorMessage,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        }

        // Limpiar formulario si ambos guardados fueron exitosos
        if (firebaseSuccess && mysqlSuccess) {
            document.getElementById('studentForm').reset();
            document.getElementById('editor1').value = '';
            document.getElementById('editor2').value = '';
        }
    } catch (error) {
        console.error('Error al enviar las respuestas:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al conectar con los servidores: ' + error.message,
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6'
        });
    }
});

// Función para actualizar los números de línea
function updateLineNumbers(editorId, linesId) {
    const editor = document.getElementById(editorId);
    const lines = document.getElementById(linesId);
    const lineCount = (editor.value || '').split('\n').length;
    let lineNumbers = '';
    for (let i = 1; i <= lineCount; i++) {
        lineNumbers += `${i}\n`;
    }
    lines.innerText = lineNumbers;
    lines.scrollTop = editor.scrollTop;
}

// Mapa para almacenar los colores asignados a cada palabra o símbolo
const colorMap = new Map();

// Función para generar un color claro aleatorio
function getRandomColor() {
    const r = Math.floor(Math.random() * 106) + 150;
    const g = Math.floor(Math.random() * 106) + 150;
    const b = Math.floor(Math.random() * 106) + 150;
    return `rgb(${r}, ${g}, ${b})`;
}

// Función para obtener o asignar un color a una palabra o símbolo
function getColorForToken(token) {
    if (colorMap.has(token)) {
        return colorMap.get(token);
    }
    const color = getRandomColor();
    colorMap.set(token, color);
    return color;
}

// Función para resaltar el código con colores consistentes
function highlightCode(editorId) {
    try {
        const editor = document.getElementById(editorId);
        const highlight = document.getElementById('highlight' + editorId.substring(editorId.length - 1));

        let code = editor.value.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');

        let highlightedCode = code.replace(/(\w+)|([^\w\s])|(\s+)/g, (match, word, symbol, whitespace) => {
            if (whitespace) {
                return whitespace;
            }
            const tokenColor = getColorForToken(match);
            return `<span style="color: ${tokenColor}">${match}</span>`;
        });

        highlight.innerHTML = highlightedCode;

        const currentTokens = new Set();
        code.match(/(\w+)|([^\w\s])/g)?.forEach(token => currentTokens.add(token));
        for (const token of colorMap.keys()) {
            if (!currentTokens.has(token)) {
                colorMap.delete(token);
            }
        }
    } catch (error) {
        console.error('Error en highlightCode:', error);
    }
}

// Configuración de los editores
const editor1 = document.getElementById('editor1');
const editor2 = document.getElementById('editor2');

// Variable para controlar el temporizador
let timerStarted = false;

// Variable para evitar múltiples notificaciones
let hasShownWarning = false;

// Función para manejar cambio de pestaña, salida o pérdida de foco
function handleTabSwitchOrExit() {
    editor1.value = '';
    editor2.value = '';

    updateLineNumbers('editor1', 'lines1');
    updateLineNumbers('editor2', 'lines2');
    highlightCode('editor1');
    highlightCode('editor2');

    if (!hasShownWarning) {
        hasShownWarning = true;
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'No puede salir de esta pestaña, estás en examen',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            hasShownWarning = false;
        });
    }
}

// Variable para evitar múltiples notificaciones de pegado
let hasShownPasteWarning = false;

// Función para manejar intento de pegar texto
function handlePasteAttempt() {
    if (!hasShownPasteWarning) {
        hasShownPasteWarning = true;
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'No se puede pegar texto, estás en examen',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            hasShownPasteWarning = false;
        });
    }
}

// Detectar cambio de pestaña o minimización del navegador
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
        handleTabSwitchOrExit();
    }
});

// Detectar intento de cerrar la pestaña o el navegador
window.addEventListener('beforeunload', (e) => {
    handleTabSwitchOrExit();
    const message = 'No puedes salir de esta pestaña, estás en examen. ¿Estás seguro de que quieres salir?';
    e.returnValue = message;
    return message;
});

// Detectar pérdida de foco (como Alt + Tab)
window.addEventListener('blur', () => {
    handleTabSwitchOrExit();
});

// Configurar eventos para los editores
[editor1, editor2].forEach(editor => {
    editor.addEventListener('input', function () {
        if (!timerStarted) {
            timerStarted = true;
            updateTimer();
        }
        highlightCode(this.id);
        updateLineNumbers(this.id, 'lines' + this.id.slice(-1));
    });

    editor.addEventListener('scroll', function () {
        document.getElementById('lines' + this.id.slice(-1)).scrollTop = this.scrollTop;
        document.getElementById('highlight' + this.id.slice(-1)).scrollTop = this.scrollTop;
    });

    editor.addEventListener('paste', (e) => {
        e.preventDefault();
        handlePasteAttempt();
    });

    editor.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'v') {
            e.preventDefault();
            handlePasteAttempt();
        }
    });
});

// Inicializar los editores
updateLineNumbers('editor1', 'lines1');
updateLineNumbers('editor2', 'lines2');
highlightCode('editor1');
highlightCode('editor2');