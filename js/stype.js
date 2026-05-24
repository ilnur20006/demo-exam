document.querySelectorAll('button').forEach(btn => {
    btn.onclick = function(){
        this.style.transform = 'scale(0.97)';
        setTimeout(() => this.style.transform = "" , 150);
    }
});
const othercheckbox = document.getElementById('other_checkbox');
const otherblock = document.getElementById('other_blokc');

if(othercheckbox && otherblock){
    othercheckbox.addEventListener('change' , function(){
        otherblock.style.display = this.checked ? 'block' : 'none';
    });
}