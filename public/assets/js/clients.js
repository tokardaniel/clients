
( async () => {

    let cars_table_contaier = null;
    let spinner_div = null;
    let services_table_container = null;
    let nameOfCarColumns = ['autó sorszáma', 'autó típusa', 'regisztrálás időpontja', 'saját márkás', 'balesetek száma', 'legutolsó legsúlyosabb szervízbejegyzés', 'legutolsó szervízbejegyzés ideje'];

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

    document.addEventListener('DOMContentLoaded', async () => {
        cars_table_contaier = document.getElementById('cars_table_container');
        spinner_div = document.getElementById('spinner_div');
        services_table_container = document.getElementById('services_table_container');
        const tds = document.getElementsByClassName('td_client_name');
        for (td of tds) {
            td.addEventListener('click', (e) => showCars(e));
        }
    });

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
