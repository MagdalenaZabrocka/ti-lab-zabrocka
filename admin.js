console.log('ADMIN.JS ZOSTAŁ ZAŁADOWANY');
const formularz = document.querySelector('#formularz-dodawania');
const listaUslug = document.querySelector('#lista-uslug');
const komunikat = document.querySelector('#komunikat');

formularz.addEventListener('submit', async function (e) {
    e.preventDefault();

    console.log('FORMULARZ ZOSTAŁ WYSŁANY');

    const nazwa = document.querySelector('#nazwa').value.trim();
    const cena = document.querySelector('#cena').value;

    try {
        const odpowiedz = await fetch('api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nazwa, cena })
        });

        const dane = await odpowiedz.json();

        if (odpowiedz.status === 201) {

            const wiersz = document.createElement('tr');

            const komorkaId = document.createElement('td');
            komorkaId.textContent = dane.id;

            const komorkaNazwa = document.createElement('td');
            komorkaNazwa.textContent = dane.nazwa;

            const komorkaCena = document.createElement('td');
            komorkaCena.textContent = dane.cena + ' zł';

            const komorkaAkcja = document.createElement('td');

            const formularzUsuwania = document.createElement('form');
            formularzUsuwania.method = 'post';
            formularzUsuwania.className = 'd-inline';

            const akcja = document.createElement('input');
            akcja.type = 'hidden';
            akcja.name = 'akcja';
            akcja.value = 'usun';

            const id = document.createElement('input');
            id.type = 'hidden';
            id.name = 'id';
            id.value = dane.id;

            const przyciskUsuwania = document.createElement('button');
            przyciskUsuwania.type = 'submit';
            przyciskUsuwania.className = 'btn btn-sm btn-outline-danger';
            przyciskUsuwania.textContent = 'Usuń';

            formularzUsuwania.append(akcja, id, przyciskUsuwania);
            komorkaAkcja.append(formularzUsuwania);

            wiersz.append(
                komorkaId,
                komorkaNazwa,
                komorkaCena,
                komorkaAkcja
            );

            listaUslug.append(wiersz);

            formularz.reset();

            komunikat.textContent = 'Usługa została dodana!';
            komunikat.className = 'alert alert-success mt-3';

        } else {
            komunikat.textContent = dane.blad || 'Nie udało się dodać usługi.';
            komunikat.className = 'alert alert-danger mt-3';
        }

    } catch (blad) {
        komunikat.textContent = 'Błąd połączenia z serwerem.';
        komunikat.className = 'alert alert-danger mt-3';
    }
});
