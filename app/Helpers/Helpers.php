<?php

if (!function_exists('getCurrentAcademicYear')) {
    function getCurrentAcademicYear(): string
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Si on est entre septembre et décembre, l'année scolaire est currentYear-nextYear
        if ($currentMonth >= 9) {
            return $currentYear . '-' . ($currentYear + 1);
        }

        // Si on est entre janvier et août, l'année scolaire est previousYear-currentYear
        return ($currentYear - 1) . '-' . $currentYear;
    }
}
