

const przycisk = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');
const statusInfo = document.querySelector('#status');
const poleMax = document.querySelector('#poleMax');
const wykres = document.querySelector('#wykres');

// Menu mobilne
przycisk.addEventListener('click', function () {
    const otwarte = menu.classList.toggle('menu--open');
    przycisk.setAttribute('aria-expanded', otwarte);
});

// Wyświetlanie tabeli
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

// Rysowanie wykresu SVG
function rysujWykres(uslugi) {

    const SVG_NS = 'http://www.w3.org/2000/svg';

    // Usuwamy poprzedni wykres
    wykres.replaceChildren();

    const najwieksza = Math.max(
        1,
        ...uslugi.map(u => Number(u.popularnosc))
    );

    uslugi.forEach(function (usluga, i) {

        // Nazwa usługi
        const tekst = document.createElementNS(SVG_NS, 'text');

        tekst.setAttribute('x', 5);
        tekst.setAttribute('y', i * 40 + 20);
        tekst.textContent = usluga.nazwa;

        wykres.append(tekst);

        // Pasek wykresu
        const pasek = document.createElementNS(SVG_NS, 'rect');

        pasek.setAttribute('x', 180);
        pasek.setAttribute('y', i * 40);

        const dlugosc =
            Number(usluga.popularnosc) / najwieksza * 260;

        pasek.setAttribute('width', dlugosc);
        pasek.setAttribute('height', 28);
        pasek.setAttribute('fill', 'steelblue');

        wykres.append(pasek);
    });
}

// Pobieranie usług z API
async function wczytajUslugi(max = '') {

    const adres = max === ''
        ? 'api.php'
        : 'api.php?max=' + encodeURIComponent(max);

    try {

        const odpowiedz = await fetch(adres);

        if (!odpowiedz.ok) {
            throw new Error('HTTP ' + odpowiedz.status);
        }

        const uslugi = await odpowiedz.json();

        pokazTabele(uslugi);
        rysujWykres(uslugi);

        statusInfo.textContent = '';

    } catch (blad) {

        statusInfo.textContent =
            'Nie udało się wczytać cennika.';
    }
}

// Debounce – opóźnienie 300 ms
let opoznienie;

poleMax.addEventListener('input', function () {

    clearTimeout(opoznienie);

    opoznienie = setTimeout(function () {

        wczytajUslugi(poleMax.value.trim());

    }, 300);
});

// Początkowe pobranie wszystkich usług
wczytajUslugi();
