(function(document, window) {
    const APP_ID = 7177682,
          API_V = 5.102,
          PAGE_LIMIT = 1000,
          MIN_YEAR = 1900,
          AGE_RESTRICTIONS = [20, 40],
          FIELDS = 'first_name,last_name,nickname,photo_200';

    let form,
        day,
        month,
        year,
        results,
        tile,
        status,
        fields = [];

    const init = () => {
        form = document.getElementById('form');
        day = document.getElementById('day');
        month = document.getElementById('month');
        year = document.getElementById('year');
        results = document.getElementById('results');
        tile = document.getElementById('tile');
        status = document.getElementById('status');

        fields = [year, month, day];

        for (let field of fields) {
            field.addEventListener('input', onInputChange);
        }

        form.addEventListener('submit', onFromSubmit);

        apiInit();
        enableForm();
        setStatus('Ready');
    };

    const enableForm = (isEnabled = true) => {
        form.classList.toggle('form-disabled', !isEnabled);
    };

    const setMessage = (target, message = '') => {
        if (message === '') {
            if (target.hasAttribute('data-message')) {
                target.removeAttribute('data-message');
            }

            if (form.hasAttribute('data-message')) {
                form.removeAttribute('data-message');
            }
        } else {
            target.setAttribute('data-message', message);
        }
    };

    const setStatus = message => {
        status.innerHTML = message;
    };

    const setResults = items => {
        results.innerHTML = '';

        let fragment = new DocumentFragment();

        let template,
            link,
            image,
            caption,
            name;

        for (let {id, first_name, last_name, nickname, photo_200} of items) {
            name = [first_name, nickname === '' ? nickname : `"${nickname}"`, last_name].filter(i => i !== '').join(' ');

            template = tile.content.cloneNode(true);

            link = template.querySelector('.tile');
            image = template.querySelector('.tile__image');
            caption = template.querySelector('.tile__caption');

            link.setAttribute('href', `https://vk.com/id${id}`);
            link.setAttribute('title', name);

            if (photo_200) {
                image.setAttribute('src', photo_200);
                image.removeAttribute('srcset');
                image.addEventListener('load', onImageLoad);
                image.addEventListener('error', onImageError);
            }
            image.setAttribute('alt', name);
            image.setAttribute('title', name);

            caption.innerHTML = name;

            fragment.append(template);
        }

        results.append(fragment);
    };

    const login = () => {
        return new Promise((resolve, reject) => {
            apiAuth().then(status => {
                resolve(status);
            }).catch(() => {
                return apiAuth('login');
            }).then(status => {
                resolve(status);
            }).catch(error => {
                reject(new Error(`Login failed: ${error.message}`));
            });
        });
    };

    const search = async (birth_year, birth_month, birth_day, offset = 0, count = PAGE_LIMIT, fields = FIELDS) => {
        enableForm(false);

        await login().then(() => {
            return apiCall('users.search', {
                birth_year, birth_month, birth_day, offset, count, fields
            });
        }).then(({ count, items }) => {
            setStatus(`${items.length} records out of ${count} loaded`);
            setResults(items);
        }).catch(error => {
            setStatus(error.message);
        });

        enableForm(true);
    };

    /* listeners */

    const onInputChange = event => {
        setMessage(event.currentTarget.parentElement);
    };

    const onFromSubmit = event => {
        event.preventDefault();

        const NOW = new Date();

        const messages = new Map(),
              values = new Map();

        for (let field of fields) {
            switch (true) {
                case field.validity.valueMissing:
                    messages.set(field, 'Value missing');
                    break;
                case field.validity.stepMismatch:
                    messages.set(field, 'Value must be integer');
                    break;
                default:
                    const value = parseInt(field.value);

                    switch (field) {
                        case year:
                            const currentYear = NOW.getFullYear();

                            if (value < MIN_YEAR || value > currentYear) {
                                messages.set(field, `Value must be between ${MIN_YEAR} and ${currentYear} inclusive`);
                            } else {
                                values.set(field, value);
                            }
                            break;
                        case month:
                            if (value < 1 || value > 12) {
                                messages.set(field, `Value must be between 1 and 12 inclusive`);
                            } else {
                                values.set(field, value);
                            }
                            break;
                        case day:
                            if (values.has(year) && values.has(month)) {
                                const daysInMonth = new Date(values.get(year), values.get(month), 0).getDate();

                                if (value < 1 || value > daysInMonth) {
                                    messages.set(field, `Value must be between 1 and ${daysInMonth} inclusive`);
                                } else {
                                    values.set(field, value);
                                }
                            }
                            break;
                    }
            }
        }

        if (messages.size > 0) {
            for (let [field, message] of messages) {
                setMessage(field.parentElement, message);
            }
        } else {
            const vals = [values.get(year), values.get(month), values.get(day)];

            const birthDate = new Date(...vals);

            const y = NOW.getFullYear() - birthDate.getFullYear(),
                  m = NOW.getMonth() - birthDate.getMonth(),
                  d = NOW.getDate() - birthDate.getDate();

            let age = (m < 0 || (m === 0 && d < 0)) ? y - 1 : y;

            if (age < AGE_RESTRICTIONS[0] || age > AGE_RESTRICTIONS[1]) {
                setMessage(form, `Age must be between ${AGE_RESTRICTIONS[0]} and ${AGE_RESTRICTIONS[1]} inclusive`);
            } else {
                search(...vals);
            }
        }

        return false;
    };

    const onImageLoad = event => {
        const target = event.currentTarget;

        target.classList.toggle('tile__image-loaded', true);
    };

    const onImageError = event => {
        const target = event.currentTarget;

        target.setAttribute('src', 'img/placeholder@1x.png');
        target.setAttribute('srcset', 'img/placeholder@1x.png 1x, img/placeholder@2x.png 2x, img/placeholder@3x.png 3x, img/placeholder@4x.png 4x');
        target.classList.toggle('tile__image-loaded', true);
    };

    /* VK API */

    const apiInit = (apiId = APP_ID) => {
        VK.init({ apiId });
    };

    const apiAuth = (method = 'getLoginStatus') => {
        return new Promise((resolve, reject) => {
            if (method === 'logout') {
                resolve(VK.Auth[method]());
            } else {
                VK.Auth[method](({ session, status }) => {
                    if (session) {
                        resolve(status);
                    } else {
                        reject(new Error(status));
                    }
                });
            }
        });
    };

    const apiCall = (method, params = {}) => {
        if (!('v' in params)) params.v = API_V;

        return new Promise((resolve, reject) => {
            VK.Api.call(method, params, data => {
                if ('error' in data) {
                    reject(new Error(data.error.error_msg));
                } else {
                    resolve(data.response);
                }
            });
        });
    };

    document.addEventListener('DOMContentLoaded', init);
})(document, window);
