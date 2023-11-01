export default class UsersApi {
    changePass = (formData, user_id) => axios.post(`/api/users/change-pass/${user_id}`, formData)
    .then(response => response)
    .catch(error => error.response)
}
