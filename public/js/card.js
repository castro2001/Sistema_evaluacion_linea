const peticion = async ()=>{
    const request = await fetch(`App/Model/card.json`);
    const response = await request.json();
    console.log();
    
    const cardHtml= document.querySelector('#CardContainer')
    response.Card.map(item=>{
        cardHtml.innerHTML +=`
        <div class="col">
                <a href="Preguntas/test/${item.link}"  class="border-none shadow card rounded-4 text-decoration-none ">
                <img src="${item.image}" class=" card-img-top img-fluid" style="height:240px"  alt="...">
                <div class="card-body">
                    <h5 class="card-title">${item.title}</h5>
                </div>
                </a>
           </div>
        `;
    })


}

peticion()
