export default class ReportsApi {
    totalAssets = () => axios.get(`/api/total-assets`)
        .then(response => response.data)
        .catch(error => error.response);

    totalSpending = () => axios.get(`/api/total-spending`)
        .then(response => response.data)
        .catch(error => error.response);

    totalSold = () => axios.get(`/api/total-sold`)
        .then(response => response.data)
        .catch(error => error.response);

    totalRequests = () => axios.get(`/api/total-requests`)
        .then(response => response.data)
        .catch(error => error.response);
}
