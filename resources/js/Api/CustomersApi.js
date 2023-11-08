export default class CustomersApi {
    list = () => axios.get(`/api/customers/list`)
        .then(response => response.data)
        .catch(error => error.response)
    orders = (customer_id) => axios.get(`/api/customer-orders/${customer_id}`)
        .then(response => response)
        .catch(error => error.response)
    totalCost = (customer_id) => axios.get(`/api/customer-total-cost/${customer_id}`)
        .then(response => response)
        .catch(error => error.response)
}
