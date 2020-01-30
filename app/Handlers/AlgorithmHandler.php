<?php

namespace App\Handlers;

use App\Models\Recipe;
use Carbon\Carbon;
use App\Models\Health;

class AlgorithmHandler
{

    /**
     * @param mixed ...$offsets
     * @return array|bool|mixed
     */
    protected function getter(...$offsets)
    {
        $final = [
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
                            ['range' => [0, 19], 'energy' => 28, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [19, 24], 'energy' => 26, 'ratio' => [['2:2:1', 'ttl' => 2], ['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 29], 'energy' => 23, 'ratio' => [['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                            ['range' => [29, null], 'energy' => 23, 'ratio' => [['1:3:1', 'ttl' => 4], ['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 24], 'energy' => 28, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 29], 'energy' => 26, 'ratio' => [['2:2:1', 'ttl' => 2], ['2:1:1', 'ttl' => null]]],
                            ['range' => [29, 34], 'energy' => 23, 'ratio' => [['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                            ['range' => [34, null], 'energy' => 23, 'ratio' => [['1:3:1', 'ttl' => 4], ['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    6 => [
                        'm' => [
                            ['range' => [0, 10], 'energy' => 58, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [10, 16], 'energy' => 53, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [16, 21], 'energy' => 48, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [21, 26], 'energy' => 43, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [26, null], 'energy' => 38, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 15], 'energy' => 58, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [15, 21], 'energy' => 53, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [21, 26], 'energy' => 48, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [26, 31], 'energy' => 43, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [31, null], 'energy' => 38, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    7 => [
                        'f' => [
                            ['range' => [0, 25], 'energy' => 38, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [25, null], 'energy' => 33, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'm' => [
                            ['range' => [0, 20], 'energy' => 38, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [20, null], 'energy' => 33, 'ratio' => [['2:1:1', 'ttl' => null]]],
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
                            ['range' => [0, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 29], 'energy' => 28, 'ratio' => [['2:2:1', 'ttl' => 2], ['2:1:1', 'ttl' => null]]],
                            ['range' => [29, 34], 'energy' => 25, 'ratio' => [['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                            ['range' => [34, null], 'energy' => 25, 'ratio' => [['1:3:1', 'ttl' => 4], ['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 19], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [19, 24], 'energy' => 28, 'ratio' => [['2:2:1', 'ttl' => 2], ['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 29], 'energy' => 25, 'ratio' => [['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                            ['range' => [29, null], 'energy' => 25, 'ratio' => [['1:3:1', 'ttl' => 4], ['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    6 => [
                        'm' => [
                            ['range' => [0, 10], 'energy' => 60, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [10, 16], 'energy' => 55, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [16, 21], 'energy' => 50, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [21, 26], 'energy' => 45, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [26, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 15], 'energy' => 60, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [15, 21], 'energy' => 55, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [21, 26], 'energy' => 50, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [26, 31], 'energy' => 45, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [31, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    7 => [
                        'm' => [
                            ['range' => [0, 20], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [20, null], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 25], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [25, null], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
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
                            ['range' => [0, 19], 'energy' => 32, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [19, 24], 'energy' => 30, 'ratio' => [['2:2:1', 'ttl' => 2], ['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 29], 'energy' => 27, 'ratio' => [['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                            ['range' => [29, null], 'energy' => 27, 'ratio' => [['1:3:1', 'ttl' => 4], ['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 24], 'energy' => 32, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 29], 'energy' => 30, 'ratio' => [['2:2:1', 'ttl' => 2], ['2:1:1', 'ttl' => null]]],
                            ['range' => [29, 34], 'energy' => 27, 'ratio' => [['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                            ['range' => [34, null], 'energy' => 27, 'ratio' => [['1:3:1', 'ttl' => 4], ['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    6 => [
                        'm' => [
                            ['range' => [0, 10], 'energy' => 62, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [10, 16], 'energy' => 57, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [16, 21], 'energy' => 52, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [21, 26], 'energy' => 47, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [26, null], 'energy' => 42, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 15], 'energy' => 62, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [15, 21], 'energy' => 57, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [21, 26], 'energy' => 52, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [26, 31], 'energy' => 47, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [31, null], 'energy' => 42, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    7 => [
                        'f' => [
                            ['range' => [0, 25], 'energy' => 42, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [25, null], 'energy' => 37, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'm' => [
                            ['range' => [0, 20], 'energy' => 42, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [20, null], 'energy' => 37, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                ],
            ],
            'bmi' => [
                1 => [
                    1 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 28, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 25, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 28, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 25, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    2 => [
                        'm' => [
                            ['range' => [24, 28], 'energy' => 22, 'ratio' => [['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                            ['range' => [0, null], 'energy' => 22, 'ratio' => [['1:3:1', 'ttl' => 4], ['2:2:1', 'ttl' => 4], ['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => ['range' => [0, null], 'energy' => 22, 'ratio' => [['2:1:1', 'ttl' => null]]],
                    ],
                    3 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 50, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 45, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 50, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 45, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    4 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 30, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 30, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    5 => null,
                    6 => null,
                    7 => null,
                ],
                2 => [
                    1 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 28, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 25, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 28, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 25, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    2 => null,
                    3 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 50, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 45, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 50, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 45, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    4 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 30, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 30, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    5 => null,
                    6 => null,
                    7 => null,
                ],
                3 => [
                    1 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 28, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 25, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 35, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 28, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 25, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    2 => null,
                    3 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 50, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 45, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 50, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 45, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 40, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    4 => [
                        'm' => [
                            ['range' => [0, 18], 'energy' => 30, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                        'f' => [
                            ['range' => [0, 18], 'energy' => 30, 'ratio' => [['3:1:1', 'ttl' => null]]],
                            ['range' => [18, 24], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [24, 28], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                            ['range' => [28, null], 'energy' => 30, 'ratio' => [['2:1:1', 'ttl' => null]]],
                        ],
                    ],
                    5 => null,
                    6 => null,
                    7 => null,
                ],
            ],
        ];
        foreach ($offsets as $offset) {
            $final = $final[$offset] ?? false;
        }
        return $final;
    }

    /**
     * @param Health $health
     * @return array|bool
     * @throws \Exception
     */
    public function calculate_intake(Health $health)
    {
        //计算年龄
        $birthday = new Carbon($health->birthday);
        /** @var int $age */
        $age = $birthday->diffInYears(Carbon::now());

        //计算基础代谢
        /** @var int $metabolism*/
        $metabolism = 13.88 * $health->weight + 4.16 * $health->height - 3.43 * $age + 54.34 - ($health->gender == 'f' ? 112.4 : 0);
        if ($age > 30) {
            $metabolism -= ($age - 30) * 0.0002 * $metabolism;
        }

        if ($health->purpose == 2) $health->fat = false;

        if (!$health->fat) {
            $height = $health->height / 100;
            $bmi = $health->weight / ($height * $height);
            $purpose = in_array($health->purpose, [5, 6, 7]) ? [5 => 1, 6 => 3, 7 => 4][$health->purpose] : $health->purpose;
            if (!$intakes = $this->getter('bmi', $health->exercise, $purpose, $health->gender))
            {
                return false;
            }
            foreach ($intakes as $intake) {
                if ($bmi < $intake['range'][1] && $bmi >= $intake['range'][0]) {
                    break;
                }
            }
        } else {
            $purpose = in_array($health->purpose, [1, 3, 4]) ? [1 => 5, 3 => 6, 4 => 7][$health->purpose] : $health->purpose;
            if (!$intakes = $this->getter('fat', $health->exercise, $purpose, $health->gender))
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
            'energy' => $intake['energy'] * $health->weight - ($health->habit - 1) * 200 ?? null,
            'ratio' => $intake['ratio'] ?? null,
            'bmr_warn' => empty($intake) ? null : ($intake['energy'] * $health->weight) < $metabolism,
        ];
    }

    /**
     * @param Health $health
     * @param Recipe $recipe
     * @return \App\Models\Diet
     */
    public function calculate_dist(Health $health, Recipe $recipe)
    {
        $user_id = $health->user->id;

        $diet = new \App\Models\Diet([
            'user_id' => $user_id,
            'recipe_id' => $recipe->id,
        ]);

        $intakes = $health->intake;
        $ratio = count($intakes['ratio']) > 1 ? \Illuminate\Support\Facades\Cache::get('user:' . $user_id . ':intake_lt') : $intakes['ratio'][0][0];
        if (!$ratio) abort(404, '未设置身体数据');
        $intakes = $intakes['energy'];
        $ratio = $this->parse_ratio($ratio);

        foreach (['breakfast', 'lunch', 'dinner'] as $name) {
            $nutrition = array([], [], []); $lb = array();
            foreach (($recipe->$name) as $ingredient) {
                $ingredient_ = \App\Models\Ingredient::find($ingredient['id']);
                $lb[] = $ingredient['min'];
                $nutrition[0][] = $ingredient_->carbohydrate;
                $nutrition[1][] = $ingredient_->protein;
                $nutrition[2][] = $ingredient_->fat;
            }

            $dist = $this->call_outside_calculate($nutrition, $lb, [
                $intakes * $ratio[0] * ($name == 'lunch' ? 0.4 : 0.3),
                $intakes * $ratio[1] * ($name == 'lunch' ? 0.4 : 0.3),
                $intakes * $ratio[2] * ($name == 'lunch' ? 0.4 : 0.3),
            ]);

            $meal_ingredients = array_map(function ($n, $d) {
                return array('id' => $n['id'], 'amount' => (int)$d);
            }, ($recipe->$name), $dist);

            $diet->$name = $meal_ingredients;
        }

        return $diet;
    }

    /**
     * @param $spares
     * @param $lb
     * @param $sum
     * @return mixed
     */
    private function call_outside_calculate($spares, $lb, $sum) {
        $id = \Illuminate\Support\Str::random(6);
        $key = 'gym:swap:' . $id;

        \Illuminate\Support\Facades\Redis::set($key, json_encode([
            'a' => $spares,
            'b' => $sum,
            'lb' => $lb
        ]));

        $return = exec('python3 ' . __DIR__ . '/../../external/solve.py ' . $id);
        if ($return != 0) return false;

        $result = \Illuminate\Support\Facades\Redis::get($key);
        \Illuminate\Support\Facades\Redis::del($key);
        return json_decode($result, true);
    }

    /**
     * @param string $ratio
     * @return array|string
     */
    private function parse_ratio(string $ratio)
    {
        $ratio = explode(':', $ratio);
        $sum = array_sum($ratio);
        $ratio = array_map(function ($item) use ($sum) {
            $item /= $sum;
            return $item;
        }, $ratio);

        return $ratio;
    }
}
