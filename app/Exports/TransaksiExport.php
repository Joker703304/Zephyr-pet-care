<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Transaksi;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TransaksiExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    protected $mode;
    protected $bulan;
    protected $tahun;

    public function __construct($mode, $bulan = null, $tahun = null)
    {
        $this->mode = $mode;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        if ($this->mode === 'bulan' && $this->bulan) {
            $start = Carbon::parse($this->bulan . '-01')->startOfMonth();
            $end = Carbon::parse($this->bulan . '-01')->endOfMonth();

            return Transaksi::with(['konsultasi.hewan'])
                ->where('status_pembayaran', 'Sudah Dibayar')
                ->whereBetween('created_at', [$start, $end])
                ->get()
                ->map(function ($item) {
                    return [
                        $item->created_at->format('d-m-Y'),
                        $item->konsultasi->hewan->nama_hewan ?? '-',
                        $item->total_harga,
                        $item->jumlah_bayar,
                        $item->kembalian,
                    ];
                });
        } else {
            $start = Carbon::parse($this->tahun . '-01-01')->startOfYear();
            $end = Carbon::parse($this->tahun . '-12-31')->endOfYear();

            $transaksi = Transaksi::where('status_pembayaran', 'Sudah Dibayar')
                ->whereBetween('created_at', [$start, $end])
                ->get();

            $rekap = $transaksi->groupBy(function ($item) {
                return $item->created_at->format('m');
            })->map(function ($group) {
                return $group->sum('total_harga');
            });

            $rekapTahun = collect();
            for ($i = 1; $i <= 12; $i++) {
                $bulanStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                $namaBulan = Carbon::createFromFormat('m', $bulanStr)->locale('id')->translatedFormat('F');
                $rekapTahun->push([
                    $namaBulan,
                    $rekap->get($bulanStr, 0)
                ]);
            }

            $rekapTahun->push([
                'Total Tahun ' . $this->tahun,
                $rekapTahun->sum(function ($row) {
                    return $row[1];
                })
            ]);

            return $rekapTahun;
        }
    }

    public function headings(): array
    {
        if ($this->mode === 'bulan') {
            return ['Tanggal', 'Nama Hewan', 'Total Harga', 'Jumlah Bayar', 'Kembalian'];
        }

        return ['Bulan', 'Total Uang Masuk'];
    }

    public function title(): string
    {
        return $this->mode === 'bulan' ? 'Laporan Bulanan' : 'Laporan Tahunan';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn();

        // Border seluruh tabel
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}