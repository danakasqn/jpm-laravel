import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Bootstrap JS (w tym Collapse, Dropdown, Modal itd.)
import 'bootstrap';
