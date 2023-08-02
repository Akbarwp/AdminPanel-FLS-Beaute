@foreach($products as $product)
    <tr>
        <td>{{ $product->product_type->kode_produk }}</td>
        <td>{{ $product->product_type->nama_produk }}</td>
        <td>{{ number_format($product->stok, 0, ',', '.') }} pcs</td>
        <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($product->harga_modal, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($product->stok * $product->harga_modal, 0, ',', '.') }}</td>
        <td>{{ $product->keterangan }}</td>
        <td><button class="btn btn-primary btn-sm" onclick="location.href='{{ url('/manage_product/products/'.$product->id) }}'"><i class="fa fa-eye"></button></td>
        {{-- @can('superadmin_pabrik') --}}
            <td><button type="button" class="btn btn-sm btn-warning" onclick="location.href='{{ url('/manage_product/products/'.$product->id.'/edit') }}'">
                <span><i class="fa fa-edit"></i>Edit</span>
            </button></td>
        {{-- @endcan --}}
    </tr>
@endforeach