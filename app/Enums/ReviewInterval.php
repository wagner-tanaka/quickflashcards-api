<?php

namespace App\Enums;

enum ReviewInterval: int
{
    case ReviewToday = 0;
    case ReviewInOneDay = 1;
    case ReviewInThreeDays = 2;
    case ReviewInSevenDays = 3;
    case ReviewInTwoWeeks = 4;
    case ReviewInOneMonth = 5;
    case ReviewInThreeMonths = 6;
    case ReviewInSixMonths = 7;
    case ReviewInactive = 8;

    public function getInterval(): int
    {
        return match($this) {
            ReviewInterval::ReviewToday => 0,
            ReviewInterval::ReviewInOneDay => 1,
            ReviewInterval::ReviewInThreeDays => 3,
            ReviewInterval::ReviewInSevenDays => 7,
            ReviewInterval::ReviewInTwoWeeks => 14,
            ReviewInterval::ReviewInOneMonth => 30,
            ReviewInterval::ReviewInThreeMonths => 90,
            ReviewInterval::ReviewInSixMonths => 180,
            ReviewInterval::ReviewInactive => 9999, // A large number to simulate "forever"
        };
    }
}
