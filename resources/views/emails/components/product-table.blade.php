<table class="products-table">
    <thead>
        <tr>
            <th>Product</th>
            <th style="text-align: center;">Quantity</th>
            <th style="text-align: right;">Price</th>
            <th style="text-align: right;">{{ $totalColumn ?? 'Total' }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>
                    <strong>{{ $item->snapshot_product_name }}</strong>
                    @if ($item->snapshot_variant_attributes)
                        @php
                            $attributes = json_decode($item->snapshot_variant_attributes, true);
                        @endphp
                        @if ($attributes && is_array($attributes))
                            <br>
                            <small style="color: #666;">
                                @foreach ($attributes as $attr)
                                    {{ $attr['name'] ?? '' }}: {{ $attr['value'] ?? '' }}
                                    @if (!$loop->last), @endif
                                @endforeach
                            </small>
                        @endif
                    @endif
                    <br>
                    <small style="color: #999;">SKU: {{ $item->snapshot_product_sku }}</small>
                </td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                <td style="text-align: right;"><strong>${{ number_format($item->total_price, 2) }}</strong></td>
            </tr>
        @endforeach
    </tbody>
</table>
