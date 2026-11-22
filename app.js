
const przycisk = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');
const statusInfo = document.querySelector('#status');

przycisk.addEventListener('click', function () {
    const otwarte = menu.classList.toggle('menu--open');
    przycisk.setAttribute('aria-expanded', otwarte);
});


function pokazTabele(uslugi) {
    const tbody = document.querySelector('#uslugi-body');

    tbody.innerHTML = '';

    uslugi.forEach(usluga => {
        const wiersz = document.createElement('tr');

        const komorkaNazwa = document.createElement('td');
        komorkaNazwa.textContent = usluga.nazwa;

        const komorkaCena = document.createElement('td');
        komorkaCena.textContent = usluga.cena + ' zł';

        wiersz.appendChild(komorkaNazwa);
        wiersz.appendChild(komorkaCena);

        tbody.appendChild(wiersz);
    });
}

async function wczytajUslugi() { 
try { 
const odpowiedz = await fetch('api.php');// 1. wyślij i poczekaj 
if (!odpowiedz.ok) throw new Error('HTTP ' + odpowiedz.status);// 2. ok = 200–299 
const uslugi= await odpowiedz.json();// 3. JSON → tablica
pokazTabele(uslugi);// 4. narysuj
} catch (blad) {
statusInfo.textContent = 'Nie udało się wczytać cennika.';
} 
}