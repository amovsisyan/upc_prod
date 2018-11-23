<?php


namespace App\Transformers;


abstract class Transformer
{
	public function transformCollection($items, $method = 'transform')
	{
		return $items->map([$this, $method]);
	}
	
	public abstract function transform($item);
}