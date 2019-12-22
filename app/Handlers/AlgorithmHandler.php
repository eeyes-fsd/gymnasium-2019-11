<?php

namespace App\Handlers;

use Carbon\Carbon;
use App\Models\Health;

class AlgorithmHandler
{
    const parameters = [
        'age' => [18, 30],
        'fat' => [
            // 运动量分级
            1 => [
                // 目的分级
                1 => null,
                2 => null,
                3 => null,
                4 => null,
                5 => [
                    'm' => [
                        ['range' => [0, 19], 'energy' => 28, 'ratio' => '3:1:1'],
                        ['range' => [19, 24], 'energy' => 26, 'ratio' => '2:2:1(2) 2:1:1'],
                        ['range' => [24, 29], 'energy' => 23, 'ratio' => '2:2:1(4) 2:1:1'],
                        ['range' => [29, null], 'energy' => 23, 'ratio' => '1:3:1(4) 2:2:1(4) 2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 24], 'energy' => 28, 'ratio' => '3:1:1'],
                        ['range' => [24, 29], 'energy' => 26, 'ratio' => '2:2:1(2) 2:1:1'],
                        ['range' => [29, 34], 'energy' => 23, 'ratio' => '2:2:1(4) 2:1:1'],
                        ['range' => [34, null], 'energy' => 23, 'ratio' => '1:3:1(4) 2:2:1(4) 2:1:1'],
                    ],
                ],
                6 => [
                    'm' => [
                        ['range' => [0, 10], 'energy' => 58, 'ratio' => '3:1:1'],
                        ['range' => [10, 16], 'energy' => 53, 'ratio' => '2:1:1'],
                        ['range' => [16, 21], 'energy' => 48, 'ratio' => '2:1:1'],
                        ['range' => [21, 26], 'energy' => 43, 'ratio' => '2:1:1'],
                        ['range' => [26, null], 'energy' => 38, 'ratio' => '2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 15], 'energy' => 58, 'ratio' => '3:1:1'],
                        ['range' => [15, 21], 'energy' => 53, 'ratio' => '2:1:1'],
                        ['range' => [21, 26], 'energy' => 48, 'ratio' => '2:1:1'],
                        ['range' => [26, 31], 'energy' => 43, 'ratio' => '2:1:1'],
                        ['range' => [31, null], 'energy' => 38, 'ratio' => '2:1:1'],
                    ],
                ],
                7 => [
                    'f' => [
                        ['range' => [0, 25], 'energy' => 38, 'ratio' => '2:1:1'],
                        ['range' => [25, null], 'energy' => 33, 'ratio' => '2:1:1'],
                    ],
                    'm' => [
                        ['range' => [0, 20], 'energy' => 38, 'ratio' => '2:1:1'],
                        ['range' => [20, null], 'energy' => 38, 'ratio' => '2:1:1'],
                        // 可能存在错误的数据
                    ],
                ],
            ],
            2 => [
                1 => null,
                2 => null,
                3 => null,
                4 => null,
                5 => [
                    'm' => [
                        ['range' => [0, 24], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [24, 29], 'energy' => 28, 'ratio' => '2:2:1(2) 2:1:1'],
                        ['range' => [29, 34], 'energy' => 25, 'ratio' => '2:2:1(4) 2:1:1'],
                        ['range' => [34, null], 'energy' => 25, 'ratio' => '1:3:1(4) 2:2:1(4) 2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 19], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [19, 24], 'energy' => 28, 'ratio' => '2:2:1(2) 2:1:1'],
                        ['range' => [24, 29], 'energy' => 25, 'ratio' => '2:2:1(4) 2:1:1'],
                        ['range' => [29, null], 'energy' => 25, 'ratio' => '1:3:1(4) 2:2:1(4) 2:1:1'],
                    ],
                ],
                6 => [
                    'm' => [
                        ['range' => [0, 10], 'energy' => 60, 'ratio' => '3:1:1'],
                        ['range' => [10, 16], 'energy' => 55, 'ratio' => '2:1:1'],
                        ['range' => [16, 21], 'energy' => 50, 'ratio' => '2:1:1'],
                        ['range' => [21, 26], 'energy' => 45, 'ratio' => '2:1:1'],
                        ['range' => [26, null], 'energy' => 40, 'ratio' => '2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 15], 'energy' => 60, 'ratio' => '3:1:1'],
                        ['range' => [15, 21], 'energy' => 55, 'ratio' => '2:1:1'],
                        ['range' => [21, 26], 'energy' => 50, 'ratio' => '2:1:1'],
                        ['range' => [26, 31], 'energy' => 45, 'ratio' => '2:1:1'],
                        ['range' => [31, null], 'energy' => 40, 'ratio' => '2:1:1'],
                    ],
                ],
                7 => [
                    'm' => [
                        ['range' => [0, 20], 'energy' => 40, 'ratio' => '2:1:1'],
                        ['range' => [20, null], 'energy' => 35, 'ratio' => '2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 25], 'energy' => 40, 'ratio' => '2:1:1'],
                        ['range' => [25, null], 'energy' => 35, 'ratio' => '2:1:1'],
                    ],
                ],
            ],
            3 => [
                1 => null,
                2 => null,
                3 => null,
                4 => null,
                5 => [
                    'm' => [
                        ['range' => [0, 19], 'energy' => 32, 'ratio' => '3:1:1'],
                        ['range' => [19, 24], 'energy' => 30, 'ratio' => '2:2:1(2) 2:1:1'],
                        ['range' => [24, 29], 'energy' => 27, 'ratio' => '2:2:1(4) 2:1:1'],
                        ['range' => [29, null], 'energy' => 27, 'ratio' => '1:3:1(4) 2:2:1(4) 2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 24], 'energy' => 32, 'ratio' => '3:1:1'],
                        ['range' => [24, 29], 'energy' => 30, 'ratio' => '2:2:1(2) 2:1:1'],
                        ['range' => [29, 34], 'energy' => 27, 'ratio' => '2:2:1(4) 2:1:1'],
                        ['range' => [34, null], 'energy' => 27, 'ratio' => '1:3:1(4) 2:2:1(4) 2:1:1'],
                    ],
                ],
                6 => [
                    'm' => [
                        ['range' => [0, 10], 'energy' => 62, 'ratio' => '3:1:1'],
                        ['range' => [10, 16], 'energy' => 57, 'ratio' => '2:1:1'],
                        ['range' => [16, 21], 'energy' => 52, 'ratio' => '2:1:1'],
                        ['range' => [21, 26], 'energy' => 47, 'ratio' => '2:1:1'],
                        ['range' => [26, null], 'energy' => 42, 'ratio' => '2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 15], 'energy' => 62, 'ratio' => '3:1:1'],
                        ['range' => [15, 21], 'energy' => 57, 'ratio' => '2:1:1'],
                        ['range' => [21, 26], 'energy' => 52, 'ratio' => '2:1:1'],
                        ['range' => [26, 31], 'energy' => 47, 'ratio' => '2:1:1'],
                        ['range' => [31, null], 'energy' => 42, 'ratio' => '2:1:1'],
                    ],
                ],
                7 => [
                    'f' => [
                        ['range' => [0, 25], 'energy' => 42, 'ratio' => '2:1:1'],
                        ['range' => [25, null], 'energy' => 37, 'ratio' => '2:1:1'],
                    ],
                    'm' => [
                        ['range' => [0, 20], 'energy' => 42, 'ratio' => '2:1:1'],
                        ['range' => [20, null], 'energy' => 37, 'ratio' => '2:1:1'],
                    ],
                ],
            ],
        ],
        'bmi' => [
            1 => [
                1 => [
                    'm' => [
                        ['range' => [0, 18], 'energy' => 35, 'ratio' => '2:1:1'],
                        ['range' => [18, 24], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [24, 28], 'energy' => 28, 'ratio' => '2:1:1'],
                        ['range' => [28, null], 'energy' => 25, 'ratio' => '2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 18], 'energy' => 35, 'ratio' => '2:1:1'],
                        ['range' => [18, 24], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [24, 28], 'energy' => 28, 'ratio' => '2:1:1'],
                        ['range' => [28, null], 'energy' => 25, 'ratio' => '2:1:1'],
                    ],
                ],
                2 => [
                    'm' => [
                        ['range' => [24, 28], 'energy' => 22, 'ratio' => '2:2:1(4*) 2:1:1'],
                        ['range' => [0, null], 'energy' => 22, 'ratio' => '1:3:1(4) 2:2:1(4) 2:1:1'],
                    ],
                    'f' => ['range' => [0, null], 'energy' => 22, 'ratio' => '2：1：1'],
                ],
                3 => [
                    'm' => [
                        ['range' => [0, 18], 'energy' => 50, 'ratio' => '3:1:1'],
                        ['range' => [18, 24], 'energy' => 45, 'ratio' => '3:1:1'],
                        ['range' => [24, 28], 'energy' => 40, 'ratio' => '2:1:1'],
                        ['range' => [28, null], 'energy' => 40, 'ratio' => '2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 18], 'energy' => 50, 'ratio' => '3:1:1'],
                        ['range' => [18, 24], 'energy' => 45, 'ratio' => '3:1:1'],
                        ['range' => [24, 28], 'energy' => 40, 'ratio' => '2:1:1'],
                        ['range' => [28, null], 'energy' => 40, 'ratio' => '2:1:1'],
                    ],
                ],
                4 => [
                    'm' => [
                        ['range' => [0, 18], 'energy' => 30, 'ratio' => '3:1:1'],
                        ['range' => [18, 24], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [24, 28], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [28, null], 'energy' => 30, 'ratio' => '2:1:1'],
                    ],
                    'f' => [
                        ['range' => [0, 18], 'energy' => 30, 'ratio' => '3:1:1'],
                        ['range' => [18, 24], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [24, 28], 'energy' => 30, 'ratio' => '2:1:1'],
                        ['range' => [28, null], 'energy' => 30, 'ratio' => '2:1:1'],
                    ],
                ],
                5 => null,
                6 => null,
                7 => null,
            ],
            2 => [
                1 => [
                    ['range' => [0, 18], 'energy' => 35, 'ratio' => '2:1:1'],
                    ['range' => [18, 24], 'energy' => 35, 'ratio' => '2:1:1'],
                    ['range' => [24, 28], 'energy' => 35, 'ratio' => '2:1:1'],
                    ['range' => [28, null], 'energy' => 35, 'ratio' => '2:1:1'],
                ],
                2 => null,
                3 => [
                    ['range' => [0, 18], 'energy' => 50, 'ratio' => '3:1:1'],
                    ['range' => [18, 24], 'energy' => 45, 'ratio' => '3:1:1'],
                    ['range' => [24, 28], 'energy' => 40, 'ratio' => '2:1:1'],
                    ['range' => [28, null], 'energy' => 40, 'ratio' => '2:1:1'],
                ],
                4 => [
                    ['range' => [0, 18], 'energy' => 30, 'ratio' => '3:1:1'],
                    ['range' => [18, 24], 'energy' => 30, 'ratio' => '2:1:1'],
                    ['range' => [24, 28], 'energy' => 30, 'ratio' => '2:1:1'],
                    ['range' => [28, null], 'energy' => 30, 'ratio' => '2:1:1'],
                ],
                5 => null,
                6 => null,
                7 => null,
            ],
            3 => [
                1 => [
                    ['range' => [0, 18], 'energy' => 35, 'ratio' => '2:1:1'],
                    ['range' => [18, 24], 'energy' => 35, 'ratio' => '2:1:1'],
                    ['range' => [24, 28], 'energy' => 35, 'ratio' => '2:1:1'],
                    ['range' => [28, null], 'energy' => 35, 'ratio' => '2:1:1'],
                ],
                2 => null,
                3 => [
                    ['range' => [0, 18], 'energy' => 50, 'ratio' => '3:1:1'],
                    ['range' => [18, 24], 'energy' => 45, 'ratio' => '3:1:1'],
                    ['range' => [24, 28], 'energy' => 40, 'ratio' => '2:1:1'],
                    ['range' => [28, null], 'energy' => 40, 'ratio' => '2:1:1'],
                ],
                4 => [
                    ['range' => [0, 18], 'energy' => 30, 'ratio' => '3:1:1'],
                    ['range' => [18, 24], 'energy' => 30, 'ratio' => '2:1:1'],
                    ['range' => [24, 28], 'energy' => 30, 'ratio' => '2:1:1'],
                    ['range' => [28, null], 'energy' => 30, 'ratio' => '2:1:1'],
                ],
                5 => null,
                6 => null,
                7 => null,
            ],
        ],
    ];

    /**
     * @param mixed ...$offsets
     * @return array|bool|mixed
     */
    protected function getter(...$offsets)
    {
        $final = self::parameters;
        foreach ($offsets as $offset) {
            $final = $final[$offset] ?? false;
        }
        return $final;
    }

    public function calculate_intake(Health $health)
    {
        //计算年龄
        $birthday = new Carbon($health->birthday);
        /** @var int $age */
        $age = $birthday->diffInYears(Carbon::now());

        //计算基础代谢
        /** @var int $metabolism*/
        $metabolism = 13.88 * $health->weight + 4.16 * $health->height - 3.43 * $age + 54.34 - ($health->gender == 'f' ? 112.4 : 0);

        if (!$health->fat) {
            $height = $health->height / 100;
            $bmi = $health->weight / ($height * $height);
            if (!$intakes = $this->getter('bmi', $health->exercise, $health->purpose, $health->gender))
            {
                return false;
            }
            foreach ($intakes as $intake) {
                if ($bmi < $intake['range'][1] && $bmi >= $intake['range'][0]) {
                    break;
                }
            }
        } else {
            if (!$intakes = $this->getter('fat', $health->exercise, $health->purpose, $health->gender))
            {
                return false;
            }
            foreach ($intakes as $intake) {
                if ($health->fat < $intake['range'][1] && $health->fat >= $intake['range'][0]) {
                    break;
                }
            }
        }

        return [
            'metabolism' => $metabolism,
            'intake' => $intake['energy'] ?? null,
            'ratio' => $intake['ratio'] ?? null,
            'bmr_warn' => empty($intake) ? null : ($intake['energy'] * $health->weight) < $metabolism,
        ];
    }
}
