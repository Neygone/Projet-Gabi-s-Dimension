document.addEventListener('DOMContentLoaded', function()
{
    const deconnexion_button = document.querySelector('.fa-power-off');
    const modal = document.querySelector('.modal');
    const yes = document.querySelector('.oui');
    const no = document.querySelector('.non');

    deconnexion_button.addEventListener('click', openModal);
    no.addEventListener('click', closeModal)
    
    function openModal()
    {
        modal.style.display = "block";
    }
    
    function closeModal()
    {
        modal.style.display = "none";
    }
})