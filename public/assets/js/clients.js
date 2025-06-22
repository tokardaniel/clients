
( async () => {

    let cars_table_contaier = null;
    let spinner_div = null;
    let services_table_container = null;
    let errorMsgAlert = null;
    let errorMsgContent = null;
    let search_result_container = null;
    let nameOfCarColumns = ['autó sorszáma', 'autó típusa', 'regisztrálás időpontja', 'saját márkás', 'balesetek száma', 'legutolsó legsúlyosabb szervízbejegyzés', 'legutolsó szervízbejegyzés ideje'];
    let nameOFSearchResultColumns = ['ügyfél azonosítója', 'ügyfél neve', 'ügyfél okmányazonosítója', 'autók darabszáma', 'összes szerviznapló bejegyzések száma'];

    async function showCars(e) {
        client = await getClientById(e.target.id);
        drawTable(client);
    }

    async function getClientById(id) {
        spinner_div.style.display = 'inline-block';
        const json = await fetch(`/client/${id}`).then((response) => response.json()).catch((error) => {
            console.log('Hiba ajax hívás közben:', error);
            alert('Nem sikerült lekrédezni az ügyfelet');
        });
        spinner_div.style.display = 'none';

        return json;
    }

    async function getClientByName(name) {
        return await fetch(`/client/search-by-name/${name}`).then((response) => response.json()).catch((error) => {
            console.log('Hiba ajax hívás közben:', error);
            alert('Nem sikerült lekrédezni az ügyfelet');
        });
    }

    async function getClientByPersonalId(id) {
        return await fetch(`/client/search-by-personal-id/${id}`).then((response) => response.json()).catch((error) => {
            console.log('Hiba ajax hívás közben:', error);
            alert('Nem sikerült lekrédezni az ügyfelet');
        });
    }

    document.addEventListener('DOMContentLoaded', async () => {
        cars_table_contaier = document.getElementById('cars_table_container');
        spinner_div = document.getElementById('spinner_div');
        services_table_container = document.getElementById('services_table_container');
        errorMsgContent = document.getElementById('errorMsgContent');
        errorMsgAlert = document.getElementById('errorMsgAlert');
        search_result_container = document.getElementById('search_result_container');
        const tds = document.getElementsByClassName('td_client_name');
        for (td of tds) {
            td.addEventListener('click', (e) => showCars(e));
        }
        document.addEventListener('submit', async (e) => {
            e.preventDefault();
            const responseJSON = await search(e.target);
            if (responseJSON) {
                if (responseJSON.Error) { showErrorMsg(responseJSON.Error); search_result_container.innerHTML = ''; return }
                console.log(responseJSON);
                showSearchResultTable(responseJSON);
            }
        });
    });

    async function search(target) {
        const client_name = target.querySelector('#client_name_input').value.trim();
        const client_id = target.querySelector('#client_id_input').value.trim();
        const searchIsValid = searchInputsValidation(client_name, client_id);

        if (searchIsValid) {
            search_result_container.innerHTML = 'Keresés...';
            if (client_name) return await getClientByName(client_name);
            if (client_id) return await getClientByPersonalId(client_id);
        }

        return null;
    }

    function searchInputsValidation(client_name, client_id) {
        errorMsgAlert.style.display = 'none';


        if (client_name.length > 0 && client_id.length > 0) {
            showErrorMsg('Csak az egyik mezőt kell kitölteni!');
            return false;
        }

        if (client_name.length === 0 && client_id.length === 0) {
            showErrorMsg('Legalább az egyik mezőt ki kell tölteni!');
            return false;
        }

        const format = /^[0-9,a-z,A-Z]*$/;
        if (!format.test(client_id)) {
            showErrorMsg('Hibás okmányazonosító! Az azonosító csak betűket és számokat tartalmazhat.');
            return false;
        }

        return true;
    }

    function showSearchResultTable(searchResult) {
        search_result_container.innerHTML = '';
        const table = document.createElement('table');
        table.setAttribute('class', 'table');
        const thead = document.createElement('thead');
        const tr = document.createElement('tr');
        nameOFSearchResultColumns.forEach(title => {
            const th = document.createElement('th');
            th.innerHTML = title;
            tr.appendChild(th);
        });
        thead.appendChild(tr);
        const tbody = document.createElement('tbody');
        const tbody_tr = document.createElement('tr');
        const td_id = document.createElement('td');
        td_id.innerHTML = searchResult.id;
        tbody_tr.appendChild(td_id);
        const td_name = document.createElement('td');
        td_name.innerHTML = searchResult.name;
        tbody_tr.appendChild(td_name);
        const td_card_id = document.createElement('td');
        td_card_id.innerHTML = searchResult.card_number;
        tbody_tr.appendChild(td_card_id);
        const td_cars_count = document.createElement('td');
        td_cars_count.innerHTML = searchResult.cars_count;
        tbody_tr.appendChild(td_cars_count);
        const td_card_number = document.createElement('td');
        td_card_number.innerHTML = searchResult.services_count;
        tbody_tr.appendChild(td_card_number);
        tbody.appendChild(tbody_tr);
        table.appendChild(thead);
        table.appendChild(tbody);
        search_result_container.appendChild(table);
    }


    function showErrorMsg(msg) {
        errorMsgAlert.style.display = 'block';
        errorMsgContent.innerHTML = msg;
    }


    function show_services(e) {
        const car_id = e.target.id;
        services_table_container.style.display = 'block';

        if ($.fn.DataTable.isDataTable('#services_data_tables')) {
            $('#services_data_tables').DataTable().clear().destroy();
        }

        new DataTable('#services_data_tables', {
            ajax: {
                url: `/car/${car_id}`,
                dataSrc: (json) => {
                    return json.services;
                },
            },
            columns: [
                { data: 'log_number' },
                { data: 'event' },
                { data: 'event_time' },
                { data: 'document_id' }
            ],
            order: [[2, 'desc']]
        });
    }

    function drawTable(client) {
        cars_table_contaier.innerHTML = '';
        services_table_container.style.display = 'none';
        if (client.cars.length === 0) {
            cars_table_contaier.innerHTML = '<p class="text-center">Nincs autó az ügyfélhez rendelve</p>';
            return;
        }
        const table = document.createElement('table');
        table.setAttribute('class', 'table table-striped');
        const thead = document.createElement('thead');
        const h_tr = document.createElement('tr');
        for (let name of nameOfCarColumns) {
            const th = document.createElement('th');
            th.innerHTML = name;
            h_tr.appendChild(th);
        }
        thead.appendChild(h_tr);
        table.appendChild(thead);
        const tbody = document.createElement('tbody');
        for (car of client.cars) {
            const tr = document.createElement('tr');
            const td_id = document.createElement('td');
            const id_href = document.createElement('a');
            id_href.setAttribute('href', 'javascript:void(0)');
            id_href.setAttribute('id', car.id);
            id_href.innerHTML = car.id;
            id_href.addEventListener('click', (e) => show_services(e));
            td_id.appendChild(id_href);
            tr.appendChild(td_id);
            for (value of Object.values(car).slice(1)) {
                    const td = document.createElement('td');
                    td.innerHTML = value;
                tr.appendChild(td);
            }
            const tdMaxlog = document.createElement('td');
            tdMaxlog.innerHTML = client.maxLognumberOfName;
            tr.appendChild(tdMaxlog);
            const tdLogDate = document.createElement('td');
            tdLogDate.innerHTML = client.maxLognumberOfDate;
            tr.appendChild(tdLogDate);
            tbody.appendChild(tr);
        }
        table.appendChild(thead);
        table.appendChild(tbody);
        cars_table_contaier.appendChild(table);
    }

})();
