<?php
/**
 * Created by PhpStorm.
 * User: Mohamadreza
 * Date: 4/8/2019
 * Time: 4:56 PM
 */

namespace Waxwink\Clustering;


use Waxwink\Clustering\Contracts\ClusterMaker;

class Kmeans implements ClusterMaker
{
    protected $main_cluster;
    protected $number;
    protected $iteration;

    /**
     * MakeClusters constructor.
     * @param Cluster $main_cluster
     * @param $number
     * @param $iteration
     */
    public function __construct(Cluster $main_cluster, $number, $iteration)
    {
        $this->main_cluster = $main_cluster;
        $this->number = $number;
        $this->iteration = $iteration;
    }

    /**
     * @return array
     */
    public function make()
    {
        $points = $this->main_cluster->getPoints();
        $clusters = [];

        //initializing
        for ($i=0; $i<$this->number; $i++){
            $clusters[$i] = (new Cluster())->addPoint($points[$i]);
        }


        for($j = 0; $j<$this->iteration; $j++){
            foreach ($points as $point){
                for ($i=0; $i<$this->number; $i++) {
                    $clusters[$i]->refresh();
                    $d[$i] = $this->distance($point, $clusters[$i]);
                }

                $min_key = \array_keys($d , min($d));
                $clusters[$min_key[0]]->addPoint($point);

            }
        }




        return $clusters;
    }

    protected function distance(Point $point1, Point $point2)
    {
        return \bcadd(\abs(\bcsub($point2->x, $point1->x, 10)), \abs(\bcsub($point2->y, $point1->y, 10)), 10);
    }

}
