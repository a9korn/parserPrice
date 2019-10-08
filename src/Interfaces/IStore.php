<?php


namespace App\Interfaces;


interface IStore
{
    public function set( array $value);
    public function get(): array ;
}