<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\CrmPoin;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\SalesProduct;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $id_productType = ProductType::create([
                'kode_produk' => $row['kode_produk'],
                'nama_produk' => $row['nama_produk'],
            ]);

            $id_category = Category::where('nama_kategori', $row['kategori'])->first();
            $groups = User::groupBy('id_group')->get();

            foreach ($groups as $group) {
                $newProduct['id_productType'] = $id_productType->id;
                $newProduct['id_group'] = $group->id_group;

                $owner = User::where('id_group', $group->id_group)->first();
                $newProduct['id_owner'] = $owner->id;

                // CREATE NEW PRODUCT PUSAT
                if ($group->group->nama_group == "pusat") {
                    $newProduct['id_category'] = $id_category->id;
                    $newProduct['lokasi_barang'] = $row['lokasi_barang'];
                    $newProduct['stok'] = $row['stok'];
                    $newProduct['harga_jual'] = $row['harga_jual'];
                    $newProduct['harga_modal'] = $row['harga_modal'];
                    if ($row['stok'] == null || $row['stok'] == 0) {
                        $newProduct['keterangan'] = 'Kosong';
                    } else {
                        $newProduct['keterangan'] = 'Tersedia';
                    }
                }
                // CREATE NEW PRODUCT DISTRIBUTOR, HARGA MODAL = HARGA JUAL PUSAT
                else if ($owner->user_position == "superadmin_distributor") {
                    $newProduct['id_category'] = $id_category->id;
                    $newProduct['stok'] = 0;
                    $newProduct['harga_jual'] = 0;
                    $newProduct['harga_modal'] = $row['harga_jual'];
                    $newProduct['keterangan'] = 'Kosong';

                    $salesProduct['id_productType'] = $newProduct['id_productType'];
                    $salesProduct['id_group'] = $newProduct['id_group'];
                    $salesProduct['id_owner'] = $newProduct['id_owner'];
                    $salesProduct['harga_jual'] = 0;
                    $salesProduct['bonus'] = 0;

                    SalesProduct::create($salesProduct);
                }

                Product::create($newProduct);

                $resellers = User::where('id_group', $owner->id_group)->where('user_position', 'reseller')->get();

                // CREATE NEW PRODUCT RESELLER, HARGA MODAL = 0
                foreach ($resellers as $reseller) {
                    $newProductReseller['id_category'] = $id_category->id;
                    $newProductReseller['id_productType'] = $id_productType->id;
                    $newProductReseller['id_group'] = $owner->id_group;
                    $newProductReseller['id_owner'] = $reseller->id;
                    $newProductReseller['stok'] = 0;
                    $newProductReseller['harga_jual'] = 0;
                    $newProductReseller['harga_modal'] = 0;
                    $newProductReseller['keterangan'] = 'Kosong';

                    Product::create($newProductReseller);
                }

                // CREATE NEW PRODUCT SALES, HARGA MODAL = HARGA JUAL PUSAT
                $sales = User::where('id_group', $owner->id_group)->where('user_position', 'sales')->get();

                foreach ($sales as $s) {
                    $newProductSales['id_productType'] = $id_productType->id;
                    $newProductSales['id_category'] = $id_category->id;
                    $newProductSales['id_group'] = $owner->id_group;
                    $newProductSales['id_owner'] = $s->id;
                    $newProductSales['stok'] = 0;
                    $newProductSales['harga_jual'] = 0;
                    $newProductSales['harga_modal'] = $row['harga_jual'];
                    $newProductSales['keterangan'] = 'Kosong';

                    Product::create($newProductSales);
                }
            }

            // CREATE POIN CRM = 0
            $newPoinCrm['id_productType'] = $id_productType->id;
            $newPoinCrm['distributor_beli'] = 0;
            $newPoinCrm['distributor_jual'] = 0;
            $newPoinCrm['reseller_beli'] = 0;
            CrmPoin::create($newPoinCrm);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Import Product";
            UserHistory::create($newActivity);
        }
    }

    public function rules(): array
    {
        return [
            '*.kode_produk' => ['unique:product_types,kode_produk'],
            'kategori' => Rule::exists('categories', 'nama_kategori'),
        ];
    }
}
