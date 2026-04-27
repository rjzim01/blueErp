<?php /** @var \App\Filament\Pages\Pos $this */ ?>
<div class="fi-fi-content">
    <div class="flex h-[calc(100vh-8rem)] gap-6">
        <!-- Left Side - Main Content (col-md-8) -->
        <div class="w-[66%] flex flex-col gap-4">
            <!-- Operation Section -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Operation</span>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Product Type</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" wire:model="ptype" value="0" class="rounded border-gray-300">
                                    <span class="text-sm">Running Product</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" wire:model="ptype" value="1" class="rounded border-gray-300">
                                    <span class="text-sm">New Product</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sell Barcode</label>
                            <div class="flex gap-2">
                                <input type="text" wire:model="barcode" wire:keydown.enter="$set('barcode', '')" class="flex-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2 font-mono" placeholder="Scan or enter barcode">
                                <button wire:click="getbarcode" class="px-4 bg-pink-500 text-white rounded text-sm">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sell Items Table -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden flex-1">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Sell Items</span>
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

            <!-- Return Items (hidden by default, shown when in Return mode) -->
            @if($otype == '1' || $otype == '3')
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Return Items</span>
                </div>
                <div class="p-4">
                    <div class="flex gap-2 mb-4">
                        <input type="text" wire:model="returncode" class="flex-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2 font-mono" placeholder="Return barcode">
                        <button wire:click="getreturncode" class="px-4 bg-pink-500 text-white rounded text-sm">+</button>
                    </div>
                    <p class="text-gray-400 text-sm">No return items</p>
                </div>
            </div>
            @endif

            <!-- Payment Section -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="p-4">
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Method + Cash -->
                        <div class="col-span-5">
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Method</label>
                                <select wire:model="payment_method_id" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 py-2">
                                    @foreach($paymentMethods as $method)<option value="{{ $method->id }}">{{ $method->name }}</option>@endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-500">Customer Paid</label>
                                    <input type="number" wire:model="cash_received" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm py-2">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500">Return</label>
                                    <input type="number" disabled value="{{ $this->change > 0 ? number_format($this->change, 0) : 0 }}" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm py-2 bg-gray-100 dark:bg-gray-700">
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Button -->
                        <div class="col-span-3 flex items-center justify-center">
                            <button class="w-full py-16 bg-green-500 text-white text-2xl font-bold rounded" wire:click="completeSale" {{ empty($cart) ? 'disabled' : '' }}>Confirm Sell</button>
                        </div>

                        <!-- Totals -->
                        <div class="col-span-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total</span>
                                <span class="text-xl font-bold">{{ number_format($this->subtotal, 0) }}/-</span>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex-1">
                                    <label class="text-xs text-gray-500">Discount %</label>
                                    <input type="number" wire:model="discount_percent" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm py-1" placeholder="%">
                                </div>
                                <div class="flex-1">
                                    <label class="text-xs text-gray-500">Amount</label>
                                    <input type="number" disabled value="{{ $this->discount_amount }}" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm py-1 bg-gray-100 dark:bg-gray-700">
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex-1">
                                    <label class="text-xs text-gray-500">VAT %</label>
                                    <input type="number" wire:model="vat_percent" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm py-1" placeholder="%">
                                </div>
                                <div class="flex-1">
                                    <label class="text-xs text-gray-500">Amount</label>
                                    <input type="number" disabled value="{{ $this->vat_amount }}" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm py-1 bg-gray-100 dark:bg-gray-700">
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-lg font-bold">Net Payable</span>
                                <span class="text-xl font-bold text-green-600">{{ number_format($this->total, 0) }}/-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Browse Invoice (shown when otype == 2) -->
            @if($otype == '2')
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden p-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <button class="w-full py-3 bg-blue-500 text-white rounded text-lg">A4 Invoice</button>
                        <button class="w-full py-3 bg-blue-500 text-white rounded text-lg mt-2">3" Invoice</button>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-400 text-sm">Invoice details will appear here</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Side - Sidebar (col-md-4) -->
        <div class="w-[34%] flex flex-col gap-4">
            <!-- Operation Type -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Operation Type</span>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-4 gap-2">
                        <button wire:click="$set('otype', '0')" class="py-3 text-sm font-semibold rounded {{ $otype == '0' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">Sell</button>
                        <button wire:click="$set('otype', '1')" class="py-3 text-sm font-semibold rounded {{ $otype == '1' ? 'bg-pink-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">Return</button>
                        <button wire:click="$set('otype', '3')" class="py-3 text-sm font-semibold rounded {{ $otype == '3' ? 'bg-gray-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">Return & Sell</button>
                        <button wire:click="$set('otype', '2')" class="py-3 text-sm font-semibold rounded {{ $otype == '2' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">Show</button>
                    </div>
                    @if($otype == '2')
                    <div class="mt-4">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Invoice</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model="invoiceno" class="flex-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2" placeholder="Invoice number">
                            <button wire:click="getInvoiceDetails" class="px-4 bg-pink-500 text-white rounded text-sm">Refresh</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Outlet Details -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Outlet Details</span>
                </div>
                <div class="p-4">
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Outlet</label>
                    <select wire:model="outlet_id" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2">
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Customer Details</span>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Mobile</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model="mobile" class="flex-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2" placeholder="01XXXXXXXXX" maxlength="11">
                            <button @click="customer=initCustomer" class="px-3 bg-pink-500 text-white rounded text-sm">X</button>
                        </div>
                    </div>
                    @if($selectedCustomer)
                    <div class="px-2 py-1 bg-green-100 dark:bg-green-900/30 rounded text-xs font-medium text-green-700 dark:text-green-400">ID: C-{{ $selectedCustomer }}</div>
                    @endif
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Name</label>
                        <input type="text" wire:model="customer_name" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                        <input type="text" wire:model="customer_email" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Address</label>
                        <input type="text" wire:model="customer_address" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Delivery Address</label>
                        <input type="text" wire:model="delivery_address" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm py-2">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>