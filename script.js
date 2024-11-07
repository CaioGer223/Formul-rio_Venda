document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const fotos = formData.getAll("fotos");

        const anuncioData = {
            titulo: formData.get("titulo"),
            price: formData.get("price"),
            descricao: formData.get("descricao"),
            marca: formData.get("marca"),
            modelo: formData.get("modelo"),
            km: formData.get("km"),
            data: formData.get("data"),
            cambio: formData.get("cambio"),
            opcionais: formData.getAll("opcional"),
            fotos: []
        };

        let imagensProcessadas = 0;

        if (fotos.length > 0) {
            fotos.forEach(foto => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    anuncioData.fotos.push(e.target.result);
                    imagensProcessadas++;

                    if (imagensProcessadas === fotos.length) {
                        localStorage.setItem('anuncio', JSON.stringify(anuncioData));
                        window.location.href = "anuncio.html";
                    }
                };
                reader.readAsDataURL(foto);
            });
        } else {
            localStorage.setItem('anuncio', JSON.stringify(anuncioData));
            window.location.href = "anuncio.html"; 
        }
    });
});
