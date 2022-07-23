document.addEventListener('DOMContentLoaded', function()
{
    const modal = document.querySelector('#modal');
    const no = document.querySelector('#no');
    const gavel = document.querySelector('#gavel');
    
    gavel.addEventListener('click', openModal);
    no.addEventListener('click', closeModal);
    
    function openModal()
    {
        modal.style.display = "block";
    }
    
    function closeModal()
    {
        modal.style.display = "none";
    }
});