export default class InventoryApi {
    recent = () => axios.get(`/api/assets/recent`)
        .then(response => response.data)
        .catch(error => error.response)
}
