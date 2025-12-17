<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'username' => $row['username'] ?? null,
            'email' => $row['email'] ?? null,
            'password' => bcrypt($row['password'] ?? 'password123'),
            'phone' => $row['phone'] ?? null,
            'status' => $row['status'] ?? 'active',
            'role_id' => $row['role_id'] ?? 3,
        ]);
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
        ];
    }
}
