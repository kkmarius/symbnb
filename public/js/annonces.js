$('#add-image').click(function(){
    // Récupère le numéro des futurs champs que je veux créer
    const index = +$('#widgets-counter').val();

    //Récupère le prototype des entrées
    const template = $('#annonces_images').data('prototype').replace(/__name__/g, index)

    // console.log(template);

    $('#annonces_images').append(template);

    $('#widgets-counter').val(index +1);

    // Le bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        
        // console.log(target);

        $(target).remove();
    });
}

function updateCounter(){
    const count = +$('#annonces_images div.form-group').length;

    $('#widgets-counter').val(count);
}

// A l'initialisation on met à jour le compteur
updateCounter();
// A l'initialisation de la page tout supprimer
handleDeleteButtons();