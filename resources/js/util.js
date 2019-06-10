(function (util, undefined) {
        //Private Property
        var isHot = true;

        // Public properties
        util.token = document.head.querySelector('meta[name="csrf-token"]');

        //Public Methods
        /**
         * ---------------------------------------------------------------
         * Creates a form with the given data and submits the form to the
         * provided URL. If no data is provided, empty form is submitted.
         * ---------------------------------------------------------------*/
        util.submit = function (url, data, method) {
                if (typeof url === 'undefined') {
                        return;
                }
                if (typeof data === 'undefined') {
                        data = {}
                }
                if (typeof method === 'undefined') {
                        method = 'post'
                }
                const form = document.createElement('form')
                form.method = (method.toLowerCase() === 'get'? 'GET' : 'POST')
                form.action = url
                for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                                const hiddenField = document.createElement('input');
                                hiddenField.type = 'hidden';
                                hiddenField.name = key;
                                hiddenField.value = data[key];
                                form.appendChild(hiddenField);
                        }
                }
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = util.token.content;
                form.appendChild(csrfField)

                if (method.toLowerCase() === 'delete' || method.toLowerCase() === 'patch' || method.toLowerCase() === 'put') {
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = method.toUpperCase();
                        form.appendChild(methodField)
                }

                document.body.appendChild(form)
                form.submit()
        }

        /**
         * ---------------------------------------------------------------
         * Makes ajax request to the URL with or without the given data
         * ---------------------------------------------------------------*/
        util.ajax = function (type, 
                url, 
                data, 
                success_handler, 
                client_error_handler, 
                server_error_handler, 
                other_error_handler
        ) {
                if (typeof type === 'undefined') type = 'post';
                if (typeof url === 'undefined') return;
                if (typeof data === 'undefined') data = {};
                if (typeof success_handler === 'undefined') success_handler = function (response_data) {
                        alert('Operation completed successfully');
                        console.log(response_data)
                };
                const general_error_handler = function (statusCode, data) {
                        let message = (data.hasOwnProperty('message')? data.message : 'There is an error while trying to reach server.')
                        alert(statusCode + ': ' + message);
                        console.log(data)
                }
                if (typeof client_error_handler === 'undefined') client_error_handler = general_error_handler;
                if (typeof server_error_handler === 'undefined') server_error_handler = general_error_handler;
                if (typeof other_error_handler === 'undefined') other_error_handler = general_error_handler;

                let handler;

                switch(type) {
                        case 'get':
                                handler = axios.get(url);
                                break;
                        case 'post':
                                handler = axios.post(url, data);
                                break;
                        case 'patch':
                                handler = axios.patch(url, data);
                                break;
                        case 'delete':
                                handler = axios.delete(url);
                }

                handler.then((response) => {
                        console.log('success')
                        success_handler(response.data)
                });

                handler.catch((error) => {
                        // Error
                        if (error.response) {
                                // The request was made and the server responded with a status code
                                // that falls out of the range of 2xx

                                if (error.response.status >= 400 && error.response.status < 500) {
                                        client_error_handler(error.response.status, error.response.data)
                                }
                                if (error.response.status >= 500) {
                                        server_error_handler(error.response.status, error.response.data)
                                }
                                // console.log(error.response.headers);
                        } else if (error.request) {
                                // The request was made but no response was received
                                // `error.request` is an instance of XMLHttpRequest in the browser 
                                other_error_handler('204', 'The request was made but no response was received. Please try again later.')
                                console.log(error.request);
                        } else {
                                // Something happened in setting up the request that triggered an Error
                                other_error_handler('000', 'Something wrong happened in setting up the request.');
                                console.log('Error', error.message);
                        }
                        // console.log(error.config);
                });
        }
        // axios.patch('/admin/categories/' + this.id, {
        //         'name': this.name, 'description': this.description, 'parent_id': this.parent_id
        // }).then((response) => {
        //         flash({ message: response.data.flash.message })
        // })
        // .catch

        //Private Method
        // function addItem(item) {}

}(window.util = window.util || {}));