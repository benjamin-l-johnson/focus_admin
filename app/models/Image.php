<?php


class Image extends Eloquent {
 
  protected $fillable = array('path','name','folder');
  public function imageable()
  {
    return $this->morphTo();
  }
 
}