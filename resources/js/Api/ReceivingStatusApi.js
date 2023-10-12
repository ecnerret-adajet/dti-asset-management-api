export default class LocationsApi {
    list = () => axios.get(`/api/receiving-statuses`)
        .then(response => response.data)
        .catch(error => error.response)
}
