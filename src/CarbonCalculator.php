<?php
// src/CarbonCalculator.php

class CarbonCalculator {
    // Emission factors (kg CO2e per unit)
    // These are approximate values for demonstration
    private const FACTORS = [
        'transport_car' => 0.19, // kg per km (average petrol car)
        'transport_bus' => 0.09, // kg per km
        'transport_bike' => 0.0, // kg per km
        'electricity'   => 0.475, // kg per kWh (approx grid average)
        'food_meat'     => 27.0, // kg per kg (beef)
        'food_veg'      => 2.0,  // kg per kg
        'waste'         => 0.5,  // kg per kg (general waste)
    ];

    public static function calculate($type, $value) {
        if (!isset(self::FACTORS[$type])) {
            return 0; // Or throw exception
        }
        return self::FACTORS[$type] * $value;
    }

    public static function getFactors() {
        return self::FACTORS;
    }
}
?>
