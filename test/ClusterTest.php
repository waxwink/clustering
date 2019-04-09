<?php

namespace Tests\Feature;

use Waxwink\Clustering\Cluster;
use Waxwink\Clustering\Point;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClusterTest extends TestCase
{
    public function testCluster()
    {
        $points = [[1,2],[5,3]];
        $cluster = new Cluster($points);
        $this->assertEquals(4 , $cluster->getLengthX());

        $points = [new Point(-1,5), new Point(-2,4)];
        $cluster = new Cluster($points);
        $this->assertEquals(1 , $cluster->getLengthY());

        $points = [new Point(-1,5)];
        $cluster = new Cluster($points);
        $this->assertEquals(0 , $cluster->getLengthX());
    }

    public function testClusterPoint()
    {
        $points = [[0,0],[4,4]];
        $cluster = new Cluster($points);
        $cluster->refresh();
        $this->assertEquals([2,2] , [$cluster->x, $cluster->y]);


        $points = [[0,0],[4,4], [1,1],[3,7]];
        $cluster = new Cluster($points);
        $cluster->refresh();
        $this->assertEquals([2,3] , [$cluster->x, $cluster->y]);

    }

    public function testRemovePoint()
    {
        $point1 = new Point(1,2);
        $point2 = new Point(0, 3);

        $cluster = new Cluster([$point1, $point2]);
        //\var_dump($cluster->getPoints());
        $cluster->removePoint($point2);
        var_dump($cluster->getPoints()->toArray());
        $this->assertEquals([$point1], $cluster->getPoints()->toArray());

    }

}
