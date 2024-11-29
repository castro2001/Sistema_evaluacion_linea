export const peticion = async (url)=>{
    const request = await fetch(`App/Model/${url}.json`);
    const response = await request.json();
    return response
}


let currentIndex = 0;
const questionsPerPage = 3;
let respuestasSeleccionadas = {};//mantener las preguntas seleccionadas

peticion('Questions')
.then(data=>{
    const responseData= data.question;
    const questionHtml = document.getElementById('question');
//Preguntas
const start = currentIndex;
const end = start + questionsPerPage;

responseData.slice(start,end)
    responseData.map(item => {
        questionHtml.innerHTML +=`
         <ul class="list-group" >
            <li class="list-group-item">
            ${item.question}
            </li>
                  <li class="list-group-item">
        ${item.options.map(opcion => `
        <label class="btn btn-outline-danger">${opcion}
        <input
        class="btn radio w-10 md:w-24 text-xl md:text-3xl"
        type="radio"
        name="options-${item.id}"
        aria-label="${opcion}"
        title="${opcion}"
        value="${opcion}"

        />
        </label>
        `).join('')}

    </li>
                </ul>
        `; 
    });
   
    
})

