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
        return User::updateOrCreate(
            ['email' => $row['email']],
            [
                'username' => $row['username'],
                'phone' => $row['phone'],
                'password' => bcrypt($row['password'] ?? '123456789'),
            ]
        );
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
