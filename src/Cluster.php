<?php


namespace Waxwink\Clustering;


use Illuminate\Database\Eloquent\Collection;

class Cluster extends Point
{
    protected $total;
    /**
     * @var Collection
     */
    protected $points;

    protected $boundaries;

    /**
     * @return mixed
     */
    public function getBoundaries()
    {
        return $this->boundaries;
    }

    /**
     * @param array $points
     */
    public function setPoints(array $points, $setBountries = true)
    {
        $this->points = $this->preparePoints($points);
        if ($setBountries){
            $this->setBoundaries();
        }

        return $this;
    }

    /**
     * @return Collection $points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Cluster constructor.
     *
     * @param array $points
     */
    public function __construct(array $points = [])
    {
        $this->setPoints($points);
        $this->points->keyBy('id');
    }

    /**
     * Adds a point to the points repository
     *
     * @param Point $point
     */
    public function addPoint(Point $point)
    {
        if ($point->getParentCluster() !=  null){
            $point->getParentCluster()->removePoint($point);
        }

        $this->points->add($point);
        $point->setParentCluster($this);
        return $this;
    }

    /**
     * Removes a point from the points repository
     *
     * @param Point $point
     * @return Cluster
     */
    public function removePoint(Point $point)
    {
        $key = $this->points->search(function($p) use($point) {
            return $p->id == $point->id;
        });

        $this->points->pull($key);
        return $this;
    }

    /**
     * Recalculates the x and y of this cluster
     */
    public function refresh()
    {
        $this->x = $this->points->avg(function($point){
            return $point->x;
        });
        $this->y = $this->points->avg(function($point){
            return $point->y;
        });
    }

    /**
     * Calculate the total number of the points
     *
     * @return int
     */
    public function getTotal()
    {
        return sizeof($this->points);
    }

    /**
     */
    protected function setBoundaries()
    {
        $this->boundaries['minX'] = $this->points->min(function ($point) {
            return $point->x;
        });
        $this->boundaries['maxX'] = $this->points->max(function ($point) {
            return $point->x;
        });
        $this->boundaries['minY'] = $this->points->min(function ($point) {
            return $point->y;
        });
        $this->boundaries['maxY'] = $this->points->max(function ($point) {
            return $point->y;
        });
    }

    public function getLengthX()
    {
        return $this->boundaries['maxX']-$this->boundaries['minX'];
    }

    public function getLengthY()
    {
        return $this->boundaries['maxY']-$this->boundaries['minY'];
    }

    /**
     * @param array $points
     * @return Collection
     * @throws \Exception
     */
    protected function preparePoints(Array $points)
    {
        $collection = new Collection();
        foreach ($points as $point) {

            if (!$point instanceof Point) {
                //TODO check if it is an array with two numbers in it
                $point = new Point($point[0], $point[1]);
            }
            $collection->add($point);
        }
        return $collection;
    }

}
