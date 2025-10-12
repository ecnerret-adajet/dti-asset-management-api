<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Order;
use App\Models\Receiving;
use App\Models\OrderStatus;
use App\Models\ReceivingStatus;
use Carbon\Carbon;

class ReportsApiController extends Controller
{
    // ============================================
    // LEGACY ENDPOINTS (Maintained for backward compatibility)
    // ============================================

    public function totalAssets()
    {
        return Asset::count();
    }

    public function totalSpending()
    {
        return Asset::sum('unit_price');
    }

    public function totalQuantitySold()
    {
        return Order::whereMonth('created_at', '=', now()->month)->count();
    }

    public function totalQuantityRequest()
    {
        return Receiving::whereMonth('created_at', '=', now()->month)->count();
    }

    // ============================================
    // NEW DASHBOARD ENDPOINTS
    // ============================================

    /**
     * Get comprehensive dashboard summary with all KPIs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardSummary()
    {
        try {
            // Calculate total inventory value from orders (asset_order pivot table)
            $inventoryValue = DB::table('asset_order')
                ->join('assets', 'asset_order.asset_id', '=', 'assets.id')
                ->whereNull('assets.deleted_at')
                ->sum(DB::raw('asset_order.qty * asset_order.unit_price'));

            // Count low stock items (using a threshold of 5 as default)
            // In production, this should come from assets.reorder_point field
            $lowStockCount = DB::table('asset_order')
                ->select('asset_id', DB::raw('SUM(qty) as total_qty'))
                ->groupBy('asset_id')
                ->havingRaw('SUM(qty) > 0 AND SUM(qty) < 10')
                ->count();

            // Count out of stock items
            $outOfStockCount = Asset::whereDoesntHave('orders')->count();

            // Orders created today
            $ordersToday = Order::whereDate('created_at', today())->count();

            // Pending receivings (assuming status_id 1 is pending)
            $pendingReceivings = Receiving::where('receiving_status_id', 1)
                ->orWhereNull('receiving_status_id')
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_assets' => Asset::count(),
                    'total_inventory_value' => $inventoryValue,
                    'total_inventory_value_formatted' => '₱' . number_format($inventoryValue, 2),
                    'low_stock_items' => $lowStockCount,
                    'out_of_stock_items' => $outOfStockCount,
                    'orders_today' => $ordersToday,
                    'pending_receivings' => $pendingReceivings,
                ],
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch dashboard summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get total inventory value
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalInventoryValue()
    {
        try {
            $inventoryValue = DB::table('asset_order')
                ->join('assets', 'asset_order.asset_id', '=', 'assets.id')
                ->whereNull('assets.deleted_at')
                ->sum(DB::raw('asset_order.qty * asset_order.unit_price'));

            return response()->json([
                'success' => true,
                'data' => [
                    'value' => $inventoryValue,
                    'formatted' => '₱' . number_format($inventoryValue, 2)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate inventory value',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get count of low stock items
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLowStockItemsCount()
    {
        try {
            $lowStockCount = DB::table('asset_order')
                ->select('asset_id', DB::raw('SUM(qty) as total_qty'))
                ->groupBy('asset_id')
                ->havingRaw('SUM(qty) > 0 AND SUM(qty) < 10')
                ->count();

            return response()->json([
                'success' => true,
                'data' => $lowStockCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to count low stock items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get count of out of stock items
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOutOfStockItemsCount()
    {
        try {
            $outOfStockCount = Asset::whereDoesntHave('orders')->count();

            return response()->json([
                'success' => true,
                'data' => $outOfStockCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to count out of stock items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get orders created today
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrdersToday()
    {
        try {
            $ordersToday = Order::whereDate('created_at', today())->count();
            $totalValueToday = Order::whereDate('created_at', today())->sum('total_cost');

            return response()->json([
                'success' => true,
                'data' => [
                    'count' => $ordersToday,
                    'total_value' => $totalValueToday,
                    'total_value_formatted' => '₱' . number_format($totalValueToday, 2)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch today\'s orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get count of pending receivings
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPendingReceivingsCount()
    {
        try {
            $pendingReceivings = Receiving::where('receiving_status_id', 1)
                ->orWhereNull('receiving_status_id')
                ->count();

            $oldestPending = Receiving::where('receiving_status_id', 1)
                ->orWhereNull('receiving_status_id')
                ->orderBy('created_at', 'asc')
                ->first();

            return response()->json([
                'success' => true,
                'data' => [
                    'count' => $pendingReceivings,
                    'oldest_date' => $oldestPending ? $oldestPending->created_at->format('Y-m-d') : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to count pending receivings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get stock level distribution for donut chart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStockDistribution()
    {
        try {
            // Get assets with their order quantities
            $assetsWithQty = DB::table('assets')
                ->leftJoin('asset_order', 'assets.id', '=', 'asset_order.asset_id')
                ->select('assets.id', DB::raw('COALESCE(SUM(asset_order.qty), 0) as total_qty'))
                ->whereNull('assets.deleted_at')
                ->groupBy('assets.id')
                ->get();

            $inStock = 0;
            $lowStock = 0;
            $outOfStock = 0;
            $overStock = 0;

            foreach ($assetsWithQty as $asset) {
                if ($asset->total_qty == 0) {
                    $outOfStock++;
                } elseif ($asset->total_qty < 10) {
                    $lowStock++;
                } elseif ($asset->total_qty > 50) {
                    $overStock++;
                } else {
                    $inStock++;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'labels' => ['In Stock', 'Low Stock', 'Out of Stock', 'Overstock'],
                    'values' => [$inStock, $lowStock, $outOfStock, $overStock],
                    'colors' => ['#1BC5BD', '#FFA800', '#F64E60', '#3699FF']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch stock distribution',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get inventory trend data for line chart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInventoryTrend(Request $request)
    {
        try {
            $days = $request->input('days', 30);
            $startDate = now()->subDays($days);

            $dates = [];
            $ordersData = [];
            $receivingsData = [];

            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $dates[] = $date->format('M d');

                $ordersCount = Order::whereDate('created_at', $date->format('Y-m-d'))->count();
                $receivingsCount = Receiving::whereDate('created_at', $date->format('Y-m-d'))->count();

                $ordersData[] = $ordersCount;
                $receivingsData[] = $receivingsCount;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'labels' => $dates,
                    'datasets' => [
                        [
                            'label' => 'Orders',
                            'data' => $ordersData,
                            'borderColor' => '#F64E60',
                            'backgroundColor' => 'rgba(246, 78, 96, 0.1)'
                        ],
                        [
                            'label' => 'Receivings',
                            'data' => $receivingsData,
                            'borderColor' => '#1BC5BD',
                            'backgroundColor' => 'rgba(27, 197, 189, 0.1)'
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch inventory trend',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get daily orders summary for bar chart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDailyOrdersSummary(Request $request)
    {
        try {
            $days = $request->input('days', 7);

            $labels = [];
            $counts = [];
            $values = [];

            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('D, M d');

                $dayOrders = Order::whereDate('created_at', $date->format('Y-m-d'));
                $counts[] = $dayOrders->count();
                $values[] = $dayOrders->sum('total_cost');
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'labels' => $labels,
                    'counts' => $counts,
                    'values' => $values,
                    'datasets' => [
                        [
                            'label' => 'Orders',
                            'data' => $counts,
                            'backgroundColor' => '#3699FF'
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch daily orders summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get daily receivings summary for bar chart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDailyReceivingsSummary(Request $request)
    {
        try {
            $days = $request->input('days', 7);

            $labels = [];
            $counts = [];
            $quantities = [];

            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('D, M d');

                $dayReceivings = Receiving::whereDate('created_at', $date->format('Y-m-d'));
                $counts[] = $dayReceivings->count();
                $quantities[] = $dayReceivings->sum('qty');
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'labels' => $labels,
                    'counts' => $counts,
                    'quantities' => $quantities,
                    'datasets' => [
                        [
                            'label' => 'Receivings',
                            'data' => $counts,
                            'backgroundColor' => '#1BC5BD'
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch daily receivings summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get low stock alerts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLowStockAlerts(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            $lowStockItems = DB::table('assets')
                ->leftJoin('asset_order', 'assets.id', '=', 'asset_order.asset_id')
                ->select(
                    'assets.id',
                    'assets.name',
                    'assets.part_number',
                    DB::raw('COALESCE(SUM(asset_order.qty), 0) as current_quantity'),
                    DB::raw('MAX(asset_order.created_at) as last_order_date')
                )
                ->whereNull('assets.deleted_at')
                ->groupBy('assets.id', 'assets.name', 'assets.part_number')
                ->havingRaw('current_quantity > 0 AND current_quantity < 10')
                ->orderBy('current_quantity', 'asc')
                ->limit($limit)
                ->get();

            $formattedItems = $lowStockItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'part_number' => $item->part_number,
                    'current_quantity' => (int) $item->current_quantity,
                    'reorder_point' => 10, // Default threshold
                    'last_order_date' => $item->last_order_date ? Carbon::parse($item->last_order_date)->format('Y-m-d') : null,
                    'status' => $item->current_quantity < 5 ? 'critical' : 'warning'
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedItems,
                'count' => $formattedItems->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch low stock alerts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent orders
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecentOrders(Request $request)
    {
        try {
            $limit = $request->input('limit', 5);

            $recentOrders = Order::with(['customer', 'orderStatus'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'order_reference' => $order->order_reference,
                        'customer_name' => $order->customer ? $order->customer->name : 'N/A',
                        'total_amount' => $order->total_cost,
                        'total_amount_formatted' => '₱' . number_format($order->total_cost, 2),
                        'status' => $order->orderStatus ? $order->orderStatus->name : 'N/A',
                        'status_id' => $order->order_status_id,
                        'date' => $order->created_at->format('Y-m-d H:i:s'),
                        'date_formatted' => $order->created_at->format('M d, Y')
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $recentOrders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch recent orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent receivings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecentReceivings(Request $request)
    {
        try {
            $limit = $request->input('limit', 5);

            $recentReceivings = Receiving::with(['asset', 'receivingStatus'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($receiving) {
                    return [
                        'id' => $receiving->id,
                        'reference_number' => $receiving->reference_number,
                        'asset_name' => $receiving->asset ? $receiving->asset->name : 'N/A',
                        'quantity' => $receiving->qty,
                        'status' => $receiving->receivingStatus ? $receiving->receivingStatus->name : 'N/A',
                        'status_id' => $receiving->receiving_status_id,
                        'date' => $receiving->created_at->format('Y-m-d H:i:s'),
                        'date_formatted' => $receiving->created_at->format('M d, Y')
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $recentReceivings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch recent receivings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order status details with totals
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderStatusDetails()
    {
        try {
            $statusDetails = OrderStatus::withCount('orders')
                ->with(['orders' => function ($query) {
                    $query->select('order_status_id', DB::raw('SUM(total_cost) as total_value'));
                    $query->groupBy('order_status_id');
                }])
                ->get()
                ->map(function ($status) {
                    $totalValue = $status->orders->sum('total_cost') ?? 0;

                    return [
                        'id' => $status->id,
                        'name' => $status->name,
                        'count' => $status->orders_count,
                        'total_value' => $totalValue,
                        'total_value_formatted' => '₱' . number_format($totalValue, 2),
                        'percentage' => 0 // Will be calculated on frontend
                    ];
                });

            $totalOrders = $statusDetails->sum('count');

            // Calculate percentages
            $statusDetails = $statusDetails->map(function ($item) use ($totalOrders) {
                $item['percentage'] = $totalOrders > 0 ? round(($item['count'] / $totalOrders) * 100, 1) : 0;
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $statusDetails,
                'total_orders' => $totalOrders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch order status details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get receiving status details with totals
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReceivingStatusDetails()
    {
        try {
            $statusDetails = ReceivingStatus::withCount('receivings')
                ->get()
                ->map(function ($status) {
                    $totalQty = Receiving::where('receiving_status_id', $status->id)->sum('qty');

                    return [
                        'id' => $status->id,
                        'name' => $status->name,
                        'count' => $status->receivings_count,
                        'total_quantity' => $totalQty,
                        'percentage' => 0 // Will be calculated below
                    ];
                });

            $totalReceivings = $statusDetails->sum('count');

            // Calculate percentages
            $statusDetails = $statusDetails->map(function ($item) use ($totalReceivings) {
                $item['percentage'] = $totalReceivings > 0 ? round(($item['count'] / $totalReceivings) * 100, 1) : 0;
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $statusDetails,
                'total_receivings' => $totalReceivings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch receiving status details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all dashboard data in one request (consolidated endpoint)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllDashboardData()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'summary' => $this->getDashboardSummary()->getData()->data,
                    'stock_distribution' => $this->getStockDistribution()->getData()->data,
                    'inventory_trend' => $this->getInventoryTrend(request())->getData()->data,
                    'daily_orders' => $this->getDailyOrdersSummary(request())->getData()->data,
                    'daily_receivings' => $this->getDailyReceivingsSummary(request())->getData()->data,
                    'low_stock_alerts' => $this->getLowStockAlerts(request())->getData()->data,
                    'recent_orders' => $this->getRecentOrders(request())->getData()->data,
                    'recent_receivings' => $this->getRecentReceivings(request())->getData()->data,
                    'order_status_details' => $this->getOrderStatusDetails()->getData()->data,
                    'receiving_status_details' => $this->getReceivingStatusDetails()->getData()->data,
                ],
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
