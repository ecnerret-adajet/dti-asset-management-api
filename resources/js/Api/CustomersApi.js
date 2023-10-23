export default class CustomersApi {
    list = () => axios.get(`/api/customers/list`)
        .then(response => response.data)
        .catch(error => error.response)
}
