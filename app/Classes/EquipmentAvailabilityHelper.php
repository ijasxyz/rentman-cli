<?php

namespace App\Classes;

use DateTime;
use Illuminate\Support\Facades\DB;

/**
 * Class EquipmentAvailabilityHelper
 *
 * @package \App\Classes
 */
class EquipmentAvailabilityHelper
{
    /**
     * This function checks if a given quantity is available in the passed time frame
     * @param int $equipment_id Id of the equipment item
     * @param int $quantity How much should be available
     * @param DateTime $start Start of time window
     * @param DateTime $end End of time window
     * @return bool True if available, false otherwise
     */
    public static function isAvailable (int $equipment_id, int $quantity, DateTime $start, DateTime $end): bool
    {
        $start = $start->format('Y-m-d');
        $end = $end->format('Y-m-d');

        $query = "
            SELECT 
                (eq.stock - (
                    SELECT 
                        SUM(quantity)
                    FROM 
                        planning p 
                    WHERE 
                        `equipment` = ${equipment_id} AND (
                        `start` between '${start}' AND '${end}' OR
                        `end` BETWEEN '${start}' AND '${end}')
                )) as available 
            FROM 
                planning p 
            INNER JOIN 
                equipment eq on eq.id = p.equipment 
            WHERE 
                equipment = ${equipment_id}
            GROUP BY eq.id
        ";

        $result = DB::select($query);

        return $result[0]->available >= $quantity;
    }

    /**
     * Calculate all items that are short in the given period
     * @param DateTime $start Start of time window
     * @param DateTime $end End of time window
     * @return array Key/valyue array with as indices the equipment id's and as values the shortages
     */
    public static function getShortages (DateTime $start, DateTime $end): array
    {
        $start = $start->format('Y-m-d');
        $end = $end->format('Y-m-d');

        $query = "
            SELECT
                eq.id,
                (eq.stock - SUM(quantity)) as shortage
            FROM
                planning p
            INNER JOIN equipment eq on
                eq.id = p.equipment
            WHERE
                p.equipment = eq.id AND ((`start` between '${start}' AND '${end}')
                OR (`end` BETWEEN '${start}' AND '${end}'))
            GROUP BY
                eq.id
            HAVING
	            shortage <= 0
        ";

        $result = DB::select($query);

        return array_map(function($r){
            return [$r->id, $r->shortage];
        }, $result);
    }
}
