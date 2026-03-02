<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CorteDiarioController extends Controller
{
    public function generarCorteDiario(Request $request)
    {
        $userId = Auth::id();
        $now = now();
        $startOfDay = $now->copy()->startOfDay();
        $endOfDay = $now->copy()->endOfDay();

        // 1. Totales Principales (Incluyo todo lo que no esté cancelado para coincidir con el Dashboard)
        $totalSales = (float) Sale::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('estado', '!=', 'cancelado')
            ->sum('total');

        $transactionCount = Sale::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('estado', '!=', 'cancelado')
            ->count();

        $voidedSales = Sale::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('estado', 'cancelado')
            ->count();

        // 2. Desglose por Método de Pago (Coincidiendo con DashboardStatsController)
        $paymentBreakdown = DB::table('sale_payments')
            ->join('sales', 'sale_payments.sale_id', '=', 'sales.id')
            ->join('payment_methods', 'sale_payments.payment_method_id', '=', 'payment_methods.id')
            ->where('sales.user_id', $userId)
            ->whereBetween('sales.created_at', [$startOfDay, $endOfDay])
            ->where('sales.estado', '!=', 'cancelado')
            ->select('payment_methods.name', DB::raw('SUM(sale_payments.amount) as total'))
            ->groupBy('payment_methods.name')
            ->get();

        // 3. Métricas de Performance
        $ticketAverage = $transactionCount > 0 ? ($totalSales / $transactionCount) : 0;

        $firstOrder = Sale::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'asc')
            ->first();

        $lastOrder = Sale::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'desc')
            ->first();

        // 4. Ventas Recientes
        $recentSales = Sale::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->latest()
            ->take(10)
            ->with('client')
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'total' => number_format((float) $s->total, 2),
                'hour' => $s->created_at->format('H:i'),
                'client' => $s->client->name ?? 'Venta Rápida',
                'estado' => $s->estado
            ]);

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $now->format('d/m/Y'),
                'seller' => Auth::user()->name,
                'total_sales' => number_format((float) $totalSales, 2),
                'total_transactions' => $transactionCount,
                'total_income' => number_format((float) $totalSales, 2),
                'voided_sales' => $voidedSales,
                'payment_breakdown' => $paymentBreakdown,
                'ticket_average' => number_format((float) $ticketAverage, 2),
                'first_order_time' => $firstOrder ? $firstOrder->created_at->format('H:i') : 'N/A',
                'last_order_time' => $lastOrder ? $lastOrder->created_at->format('H:i') : 'N/A',
                'recent_sales' => $recentSales
            ]
        ]);
    }
}
