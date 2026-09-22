<?php

namespace App\Exports;

use App\Models\ApiLogModel;
use App\Models\PreIpoModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PreIpoDeviceExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        // Define the mapping for device types
        $devices = [
            'android' => 'Android', 
            'ios' => 'iOS', 
            'desktop' => 'Desktop / Web', 
            'macos' => 'macOS'
        ];
        
        $data = [];

        foreach ($devices as $key => $label) {
            // Step 1: Query API logs for this device
            $loginsQuery = ApiLogModel::where('devicetype', $key)->where('usertype', 'investor');
            $totalLogins = $loginsQuery->count();
            
            // Step 2: Get unique investor IDs
            $userIds = $loginsQuery->whereNotNull('userid')
                ->where('userid', '!=', '0')
                ->distinct('userid')
                ->pluck('userid')
                ->toArray();
                
            $totalInvestors = count($userIds);
            
            // Step 3: Find valid Pre-IPO investments for these users (matching dashboard logic)
            $preIpoQuery = PreIpoModel::query()
                ->whereIn('investor_id', $userIds)
                ->where('status', '>=', 2)
                ->where('is_valid', 1)
                ->whereHas('investor', fn($q) => $q->where('is_demo', '0'));
            
            $totalOrders = $preIpoQuery->count();
            $totalAmount = $preIpoQuery->sum('investment_amount');
            
            $data[] = [
                'device' => $label,
                'total_logins' => $totalLogins,
                'total_investors' => $totalInvestors,
                'total_orders' => $totalOrders,
                'total_amount' => $totalAmount
            ];
        }
        
        return collect($data);
    }
    
    public function headings(): array
    {
        return [
            'Device Platform',
            'Total Logins',
            'Total Unique Investors',
            'Total Valid Pre-IPO Orders',
            'Total Pre-IPO Amount (INR)'
        ];
    }
}
