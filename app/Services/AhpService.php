<?php

namespace App\Services;

class AhpService
{
    // Skala perbandingan AHP
    private $comparisonScale = [
        1 => 'Sama penting',
        2 => 'Sedikit lebih penting',
        3 => 'Lebih penting',
        4 => 'Sangat lebih penting',
        5 => 'Mutlak lebih penting',
        6 => 'Di antara 5 dan 7',
        7 => 'Sangat mutlak lebih penting',
        8 => 'Di antara 7 dan 9',
        9 => 'Ekstrem lebih penting'
    ];

    // Random Index untuk konsistensi
    private $randomIndex = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49
    ];

    public function getComparisonScale()
    {
        return $this->comparisonScale;
    }

    public function calculateWeights($matrix)
    {
        $n = count($matrix);
        $weights = [];
        
        // Normalisasi matriks
        $normalizedMatrix = $this->normalizeMatrix($matrix);
        
        // Hitung rata-rata baris untuk mendapatkan bobot
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $normalizedMatrix[$i][$j];
            }
            $weights[$i] = $sum / $n;
        }
        
        return $weights;
    }

    public function calculateConsistencyRatio($matrix, $weights)
    {
        $n = count($matrix);
        
        if ($n <= 2) {
            return 0.0; // Konsisten secara otomatis untuk matriks 2x2 atau kurang
        }
        
        // Hitung lambda max
        $lambdaMax = $this->calculateLambdaMax($matrix, $weights);
        
        // Hitung Consistency Index (CI)
        $ci = ($lambdaMax - $n) / ($n - 1);
        
        // Hitung Consistency Ratio (CR)
        $ri = $this->randomIndex[$n] ?? 1.49;
        $cr = $ci / $ri;
        
        return $cr;
    }

    private function normalizeMatrix($matrix)
    {
        $n = count($matrix);
        $normalizedMatrix = [];
        
        // Hitung jumlah setiap kolom
        $columnSums = [];
        for ($j = 0; $j < $n; $j++) {
            $sum = 0;
            for ($i = 0; $i < $n; $i++) {
                $sum += $matrix[$i][$j];
            }
            $columnSums[$j] = $sum;
        }
        
        // Normalisasi setiap elemen
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalizedMatrix[$i][$j] = $matrix[$i][$j] / $columnSums[$j];
            }
        }
        
        return $normalizedMatrix;
    }

    private function calculateLambdaMax($matrix, $weights)
    {
        $n = count($matrix);
        $weightedSum = [];
        
        // Kalikan matriks dengan vektor bobot
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $matrix[$i][$j] * $weights[$j];
            }
            $weightedSum[$i] = $sum;
        }
        
        // Hitung lambda max
        $lambdaMax = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($weights[$i] != 0) {
                $lambdaMax += $weightedSum[$i] / $weights[$i];
            }
        }
        
        return $lambdaMax / $n;
    }

    public function isConsistent($consistencyRatio)
    {
        return $consistencyRatio <= 0.1; // CR harus <= 0.1 untuk konsisten
    }

    public function generateDefaultMatrix($items)
    {
        $n = count($items);
        $matrix = [];
        
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i == $j) {
                    $matrix[$i][$j] = 1; // Diagonal = 1
                } else {
                    $matrix[$i][$j] = 1; // Default sama penting
                }
            }
        }
        
        return $matrix;
    }
}