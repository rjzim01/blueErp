<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">POS</h1>
    </div>
    <div class="flex gap-6 mt-4">
        <!-- Left Column: Transaction Details -->
        <div class="w-[60%] flex flex-col gap-4">

            <!-- Operation & Barcode -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="space-y-3">
                    {{-- <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Product Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="ptype" value="0" class="w-4 h-4 text-pink-500">
                                <span class="text-sm">Running Product</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="ptype" value="1" class="w-4 h-4 text-pink-500">
                                <span class="text-sm">New Product</span>
                            </label>
                        </div>
                    </div> --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sell Barcode</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model="barcode" wire:keydown.enter="$set('barcode', '')" class="flex-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 font-mono text-sm" placeholder="Scan or enter barcode">
                            <button wire:click="addBarcode" class="px-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sell Items -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden flex-1">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-2 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Sell Items</span>
                    <button wire:click="resetCart" class="text-xs text-red-500 hover:text-red-700">Clear</button>
                </div>
                <div class="overflow-auto flex-1">
                    @if(empty($cart))
                    <div class="h-48 flex items-center justify-center text-gray-400"><p class="text-sm">No items in cart</p></div>
                    @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase">
                            <tr>
                                <th class="px-4 py-2 text-left w-12">Option</th>
                                <th class="px-4 py-2 text-left w-12">SL</th>
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-left">Barcode</th>
                                <th class="px-4 py-2 text-left">Product Name</th>
                                <th class="px-4 py-2 text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($cart as $key => $item)
                            <tr>
                                <td class="px-4 py-2"><button class="text-red-500 font-bold" wire:click="removeFromCart({{ $key }})">X</button></td>
                                <td class="px-4 py-2">{{ $key + 1 }}</td>
                                <td class="px-4 py-2">{{ $item['code'] ?? 'N/A' }}</td>
                                <td class="px-4 py-2 font-mono text-xs">{{ $item['barcode'] ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $item['name'] }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($item['price'], 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-right font-bold">Total</td>
                                <td class="px-4 py-3 text-right font-bold text-lg">{{ number_format($this->subtotal, 0) }}/-</td>
                            </tr>
                        </tfoot>
                    </table>
                    @endif
                </div>
            </div>

            <!-- Payment Section -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Left: Method & Cash -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                Payment Method
                            </label>
                            <select wire:model="payment_method_id" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 text-sm">
                                @foreach($this->paymentMethods() as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Customer Paid</label>
                                <input type="number" wire:model="cash_received" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Return</label>
                                <input type="number" disabled value="{{ number_format($this->change, 0) }}" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700">
                            </div>
                        </div>
                    </div>
                    <!-- Right: Totals -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Total</span>
                            <span class="text-lg font-bold">{{ number_format($this->subtotal, 0) }}/-</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Discount %</label>
                                <input type="number" wire:model="discount_percent" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1 text-sm" placeholder="%">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Amount</label>
                                <input type="number" disabled value="{{ number_format($this->discount_amount, 0) }}" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-2 py-1 text-sm bg-gray-100 dark:bg-gray-700">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">VAT %</label>
                                <input type="number" wire:model="vat_percent" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1 text-sm" placeholder="%">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Amount</label>
                                <input type="number" disabled value="{{ number_format($this->vat_amount, 0) }}" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-2 py-1 text-sm bg-gray-100 dark:bg-gray-700">
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-700">
                            <span class="font-bold">Net Payable</span>
                            <span class="text-lg font-bold text-green-600">{{ number_format($this->total, 0) }}/-</span>
                        </div>
                        <button wire:click="completeSale" wire:loading.attr="disabled" {{ empty($cart) ? 'disabled' : '' }} class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading>Processing...</span>
                            <span wire:loading.remove>Confirm Sale</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="w-[40%] flex flex-col gap-4">
            <!-- Operation Type -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                <span class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 block mb-4">
                    Operation Type
                </span>
                <div class="grid grid-cols-4 gap-1">
                    <button wire:click="$set('otype', '0')" class="py-2 text-sm font-semibold rounded-lg {{ $otype == '0' ? 'bg-green-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                        Sell
                    </button>
                    <button wire:click="$set('otype', '1')" class="py-2 text-sm font-semibold rounded-lg {{ $otype == '1' ? 'bg-pink-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                        Return
                    </button>
                    <button wire:click="$set('otype', '3')" class="py-2 text-sm font-semibold rounded-lg {{ $otype == '3' ? 'bg-gray-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                        Return & Sell
                    </button>
                    <button wire:click="$set('otype', '2')" class="py-2 text-sm font-semibold rounded-lg {{ $otype == '2' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                        Show
                    </button>
                </div>
            </div>

            <!-- Invoice (Show mode) -->
            @if($otype == '2')
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Invoice</label>
                <div class="flex gap-2">
                    <input type="text" wire:model="invoice_no" class="flex-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-4 py-3" placeholder="Invoice number">
                    <button wire:click="loadInvoice" class="px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Refresh</button>
                </div>
            </div>
            @endif

            <!-- Outlet Details -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                <span class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 block mb-4">
                    Outlet Details
                </span>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Outlet</label>
                <select
                    wire:model="outlet_id"
                    class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-4 py-2"
                >
                    @foreach($this->outlets() as $outlet)
                        <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Customer Details -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                <span class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 block mb-4">
                    Customer Details
                </span>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Mobile</label>
                        <div class="flex gap-2">
                            <input
                                type="text"
                                wire:model="mobile"
                                class="flex-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-4 py-2"
                                placeholder="01XXXXXXXXX"
                                maxlength="11"
                            >
                            <button wire:click="clearCustomer" class="px-4 py-2 bg-pink-500 text-white rounded-lg">X</button>
                        </div>
                    </div>
                    @if($selectedCustomer)
                        <div
                            class="px-4 py-2 bg-green-100 dark:bg-green-900/30 rounded-lg text-sm font-medium text-green-700 dark:text-green-400">
                            ID: C-{{ $selectedCustomer }}
                        </div>
                    @endif
                    <div>
                        <label
                            class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2"
                        >
                            Name
                        </label>
                        <input
                            type="text"
                            wire:model="customer_name"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-4 py-2"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Email</label>
                        <input type="email" wire:model="customer_email" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Address</label>
                        <input type="text" wire:model="customer_address" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-4 py-2">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($showReceipt)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeReceipt">
        <div class="bg-white dark:bg-gray-900 rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
            <div class="text-center">
                <div class="text-green-500 text-4xl mb-2">✓</div>
                <h2 class="text-xl font-bold mb-4">Sale Completed</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-2">Invoice: {{ $last_invoice_no }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Total: {{ number_format($receipt_total, 0) }}/-</p>
                
                <button wire:click="printReceipt" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg mb-3">
                    Print Receipt
                </button>
                <button wire:click="closeReceipt" class="w-full py-3 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 font-bold rounded-lg">
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
