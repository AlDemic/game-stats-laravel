//js logic of parsing
//send user's form -> write notif MSG depends on result

const token = document.querySelector("meta[name='csrf-token']").getAttribute('content'); //csrf token for post operation

const urlType = new URLSearchParams(window.location.search).get('type');

const typeArray = {
    'select-parser': '/admin/api/parser/run',
    'load-json': '/admin/api/parser/load-json',
};

const startParserBtn = document.querySelector('.parser');

if(startParserBtn) {
    startParserBtn.addEventListener("submit", async (e) => {
        e.preventDefault(); //stop refresh

        //switch off submit btn
        const submitBtnControl = document.querySelector('[type="submit"]');
        submitBtnControl.disabled = true;

        try {
            //get data from form
            const form = e.target;
            const formData = new FormData(form);

            //make request to server
            const req = await fetch(`${typeArray[urlType]}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: formData
            });

            //if okey
            const res = await req.json();

            //notification block for user
            const notifBlock = document.querySelector('.sys-msg');
            if(!notifBlock) return; //safety

            notifBlock.innerHTML = ''; //clear content

            //msg for user
            if(res.status === 'ok') {
                form.reset(); //reset form

                notifBlock.innerHTML = `<p style="color:green">${res.msg}</p>`;
            } else if(res.errors) {
                notifBlock.innerHTML = `<p style="color:red">${Object.values(res.errors)[0][0]}</p>`;
            } else {
                notifBlock.innerHTML = `<p style="color:red">${res.msg}</p>`;
            }
        } catch (err) {
            console.log(err);
        } finally {
            //switch on button
            submitBtnControl.disabled = false;
        }
    });

}