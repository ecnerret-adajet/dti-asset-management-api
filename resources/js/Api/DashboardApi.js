/**
 * Dashboard API Service
 * Handles all API requests for the enhanced dashboard
 */
export default class DashboardApi {
    /**
     * Get all dashboard data in one request (consolidated endpoint)
     * Recommended for better performance
     */
    getAllDashboardData = () => axios.get(`/api/dashboard/all`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch all dashboard data:', error);
            throw error.response;
        });

    /**
     * Summary Metrics
     */
    getDashboardSummary = () => axios.get(`/api/dashboard/summary`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch dashboard summary:', error);
            throw error.response;
        });

    getTotalInventoryValue = () => axios.get(`/api/dashboard/inventory-value`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch inventory value:', error);
            throw error.response;
        });

    getLowStockCount = () => axios.get(`/api/dashboard/low-stock-count`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch low stock count:', error);
            throw error.response;
        });

    getOutOfStockCount = () => axios.get(`/api/dashboard/out-of-stock-count`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch out of stock count:', error);
            throw error.response;
        });

    getOrdersToday = () => axios.get(`/api/dashboard/orders-today`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch today\'s orders:', error);
            throw error.response;
        });

    getPendingReceivings = () => axios.get(`/api/dashboard/pending-receivings`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch pending receivings:', error);
            throw error.response;
        });

    /**
     * Chart Data Endpoints
     */
    getStockDistribution = () => axios.get(`/api/dashboard/stock-distribution`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch stock distribution:', error);
            throw error.response;
        });

    getInventoryTrend = (days = 30) => axios.get(`/api/dashboard/inventory-trend`, {
            params: { days }
        })
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch inventory trend:', error);
            throw error.response;
        });

    getDailyOrdersSummary = (days = 7) => axios.get(`/api/dashboard/daily-orders`, {
            params: { days }
        })
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch daily orders summary:', error);
            throw error.response;
        });

    getDailyReceivingsSummary = (days = 7) => axios.get(`/api/dashboard/daily-receivings`, {
            params: { days }
        })
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch daily receivings summary:', error);
            throw error.response;
        });

    /**
     * Detailed Lists Endpoints
     */
    getLowStockAlerts = (limit = 10) => axios.get(`/api/dashboard/low-stock-alerts`, {
            params: { limit }
        })
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch low stock alerts:', error);
            throw error.response;
        });

    getRecentOrders = (limit = 5) => axios.get(`/api/dashboard/recent-orders`, {
            params: { limit }
        })
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch recent orders:', error);
            throw error.response;
        });

    getRecentReceivings = (limit = 5) => axios.get(`/api/dashboard/recent-receivings`, {
            params: { limit }
        })
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch recent receivings:', error);
            throw error.response;
        });

    /**
     * Enhanced Status Details Endpoints
     */
    getOrderStatusDetails = () => axios.get(`/api/dashboard/order-status-details`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch order status details:', error);
            throw error.response;
        });

    getReceivingStatusDetails = () => axios.get(`/api/dashboard/receiving-status-details`)
        .then(response => response.data)
        .catch(error => {
            console.error('Failed to fetch receiving status details:', error);
            throw error.response;
        });
}
