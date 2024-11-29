let currentIndex= 0;
let questionPerPage =2;
const url= "http://localhost/Sistema_evaluacion_linea";

let timeRemaining= 100;
let timeInterval;
const question = document.querySelector('[data-preguntas]');
const questionID = question.getAttribute('data-preguntas')
let answersSelected={};

const peticion = async ()=>{

   
   const request = await fetch(`${url}/App/Model/${questionID}.json`);
   const response = await request.json();
   return response;
}

const peticions = async (url,options={})=>{
   const request = await fetch(url,options);
   const response = await request.json();
   return response;
}


const countTime = ()=>{
  const countdownContainer = document.getElementById('countdown-container');

   timerInterval = setInterval(() => {
      const minutes = Math.floor(timeRemaining / 60);
      const seconds = timeRemaining % 60;
      countdownContainer.innerHTML = `
         <span class="w-10 h-2 px-3 py-1 text-center text-white rounded shadow fs-5 bg-dark" id="countTime">
            <span >${String(minutes).padStart(2,'0')}</span>:
            <span >${String(seconds).padStart(2,'0')} </span>
         </span>
      `
      timeRemaining--;
      if (timeRemaining < 0) {
          clearInterval(timerInterval);
                     // Aquí puedes manejar lo que pasa cuando el tiempo se agota
         }
   }

   , 800);
}

const renderQuestion = () => {
   peticion().then(response => {
      const questions = response.Question;
      const start = currentIndex;
      const end = start + questionPerPage;
      const currentQuestions = questions.slice(start, end);
      const questionContainer = document.querySelector('#question-container');
      questionContainer.innerHTML = '';
      
      currentQuestions.forEach(item => {
         const { A, B, C, D } = item.options;
         const questionCard = document.createElement('div');
         questionCard.innerHTML = `
            <ul class="list-group" >
               <li class="list-group-item">
                  ${item.id}.- ${item.question}
               </li>

               <div class="mt-3 mb-3 form-check ps-5">
                  <input class="form-check-input" type="radio" name="answer-${item.id}" value="${A}" 
                     id="flexRadioDefault_${item.id}"
                     ${answersSelected["answer_" + item.id] === A ? 'checked' : ''} 
                     onchange="handleOptionChange(${item.id}, '${A}')">
                  <label class="form-check-label" for="flexRadioDefault_${item.id}">${A}</label>
               </div>

               <div class="mb-3 form-check ps-5">
                  <input class="form-check-input" type="radio" name="answer-${item.id}" value="${B}" 
                     id="flexRadioDefault_${item.id}"
                     ${answersSelected["answer_" + item.id] === B ? 'checked' : ''} 
                     onchange="handleOptionChange(${item.id}, '${B}')">
                  <label class="form-check-label" for="flexRadioDefault_${item.id}">${B}</label>
               </div>

               <div class="mb-3 form-check ps-5">
                  <input class="form-check-input" type="radio" name="answer-${item.id}" value="${C}" 
                     id="flexRadioDefault_${item.id}"
                     ${answersSelected["answer_" + item.id] === C ? 'checked' : ''} 
                     onchange="handleOptionChange(${item.id}, '${C}')">
                  <label class="form-check-label" for="flexRadioDefault_${item.id}">${C}</label>
               </div>

               <div class="mb-3 form-check ps-5">
                  <input class="form-check-input" type="radio" name="answer-${item.id}" value="${D}" 
                     id="flexRadioDefault_${item.id}"
                     ${answersSelected["answer_" + item.id] === D ? 'checked' : ''} 
                     onchange="handleOptionChange(${item.id}, '${D}')">
                  <label class="form-check-label" for="flexRadioDefault_${item.id}">${D}</label>
               </div>
            </ul>
         `;
         questionContainer.appendChild(questionCard);
      });

      buttonController();
   });
};




const progressBar = ()=>{
   peticion()
   .then(response=>{
      const questions=response.Question;
      const progressbar= document.getElementById('progressbar');
      const totalQuestions= questions.length;
      const answeredQuestions = Object.keys(answersSelected).length;
    const progressPercent = (answeredQuestions / totalQuestions) * 100;
    progressbar.style.width = `${progressPercent}%`; 
   
   });
}

const handleOptionChange = (questionid, selectedOption)=>{
   peticion()
   .then(response=>{
      const questions=response.Question;
      const currentQuestions=  questions.slice(currentIndex,currentIndex +questionPerPage );
      let allSelected = true;
      answersSelected["answer_"+ questionid ] = selectedOption;
      currentQuestions.forEach(question=>{
         const selectedOption = document.querySelector(`input[name="answer-${question.id}"]:checked`);
         if(!selectedOption){
            allSelected-=false
         }   
      });

      const nextButton = document.getElementById('nextButton');
      nextButton.disabled = !allSelected;

      if(allSelected === true && currentIndex + questionPerPage >=questions.length){
     
         // Mostrar el modal al terminar el cuestionario
         const modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
         modal.show();
      }else if (allSelected === true) {
         setTimeout(function(){
            currentIndex += questionPerPage;
            renderQuestion()
         },500)
         nextButton.disabled = allSelected;

      }
      progressBar()
      buttonController()
   })

}

const buttonController = ()=>{
   const prevButton = document.getElementById('prevButton');
   const nextButton = document.getElementById('nextButton');
  
  
   prevButton.disabled = currentIndex === 0;
   nextButton.disabled = Object.keys(answersSelected).length < (currentIndex + questionPerPage);

   prevButton.onclick = () => {
     
      currentIndex -= questionPerPage;
      renderQuestion()
      //restaurarRespuestas();
  };

  nextButton.onclick = () => {
  
   currentIndex += questionPerPage;
   renderQuestion()

  };
}


const formulario = ()=>{
   const form = document.querySelector('#formulario_preguntas');
   
   form.addEventListener('submit', (e)=>{
      e.preventDefault()
     
      
   const send= url+"/Preguntas/questionProccess"
       const options={
         method: 'POST',
         headers: {
           'Content-Type': 'application/json',       
         },
         body: JSON.stringify({
        
         [questionID]:answersSelected})
         , 
      }
     
      peticions(send,options)
      .then(response=>{
         console.log(response);
         if(response.message=== "ok"){
            window.location.href=url+"/Preguntas/resultado";
         }
         
      })
      .catch(error=>console.error(error))
      
   })
}
function restaurarRespuestas() {
   
   console.log(answersSelected);
   
}
restaurarRespuestas()
renderQuestion();
countTime();
formulario()
