<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DayInNumberExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('day_of_year', [$this, 'getDayOfYear']),
        ];
    }

    /**
     * Calcula el número del día del año a partir de una fecha en formato d/m/Y.
     *
     * @param \DateTime|string $date Fecha en formato d/m/Y o un objeto \DateTime
     * @return int Número del día del año (1-366)
     */
    public function getDayOfYear($date): int
    {
        if ($date instanceof \DateTime) {
            // Si ya es un objeto DateTime, usa el formato
            $date = $date->format('d/m/Y');
        } elseif (!is_string($date)) {
            // Manejo de error si no es un string o un objeto DateTime
            return 0;
        }

        // Convierte la cadena de fecha en un objeto DateTime
        $dateTime = \DateTime::createFromFormat('d/m/Y', $date);
        
        if ($dateTime === false) {
            // Manejo de error si la fecha es inválida
            return 0; // O cualquier valor que consideres adecuado para indicar error
        }

        // Devuelve el número del día del año (1-366)
        return $dateTime->format('z') + 1;
    }
}
