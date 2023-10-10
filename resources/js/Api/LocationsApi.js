export default class LocationsApi {
    list = () => axios.get(`/api/locations`)
        .then(response => response.data)
        .catch(error => error.response)
}
