export default class NotesApi {
    list = (asset_id) => axios.get(`/api/notes/${asset_id}`)
        .then(response => response.data)
        .catch(error => error.response);
    store = (formData) => axios.post(`/api/notes`, formData)
        .then(response => response)
        .catch(error => error.response);
    delete = (note_id) => axios.delete(`/api/notes/${note_id}`)
        .then(response => response)
        .catch(error => error.response)
}
