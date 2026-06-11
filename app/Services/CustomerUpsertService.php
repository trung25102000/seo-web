<?php

namespace App\Services;

use App\Models\Customer;

class CustomerUpsertService
{
    /**
     * @param  array{name?: string, email?: ?string, phone?: ?string, customer_group?: ?string, zalo?: ?string, facebook_url?: ?string}  $data
     */
    public function upsert(array $data): Customer
    {
        $lookup = [];

        if (! empty($data['email'])) {
            $lookup['email'] = $data['email'];
        } elseif (! empty($data['phone'])) {
            $lookup['phone'] = $data['phone'];
        } else {
            $lookup['name'] = $data['name'] ?? 'Khách hàng';
        }

        return Customer::query()->updateOrCreate($lookup, [
            'name' => $data['name'] ?? $lookup['name'] ?? 'Khách hàng',
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'zalo' => $data['zalo'] ?? null,
            'facebook_url' => $data['facebook_url'] ?? null,
            'customer_group' => $data['customer_group'] ?? 'shop_owner',
        ]);
    }
}
