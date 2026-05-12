window.axios = {
    defaults: {
        headers: {
            common: {}
        }
    }
};

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';