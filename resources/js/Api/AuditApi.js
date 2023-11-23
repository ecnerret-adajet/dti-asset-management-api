export default class AuditApi {
    list = () => axios.get(`/api/audits-assets`)
    .then(response => response.data)
    .catch(error => error.response)
}
