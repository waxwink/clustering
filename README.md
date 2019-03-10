
![image_2019-03-10_09-19-21](https://user-images.githubusercontent.com/34881789/54081192-d5b08380-4315-11e9-8f78-bf913e8de23c.png)

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


$output = Clustering::getClusters($points, 0.15);
//output :
/*
array (size=2)
  0 => 
    array (size=3)
      'lat' => float 35.738596
      'lng' => float 51.408441666667
      'total' => int 3
  1 => 
    array (size=3)
      'lat' => float 35.743621
      'lng' => float 51.530846
      'total' => int 1
 */
 
 
 $output = Clustering::getClusters($points, 0.2);
//output :
/*
array (size=1)
  0 => 
    array (size=3)
      'lat' => float 35.73985225
      'lng' => float 51.43904275
      'total' => int 4
 */
`
