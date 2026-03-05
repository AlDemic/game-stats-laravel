//JS logic file for admin to work with ONLINE and INCOME
//list of func: add and delete game's record depends on stat

//take same function from games.js
import { gameActions } from "./games";

//common vars
const notifBlock = document.querySelector('.sys-msg'); //notification block for user
const token = document.querySelector("meta[name='csrf-token']").getAttribute('content'); //csrf token for post operation

//common array for different function
const arrayFunc = {
    addRecordOnline: {elId: 'add-record-online', fetchUrl: '/admin/api/add-record-online'},
    addRecordIncome: {elId: 'add-record-income', fetchUrl: '/admin/api/add-record-income'},

    delOnlineOneRecord: {elId: 'del-record-online-one', fetchUrl: '/admin/api/del-record-online/one'},
    delOnlineMonthRecord: {elId: 'del-record-online-month', fetchUrl: '/admin/api/del-record-online/month'},

    delIncomeOneRecord: {elId: 'del-record-income-one', fetchUrl: '/admin/api/del-record-income/one'},
    delIncomeMonthRecord: {elId: 'del-record-income-month', fetchUrl: '/admin/api/del-record-income/month'},

    //get records
    getOnlineRecords: {elId: 'month-info', fetchUrl: '/admin/api/records/online'},
};

//load page
document.addEventListener('DOMContentLoaded', () => {
    gameActions(arrayFunc.addRecordOnline.elId, arrayFunc.addRecordOnline.fetchUrl, notifBlock); //add online record
    gameActions(arrayFunc.addRecordIncome.elId, arrayFunc.addRecordIncome.fetchUrl, notifBlock); //add income record

    gameActions(arrayFunc.delOnlineOneRecord.elId, arrayFunc.delOnlineOneRecord.fetchUrl, notifBlock); //delete one record from online
    gameActions(arrayFunc.delOnlineMonthRecord.elId, arrayFunc.delOnlineMonthRecord.fetchUrl, notifBlock); //delete online records for month from online

    gameActions(arrayFunc.delIncomeOneRecord.elId, arrayFunc.delIncomeOneRecord.fetchUrl, notifBlock); //delete one record from income
    gameActions(arrayFunc.delIncomeMonthRecord.elId, arrayFunc.delIncomeMonthRecord.fetchUrl, notifBlock); //delete income records for month from online

    //records
    getGameRecords(arrayFunc.getOnlineRecords.elId, arrayFunc.getOnlineRecords.fetchUrl, notifBlock); //get online records for selected game
});

//get games records to delete
function getGameRecords(elId, fetchUrl, notifBlock) {
    const monthInfoForm = document.getElementById(`${elId}`); //block with records
    if(!monthInfoForm) return;

    monthInfoForm.addEventListener('submit', async (e) => {
    e.preventDefault(); //stop auto reload

    //switch off submit btn
    const submitBtnControl = document.querySelector('[type="submit"]');
    submitBtnControl.disabled = true;

    try{
        const form = new FormData(e.target);

        //make server request
        const req = await fetch(`${fetchUrl}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: form
        });

        //get request
        const res = await req.json(); //get json

        //get block to write msg
        const recordsBlock = document.querySelector('.month-info__records');
        if(!recordsBlock) return;
        if(!notifBlock) return;

        if(Array.isArray(res.records) && res.records.length > 0) {
            recordsBlock.innerHTML = ''; //clean content
            notifBlock.innerHTML = ''; //clean msg inform block

            res.records.forEach(rec => {
                const p = document.createElement('p');
                p.innerHTML = `Stat: ${rec.stat} - <span>Source: ${rec.source}</span><br/>`;
                recordsBlock.appendChild(p);
            });
            } else if(res.errors) {
                notifBlock.innerHTML = ''; //clean msg inform
                notifBlock.innerHTML = `<p style="color:red">${Object.values(res.errors)[0][0]}</p>`;
            } else {
                notifBlock.innerHTML = ''; //clean msg inform
                notifBlock.innerHTML = "<p style='color:red'>No data</p>";
            }
    } catch(err) {
        console.log(err);
    } finally {
        //switch on button
        submitBtnControl.disabled = false;
    }
   });
}

