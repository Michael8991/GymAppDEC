const datewehaterContainer =  document.querySelector('.dateweather-wrapper');
const date = document.querySelector('#date'); 
const weather = document.querySelector('#weather');
const greeting = document.querySelector('#greeting');
const formWeather = document.getElementById('form-weather');
const submitBtn = document.querySelector('#submit-modalWeather');
const exercisesApiList = document.querySelector('#exercises-api-list');
const addBtn = document.querySelectorAll('.add-btn');

const exercisesSession = document.querySelector('#exercises-session-list');

const saveSessionBtn = document.querySelector('#saveSession');

const musclesInput = document.getElementById('muscles');

const weekdays = document.getElementById('weekdays')

let ejercicios = [];

let ejerciciosSesion = [];

let ciudad = 'Madrid';
let pais = 'España';

let fecha = new Date();
let diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
let meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
let diaSemana = diasSemana[fecha.getDay()];
let diaMes = fecha.getDate();
let mes = meses[fecha.getMonth()];

let fechaFormateada = diaSemana + ", " + diaMes + " " + mes;

let hora =  fecha.getHours();

function obtenerSaludo(hora){
    let saludoFormateado;
    if(hora < 12 && hora >= 6){
        saludoFormateado = "Buenos días";
    }else if(hora >= 12 && hora < 20){
        saludoFormateado = "Buenas tardes"
    }else if(hora >=20 || hora < 6){
        saludoFormateado = "Buenas noches"
    }
        return saludoFormateado;
}

greeting.innerText = obtenerSaludo(hora);
date.innerText = fechaFormateada;

function openModalWeather() {
    var modal = document.getElementById("modalWeather");
    modal.style.display = "block";
  }
  
function closeModalWeather() {
    var modal = document.getElementById("modalWeather");
    modal.style.display = "none";
}

formWeather.addEventListener('submit', (e) =>{
    e.preventDefault();
    //SV = sin validar
    let ciudadSV = document.getElementById('city').value;
    let paisSV = document.getElementById('country').value;

    //validación
    if(ciudadSV !== '' || paisSV !== ''){
        ciudad = ciudadSV;
        pais = paisSV.replace(/\s+/g, '');
        buscarClima(ciudad, pais)
        closeModalWeather()
    }else{
        mostrarError('Estos campos no pueden estar vacío')
    }
})

function mostrarError(mensaje){
    const divError = document.createElement('div');
    divError.classList.add('alertaError');
    divError.innerText = mensaje;
    const alerta = document.querySelector('.alertaError');
    if(!alerta){
        formWeather.appendChild(divError);
        setTimeout(()=>{
            divError.remove();
            formWeather.reset();
        },3000)
    }
}

window.addEventListener('load', () =>{
    buscarClima(ciudad, pais);
})

function buscarClima(ciudad, pais){
    const appId = '2b140ebfca3c6c43c152ad228152c8f7'

    const url = `https://api.openweathermap.org/data/2.5/weather?q=${ciudad},${pais}&lang=es&appid=${appId}`

    fetch(url)
        .then(respuesta => respuesta.json())
        .then(datos => {
            if(datos.cod === "404"){
                console.log('Ciudad no encontrada')
            }
            mostrarClima(datos);
        })
}

function mostrarClima(datos){
    const {main : {temp}, weather: [{main}]} = datos
    let temperatura = Math.round(temp - 273.15);
    let cielos =  main;
    switch(cielos) {
        case 'Clear':
            cielos = 'Despejado';
            break;
        case 'Clouds':
            cielos = 'Nublado';
            break;
        case 'Rain':
            cielos = 'Lluvia';
            break;
        case 'Drizzle':
            cielos = 'Lloviznas';
            break
        case 'Snow':
            cielos = 'Nieve';
            break
        case 'Storms':
        cielos = 'Tormentas';
        break
        case 'Fog':
        cielos = 'Niebla';
        break
        case 'Mist':
        cielos = 'Neblina';
        break
        default:
            cielos = cielos;
            break
    }

    weather.innerText = `${temperatura}° en ${ciudad}, ${cielos}`
}

musclesInput.addEventListener('input', () => {
    let muscle = musclesInput.value;
    obtenerEjercicio(muscle)
})

function obtenerEjercicio(muscle){
    $.ajax({
        method: 'GET',
        url: 'https://api.api-ninjas.com/v1/exercises?muscle=' + muscle,
        headers: { 'X-Api-Key': '54eqaUwpah8WPIlMIS8kLw==8zE3WuZey7LVOO3C'},
        contentType: 'application/json',
        success: function(result) {
            ejercicios = result;
            imprimirEjercicios(ejercicios);
        },
        error: function ajaxError(jqXHR) {
            console.error('Error: ', jqXHR.responseText);
        }
    });
}

function imprimirEjercicios(ejercicios){
    exercisesApiList.innerHTML=``;
    let idEjericicio = 0;
    ejercicios.forEach(ejercicio => {
        const {name, difficulty, equipment, muscle} = ejercicio
        const ejercicioDiv = document.createElement('div');
        ejercicioDiv.classList.add('card-shadow');
        ejercicioDiv.innerHTML = `
            <div class="exercises-wrapper">
                <div class="exercise">
                    <div class="exercise-container">
                        <p class="title-exercise">Nombre: </p>
                        <p id="exerciseName">${name}</p>
                    </div>
                    <div class="exercise-container">
                        <p class="title-exercise">Dificultad: </p>
                        <p id="exerciseDifficulty">${difficulty}</p>
                    </div>
                    <div class="exercise-container">
                        <p class="title-exercise">Equipamiento:</p>
                        <p id="exerciseEquipment">${equipment}</p>
                    </div>
                    <div class="exercise-container">
                        <p class="title-exercise">Músculo:</p>
                        <p id="exerciseMuscle">${muscle}</p>
                    </div>
                </div>
                <div class="btn-container">
                        <button class="info-btn" data-id="${idEjericicio}" onclick="agregarEjercicioSesion(${idEjericicio})">Agregar</button>
                    </div>
            </div>`;
            exercisesApiList.appendChild(ejercicioDiv);
            idEjericicio++;
    })
}

function agregarEjercicioSesion(id){
    const ejercicio = ejercicios[id];
    let ejercicioSesion = {
        "id" : '',
        "name": '',
        "type": '',
        "muscle": '',
        "equipment":'',
        "difficulty": '',
        "instructions": ''
    }
    
    if(ejercicio){
        ejercicioSesion ={
            "id" : Date.now(),
            "name": ejercicio.name,
            "type": ejercicio.type,
            "muscle": ejercicio.muscle,
            "equipment":ejercicio.equipment,
            "difficulty": ejercicio.difficulty,
            "instructions": ejercicio.instructions
        }
        ejerciciosSesion.push(ejercicioSesion);
        imprimirEjerciciosSesion(ejerciciosSesion);

        const agregarBtn = document.querySelector(`button[data-id="${id}"]`);
        const wrapper = agregarBtn.parentElement.parentElement;

        const mensajeDiv = document.createElement('div');
        mensajeDiv.classList.add('mensaje-translucido');
        mensajeDiv.innerHTML = '<h2>Ejercicio agregado</h2>';
        
        // Insertar el mensaje antes del div exercises-wrapper
        wrapper.parentElement.prepend(mensajeDiv)

        // Desvanecer el mensaje después de 1 segundo
        setTimeout(function () {
            mensajeDiv.style.opacity = '0';
            setTimeout(function () {
                mensajeDiv.remove();
            }, 1000);
        }, 1000);
        
        
    }
}

function imprimirEjerciciosSesion(ejerciciosSesion){
    exercisesSession.innerHTML = ``;
    ejerciciosSesion.forEach((ejercicio)=>{
        const {id, name, type, difficulty, equipment, muscle, instructions} = ejercicio;
        const ejercicioSesionDiv = document.createElement('div');
        ejercicioSesionDiv.classList.add('card-shadow');
        ejercicioSesionDiv.innerHTML = `<div class="exercises-wrapper">
        <div class="exercise">
            <div class="exercise-container">
                <p class="title-exercise">Nombre: </p>
                <p id="exerciseName">${name}</p>
            </div>
            <div class="exercise-container">
                <p class="title-exercise">Tipo: </p>
                <p id="exerciseType">${type}</p>
            </div>
            <div class="exercise-container">
                <p class="title-exercise">Dificultad:</p>
                <p id="exerciseDifficulty">${difficulty}</p>
            </div>
        </div>
        <div class="exercise">
            <div class="exercise-container">
                <p class="title-exercise">Equipamiento:</p>
                <p id="exerciseEquipment">${equipment}</p>
            </div>
            <div class="exercise-container">
                <p class="title-exercise">Músculo:</p>
                <p id="exerciseMuscle">${muscle}</p>
            </div>
            <button class="info-btn" onclick="obtenerInformacion(event, ${id})">Explicación</button>
            <button class="delete-exercise-btn" onclick="borrarEjercicioSesion(event, ${id})">Eliminar</button>
        </div>
    </div>`;
    exercisesSession.appendChild(ejercicioSesionDiv);
    })
}

function borrarEjercicioSesion(event, id){
    event.preventDefault();
    ejerciciosSesion = ejerciciosSesion.filter(ejercicio => ejercicio.id !== id);
    imprimirEjerciciosSesion(ejerciciosSesion)
}

function obtenerInformacion(event, id){
    event.preventDefault();
    const modalInformacion = document.getElementById("modalInformacion");
    modalInformacion.style.display = "block";
    const exerciseNameInfo = document.getElementById('exerciseNameInfo');
    const exerciseInfo = document.getElementById('exerciseInfo');

    const ejercicio = ejerciciosSesion.find(ejercicio => ejercicio.id === id);
    if(ejercicio){
        const {name, instructions} = ejercicio;
        exerciseNameInfo.innerText = `${name}`;
        exerciseInfo.innerText = `${instructions}`;
    }
    
}

function cerrarModalInformacion() {
    const modal = document.getElementById("modalInformacion");
    modal.style.display = "none";
}

saveSessionBtn.addEventListener('click', function(e){
    e.preventDefault();
    const mensajeSesionRapida = document.getElementById('mensajeSesionRapida');
    const weekday = weekdays.value;
    const ejerciciosJSON = JSON.stringify(ejerciciosSesion)
    const data = {
        weekday : weekday,
        ejerciciosJSON : ejerciciosJSON
    }
    fetch('../php/saveQuickSession.php', {
        method : 'POST',
        headers : {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify(data) 
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            mensajeSesionRapida.classList.add('session-save-success')
            mensajeSesionRapida.innerHTML = `<p><i class="fa-solid fa-check"></i> ${data.message}</p>`
            
            setTimeout(function () {
                mensajeSesionRapida.innerHTML = ``;
                mensajeSesionRapida.classList.remove('session-save-success')
            }, 2000);

        }else if(data.message){
            mensajeSesionRapida.classList.add('session-save-error')
            mensajeSesionRapida.innerHTML = `<p><i class="fa-solid fa-triangle-exclamation"></i> ${data.message}</p>`
            
            setTimeout(function () {
                mensajeSesionRapida.innerHTML = ``;
                mensajeSesionRapida.classList.remove('session-save-error')
            }, 2000);
        }
    })
    .catch(error => console.error('Error', error));
});

function onload(){
    obtenerEjercicio(musclesInput.value)
    obtenerDiaSemana(weekdays.value)
}

window.onload = onload();

weekdays.addEventListener('change', function(){
    obtenerDiaSemana(weekdays.value);
});

function obtenerDiaSemana(day){
    const data = {
        day: day
    };

    fetch('getRoutine.php', {
        method: 'POST',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Hubo un problema al obtener los datos.');
        }
        return response.json();
    })
    .then(jsonData => {
        if(!jsonData.message){
            ejerciciosSesion = jsonData;
            imprimirEjerciciosSesion(ejerciciosSesion);
        }else{
            ejerciciosSesion = [];
            exercisesSession.innerHTML = ``;
            const divDiaVacio = document.createElement('h2');
            divDiaVacio.classList.add('mensaje-dia-vacio');
            divDiaVacio.innerText = jsonData.message;
            exercisesSession.appendChild(divDiaVacio);
        }
    })
    .catch(error => {
        console.error('Error al obtener los datos:', error);
    });
}