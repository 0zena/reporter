<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * Return a collection of users.
     */
    public function collection()
    {
        return User::select('name', 'surname', 'email', 'phone')->get();
    }
}
