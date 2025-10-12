<?php

namespace App\Repositories;

interface BaseRepository
{
    public function create(array $attributes);
    public function find($id);
    public function update($id, array $attributes);
    public function delete($id);
}