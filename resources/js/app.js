import './bootstrap';
const value=document.querySelector('#balanceValue'); const toggle=document.querySelector('#toggleBalance');
toggle?.addEventListener('click',()=>{value.textContent=value.textContent.includes('•')?'Rp28.000.000':'Rp••••••••';});
