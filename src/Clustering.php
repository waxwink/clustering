<?php
/**
 * Created by PhpStorm.
 * User: Bertina
 * Date: 2/24/2019
 * Time: 2:50 PM
 */

namespace Waxwink\Clustering;


use Exception;

class Clustering
{
    protected $processes = [];

    const VALUES_NOT_ARRAY = 'The values in the points array should be array';
    const LAT_KEY_REQUIRED = 'The points should have a lat key';
    const LNG_KEY_REQUIRED = 'The points should have a lng key';

    public static function getClusters(Array $points, $radius)
    {
        //prepare points
        $newPoints = self::preparePoints($points);

        //make a master cluster with points
        $cluster = new Cluster($newPoints);

        // and split it
        $maker = new Clusters($cluster, $radius);
        $clusters = $maker->make();

        //prepare the output points
        return self::prepareOutputs($clusters);

    }

    /**
     * @param $point
     * @throws Exception
     */
    protected static function validatePointArray(Array $point)
    {
        if (!is_array($point)) {
            throw new Exception(static::VALUES_NOT_ARRAY);
        }

        if (!\key_exists('lat', $point)) {
            throw new Exception(static::LAT_KEY_REQUIRED);
        }

        if (!\key_exists('lat', $point)) {
            throw new Exception(static::LNG_KEY_REQUIRED);
        }
    }

    /**
     * @param array $points
     * @return array
     * @throws Exception
     */
    protected static function preparePoints(Array $points)
    {
        $newPoints = [];
        foreach ($points as $point) {
            try {
                self::validatePointArray($point);
            } catch (Exception $e) {
                echo "<div style='margin: 10px; padding: 10px; border: red 1px solid; font-weight: bold;' >";
                echo $e->getMessage();
                echo "</div>";
                exit();
            }

            $newPoints[] = new Point($point['lat'], $point['lng']);
        }
        return $newPoints;
    }

    /**
     * @param array $clusters
     * @return array
     */
    protected static function prepareOutputs(array $clusters)
    {
        $output_points = [];
        foreach ($clusters as $values) {
            foreach ($values as $cluster) {
                $cluster->refresh();
                $output_points[] = [
                    'lat' => $cluster->x,
                    'lng' => $cluster->y,
                    'total' => $cluster->getTotal()
                ];
            }
        }
        return $output_points;
    }

}
