<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\ApiResponser;

class HolidayController extends Controller
{
    use ApiResponser;

    /**
     * Obtém feriados nacionais fixos.
     *
     * @param int $year
     * @return array
     */
    private function getNationalHolidays(int $year): array
    {
        $fixedHolidays = [
            '01-01' => 'Confraternização Universal',
            '04-21' => 'Tiradentes',
            '05-01' => 'Dia do Trabalho',
            '09-07' => 'Independência do Brasil',
            '10-12' => 'Nossa Senhora Aparecida',
            '11-02' => 'Finados',
            '11-15' => 'Proclamação da República',
            '12-25' => 'Natal',
        ];

        if ($year >= 2024) {
            $fixedHolidays['11-20'] = 'Dia da Consciência Negra';
        }

        $holidays = [];
        foreach ($fixedHolidays as $date => $name) {
            $holidays[] = [
                'date' => "$year-$date",
                'name' => $name,
                'type' => 'nacional',
            ];
        }

        return $holidays;
    }

    /**
     * Calcula feriados móveis baseados na Páscoa.
     *
     * @param int $year
     * @return array
     */
    private function getEasterHolidays(int $year): array
    {
        // Datas da Lua Cheia Pascal para os anos de 1900-2199
        $pascalFullMoonDates = [
            [3, 14], [3, 3], [2, 23], [3, 11], [2, 31], [3, 18],
            [3, 8], [2, 28], [3, 16], [3, 5], [2, 25], [3, 13],
            [3, 2], [2, 22], [3, 10], [2, 30], [3, 17], [3, 7], [2, 27],
        ];

        [$refMonth, $refDay] = $pascalFullMoonDates[$year % 19];
        $easter = Carbon::create($year, $refMonth + 1, $refDay)->next(Carbon::SUNDAY);

        return [
            [
                'date' => $easter->toDateString(),
                'name' => 'Páscoa',
                'type' => 'nacional',
            ],
            [
                'date' => $easter->copy()->subDays(2)->toDateString(),
                'name' => 'Sexta-feira Santa',
                'type' => 'nacional',
            ],
            [
                'date' => $easter->copy()->subDays(47)->toDateString(),
                'name' => 'Carnaval',
                'type' => 'nacional',
            ],
            [
                'date' => $easter->copy()->addDays(60)->toDateString(),
                'name' => 'Corpus Christi',
                'type' => 'nacional',
            ],
        ];
    }

    /**
     * Combina feriados móveis e fixos e ordena por data.
     *
     * @param int $year
     * @return array
     */
    public function getHolidays(int $year): array
    {
        $nacionalHolidays = $this->getNationalHolidays($year);
        $easterHolidays = $this->getEasterHolidays($year);

        $holidays = array_merge($nacionalHolidays, $easterHolidays);

        usort($holidays, fn ($a, $b) => $a['date'] <=> $b['date']);

        return $holidays;
    }

    /**
     * Endpoint para obter feriados.
     *
     * @param Request $request
     * @param int $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, int $year)
    {
        if ($year < 1900 || $year > 2199) {
            return $this->errorResponse('Ano fora do intervalo suportado entre 1900 e 2199.');
        }
        return $this->successResponse($this->getHolidays($year));
    }
}
