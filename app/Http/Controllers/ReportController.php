<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\EvaluationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    public function index()
    {
        $reports = EvaluationReport::with(['alternatives' => function($query) {
            $query->orderBy('rank');
        }])->orderBy('created_at', 'desc')->paginate(10);
        
        return view('reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = EvaluationReport::with(['alternatives' => function($query) {
            $query->orderBy('rank');
        }])->findOrFail($id);
        
        $criteria = Criteria::with('subcriteria')->get();
        
        return view('reports.show', compact('report', 'criteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Create evaluation report
            $report = EvaluationReport::create([
                'title' => $request->title,
                'description' => $request->description,
                'calculation_date' => now(),
                'total_alternatives' => Alternative::count(),
                'total_criteria' => Criteria::count(),
                'total_subcriteria' => \App\Models\Subcriteria::count()
            ]);

            // Save current alternatives data to report
            $alternatives = Alternative::with('evaluations.subcriteria')->get();
            
            foreach ($alternatives as $alternative) {
                $report->alternatives()->create([
                    'alternative_id' => $alternative->id,
                    'name' => $alternative->name,
                    'code' => $alternative->code,
                    'email' => $alternative->email,
                    'phone' => $alternative->phone,
                    'address' => $alternative->address,
                    'final_score' => $alternative->final_score,
                    'rank' => $alternative->rank,
                    'evaluations_data' => $alternative->evaluations->map(function($eval) {
                        return [
                            'subcriteria_id' => $eval->subcriteria_id,
                            'subcriteria_name' => $eval->subcriteria->name,
                            'criteria_name' => $eval->subcriteria->criteria->name,
                            'value' => $eval->value,
                            'normalized_value' => $eval->normalized_value
                        ];
                    })->toArray()
                ]);
            }

            DB::commit();

            return redirect()->route('reports.show', $report)
                ->with('success', 'Laporan evaluasi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $report = EvaluationReport::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus');
    }

    public function export($id, Request $request)
    {
        $report = EvaluationReport::with(['alternatives' => function($query) {
            $query->orderBy('rank');
        }])->findOrFail($id);
        
        $format = $request->get('format', 'excel'); // default to excel
        
        if ($format === 'pdf') {
            return $this->exportPDF($report);
        } else {
            return $this->exportExcel($report);
        }
    }

    private function exportExcel($report)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Evaluasi AHP');

        // Header Information
        $sheet->setCellValue('A1', 'LAPORAN EVALUASI AHP');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Judul Laporan:');
        $sheet->setCellValue('B3', $report->title);
        $sheet->setCellValue('A4', 'Tanggal Perhitungan:');
        $sheet->setCellValue('B4', $report->calculation_date->format('d F Y, H:i'));
        $sheet->setCellValue('A5', 'Total Alternatif:');
        $sheet->setCellValue('B5', $report->total_alternatives);
        $sheet->setCellValue('A6', 'Total Kriteria:');
        $sheet->setCellValue('B6', $report->total_criteria);

        if ($report->description) {
            $sheet->setCellValue('A7', 'Deskripsi:');
            $sheet->setCellValue('B7', $report->description);
        }

        // Table Headers
        $headerRow = 9;
        $headers = ['Rank', 'Kode', 'Nama Nasabah', 'Email', 'Telepon', 'Alamat', 'Skor Akhir', 'Status'];
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, etc.
            $sheet->setCellValue($column . $headerRow, $header);
        }

        // Style headers
        $headerRange = 'A' . $headerRow . ':' . chr(65 + count($headers) - 1) . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E3F2FD');
        $sheet->getStyle($headerRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Data rows
        $row = $headerRow + 1;
        foreach ($report->alternatives as $alternative) {
            $status = 'Tidak Layak';
            if ($alternative->rank > 0) {
                if ($alternative->rank <= 3) {
                    $status = 'Sangat Layak';
                } elseif ($alternative->rank <= 5) {
                    $status = 'Layak';
                } else {
                    $status = 'Perlu Review';
                }
            }

            $sheet->setCellValue('A' . $row, $alternative->rank > 0 ? $alternative->rank : '-');
            $sheet->setCellValue('B' . $row, $alternative->code);
            $sheet->setCellValue('C' . $row, $alternative->name);
            $sheet->setCellValue('D' . $row, $alternative->email ?: '-');
            $sheet->setCellValue('E' . $row, $alternative->phone ?: '-');
            $sheet->setCellValue('F' . $row, $alternative->address ?: '-');
            $sheet->setCellValue('G' . $row, number_format($alternative->final_score, 4));
            $sheet->setCellValue('H' . $row, $status);

            // Highlight top 3
            if ($alternative->rank <= 3 && $alternative->rank > 0) {
                $rowRange = 'A' . $row . ':H' . $row;
                $sheet->getStyle($rowRange)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E8F5E8');
            }

            $row++;
        }

        // Style data area
        $dataRange = 'A' . $headerRow . ':H' . ($row - 1);
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Evaluasi_AHP_' . date('YmdHis') . '.xlsx';
        
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    private function exportPDF($report)
    {
        $data = [
            'report' => $report,
            'alternatives' => $report->alternatives,
            'exportDate' => now()
        ];

        $html = view('reports.pdf', $data)->render();
        
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $filename = 'Laporan_Evaluasi_AHP_' . date('YmdHis') . '.pdf';
        
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
