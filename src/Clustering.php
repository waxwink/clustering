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

    const SQUARING_ALGORITHM = 0;
    const K_MEANS_ALGORITHM = 1;

    protected static $algorithm = self::K_MEANS_ALGORITHM;

    const VALUES_NOT_ARRAY = 'The values in the points array should be array';
    const LAT_KEY_REQUIRED = 'The points should have a lat key';
    const LNG_KEY_REQUIRED = 'The points should have a lng key';

    public static function getClusters(Array $points, $param, $algorithm = self::SQUARING_ALGORITHM, $iteration = 5)
    {
        self::$algorithm = $algorithm;
        //prepare points
        $newPoints = self::preparePoints($points);

        //make a master cluster with points
        $cluster = new Cluster($newPoints);

        if(self::$algorithm == self::SQUARING_ALGORITHM){
            $radius = $param;
            // split it
            $maker = new Clusters($cluster, $radius);
            $clusters = $maker->make();
        }

        if(self::$algorithm == self::K_MEANS_ALGORITHM){
            $n = $param;
            // send it to k-means clustering class
            $maker = new Kmeans($cluster, $n, $iteration );
            $clusters = $maker->make();
        }


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
        foreach ($clusters as $cluster) {
            $cluster->refresh();
            $output_points[] = [
                'lat' => $cluster->x,
                'lng' => $cluster->y,
                'total' => $cluster->getTotal()
            ];

        }
        return $output_points;
    }

}
