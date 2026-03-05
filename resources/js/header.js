//js logic take games list from DB and make as navigation in header

//take func from render
import { renderNav } from './render.js';

const fetchUrl = '/api/games-list'; //api route for request

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const req = await fetch(`${fetchUrl}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        //get result
        const res = await req.json();

        //check answer
        if(res.status === 'ok') {
            //send result to render function
            renderNav(res.gamesList);
        } else {
            //send no have games in case any errors
            renderNav('No games');
        }
    } catch(err) {
        console.log(err);
    }
});