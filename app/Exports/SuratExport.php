<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratExport implements FromArray, WithHeadings, WithMapping
{

    private $setData;
    private $setSheetTitle;

    public function __construct($data = [], $title = '')
    {
        $this->setData = $data;
        $this->setSheetTitle = $title;
    }

    public function array(): array
    {
        return $this->setData;
    }

    public function title(): string
    {
        return is_null($this->setSheetTitle) ? 'Main' : $this->setSheetTitle;
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->type_surat,
            $data->code_surat_printed,
            date('d F Y', strtotime($data->printed_at)),
            $data->pemohon,
            $data->nama_staf_desa,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Jenis Surat',
            'Kode Surat',
            'Tanggal Printe Surat',
            'Nama Pemohon',
            'Nama Staff Desa',
        ];
    }
}
