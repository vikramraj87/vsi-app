<?php namespace Kivi\Repositories;


interface CategoryRepository
{
    public function find($id);

    public function allWithRelations();

    public function create($input);
} 