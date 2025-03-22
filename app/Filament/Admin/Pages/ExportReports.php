<?php

namespace App\Filament\Admin\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DigitalProduct;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use League\Csv\CannotInsertRecord;
use Illuminate\Support\Str;

class ExportReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static string $view = 'filament.admin.pages.export-reports';
    protected static ?string $navigationLabel = 'Ekspor Laporan';
    protected static ?string $title = 'Ekspor Laporan Keuangan';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?int $navigationSort = 2;
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill([
            'report_type' => 'sales',
            'date_range' => 'this_month',
            'start_date' => null,
            'end_date' => null,
            'include_product_details' => true,
            'include_customer_data' => false,
            'file_format' => 'csv',
        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Pengaturan Laporan')
                    ->description('Konfigurasi laporan yang ingin Anda ekspor')
                    ->schema([
                        Radio::make('report_type')
                            ->label('Jenis Laporan')
                            ->options([
                                'sales' => 'Laporan Penjualan',
                                'products' => 'Laporan Produk',
                                'category' => 'Laporan Kategori',
                                'licenses' => 'Laporan Lisensi',
                            ])
                            ->default('sales')
                            ->required(),
                            
                        Radio::make('date_range')
                            ->label('Rentang Waktu')
                            ->options([
                                'today' => 'Hari ini',
                                'yesterday' => 'Kemarin',
                                'this_week' => 'Minggu ini',
                                'last_week' => 'Minggu lalu',
                                'this_month' => 'Bulan ini',
                                'last_month' => 'Bulan lalu',
                                'this_year' => 'Tahun ini',
                                'custom' => 'Kustom...',
                            ])
                            ->default('this_month')
                            ->live(),
                            
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->visible(fn (callable $get) => $get('date_range') === 'custom')
                            ->required(fn (callable $get) => $get('date_range') === 'custom')
                            ->before('end_date'),
                            
                        DatePicker::make('end_date')
                            ->label('Tanggal Akhir')
                            ->visible(fn (callable $get) => $get('date_range') === 'custom')
                            ->required(fn (callable $get) => $get('date_range') === 'custom')
                            ->after('start_date')
                            ->before(fn () => now()->addDay()),
                            
                        Toggle::make('include_product_details')
                            ->label('Sertakan Detail Produk')
                            ->default(true)
                            ->visible(fn (callable $get) => in_array($get('report_type'), ['sales', 'products'])),
                            
                        Toggle::make('include_customer_data')
                            ->label('Sertakan Data Pelanggan')
                            ->default(false)
                            ->visible(fn (callable $get) => in_array($get('report_type'), ['sales', 'licenses'])),
                            
                        Select::make('file_format')
                            ->label('Format File')
                            ->options([
                                'csv' => 'CSV (.csv)',
                                'excel' => 'Excel (.xlsx)',
                            ])
                            ->default('csv')
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }
    
    public function exportReport(): void
    {
        $this->validate();
        
        try {
            $dateRange = $this->getDateRange();
            $startDate = $dateRange['start'];
            $endDate = $dateRange['end'];
            
            $reportType = $this->data['report_type'];
            $includeProductDetails = $this->data['include_product_details'] ?? false;
            $includeCustomerData = $this->data['include_customer_data'] ?? false;
            $fileFormat = $this->data['file_format'];
            
            // Get data based on report type
            $reportData = $this->getReportData(
                $reportType, 
                $startDate, 
                $endDate, 
                $includeProductDetails,
                $includeCustomerData
            );
            
            if (empty($reportData)) {
                Notification::make()
                    ->title('Tidak ada data')
                    ->body('Tidak ada data yang tersedia untuk kriteria yang dipilih')
                    ->warning()
                    ->send();
                return;
            }
            
            // Export data to selected format
            $exportFunction = $fileFormat === 'csv' ? 'exportToCsv' : 'exportToExcel';
            $downloadUrl = $this->$exportFunction($reportData, $reportType, $startDate, $endDate);
            
            // Notify success
            Notification::make()
                ->title('Ekspor berhasil')
                ->body('File laporan Anda siap untuk diunduh')
                ->success()
                ->actions([
                    \Filament\Notifications\Actions\Action::make('download')
                        ->label('Unduh')
                        ->url($downloadUrl)
                        ->openUrlInNewTab(),
                ])
                ->send();
                
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal mengekspor data')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    private function getDateRange(): array
    {
        $dateRange = $this->data['date_range'];
        
        switch ($dateRange) {
            case 'today':
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::today()->endOfDay(),
                ];
            case 'yesterday':
                return [
                    'start' => Carbon::yesterday(),
                    'end' => Carbon::yesterday()->endOfDay(),
                ];
            case 'this_week':
                return [
                    'start' => Carbon::now()->startOfWeek(),
                    'end' => Carbon::now()->endOfWeek(),
                ];
            case 'last_week':
                return [
                    'start' => Carbon::now()->subWeek()->startOfWeek(),
                    'end' => Carbon::now()->subWeek()->endOfWeek(),
                ];
            case 'this_month':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth(),
                ];
            case 'last_month':
                return [
                    'start' => Carbon::now()->subMonth()->startOfMonth(),
                    'end' => Carbon::now()->subMonth()->endOfMonth(),
                ];
            case 'this_year':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now()->endOfYear(),
                ];
            case 'custom':
                return [
                    'start' => Carbon::parse($this->data['start_date']),
                    'end' => Carbon::parse($this->data['end_date'])->endOfDay(),
                ];
            default:
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth(),
                ];
        }
    }
    
    private function getReportData(
        string $reportType, 
        Carbon $startDate, 
        Carbon $endDate, 
        bool $includeProductDetails = false,
        bool $includeCustomerData = false
    ): array {
        $data = [];
        
        switch ($reportType) {
            case 'sales':
                $orders = Order::whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 'completed')
                    ->with(['items', 'user'])
                    ->get();
                    
                // Prepare sales report data
                foreach ($orders as $order) {
                    $orderData = [
                        'ID Pesanan' => $order->id,
                        'Nomor Pesanan' => $order->order_number,
                        'Tanggal' => $order->created_at->format('Y-m-d H:i:s'),
                        'Total' => $order->total,
                        'Status Pembayaran' => $order->payment_status,
                    ];
                    
                    if ($includeCustomerData) {
                        $orderData['Nama Pelanggan'] = $order->user->name;
                        $orderData['Email Pelanggan'] = $order->user->email;
                    }
                    
                    if ($includeProductDetails) {
                        // For each order item
                        foreach ($order->items as $index => $item) {
                            $orderData['Produk ' . ($index + 1)] = $item->orderable ? $item->orderable->name : 'Produk Dihapus';
                            $orderData['Harga ' . ($index + 1)] = $item->price;
                        }
                    }
                    
                    $data[] = $orderData;
                }
                break;
                
            case 'products':
                // Get products with their sales count
                $products = DigitalProduct::select('digital_products.*')
                    ->selectRaw('COUNT(order_items.id) as sales_count')
                    ->selectRaw('SUM(order_items.total) as revenue')
                    ->leftJoin('order_items', function($join) {
                        $join->on('digital_products.id', '=', 'order_items.orderable_id')
                            ->where('order_items.orderable_type', '=', DigitalProduct::class);
                    })
                    ->leftJoin('orders', function($join) use ($startDate, $endDate) {
                        $join->on('order_items.order_id', '=', 'orders.id')
                            ->where('orders.status', 'completed')
                            ->whereBetween('orders.created_at', [$startDate, $endDate]);
                    })
                    ->with('category')
                    ->groupBy('digital_products.id')
                    ->get();
                    
                // Prepare product report data
                foreach ($products as $product) {
                    $productData = [
                        'ID Produk' => $product->id,
                        'Nama Produk' => $product->name,
                        'Kategori' => $product->category ? $product->category->name : 'Tanpa Kategori',
                        'Jumlah Penjualan' => $product->sales_count ?? 0,
                        'Pendapatan' => $product->revenue ?? 0,
                        'Harga' => $product->price,
                    ];
                    
                    if ($includeProductDetails) {
                        $productData['Deskripsi'] = Str::limit(strip_tags($product->description), 100);
                        $productData['Status'] = $product->is_active ? 'Aktif' : 'Tidak Aktif';
                        $productData['Tanggal Dibuat'] = $product->created_at->format('Y-m-d');
                    }
                    
                    $data[] = $productData;
                }
                break;
                
            case 'category':
                // Get categories with sales data
                $categories = \App\Models\Category::select('categories.*')
                    ->selectRaw('COUNT(DISTINCT orders.id) as order_count')
                    ->selectRaw('COUNT(order_items.id) as product_sold')
                    ->selectRaw('SUM(order_items.total) as revenue')
                    ->leftJoin('digital_products', 'categories.id', '=', 'digital_products.category_id')
                    ->leftJoin('order_items', function($join) {
                        $join->on('digital_products.id', '=', 'order_items.orderable_id')
                            ->where('order_items.orderable_type', '=', DigitalProduct::class);
                    })
                    ->leftJoin('orders', function($join) use ($startDate, $endDate) {
                        $join->on('order_items.order_id', '=', 'orders.id')
                            ->where('orders.status', 'completed')
                            ->whereBetween('orders.created_at', [$startDate, $endDate]);
                    })
                    ->groupBy('categories.id')
                    ->get();
                    
                // Prepare category report data
                foreach ($categories as $category) {
                    $data[] = [
                        'ID Kategori' => $category->id,
                        'Nama Kategori' => $category->name,
                        'Jumlah Pesanan' => $category->order_count ?? 0,
                        'Produk Terjual' => $category->product_sold ?? 0,
                        'Pendapatan' => $category->revenue ?? 0,
                    ];
                }
                break;
                
            case 'licenses':
                // Get license data
                $licenses = \App\Models\DigitalProductLicense::whereBetween('created_at', [$startDate, $endDate])
                    ->with(['product', 'user', 'order'])
                    ->get();
                    
                // Prepare license report data
                foreach ($licenses as $license) {
                    $licenseData = [
                        'ID Lisensi' => $license->id,
                        'Kode Lisensi' => $license->license_code,
                        'Produk' => $license->product ? $license->product->name : 'Produk Dihapus',
                        'Status' => $license->status,
                        'Tanggal Pembuatan' => $license->created_at->format('Y-m-d'),
                        'Tanggal Aktivasi' => $license->activated_at ? Carbon::parse($license->activated_at)->format('Y-m-d') : 'Belum Diaktivasi',
                    ];
                    
                    if ($includeCustomerData) {
                        $licenseData['Nama Pelanggan'] = $license->user ? $license->user->name : 'Pengguna Dihapus';
                        $licenseData['Email Pelanggan'] = $license->user ? $license->user->email : '-';
                    }
                    
                    $data[] = $licenseData;
                }
                break;
        }
        
        return $data;
    }
    
    private function exportToCsv(array $data, string $reportType, Carbon $startDate, Carbon $endDate): string
    {
        $csv = Writer::createFromString('');
        
        // Add headers
        if (!empty($data)) {
            $csv->insertOne(array_keys($data[0]));
        }
        
        // Add rows
        foreach ($data as $row) {
            $csv->insertOne($row);
        }
        
        // Save to storage
        $filename = $this->getFilename($reportType, $startDate, $endDate, 'csv');
        Storage::disk('public')->put('reports/' . $filename, $csv->toString());
        
        return Storage::disk('public')->url('reports/' . $filename);
    }
    
    private function exportToExcel(array $data, string $reportType, Carbon $startDate, Carbon $endDate): string
    {
        // Create new Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Add title
        $sheet->setCellValue('A1', $this->getReportTitle($reportType, $startDate, $endDate));
        $sheet->mergeCells('A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($data[0])) . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        
        // Add date range
        $sheet->setCellValue('A2', 'Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'));
        $sheet->mergeCells('A2:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($data[0])) . '2');
        
        // Add headers (row 4)
        $column = 1;
        foreach (array_keys($data[0]) as $header) {
            $sheet->setCellValue(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column - 1) . '4', 
                $header
            );
            $column++;
        }
        $sheet->getStyle('A4:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($data[0])) . '4')
            ->getFont()->setBold(true);
        
        // Add data rows (starting from row 5)
        $row = 5;
        foreach ($data as $dataRow) {
            $column = 1;
            foreach ($dataRow as $value) {
                $sheet->setCellValue(
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column - 1) . $row, 
                    $value
                );
                $column++;
            }
            $row++;
        }
        
        // Auto size columns
        foreach (range('A', \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($data[0]) - 1)) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Save to storage
        $filename = $this->getFilename($reportType, $startDate, $endDate, 'xlsx');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $path = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        
        $writer->save($path);
        
        return Storage::disk('public')->url('reports/' . $filename);
    }
    
    private function getFilename(string $reportType, Carbon $startDate, Carbon $endDate, string $extension): string
    {
        $reportTypeMap = [
            'sales' => 'penjualan',
            'products' => 'produk',
            'category' => 'kategori',
            'licenses' => 'lisensi',
        ];
        
        return sprintf(
            'laporan_%s_%s_%s.%s',
            $reportTypeMap[$reportType],
            $startDate->format('Ymd'),
            $endDate->format('Ymd'),
            $extension
        );
    }
    
    private function getReportTitle(string $reportType, Carbon $startDate, Carbon $endDate): string
    {
        $titleMap = [
            'sales' => 'Laporan Penjualan',
            'products' => 'Laporan Produk',
            'category' => 'Laporan Kategori',
            'licenses' => 'Laporan Lisensi',
        ];
        
        return $titleMap[$reportType] . ' (' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y') . ')';
    }
    
    protected function getFormActions(): array
    {
        return [
            FormAction::make('export')
                ->label('Ekspor Data')
                ->color('primary')
                ->icon('heroicon-m-arrow-down-tray')
                ->action('exportReport'),
        ];
    }
    
    protected function getHeaderActions(): array
    {
        return [];
    }
} 