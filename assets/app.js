import './styles/app.css';
import $ from "jquery"

import 'popper.js/dist/popper'
import 'bootstrap/dist/js/bootstrap.js';
import 'datatables.net/js/jquery.dataTables.js';
import 'datatables.net-bs5/js/dataTables.bootstrap5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';

$(document).ready(function () {
    $('#table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
    });
});