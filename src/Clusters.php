<?php

namespace Waxwink\Clustering;


use Waxwink\Clustering\Contracts\ClusterMaker;

class Clusters implements ClusterMaker
{
    protected $main_cluster;
    protected $radius;

    /**
     * MakeClusters constructor.
     * @param Cluster $main_cluster
     * @param $radius
     */
    public function __construct(Cluster $main_cluster, $radius)
    {
        $this->main_cluster = $main_cluster;
        $this->radius = $radius;
    }

    public function make()
    {
        $points = $this->main_cluster->getPoints();

        $boundaries = $this->main_cluster->getBoundaries();

        $clusters = [];

        $points->each(function($point) use($boundaries, &$clusters){
            $i = floor(bcdiv($point->x - $boundaries['minX'], $this->radius, 1));
            $j = floor(bcdiv($point->y - $boundaries['minY'], $this->radius, 1));
            if (! isset($clusters[$i][$j])){
                $clusters[$i][$j] = new Cluster([],false);
            }

            $clusters[$i][$j]->addPoint($point);
        });


        $new_clusters = [];
        foreach ($clusters as $values) {
            foreach ($values as $cluster) {
                $new_clusters[] = $cluster;
            }
        }



        return $new_clusters;
    }

}
