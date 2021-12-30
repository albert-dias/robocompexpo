import Axios from 'axios';

const api = Axios.create({
    baseURL: 'http://192.168.88.92:3333/'
});

export default api;