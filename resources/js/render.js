//JS logic for any render function

//blocks
const navBlock = document.querySelector('.nav'); //nav block 
const logoPicBlock = document.querySelector('.logo__pic'); //logo picture

//take global url for render
const urlSliced = (window.location.pathname).slice(7); //take url without '/'

//logo pic size
let logoHeight = 70;
let logoWidth = 150;

//render LOGO func
function renderLogo(src='/storage/logo/main-logo.png', alt='Game logo') {
    logoPicBlock.innerHTML = `<img src="${src}" width="${logoWidth}" height="${logoHeight}" alt="${alt}"/>`;
}

//navigation render
export async function renderNav(navList) { 
    //if in db exist any game
    if(Array.isArray(navList) && navList.length > 0) {
        navBlock.innerHTML = ''; //clear nav block

        //If url exist in array => render game's logo
        if(navList.find(nav => nav.url === urlSliced)) {
            const game = navList.find(nav => nav.url === urlSliced);
            const picGame = '/storage/' + game?.pic; 

            renderLogo(picGame, game?.title); //logo of selected game
        } else {
            renderLogo(); //main logo render
        }

        //create each game as nav btn
        for(let i = 0; i < navList.length; i++) {
            const navBtn = document.createElement('button');
            navBtn.className = 'btn-56'; 
            navBtn.textContent = navList[i].title;
            if(urlSliced === navList[i].url) {
                navBtn.disabled = true; //selected game
            }

            //change url
            navBtn.addEventListener('click', () => {
                const urlChange = navList[i].url; // /gameName in url
                window.location.href = `/games/${urlChange}`;
            });

            //add to html
            navBlock.appendChild(navBtn);
        }
    } else {
        //make "base" navigation
        navBlock.innerHTML = `<b>No games</b>`;

        //render base logo
        renderLogo();  
    }
}

