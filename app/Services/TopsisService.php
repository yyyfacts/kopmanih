<?php

namespace App\Services;

use App\Models\PengajuanBarang;
use App\Models\KriteriaTopsis;
use App\Models\NilaiTopsis;
use Illuminate\Support\Collection;

class TopsisService
{
    public function hitungRanking(): array
    {
        $alternatif = PengajuanBarang::with('nilaiTopsis')
            ->where('status', 'pending')
            ->get();
        $kriteria = KriteriaTopsis::all();

        if ($alternatif->isEmpty() || $kriteria->isEmpty()) {
            return [];
        }

        // Matriks Keputusan
        $matriks = $this->buatMatriksKeputusan($alternatif, $kriteria);

        // Normalisasi
        list($normalisasi, $pembagi) = $this->normalisasiMatriks($matriks, $kriteria, $alternatif);

        // Matriks Terbobot
        $terbobot = $this->hitungMatriksTerbobot($normalisasi, $kriteria, $alternatif);

        // Solusi Ideal
        list($idealPos, $idealNeg) = $this->tentukanSolusiIdeal($terbobot, $kriteria, $alternatif);

        // Hitung Jarak dan Preferensi
        $hasil = $this->hitungJarakDanPreferensi($terbobot, $idealPos, $idealNeg, $alternatif);

        // Urutkan Hasil
        usort($hasil, fn($a, $b) => $b['nilai_preferensi'] <=> $a['nilai_preferensi']);

        return $hasil;
    }

    private function buatMatriksKeputusan(Collection $alternatif, Collection $kriteria): array
    {
        $matriks = [];
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $k) {
                $nilai = $alt->nilaiTopsis
                    ->where('kriteria_topsis_id', $k->id)
                    ->first()
                    ?->nilai ?? 0;
                $matriks[$alt->id][$k->id] = $nilai;
            }
        }
        return $matriks;
    }

    private function normalisasiMatriks(array $matriks, Collection $kriteria, Collection $alternatif): array
    {
        $pembagi = [];
        $normalisasi = [];

        // Hitung pembagi
        foreach ($kriteria as $k) {
            $totalKuadrat = 0;
            foreach ($alternatif as $alt) {
                $totalKuadrat += pow($matriks[$alt->id][$k->id], 2);
            }
            $pembagi[$k->id] = sqrt($totalKuadrat);
        }

        // Normalisasi
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $k) {
                $normalisasi[$alt->id][$k->id] = $matriks[$alt->id][$k->id] / ($pembagi[$k->id] ?: 1);
            }
        }

        return [$normalisasi, $pembagi];
    }

    private function hitungMatriksTerbobot(array $normalisasi, Collection $kriteria, Collection $alternatif): array
    {
        $terbobot = [];
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $k) {
                $terbobot[$alt->id][$k->id] = $normalisasi[$alt->id][$k->id] * $k->bobot;
            }
        }
        return $terbobot;
    }

    private function tentukanSolusiIdeal(array $terbobot, Collection $kriteria, Collection $alternatif): array
    {
        $idealPos = $idealNeg = [];
        foreach ($kriteria as $k) {
            $values = array_column(
                array_map(
                    fn($a) => $terbobot[$a->id][$k->id],
                    $alternatif->all()
                ),
                null
            );
            
            $idealPos[$k->id] = $k->atribut === 'benefit' ? max($values) : min($values);
            $idealNeg[$k->id] = $k->atribut === 'benefit' ? min($values) : max($values);
        }
        return [$idealPos, $idealNeg];
    }

    private function hitungJarakDanPreferensi(
        array $terbobot,
        array $idealPos,
        array $idealNeg,
        Collection $alternatif
    ): array {
        $hasil = [];
        foreach ($alternatif as $alt) {
            $dPos = $dNeg = 0;
            foreach ($idealPos as $kriteriaId => $nilai) {
                $dPos += pow($terbobot[$alt->id][$kriteriaId] - $idealPos[$kriteriaId], 2);
                $dNeg += pow($terbobot[$alt->id][$kriteriaId] - $idealNeg[$kriteriaId], 2);
            }
            
            $dPos = sqrt($dPos);
            $dNeg = sqrt($dNeg);
            
            $hasil[$alt->id] = [
                'alternatif' => $alt,
                'nilai_preferensi' => $dNeg / ($dNeg + $dPos),
                'jarak_positif' => $dPos,
                'jarak_negatif' => $dNeg
            ];
        }
        return $hasil;
    }
}
