const currentDate = new Date();
currentDate.setTime(currentDate.getTime() + 15 * 60 * 1000);

let day = String(currentDate.getDate()).padStart(2, '0');
let month = String(currentDate.getMonth() + 1).padStart(2, '0');
let year = String(currentDate.getFullYear()).slice(-2);
let hours = String(currentDate.getHours()).padStart(2, '0');
let minutes = String(currentDate.getMinutes()).padStart(2, '0');

const formattedStartDateForInput = `${currentDate.getFullYear()}-${month}-${day}T${hours}:${minutes}`;

const currentDateEnd = new Date();
currentDateEnd.setTime(currentDateEnd.getTime() + 25 * 60 * 1000);
day = String(currentDateEnd.getDate()).padStart(2, '0');
month = String(currentDateEnd.getMonth() + 1).padStart(2, '0');
year = String(currentDateEnd.getFullYear()).slice(-2);
hours = String(currentDateEnd.getHours()).padStart(2, '0');
minutes = String(currentDateEnd.getMinutes()).padStart(2, '0');

const formattedEndDateForInput = `${currentDate.getFullYear()}-${month}-${day}T${hours}:${minutes}`;

const futureDate = new Date(currentDate);
futureDate.setMonth(futureDate.getMonth() + 1);

const futureDay = String(futureDate.getDate()).padStart(2, '0');
const futureMonth = String(futureDate.getMonth() + 1).padStart(2, '0');
const futureYear = String(futureDate.getFullYear()).slice(-2);
const futureHours = String(futureDate.getHours()).padStart(2, '0');
const futureMinutes = String(futureDate.getMinutes()).padStart(2, '0');

const formattedDateForFutureInput = `${futureDate.getFullYear()}-${futureMonth}-${futureDay}T${futureHours}:${futureMinutes}`;

const fieldStart = document.getElementById('reserve_place_form_start');
const fieldEnd = document.getElementById('reserve_place_form_end');
fieldStart.value = formattedStartDateForInput;
fieldStart.min = formattedStartDateForInput;
fieldStart.max = formattedDateForFutureInput;
fieldEnd.value = formattedEndDateForInput;
fieldEnd.min = formattedEndDateForInput;
fieldEnd.max = formattedDateForFutureInput;