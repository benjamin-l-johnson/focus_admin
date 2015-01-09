<?php


class Image extends Eloquent {
 
  protected $fillable = array('path');
  public function imageable()
  {
    return $this->morphTo();
  }
 
}