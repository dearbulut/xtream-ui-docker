import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Xtream API için özel axios instance
window.xtreamApi = axios.create({
    baseURL: window.xtreamConfig?.apiUrl || '',
    timeout: 10000,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

// Request interceptor
window.xtreamApi.interceptors.request.use(
    (config) => {
        const username = window.xtreamConfig?.username;
        const password = window.xtreamConfig?.password;

        if (username && password) {
            config.params = {
                ...config.params,
                username,
                password
            };
        }

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Response interceptor
window.xtreamApi.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Yetkilendirme hatası
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);
