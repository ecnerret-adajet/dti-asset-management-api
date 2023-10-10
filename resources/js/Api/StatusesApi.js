export default class StatusesApi {
    list = () => axios.get(`/api/statuses`)
        .then(response => response.data)
        .catch(error => error.response);
}
