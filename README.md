## Clustering
This package focuses on clustering map markers in an efficient way by dividing the map in defined square spaces and assign each point to its own space.

### instruction

#### Getting Started
Require the package in your project with the following command with composer:

```
$ composer require waxwink/clustering 
```
#### Usage
The usage is pretty straight forward:

```php
require __DIR__.'/vendor/autoload.php';

use Waxwink\Clustering\Clustering;

$points = [
	[
		'lat' => 35.821006,
		'lng' => 51.427388
	],
	[
		'lat' => 35.716912,
		'lng' => 51.439202
	],
	[
		'lat' => 35.67787,
		'lng' => 51.358735
	],
	[
		'lat' => 35.743621,
		'lng' => 51.530846
	],
];
```

For dividing the space into equal areas and cluster the points by the spaces you can use the following format:
```php
$output = Clustering::getClusters($points, 0.1);
//The second parameter is the length of the square spaces by which the points are going to be clusterd.
//output :
/*
array (size=3)
  0 => 
    array (size=3)
      'lat' => float 35.821006
      'lng' => float 51.427388
      'total' => int 1
  1 => 
    array (size=3)
      'lat' => float 35.697391
      'lng' => float 51.3989685
      'total' => int 2
  2 => 
    array (size=3)
      'lat' => float 35.743621
      'lng' => float 51.530846
      'total' => int 1
*/
```
Another option for clustering is the K-means algorithm in which the number of requested clusters is required. This approach is slower in performance but gives accurate clusters.
```php
$output = Clustering::getClusters($points, 2, Clustering::K_MEANS_ALGORITHM, 5);
//the second parameter is the number of clusters
//the third parameter is the algorithm
//the forth parameter is the number of iterations used in the K-means algorithm which is 5 by default


//output:
array (size=2)
  0 => 
    array (size=3)
      'lat' => float 35.821006
      'lng' => float 51.427388
      'total' => int 1
  1 => 
    array (size=3)
      'lat' => float 35.712801
      'lng' => float 51.442927666667
      'total' => int 3
```
