<script setup>
import { watch, reactive, onMounted, ref, computed } from "vue";
import BasicLayout from "../Layouts/BasicLayout.vue";
import SummaryCard from "../Components/Dashboard/SummaryCard.vue";
import LineChart from "../Components/Dashboard/LineChart.vue";
import DoughnutChart from "../Components/Dashboard/DoughnutChart.vue";
import BarChart from "../Components/Dashboard/BarChart.vue";

// API Services
import DashboardApi from "../Api/DashboardApi";
import OrdersApi from "../Api/OrdersApi";
import ReceivingApi from "../Api/ReceivingApi";

const dashboardService = new DashboardApi();
const ordersService = new OrdersApi();
const receivingService = new ReceivingApi();

// State
const loading = ref(true);
const errors = ref(null);
const lastUpdated = ref(null);

// Summary metrics
const summary = ref({
  total_assets: 0,
  total_inventory_value: 0,
  total_inventory_value_formatted: "₱0.00",
  low_stock_items: 0,
  out_of_stock_items: 0,
  orders_today: 0,
  pending_receivings: 0,
});

// Chart data
const stockDistribution = ref(null);
const inventoryTrend = ref(null);
const dailyOrders = ref(null);
const dailyReceivings = ref(null);

// Computed chart data with proper formatting
const stockDistributionData = computed(() => {
  if (!stockDistribution.value) return null;
  return {
    labels: stockDistribution.value.labels || [],
    datasets: [{
      data: stockDistribution.value.values || [],
      backgroundColor: stockDistribution.value.colors || [],
    }]
  };
});

const dailyOrdersData = computed(() => {
  if (!dailyOrders.value) return null;
  return {
    labels: dailyOrders.value.labels || [],
    datasets: dailyOrders.value.datasets || []
  };
});

const dailyReceivingsData = computed(() => {
  if (!dailyReceivings.value) return null;
  return {
    labels: dailyReceivings.value.labels || [],
    datasets: dailyReceivings.value.datasets || []
  };
});

// Table data
const lowStockAlerts = ref([]);
const recentOrders = ref([]);
const recentReceivings = ref([]);
const orderStatuses = ref([]);
const receivingStatuses = ref([]);

// SVG Icons
const packageIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect x="0" y="0" width="24" height="24"></rect>
    <path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z" fill="#000000" opacity="0.3"></path>
  </g>
</svg>`;

const moneyIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect x="0" y="0" width="24" height="24"></rect>
    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
    <path d="M12,16 C14.209139,16 16,14.209139 16,12 C16,9.790861 14.209139,8 12,8 C9.790861,8 8,9.790861 8,12 C8,14.209139 9.790861,16 12,16 Z" fill="#000000"></path>
  </g>
</svg>`;

const warningIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect x="0" y="0" width="24" height="24"></rect>
    <path d="M12,2 L2,19 L22,19 L12,2 Z M12,8 L12,14 L12,14 Z M12,16 L12,18 L12,18 Z" fill="#000000"></path>
  </g>
</svg>`;

const alertIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect x="0" y="0" width="24" height="24"></rect>
    <circle fill="#000000" cx="12" cy="12" r="9"></circle>
    <text font-family="sans-serif" font-size="14" font-weight="bold" fill="#FFF">
      <tspan x="9" y="16">!</tspan>
    </text>
  </g>
</svg>`;

const cartIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect x="0" y="0" width="24" height="24"></rect>
    <path d="M7,3 L17,3 C17.55,3 18,3.45 18,4 L18,20 C18,20.55 17.55,21 17,21 L7,21 C6.45,21 6,20.55 6,20 L6,4 C6,3.45 6.45,3 7,3 Z" fill="#000000" opacity="0.3"></path>
  </g>
</svg>`;

const inboxIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect x="0" y="0" width="24" height="24"></rect>
    <path d="M5,9 L19,9 L19,17 L5,17 L5,9 Z M5,5 L19,5 L19,7 L5,7 L5,5 Z" fill="#000000"></path>
  </g>
</svg>`;

// Chart options
const lineChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      position: "top",
    },
    tooltip: {
      mode: "index",
      intersect: false,
    },
  },
  scales: {
    y: {
      beginAtZero: true,
    },
  },
};

const doughnutChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      position: "bottom",
    },
  },
};

const barChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false,
    },
  },
  scales: {
    y: {
      beginAtZero: true,
    },
  },
};

// Fetch all dashboard data
const fetchDashboardData = async () => {
  loading.value = true;
  errors.value = null;
  try {
    // Use consolidated endpoint for better performance
    const response = await dashboardService.getAllDashboardData();

    console.log('Dashboard API Response:', response);

    if (response.success) {
      summary.value = response.data.summary;
      stockDistribution.value = response.data.stock_distribution;
      inventoryTrend.value = response.data.inventory_trend;
      dailyOrders.value = response.data.daily_orders;
      dailyReceivings.value = response.data.daily_receivings;
      lowStockAlerts.value = response.data.low_stock_alerts || [];
      recentOrders.value = response.data.recent_orders || [];
      recentReceivings.value = response.data.recent_receivings || [];
      orderStatuses.value = response.data.order_status_details || [];
      receivingStatuses.value = response.data.receiving_status_details || [];
      lastUpdated.value = new Date();

      console.log('Stock Distribution:', stockDistribution.value);
      console.log('Daily Orders:', dailyOrders.value);
      console.log('Daily Receivings:', dailyReceivings.value);
    } else {
      errors.value = 'Failed to load dashboard data';
      console.error('API returned success: false');
    }
  } catch (error) {
    errors.value = error;
    console.error("Failed to fetch dashboard data:", error);
    console.error("Error details:", error.response?.data || error.message);
  } finally {
    loading.value = false;
  }
};

// Currency formatter
const currencyFormatter = (amount) => {
  const currencyAmount = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "PHP",
  });
  return currencyAmount.format(amount);
};

// Format date
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
};

// Get status badge class
const getStatusBadgeClass = (status) => {
  const statusLower = status?.toLowerCase() || "";
  if (statusLower.includes("pending")) return "label-warning";
  if (statusLower.includes("completed") || statusLower.includes("delivered"))
    return "label-success";
  if (statusLower.includes("cancelled")) return "label-danger";
  return "label-info";
};

onMounted(() => {
  fetchDashboardData();

  // Auto-refresh every 5 minutes
  setInterval(() => {
    fetchDashboardData();
  }, 300000);
});
</script>

<template>
  <BasicLayout>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!-- Subheader -->
      <div
        class="subheader py-2 py-lg-12 subheader-transparent"
        id="kt_subheader"
      >
        <div
          class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
        >
          <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex flex-column">
              <h2 class="text-white font-weight-bold my-2 mr-5">
                Inventory Dashboard
              </h2>
              <div class="d-flex align-items-center font-weight-bold my-2">
                <a href="#" class="opacity-75 hover-opacity-100">
                  <i class="flaticon2-shelter text-white icon-1x"></i>
                </a>
                <span
                  class="label label-dot label-sm bg-white opacity-75 mx-3"
                ></span>
                <a
                  href=""
                  class="text-white text-hover-white opacity-75 hover-opacity-100"
                  >Dashboard</a
                >
                <span
                  class="label label-dot label-sm bg-white opacity-75 mx-3"
                ></span>
                <span class="text-white opacity-75" v-if="lastUpdated">
                  Updated {{ lastUpdated.toLocaleTimeString() }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="d-flex flex-column-fluid">
        <div class="container">
          <!-- Error State -->
          <div v-if="errors" class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Error Loading Dashboard</h4>
            <p>{{ errors.message || errors }}</p>
            <button @click="fetchDashboardData" class="btn btn-sm btn-danger">
              Retry
            </button>
          </div>

          <!-- Loading State -->
          <div v-else-if="loading && !summary.total_assets" class="text-center py-10">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>

          <!-- Dashboard Content -->
          <div v-else>
            <!-- Row 1: Summary Cards -->
            <div class="row">
              <SummaryCard
                title="Total Assets"
                :value="summary.total_assets"
                :icon="packageIcon"
                color="info"
                subtitle="All inventory items"
              />

              <SummaryCard
                title="Inventory Value"
                :value="summary.total_inventory_value_formatted"
                :icon="moneyIcon"
                color="success"
                :colored="true"
                subtitle="Total stock value"
              />

              <SummaryCard
                title="Low Stock Items"
                :value="summary.low_stock_items"
                :icon="warningIcon"
                color="warning"
                :colored="true"
                subtitle="Need attention"
              />

              <SummaryCard
                title="Out of Stock"
                :value="summary.out_of_stock_items"
                :icon="alertIcon"
                color="danger"
                :colored="true"
                subtitle="Requires restock"
              />

              <SummaryCard
                title="Orders Today"
                :value="summary.orders_today"
                :icon="cartIcon"
                color="info"
                subtitle="Today's orders"
              />

              <SummaryCard
                title="Pending Requests"
                :value="summary.pending_receivings"
                :icon="inboxIcon"
                color="dark"
                :colored="true"
                subtitle="Awaiting processing"
              />
            </div>

            <!-- Row 2: Charts -->
            <div class="row mt-5">
              <!-- Inventory Trend Chart -->
              <div class="col-xl-6">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Inventory Trend (30 Days)</h3>
                  </div>
                  <div class="card-body" style="height: 300px">
                    <LineChart
                      v-if="inventoryTrend"
                      :data="inventoryTrend"
                      :options="lineChartOptions"
                    />
                  </div>
                </div>
              </div>

              <!-- Stock Distribution Chart -->
              <div class="col-xl-6">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Stock Level Distribution</h3>
                  </div>
                  <div class="card-body" style="height: 300px">
                    <DoughnutChart
                      v-if="stockDistributionData"
                      :data="stockDistributionData"
                      :options="doughnutChartOptions"
                    />
                    <div v-else class="text-center text-muted py-5">
                      <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Row 3: Bar Charts -->
            <div class="row">
              <!-- Daily Orders -->
              <div class="col-xl-6">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Daily Orders (Last 7 Days)</h3>
                  </div>
                  <div class="card-body" style="height: 250px">
                    <BarChart
                      v-if="dailyOrdersData"
                      :data="dailyOrdersData"
                      :options="barChartOptions"
                    />
                    <div v-else class="text-center text-muted py-5">
                      <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Daily Receivings -->
              <div class="col-xl-6">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Daily Receivings (Last 7 Days)</h3>
                  </div>
                  <div class="card-body" style="height: 250px">
                    <BarChart
                      v-if="dailyReceivingsData"
                      :data="dailyReceivingsData"
                      :options="barChartOptions"
                    />
                    <div v-else class="text-center text-muted py-5">
                      <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Row 4: Tables -->
            <div class="row">
              <!-- Low Stock Alerts -->
              <div class="col-xl-4">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title text-danger">
                      <i class="fas fa-exclamation-triangle mr-2"></i>Low Stock
                      Alerts
                    </h3>
                  </div>
                  <div class="card-body pt-0">
                    <div class="table-responsive">
                      <table class="table table-borderless table-vertical-center">
                        <thead>
                          <tr>
                            <th class="p-0" style="width: 50%">Asset</th>
                            <th class="p-0 text-center">Qty</th>
                            <th class="p-0 text-center">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="item in lowStockAlerts"
                            :key="item.id"
                            class="border-bottom"
                          >
                            <td class="pl-0 py-4">
                              <div class="font-weight-bold">{{ item.name }}</div>
                              <div class="text-muted font-size-sm">
                                {{ item.part_number }}
                              </div>
                            </td>
                            <td class="text-center">
                              <span
                                :class="[
                                  'label label-lg label-inline',
                                  item.status === 'critical'
                                    ? 'label-danger'
                                    : 'label-warning',
                                ]"
                              >
                                {{ item.current_quantity }}
                              </span>
                            </td>
                            <td class="text-center">
                              <span
                                :class="[
                                  'label label-dot mr-2',
                                  item.status === 'critical'
                                    ? 'label-danger'
                                    : 'label-warning',
                                ]"
                              ></span>
                            </td>
                          </tr>
                          <tr v-if="lowStockAlerts.length === 0">
                            <td colspan="3" class="text-center text-muted py-4">
                              No low stock items
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Recent Orders -->
              <div class="col-xl-4">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Recent Orders</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div class="table-responsive">
                      <table class="table table-borderless table-vertical-center">
                        <tbody>
                          <tr
                            v-for="order in recentOrders"
                            :key="order.id"
                            class="border-bottom"
                          >
                            <td class="pl-0 py-4">
                              <div class="font-weight-bold">
                                {{ order.order_reference }}
                              </div>
                              <div class="text-muted font-size-sm">
                                {{ order.customer_name }}
                              </div>
                            </td>
                            <td class="text-right">
                              <div class="font-weight-bold">
                                {{ order.total_amount_formatted }}
                              </div>
                              <span
                                :class="[
                                  'label label-inline label-sm',
                                  getStatusBadgeClass(order.status),
                                ]"
                              >
                                {{ order.status }}
                              </span>
                            </td>
                          </tr>
                          <tr v-if="recentOrders.length === 0">
                            <td colspan="2" class="text-center text-muted py-4">
                              No recent orders
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Recent Receivings -->
              <div class="col-xl-4">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Recent Receivings</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div class="table-responsive">
                      <table class="table table-borderless table-vertical-center">
                        <tbody>
                          <tr
                            v-for="receiving in recentReceivings"
                            :key="receiving.id"
                            class="border-bottom"
                          >
                            <td class="pl-0 py-4">
                              <div class="font-weight-bold">
                                {{ receiving.asset_name }}
                              </div>
                              <div class="text-muted font-size-sm">
                                Ref: {{ receiving.reference_number }}
                              </div>
                            </td>
                            <td class="text-right">
                              <div class="font-weight-bold">
                                Qty: {{ receiving.quantity }}
                              </div>
                              <span
                                :class="[
                                  'label label-inline label-sm',
                                  getStatusBadgeClass(receiving.status),
                                ]"
                              >
                                {{ receiving.status }}
                              </span>
                            </td>
                          </tr>
                          <tr v-if="recentReceivings.length === 0">
                            <td colspan="2" class="text-center text-muted py-4">
                              No recent receivings
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Row 5: Status Breakdown -->
            <div class="row">
              <!-- Order Status -->
              <div class="col-xl-6">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Order Status Summary</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div
                      v-for="status in orderStatuses"
                      :key="status.id"
                      class="d-flex align-items-center mb-7"
                    >
                      <div class="d-flex flex-column flex-grow-1 mr-2">
                        <a
                          href="#"
                          class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1"
                        >
                          {{ status.name }}
                        </a>
                        <span class="text-muted font-weight-bold">
                          {{ status.total_value_formatted }}
                        </span>
                      </div>
                      <span
                        class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder"
                      >
                        {{ status.count }} ({{ status.percentage }}%)
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Receiving Status -->
              <div class="col-xl-6">
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <h3 class="card-title">Receiving Status Summary</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div
                      v-for="status in receivingStatuses"
                      :key="status.id"
                      class="d-flex align-items-center mb-7"
                    >
                      <div class="d-flex flex-column flex-grow-1 mr-2">
                        <a
                          href="#"
                          class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1"
                        >
                          {{ status.name }}
                        </a>
                        <span class="text-muted font-weight-bold">
                          Total Qty: {{ status.total_quantity }}
                        </span>
                      </div>
                      <span
                        class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder"
                      >
                        {{ status.count }} ({{ status.percentage }}%)
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BasicLayout>
</template>
