// показывает окно ввода ДР при первом входе в личный кабинет
// не отображается у admin
if(auth && exitCount==0 && visitCount==1 && login!=='admin') document.querySelector('#birthdaySection').className = 'modal modal_active'; 

// Закрытие модального окна
const closeBirthdayBtn = document.querySelector('#birthday__closeBtn');
if(closeBirthdaySendWindowBtn) closeBirthdayBtn.onclick = () => document.querySelector('#birthdaySection').className='modal'; 

// разблокировка кнопки отправки при вводе даты
let birthdayInput = document.querySelector('.birthday__birthdayInput');
if(birthdayInput) birthdayInput.oninput = () => document.querySelector('.birthday__sendBtn').disabled = false; 
