let menu = document.querySelector('#menu-icon')
let navlist = document.querySelector('.navlist')

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navlist.classList.toggle('open');
}

let sections = document.querySelectorAll('section');
let navlink = document.querySelectorAll('.navlist ul li a');
window.onscroll = () => {
    sections.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop - 150;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if(top >=  offset && top < offset + height) {
            navlink.forEach(links =>{
                links.classList.remove('active');
                document.querySelector('.navlist ul li a[href*' + id + ']').classList.add('active');
            });
        };
    });
};
