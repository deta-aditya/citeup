/**
 * The Citeup object.
 * The logic for accessing API and something else.
 */

var Citeup = {};

Citeup.csrf = document.head.querySelector('meta[name="csrf-token"]').content;

Citeup.gmapKey = 'AIzaSyAgPkOOLDX99cfexC_3kUCxKNCPI6aHJh4';

Citeup.appPath = document.head.querySelector('meta[name="app-path"]').content;

Citeup.apiPath = Citeup.appPath + '/api/v1';

Citeup.defaultImage = Citeup.appPath + '/images/default.jpg';

Citeup.defaultTableParams = {
    skip: 0,
    take: 15,
}

Citeup._api = function(resource, method, params) {
    return axios[method](Citeup.apiPath + resource, params);
}

Citeup.get = function(resource, params = {}) {
    return Citeup._api(resource, 'get', {params: params});
}

Citeup.post = function(resource, params) {
    return Citeup._api(resource, 'post', params);
}

Citeup.put = function(resource, params) {
    return Citeup._api(resource, 'put', params);
}

Citeup.delete = function(resource, params = {}) {
    return Citeup._api(resource, 'delete', {params: params});
}

export default Citeup;
