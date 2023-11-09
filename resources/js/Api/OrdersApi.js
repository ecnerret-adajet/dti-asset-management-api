export default class OrdersApi {
    status = (formData) => axios.get(`/api/order-statuses`,formData)
        .then(response => response.data)
        .catch(error => error.response)
}
