function setupCarrossel(carrosselId) {
    const carrossel = document.getElementById(carrosselId);
    let isDown = false; // Estado do mouse
    let startX; // Posição inicial do mouse
    let scrollLeft; // Posição inicial do scroll

    // Inicia o arrasto do mouse
    carrossel.addEventListener('mousedown', (e) => {
        isDown = true; // O mouse está pressionado
        startX = e.pageX - carrossel.offsetLeft; // Captura a posição inicial do mouse
        scrollLeft = carrossel.scrollLeft; // Captura a posição do scroll
        carrossel.style.cursor = 'pointer'; // Muda o cursor para 'pointer'
    });

    // Finaliza o arrasto do mouse
    carrossel.addEventListener('mouseleave', () => {
        isDown = false; // O mouse não está pressionado
        carrossel.style.cursor = 'pointer'; // Restaura o cursor
    });

    carrossel.addEventListener('mouseup', () => {
        isDown = false; // O mouse não está pressionado
        carrossel.style.cursor = 'pointer'; // Restaura o cursor
    });

    // Mover o carrossel
    carrossel.addEventListener('mousemove', (e) => {
        if (!isDown) return; // Se não estiver pressionado, não faz nada
        e.preventDefault(); // Evita seleção de texto
        const x = e.pageX - carrossel.offsetLeft; // Atualiza a posição do mouse
        const walk = (x - startX); // Distância que o mouse se moveu
        carrossel.scrollLeft = scrollLeft - walk; // Atualiza a posição do scroll
    });

    // Eventos de toque para dispositivos móveis
    carrossel.addEventListener('touchstart', (e) => {
        isDown = true; // O toque está ativo
        startX = e.touches[0].pageX - carrossel.offsetLeft; // Captura a posição inicial do toque
        scrollLeft = carrossel.scrollLeft; // Captura a posição do scroll
        carrossel.style.cursor = 'grabbing'; // Muda o cursor para 'grabbing'
    });

    carrossel.addEventListener('touchend', () => {
        isDown = false; // O toque não está ativo
        carrossel.style.cursor = 'grab'; // Restaura o cursor
    });

    carrossel.addEventListener('touchmove', (e) => {
        if (!isDown) return; // Se não estiver pressionado, não faz nada
        e.preventDefault(); // Evita seleção de texto
        const x = e.touches[0].pageX - carrossel.offsetLeft; // Atualiza a posição do toque
        const walk = (x - startX); // Distância que o toque se moveu
        carrossel.scrollLeft = scrollLeft - walk; // Atualiza a posição do scroll
    });

    // Impede o arrasto das imagens
    const imagens = carrossel.querySelectorAll('img');
    imagens.forEach(imagem => {
        imagem.addEventListener('dragstart', (e) => {
            e.preventDefault(); // Impede o comportamento padrão de arrastar
        });
    });
}

// Inicializa os carrosseis
setupCarrossel('carrossel-categorias');
setupCarrossel('carrossel-destaques');
