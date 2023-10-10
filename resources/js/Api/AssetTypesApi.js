export default class AssetTypesApi {
    list = () => axios.get(`/api/asset-types`)
    .then(response => response.data)
    .catch(error => error.response)
}
