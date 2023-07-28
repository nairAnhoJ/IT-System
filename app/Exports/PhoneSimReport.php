<?php

namespace App\Exports;

use App\Models\PhoneSim;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PhoneSimReport implements FromCollection, WithHeadings
{
    protected $formInput;

    public function __construct(array $formInput)
    {
        $this->formInput = $formInput;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $item = $this->formInput['item'];

        return PhoneSim::select('phone_sims.item', 'phone_sims.user', 'departments.name', 'phone_sims.desc', 'phone_sims.serial_no', 'phone_sims.status', 'phone_sims.date_issued', 'phone_sims.date_del')
            ->join('departments', 'phone_sims.department', '=', 'departments.id')
            ->where('item', 'LIKE', '%'.$item.'%')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Return an array of custom headers
        return [
            'ITEM',
            'USER',
            'DEPARTMENT',
            'DESCRIPTION',
            'SERIAL NUMBER',
            'STATUS',
            'DATE ISSUED',
            'DATE DELIVERED',
        ];
    }
}
