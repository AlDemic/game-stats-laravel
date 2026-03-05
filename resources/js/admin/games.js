//JS logic file for admin to work with GameController
//list of func: addGame, delGame

//common vars
const token = document.querySelector("meta[name='csrf-token']").getAttribute('content'); //csrf token for post operation
const notifBlock = document.querySelector('.sys-msg'); //notification block for user

//common array for different function
const arrayFunc = {
    add: {elId: 'add-game', fetchUrl: '/admin/api/add-game'},
    del: {elId: 'del-game', fetchUrl: '/admin/api/del-game'},
};

//load page
document.addEventListener('DOMContentLoaded', () => {
    gameActions(arrayFunc.add.elId, arrayFunc.add.fetchUrl, notifBlock);
    gameActions(arrayFunc.del.elId, arrayFunc.del.fetchUrl, notifBlock);
});

//common func for ADD and DEL game
export function gameActions(elId, fetchUrl, notifBlock) {
    const formBlock = document.getElementById(`${elId}`);
    if(!formBlock) return;

    formBlock.addEventListener("submit", async (e) => {
        e.preventDefault(); //stop refresh

        //switch off submit btn
        const submitBtnControl = document.querySelector('[type="submit"]');
        submitBtnControl.disabled = true;

        try {
            //get data from form
            const form = e.target;
            const formData = new FormData(form);

            //make request to server
            const req = await fetch(`${fetchUrl}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: formData
            });

            //if okey
            const res = await req.json();

            //msg for user
            if(!notifBlock) return;
            
            if(res.status === 'ok') {
                formBlock.reset(); //reset form

                notifBlock.innerHTML = `<p style="color:green">${res.msg}</p>`;
            } else if(res.errors) {
                notifBlock.innerHTML = `<p style="color:red">${Object.values(res.errors)[0][0]}</p>`;
            } else {
                notifBlock.innerHTML = `<p style="color:red">Error on server.</p>`;
            }
        } catch (err) {
            console.log(err);
        } finally {
            //switch on button
            submitBtnControl.disabled = false;
        }
    });
}