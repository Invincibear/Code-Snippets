// Prevent <a href="#"> links from scrolling to top of page
// https://medium.com/@jacobwarduk/how-to-correctly-use-preventdefault-stoppropagation-or-return-false-on-events-6c4e3f31aedb
let links = document.getElementsByTagName("a");
for (let i = 0; i < links.length; i++) {
    console.log({i:i, link:links[i]});
    links[i].addEventListener('click', (event) => {
        if (links[i].href === '#' || links[i].href === 'https://gmetimeline.com/#') {
            event.preventDefault();
        }
    });
}