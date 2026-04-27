<?php

namespace App\Filament\Pages;

use App\Models\PaymentMethod;
use App\Models\Outlet;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;

class PosNew extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = null;
    protected static ?string $title = 'POS';
    protected static ?string $slug = 'pos/create';
    protected static string $view = 'filament.pages.pos-new';

    public $ptype = '0';
    public $barcode = '';
    public $cart = [];
    public $payment_method_id;
    public $cash_received = 0;
    public $discount_percent = 0;
    public $vat_percent = 0;
    public $otype = '0';
    public $invoice_no = '';
    public $outlet_id;
    public $mobile = '';
    public $selectedCustomer = null;
    public $customer_name = '';
    public $customer_email = '';
    public $customer_address = '';
    public $last_invoice_no = '';
    public $last_sale_id = '';
    public $receipt_total = 0;
    public $isProcessing = false;
    public $showReceipt = false;

    protected $rules = [
        'ptype' => 'required',
        'barcode' => 'nullable|string',
        'payment_method_id' => 'required',
        'cash_received' => 'nullable|numeric|min:0',
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'vat_percent' => 'nullable|numeric|min:0|max:100',
        'otype' => 'required',
        'outlet_id' => 'required',
    ];

    public function mount(): void
    {
        $outlet = Outlet::first();
        $this->outlet_id = $outlet?->id;
        $method = PaymentMethod::first();
        $this->payment_method_id = $method?->id;
    }

    public function paymentMethods(): Collection
    {
        return PaymentMethod::all();
    }

    public function outlets(): Collection
    {
        return Outlet::all();
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->cart)->sum('price');
    }

    public function getDiscountAmountProperty(): float
    {
        return $this->subtotal * ($this->discount_percent / 100);
    }

    public function getVatAmountProperty(): float
    {
        return ($this->subtotal - $this->discount_amount) * ($this->vat_percent / 100);
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal - $this->discount_amount + $this->vat_amount;
    }

    public function getChangeProperty(): float
    {
        return max(0, $this->cash_received - $this->total);
    }

    public function addBarcode(): void
    {
        if (empty($this->barcode)) {
            return;
        }

        $product = \App\Models\ProductArchive::where('barcode', $this->barcode)->first();

        if (!$product) {
            return;
        }

        $price = $product->price ?? 0;
        $name = $product->name ?? 'Unknown Product';
        $code = $product->code ?? '';
        $barcode = $product->barcode ?? '';

        $this->cart[] = [
            'code' => $code,
            'barcode' => $barcode,
            'name' => $name,
            'price' => $price,
        ];

        $this->barcode = '';
    }

    public function removeFromCart(int $key): void
    {
        unset($this->cart[$key]);
        $this->cart = array_values($this->cart);
    }

    public function resetCart(): void
    {
        $this->cart = [];
        $this->cash_received = 0;
        $this->discount_percent = 0;
        $this->vat_percent = 0;
    }

    public function clearCustomer(): void
    {
        $this->selectedCustomer = null;
        $this->mobile = '';
        $this->customer_name = '';
        $this->customer_email = '';
        $this->customer_address = '';
    }

    public function lookupCustomer(): void
    {
        if (empty($this->mobile) || strlen($this->mobile) < 11) {
            return;
        }

        $customer = \App\Models\Customer::where('mobile', $this->mobile)->first();

        if ($customer) {
            $this->selectedCustomer = $customer->id;
            $this->customer_name = $customer->name ?? '';
            $this->customer_email = $customer->email ?? '';
            $this->customer_address = $customer->address ?? '';
        }
    }

    public function createCustomer(): void
    {
        if (empty($this->mobile)) {
            return;
        }

        $customer = \App\Models\Customer::create([
            'name' => $this->customer_name ?: 'Walk-in Customer',
            'mobile' => $this->mobile,
            'email' => $this->customer_email ?: '',
            'address' => $this->customer_address ?: '',
        ]);

        $this->selectedCustomer = $customer->id;
    }

    public function completeSale(): void
    {
        if (empty($this->cart)) {
            Notification::make()
                ->title('Error')
                ->body('Cart is empty')
                ->danger()
                ->send();
            return;
        }

        $this->isProcessing = true;
        $invoiceNo = 'INV-' . time();

        try {
            $screenData = [
            'customer' => [
                'id' => $this->selectedCustomer,
                'name' => $this->customer_name,
                'mobile' => $this->mobile,
                'email' => $this->customer_email,
                'address' => $this->customer_address,
            ],
            'outlet' => ['id' => $this->outlet_id],
            'itemList' => $this->cart,
            'paymentmethod' => ['id' => $this->payment_method_id],
            'invoiceno' => $invoiceNo,
        ];

            $sellItems = [];
            foreach ($this->cart as $item) {
                $sellItems[] = [
                    'product_barcode' => $item['barcode'],
                    'product_name' => $item['name'],
                    'quantity' => 1,
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'],
                ];

                // Update product_archive with sell_statement
                \App\Models\ProductArchive::where('barcode', $item['barcode'])->update([
                    'sell_statement' => $invoiceNo,
                    'status' => 3, // Mark as sold
                ]);
            }

            \App\Models\Sell::create([
                'fy' => date('Y'),
                'date' => date('Y-m-d'),
                'order_no' => $invoiceNo,
                'invoice_no' => $invoiceNo,
                'outlet' => $this->outlet_id,
                'customer' => $this->selectedCustomer ?? 0,
                'price_total' => $this->subtotal,
                'amount' => $this->subtotal,
                'discount' => $this->discount_amount,
                'vat' => $this->vat_amount,
                'payable' => $this->total,
                'profit' => 0,
                'paid' => $this->cash_received,
                'due' => max(0, $this->total - $this->cash_received),
                'payment_method' => $this->payment_method_id,
                'items' => json_encode($sellItems),
                'screen_data' => json_encode($screenData),
                'status' => '1',
                'entry_by' => 'POS_V3',
                'update_by' => 'POS_V3',
            ]);

            $saved = \App\Models\Sell::where('invoice_no', $invoiceNo)->first();

            //\Log::info('POS Sell record created, checking DB...');

            if (!$saved) {
                //\Log::error('POS: Sale saved but not found - invoice: ' . $invoiceNo);
                throw new \Exception('Failed to save sale record');
            }

            //\Log::info('POS Sale saved: ' . $invoiceNo . ' ID: ' . $saved->id);

            $this->last_sale_id = $saved->id;
            $this->last_invoice_no = $invoiceNo;
            $this->receipt_total = $this->total;
            $this->isProcessing = false;

            Notification::make()
                ->title('Sale Completed')
                ->body('Invoice: ' . $invoiceNo . ', Total: ' . number_format($this->total, 0))
                ->success()
                ->send();

            $this->resetCart();
            $this->clearCustomer();
            $this->showReceipt = true;
        } catch (\Exception $e) {
            $this->isProcessing = false;
            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function closeReceipt(): void
    {
        $this->showReceipt = false;
        $this->receipt_total = 0;
    }

    public function printReceipt(): void
    {
        if ($this->last_sale_id) {
            $this->js('window.open("http://127.0.0.1:8900/downloads/receipt/sell/invoice/threeinch/' . $this->last_sale_id . '", "_blank")');
        }
    }

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
        ]);
    }
}
