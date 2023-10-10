export default class AssetsApi {
    list = () => axios.get(`/api/assets/list`)
    .then(response => response.data)
    .catch(error => error.response)
}
