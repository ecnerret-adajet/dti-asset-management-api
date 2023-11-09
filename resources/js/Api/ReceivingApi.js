export default class LocationsApi {
    list = () => axios.get(`/api/receivings`)
        .then(response => response.data)
        .catch(error => error.response);
    store = (formData) => axios.post(`/api/receivings`, formData)
        .then(response => response)
        .catch(error => error.response)
    status = (formData) => axios.get(`/api/receivings-statuses-stats`,formData)
        .then(response => response.data)
        .catch(error => error.response)
}
